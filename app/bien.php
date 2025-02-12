<?php include 'include/header.php';
$db = ConnexionBase();

$stmt = $db->prepare("SELECT * FROM waz_annonces wa
JOIN waz_type_offre wto ON wa.tp_ofr_id = wto.tp_ofr_id
JOIN waz_photo wp ON wa.an_id = wp.an_id
GROUP BY wa.an_id;");
$stmt->execute();
$annonces = $stmt->fetchAll();
?>

<section></section>

<?php include 'include/footer.php' ?>