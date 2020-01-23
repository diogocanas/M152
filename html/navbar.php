<?php
/**
 * Nom du projet    : projet__M152
 * Nom du fichier   : navbar.php
 * Auteur           : Diogo CANAS ALMEIDA
 * Date             : 23 janvier 2020
 * Description      : Barre de navigation de l'application
 * Version          : 1.0
 */
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="img/logoCFPT.png" width="70" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="./home.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./post.php"><i class="fas fa-plus"></i> Post</a>
        </li>
        </ul>
    </div>
</nav>