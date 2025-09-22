<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$usuario = $_SESSION['usuario'] ?? null;

if (!$usuario_id) {
    header("Location: login.php");
    exit;
}

$stmt = $conexion->prepare("
    SELECT hilos.id, hilos.titulo, hilos.fecha, categorias.nombre AS categoria
    FROM favoritos
    JOIN hilos ON hilos.id = favoritos.hilo_id
    JOIN categorias ON categorias.id = hilos.categoria_id
    WHERE favoritos.usuario_id = ?
    ORDER BY favoritos.fecha_guardado DESC
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$favoritos = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Favoritos - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2>Mis temas guardados</h2>
        <?php if ($favoritos->num_rows === 0): ?>
            <div class="alert alert-info">No has guardado ningún tema aún.</div>
        <?php else: ?>
            <div class="list-group">
                <?php while ($f = $favoritos->fetch_assoc()): ?>
                    <a href="view_topic.php?id=<?= $f['id'] ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <strong><?= limpiar($f['titulo']) ?></strong>
                            <small><?= $f['fecha'] ?></small>
                        </div>
                        <small class="text-muted">Categoría: <?= limpiar($f['categoria']) ?></small>
                    </a>
                    <!-- Botón debajo del tema para ir directamente -->
                    <div class="mt-2 mb-4">
                        <a href="view_topic.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-info">🔙 Volver al hilo</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <!-- Botón al final para volver al inicio -->
        <div class="mt-4">
            <a href="index.php" class="btn btn-primary">🏠 Volver al inicio</a>
        </div>
    </div>
</body>

</html>