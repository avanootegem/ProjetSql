<?php session_start();
$titre = "Account";
require_once("assets/php/header.php");
logged_only();

if(!empty($_POST)) {
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']->user_id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once("assets/php/db.php");
        $req = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $req->execute([$password, $user_id]);

        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}
?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>

    <form action="" method="post"> 
    <div class="form-group">
        <input type="password" name="password" id="" placeholder="Changer de mot de passe">
    </div>

    <div class="form-group">
        <input type="password" name="password_confirm" id="" placeholder="Confirmation de votre mot de passe">
    </div>

    <button type="submit" class="form-group">Changer mon mot de passe</button>
    </form>


<?php require_once("assets/php/footer.php") ?>