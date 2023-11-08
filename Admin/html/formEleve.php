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
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">FORMAULIARE AJOUT ELEVES</h5><br>
              <?php
              
              $req_last_matricule = "SELECT MAX(MATRICULE) as last_matricule FROM eleve";
              $result_last_matricule = mysqli_query($congestschool, $req_last_matricule);
              $row_last_matricule = mysqli_fetch_assoc($result_last_matricule);
              $lastMatriculeFromDB = $row_last_matricule['last_matricule'];
              ?>
                <form action="traitementEleve.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">MATRICULE</label>
                        <input type="hidden" id="matriculeGenerator" name="txtmatricule">
                        <input type="text" class="form-control bg-light" id="matriculeDisplay" readonly>
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer le nom" required name="txtnom">
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PRENOM</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" required name="txtprenom">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">SEXE</label>
                        <div class="col-3">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" required name="txtsexe" id="membershipRadios1" value="HOMME" checked>
                              HOMME
                            </label>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" required name="txtsexe" id="membershipRadios2" value="FEMME">
                              FEMME
                            </label>
                          </div>
                        </div><br>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label" >DATE DE NAISSANCE</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" required name="txtdatenaiss">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">LIEU DE NAISSANCE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" required placeholder="Entrer le lieu de naissance" name="txtlieu">
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PHOTO</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" name="txtphoto">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">ADRESSE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" required placeholder="Entrer l'adresse" name="txtadresse">
                      </div>
                    </div><br><br>
                    <h5 class="text-center bg-light">INFORMATIONS DU TUTEUR</h5>
                    <br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM DU TUTEUR</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" required name="txtnomtuteur">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PRENOM DU TUTEUR</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" required placeholder="" name="txtprenomtuteur">
                      </div>
                    </div><br>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">TELEPHONE DU TUTEUR</label>
                      <input type="text" class="form-control" id="exampleInputPassword1" required name="txttelephonetuteur">
                    </div><br>
                    <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                    <button type="rest" class="btn btn-dark">Annuler</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('script.php') ?>

  <script>
    window.onload = function() {
      // Utilise le dernier matricule récupéré depuis la base de données
      var lastMatriculeFromDB = "<?php echo $lastMatriculeFromDB; ?>";
      var lastNumber = parseInt(lastMatriculeFromDB.substring(2));
      var newMatricule = 'EL' + ('00' + (lastNumber + 1)).slice(-3);

      // Affichez la nouvelle valeur du MATRICULE.
      var matriculeDisplay = document.getElementById('matriculeDisplay');
      var matriculeGenerator = document.getElementById('matriculeGenerator');
      matriculeDisplay.value = newMatricule;
      matriculeGenerator.value = newMatricule;
    };
  </script>

</body>

</html>