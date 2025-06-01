<!doctype html>
<html lang="fr">
<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?=base_url('assets/icon.jpg')?>" type="image/png">

        <title> Binômage </title>
        <!-- Bootstrap CDN -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap CSS -->
         <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/vendors/linericon/style.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/css/font-awesome.min.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/vendors/owl-carousel/owl.carousel.min.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/vendors/lightbox/simpleLightbox.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/vendors/nice-select/css/nice-select.css')?>">
        <!-- main css -->
        <link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/css/responsive.cs')?>s">
      
    </head>
   
<body class="bg-light" >
    <div class="container py-5">
        <!--================ Header Area =================-->

        <header class="header_area">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Bienvenue</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('filleuls/creer') ?>">Ajouter un filleul 🎓</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('parrains/creer') ?>">Ajouter un parrain 🎓</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('liste') ?>">Liste 📃</a>
                    </li> 
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('binomes') ?>">Résultats</a>
                    </li> -->
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="page">Bienvenue</a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" href="filleuls_creer">Ajouter un filleul 🎓</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="parrains_creer">Ajouter un parrain 🎓</a>   
                            </li>                 
                            <li class="nav-item">
                                <a class="nav-link" href="liste_etud">liste 📃 </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="binomes"> Résultats </a>
                            </li> -->
                        </ul>
                    </div> 
                </div>
            </nav>
        </header>
        <!--================ Fin Header =================-->

        <?= $this->renderSection('content') ?>

    </div>

    <!--================ start footer Area  =================-->
<footer class="footer-area" style="background-color: #1d1f21; padding: 50px 0; color: #fff;">
    <div class="container">
        <div class="row">
            <!-- À propos -->
            <div class="col-lg-4 col-md-6">
                <div class="single-footer-widget">
                    <h6 class="footer-title" style="font-size: 20px; margin-bottom: 10px;">À propos de nous</h6>
                    <p style="font-size: 15px; line-height: 1.8;">Nous sommes un groupe d'étudiants passionnés par l'informatique, le développement et l'innovation. Curieux et motivés. </p>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-4 col-md-6">
                <div class="single-footer-widget">
                    <h6 class="footer-title" style="font-size: 18px; margin-bottom: 20px;">Inscription à la Newsletter</h6>
                  <h3>
                    <p style="font-size: 15px; line-height: 1.8;">NOUS VOUS REMERCIONS D'AVOIR UTILISER NOTRE APPLICATION WEB 😉</p>
                  </h3>  
                    <form class="form-inline" style="margin-top: 20px;">
                        <input type="email" class="form-control mb-2 mr-sm-2" placeholder="Entrez votre email" required style="width: 70%; border-radius: 0px; padding: 10px 15px;">
                        <button type="submit" class="btn btn-primary mb-2" style="border-radius: 10px;">S'abonner</button>
                    </form>
                </div>
            </div>

            <!-- Liens supplémentaires -->
            <div class="col-lg-4 col-md-6">
                <div class="single-footer-widget">
                    <h6 class="footer-title" style="font-size: 18px; margin-bottom: 20px;">Liens utiles</h6>
                    <ul class="footer-links">
                        <li><a href="#" style="font-size: 15px;">À propos de nous</a></li>
                        <li><a href="#" style="font-size: 15px;">Notre équipe</a></li>
                        <li><a href="#" style="font-size: 15px;">Contact</a></li>
                        <li><a href="page" style="font-size: 15px;">Page d'accueille</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <hr style="border-top: 1px solid #fff; margin-top: 40px; margin-bottom: 30px;">

        <!-- Copyright -->
        <p class="text-center" style="font-size: 14px; margin-bottom: 0;">Copyright &copy; 2025 ESETEC Binomage. Tous droits réservés.</p>
    </div>
</footer>

    <!--================ End footer Area  =================-->
    
    <!-- JavaScript -->
    <script src="<?= base_url('assets/js/jquery-3.2.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom.js') ?>"></script>

</body>
</html>

