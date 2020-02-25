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
                <input type="file" class="form-control-file" id="imagePost" name="imagePost[]" accept="image/*" multiple>
            </div>
            <button class="btn btn-primary" type="submit" name="btnValidPost">Valider</button>
        </form>
        <?php
            if (isset($btnValidPost)) {
                $countfiles = count($_FILES['imagePost']['name']);
                for ($i = 0; $i < $countfiles; $i++){
                    if (strpos($_FILES['imagePost']['type'][$i], 'image') !== false) {
                        if (convertBytesToMegaBytes($_FILES['imagePost']['size'][$i]) <= 3) {
                            if (!doesImageExist($_FILES['imagePost']['name'][$i])) {
                                $uploads_dir = 'img';
                                $name = $_FILES['imagePost']['name'][$i];
                                move_uploaded_file($_FILES['imagePost']['tmp_name'][$i], "$uploads_dir/$name");
                            }
                        }
                    }
                }
                saveAllPost($messagePost, date('Y-m-d H:i:s'), $_FILES['imagePost']);
            }
        ?>
    </div>
    <?php
        include_once('html/js.php');
    ?>
  </body>
</html>