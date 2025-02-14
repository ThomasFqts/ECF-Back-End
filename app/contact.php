<?php
include 'include/header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Envoi de l'email
        $to = "ordre.tuple@example.com";
        $subject = "Nous contacter";
        $body = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "De: $email";

        if ($to && $subject && $body && $headers) {
            echo "Message envoyé avec succès!";
        } else {
            echo "Echec de l'envoi du message.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>

<h1>Contact Us</h1>
<form action="contact.php" method="post" class="form-control d-flex flex-column justify-content-center align-items-center">
    <article class="d-flex flex-row">
        <label for="name">Prénom:</label>
        <input type="text" id="name" name="name" required><br><br>
    </article>
    <article class="d-flex flex-row">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
    </article>
    <article class="d-flex flex-row">
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br><br>
    </article>

    <button type="submit" class="btn btn-success">Envoyer !</button>
</form>
</body>

</html>