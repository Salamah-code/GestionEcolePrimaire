<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $classeId = $_GET['id'];
    
    $req_classe = "SELECT  A.*,C.*, E.* ,ELEVE.* 
                      FROM affectation A
                      JOIN classe C ON  A.ID_CLASSE = C.IDCLASSE 
                      JOIN enseignant E ON E.IDENSEIGNANT = A.ID_ENSIGNANT
                      JOIN eleve ELEVE ON A.ID_ELEVE = ELEVE.IDELEVE
                      WHERE IDAFFECTATION  = $classeId";

    $result_classe = mysqli_query($congestschool, $req_classe);
    if (!$result_classe) {
        die("Erreur SQL: " . mysqli_error($congestschool));
    }
    
} else {
    $error_message = "ID de classe non spécifié.";
}
?>

<!DOCTYPE html>
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
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <nav class="navbar navbar-light">
            <div class="container-fluid">
              <form class="d-flex" method="post">
                <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search" style="width:500px;">
                <button class="btn btn-outline-info" name="action" type="submit">Search</button>
              </form>
            </div>
          </nav><br>
          <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4 text-center">DETAILS DES CLASSES</h5>
                <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
                <div class="table-responsive">
               
                 
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">                             
                                <th scope="col">NIVEAU</th>
                                <th scope="col">Nom Enseignant</th>
                                <th scope="col">Prenom Enseignant</th>
                                <th scope="col">Nom Eleve</th>
                                <th scope="col">Prenom Eleve</th> 
                                <th scope="col">Nom Classe</th> 

                        
                               
                            </tr>
                        </thead>
                        <tbody>

                  <?php
                            if (isset($result_classe)) {
                                while ($classe = mysqli_fetch_assoc($result_classe)) {
                                    echo "<tr>";                                  
                                    echo "<td>" . $classe['NIVEAU'] . "</td>";
                                    echo "<td>" . $classe['NOMENSEIGNANT'] . "</td>";
                                    echo "<td>" . $classe['PRENNOMENSEIGNANT'] . "</td>";
                                    echo "<td>" . $classe['NOM'] . "</td>";
                                    echo "<td>" . $classe['PRENOM'] . "</td>";                          
                                    echo "<td>" . $classe['NOMCLASSE'] . "</td>";                          
                                    echo "</tr>";
                                }
                            } elseif (isset($error_message)) {
                                echo "<tr><td colspan='9'>$error_message</td></tr>";
                            }
                            ?>
                            </tbody>
                </table>
              </div><br>
     <button class="btn btn-primary p-2 mb-4  fs-3"><a href="listeclasses.php" class="fw-bold text-light">Retour à la liste des classes</a></button><br/>

             </div>
          </div>
        </div>
      </div>
    </div>

    </body>
</html>