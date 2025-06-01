<?=$this->extend('layouts/acceuil')?>
<!-- [$this->extend('route du fichier template ou principale )] -->
<!-- 'fichier template' c'est le fichier qui contient la page principale -->
<?=$this->section('content')?>



<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <a href="#">BINOMAGE</a>
    </div>
    <ul class="nav-links">
    <li><a href="#">&nbsp;</a></li>
         <li><a href="#">Accueil</a></li>
        <li><a href="#">&nbsp;</a></li>

         <li class="nav-item">
              <a class="nav-link" href="<?= site_url('filleuls/creer') ?>">Formulaire d'ajout</a>
         </li>
        <li><a href="#">&nbsp;</a></li>
        <li><a href="#">&nbsp;</a></li>
        <li><a href="#">&nbsp;</a></li>
    </ul>
    <div class="hamburger" id="hamburger">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
     <div class="table-responsive">

        <strong>
            <h1>  Bienvenue sur notre page d'accueille du logiciel de binômage </h1>
        </strong>
        
        <h3 style="color: cyan;">
            Explorons ensemble cette technologies, produit innovant créer pour et par des étudiants en  infomatique
        </h3>
    </div>
    <a href="binomes" class="btn-main">
        Let's GO ✨ 
    </a>
</section>

<!-- Features Section -->
<section class="features-section">
        <div class="table-responsive">

      
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <h3>C'est quoi cette cérémonie ?</h3>
                    <p>Une cérémonie de binomage est un événement où deux personnes sont officiellement associées, généralement dans un cadre de mentorat ou de parrainage. Elle marque le début de la relation entre un "parrain" et un "filleul" pour un accompagnement ou une collaboration .</p>
                </div>
            </div>
            <hr>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-box">
                    <h3>Pourquoi une cérémonie de binomage est-elle importante ?</h3>
                    <p>Cette cérémonie est importante car elle officialise la relation de mentorat ou de parrainage, créant ainsi un cadre structuré pour l'accompagnement. Cela permet aussi de renforcer l'engagement des participants, en rendant la relation plus sérieuse et formelle.</p>
                </div>
            </div>
           
        </div>
    </div>
</section>

<!-- Footer -->

    <footer class="footer">
    <div class="footer-content">
        <div class="logo">
            <h2>Merci !</h2>
        </div>
       
        <p>&copy; 2025 IGL / IDA  | Tous droits réservés</p>
    </div>
</footer>


<!-- Bootstrap JS and dependencies -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/popper.min.js"></script>

<script>
    // JavaScript pour gérer le hamburger menu
    const hamburger = document.getElementById('hamburger');
    const navbar = document.querySelector('.navbar');
    hamburger.addEventListener('click', () => {
        navbar.classList.toggle('active');
    });
</script>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fb;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Navbar */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #333;
        padding: 20px 30px;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
    .navbar .logo a {
        color: #fff;
        font-weight: bold;
        font-size: 1.5rem;
        text-decoration: none;
    }
    .navbar .nav-links {
        list-style: none;
        display: flex;
        margin: 0;
    }
    .navbar .nav-links li {
        margin-right: 20px;
    }
    .navbar .nav-links li a {
        color: #fff;
        text-decoration: none;
        font-size: 1rem;
    }
    .navbar .nav-links li a:hover {
        color: #f8b400;
    }
    .hamburger {
        display: none;
        cursor: pointer;
        flex-direction: column;
        justify-content: space-between;
        height: 20px;
        width: 30px;
    }
    .hamburger .bar {
        background-color: #fff;
        height: 3px;
        width: 100%;
    }
    @media (max-width: 768px) {
        .navbar .nav-links {
            position: fixed;
            top: 0;
            left: -100%;
            height: 100%;
            width: 100%;
            background-color: #333;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: left 0.3s ease;
        }
        .navbar .nav-links li {
            margin: 20px 0;
        }
        .navbar .hamburger {
            display: flex;
        }
        .navbar.active .nav-links {
            left: 0;
        }
    }

    /* Hero Section */
    .hero-section {
        background: url('<?=base_url('bino2.jpeg')?>') no-repeat center center;
        /* background: url('<?=base_url('Formation18-02-25.jpg')?>') no-repeat center center; */
        background-size: cover;
        height: 100vh;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
    }
    .hero-section h1 {
        font-size: 4rem;
        font-weight: bold;
        margin-bottom: 20px;
        z-index: 2;
    }
    .hero-section p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        z-index: 2;
    }
    .hero-section::before {
        content: '';
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    .btn-main {
        background-color: #f8b400;
        color: #1d1f21;
        font-weight: bold;
        padding: 12px 30px;
        border-radius: 30px;
        border: none;
        z-index: 2;
    }
    .btn-main:hover {
        background-color: #fff;
        color: #1d1f21;
    }

    /* Features Section */
    .features-section {
        padding: 60px 0;
    }
    .feature-box {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .feature-box h3 {
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    .feature-box p {
        font-size: 1.1rem;
        color: #555;
    }

    /* Footer */
    
.footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    width: 100%;
    text-align: center;
}

.footer .footer-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.footer .logo a {
    color: #fff;
    font-weight: bold;
    font-size: 1.5rem;
    text-decoration: none;
    margin-bottom: 10px;
}

.footer .footer-links {
    list-style: none;
    display: flex;
    padding: 0;
    margin: 0;
}

.footer .footer-links li {
    margin-right: 20px;
}

.footer .footer-links li a {
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
}

.footer .footer-links li a:hover {
    color: #f8b400;
}

    }
</style>

