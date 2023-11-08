<?php
require_once 'connexion.php';
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
          <nav class="navbar navbar-light">
            <div class="container-fluid">
              <form class="d-flex" method="post">
                <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search" style="width:500px;">
                <button class="btn btn-outline-info" name="action" type="submit">Search</button>
              </form>
            </div>
          </nav><br>
          <div class="card">
<!-- ... Votre code HTML existant ... -->
      <div class="card-body">
          <h5 class="card-title fw-semibold mb-4 text-center">LISTE DES AFFECTATIONS</h5>
              <div class="d-flex justify-content-between align-items-center">
                <a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a>
                <a href="formAffectation.php" class="btn btn-primary">Nouvelle affectation</a>
              </div>
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
                  $req_recuperation = "SELECT * FROM affectation WHERE IDAFFECTATION  = '$mc' OR ID_CLASSE = '$mc' ";
                } else {
                  $req_recuperation = "SELECT C.NOMCLASSE, E.NOMENSEIGNANT, E.PRENNOMENSEIGNANT ,A.*
                     FROM affectation A 
                     JOIN enseignant E ON E.IDENSEIGNANT = A.ID_ENSIGNANT
                     JOIN classe C ON C.IDCLASSE = A.ID_CLASSE
                     LIMIT $start_from, $nombre_page";

                }

                $resultat = mysqli_query($congestschool, $req_recuperation);

                $req_select = "SELECT * FROM affectation";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

                ?>
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-success">
                      <th scope="col">SALLE</th>
                      <th scope="col">CLASSE</th>
                      <th scope="col">ENSEIGNANT</th>
                      <th scope="col">DATE AFFECTATION</th>
                      <th scope="col">MODIFIER</th>
                      <th scope="col">DETAILS</th>
                     
                      <th scope="col">SUPPRIMER</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                      echo "<tr>";
                    echo "<td>" . $ligne['IDAFFECTATION'] . "</td>";
                    echo "<td>" . $ligne['NOMCLASSE'] . "</td>";
                    echo "<td>" . $ligne['NOMENSEIGNANT'] . ' '. $ligne['PRENNOMENSEIGNANT'] . "</td>";
                    echo "<td>" . $ligne['date_affectation'] . "</td>";                  
                    echo '<td><a href="updateAffectation.php?id=' . $ligne['IDAFFECTATION'] . '" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a></td>';
                    echo '<td><a href="./detailsAffectation.php?id=' . $ligne['IDAFFECTATION'] . '" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>';

                    echo '<td><a href="Delete/deleteAffectation" class="btn btn-danger delete-btn" data-id="' . $ligne['IDAFFECTATION'] . '"><i class="bi bi-trash3-fill"></i></a></td>';
                    echo "</tr>";
                
                    }
                      ?>
                  </tbody>
                </table>
              </div><br>
              <?php
              $pr_query = "SELECT * FROM affectation";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='listeAffectation.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page; $i++) {
                if ($page != $i) {
                  echo "<a href='listeAffectation.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='listeAffectation.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('script.php') ?>

    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                const id = this.getAttribute("data-id");
                const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cet enregistrement ?");

                if (confirmDelete) {
                    window.location.href = "./Delete/deleteClasse.php?id=" + id;
                }
            });
        });
    });
</script>
</body>

</html>