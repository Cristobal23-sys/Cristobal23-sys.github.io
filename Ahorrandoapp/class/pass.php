<?php
session_start();
include "../class/auth.php";

$user = $_POST['user'];
$pass = $_POST['pass'];

$Auth = new Auth($user, $pass);

if ($Auth->logear($user, $pass)) {
    $_SESSION['user'] = $user;
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../views/index.php';

// Redirigir al usuario a la página anterior
header("Location: " . $referrer);
exit();
    
} else {
    session_start();
        $_SESSION['error_message'] = 'Email o contraseña incorrectos.';
        header("Location: ../views/index.php");
        exit();
    
}
?>