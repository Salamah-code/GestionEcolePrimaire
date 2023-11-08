<?php
require_once 'connexion.php';

// Récupérer la liste des élèves depuis la base de données
$req_eleves = "SELECT * FROM eleves";
$result_eleves = mysqli_query($congestschool, $req_eleves);

if (isset($_GET['id'])) {
    $inscriptionId = $_GET['id'];
    
    // Récupérer les détails de l'inscription à partir de la base de données
    $req_inscription = "SELECT * FROM inscription WHERE NUMERO = $inscriptionId";
    $result_inscription = mysqli_query($congestschool, $req_inscription);
    $inscription = mysqli_fetch_assoc($result_inscription);
}

if (isset($_POST['submit'])) {
    // Traitement des données soumises depuis le formulaire de modification
    $ideleve=$_POST['ideleve'];
    $date = $_POST['date'];
    $montant = $_POST['montant'];
    $details = $_POST['libelle'];
   
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE inscription SET IDELEVE_INSC='$ideleve' , DATE = '$date', MONTANTPAYE = '$montant', DETAILS = '$details' WHERE NUMERO = $inscriptionId";
    if (mysqli_query($congestschool, $req_maj)) {
        echo "<script type=\"text/javascript\">
              alert(\"Modification réussie !\");
              window.location.href = './listeinscription.php';
            </script>";
        echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
    } else {
        echo "<script type=\"text/javascript\">
            alert(\"Échec de la modification.\");
            window.location.href = './listeInscription.php';
          </script>";
        echo '<div class="alert alert-danger" role="alert">Échec de la modification.</div>';
    }
}
?>

<!doctype html>
<html lang="en">
<?php include('header.php'); ?>

<body>
  <!--  Body Wrapper -->
  <!-- ... (le reste de votre code HTML) ... -->
</body>

</html>



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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION DE CLASSE</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR LA CLASSE</h5><br>
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $inscription['NUMERO']; ?>">
            </div>
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> ELEVE </label>
                <input type="text" class="form-control" id="ideleve" name="ideleve" value="<?php echo $inscription['IDELEVE_INSC']; ?>">
             </div>
            
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DATE </label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $inscription['DATE']; ?>">
             </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant" name="montant" value="<?php echo $inscription['MONTANTPAYE']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DETAILS </label>
                <input type="text" class="form-control" id="libelle" name="libelle" value="<?php echo $inscription['DETAILS']; ?>">
            </div>
           
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeInscription.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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