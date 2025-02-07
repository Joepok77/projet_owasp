<?php
    
namespace Johan\ProjetOwasp\Utils;  // Modifier ici

use PDO;
use PDOException;

class Database
{
    public static function getPDO()
    {
        $host = 'localhost';  // ou votre hôte
        $db = 'ecommerce';    // nom de votre base de données
        $user = 'user';       // votre utilisateur
        $pass = 'password';   // votre mot de passe

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
        try {
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
}