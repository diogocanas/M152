<?php
/**
 * Nom de projet    : projet_M152
 * Nom de fichier   : functions.php
 * Auteur           : Diogo CANAS ALMEIDA
 * Date             : 23 janvier 2020
 * Description      : Fichier de fonctions
 * Version          : 1.0
 */

/**
 * @brief   Fonction qui appelle plusieurs autres fonctions
 * @param   $commentaire    ==> Message du post
 * @param   $date           ==> Date du post
 * @param   $images         ==> Tableau d'images du post
 */
function saveAllPost($commentaire, $date, $images) {
    $db = Database::GetInstance();
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
    Database::GetInstance()->beginTransaction();
    
    try {
        $sql = "INSERT INTO post(commentaire, creationDate) VALUES(:commentaire, :creationDate)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
        $stmt->execute();
        $idPost = $db->lastInsertId();
        for ($i = 0; $i < count($images['name']); $i++) {
            $imageType = $images['type'][$i];
            $imageName = $images['name'][$i];
    
            $sql = "INSERT INTO media(typeMedia, nomMedia, creationDate, post_idPost) VALUES(:typeMedia, :nomMedia, :creationDate, :post_idPost)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":typeMedia", $imageType, PDO::PARAM_STR);
            $stmt->bindParam(":nomMedia", $imageName, PDO::PARAM_STR);
            $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
            $stmt->bindParam(":post_idPost", $idPost, PDO::PARAM_INT);
            moveFiles($images);
            $stmt->execute();
        }
        Database::GetInstance()->commit();
    } catch (PDOException $e) {
        Database::GetInstance()->rollBack();
        die("Erreur : " . $e->getMessage());
    }
}

/**
 * @brief   Fonction qui déplace l'image dans un dossier donné
 */
function moveFiles($images) {
    $countfiles = count($images['name']);
        for ($i = 0; $i < $countfiles; $i++){
            if (strpos($images['type'][$i], 'image') !== false || strpos($images['type'][$i], 'video') !== false || strpos($images['type'][$i], 'audio') !== false) {
                if (convertBytesToMegaBytes($images['size'][$i]) <= 3) {
                    if (!doesImageExist($images['name'][$i])) {
                        $uploads_dir = './img';
                        $name = $images['name'][$i];
                        move_uploaded_file($images['tmp_name'][$i], "$uploads_dir/$name");
                        array_push($_SESSION['imgValid'], true);
                    } else {
                        array_push($_SESSION['imgValid'], false);
                    }
                } else {
                    array_push($_SESSION['imgValid'], false);
                }
            } else {
                array_push($_SESSION['imgValid'], false);
            }
        }
}

/**
 * @brief   Fonction qui récupère les informations des posts
 * @return  array   ==> Informations des posts et des medias
 */
function getAllPostsAndMedias() {
    $db = Database::GetInstance();
    $posts = array();
    $medias = array();

    try {
        $sql = "SELECT post.idPost, post.commentaire, post.creationDate, media.nomMedia, media.post_idPost, media.typeMedia FROM post INNER JOIN media ON post.idPost = media.post_idPost ORDER BY post.creationDate DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            if (count($posts) == 0) {
                array_push($posts, array($row['idPost'], $row['commentaire'], $row['creationDate']));
            }
            foreach ($posts as $post) {
                if ($post[0] != $row['idPost']) {
                    array_push($posts, array($row['idPost'], $row['commentaire'], $row['creationDate']));
                    break;
                }
            }
            array_push($medias, array($row['nomMedia'], $row['post_idPost'], $row['typeMedia']));
        }
        return array($posts, $medias);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

/**
 * @brief   Fonction qui vérifie si l'image uploadée existe déjà ou non
 * @param   $imageName      ==> Nom de l'image
 * @return  $doesExist      ==> True si l'image existe déjà | False si l'image n'existe pas
 */
function doesImageExist($imageName) {
    $db = Database::GetInstance();
    $doesExist = false;

    try {
        $sql = "SELECT nomMedia FROM media";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            if ($row['nomMedia'] == $imageName) {
                $doesExist = true;
                break;
            } else {
                $doesExist = false;
            }
        }
        return $doesExist;
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

/**
 * @brief   Fonction qui convertit les octets en mégaoctets
 * @param   $bytes      ==> Nombre d'octets de l'image
 * @return  $megabytes  ==> Nombre de mégaoctets de l'image
 */
function convertBytesToMegaBytes($bytes) {
    $megabytes = $bytes / 1000000;
    return $megabytes;
}