<?php include 'include/header.php';
$db = ConnexionBase();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $an_id = $_POST['an_id'];
    $titre_annonce = $_POST['an_titre'];
    $ref = $_POST['an_ref'];
    $desc = $_POST['an_desc'];
    $type_offre = $_POST['type_offre'];
    $type_bien = $_POST['type_bien'];
    $nbre_piece = $_POST['an_pieces'];
    $options = $_POST['option'];
    $surf_hab = $_POST['surface_habitable'];
    $surf_tot = $_POST['surface_total'];
    $diagnostic = $_POST['diagnostic'];
    $loc = $_POST['an_loc'];
    $prix = $_POST['an_prix'];
    $date_modif = $_POST['date_modif'];
    $etat = $_POST['an_etat'];

    $stmt = $db->prepare("UPDATE waz_annonces SET an_id = ?, an_pieces = ?, an_ref = ?, an_titre = ?, an_description = ?
    , an_local = ?, an_surf_hab = ?, an_surf_tot = ?, an_prix = ?, an_d_modif = ?, an_etat = ?, d_id = ?;");
    $stmt->execute([$an_id, $nbre_piece, $ref, $titre_annonce, $desc, $loc, $surf_hab, $surf_tot, $prix, $date_modif, $etat, $diagnostic]);
    header("Location : index.php");
}
?>