<?php $titre = "Mes idées";
require_once("assets/php/header.php");
require_once("assets/php/db.php")
?>

<h1 id="title_ideas_page">Voici vos idées de films</h1>
<form action="create.php" class="buttonNewMovie">
    <input type="submit" value="Proposer un nouveau scénario">
</form>
<?php

$req = $pdo->prepare("SELECT * FROM movies_idea WHERE user_id = ?");
$req->execute([$_SESSION['auth']->user_id]);
$movies = $req->fetchAll(); ?>

<div id="all_ideas">
    <?php foreach ($movies as $movie) :
        $req = $pdo->prepare("SELECT username FROM users NATURAL JOIN movies_idea WHERE user_id = ? AND title = ?");
        $req->execute([$movie->user_id, $movie->title]);
        $autor = $req->fetch(); ?>

        <div class="idea">
            <h2 class="title"><?= $movie->title ?></h2>
            <p class="synopsis"><?= $movie->synopsis ?></p>
            <div id="bottomHistory">
                <form method="post" action="modify.php">
                    <input type="submit" value="M">
                    <input type="hidden" name="id" value="<?= $movie->movie_id?>">
                </form>
                <form method="post" action="delete.php">
                    <input type="submit" value="D">
                    <input type="hidden" name="id" value="<?= $movie->movie_id?>">
                </form>
                <h2 class="autor"><?= $autor->username ?></h2>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once("assets/php/footer.php"); ?>