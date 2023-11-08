<?php
require_once 'connexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id'])) {
  $bulletinId = $_GET['id'];

  // Récupérer les détails du bulletin à partir de la base de données
  $req_bulletin = "SELECT * FROM bulletin WHERE IDBULLETIN = $bulletinId";
  $result_bulletin = mysqli_query($congestschool, $req_bulletin);
  $bulletin = mysqli_fetch_assoc($result_bulletin);

  // Récupérer les informations de l'élève associé à ce bulletin
  $ideleve_bulletin = $bulletin['IDELEVE_BUL'];
  $req_eleve = "SELECT * FROM eleve WHERE IDELEVE = $ideleve_bulletin";
  $result_eleve = mysqli_query($congestschool, $req_eleve);
  $eleve = mysqli_fetch_assoc($result_eleve);
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $ideleve = $_POST['ideleve'];
    $annee = $_POST['annee'];
    $trimestre = $_POST['trimestre'];

    // Vérifier s'il existe déjà un bulletin pour cet élève et ce trimestre
    $req_verification = "SELECT COUNT(*) AS count FROM bulletin WHERE IDELEVE_BUL = '$ideleve' AND TRIMESTRE = '$trimestre'";
    $result_verification = mysqli_query($congestschool, $req_verification);
    $row_verification = mysqli_fetch_assoc($result_verification);
    $count = intval($row_verification['count']);

    if ($count > 0) {
        echo "<script type=\"text/javascript\">
            alert(\"Cet élève a déjà un bulletin pour ce trimestre !\");
            window.location.href = './listeBulletin.php';
        </script>";
        exit;
    }

    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE bulletin SET IDELEVE_BUL = '$ideleve', ANNEESCOLAIRE = '$annee' , TRIMESTRE='$trimestre' WHERE IDBULLETIN = $bulletinId";
    if (mysqli_query($congestschool, $req_maj)) {
        echo "<script type=\"text/javascript\">
            alert(\"Modification réussie !\");
            window.location.href = './listeBulletin.php';
        </script>";
    } else {
        echo "<script type=\"text/javascript\">
            alert(\"Échec de la modification.\");
            window.location.href = './listeBulletin.php';
        </script>";
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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION D'UN BULLETIN</h5><br>
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS SUR LE BULLETIN</h5><br>
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $bulletin['IDBULLETIN']; ?>">
            </div>
            <div class="mb-3">
    <label for="ideleve" class="form-label">ELEVE</label>
    <select name="ideleve" id="ideleve" class="form-control">
        <?php
        include 'connexion.php';
        $req_select = "SELECT * FROM eleve";
        $resultat2 = mysqli_query($congestschool, $req_select);
        while ($ligne = mysqli_fetch_assoc($resultat2)) {
            $ideleve = $ligne['IDELEVE'];
            $matricule = $ligne['MATRICULE'];
            $no = $ligne['NOM'];
            $preno = $ligne['PRENOM'];
            $selected = ($ideleve == $bulletin['IDELEVE_BUL']) ? "selected" : "";
            ?>
            <option value="<?php echo $ideleve; ?>" <?php echo $selected; ?>>
                <?php echo $matricule . ' ' . $no . ' ' . $preno; ?>
            </option>
        <?php
        }
        ?>
    </select>
</div>
    <div class="mb-3">  
             <label for="nouvelle_capacite" class="form-label">TRIMESTRE</label>
                <select name="trimestre" id="trimestre" class="form-control w-10">
                 <option value="1er trimestre" <?php if ($bulletin['TRIMESTRE'] === '1er trimestre') echo 'selected'; ?>>Trimestre 1</option>
                 <option value="2em trimestre" <?php if ($bulletin['TRIMESTRE'] === '2em trimestre') echo 'selected'; ?>>Trimestre 2</option>
                 <option value="3em trimestre" <?php if ($bulletin['TRIMESTRE'] === '3em trimestre') echo 'selected'; ?>>Trimestre 3</option>
                </select> 
            </div>
            <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> ANNEE SCOLAIRE</label>
                <input type="text"  class="form-control" id="annee" name="annee" value="<?php echo $bulletin['ANNEESCOLAIRE']; ?>">
                </div>
            </div>
          </div>
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <button type="reset" class="btn btn-dark" onclick="customReset()">Annuler</button>
                      </div>                  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
  function customReset() {

  document.getElementById("myForm").reset();
   }
</script>
</body>



</html>