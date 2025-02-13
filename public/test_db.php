<?php
// Inclure le fichier Database.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Johan\ProjetOwasp\Utils\Database;
require_once '../config/database.php';  // Chemin relatif

// Instancier la classe Database
$db = new Database();

// Essayer de se connecter à la base de données
$conn = $db->getPDO();

// Vérifier si la connexion a réussi
if ($conn) {
    echo "Connexion réussie à la base de données!";
} else {
    echo "Échec de la connexion à la base de données!";
}
?>
