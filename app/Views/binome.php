<?=$this->extend('layouts/acceuil1')?>

<?= $this->section('content') ?>
<br><br>

<?php /* --- Affichage des Messages Flash --- */ ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('warning')): /* Ajout pour messages d'avertissement */ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<h2 class="text-center mb-4">Résultats du Binômage</h2>

<?php /* --- Boutons d'Action --- */ ?>
<div class="d-flex justify-content-center align-items-center gap-3 mb-4 flex-wrap">
    <form action="<?= site_url('binomes/generate') ?>" method="post" class="m-1">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-success"> Générer les binômes </button>
    </form>

    <?php // Afficher le bouton Réinitialiser seulement s'il y a des binômes ?>
    <?php if (!empty($binomes)): ?>
        <form action="<?= site_url('binomes/reset') ?>" method="post" class="m-1" onsubmit="return confirm('Voulez-vous vraiment supprimer tous les binômes formés ?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-warning"> Réinitialiser les binômes formés</button>
        </form>
    <?php endif; ?>
</div>


<?php /* --- Affichage des Binômes --- */ ?>
<?php if (!empty($binomes)): ?>
    <p class="text-center text-muted">Nombre de binômes formés : <?= count($binomes) ?></p>
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-bordered table-hover align-middle text-center caption-top">
           
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 1%;"></th>
                    <th scope="col" style="width: 50%;">Parrain</th>
                    <th scope="col" style="width: 50%;">Filleul</th>
                    <th scope="col" style="width: 10%;"></th> <?php /* Pour suppression individuelle */ ?>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach ($binomes as $index => $b): ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td>
                            <!-- /* --- Info Parrain --- */  -->
                            <?php
                                // Chemin vers l'image par défaut (à créer dans public/uploads/)
                                $defaultPhoto = base_url('uploads/default_avatar.png');
                                // Chemin vers la photo spécifique
                                $parrainPhotoPath = FCPATH . 'uploads/' . $b['parrain_photo'];
                                $parrainPhotoUrl = (!empty($b['parrain_photo']) && file_exists($parrainPhotoPath))
                                                    ? base_url('uploads/' . $b['parrain_photo'])
                                                    : $defaultPhoto;
                            ?>
                            <img src="<?= $parrainPhotoUrl ?>"
                                 class="rounded-circle img-thumbnail mb-2 shadow-sm"
                                 style="width:160px;height:160px;object-fit:cover;"
                                 alt="Photo de <?= esc($b['parrain_prenom']) ?>">
                            <br>
                            <span class="fw-bold"><?= esc($b['parrain_prenom'] . ' ' . $b['parrain_nom']) ?></span>
                        </td>
                        <td>
                             <?php /* --- Info Filleul --- */ ?>
                             <?php
                                $filleulPhotoPath = FCPATH . 'uploads/' . $b['filleul_photo'];
                                $filleulPhotoUrl = (!empty($b['filleul_photo']) && file_exists($filleulPhotoPath))
                                                    ? base_url('uploads/' . $b['filleul_photo'])
                                                    : $defaultPhoto;
                            ?>
                             <img src="<?= $filleulPhotoUrl ?>"
                                  class="rounded-circle img-thumbnail mb-2 shadow-sm"
                                 style="width:160px;height:160px;object-fit:cover;"
                                  alt="Photo de <?= esc($b['filleul_prenom']) ?>">
                            <br>
                             <span class="fw-bold"><?= esc($b['filleul_prenom'] . ' ' . $b['filleul_nom']) ?></span>
                        </td>
                        <td>
                            <?php /* --- Bouton Suppression Individuelle (Optionnel) --- */ ?>
                             <?php if (isset($b['binome_id'])): // Assurez-vous que binome_id est bien passé par le contrôleur ?>
                                <form action="<?= site_url('binomes/' . $b['binome_id']) ?>" method="post" onsubmit="return confirm('Etes vous sûr de vouloir supprimer l\'association entre <?= esc($b['parrain_prenom']) ?> et <?= esc($b['filleul_prenom']) ?> ?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE"> <?php /* Important pour la route DELETE */ ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer ce binôme">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                        </svg>
                                        <span class="visually-hidden">Supprimer</span>
                                    </button>
                                </form>
                             <?php else: ?>
                                 <span class="text-muted">-</span>
                             <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php /* --- Message si Aucun Binôme --- */ ?>
<?php else: ?>
    <div class="alert alert-info text-center shadow-sm mt-4">
        <h4 class="alert-heading">Il n'y a actuellement aucun binôme formé !</h4>
        <hr>
        <p class="mb-0">Cliquez sur le bouton " Générer les binômes " ci-dessus pour créer les binômes.</p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<style>
    /* Optionnel : Ajoute un peu d'espace entre les cellules pour mieux voir les bordures */
    .table {
        border-collapse: separate;
        border-spacing: 0 5px; /* Espace vertical entre les lignes */
    }
    .table td, .table th {
        padding: 0.3rem; /* Augmenter un peu le padding interne */
    }
</style>