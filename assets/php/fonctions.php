<?php

function debug($variable) {
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($lenght) {
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);
}

function logged_only() {
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
    }
}

function reconnect_cookie() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
        require_once('db.php');
        if(!isset($pdo)) {
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode("//", $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $req->execute([$user_id]);
        $user = $req->fetch();
        if ($user) {
            $expected = $user_id . "//" . $user->remember_token . sha1($user_id . "ratonlaveurs");
            if ($expected == $remember_token) {
                $_SESSION['auth'] = $user_id;
                setcookie('remember', $remember_token, time() * 60 * 60 * 24 * 7);
                header("Location: account.php");
            } else {
                setcookie('remember', NULL, -1);
            }
        } else {
            setcookie('remember', NULL, -1);
        }
    }
}
