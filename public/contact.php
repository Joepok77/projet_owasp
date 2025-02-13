<?php
session_start();
require_once 'csrf.php'; // Inclusion des fonctions CSRF

// Vérification et traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur : CSRF token invalide.");
    }

    // Récupération des données et validation simple
    $nom = trim($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = trim($_POST['message']);

    if ($nom && $email && $message) {
        // Connexion à la base de données (ajuste les informations)
        $pdo = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
        $stmt = $pdo->prepare("INSERT INTO contact_messages (nom, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $message]);
        
        $success = "Message envoyé avec succès !";
    } else {
        $error = "Veuillez remplir tous les champs correctement.";
    }
}

// Génération du token CSRF
$csrf_token = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<body>
    <h1>Contactez-nous</h1>

    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form action="contact.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" required><br>

        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" required><br>

        <label for="message">Message :</label><br>
        <textarea name="message" id="message" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>

    <a href="/">Retour à l'accueil</a>
</body>
</html>
