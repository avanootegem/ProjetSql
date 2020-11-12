<?php $titre = "Toutes les idées";
require_once("assets/php/header.php");
require_once("assets/php/db.php")
?>

<?php
if(!empty($_POST)) {
    $req = $pdo->prepare("INSERT INTO movies_idea (title, synopsis, user_id) VALUES (?, ?, ?)");
    $req->execute([$_POST['title'], $_POST['synopsis'], $_SESSION['auth']->user_id]);
    $_SESSION['flash']['success'] = "Votre histoire a bien été créée";
    header("Location: my_idea.php");
    exit();
}

?>

<form action="" method="post">

    <div class="form-group">
        <label for="">Titre</label> <br>
        <input type="text" name="title" required>
    </div>

    <div class="form-group">
        <label for="">Synopsis</label> <br>
        <textarea name="synopsis" id="" cols="35" rows="10" required></textarea>
    </div>

    <button type="submit" class="form-group">Soumettre l'histoire</button>

</form>

<?php require_once("assets/php/footer.php"); ?>