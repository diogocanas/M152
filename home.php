<?php

/**
 * Nom du projet    : projet__M152
 * Nom du fichier   : home.php
 * Auteur           : Diogo CANAS ALMEIDA
 * Date             : 23 janvier 2020
 * Description      : Page d'accueil de l'application
 * Version          : 1.0
 */
session_start();
require_once 'php/inc.all.php';
$posts_medias = getAllPostsAndMedias();
$posts = $posts_medias[0];
$medias = $posts_medias[1];
if (!isset($_SESSION['imgValid'])) {
  $_SESSION['imgValid'] = array();
}
?>
<!doctype html>
<html lang="en">

<head>
  <?php
  include_once('html/head.php');
  ?>
  <title>Home</title>
</head>

<body>
  <?php
  include_once('html/navbar.php');
  $carousel = false;
  ?>
  <div class="m-5">
    <div class="card">
      <h1>Welcome !</h1>
      <?php
      foreach ($posts as $post) {
      ?>
        <div class="card" style="width: 18rem;">
          <?php
          foreach ($medias as $media) {
            if ($media[1] == $post[0]) {
              $type = $media[2];
              if (strpos($type, "image") !== false) {
          ?>
                <img src=<?= "img/$media[0]" ?> class="card-img-top" alt="">
              <?php
              } else if (strpos($type, "video") !== false) {
              ?>
                <video id="video" controls autoplay loop>
                  <source src="<?= "img/$media[0]" ?>" type="<?= $media[2] ?>">
                </video>
          <?php
              }
            }
          }
          ?>
          <div class="card-body">
            <p class="card-text"><?= $post[1] ?></br><?= $post[2] ?></p>
            <button type="button" class="btn btn-primary">Modifier</button>
            <button type="button" class="btn btn-danger">Supprimer</button>
          </div>
        </div>
      <?php
      }
      ?>
      <div class="card-body">

      </div>
    </div>
  </div>
  <?php
  include_once('html/js.php');
  ?>
</body>
</html>