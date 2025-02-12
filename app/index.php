<?php include 'include/header.php';
$db = ConnexionBase();

$stmt = $db->prepare("SELECT * FROM waz_annonces wa
JOIN waz_type_offre wto ON wa.tp_ofr_id = wto.tp_ofr_id
JOIN waz_photo wp ON wa.an_id = wp.an_id
GROUP BY wa.an_id;");
$stmt->execute();
$annonces = $stmt->fetchAll();
?>

<section class="d-flex flex-row justify-content-around">
    <?php foreach ($annonces as $annonce): ?>
        <?php if($annonce['an_etat'] == 1): ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $annonce['an_titre'] ?></h5>
                    <p class="card-text"><strong>Desccription : </strong> <?= $annonce['an_description'] ?></p>
                    <p><strong>Nombre de pièce : </strong><?= $annonce['an_pieces'] ?></p>
                    <p class="card-text"><strong>Type Offre : </strong> <?= $annonce['tp_ofr_libelle'] ?></p>
                    <p><strong>Surface habitable : </strong><?= $annonce['an_surf_hab'] ?>m2</p>
                    <p><strong>Surface total : </strong><?= $annonce['an_surf_tot'] ?>m2</p>
                    <p class="card-text"><strong>Prix :</strong> <?= $annonce['an_prix'] ?>€</p>
                    <p class="card-text"><strong>Prix :</strong> <?= $annonce['an_d_ajout'] ?></p>
                    <form action="bien.php" method="POST">
                        <input type="hidden" name="an_id" value="<?= $annonce['an_id'] ?>">
                        <button type="submit" class="btn btn-primary">En savoir plus</button>
                    </form>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</section>


<?php include 'include/footer.php'; ?>