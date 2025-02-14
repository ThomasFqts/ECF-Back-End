<?php include 'include/header.php';
$db = ConnexionBase();

// Verifie si l'utilisateur est connecté et si c'est un admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: index.php'); // Redirection pour les utilisateurs non autorisés
    exit(); // Sortie de la boucle
}

// Verification de la methode de la requete + Recuperation des données
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $an_id = $_POST['an_id'];

    $stmt = $db->prepare("SELECT DISTINCT * FROM waz_annonces wa
    JOIN waz_type_offre wto ON wa.tp_ofr_id = wto.tp_ofr_id
    JOIN waz_photo wp ON wa.an_id = wp.an_id
    LEFT JOIN waz_an_opt wap ON wap.an_id = wa.an_id
    LEFT JOIN waz_options wo ON wo.opt_id = wap.opt_id
    WHERE wa.an_id = ?
    GROUP BY wa.an_id;");
    $stmt->execute([$an_id]);
    $annonces = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT * FROM waz_options");
    $stmt->execute();
    $options = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT * FROM waz_type_bien");
    $stmt->execute();
    $type_bien = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT * FROM waz_type_offre");
    $stmt->execute();
    $type_offre = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT * FROM waz_diagnostic");
    $stmt->execute();
    $diagnostics = $stmt->fetchAll();

    // Récupération des options sélectionnées
    $stmt = $db->prepare("SELECT opt_id FROM waz_an_opt WHERE an_id = ?");
    $stmt->execute([$an_id]);
    $selected_options = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!-- Formulaire modification -->
<article class="d-flex justify-content-center">
    <form action="admin/edit.php" method="POST" class="form-control d-flex flex-column w-75">
        <?php foreach ($annonces as $annonce): ?>
            <!-- Contenu du formulaire -->
            <section class="d-flex flex-row justify-content-around align-items-center">

                <!-- Titre + Référence + Description + Typde d'offre + Type de bien + Nombre de pièce -->
                <section class="d-flex flex-column align-items-start">
                    <!-- Titre de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_titre">Titre : </label></strong>
                        <input type="text" name="an_titre" class="" value="<?= $annonce['an_titre']; ?>">
                    </article>

                    <!-- Référence de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_ref">Référence de l'annonce : </label></strong>
                        <input type="text" name="an_ref" class="" value="<?= $annonce['an_ref']; ?>">
                    </article>

                    <!-- Description de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_desc">Description : </label></strong>
                        <input type="text" name="an_desc" class="" value="<?= $annonce['an_description']; ?>">
                    </article>

                    <!-- Type de l'offre de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="type_offre">Type d'offre : </label></strong>
                        <?php foreach ($type_offre as $offre): ?>
                            <article>
                                <input type="radio" name="type_offre" value="<?= $offre['tp_ofr_id']; ?>" <?= $offre['tp_ofr_id'] == $annonce['tp_ofr_id'] ? 'checked' : ''; ?>>
                                <label for=""><?= $offre['tp_ofr_libelle'] ?></label>
                            </article>
                        <?php endforeach ?>
                    </article>

                    <!-- Type de bien du bien de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="type_bien">Type de bien : </label></strong>
                        <select name="type_bien" id="">
                            <option value="" selected disabled hidden>Quel est le type du bien ?</option>
                            <?php foreach ($type_bien as $bien): ?>
                                <option value="<?= $bien['tp_bn_id'] ?>" <?= $bien['tp_bn_id'] == $annonce['tp_bn_id'] ? 'selected' : ''; ?>><?= $bien['tp_bn_libelle'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </article>

                    <!-- Nombre de pièce dans le bien -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_pieces">Nombre de pièce : </label></strong>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <article>
                                <input type="radio" name="an_pieces" value="<?= $i; ?>" <?= $annonce['an_pieces'] == $i ? 'checked' : ''; ?>>
                                <label for=""><?= $i; ?> Pièce<?= $i > 1 ? 's' : ''; ?></label>
                            </article>
                        <?php endfor ?>
                        <article>
                            <input type="radio" name="an_pieces" value="7" <?= $annonce['an_pieces'] == 7 ? 'checked' : ''; ?>>
                            <label for="">Plus de 6 pièces</label>
                        </article>
                    </article>
                </section>

                <!-- Les options + Etat de l'annonce (active ou non) -->
                <section class="d-flex flex-column align-items-center">
                    <!-- Les options -->
                    <article class="d-flex flex-column">
                        <strong><label for="options">Options : </label></strong>
                        <?php foreach ($options as $option): ?>
                            <article>
                                <input type="checkbox" name="option[]" value="<?= $option['opt_id'] ?>" <?= in_array($option['opt_id'], $selected_options) ? 'checked' : ''; ?>>
                                <label for=""><?= $option['opt_libelle'] ?></label>
                            </article>
                        <?php endforeach ?>
                    </article>

                    <!-- Etat de l'annonce -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_etat">Etat : </label></strong>
                        <article>
                            <input type="radio" name="an_etat" value="1" <?= $annonce['an_etat'] == 1 ? 'checked' : ''; ?>>
                            <label for="an_etat">Actif</label>
                        </article>
                        <article>
                            <input type="radio" name="an_etat" value="0" <?= $annonce['an_etat'] == 0 ? 'checked' : ''; ?>>
                            <label for="an_etat">Désactivé</label>
                        </article>
                    </article>
                </section>

                <!-- Surface Habitable + Surface Total + Diagnostic + Localisation du bien + Prix du bien + Date de la modification -->
                <section class="d-flex flex-column align-items-start">
                    <!-- Surface Habitable -->
                    <article class="d-flex flex-column">
                        <strong><label for="surface_habitable">Surface habitable : </label></strong>
                        <input type="text" name="surface_habitable" value="<?= $annonce['an_surf_hab'] ?>">
                    </article>

                    <!-- Surface Total -->
                    <article class="d-flex flex-column">
                        <strong><label for="surface_total">Surface total : </label></strong>
                        <input type="text" name="surface_total" value="<?= $annonce['an_surf_tot'] ?>">
                    </article>

                    <!-- Diagnostic -->
                    <article class="d-flex flex-column">
                        <strong><label for="diagnostic">Diagnostic : </label></strong>
                        <?php foreach ($diagnostics as $diagnostic): ?>
                            <article>
                                <input type="radio" name="diagnostic" value="<?= $diagnostic['d_id'] ?>" <?= $diagnostic['d_id'] == $annonce['d_id'] ? 'checked' : ''; ?>>
                                <label for=""><?= $diagnostic['d_libelle'] ?></label>
                            </article>
                        <?php endforeach ?>
                    </article>

                    <!-- Localisation du bien -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_loc">Localisation : </label></strong>
                        <input type="text" name="an_loc" class="" value="<?= $annonce['an_local']; ?>">
                    </article>

                    <!-- Prix du bien -->
                    <article class="d-flex flex-column">
                        <strong><label for="an_prix">Prix : </label></strong>
                        <input type="text" name="an_prix" class="" value="<?= $annonce['an_prix']; ?>">
                    </article>

                    <!-- Date de modification -->
                    <article class="d-flex flex-column">
                        <strong><label for="date_modif">Date de modif : </label></strong>
                        <input type="text" name="date_modif" value="<?= $annonce['an_d_modif']; ?>">
                    </article>
                </section>
            </section>

            <!-- Bouton de validation du formulaire -->
            <section class="d-flex justify-content-center">
                <input type="hidden" name="an_id" value="<?= $an_id ?>">
                <button type="submit" class="btn btn-success">Modifier</button>
            </section>
        <?php endforeach ?>
    </form>
</article>
<?php include 'include/footer.php'; ?>