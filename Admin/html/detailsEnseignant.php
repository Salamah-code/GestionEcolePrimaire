<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $classeId = $_GET['id'];

    // Ajoutez une instruction de débogage pour vérifier la valeur de $classeId
    echo "Classe ID: " . $classeId . "<br>";

    $req_classe = "SELECT DISTINCT eleve.MATRICULE, E.NOMENSEIGNANT, E.PRENNOMENSEIGNANT, S.NOMSALLE, eleve.NOM AS NOM_ELEVE, eleve.PRENOM AS PRENOM_ELEVE, E.MATRICULE AS MAT_ENS
    FROM classe C
    JOIN affectation A ON C.IDCLASSE = A.ID_CLASSE
    JOIN enseignant E ON E.IDENSEIGNANT = A.ID_ENSIGNANT
    JOIN salle S ON S.IDSALLE = C.ID_SALLE
    JOIN eleve ON A.ID_ELEVE = eleve.IDELEVE
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
                <h5 class="card-title fw-semibold mb-4 text-center">LES ELEVES DE L'ENSEIGNANT</h5>
                <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
                <div class="table-responsive">
                <?php
                if (isset($_GET['page'])) {
                  $page = $_GET['page'];
                } else {
                  $page = 1;
                }
                $nombre_page = 05;
                $start_from = ($page - 1) * 05;

                /* on verifie que le contenue de la Recherche correspondants aux cararacère et on affiche le resutat*/
                if (isset($_POST['action'])) {
                  $mc = $_POST['motcle'];
                  $req_recuperation = "SELECT * FROM eleve join affectation ON affectation.ID_ELEVE=eleve.IDELEVE
                  WHERE eleve.MATRICULE LIKE '%$mc%' OR eleve.NOM LIKE '%$mc%' ";
                } else {
                  $req_recuperation = "SELECT * FROM classe   LIMIT $start_from,$nombre_page";
                }

               
                $req_select = "SELECT * FROM classe";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

                 // ...

$classeInfo = mysqli_fetch_assoc($result_classe);

if ($classeInfo) {
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
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($eleve = mysqli_fetch_assoc($result_classe)) {
      echo "<tr>";
      echo "<td>" . $eleve['MATRICULE'] . "</td>";
      echo "<td>" . $eleve['NOM_ELEVE'] . "</td>";
      echo "<td>" . $eleve['PRENOM_ELEVE'] . "</td>";
      echo "</tr>";
  }
  

    echo "</tbody>";
    echo "</table>";
} elseif (isset($error_message)) {
    echo "<p>$error_message</p>";
}

// ...
?>
              </div><br>
     <button class="btn btn-primary p-2 mb-4  fs-3"><a href="listeclasses.php" class="fw-bold text-light">Retour à la liste des classes</a></button><br/>
     <?php
              $pr_query = "SELECT * FROM classe";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='Listes/listeAffectation.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page+1; $i++) {
                if ($page != $i) {
                  echo "<a href='Listes/listeAffectation.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='Listes/listeAffectation.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
              }
              ?>
             </div>
          </div>
        </div>
      </div>
    </div>

    </body>
</html>