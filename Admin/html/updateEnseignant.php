<?php
require_once 'connexion.php';

$enseignant = array();

if (isset($_GET['id'])) {
    $enseignantId = $_GET['id'];
    $req_enseignant = "SELECT * FROM enseignant WHERE IDENSEIGNANT = $enseignantId";
    $result_enseignant = mysqli_query($congestschool, $req_enseignant);
    $enseignant = mysqli_fetch_assoc($result_enseignant);
}

if (isset($_POST['submit'])) {
    // Récupération des champs du formulaire
    $txtnom = $_POST['txtnom'];
    $txtprenom = $_POST['txtprenom'];
    $txtemail = $_POST['txtemail'];
    $txttel = $_POST['txttel'];
    $txtnation = $_POST['txtnation'];

    // Gestion du fichier

    if (!empty($_FILES['txtfichier']['name'])) {
      $targetDirectory = 'fichiers/';
      $targetFile = $targetDirectory . basename($_FILES['txtfichier']['name']);
      $fileExtension = strtolower(pathinfo($_FILES['txtfichier']['name'], PATHINFO_EXTENSION));
      
      $allowedExtensions = array('pdf', 'docx');
      if (!in_array($fileExtension, $allowedExtensions)) {
          echo "<script type=\"text/javascript\">
              alert(\"Erreur d'extension, utilisez une extension valide pdf ou docx !\");
              window.location.href = './listeEnseignants.php';
          </script>";
          exit; // Sortie du script en cas d'extension non valide
      }
  
      if (move_uploaded_file($_FILES['txtfichier']['tmp_name'], $targetFile)) {
          // Le téléchargement du fichier est réussi
      } else {
          echo "Une erreur s'est produite lors du téléchargement du fichier.";
      }
  }
  
    // Mise à jour de la base de données
    $req_update = "UPDATE enseignant SET NOMENSEIGNANT = '$txtnom', PRENNOMENSEIGNANT = '$txtprenom', EMAIL = '$txtemail', TEL = '$txttel', 
            PHOTO = '$targetFile', NATIONNALITE = '$txtnation' WHERE IDENSEIGNANT = '$enseignantId'";

    if (mysqli_query($congestschool, $req_update)) {
        echo "<script type=\"text/javascript\">
            alert(\"Modification réussie !\");
            window.location.href = './listeEnseignants.php';
        </script>";
    } else {
        echo "<script type=\"text/javascript\"> 
            alert(\"Échec de la modification.\");
            window.location.href = './listeEnseignants.php';
        </script>";
    }
}
?>
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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION D'UN ENSEIGNANTS</h5><br>
              
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center bg-light">INFORMATIONS DE L'ENSEIGNANTS</h5><br>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">MATRICULE</label>
                        <input type="hidden" id="matriculeGenerator" name="txtmatricule">
                        <input type=" " class="form-control bg-light" id="matricule" readonly   
                        value="<?php echo $enseignant['MATRICULE'];?>">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer le nom" required name="txtnom"
                        value="<?php echo $enseignant['NOMENSEIGNANT'];?>">
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">PRENOM</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtprenom"
                        value="<?php echo $enseignant['PRENNOMENSEIGNANT'];?>">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="txtemail"
                        value="<?php echo $enseignant['EMAIL'];?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">TELEPHONE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txttel"
                        value="<?php echo $enseignant['TEL'];?>">
                      </div>
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NATIONNALITE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer votre nationnalité" name="txtnation"
                        value="<?php echo $enseignant['NATIONNALITE'];?>">
                      </div>
                    </div><br>
                    <div class="row">
                      <label for="exampleInputEmail1" class="form-label">CNI actuelle</label>
                      <p><a href="<?php echo $enseignant['PHOTO']; ?>" target="_blank">Télécharger la CNI actuelle</a></p>
                      <input type="hidden" name="document_actuel" value="<?php echo $enseignant['PHOTO']; ?>">
                  </div><br>

                  <!-- Ajoutez ceci pour le champ d'upload -->
                  <div class="row">
                      <label for="exampleInputEmail1" class="form-label">Nouvelle CNI: Joindre un fichier</label>
                      <input type="file" class="form-control" id="exampleInputEmail1" name="txtfichier">
                  </div><br>
                      <button type="submit" class="btn btn-primary" name="submit">Valider</button>
                      <a href="listeEnseignants.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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
