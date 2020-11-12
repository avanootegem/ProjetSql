<?php $titre = "Toutes les idées";
require_once("assets/php/header.php");
require_once("assets/php/db.php")
?>

<?php
if(!empty($_POST['synopsis'])) {
    $req = $pdo->prepare("UPDATE movies_idea SET title = ?, synopsis = ? WHERE movie_id = ?");
    $req->execute([$_POST['title'], $_POST['synopsis'], $_POST['id']]);
    $_SESSION['flash']['success'] = "Votre histoire a bien été modifiée";
    header("Location: my_idea.php");
    exit();
}

?>

<form action="" method="post">
    <?php
    echo($_POST['id']);
    $req = $pdo->prepare("SELECT * FROM movies_idea WHERE movie_id = ?");
    $req->execute([$_POST['id']]);
    $movie = $req->fetch(); ?>
    <div class="form-group">
        <label for="">Titre</label> <br>
        <input type="text" name="title" value="<?=$movie->title?>" required>
    </div>

    <div class="form-group">
        <label for="">Synopsis</label> <br>
        <textarea name="synopsis" id="" cols="35" rows="10" required><?=$movie->synopsis?></textarea>
    </div>

    <input type="hidden" name="id" value="<?= $_POST['id']?>">

    <button type="submit" class="form-group">Soumettre l'histoire</button>

</form>

<?php require_once("assets/php/footer.php"); ?>