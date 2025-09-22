<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

$id = $_GET['id'] ?? 0;
$usuario = $_SESSION['usuario'] ?? null;
$usuario_id = $_SESSION['usuario_id'] ?? null;

// Cargar hilo
$stmt = $conexion->prepare("SELECT hilos.*, usuarios.usuario, categorias.nombre AS categoria FROM hilos JOIN usuarios ON usuarios.id = hilos.usuario_id JOIN categorias ON categorias.id = hilos.categoria_id WHERE hilos.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$hilo = $result->fetch_assoc();
$es_favorito = esFavorito($conexion, $usuario_id, $id);




// Eliminar hilo
if (isset($_POST['eliminar_hilo']) && $usuario_id == $hilo['usuario_id']) {
    $stmt = $conexion->prepare("DELETE FROM hilos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Eliminar respuesta
if (isset($_POST['eliminar_respuesta']) && isset($_POST['respuesta_id'])) {
    $respuesta_id = intval($_POST['respuesta_id']);
    
    // Verificamos que la respuesta le pertenezca al usuario logueado
    $stmt = $conexion->prepare("SELECT * FROM respuestas WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $respuesta_id, $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $stmt = $conexion->prepare("DELETE FROM respuestas WHERE id = ?");
        $stmt->bind_param("i", $respuesta_id);
        $stmt->execute();
    }
    header("Location: view_topic.php?id=$id");
    exit;
}
// Insertar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuario_id && isset($_POST['contenido'])) {
    $contenido = limpiar($_POST['contenido']);
    $stmt = $conexion->prepare("INSERT INTO respuestas (hilo_id, usuario_id, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id, $usuario_id, $contenido);
    $stmt->execute();
    header("Location: view_topic.php?id=$id");
    exit;
}





// Obtener respuestas
$respuestas = $conexion->query("SELECT respuestas.*, usuarios.usuario FROM respuestas JOIN usuarios ON usuarios.id = respuestas.usuario_id WHERE hilo_id = $id ORDER BY fecha ASC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= limpiar($hilo['titulo']) ?> - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2><?= limpiar($hilo['titulo']) ?></h2>
        <p><?= nl2br(limpiar($hilo['contenido'])) ?></p>
        <p class="text-muted">Publicado por <?= $hilo['usuario'] ?> en <?= $hilo['categoria'] ?> | <?= $hilo['fecha'] ?>
        </p>

        <hr>
        <h4>Respuestas</h4>
        <?php while ($r = $respuestas->fetch_assoc()): ?>
            <div class="border p-2 mb-2">
                <p><strong><?= $r['usuario'] ?>:</strong> <?= nl2br(limpiar($r['contenido'])) ?></p>
                <small class="text-muted"><?= $r['fecha'] ?></small>
            </div>
            <?php if ($r['usuario'] == $usuario): ?>
    <form method="POST" class="mt-1" onsubmit="return confirm('¿Eliminar esta respuesta?');">
        <input type="hidden" name="respuesta_id" value="<?= $r['id'] ?>">
        <button type="submit" name="eliminar_respuesta" class="btn btn-sm btn-outline-danger">Eliminar</button>
    </form>
<?php endif; ?>

        <?php endwhile; ?>

        <?php if ($usuario): ?>
            <hr>
            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label>Responder</label>
                    <textarea name="contenido" class="form-control" required></textarea>
                </div>
                <button class="btn btn-success mb-3 ">Publicar respuesta</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Inicia sesión</a> para responder.</p>
        <?php endif; ?>


        <?php if ($usuario): ?>
            <?php $es_favorito = esFavorito($conexion, $usuario_id, $id); ?>
            <form method="POST" action="boton_fav.php" class="mb-3">
                <input type="hidden" name="hilo_id" value="<?= $id ?>">
                <?php if ($es_favorito): ?>
                    <button type="submit" name="accion" value="quitar" class="btn btn-warning mb-3">⭐ Quitar de
                        favoritos</button>
                <?php else: ?>
                    <button type="submit" name="accion" value="agregar" class="btn btn-outline-warning mb-3 ">⭐ Guardar en
                        favoritos</button>
                <?php endif; ?>
                <div class="mb-4">
                <a href="index.php" class="btn btn-primary">🏠 Volver al inicio</a>
                </div>
            </form>
            
            <?php if ($usuario_id == $hilo['usuario_id']): ?>
    <form method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este hilo? Esta acción no se puede deshacer.');">
        <button type="submit" name="eliminar_hilo" class="btn btn-danger mb-3">🗑️ Eliminar hilo</button>
    </form>
<?php endif; ?>

        <?php endif; ?>



    </div>
</body>

</html>