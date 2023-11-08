<?php
require_once 'connexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id'])) {
  $notesId = $_GET['id'];

  // Récupérer les détails du notes à partir de la base de données
  $req_notes = "SELECT * FROM notes WHERE IDNOTE = $notesId";
  $result_notes = mysqli_query($congestschool, $req_notes);
  $note= mysqli_fetch_assoc($result_notes);

                if (isset($_POST['submit'])) {
                    // Traiter les données soumises depuis le formulaire de modification
                    $idbulletin = $_POST['idbulletin'];
                    $idmatiere = $_POST['idmatiere']; 
                    $note = $_POST['note'];
                    $evaluation = $_POST['evaluation'];
                    $date = $_POST['date'];

                    // Effectuer la mise à jour dans la base de données
                    $req_maj = "UPDATE notes SET  ID_MATIERE_NOTE  = '$idmatiere' , NOTE='$note',
                    TYPE_EVALUATION='$evaluation', DATE_EVALUATION='$date' WHERE IDNOTE = $notesId";
                    if (mysqli_query($congestschool, $req_maj)) {
                        echo "<script type=\"text/javascript\">
                            alert(\"Modification réussie !\");
                            window.location.href = './listeNote.php';
                        </script>";
                    } else {
                        echo "<script type=\"text/javascript\">
                            alert(\"Échec de la modification.\");
                            window.location.href = './listeNote.php';
                        </script>";
                    }
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
              
          <form method="post">
            <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">ID NOTE</label>
                        
                        <input type="" class="form-control bg-light" id="matriculeDisplay" readonly
                        value="<?php echo $note['IDNOTE']; ?>">
            </div>
           
           
            <div class="mb-3">
    <label for="ideleve" class="form-label">ELEVE</label>
    <select name="idbulletin" id="idbulletin" class="form-control">
        <?php
        include 'connexion.php';
        $req_select = "SELECT B.*,E.* FROM bulletin b join eleve e on b.IDELEVE_BUL=e.IDELEVE";
        $resultat2 = mysqli_query($congestschool, $req_select);
        while ($ligne = mysqli_fetch_assoc($resultat2)) {
            $idbulletin = $ligne['IDBULLETIN'];
            $matricule = $ligne['MATRICULE'];
            $no = $ligne['NOM'];
            $preno = $ligne['PRENOM'];
            $selected = ($idnote == $note['ID_BULLETIN_NOTE']) ? "selected" : "";
            ?>
            <option value="<?php echo $idbulletin; ?>" <?php echo $selected; ?>>
                <?php echo $idbulletin.' ' .$matricule . ' ' . $no . ' ' . $preno; ?>
            </option>
        <?php
        }
        ?>
    </select>
</div>
<div class="mb-3">             
     <label for="ideleve" class="form-label">MATIERE</label>
        <select name="idmatiere" id="idmatiere" class="form-control">
            <?php
            include 'connexion.php';
            $req_select = "SELECT * FROM matiere";
            $resultat2 = mysqli_query($congestschool, $req_select);
            while ($ligne = mysqli_fetch_assoc($resultat2)) {
                $idmatiere = $ligne['IDMATIERE'];
                $lib = $ligne['LIBELLE'];
              
                $selected = ($idmatiere == $emargement['idmatiere']) ? "selected" : "";
                ?>
                <option value="<?php echo $idmatiere; ?>" <?php echo $selected; ?>>
                    <?php echo $lib ;?>
            </option><?php
               }
            ?>
        </select>
 </div>        
 <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> NOTE</label>
                <input type="text"  class="form-control" id="note" name="note" value="<?php echo $note['NOTE']; ?>">
 </div>
 <div class="mb-3">  
             <label for="nouveau_nom" class="form-label"> TYPE D'EVALUTION</label>
                <select name="evaluation" id="evaluation" class="form-control w-10">
                 <option value="Devoir" <?php if ($note['TYPE_EVALUATION'] === 'Devoir') echo 'selected'; ?>>Devoir</option>
                 <option value="Controle" <?php if ($note['TYPE_EVALUATION'] === 'Controle') echo 'selected'; ?>>Controle</option>
                 <option value="Composition" <?php if ($note['TYPE_EVALUATION'] === 'Composition') echo 'selected'; ?>>Composition</option>
                </select> 
  </div>
               
   <div class="mb-3">
                <label for="nouveau_nom" class="form-label"> DATE D'EVALUATION</label>
                <input type="text"  class="form-control" id="date" name="date" value="<?php echo $note['DATE_EVALUATION']; ?>">
    </div>
 </div>  
</div>
            <button type="submit" class="btn btn-primary" name="submit">Mettre à jour</button>
             <button type="reset" class="btn btn-dark">Annuler</button>
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