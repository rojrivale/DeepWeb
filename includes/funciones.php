<?php
// Sanitiza cualquier entrada del usuario
function limpiar($valor) {
    return htmlspecialchars(trim((string)$valor), ENT_QUOTES, 'UTF-8');
}

// Obtener todas las categorías ordenadas alfabéticamente
function obtenerCategorias($conexion) {
    return $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
}

// Obtener todos los hilos recientes con su usuario y categoría
function obtenerHilos($conexion) {
    $sql = "SELECT hilos.*, usuarios.usuario, categorias.nombre AS categoria
            FROM hilos
            JOIN usuarios ON usuarios.id = hilos.usuario_id
            JOIN categorias ON categorias.id = hilos.categoria_id
            ORDER BY hilos.fecha DESC";
    return $conexion->query($sql);
}

// Obtener un hilo específico por ID, incluyendo autor y categoría
function obtenerHiloPorId($conexion, $id) {
    $stmt = $conexion->prepare("SELECT hilos.*, usuarios.usuario, categorias.nombre AS categoria
                                 FROM hilos
                                 JOIN usuarios ON usuarios.id = hilos.usuario_id
                                 JOIN categorias ON categorias.id = hilos.categoria_id
                                 WHERE hilos.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

// Obtener respuestas asociadas a un hilo, incluyendo el nombre del autor
function obtenerRespuestas($conexion, $hilo_id) {
    $stmt = $conexion->prepare("SELECT respuestas.*, usuarios.usuario
                                FROM respuestas
                                JOIN usuarios ON usuarios.id = respuestas.usuario_id
                                WHERE respuestas.hilo_id = ?
                                ORDER BY respuestas.fecha ASC");
    $stmt->bind_param("i", $hilo_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Verifica si un hilo está marcado como favorito por un usuario
function esFavorito($conexion, $usuario_id, $hilo_id) {
    $stmt = $conexion->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND hilo_id = ?");
    $stmt->bind_param("ii", $usuario_id, $hilo_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

// Agrega un hilo a los favoritos de un usuario
function agregarFavorito($conexion, $usuario_id, $hilo_id) {
    if (!esFavorito($conexion, $usuario_id, $hilo_id)) {
        $stmt = $conexion->prepare("INSERT INTO favoritos (usuario_id, hilo_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $usuario_id, $hilo_id);
        $stmt->execute();
    }
}

// Elimina un hilo de los favoritos de un usuario
function eliminarFavorito($conexion, $usuario_id, $hilo_id) {
    $stmt = $conexion->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND hilo_id = ?");
    $stmt->bind_param("ii", $usuario_id, $hilo_id);
    $stmt->execute();
}



?>