<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("assets/php/fonctions.php");
require_once("assets/php/db.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $titre ?> </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/head_foot.css">
    <link rel="stylesheet" href="assets/css/style_sheet.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/css/block_idea.css">
    <script src="https://kit.fontawesome.com/00ba05901f.js" crossorigin="anonymous"></script>
</head>

<body>
    <header id="entete">
        <nav class="w100">
            <div class="w40">
                <span> Proposition de films prochainement cultes </span>
            </div>
            <ul class="w45">
                <li><a href="index.php">Accueil</a></li>
                <?php if (isset($_SESSION['auth'])) : ?>
                    <li><a href="my_idea.php">Mes idées</a></li>
                    <li><a href="all_ideas.php">Toutes les idées</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                <?php else : ?>
                    <li> <a href="register.php">S'inscrire </a></li>
                    <li> <a href="login.php">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section>

        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="alert alert-<?= $type; ?>">
                    <div>
                        <?= $message ?>
                    </div>
                </div>

        <?php endforeach;
            unset($_SESSION['flash']);
        endif; ?>

        <?php
        $pdo->prepare("ALTER TABLE movies_idea DROP movie_id")->execute();
        $pdo->prepare("ALTER TABLE movies_idea ADD movie_id BIGINT(200) NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (movie_id)")->execute();
        
        $pdo->prepare("ALTER TABLE users DROP user_id")->execute();
        $pdo->prepare("ALTER TABLE users ADD user_id BIGINT(200) NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (user_id)")->execute();