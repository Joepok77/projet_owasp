<?php
// Inclure l'autoloader généré par Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Utilisation du bon namespace
use Johan\ProjetOwasp\Controllers\AuthController;
use AltoRouter;

// Initialiser le routeur AltoRouter
$router = new AltoRouter();

// Définir la base path de l'application (si nécessaire)
$router->setBasePath('/projet_owasp');// Vous pouvez aussi spécifier directement le chemin

// Définir les routes
$router->addRoutes([
    ['GET', '/', 'Johan\\ProjetOwasp\\Controllers\\AuthController::home', 'home'],
    ['GET|POST', '/register', 'Johan\\ProjetOwasp\\Controllers\\AuthController::register', 'register'],
    ['GET|POST', '/login', 'Johan\\ProjetOwasp\\Controllers\\AuthController::login', 'login'],
    ['GET', '/logout', 'Johan\\ProjetOwasp\\Controllers\\AuthController::logout', 'logout'],
]);

// Récupérer la correspondance de l'URL actuelle
$match = $router->match();

// Si une correspondance est trouvée, appeler le contrôleur et l'action
if ($match) {
    $controller = $match['target'];
    $params = $match['params'];

    list($controllerClass, $method) = explode('::', $controller);

    $controllerInstance = new $controllerClass();

    // Appeler la méthode du contrôleur correspondante
    $controllerInstance->$method(...$params);
} else {
    echo "Page non trouvée!";
}
