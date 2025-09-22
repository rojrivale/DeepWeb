<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

// Solo usuarios logueados pueden acceder
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$categorias = obtenerCategorias($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = limpiar($_POST['titulo']);
    $contenido = limpiar($_POST['contenido']);
    $categoria = (int) $_POST['categoria'];

    if (!empty($titulo) && !empty($contenido) && $categoria > 0) {
        $stmt = $conexion->prepare("INSERT INTO hilos (titulo, contenido, categoria_id, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $titulo, $contenido, $categoria, $usuario_id);
        $stmt->execute();

        // Redirige al inicio para ver el hilo publicado
        header("Location: index.php");
        exit;
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo tema - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2>Crear nuevo tema</h2>
        <?php if (!empty($error))
            echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contenido">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"><?= limpiar($cat['nombre']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>