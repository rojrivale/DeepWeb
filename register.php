<?php
require_once 'includes/conedb.php';
require_once 'includes/funciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = limpiar($_POST['usuario']);
    $email = limpiar($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $email, $pass);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "El usuario o email ya está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrarse - DeepWebb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h2>Crear cuenta</h2>
        <?php if (!empty($error))
            echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Usuario</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <a href="login.php" class="btn btn-link">¿Ya tienes cuenta?</a>
        </form>
    </div>
</body>

</html>