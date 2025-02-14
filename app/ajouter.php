<?php include 'include/header.php';
$db = ConnexionBase();

// Verifie si l'utilisateur est connecté et si c'est un admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: index.php'); // Redirection pour les utilisateurs non autorisés
    exit(); // Sortie de la boucle
}

// Verification de la methode de la requete + Recuperation des données
if ($_SERVER['REQUEST_METHOD'] === "POST") {
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
}
?>

<!-- Formulaire d'ajout -->
<article class="d-flex justify-content-center">
    <form action="admin/add.php" method="POST" class="form-control d-flex flex-column w-75">
        <!-- Contenu du formulaire -->
        <section class="d-flex flex-row justify-content-around align-items-center">

            <!-- Titre + Référence + Description + Typde d'offre + Type de bien + Nombre de pièce -->
            <section class="d-flex flex-column align-items-start">
                <!-- Titre de l'annonce -->
                <article class="d-flex flex-column">
                    <strong><label for="an_titre">Titre : </label></strong>
                    <input type="text" name="an_titre" class="" placeholder="Titre de l'annonce">
                </article>

                <!-- Référence de l'annonce -->
                <article class="d-flex flex-column">
                    <strong><label for="an_ref">Référence de l'annonce : </label></strong>
                    <input type="text" name="an_ref" class="" placeholder="Référence de l'annonce">
                </article>

                <!-- Description de l'annonce -->
                <article class="d-flex flex-column">
                    <strong><label for="an_desc">Decsription : </label></strong>
                    <input type="text" name="an_desc" class="" placeholder="Description de l'annonce">
                </article>

                <!-- Typde de l'offre de l'annonce -->
                <article class="d-flex flex-column">
                    <strong><label for="type_offre">Type d'offre : </label></strong>
                    <?php foreach ($type_offre as $offre): ?>
                        <article>
                            <input type="radio" name="type_offre" value="<?= $offre['tp_ofr_id']; ?>">
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
                            <article>
                                <option value="<?= $bien['tp_bn_id'] ?>"><?= $bien['tp_bn_libelle'] ?></option>
                            </article>
                        <?php endforeach ?>
                    </select>

                </article>

                <!-- Nombre de pièce dans le bien -->
                <article class="d-flex flex-column">
                    <strong><label for="an_pieces">Nombre de pièce : </label></strong>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <article>
                            <input type="radio" name="an_pieces" value="<?= $i; ?>">
                            <label for=""><?= $i; ?> Pièce<?= $i > 1 ? 's' : ''; ?></label>
                        </article>
                    <?php endfor ?>
                    <article>
                        <input type="radio" name="an_pieces" value="7">
                        <label for="">Plus de 6 pièces</label>
                    </article>
                </article>
            </section>

            <!-- Les options + Etat de l'annonce (active ou non) + Noms des photos -->
            <section class="d-flex flex-column align-items-center">
                <!-- Les options -->
                <article class="d-flex flex-column">
                    <strong><label for="options">Options : </label></strong>
                    <?php foreach ($options as $option): ?>
                        <article>
                            <input type="checkbox" name="option[]" value="<?= $option['opt_id'] ?>">
                            <label for=""><?= $option['opt_libelle'] ?></label>
                        </article>
                    <?php endforeach ?>
                </article>

                <!-- Etat de l'annonce -->
                <article class="d-flex flex-column">
                    <strong><label for="options">Etat : </label></strong>
                    <!-- Annonce actif -->
                    <article>
                        <input type="radio" name="an_etat" value="1">
                        <label for="an_etat">Actif</label>
                    </article>

                    <!-- Annonce desactiver -->
                    <article>
                        <input type="radio" name="an_etat" value="0">
                        <label for="an_etat">Desactiver</label>
                    </article>
                </article>

                <!-- Noms des photos -->
                <article class="d-flex flex-column">
                    <strong><label for="photos">Noms des photos : </label></strong>
                    <div id="photo-fields">
                        <input type="text" name="photos[]" placeholder="Nom de la photo">
                    </div>
                    <button type="button" id="add-photo-field" class="btn btn-secondary mt-2">Ajouter un nom de photo</button>
                </article>
            </section>

            <!-- Surface Habitable + Surface Total + Diagnostic + Localisation du bien + Prix du bien + Date d'ajout de l'annonce -->
            <section class="d-flex flex-column align-items-start">
                <!-- Surface Habitable -->
                <article class="d-flex flex-column">
                    <strong><label for="surface_habitable">Surface habitable : </label></strong>
                    <input type="text" name="surface_habitable" placeholder="Surface habitable">
                </article>

                <!-- Surface Total -->
                <article class="d-flex flex-column">
                    <strong><label for="surface_total">Surface total : </label></strong>
                    <input type="text" name="surface_total" placeholder="Surface total">
                </article>

                <!-- Diagnostic -->
                <article class="d-flex flex-column">
                    <strong><label for="diagnostic">Diagnostic : </label></strong>
                    <?php foreach ($diagnostics as $diagnostic): ?>
                        <article>
                            <input type="radio" name="diagnostic" value="<?= $diagnostic['d_id'] ?>">
                            <label for=""><?= $diagnostic['d_libelle'] ?></label>
                        </article>
                    <?php endforeach ?>
                </article>

                <!-- Localisation du bien -->
                <article class="d-flex flex-column">
                    <strong><label for="an_loc">Localisation : </label></strong>
                    <input type="text" name="an_loc" class="" placeholder="Localisation du bien">
                </article>

                <!-- Prix du bien -->
                <article class="d-flex flex-column">
                    <strong><label for="an_prix">Prix : </label></strong>
                    <input type="text" name="an_prix" class="" placeholder="Prix du bien">
                </article>

                <!-- Date d'ajout -->
                <article class="d-flex flex-column">
                    <strong><label for="date_ajout">Date d'ajout : </label></strong>
                    <input type="text" name="date_ajout" placeholder="Date d'ajout">
                </article>
            </section>
        </section>

        <!-- Bouton de validation du formulaire -->
        <section class="d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Ajouter</button>
        </section>
    </form>
</article>
<?php include 'include/footer.php'; ?>