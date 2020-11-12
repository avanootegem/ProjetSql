<?php
require_once("assets/php/db.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$req = $pdo->prepare("DELETE FROM movies_idea WHERE movie_id = ?");
$req->execute([$_POST['id']]);

$_SESSION['flash']['success'] = "Votre histoire a bien été supprimé";
header("Location: my_idea.php");
exit();