<?php include '../include/header.php';
$db = ConnexionBase();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $an_id = $_POST['an_id'];
    $titre_annonce = $_POST['an_titre'];
    $ref = $_POST['an_ref'];
    $desc = $_POST['an_desc'];
    $type_offre = $_POST['type_offre'];
    $type_bien = $_POST['type_bien'];
    $nbre_piece = $_POST['an_pieces'];
    $options = isset($_POST['option']) ? $_POST['option'] : [];
    $surf_hab = $_POST['surface_habitable'];
    $surf_tot = $_POST['surface_total'];
    $diagnostic = $_POST['diagnostic'];
    $loc = $_POST['an_loc'];
    $prix = $_POST['an_prix'];
    $date_modif = $_POST['date_modif'];
    $etat = $_POST['an_etat'];

    // Mise à jour de l'annonce
    $stmt = $db->prepare("UPDATE waz_annonces 
    SET an_pieces = ?, an_ref = ?, an_titre = ?, an_description = ?, an_local = ?, an_surf_hab = ?, 
    an_surf_tot = ?, an_prix = ?, an_d_modif = ?, an_etat = ?, d_id = ?, tp_bn_id = ?, tp_ofr_id = ? 
    WHERE an_id = ?");
    $stmt->execute([$nbre_piece, $ref, $titre_annonce, $desc, $loc, $surf_hab, $surf_tot, $prix, $date_modif, $etat, $diagnostic, $type_bien, $type_offre, $an_id]);

    // Mise à jour des options
    $stmt = $db->prepare("DELETE FROM waz_an_opt WHERE an_id = ?");
    $stmt->execute([$an_id]);

    foreach ($options as $option) {
        $stmt = $db->prepare("INSERT INTO waz_an_opt (an_id, opt_id) VALUES (?, ?)");
        $stmt->execute([$an_id, $option]);
    }

    // Redirection vers la page index.php après la modification
    header("Location: ../index.php");
    exit();
}
?>