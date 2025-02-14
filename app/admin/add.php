<?php include '../include/header.php';
$db = ConnexionBase();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
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
    $date_ajout = $_POST['date_ajout'];
    $etat = $_POST['an_etat'];

    $stmt = $db->prepare("INSERT INTO waz_annonces(an_pieces, an_ref, an_titre, an_description, an_local, an_surf_hab, an_surf_tot, an_prix, an_d_ajout, an_etat, d_id, tp_bn_id, tp_ofr_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute([$nbre_piece, $ref, $titre_annonce, $desc, $loc, $surf_hab, $surf_tot, $prix, $date_ajout, $etat, $diagnostic, $type_bien, $type_offre]);

    // Insertion des options sélectionnées
    $an_id = $db->lastInsertId();
    foreach ($options as $option) {
        $stmt = $db->prepare("INSERT INTO waz_an_opt(an_id, opt_id) VALUES (?, ?);");
        $stmt->execute([$an_id, $option]);
    }

    // Insertion des noms de photos
    $photos = $_POST['photos'];
    foreach ($photos as $photo) {
        if (!empty($photo)) {
            $stmt = $db->prepare("INSERT INTO waz_photo(ft_nom, an_id) VALUES (?, ?);");
            $stmt->execute([$photo, $an_id]);
        }
    }

    header("Location: ../index.php");
    exit();
}
