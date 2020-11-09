<?php
require_once("assets/php/fonctions.php");
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    require_once("assets/php/db.php");
    session_start();
    $req = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email= :username AND confirmed_at IS NOT NULL");
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if(password_verify($_POST['password'], $user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté";
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
        <input type="text" name="username">
    </div>

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">Mot de passe oublié</a> </label> <br>
        <input type="password" name="password" id="">
    </div>

    <button type="submit" class="form-group">Se connecter</button>

</form>


<?php require_once("assets/php/footer.php") ?>