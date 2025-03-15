<?php
include_once '../config/database.php';
include_once '../models/User.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (isset($_POST['register'])) {
    $user->register($_POST['username'], $_POST['email'], $_POST['password']);
    exit();
}

if (isset($_POST['login'])) {
    $user_id = $user->login($_POST['email'], $_POST['password']);
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        header("Location: ../views/movies.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href = '../views/login.php';</script>";
    }
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
?>


