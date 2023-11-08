<!DOCTYPE html>
<html lang="en">
<!doctype html>
<html lang="en">
<?php include('header.php') ?>
<style>
    @media print {
        .no-print {
            display: none;
        }
    }
    .card {
                page-break-before: always; /* Déclenche un saut de page avant chaque carte */
                padding: 1rem;
                border: 1px solid #1111;
                margin: 1rem auto;
                max-width: 70%;
            }
          
            /* .custom-text-size {
        font-size: 18px; /* Personnalisez la taille du texte en fonction de vos besoins */
    
        
</style>

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
      <!--  Header End -->
       <div class="d-flex align-items-center">
       <p class="no-print"><a href="javascript:void(0);" class="btn btn-link" id="imprimerRecu"><i class="bi bi-printer"></i> Imprimer la carte </a></p>

                </div>
      

    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <div class="card rounded">
                 <div class="card-header bg-primary">
                    <img src="images/logo.webp" alt="logo" style="max-width: 30px; max-height: 30px; " >

                        <h3 class="text-succes mx-3 ">Modernize Primary School</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        require_once 'connexion.php';

                        if (isset($_GET['id'])) {
                            $eleveId = $_GET['id'];
                        
                            // Échappez la valeur $eleveId pour prévenir les injections SQL
                            $eleveId = mysqli_real_escape_string($congestschool, $eleveId);
                        
                            $req_jointure = "SELECT eleve.*, classe.NOMCLASSE, salle.NOMSALLE, classe.ANNEACCADEMIQUE, eleve.PHOTO
                                             FROM eleve
                                             LEFT JOIN affectation ON eleve.IDELEVE = affectation.ID_ELEVE
                                             LEFT JOIN classe ON affectation.ID_CLASSE = classe.IDCLASSE 
                                             LEFT JOIN salle ON classe.ID_SALLE = salle.IDSALLE
                                             WHERE eleve.IDELEVE = '$eleveId'
                                             GROUP BY eleve.IDELEVE";

                         

                            $resultat_jointure = mysqli_query($congestschool, $req_jointure);
                            while ($row = mysqli_fetch_assoc($resultat_jointure)) {
                                // Afficher les informations de l'élève
                                echo'<div class="row">';
                                echo'<div class="col-sm-5 col-md-6">';
                                echo '<div class=" text-dark">';
                                echo '<p>Nom : ' . $row['NOM'] . '</p>';
                                echo '<p>Prenom : ' . $row['PRENOM'] . '</p>';
                                echo '<p>Classe : ' . $row['NOMCLASSE'] . '</p>';
                                echo '<p>Adresse : ' . $row['ADRESSE'] . '</p>';
                                echo '<p>Année académique : ' . $row['ANNEACCADEMIQUE'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            
                                // Afficher le chemin de la photo pour le débogage
                                // echo '<p>Chemin de la photo : ' . $row['PHOTO'] . '</p>';
                                echo'<div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">';
                                echo '<img src="' . $row['PHOTO'] . '" alt="Photo de l\'élève" class="img-fluid mt-2" style="max-width: 150px; max-height: 150px; " />';
                                echo'</div>';
                                echo'</div>';

                            }
                        }                            
                        mysqli_close($congestschool);
                        ?>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
    </div>
   
  
    
    <script>
        document.getElementById('imprimerRecu').addEventListener('click', function () {
            window.print();
        });
    </script>
</body>
</html>
