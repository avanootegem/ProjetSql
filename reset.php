<?php
    if(isset($_GET['id']) && isset($_GET['token'])) {
        require_once('assets/php/db.php');
        require_once('assets/php/fonctions.php');
        session_start();

        $req = $pdo->prepare("SELECT * FROM users WHERE user_id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
        $req->execute([$_GET['id'], $_GET['token']]);
        $user = $req->fetch();
        if($user) {
            if(!empty($_POST)) {
                if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $req = $pdo->prepare("UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE user_id = ?");
                    $req->execute([$password, $_GET['id']]);
                    $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
                    $_SESSION['auth'] = $user;
                    header('Location: account.php');
                    exit();
                }
            }
        } else {
            $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
            header("Location: login.php");
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>

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
$titre = "Reset";
require_once("assets/php/header.php"); ?>

<h1>Réinitialiser mon mot de passe</h1>

<form action="" method="post">

    <div class="form-group">
        <label for="">Mot de passe</label> <br>
        <input type="password" name="password" id="">
    </div>

    <div class="form-group">
        <label for="">Confirmation du mot de passe</label> <br>
        <input type="password" name="password_confirm" id="">
    </div>

    <button type="submit" class="form-group">Reinitialiser votre mot de passe</button>

</form>


<?php require_once("assets/php/footer.php") ?>