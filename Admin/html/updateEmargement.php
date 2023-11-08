<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $emargementId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM emargement WHERE ID = $emargementId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    $emargement = mysqli_fetch_assoc($result_salle);
    
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $heure = $_POST['heure'];
    $date = $_POST['date'];
    $annee = $_POST['annee'];
    $trimestre=$_POST['trimestre'];
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE emargement SET HEURE = '$heure', DATE = '$date',TRIMESTRE='$trimestre', annee='$annee' WHERE ID = $emargementId";
    if (mysqli_query($congestschool, $req_maj)) {
      echo "<script type=\"text/javascript\">
      alert(\"Modification réussie !\");
      window.location.href = './listeEmargement.php';
    </script>";
      echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
    //   echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
  } else {
    echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeEmargement.php';
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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION DE L'EMARGEMENT</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR L'EMARGEMENT</h5><br>
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $emargement['ID']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">HEURE</label>
                <input type="number" class="form-control" id="heure" name="heure" value="<?php echo $emargement['HEURE']; ?>">
            </div>
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DATE </label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $emargement['DATE']; ?>">
             </div>
            
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">TRIMESTRE</label>
                <select name="trimestre" id="trimestre" class="form-control w-10">
                 <option value="Trimestre 1" <?php if ($emargement['TRIMESTRE'] === 'Trimestre 1') echo 'selected'; ?>>Trimestre 1</option>
                 <option value="Trimestre 2" <?php if ($emargement['TRIMESTRE'] === 'Trimestre 2') echo 'selected'; ?>>Trimestre 2</option>
                 <option value="Trimestre 3" <?php if ($emargement['TRIMESTRE'] === 'Trimestre 3') echo 'selected'; ?>>Trimestre 3</option>
                </select> 
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> ANNEE </label>
                <input type="text" class="form-control" id="annee" name="annee" value="<?php echo $emargement['ANNEE']; ?>">
            </div>
           
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeEmargement.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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