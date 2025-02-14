<?php include '../include/header.php';
$db = ConnexionBase();

// On verifie si un utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Récupération des éléments lors de l'envoie du formulaire d'inscription et on connecte l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['mdp'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO waz_utilisateurs(ut_email, ut_mdp, tp_ut_id) VALUES (?, ?, ?)"); // Variable qui contient la préparation de la requête SQL
    $stmt->execute([$email, $hashed_password, 2]);

    $_SESSION['logged_in'] = true;
    header('Location: ../index.php'); /* Renvoie à la page index */
    exit();
}
?>

<form method="POST">
    <label for="email">Email : </label>
    <input type="text" name="email">

    <label for="mdp">Mot de passe : </label>
    <input type="password" name="mdp">
    <button type="submit">Valider</button>
</form>
<?php include '../include/footer.php'; ?>