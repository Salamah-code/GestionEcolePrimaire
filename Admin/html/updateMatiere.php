<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $matiereId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM matiere WHERE IDMATIERE = $matiereId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    $matiere = mysqli_fetch_assoc($result_salle);
    
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification\
    $idclasse=  $_POST['idclasse'];
    $libelle = $_POST['libelle'];
    $coef = $_POST['coef'];
   
    
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE matiere SET  LIBELLE = '$libelle', COEFFICIENT = '$coef', ID_CLASS_MAT ='$idclasse' WHERE IDMATIERE = $matiereId";
    if (mysqli_query($congestschool, $req_maj)) {
      echo "<script type=\"text/javascript\">
      alert(\"Modification réussie !\");
      window.location.href = './listeMatiere.php';
    </script>";
      echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
    //   echo '<div class="alert alert-success" role="alert">Modification réussie !</div>';
  } else {
    echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeMatiere.php';
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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION DE CLASSE</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR LA CLASSE</h5><br>
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $matiere['IDMATIERE']; ?>">
            </div>
            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">CLASSE</label>
                        
                        <select name="idclasse" id='idclasse' class="form-control">
                              
                         <?php
                        include 'connexion.php';
                        $req_select = "SELECT * from classe ";
                        $resultat2 = mysqli_query($congestschool, $req_select);
                        $nbr2 = mysqli_num_rows($resultat2);

                                while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                     $idclasse= $ligne['IDCLASSE'];
                                     $clas= $ligne['NOMCLASSE'];
                                  ?>   <option value="<?php echo $idclasse ?>">
                                         <?php echo  $clas;  }
                                
                               
                         ?>
                          </option>
                         </select>
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> LIBELLE </label>
                <input type="text" class="form-control" id="libelle" name="libelle" value="<?php echo $matiere['LIBELLE']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">COEFFICIENT</label>
                <input type="number" class="form-control" id="coef" name="coef" value="<?php echo $matiere['COEFFICIENT']; ?>">
            </div>
           
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeMatiere.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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