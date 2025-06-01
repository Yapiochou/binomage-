<?= $this->extend('layouts/acceuil') ?>
<?= $this->section('content') ?>

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

<?php $errors = session()->getFlashdata('errors'); // Récupérer les erreurs de validation ?>
<?php if (! empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Erreurs de validation</h4>
        <hr>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<br><br><br>

<h2>Formulaire 📝</h2>
<br>

<form action="<?= site_url('filleuls') ?>" method="post" enctype="multipart/form-data" class="container mt-4 p-4 border rounded shadow-sm bg-light" style="max-width: 600px;">
    <?= csrf_field() ?>  <h3 class="mb-4 text-center">Ajouter un Filleul</h3>

    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="nom" id="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" value="<?= old('nom') ?>" required>
         <?php if (isset($errors['nom'])): ?>
            <div class="invalid-feedback">
                <?= esc($errors['nom']) ?>
            </div>
        <?php endif ?>
    </div>

     <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" name="prenom" id="prenom" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>" value="<?= old('prenom') ?>" required>
         <?php if (isset($errors['prenom'])): ?>
            <div class="invalid-feedback">
                <?= esc($errors['prenom']) ?>
            </div>
        <?php endif ?>
    </div>

    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
         <input type="file" name="photo" id="photo" class="form-control <?= isset($errors['photo']) ? 'is-invalid' : '' ?>" required accept="image/*" onchange="previewImage(event)">
         <?php if (isset($errors['photo'])): ?>
            <div class="invalid-feedback">
                <?= esc($errors['photo']) ?>
            </div>
        <?php endif ?>
        <img id="preview" src="#" alt="Prévisualisation" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;"/>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary"> Ajouter le Filleul </button>
    </div>
</form>
<br><br><br>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        preview.onload = function() {
            URL.revokeObjectURL(preview.src) // libère la mémoire
        }
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
// Optionnel: cacher la prévisualisation si le formulaire échoue et est rechargé sans fichier
document.addEventListener('DOMContentLoaded', (event) => {
    const photoInput = document.getElementById('photo');
    if (photoInput && photoInput.files.length === 0) {
         const preview = document.getElementById('preview');
         if(preview) {
            preview.style.display = 'none';
            preview.src = '#';
         }
    } else if (photoInput && photoInput.files.length > 0) {
         // Si un fichier est déjà sélectionné (après un échec de validation), déclencher l'aperçu
         previewImage({target: photoInput});
    }
});
</script>

<?= $this->endSection() ?>