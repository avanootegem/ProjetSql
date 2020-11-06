<?php 
$user_id = $_GET['id'];
$token = $_GET['token'];

require_once('assets/php/db.php');
$req = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$req->execute([$user_id]); 
$user=$req->fetch();
session_start();

if($user && $user->confirmation_token == $token) {
    $pdo->prepare("UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE user_id = ?")->execute([$user_id]);
    $_SESSION['auth'] = $user;
    header('Location: account.php');
} else {
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location : login.php');
}

