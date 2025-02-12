<?php
session_start(); // Commencer une session, fonction native

function ConnexionBase()
{ // Infos pour trouver la BDD
    try {
        $connexion = new PDO( // Connexion entre PHP et la BDD
            "mysql:host=localhost;dbname=afpa_wazaa_immo;charset=utf8mb4",
            'root',
            ''
        );
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Juste pour une erreur 
        return $connexion;
    } catch (Exception $e) { // Attrape l'exception, si ça ne se connecte pas à la BDD
        echo "Erreur : " . $e->getMessage() . "<br>";
        echo "N° : " . $e->getCode();
        die("Fin du script");
    }
}
$db = ConnexionBase(); // Connexion à la base de données

// Vérifie si l'utilisateur est connecté
$username = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userTypeS = $_SESSION['user_type'];

    // Récupération des informations de l'utilisateur
    $stmtUser = $db->prepare("SELECT * FROM waz_utilisateurs WHERE ut_id = :userId"); // Variable qui contient la préparation de la requête SQL
    $stmtUser->execute(['userId' => $userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $ut_email = $user['ut_email'];
    }
}

// Vérifie si l'utilisateur est admin
$isAdmin = isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['Admin']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Wazaa Immo</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active navbar-brand" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if ($username): ?>
                        <a class="" aria-current="page" href="./login/deconnexion.php">Deconnexion</a>
                    <?php else: ?>
                        <a href="./login/connexion.php" class="">Connexion</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>