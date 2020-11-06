<?php $titre = "Register";
require_once("assets/php/header.php");
?>

<div id="debug">
    <?php
    if (!empty($_POST)) {
        $errors = array();
        require_once("assets/php/db.php");

        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
            $errors['username'] = "Vous pseudo n'est pas valide (alphanumérique)";
        } else {
            $req = $pdo->prepare("SELECT user_id FROM users WHERE username=?");
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            if ($user) {
                $errors['username'] = "Ce pseudo est déja pris";
            }
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Votre email n'est pas valide";
        } else {
            $req = $pdo->prepare("SELECT user_id FROM users WHERE username=?");
            $req->execute([$_POST['email']]);
            $user = $req->fetch();
            if ($user) {
                $errors['email'] = "Cet email est déja utilisé";
            }
        }

        if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
            $errors['password'] = "Vous devez rentrer un mot de passe valide";
        }

        if (empty($errors)) {
            $req = $pdo->prepare("INSERT INTO users SET username =?, password = ?, email = ?, confirmation_token = ?");
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $token = str_random(60);
            $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
            $user_id = $pdo->lastInsertId();

            mail($_POST['email'], "Confirmation de votre compte", "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost:8000/confirm.php?id=$user_id&token=$token");
            $_SESSION['flash']['success'] = "Votre compte a été validé";
            header("Location: confirm.php?id=$user_id&token=$token");
            exit();
        }
    }

    ?>
</div>

<h1> S'inscrire </h1>

<?php if (!empty($errors)) : ?>

    <div class="alert alert-danger">
        <div>
            <p>Vous n'avez pas rempli le formulaire correctement :</p> <br>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

<?php endif; ?>

<form action="" method="post">

    <div class="form-group">
        <label for="">Pseudo</label> <br>
        <input type="text" name="username">
    </div>

    <div class="form-group">
        <label for="">Email</label> <br>
        <input type="text" name="email" id="">
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label> <br>
        <input type="password" name="password" id="">
    </div>

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label> <br>
        <input type="password" name="password_confirm" id="">
    </div>

    <button type="submit" class="form-group">M'inscrire</button>

</form>


<?php require_once("assets/php/footer.php"); ?>