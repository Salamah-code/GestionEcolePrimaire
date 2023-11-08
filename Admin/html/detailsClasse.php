<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $classeId = $_GET['id'];

    // Requête SQL pour récupérer les informations sur la classe et l'enseignant
    $req_classe = "SELECT DISTINCT eleve.IDELEVE, eleve.MATRICULE, E.NOMENSEIGNANT, E.PRENNOMENSEIGNANT, C.IDCLASSE, S.NOMSALLE, eleve.NOM AS NOM_ELEVE, eleve.PRENOM AS PRENOM_ELEVE, E.MATRICULE AS MAT_ENS
    FROM classe C
    JOIN inscription I ON C.IDCLASSE = I.IDCLASSE_INSC
    JOIN affectation A ON C.IDCLASSE = A.ID_CLASSE
    JOIN enseignant E ON E.IDENSEIGNANT = A.ID_ENSIGNANT
    JOIN salle S ON S.IDSALLE = C.ID_SALLE
    JOIN eleve ON I.IDELEVE_INSC = eleve.IDELEVE
    WHERE C.IDCLASSE = $classeId";
    

    $result_classe = mysqli_query($congestschool, $req_classe);

    if (!$result_classe) {
        die("Erreur SQL: " . mysqli_error($congestschool));
    }

} else {
    $error_message = "ID de classe non spécifié.";
}
?>
<!DOCTYPE html>
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
          <nav class="navbar navbar-light">
            <div class="container-fluid">
              <form class="d-flex" method="post">
                <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search" style="width:500px;">
                <button class="btn btn-outline-info" name="action" type="submit">Search</button>
              </form>
            </div>
          </nav><br>
          <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4 text-center">DETAILS DE LA CLASSE</h5>
                <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
                <div class="position-relative">
                <button class="btn btn-dark mb-4  fs-3 btn-left m-1">
                  <a href="formInscription.php?id= <?php echo  $classeId 
                  ;?>"  class="fw-bold text-light">
                     <i class="bi bi-plus-circle-fill  fs-5 p-2 pt-2  "></i>
                   </a>
                   </button>
                 <div class="position-absolute top-0 end-0">
               
                 </div>
                </div><br/>
                <div class="table-responsive">
                  
    <?php
  

    $classeInfo = mysqli_fetch_assoc($result_classe);

    if ($classeInfo) {
        // Affichez les informations de la classe et de l'enseignant
        echo "<p class='fw-bold fs-5'><span class='mx-4 '>";
        echo "<span> Salle:</span>" . $classeInfo['NOMSALLE'] . "</span>";
        echo "<span class='mx-4'><span>Matr Enseignant:</span>" . $classeInfo['MAT_ENS'] . "</span>";
        echo "<span class='mx-4'>Nom Enseignant<span>:</span>" . $classeInfo['NOMENSEIGNANT'] . "</span>";
        echo "<span class='mx-4'>Prenom Enseignant<span>:</span>" . $classeInfo['PRENNOMENSEIGNANT'] . "</span>";

        echo "</p>";

        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr class='table-success'>";
        echo "<th scope='col'>Matricule</th>";
        echo "<th scope='col'>Nom Eleve</th>";
        echo "<th scope='col'>Prenom Eleve</th>";
        echo "<th scope='col'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Réinitialisez la position du curseur pour récupérer les élèves
        mysqli_data_seek($result_classe, 0);

        // Pagination
        $eleves_par_page = 7; // Nombre d'élèves par page
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Page actuelle

        $start = ($page - 1) * $eleves_par_page; // Position de départ dans les résultats

        $count = 0; // Compteur d'élèves

        while ($eleve = mysqli_fetch_assoc($result_classe)) {
            if ($count >= $start && $count < ($start + $eleves_par_page)) {
                // Affichez seulement les élèves pour la page actuelle
                echo "<tr>";
                echo "<td>" . $eleve['MATRICULE'] . "</td>";
                echo "<td>" . $eleve['NOM_ELEVE'] . "</td>";
                echo "<td>" . $eleve['PRENOM_ELEVE'] . "</td>";
                echo "<td>
                <a href='creer_bulletin.php?id=" . $eleve['IDELEVE'] . "' class='btn btn-primary'>Créer un bulletin</a>
                <a href='ajouter_note.php?id=" . $eleve['IDELEVE'] . "' class='btn btn-info'>Ajouter une note</a>
                <a href='payer_scolarite.php?id=" . $eleve['IDELEVE'] . "' class='btn btn-success'>Payer la scolarité</a>
              </td>";
        
        
                echo "</tr>";
            }
            $count++;
        }

        echo "</tbody>";
        echo "</table>";

        // Affichage de la pagination
        $total_pages = ceil($count / $eleves_par_page);

        echo "<div class='pagination'>";
        if ($page > 1) {
          echo "<a href='detailsClasse.php?id=$classeId&page=" . ($page - 1) . "'>&laquo; Page précédente</a>";
      }
  
      // Lien vers la page suivante
      if ($page < $total_pages) {
          echo "<a href='detailsClasse.php?id=$classeId&page=" . ($page + 1) . "'>Page suivante &raquo;</a>";
      }
  
      echo "</div>";
    }
    ?>
</div>

     <button class="btn btn-primary p-2 mb-4  fs-3"><a href="listeclasses.php" class="fw-bold text-light">Retour à la liste des classes</a></button><br/>
   
             </div>
          </div>
        </div>
      </div>
    </div>

    </body>
</html> 