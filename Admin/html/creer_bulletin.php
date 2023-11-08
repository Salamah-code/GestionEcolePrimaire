<!doctype html>
<html lang="en">
<?php 
include('header.php');
require_once 'connexion.php';
 if(isset($_GET['id'])){
  $selectedStudentId = isset($_GET['id']) ? $_GET['id'] : '';
 }

// Vérifiez si l'ID de l'élève est défini
// $selectedStudentId = isset($_POST['ideleve']) ? $_POST['ideleve'] : '';
?>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="MenuAdmin.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <?php include('nav.php') ?>
      </div>
    </aside>
    <div class="body-wrapper">
      <div class="container-fluid  ">
        <div class="container-fluid ">
          <div class="card">
            <nav class="card-body">
              <nav class="navbar navbar-light">
                <div class="container-fluid">
                </div>
              </nav><br>
              <h5 class="text-center">FORMULAIRE AJOUT BULLETIN</h5><br>
              <form action="traitementBulletin.php" method="post" >
              <input type='hidden' name='id' value='<?php echo $selectedStudentId; ?>'>
                              <div class="form-group col-6">
                  <label for="exampleInputEmail1" class="form-label">ELEVE</label>
                  <select name="eleve" class="form-control" disabled>
                    <?php
                      $req_eleves = "SELECT * FROM eleve";
                      $resultat_eleves = mysqli_query($congestschool, $req_eleves);
                      if ($resultat_eleves) {
                          while ($ligne_eleve = mysqli_fetch_assoc($resultat_eleves)) {
                              $ideleve = $ligne_eleve['IDELEVE'];
                              $matricule = $ligne_eleve['MATRICULE'];
                              $nom = $ligne_eleve['NOM'];
                              $prenom = $ligne_eleve['PRENOM'];
                              $selected = ($ideleve == $selectedStudentId) ? 'selected' : '';
                              echo "<option value='$ideleve' $selected>$matricule $nom $prenom</option>";
                          }
                      }
                    ?>
                  </select>
                </div>
                <input type='hidden' name='ideleve' value='<?php echo $selectedStudentId; ?>'>
                <div class="row">
                  <div class="form-group col-6">
                    <label for="exampleInputEmail1" class="form-label">ANNEE ACCADEMIQUE</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="txtannee">
                  </div>
                </div><br>
                <div class="form-group col-6">
                  <label for="exampleInputEmail1" class="form-label">TRIMESTRE</label>
                  <select class="form-select" aria-label="Default select example" name="trimestre">
                    <option value="1er trimestre" name="jour">1er trimestre</option>
                    <option value="2em trimestre" name="jour">2em trimestre</option>
                    <option value="3em trimestre" name="jour">3em trimestre</option>
                  </select>
                </div>
                </br>
                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                <button type="reset" class="btn btn-dark" onclick="annulerFormulaire()">Annuler</button>
              </form>

              <script>
                function annulerFormulaire() {
                    var formulaire = document.getElementById("monFormulaire");
                    formulaire.reset();
                    window.history.back();
                }
              </script>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('script.php') ?>
</body>
</html>
