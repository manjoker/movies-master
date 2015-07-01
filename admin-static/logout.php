<?php
session_name('movie_session');
session_start();

// On détruit toutes les variables dans $_SESSION
session_unset();

// On détruit la session côté serveur
session_destroy();

// On détruit le cookie de session côté client
// Le 3ème paramètre 1 indique que le cookie expire le 01/01/1970 à la 1ère seconde
setcookie(session_name(), false, 1, '/');

// On redirige vers la page login
header('Location: ../login.php');