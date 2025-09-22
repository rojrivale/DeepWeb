<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$accion = $_POST['accion'] ?? null;
$hilo_id = isset($_POST['hilo_id']) ? (int) $_POST['hilo_id'] : 0;

if (!$usuario_id || !$hilo_id) {
    header("Location: index.php");
    exit;
}

if ($accion === 'agregar') {
    agregarFavorito($conexion, $usuario_id, $hilo_id);
    $mensaje = "✅ Hilo guardado en tus favoritos.";
} elseif ($accion === 'quitar') {
    eliminarFavorito($conexion, $usuario_id, $hilo_id);
    $mensaje = "🗑️ Hilo eliminado de tus favoritos.";
} else {
    $mensaje = "⚠️ Acción no válida.";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Favorito actualizado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5 text-center">
        <h4><?= $mensaje ?></h4>
        <a href="view_topic.php?id=<?= $hilo_id ?>" class="btn btn-primary mt-3">🔙 Volver al hilo</a>
        <a href="favoritos.php" class="btn btn-warning mt-3">⭐ Ver mis favoritos</a>
    </div>
</body>

</html>