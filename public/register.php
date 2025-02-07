
<main class="main-content">
<body>
    <h1>Inscription</h1>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST); // Affiche les données envoyées
    // Votre logique de traitement ici
}
?>

    <!-- Messages d'erreur ou de succès -->
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <!-- Formulaire d'inscription -->
    <form action="index.php?action=register" method="POST">

        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required><br>
        
        <label for="email">Adresse Email :</label><br>
        <input type="email" name="email" id="email" placeholder="Email" required><br>
        
        <label for="password">Mot de Passe :</label><br>
        <input type="password" name="password" id="password" placeholder="Mot de passe" required><br>
        
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>

    <a href="/">Retour à l'accueil</a>
    </main>
</body>
</html>