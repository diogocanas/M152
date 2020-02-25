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
 * @brief   Fonction qui enregistre un post dans la base de données
 * @param   $commentaire    ==> Message du post
 * @param   $date           ==> Date du post
 */
function createPost($commentaire, $date) {
    $db = Database::GetInstance();
    
    try {
        $sql = "INSERT INTO post(commentaire, creationDate) VALUES(:commentaire, :creationDate)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

/**
 * @brief   Fonction qui enregistre un ou plusieurs média(s) dans la base de données
 * @param   $images     ==> Tableau d'images en $_FILES
 * @param   $date       ==> Date du post
 * @param   $idPost     ==> Id du post
 */
function createMedia($images, $date, $idPost) {
    $db = Database::GetInstance();

    for ($i = 0; $i < count($images['name']); $i++) {
        try {
            $imageType = $images['type'][$i];
            $imageName = $images['name'][$i];
    
            $sql = "INSERT INTO media(typeMedia, nomMedia, creationDate, post_idPost) VALUES(:typeMedia, :nomMedia, :creationDate, :post_idPost)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":typeMedia", $imageType, PDO::PARAM_STR);
            $stmt->bindParam(":nomMedia", $imageName, PDO::PARAM_STR);
            $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
            $stmt->bindParam(":post_idPost", $idPost, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}

/**
 * @brief   Fonction qui récupère l'id du post qui correspond aux images
 */
function getIdByMessageAndDate($commentaire, $date) {
    $db = Database::GetInstance();

    $date .= '.0';
    try {
        $sql = "SELECT idPost FROM post WHERE commentaire LIKE :commentaire AND creationDate LIKE :creationDate";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            return $row['idPost'];
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

function saveAllPost($commentaire, $date, $images) {
    createPost($commentaire, $date);
    $idPost = getIdByMessageAndDate($commentaire, $date);
    createMedia($images, $date, $idPost);
}

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