<?php
require_once 'connexion.php';

$eleve = array();
$errorMessage = "";

if (isset($_GET['id'])) {
    $eleveId = $_GET['id'];
    $req_eleve = "SELECT * FROM eleve WHERE IDELEVE = $eleveId";
    $result_eleve = mysqli_query($congestschool, $req_eleve);
    $eleve = mysqli_fetch_assoc($result_eleve);
}

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $txtnom = $_POST['txtnom'];
    $txtprenom = $_POST['txtprenom'];
    $txtsexe = $_POST['txtsexe'];
    $txtdatenaiss = $_POST['txtdatenaiss'];
    $txtlieu = $_POST['txtlieu'];
    $txtadresse = $_POST['txtadresse'];
    $txtnomtuteur = $_POST['txtnomtuteur'];
    $txtprenomtuteur = $_POST['txtprenomtuteur'];
    $txttelephonetuteur = $_POST['txttelephonetuteur'];

    // Traitement de la nouvelle image si elle est fournie
    if (!empty($_FILES['txtphoto']['name'])) {
        $targetDirectory = 'images/';
        $targetFile = $targetDirectory . basename($_FILES['txtphoto']['name']);
        $fileExtension = strtolower(pathinfo($_FILES['txtphoto']['name'], PATHINFO_EXTENSION));

        $extensions_valides = array('jpg', 'jpeg', 'png');
        if (!in_array($fileExtension, $extensions_valides)) {
            $errorMessage = "Erreur d'extension, utilisez une extension valide jpg, jpeg ou png !";
        } elseif (move_uploaded_file($_FILES['txtphoto']['tmp_name'], $targetFile)) {
            // Supprimer l'ancienne image si elle existe
            if (!empty($eleve['PHOTO'])) {
                unlink($eleve['PHOTO']); // Supprime l'ancienne image du serveur
            }

            // Mettre à jour le chemin de la nouvelle image dans la base de données
            $req_update = "UPDATE eleve SET NOM = '$txtnom', PRENOM = '$txtprenom', SEXE='$txtsexe', DATE_DE_NAISSANCE = '$txtdatenaiss', LIEU_DE_NAISSANCE='$txtlieu', PHOTO='$targetFile', ADRESSE='$txtadresse', NOM_TUTEUR='$txtnomtuteur', PRENOM_TUTEUR='$txtprenomtuteur', TEL_TUTEUR='$txttelephonetuteur' WHERE IDELEVE='$eleveId'";
        } else {
            $errorMessage = "Une erreur s'est produite lors du téléchargement du fichier.";
        }
    } else {
        // Pas de nouvelle image, mise à jour des autres données
        $req_update = "UPDATE eleve SET NOM = '$txtnom', PRENOM = '$txtprenom', SEXE='$txtsexe', DATE_DE_NAISSANCE = '$txtdatenaiss', LIEU_DE_NAISSANCE='$txtlieu', ADRESSE='$txtadresse', NOM_TUTEUR='$txtnomtuteur', PRENOM_TUTEUR='$txtprenomtuteur', TEL_TUTEUR='$txttelephonetuteur' WHERE IDELEVE='$eleveId'";
    }

    // Exécuter la requête de mise à jour
    if (mysqli_query($congestschool, $req_update)) {
        // Redirection en cas de succès
        header("Location: listeEleves.php");
        exit();
    } else {
        // Message en cas d'échec
        $errorMessage = "Échec de la mise à jour.";
    }
}
?>

<!doctype html>
<html lang="en">
<?php include('header.php') ?>

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
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS DE L'ELEVE</h5><br>
                     <form method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">MATRICULE</label>
                        <input type="hidden" id="matriculeGenerator" name="txtmatricule">
                        <input type=" " class="form-control bg-light" id="matricule" readonly
                        value="<?php echo $eleve['MATRICULE'];?>">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM</label>
                        <input type="text" class="form-control" id="txtnom"  
                        name="txtnom"  value="<?php echo $eleve['NOM'];?>">
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PRENOM</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtprenom"
                        value='<?php  echo $eleve["PRENOM"];?>'>
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">SEXE</label>
                        <div class="col-3">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="txtsexe" id="membershipRadios1" value="HOMME" checked
                              >
                              HOMME
                            </label>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="txtsexe" id="membershipRadios2" value="FEMME"
                              >
                              FEMME
                            </label>
                          </div>
                        </div><br>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">DATE DE NAISSANCE</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" name="txtdatenaiss"
                        value='<?php  echo $eleve["DATE_DE_NAISSANCE"];?>'>
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">LIEU DE NAISSANCE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer le lieu de naissance" 
                        name="txtlieu"  value='<?php  echo $eleve["LIEU_DE_NAISSANCE"];?>'>
                      </div>
                    </div><br>
                    <div class="row">
  
                    <div class="form-group col-6">
                    <label for="exampleInputEmail1" class="form-label">NOUVELLE PHOTO</label>
                      <input type="file" class="form-control" id="exampleInputEmail1" name="txtphoto">      
                       <img src="<?php echo $eleve['PHOTO']; ?>"width=60px >
   
</div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">ADRESSE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer l'adresse"
                         name="txtadresse"  value='<?php  echo $eleve["ADRESSE"];?>'>
                      </div>
                    </div><br><br>
                    <h5 class="text-center bg-light">INFORMATIONS DU TUTEUR</h5>
                    <br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM DU TUTEUR</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtnomtuteur"
                        value='<?php  echo $eleve["NOM_TUTEUR"];?>'>
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PRENOM DU TUTEUR</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="txtprenomtuteur"
                        value='<?php  echo $eleve["PRENOM_TUTEUR"];?>'>
                      </div>
                    </div><br>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">TELEPHONE DU TUTEUR</label>
                      <input type="text" class="form-control" id="exampleInputPassword1" name="txttelephonetuteur"
                      value='<?php  echo $eleve["TEL_TUTEUR"];?>'>
                    </div><br>
                    <button type="submit" class="btn btn-primary" name="submit">Valider</button>
                    <a href="listeEleves.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
  include('script.php') ?>

  <script>
        window.onload = function() {
            var lastMatriculeFromDB = "<?php echo $lastMatriculeFromDB; ?>";
            var lastNumber = parseInt(lastMatriculeFromDB.substring(2));
            var newMatricule = 'EL' + ('00' + (lastNumber + 1)).slice(-3);

            var matriculeDisplay = document.getElementById('matriculeDisplay');
            var matriculeGenerator = document.getElementById('matriculeGenerator');
            matriculeDisplay.value = newMatricule;
            matriculeGenerator.value = newMatricule;
        };
        function customReset() {

document.getElementById("myForm").reset();
 }
    </script>
</body>

</html>





