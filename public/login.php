<main class="main-content">
    <h1>Connexion</h1>
    <!-- Affichage des erreurs -->
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <!-- Formulaire de connexion -->
    <form action="/login" method="post">
        <label for="email">Adresse Email :</label><br>
        <input type="email" name="email" id="email" placeholder="Votre email" required><br>
        <label for="password">Mot de Passe :</label><br>
        <input type="password" name="password" id="password" placeholder="Votre mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>

    <a href="/">Retour à l'accueil</a>
</body>
</html>