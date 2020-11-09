<?php
require_once("assets/php/fonctions.php");
if(!empty($_POST) && !empty($_POST['email'])) {
    require_once("assets/php/db.php");
    session_start();
    $req = $pdo->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");
    $req->execute([$_POST['email']]);
    $user = $req->fetch();

    if($user) {
        session_start();
        $reset_token = str_random(60);
        $req = $pdo->prepare("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE user_id = ?");
        $req->execute([$reset_token, $user->user_id]);
        $_SESSION['flash']['success'] = "Sélectionner un nouveau mot de passe";
        header("Location: reset.php?id={$user->user_id}&token=$reset_token");
        exit();
    } else {
        $_SESSION['flash']['danger'] = "Aucun compte de correspond à cet adresse";
    }
}
?>


<?php
$titre = "login";
require_once("assets/php/header.php"); ?>

<h1>Mot de passe oublié</h1>

<form action="" method="post">

    <div class="form-group">
        <label for="">Email</label> <br>
        <input type="email" name="email">
    </div>

    <button type="submit" class="form-group">Se connecter</button>

</form>


<?php require_once("assets/php/footer.php") ?>

