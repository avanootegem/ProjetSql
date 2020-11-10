<?php $titre = "Toutes les idées";
require_once("assets/php/header.php");
require_once("assets/php/db.php")
?>

<h1 id="title_my_idea">Voici les idées de films proposées</h1>
<?php
$req = $pdo->prepare("SELECT title, synopsis, user_id FROM movies_idea");
$req->execute();
$movies = $req->fetchAll(); ?>
<div id="all_ideas">
    <?php foreach ($movies as $movie) : 
        $req = $pdo->prepare("SELECT username FROM users NATURAL JOIN movies_idea WHERE user_id = ? AND title = ?");
        $req->execute([$movie->user_id, $movie->title]); 
        $autor = $req->fetch(); ?>
        <div class="idea">
            <h2 class="title"><?=$movie->title?></h2>
            <p class="synopsis"><?=$movie->synopsis?></p>
            <h2 class="autor"><?=$autor->username?></h2>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once("assets/php/footer.php"); ?>