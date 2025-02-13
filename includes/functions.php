<?php
session_start();

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie si le token CSRF est valide.
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Vérifie si le token est expiré (optionnel, 1 heure de validité).
 */
function isCsrfTokenExpired() {
    return isset($_SESSION['csrf_token_time']) && (time() - $_SESSION['csrf_token_time'] > 3600);
}
?>
