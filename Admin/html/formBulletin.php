
<!doctype html>
<html lang="en">
<?php include('header.php');
require_once 'connexion.php';
?>

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
      <div class="container-fluid  ">
       <div class="container-fluid ">
       <div class="card">
       <nav class="card-body">
            <nav class="navbar navbar-light">
            <div class="container-fluid">
              <form class="d-flex" method="post">

            <select name="classe" id="classe" class="form-control">
        <option value="">Sélectionnez une classe</option>
        <?php
        // Récupérez la liste des classes depuis votre base de données
        $req_classes = "SELECT IDCLASSE, NOMCLASSE, ANNEACCADEMIQUE FROM classe";
        $result_classes = mysqli_query($congestschool, $req_classes);

        if ($result_classes) {
            while ($row_classe = mysqli_fetch_assoc($result_classes)) {
                echo '<option value="' . $row_classe['IDCLASSE'] . '">' . $row_classe['NOMCLASSE'] . ' ' . $row_classe['ANNEACCADEMIQUE'] . '</option>';
            }
        }
        ?>
    </select>
    <button class="btn btn-outline-info" name="action" type="submit">Search</button>
    </form>
            </div>
          </nav><br>
             <?php
                        include 'connexion.php';
                        if (isset($_POST['classe']) && !empty($_POST['classe'])) {
                          // Utilisez la valeur de la classe sélectionnée pour filtrer les élèves
                          $classe = $_POST['classe'];
                        ?>
              <h5 class="text-center">FORMAULIARE AJOUT BULLETIN</h5><br>
              <form action="traitementBulletin.php" method="post" >
            
                  <div class="row">
                    <div class="form-group col-6">
                    <label for="exampleInputEmail1" class="form-label">ELEVE</label>
                        <select name="ideleve" id='ideleve' class="form-control"> 
                        <option value="">Sélectionnez un élève</option>
                         <?php
                          $req_eleves = "SELECT*
                              FROM eleve E
                              JOIN inscription I ON E.IDELEVE = I.IDELEVE_INSC
                               JOIN classe C ON I.IDCLASSE_INSC = C.IDCLASSE
                              WHERE C.IDCLASSE = '$classe'";
                          
                          $resultat_eleves = mysqli_query($congestschool, $req_eleves);
                          
                          if ($resultat_eleves) {
                              while ($ligne_eleve = mysqli_fetch_assoc($resultat_eleves)) {
                                  $ideleve = $ligne_eleve['IDELEVE'];
                                  $matricule = $ligne_eleve['MATRICULE'];
                                  $nom = $ligne_eleve['NOM'];
                                  $prenom = $ligne_eleve['PRENOM'];                                 
                                  echo '<option value="' . $ideleve . '">' . $matricule . ' ' . $nom . ' ' . $prenom . '</option>';
                              }
                          }
                        
                      ?>
                  </select>
                </div>
                </div><br> 
                     
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">ANNEE ACCADEMIQUE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtannee">
                      </div>
                     
                    </div><br>
                    <div class="form-group col-6">
                    <label for="exampleInputEmail1" class="form-label">TRIMESTRE</label>
                     <select class="form-select" aria-label="Default select example" name="trimestre">
                            
                            <option value="1er trimestre" name="jour"> 1er trimestre</option>
                            <option value="2em trimestre" name="jour">2em trimestre</option>
                            <option value="3em trimestre" name="jour"> 3em trimestre</option>
                          
                    </select>
                   </div>
                </br>
                    <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                    <button type="reset" class="btn btn-dark" onclick="annulerFormulaire()">Annuler</button>
                
                  </form>
                  <?php
                  }
                  ?>

                  <script>
        function annulerFormulaire() {
            // Récupérer le formulaire
            var formulaire = document.getElementById("monFormulaire");

            // Réinitialiser les champs du formulaire
            formulaire.reset();

            // Rediriger vers la page précédente
            window.history.back();
        }
    </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('script.php') ?>



</body>

</html>