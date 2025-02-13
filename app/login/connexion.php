<?php include '../include/header.php';
$db = ConnexionBase();

// On verifie si un utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    header("Location : ../index.php");
    exit();
}

// Récupération des éléments lors de l'envoie du formulaire de connexion et on connecte l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['mdp'];

    $stmt = $db->prepare("SELECT * FROM waz_utilisateurs WHERE ut_email = :email"); // Variable qui contient la préparation de la requête SQL
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); /* Récupération des infos de l'utilisateur selon son email dans les variables de session */

    // Verification si l'utilisateur existe et que mot de passe hasher correspond à celui de la bdd
    if ($user && password_verify($password, $user['ut_mdp'])) {
        $_SESSION['user_id'] = $user['ut_id'];

        // Récupération du type de l'utilisateur
        $stmt = $db->prepare("SELECT * FROM waz_type_utilisateur WHERE tp_ut_id = :typeuser"); // Variable qui contient la préparation de la requête SQL
        $stmt->bindValue(':typeuser', $user['ut_id']);
        $stmt->execute();
        $usertype = $stmt->fetch(PDO::FETCH_ASSOC); /* Récupération des infos du type de l'utilisateur dans les variables de session */
        $_SESSION['user_type'] = $usertype['tp_ut_libelle'];
        $_SESSION['logged_in'] = true;
        header('Location: ../index.php'); /* Renvoie à la page index */
        exit();
    }
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