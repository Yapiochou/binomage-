<?=$this->extend('layouts/acceuil')?>
<!-- [$this->extend('route du fichier template ou principale )] -->
<!-- 'fichier template' c'est le fichier qui contient la page principale -->
<?=$this->section('content')?>
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
<br>
    <!-- Parrains -->
    <h2 class="mb-3"> Liste des Parrains & Marraines</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-5">
        <?php foreach ($parrains as $p): ?>
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="<?= base_url('uploads/' . $p['photo']) ?>" class="card-img-top rounded-circle mx-auto mt-3" style="width:100px;height:100px;object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($p['prenom']) ?> <?= esc($p['nom']) ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<hr>
<hr><br>
    <!-- Filleuls -->
    <h2 class="mb-3"> Liste des Filleuls  </h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-5">
        <?php foreach ($filleuls as $f): ?>
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="<?= base_url('uploads/' . $f['photo']) ?>" class="card-img-top rounded-circle mx-auto mt-3" style="width:100px;height:100px;object-fit:cover;">
                    <div class="card-body">
                       <h5 class="card-title"><?= esc($f['prenom']) ?> <?= esc($f['nom']) ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

     
    <!-- Actions -->
    <div class="d-flex justify-content-center gap-3 mb-4">
        <form action="<?= site_url('etudiants/reset_all') ?>" method="post"
              onsubmit="return confirm('ATTENTION !\n\nÊtes-vous absolument sûr de vouloir supprimer TOUS les parrains, TOUS les filleuls et TOUTES leurs photos ?\n\nCette action est IRRÉVERSIBLE et videra complètement l\'application.')">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger fw-bold">Supprimer tous les Étudiants</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?=$this->endsection('content')?>