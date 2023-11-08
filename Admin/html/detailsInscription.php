
<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>

<body>
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
    <div class="body-wrapper">

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4 text-center">LISTE DES ELEVES</h5>
                <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                              
                                <th scope="col">MATRICULE</th>
                                <th scope="col">NOM ELEVE</th>
                                <th scope="col">PRENOM ELEVE</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              require_once 'connexion.php';

                              if (isset($_GET['id'])) {
                                  $eleveId = $_GET['id'];
                              
                                  // Échappez la valeur $eleveId pour prévenir les injections SQL
                                  $eleveId = mysqli_real_escape_string($congestschool, $eleveId);
                                        
                                        $req_jointure = "
                                        SELECT eleve.*
                                        FROM eleve where IDELEVE=$eleveId ";


                            
                                    $resultat_jointure = mysqli_query($congestschool, $req_jointure);
                                    while ($row = mysqli_fetch_assoc($resultat_jointure)) {
                                            echo "<tr>
                                               <td>{$row['MATRICULE']}</td>
                                                <td>{$row['NOM']}</td>
                                                <td>{$row['PRENOM']}</td>
                                            
                                            </tr>";
                                }
                            }
                        

                            mysqli_close($congestschool);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
