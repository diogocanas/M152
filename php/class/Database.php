<?php
/**
 * Nom de projet    : projet_M152
 * Nom de fichier   : Database.php
 * Auteur           : Diogo CANAS ALMEIDA
 * Date             : 23 janvier 2020
 * Description      : Classe de bases de données
 * Version          : 1.0
 */

// Classe Database
class Database
{
    // Initialisation des variables
    private static $db;
    const HOST = "localhost";
    const DBNAME = "db_m152";
    const USERNAME = "admin";
    const PASSWORD = "Super2012";

    /**
     * @brief   Constructeur de la classe
     */
    private function __construct() {}
    private function __clone() {}

    // Méthodes
    /**
     * @brief   Méthode qui crée une connexion à une base de données
     * @return  $db --> objet PDO
     */
    public static function GetInstance() {
        if (!self::$db) {
            try {
                $dsn = 'mysql:host='.self::HOST.';dbname='.self::DBNAME;
                self::$db = new PDO($dsn, self::USERNAME, self::PASSWORD, array('charset'=>'utf8'));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur : $e");
            }
        }
        return self::$db;
    }

    
}