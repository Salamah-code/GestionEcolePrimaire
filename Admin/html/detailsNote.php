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
               
                 
                 <div class="position-absolute top-0 end-0">
               
                 </div>
                </div><br/>
                <div class="table-responsive">

                <?php
    include('connexion.php');

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $note_id = $_GET['id'];

        // Requête pour récupérer les détails de la note
        $req_note = "SELECT * FROM notes WHERE IDNOTE = $note_id";
        $resultat_note = mysqli_query($congestschool, $req_note);

        if ($resultat_note) {
            $note = mysqli_fetch_assoc($resultat_note);

            // Récupérer les détails de l'élève
            $eleve_id = $note['ID_BULLETIN_NOTE'];
            $req_eleve = "SELECT * FROM eleve WHERE IDELEVE = $eleve_id";
            $resultat_eleve = mysqli_query($congestschool, $req_eleve);
            $eleve = mysqli_fetch_assoc($resultat_eleve);

            // Récupérer les détails de la matière
            $matiere_id = $note['ID_MATIERE_NOTE'];
            $req_matiere = "SELECT * FROM matiere WHERE IDMATIERE = $matiere_id";
            $resultat_matiere = mysqli_query($congestschool, $req_matiere);
            $matiere = mysqli_fetch_assoc($resultat_matiere);

            echo "<div class='container'>";
            echo "<h2>Détails de la note</h2>";
            echo "<table class='table'>";
            echo "<tr><th>Nom de l'élève</th><td>" . $eleve['NOM'] . "</td></tr>";
            echo "<tr><th>Prénom de l'élève</th><td>" . $eleve['PRENOM'] . "</td></tr>";
            echo "<tr><th>Libellé de la matière</th><td>" . $matiere['LIBELLE'] . "</td></tr>";
            echo "<tr><th>Note</th><td>" . $note['NOTE'] . "</td></tr>";
            echo "<tr><th>Type d'évaluation</th><td>" . $note['TYPE_EVALUATION'] . "</td></tr>";
            echo "<tr><th>Date d'évaluation</th><td>" . $note['DATE_EVALUATION'] . "</td></tr>";
            echo "</table>";
            echo "</div>";
        } else {
            echo 'Aucune note trouvée';
        }
    } else {
        echo 'ID de la note non valide.';
    }

    // Fermer la connexion
    $congestschool->close();
    ?>

<div style="margin-top: 20px;">
            <a href="listeNote.php" class="btn btn-secondary">Retour</a>
        </div>
     </div>
          </div>
        </div>
      </div>
    </div>

    </body>
</html>