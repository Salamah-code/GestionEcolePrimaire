<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $edtId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM emploidutemps WHERE NUMEROEDT = $edtId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    $emploidutemps = mysqli_fetch_assoc($result_salle);
    
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $jour = $_POST['jour'];
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE emploidutemps SET JOUR = '$jour', HDEBUT = '$debut',HFIN='$fin' WHERE NUMEROEDT = $edtId";
    if (mysqli_query($congestschool, $req_maj)) {
      echo "<script type=\"text/javascript\">
      alert(\"Modification réussie !\");
      window.location.href = './listeEDT.php';
    </script>";
      echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
    //   echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
  } else {
    echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeEDT.php';
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
            <div class="card-body ">
              <h5 class="text-center">FORMAULIARE DE MODIFICATION DE L'emploidutemps</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR L'EMARGEMENT</h5><br>
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $emploidutemps['NUMEROEDT']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">JOUR</label>
                <select name="jour" id="jour" class="form-control w-10">
                            <option <?php if ($emploidutemps['JOUR'] === 'Lundi') echo 'selected'; ?>>Lundi</option>
                            <option <?php if ($emploidutemps['JOUR'] === 'Mardi') echo 'selected'; ?>> Mardi</option>
                            <option <?php if ($emploidutemps['JOUR'] === 'Mercredi') echo 'selected'; ?>> Mercredi</option>
                            <option <?php if ($emploidutemps['JOUR'] === 'Jeudi') echo 'selected'; ?>>Jeudi</option>
                            <option <?php if ($emploidutemps['JOUR'] === 'Vendredi') echo 'selected'; ?>> Vendredi</option>
                             </select>
                 </div>
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> HEURE DEBUT </label>
                <input type="time" class="form-control" id="debut" name="debut" value="<?php echo $emploidutemps['HDEBUT']; ?>">
             </div>
        
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> HEURE FIN </label>
                <input type="time" class="form-control" id="fin" name="fin" value="<?php echo $emploidutemps['HFIN']; ?>">
            </div>
           
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeEDT.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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