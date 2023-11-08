<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $affectId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM affectation WHERE IDAFFECTATION = $affectId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    $classe = mysqli_fetch_assoc($result_salle);
    
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $ideleve = $_POST['ideleve'];
    $idclasse = $_POST['idclasse'];
    $idenseignant = $_POST['idenseignant'];
    $date = $_POST['date'];
    
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE affectation SET ID_ELEVE = '$ideleve', ID_CLASSE = '$idclasse',ID_ENSIGNANT='$idenseignant',date_affectation='$date' WHERE IDAFFECTATION = $affectId";
    if (mysqli_query($congestschool, $req_maj)) {
      echo "<script type=\"text/javascript\">
      alert(\"Modification réussie !\");
      window.location.href = './listeAffectation.php';
    </script>";
  } else {
    echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeAffectation.php';
      </script>";
      echo '<div class="alert alert-danger" role="alert">Échec de la modification.</div>';
 }
}
?>
<!doctype html>
<html lang="en">
<?php include('header.php');
// require_once 'connexion.php';
// ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
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
              <h5 class="text-center">MODIFICATION DES AFFECTATIONS</h5><br>
              
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idaffectation">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $classe['IDAFFECTATION']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> ELEVE </label>
                <input type="number" class="form-control" id="libelle" name="ideleve" value="<?php echo $classe['ID_ELEVE']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">CLASSE</label>
                <input type="number" class="form-control" id="niveau" name="idclasse" value="<?php echo $classe['ID_CLASSE']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label">ENSEIGNANT</label>
                <input type="number" class="form-control" id="annee" name="idenseignant" value="<?php echo $classe['ID_ENSIGNANT']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">EFFECTIF</label>
                <input type="date" class="form-control" id="effectif" name="date" value="<?php echo $classe['date_affectation']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeAffectation.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
        </form>
    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>



</html>