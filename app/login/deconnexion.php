<?php
// On démarre une session
session_start();
// On détruit la session
session_destroy();
// Et on renvoie l'utilisateur à l'accueil
header("Location: ../index.php");
exit;
