<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';
$usuario = $_SESSION['usuario'] ?? null;
$hilos = obtenerHilos($conexion);
// Procesar elección de cookies
if (isset($_POST['aceptar_cookies'])) {
    setcookie("deepwebb_visitado", "true", time() + (7 * 24 * 60 * 60), "/"); // válida 7 días
    $_COOKIE['deepwebb_visitado'] = "true"; // Para efecto inmediato
}

$mostrarAvisoCookies = !isset($_COOKIE['deepwebb_visitado']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>DeepWeB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">

</head>

<body class="bg-light text-dark">
    <div class="container mt-4">
        <header class="text-center mb-4">
            <h1 class="d-flex align-items-center justify-content-center gap-2 text-primary">
                <img src="img/DeepWeBlogotransparente.png" alt="Logo DeepWebb" class="img-fluid" style="height: 185px;">
                DeepWeB
            </h1>


            <p>Tu espacio para compartir soluciones, guías y análisis sobre los juegos que realmente importan.</p>
            <nav>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Inicio</a>
                <a href="categorias.php" class="btn btn-outline-primary btn-sm">Categorías</a>
                <?php if ($usuario): ?>
                    <span class="ms-2">👤 <?= $usuario ?></span>
                    <a href="create_topic.php" class="btn btn-outline-primary btn-sm ms-2">Nuevo tema</a>
                    <a href="favoritos.php" class="btn btn-outline-warning btn-sm ms-2">Favoritos</a>
                    <a href="logout.php" class="btn btn-danger btn-sm ms-2">Cerrar sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-success btn-sm ms-2">Iniciar sesión</a>
                    <a href="register.php" class="btn btn-warning btn-sm ms-2">Registrarse</a>
                <?php endif; ?>
            </nav>
            <div class="form-check form-switch text-end">
                <input class="form-check-input" type="checkbox" id="modoGamerToggle">
                <label class="form-check-label" for="modoGamerToggle"><i class="bi bi-moon-fill"></i> Modo
                    oscuro</label>
            </div>

        </header>
        <div class="row">
            <!-- Temas recientes -->
            <div class="col-md-8">
                <h2>Temas recientes</h2>
                <div class="list-group">
                    <?php while ($row = $hilos->fetch_assoc()): ?>
                        <a href="view_topic.php?id=<?= $row['id'] ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <strong><?= limpiar($row['titulo']) ?></strong>
                                <small><?= $row['fecha'] ?></small>
                            </div>
                            <small class="text-muted">Por <?= $row['usuario'] ?> en <?= $row['categoria'] ?></small>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Anuncio -->
            <div class="col-md-4 d-none d-md-block">
                <img src="img/anunciodeepweb.png" alt="Bienvenida foro" class="img-fluid rounded shadow mt-4"
                    style="max-height: 700px; object-fit: contain;">
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scriptt.js"></script>
        <?php if ($mostrarAvisoCookies): ?>
            <form method="POST"
                class="cookie-banner position-fixed bottom-0 start-0 end-0 p-3 bg-dark text-white text-center z-3">
                <p class="mb-2">🍪 Este sitio usa cookies para mejorar tu experiencia. ¿Deseas aceptarlas?</p>
                <button name="aceptar_cookies" class="btn btn-success btn-sm me-2">Aceptar</button>
                <a href="#" class="btn btn-outline-light btn-sm"
                    onclick="this.parentElement.style.display='none'">Rechazar</a>
            </form>
        <?php endif; ?>
</body>

</html>
