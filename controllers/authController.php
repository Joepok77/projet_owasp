<?php
namespace Johan\ProjetOwasp\Controllers;
require_once 'Database.php';
use Johan\ProjetOwasp\Utils\Database;  // Inclure la classe Database



 class AuthController
{
    public function register()
    {
        // Vérifier si la méthode est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer et nettoyer les données du formulaire
            $nom = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST["password"]);

            // Afficher les données pour vérifier
            var_dump($_POST);  // Affiche les données envoyées
            var_dump($nom, $email, $password);  // Affiche les données après nettoyage

            // Vérification des champs requis et du mot de passe
            if (empty($nom) || empty($email) || empty($password) || strlen($password) < 4) {
                $error = "Tous les champs sont requis et le mot de passe doit avoir au moins 4 caractères.";
            } else {
                // Vérifier si l'email est valide
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Erreur : L'email n'est pas valide.";
                }
            }

            // Connexion à la base de données
            if (!isset($error)) {
                $pdo = Database::getPDO();

                // Vérifier si l'email existe déjà
                $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $existingUser = $stmt->fetch();

                if ($existingUser) {
                    $error = "Erreur : L'email est déjà utilisé.";
                } else {
                    // Hasher le mot de passe
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);

                    // Insertion dans la base de données
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password) VALUES (:nom, :email, :password)");

                    if ($stmt->execute([
                        'nom' => $nom,
                        'email' => $email,
                        'password' => $hashed_password
                    ])) {
                        $success = "Inscription réussie !";
                    } else {
                        $error = "Erreur SQL : " . implode(" - ", $stmt->errorInfo());
                    }
                }
            }
        }

        // Affichage du message d'erreur ou de succès
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        } elseif (isset($success)) {
            echo "<p style='color:green;'>$success</p>";
        }

        // Optionnel : Rediriger ou afficher le formulaire d'inscription
        // require_once '../public/register.php';  // Afficher le formulaire d'inscription
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification du CSRF token (si applicable)
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
                $error = "Requête invalide.";
            } else {
                $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
                $password = trim($_POST["password"]);

                // Vérifier si les champs sont vides
                if (empty($email) || empty($password)) {
                    $error = "Veuillez remplir tous les champs.";
                } else {
                    // Connexion à la base de données
                    $pdo = Database::getPDO();
                    $stmt = $pdo->prepare("SELECT id, nom, password FROM utilisateurs WHERE email = :email");
                    $stmt->execute(["email" => $email]);
                    $user = $stmt->fetch();

                    // Vérification du mot de passe
                    if ($user && password_verify($password, $user["password"])) {
                        // Créer la session pour l'utilisateur
                        $_SESSION["user_id"] = $user["id"];
                        $_SESSION["username"] = htmlspecialchars($user["nom"], ENT_QUOTES, 'UTF-8');
                        $_SESSION["login_attempts"] = 0;
                        header("Location: /index.php");
                        exit;
                    } else {
                        // Gestion des tentatives de connexion erronées
                        $_SESSION["login_attempts"]++;
                        sleep(2); // Petit délai pour limiter les attaques par brute force
                        $error = "Email ou mot de passe incorrect.";
                    }
                }
            }

            require_once '../public/login.php'; // Vous pouvez rediriger ou afficher un message d'erreur
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /login.php");
        exit();
    }
}