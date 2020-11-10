<?php
require_once("assets/php/fonctions.php");
require_once("assets/php/db.php");
session_start();
reconnect_cookie();

if(isset($_SESSION['auth'])) {
    header('Location: account.php');
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $req = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email= :username AND confirmed_at IS NOT NULL");
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if (password_verify($_POST['password'], $user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté";
        if($_POST['remember']) {
            $remember_token = str_random(250);
            $req = $pdo->prepare("UPDATE users SET remember_token = ? WHERE user_id = ?");
            $req->execute([$remember_token, $user->user_id]);
            setcookie("remember", $user->user_id."//".$remember_token. sha1($user->user_id."ratonlaveurs"), time() + 60 * 60 * 24 * 7);
        }
        header('Location: account.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrect";
    }
}
?>


<?php
$titre = "login";
require_once("assets/php/header.php"); ?>

<h1>Se connecter</h1>

<form action="" method="post">

    <div class="form-group">
        <label for="">Pseudo</label> <br>
        <input type="text" name="username" />
    </div>

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">Mot de passe oublié</a> </label> <br>
        <input type="password" name="password" id="" />
    </div>

    <div class="form-group check">
        <label>
            <input type="checkbox" name="remember" value="1" id="check"/>
            Se souvenir de moi
        </label>
    </div>

    <button type="submit" class="form-group">Se connecter</button>

</form>


<?php require_once("assets/php/footer.php") ?>