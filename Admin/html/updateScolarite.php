<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $scolariteId = $_GET['id'];
    
    // Récupérer les détails de la salle à partir de la base de données
    $req_salle = "SELECT * FROM paiementscoloarite WHERE IDPAIEMENT = $scolariteId";
    $result_salle = mysqli_query($congestschool, $req_salle);
    
    // Vérifier si la requête a réussi
    if (!$result_salle) {
        die('Erreur de requête : ' . mysqli_error($congestschool));
    }
    
    $paiementscolaire = mysqli_fetch_assoc($result_salle);
    
}

if (isset($_POST['submit'])) {
    // Traiter les données soumises depuis le formulaire de modification
    $date = $_POST['date'];
    $montant = $_POST['montant'];
    $mois = $_POST['mois'];
    $motif = $_POST['motif'];
    $mode = $_POST['mode'];
    $details= $_POST['detail'];
    
    // Effectuer la mise à jour dans la base de données
    $req_maj = "UPDATE paiementscoloarite SET DATEPAIEMENT = '$date', MONTANTPAIEMENT = '$montant' , MOIS='$mois', MOTIF='$motif' , MODEPAIEMENT='$mode' , DETAILS='$details' WHERE IDPAIEMENT = $scolariteId";
    
    if (mysqli_query($congestschool, $req_maj)) {
        echo "<script type=\"text/javascript\">
        alert(\"Modification réussie !\");
        window.location.href = './listeScolarite.php';
        </script>";
    } else {
        echo "<script type=\"text/javascript\">
        alert(\"Échec de la modification.\");
        window.location.href = './listeScolarite.php';
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
              <h5 class="text-center">FORMAULIARE DE MODIFICATION DE L'paiementscolaire</h5><br>
            
              
                  <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">IDENTIFIANT</label>
                        <input type="hidden" id="matriculeGenerator" name="idmatiere">
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $paiementscolaire['IDPAIEMENT']; ?>">
            </div>
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DATE </label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $paiementscolaire['DATEPAIEMENT']; ?>">
             </div>
             <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">MONTANT</label>
                <input type="number" class="form-control" id="montant" name="montant" value="<?php echo $paiementscolaire['MONTANTPAIEMENT']; ?>">
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">MOIS</label>
                <select name="mois" id="mois" class="form-control w-10">
                 <option value="Janvier" <?php if ($paiementscolaire['MOIS'] === 'Janvier') echo 'selected'; ?>>Janvier</option>
                 <option value="Février" <?php if ($paiementscolaire['MOIS'] === 'Février') echo 'selected'; ?>>Février</option>
                 <option value="Mars" <?php if ($paiementscolaire['MOIS'] === 'Mars') echo 'selected'; ?>>Mars</option>
                 <option value="Avril" <?php if ($paiementscolaire['MOIS'] === 'Avril') echo 'selected'; ?>>Avril</option>
                 <option value="Mai" <?php if ($paiementscolaire['MOIS'] === 'Mai') echo 'selected'; ?>>Mai</option>
                 <option value="Juin" <?php if ($paiementscolaire['MOIS'] === 'Juin') echo 'selected'; ?>>Juin</option>
                  <option value="Octobre" <?php if ($paiementscolaire['MOIS'] === 'Octobre') echo 'selected'; ?>>Octobre</option>
                 <option value="Novembre" <?php if ($paiementscolaire['MOIS'] === 'Novembre') echo 'selected'; ?>>Novembre</option>
                 <option value="Décembre" <?php if ($paiementscolaire['MOIS'] === 'Décembre') echo 'selected'; ?>>Décembre</option>
                </select> 
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">MOTIF DE PAIEMENT</label>
                <select name="motif" id="motif" class="form-control w-10">
                 <option value="Inscription" <?php if ($paiementscolaire['MOTIF'] === 'Inscription') echo 'selected'; ?>>Inscription</option>
                 <option value="Reinscription" <?php if ($paiementscolaire['MOTIF'] === 'Reinscription') echo 'selected'; ?>>Reinscription</option>
                 <option value="Mensualite" <?php if ($paiementscolaire['MOTIF'] === 'Mensualite') echo 'selected'; ?>>Mensualite</option>
                 <option value="Cantine" <?php if ($paiementscolaire['MOTIF'] === 'Cantine') echo 'selected'; ?>>Cantine</option>
                 <option value="Transport" <?php if ($paiementscolaire['MOTIF'] === 'Transport') echo 'selected'; ?>>Transport</option>
                </select> 
            </div>
            <div class="mb-3">
                <label for="nouvelle_capacite" class="form-label">MODE DE PAIEMENT</label>
                <select name="mode" id="mode" class="form-control w-10">
                 <option value="espece" <?php if ($paiementscolaire['MODEPAIEMENT'] === 'espece') echo 'selected'; ?>>Espece</option>
                 <option value="cheque" <?php if ($paiementscolaire['MODEPAIEMENT'] === 'cheque') echo 'selected'; ?>>Cheque</option>
                 <option value="virement" <?php if ($paiementscolaire['MODEPAIEMENT'] === 'virement') echo 'selected'; ?>>Virement</option>
                </select> 
            </div>
            <div class=<div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DETAILS</label>
                <textarea class="form-control" name="detail" id="detail" cols="30" rows="10" value="<?php echo $paiementscolaire['DETAILS']; ?>"></textarea>
             </div>
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
            <a href="listeScolarite.php" id="cancel" name="cancel" class="btn btn-dark">Annuler</a>
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