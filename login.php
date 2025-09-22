<?php
session_start();
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = limpiar($_POST['usuario']);
    $pass = $_POST['password'];

    $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);

    if ($stmt->fetch() && password_verify($pass, $hash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2>Iniciar sesión</h2>
        <?php if (!empty($error))
            echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Usuario</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Entrar</button>
            <a href="register.php" class="btn btn-link">¿No tienes cuenta?</a>
        </form>
    </div>
</body>

</html>