<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $salleId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM salle WHERE IDSALLE = $salleId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    $salle = mysqli_fetch_assoc($result_salle);
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $nouveauNom = $_POST['nouveau_nom'];
    $nouvelleCapacite = $_POST['nouvelle_capacite'];
    
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE salle SET NOMSALLE = '$nouveauNom', CAPACITE = '$nouvelleCapacite' WHERE IDSALLE = $salleId";
    if (mysqli_query($congestschool, $req_maj)) {
      echo "<script type=\"text/javascript\">
      alert(\"Modification réussie !\");
      window.location.href = './listeSalle.php';
    </script>";
      echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
    //   echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
  } else {
    echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeSalle.php';
      </script>";
    //   echo '<div class="alert alert-danger" role="alert">Échec de la modification.</div>';
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
              <h5 class="text-center">FORMAULIARE AJOUT SALLE</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR LA SALLE</h5><br>
                  <form method="post">
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label">Nouveau nom de la salle</label>
                <input type="text" class="form-control" id="nouveau_nom" name="nouveau_nom" value="<?php echo $salle['NOMSALLE']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">Nouvelle capacité</label>
                <input type="number" class="form-control" id="nouvelle_capacite" name="nouvelle_capacite" value="<?php echo $salle['CAPACITE']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
                    <!-- <button type="rest" class="btn btn-dark">Annuler</button> -->
                    <a href="listeSalle.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>

    
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