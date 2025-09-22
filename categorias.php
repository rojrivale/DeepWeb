<?php
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

$categorias = obtenerCategorias($conexion);
$categoria_seleccionada = isset($_GET['filtro_categoria']) ? (int) $_GET['filtro_categoria'] : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Categorías - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2>Categorías con temas recientes</h2>

        <!-- Filtro de categorías -->
        <form method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <select name="filtro_categoria" class="form-select">
                        <option value="0">🔎 Ver todas las categorías</option>
                        <?php
                        // Volvemos a consultar categorías para el filtro
                        $catsFiltro = obtenerCategorias($conexion);
                        while ($filtro = $catsFiltro->fetch_assoc()):
                            ?>
                            <option value="<?= $filtro['id'] ?>" <?= $categoria_seleccionada === (int) $filtro['id'] ? 'selected' : '' ?>>
                                <?= limpiar($filtro['nombre']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning w-100">Filtrar</button>
                </div>
                <div class="col-md-3">
                    <a href="categorias.php" class="btn btn-secondary w-100">Reiniciar</a>
                </div>
            </div>
        </form>

        <?php
        // Reutilizamos el cursor de categorías pero solo si no se filtró
        $categorias->data_seek(0); // Reinicia el puntero
        while ($cat = $categorias->fetch_assoc()):
            if ($categoria_seleccionada && $categoria_seleccionada !== (int) $cat['id'])
                continue;
            ?>
            <div class="mb-4 p-3 border border-secondary rounded">
                <h4 class="text-info"><?= limpiar($cat['nombre']) ?></h4>

                <?php
                $stmt = $conexion->prepare("
                SELECT hilos.id, hilos.titulo, hilos.fecha, usuarios.usuario
                FROM hilos
                JOIN usuarios ON usuarios.id = hilos.usuario_id
                WHERE hilos.categoria_id = ?
                ORDER BY hilos.fecha DESC
                LIMIT 3
            ");
                $stmt->bind_param("i", $cat['id']);
                $stmt->execute();
                $temas = $stmt->get_result();
                ?>

                <?php if ($temas->num_rows > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php while ($hilo = $temas->fetch_assoc()): ?>
                            <li class="list-group-item bg-dark text-white">
                                <a href="view_topic.php?id=<?= $hilo['id'] ?>" class="text-info text-decoration-none">
                                    <div class="d-flex justify-content-between">
                                        <strong><?= limpiar($hilo['titulo']) ?></strong>
                                    </div>
                                    <small>Publicado por <?= limpiar($hilo['usuario']) ?> | <?= $hilo['fecha'] ?></small>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No hay temas en esta categoría aún.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <div class="mt-4">
            <a href="index.php" class="btn btn-primary">🏠 Volver al inicio</a>
        </div>
</body>

</html>