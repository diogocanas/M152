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
 * @brief   Fonction qui enregistre les informations des images dans la base de données
 * @param   $commentaire    ==> Message du post
 * @param   $type           ==> Type de l'image
 * @param   $fileName       ==> Nom du fichier de l'image
 * @param   $date           ==> Date à laquelle le post à été publié
 */
function saveImageInfos($commentaire, $type, $fileName, $date) {
    $db = Database::GetInstance();
    
    try {
        $sql = "INSERT INTO post(commentaire, creationDate) VALUES(:commentaire, :creationDate)";
        $stmt->$db->prepare($sql);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(":creationDate", $date, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}