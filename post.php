<?php
/**
 * Nom du projet    : projet__M152
 * Nom du fichier   : post.php
 * Auteur           : Diogo CANAS ALMEIDA
 * Date             : 23 janvier 2020
 * Description      : Page d'édition de l'application
 * Version          : 1.0
 */

require_once 'php/inc.all.php';

$messagePost = filter_input(INPUT_POST, 'messagePost', FILTER_SANITIZE_STRING);
$btnValidPost = filter_input(INPUT_POST, 'btnValidPost');
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
    <title>Post</title>
  </head>
  <body>
    <?php
        include_once('html/navbar.php');
    ?>
    <div class="m-5">
        <form method="POST" action="post.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="messagePost">Commentaires :</label>
                <textarea class="form-control" id="messagePost" rows="3" name="messagePost"></textarea>
            </div>
            <div class="form-group">
                <label for="imagePost">Choisir une image :</label>
                <input type="file" class="form-control-file" id="imagePost" name="imagePost[]" accept="image/*,video/*,audio/*" multiple>
            </div>
            <button class="btn btn-primary" type="submit" name="btnValidPost">Valider</button>
        </form>
        <?php
            if (isset($btnValidPost)) {
                if (!in_array(false, $_SESSION['imgValid'])) {
                    $_SESSION['imgValid'] = array();
                    if ($messagePost !== "") {
                        saveAllPost($messagePost, date('Y-m-d H:i:s'), $_FILES['imagePost']);
                    }
                } else {
                    echo "Erreur";
                }
            }
        ?>
    </div>
    <?php
        include_once('html/js.php');
    ?>
  </body>
</html>