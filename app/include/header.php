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
$email = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userTypeS = $_SESSION['user_type'];

    // Récupération des informations de l'utilisateur
    $stmtUser = $db->prepare("SELECT * FROM waz_utilisateurs WHERE ut_id = :userId"); // Variable qui contient la préparation de la requête SQL
    $stmtUser->execute(['userId' => $userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['ut_email'];
    }
} else {
    // Défini le rôle d'utilisateur comme "Invité" si l'utilisateur n'est pas connecté
    $_SESSION['user_type'] = 'Invite';
    $_SESSION['user_id'] = null;
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
            <a class="navbar-brand" href="../app/index.php">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex">
                    <?php if ($email): ?>
                        <a class="" aria-current="page" href="./login/deconnexion.php">Deconnexion</a>
                    <?php else: ?>
                        <a href="./login/connexion.php" class="">Connexion</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>