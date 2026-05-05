<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuari = $_POST['usuari'];
    $contrasenya = $_POST['contrasenya'];

    $stmt = $pdo->prepare("SELECT * FROM Usuaris WHERE usuari = ?");
    $stmt->execute([$usuari]);
    $user = $stmt->fetch();

    if ($user && password_verify($contrasenya, $user['contrasenya'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['usuari'] = $user['usuari'];
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['idAlumne'] = $user['idAlumne'];

        if ($user['rol'] === 'professorat') {
            header('Location: professorat/dashboard.php');
        } else {
            header('Location: alumnat/dashboard.php');
        }
        exit;
    } else {
        $error = 'Usuari o contrasenya incorrectes';
    }
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Institut Montsià - Inici de sessió</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d8d6d6ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: #ffffffff;
            padding: 30px;
            border-radius: 8px;
            width: 300px;
        }

        .login-box img {
            display: block;
            margin: 0 auto 10px auto;
        }

        input {
            width: 80%;
            padding: 8px;
            margin: 6px 0 14px 0;
            border: 1px solid #4a90d9;
            border-radius: 4px;
        }

        button {
            width: 20%;
            padding: 10px;
            background: #4a90d9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover{
            background-color: #357abd;
            color: white;
        }

        .error {
            background-color: #da796fb7;
            color: red;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0 16px 0;
            text-align: center;
            font-size: 14px;
        }
     </style>
</head>
<body>
    <div class="login-box">
        <img src="img/logo.png" alt="logo_login" width="100">
        <h3>Inicia sessió</h3>
    
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Usuari:</label>
            <input type="text" name="usuari" required>
            <label>Contrasenya:</label>
            <input type="password" name="contrasenya" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
