<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['succes'] = "Vous êtes maintenant déconnecter";
header("Location: login.php"); 