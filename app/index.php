<?php include 'include/header.php';
$db = ConnexionBase();

// Verifie si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userType = $_SESSION['user_type'];
    $stmt = $db->prepare("SELECT * FROM waz_annonces wa
        JOIN waz_type_offre wto ON wa.tp_ofr_id = wto.tp_ofr_id
        GROUP BY wa.an_id;");
    $stmt->execute();
    $annonces = $stmt->fetchAll();
}

$isAdmin = isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['Admin']);
?>

<!-- Si l'utilisateur est connecté, on affiche les annonces -->
<?php if (isset($_SESSION['user_id'])): ?>

    <?php if ($isAdmin): ?>
        <section class="d-flex flex-row justify-content-center">
            <form action="ajouter.php" method="POST">
                <button type="submit" class="btn btn-success">Ajouter une nouvelle annonce</button>
            </form>
        </section>
    <?php endif ?>


    <section class="d-flex justify-content-around flex-wrap">
        <?php foreach ($annonces as $annonce): ?>
            <!-- Verification de l'eta de l'annonce (active = 1, desactivé = 0) -->
            <?php if ($annonce['an_etat'] == 1): ?>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <!-- Titre de l'annonce -->
                        <h5 class="card-title"><?= $annonce['an_titre'] ?></h5>

                        <!-- Description de l'annonce -->
                        <p class="card-text"><strong>Description : </strong> <?= $annonce['an_description'] ?></p>

                        <!-- Nombre de pièce du bien -->
                        <p><strong>Nombre de pièce : </strong><?= $annonce['an_pieces'] ?></p>

                        <!-- Type d'offre du bien -->
                        <p class="card-text"><strong>Type Offre : </strong> <?= $annonce['tp_ofr_libelle'] ?></p>

                        <!-- Surface Habitable du bien -->
                        <p><strong>Surface habitable : </strong><?= $annonce['an_surf_hab'] ?>m2</p>

                        <!-- Surface total du bien -->
                        <p><strong>Surface total : </strong><?= $annonce['an_surf_tot'] ?>m2</p>

                        <!-- Prix du bien -->
                        <p class="card-text"><strong>Prix :</strong> <?= $annonce['an_prix'] ?>€</p>

                        <!-- Date d'ajout de l'annonce -->
                        <p class="card-text"><strong>Date d'ajout :</strong> <?= $annonce['an_d_ajout'] ?></p>

                        <?php if ($annonce['an_d_modif']): ?>
                            <!-- Date de modification de l'annonce -->
                            <p class="card-text"><strong>Date de modification :</strong> <?= $annonce['an_d_modif'] ?></p>
                        <?php endif ?>

                        <!-- Formulaire de validation pour rediriger l'utilisateur sur la page avec tous les détails de l'annonce -->
                        <form action="bien.php" method="POST">
                            <input type="hidden" name="an_id" value="<?= $annonce['an_id'] ?>">
                            <button type="submit" class="btn btn-primary">En savoir plus</button>
                        </form>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </section>
<?php endif ?>
<?php include 'include/footer.php'; ?>