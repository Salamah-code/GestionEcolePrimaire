<?php
session_start();
if (isset($_SESSION['erreurLogin']))
  $erreurLogin = $_SESSION['erreurLogin'];
else {
  $erreurLogin = "";
}
session_destroy();
?>
<?php
require_once('connexion.php');
?>
<!DOCTYPE html>
<html lang="en">

<?php include('header.php') ?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="site-logo mr-auto w-25"><a href="index.html">GesPrimaire</a></div>

          <div class="mx-auto text-center">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
                <li><a href="#home-section" class="nav-link">Accueil</a></li>
                <li><a href="#courses-section" class="nav-link">Galeries</a></li>
                <li><a href="#programs-section" class="nav-link">A propos</a></li>
              </ul>
            </nav>
          </div>

          <div class="ml-auto w-25">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
                <li class="cta"><a href="#contact-section" class="nav-link"><span>Contactez-nous</span></a></li>
              </ul>
            </nav>
            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>

    </header>

    <div class="intro-section" id="home-section">

      <div class="slide-1" style="background-image: url('images/imag16.jpeg');" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row align-items-center">
                <div class="col-lg-6 mb-4">
                  <h1 data-aos="fade-up" data-aos-delay="100">BIENVENUE DANS NOTRE ECOLE</h1>
                  <p class="mb-4" data-aos="fade-up" data-aos-delay="200">
                  <h2> Apprendre. Eduquer. Grandir </h2>
                  Un espace de développement, d’éveil intellectuel, de savoir, d’exploration et de communication.
                  </p>
                  <p data-aos="fade-up" data-aos-delay="300"><a href="Admin/html/inscriptionadmin.php" class="btn btn-primary py-3 px-5 btn-pill">S'inscrire maintenant</a></p>
                </div>

                <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="500"><br>
                  <form action="Admin/html/connexionadmin.php" method="post" class="form-box">
                    <?php
                    if (isset($_GET['login_err'])) {
                      $err = htmlspecialchars($_GET['login_err']);

                      switch ($err) {
                        case 'password':
                    ?>
                          <div class="alert alert-danger">
                            <strong>Erreur</strong> mot de passe incorrect
                          </div>
                        <?php
                          break;

                        case 'email':
                        ?>
                          <div class="alert alert-danger">
                            <strong>Erreur</strong> email incorrect
                          </div>
                        <?php
                          break;

                        case 'already':
                        ?>
                          <div class="alert alert-danger">
                            <strong>Erreur</strong> compte non existant
                          </div>
                    <?php
                          break;
                      }
                    }
                    ?>
                    <h3 class="h4 text-black mb-4">Se connecter</h3>
                    <div class="form-group"><br>
                      <input type="email" name="email" class="form-control" placeholder="Adresse Mail">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Mot De Passe" name="password">
                    </div><br>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-pill" value="Connexion" name="btnlogin" class="box-button">
                    </div>
                  </form>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="site-section courses-title" id="courses-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">Galeries</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="site-section courses-entry-wrap" data-aos="fade-up" data-aos-delay="100">
      <div class="container">
        <div class="row">

          <div class="owl-carousel col-12 nonloop-block-14">

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag16.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>
            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/img7.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag12.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>



            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag14.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag11.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag15.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

          </div>
        </div>

        <div class="row">

          <div class="owl-carousel col-12 nonloop-block-14">

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag10.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>
            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/image20.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/img19.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>



            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imagfille.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag12.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

            <div class="course bg-white h-100 align-self-stretch">
              <figure class="m-0">
                <img src="images/imag11.jpeg" alt="Image" class="img-fluid" id="imageg"></a>
              </figure>

            </div>

          </div>
        </div>


      </div>
    </div>


    <div class="site-section" id="programs-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">A Propos</h2>
            <p></p>
          </div>
        </div>
        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
            <img src="images/imagscol.jpeg" alt="Image" class="img-fluid">
          </div>
          <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-black mb-4">L’Espace Élémentaire d’Excellence</h2>
            <p class="mb-4">
              Composée d’une équipe pédagogique disponible et attentionnée, ses maîtres mots sont :
              l’accueil, l’écoute, la confiance, le respect, la solidarité et la proximité à l’égard des élèves et de
              leurs familles. </p>

          </div>
        </div>

        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="images/imagecil.jpeg" alt="Image" class="img-fluid">
          </div>
          <div class="col-lg-4 mr-auto order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-black mb-4">L’Espace Élémentaire d’Excellence</h2>
            <p class="mb-4">Elle accueille les élèves des cycles élémentaire (CI au CM) dans un environnement favorisant
              leur développement physique et psychologique. “Notre objectif est de développer
              le savoir de l’enfant en les associant à toutes les activités pédagogiques ensuite les préparer
              graduellement à leur prochaine intégration dans le cycle secondaire.
            </p>

          </div>
        </div>

        <div class="row mb-5 align-items-center">
          <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
            <img src="images/imaglivre.jpeg" alt="Image" class="img-fluid">
          </div>
          <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-black mb-4">Nos programmes</h2>
            <p class="mb-4">Les axes du projet de l’établissement s’articulent autour : <br>
              <i class="bi bi-arrow-up-right ">
                <style>
                  i {
                    color: black;
                    font-size: 1em;
                  }
                </style>
              </i>Du développement du savoir-faire, du savoir-être et du savoir-devenir ; <br>
              De l’éducation à la citoyenneté ; <br>
              <i class="bi bi-arrow-up-right ">
                <style>
                  i {
                    color: black;
                    font-size: 1em;
                  }
                </style>
              </i>
              De l’apprentissage à vivre ensemble dans le respect et la tolérance ; <br>
              <i class="bi bi-arrow-up-right ">
                <style>
                  i {
                    color: black;
                    font-size: 1em;
                  }
                </style>
              </i>
              De la favorisation à l’ouverture culturelle (culture générale, culture littéraire, culture théâtrale,
              culture artistique et culture digitale) ; <br>
              <i class="bi bi-arrow-up-right ">
                <style>
                  i {
                    color: black;
                    font-size: 1em;
                  }
                </style>
              </i>
              De l’épanouissement par des activités pédagogiques et sportives.
            </p>




          </div>
        </div>

      </div>
    </div>










    <div class="site-section bg-light" id="contact-section">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-md-7">



            <h2 class="section-title mb-3">Contactez-nous</h2>
            <p class="mb-5">Nos équipes sont mobilisées pour répondre à vos questions par téléphone. <br> <br>Contactez
              nous via ce formulaire, nous vous rappellerons pour répondre à vos questions et préparer votre rentrée !
            </p>

            <form method="post" data-aos="fade">
              <div class="form-group row">
                <div class="col-md-6 mb-3 mb-lg-0">
                  <input type="text" class="form-control" placeholder="Prenom">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Nom">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Sujet">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="email" class="form-control" placeholder="Mail">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea class="form-control" id="" cols="30" rows="10" placeholder="Ecrire votre message ici."></textarea>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">

                  <input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="J'ENVOIE MA DEMANDE">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </diV>


    <?php include('footer.php') ?>



  </div> <!-- .site-wrap -->
  <?php include('script.php') ?>


</body>

</html>