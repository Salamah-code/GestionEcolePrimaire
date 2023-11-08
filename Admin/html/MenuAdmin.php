<?php require_once('session.php');
require_once('config.php');
?>
<!doctype html>
<html lang="en">

<?php include('header.php') ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="MenuAdmin.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <?php include('nav.php') ?>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill"></i> <span class="fw-bold">Gestion</span>
              </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up dark" aria-labelledby="drop2">
                  <div class="message-body fw-bold ">
            
              <a class="sidebar-link " href="./formInscription.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description "></i></span> -->
                <span class="hide-menu">Inscription</span>
              </a><br>
              
              <a class="sidebar-link" href="./formScolarite.php" aria-expanded="false">
                <!-- <span> <i class="bi bi-cash-coin"></i></span> -->
                <span class="hide-menu">Paiement</span>
              </a><br>
             
              <a class="sidebar-link" href="./formEleve.php" aria-expanded="false">
                <!-- <span><i class="bi bi-mortarboard-fill"></i></span> -->
                <span class="hide-menu">Ajout Elèves</span>
              </a><br>
              <a class="sidebar-link" href="./formEnseignant.php" aria-expanded="false">
                <!-- <span> <i class="bi bi-person-fill"></i></span> -->
                <span class="hide-menu"> Ajout Enseignant</span>
              </a><br>
              
              <a class="sidebar-link" href="./formSalle.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description"></i></span> -->
                <span class="hide-menu">Ajout Salle</span>
              </a><br>
              <a class="sidebar-link" href="./formClasse.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description"></i></span> -->
                <span class="hide-menu">Ajout Classe</span>
              </a><br>                     
              <a class="sidebar-link" href="./formEDT.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description"></i></span> -->
                <span class="hide-menu">Emploi Du Temps</span>
              </a><br>
              
              <a class="sidebar-link" href="./formMatiere.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description"></i></span> -->
                <span class="hide-menu">Ajout Matière</span>
              </a><br>

              <a class="sidebar-link" href="./formEmargement.php" aria-expanded="false">
                <!-- <span> <i class="ti ti-file-description"></i></span> -->
                <span class="hide-menu">Ajout Emargement</span>
              </a><br>
         </div>  
         </div> 
            </li> 
              <a href="#" class="btn btn-primary">
                Bienvenue : <?php echo $data['nom']; ?> !</a>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $data['prenom']; ?></p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $data['email']; ?></p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $data['ID']; ?></p>
                    </a>
                    <a href="../../deconnexion.php" class="btn btn-outline-danger mx-3 mt-2 d-block">Déconnexion</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <?php
  include('connexion.php');
  if (!$congestschool) {
      die("Erreur de connexion à la base de données : " . mysqli_connect_error());
  }

  // Requête pour récupérer le nombre total d'élèves
  $requete = "SELECT COUNT(*) AS totalEleves FROM eleve"; // Assurez-vous d'adapter la requête à votre structure de base de données
  $resultat = mysqli_query($congestschool, $requete);

  if ($resultat) {
      $row = mysqli_fetch_assoc($resultat);
      $totalEleves = $row['totalEleves'];
  } else {
      $totalEleves = "Erreur lors de la récupération des données";
  }

  // Requête pour obtenir le nombre total d'enseignants
  $requete = "SELECT COUNT(*) AS totalEnseignants FROM enseignant"; // Assurez-vous d'adapter la requête à votre structure de base de données
  $resultat = mysqli_query($congestschool, $requete);

  if ($resultat) {
      $row = mysqli_fetch_assoc($resultat);
      $totalEnseignants = $row['totalEnseignants'];
  } else {
      $totalEnseignants = "Erreur lors de la récupération des données";
  }

  // Requête pour obtenir le nombre total de classes
  $requete = "SELECT COUNT(*) AS totalClasses FROM classe"; // Assurez-vous d'adapter la requête à votre structure de base de données
  $resultat = mysqli_query($congestschool, $requete);

  if ($resultat) {
      $row = mysqli_fetch_assoc($resultat);
      $totalClasses = $row['totalClasses'];
  } else {
      $totalClasses = "Erreur lors de la récupération des données";
  }

  // Requête pour obtenir le nombre total de salles
  $requete = "SELECT COUNT(*) AS totalSalles FROM salle"; // Assurez-vous d'adapter la requête à votre structure de base de données
  $resultat = mysqli_query($congestschool, $requete);

  if ($resultat) {
      $row = mysqli_fetch_assoc($resultat);
      $totalSalles = $row['totalSalles'];
  } else {
      $totalSalles = "Erreur lors de la récupération des données";
  }
  // Requête pour obtenir le total des inscrits pour l'année en cours

  $req_total_inscrit = "SELECT COUNT(*) AS total_inscrit FROM inscription";
$result_total_inscrits = mysqli_query($congestschool, $req_total_inscrit);

if ($req_total_inscrit) {
    $row_total_inscrit = mysqli_fetch_assoc($result_total_inscrits);
    $total_inscrit = $row_total_inscrit['total_inscrit'];
} else {
    $total_inscrit= 0; // En cas d'erreur dans la requête
}

  // Requête pour obtenir le total des paiements pour l'année en cours
  $currentYear = date("Y");
  $requete = "SELECT SUM(MONTANTPAIEMENT) AS montant_total_annee_cours
              FROM paiementscoloarite
              WHERE YEAR(DATEPAIEMENT) = $currentYear";

  $resultat = mysqli_query($congestschool, $requete);

  if ($resultat) {
      $row = mysqli_fetch_assoc($resultat);
      $montant_total_annee_cours = $row['montant_total_annee_cours'];
  } else {
      $montant_total_annee_cours = 0; // En cas d'erreur dans la requête
  }

  // Fermer la connexion à la base de données
  mysqli_close($congestschool);
?>

        <div class="container-fluid">
          <div class="card-group">
            <div class="card border-right">
              <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                  <div>
                    <div class="d-inline-flex align-items-center">
                      <a href="lesclasses.php"><i class="bi bi-person-fill" id="iconeA"></i></a>
                      <span id="totalElevesBadge" class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                          <?php echo $totalEleves; ?>
                      </span>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">TOTAL ELEVES</h6>
                  </div>
                  <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                  </div>
                </div>
              </div>
            </div>
          <div class="card border-right">
            <div class="card-body">
              <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                  <div class="d-inline-flex align-items-center">
                  <a href="listeEnseignants.php"><i class="bi bi-person-workspace" id="iconeA"></i></a>

                   
                      <span id="totalElevesBadge" class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                          <?php echo $totalEnseignants; ?>
                      </span> 
                                  
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">TOTAL ENSEIGNANTS</h6>

                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                  <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card border-right">
            <div class="card-body">
              <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                  <div class="d-inline-flex align-items-center">
                  <a href="listeClasses.php"><i class="bi bi-book" id="iconeA"></i></a>

                    <span id="totalElevesBadge" class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                          <?php echo $totalClasses; ?>
                      </span>
                   </div>
                  <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">TOTAL CLASSES</h6>

                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                  <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card border-right">
            <div class="card-body">
              <div class="d-flex d-lg-flex d-md-block align-items-center">
                <div>
                  <div class="d-inline-flex align-items-center">
                  <a href="listeSalle.php"><i class="bi bi-house-door" id="iconeA"></i></a>
                    <span id="totalElevesBadge" class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">
                          <?php echo $totalSalles; ?>
                      </span>                 
                     </div>
                     <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">TOTAL SALLES</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                  <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                </div>
              </div>
            </div>
          </div>
        </div><br><br>
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Taux de reussite en CFEE</h5>
                  </div>
                  <div>
                    <select class="form-select">
                      <option value="1">2021-2022</option>
                      <option value="2">2022-2023</option>
                      <option value="3">2023-2024</option>
                    </select>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Total des Inscriptions</h5>
                    <div class="row align-items-center">
                      <div class="col-8">
                        <h4 class="fw-semibold mb-3"><?php echo  $total_inscrit; ?> </h4>
                        <div class="d-flex align-items-center mb-3">
                          <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                            <i class="ti ti-arrow-up-left text-success"></i>
                          </span>
                          <!-- <p class="text-dark me-1 fs-3 mb-0">+9%</p> -->
                          <p class="fs-3 mb-0"></p>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="me-4">
                            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2"></span>
                          </div>
                          <div>
                            <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-center">
                          <div id="breakup"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold">Total Paiement Annuel </h5>
                        <h4 class="fw-semibold mb-3"> <?php echo  $montant_total_annee_cours; ?> </h4>
                                                <div class="d-flex align-items-center pb-1">
                          <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                            <i class="ti ti-arrow-down-right text-danger"></i>
                          </span>
                          <!-- <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                          <p class="fs-3 mb-0">last year</p> -->
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-currency-dollar fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
        </div><br><br><br><b></b><br><br><br><b></b><br><br><br><b></b>
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php include('script.php') ?>
</body>

</html>