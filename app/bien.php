<?php include 'include/header.php';
$db = ConnexionBase();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $an_id = $_POST['an_id'];

    $stmt = $db->prepare("SELECT * FROM waz_annonces wa
    JOIN waz_type_offre wto ON wa.tp_ofr_id = wto.tp_ofr_id
    JOIN waz_diagnostic wd on wa.d_id = wd.d_id
    WHERE wa.an_id = ?
    GROUP BY wa.an_id;");
    $stmt->execute([$an_id]);
    $annonces = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT DISTINCT * FROM waz_annonces wa
    JOIN waz_an_opt wap ON wap.an_id = wa.an_id
    JOIN waz_options wo ON wo.opt_id = wap.opt_id
    WHERE wa.an_id = ?
    GROUP BY wa.an_id;");
    $stmt->execute([$an_id]);
    $options = $stmt->fetchAll();

    $stmt2 = $db->prepare("SELECT * FROM waz_photo wp
    WHERE wp.an_id = ?;");
    $stmt2->execute([$an_id]);
    $photos = $stmt2->fetchAll();

    $isAdmin = isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['Admin']);
}
?>

<section class="">
    <?php foreach ($annonces as $annonce): ?>
        <article>
            <!-- Carousel photos du bien -->
            <div id="carouselExample" class="carousel slide w-25 h-25">

                <div class="carousel-inner">
                    <?php foreach ($photos as $photo): ?>
                        <div class="carousel-item active">
                            <img src="photos/<?= $photo['ft_nom']; ?>.jpg" class="d-block w-100 h-100" alt="...">
                        </div>
                    <?php endforeach ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </article>

        <article>
            <h5 class="card-title"><?= $annonce['an_titre'] ?></h5>
            <p class="card-text"><strong>Desccription : </strong> <?= $annonce['an_description'] ?></p>
            <p class="card-text"><strong>Type d'offre :</strong> <?= $annonce['tp_ofr_libelle'] ?></p>
            <p><strong>Nombre de pièce : </strong><?= $annonce['an_pieces'] ?></p>
            <?php if ($options): ?>
                <?php foreach ($options as $option): ?>
                    <p class="card-text"><strong>Options : </strong> <?= $option['opt_libelle'] ?></p>
                <?php endforeach ?>
            <?php else: ?>
                <p class="card-text"><strong>Options :</strong> Pas d'options</p>
            <?php endif ?>
            <p><strong>Surface habitable : </strong><?= $annonce['an_surf_hab'] ?>m2</p>
            <p><strong>Surface total : </strong><?= $annonce['an_surf_tot'] ?>m2</p>
            <p class="card-text"><strong>Diagnostic :</strong> <?= $annonce['d_libelle'] ?></p>
            <p class="card-text"><strong>Prix :</strong> <?= $annonce['an_prix'] ?>€</p>
            <p class="card-text"><strong>Date d'ajout :</strong> <?= $annonce['an_d_ajout'] ?></p>
            <?php if ($isAdmin): ?>
                <form action="modifier.php" method="POST">
                    <input type="hidden" name="an_id" value="<?= $annonce['an_id'] ?>">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            <?php endif ?>
        </article>

    <?php endforeach ?>
</section>

<?php include 'include/footer.php' ?>