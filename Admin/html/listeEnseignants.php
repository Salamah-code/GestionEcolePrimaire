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
    <!-- Ajoutez le bouton Bootstrap ici -->
    
</div>

     <nav class="navbar navbar-light">
          <div class="container-fluid">
            <div class="mb-3">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="motcle" id="motcle" placeholder="Search par matricule, nom ou prenom" aria-label="Search" style="width:500px;">
                    <button class="btn btn-outline-info" name="action" type="submit">Search</button>
                </form>
           </div>
    
    <!-- Div pour la recherche de la liste des enseignants affectés par année -->
         
      </div>
          </nav><br>
          
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4 text-center">LISTE DES ENSEIGNANTS</h5>
              <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
              <div class="text-end">
            <a href="listEnseignantAffectes.php" class="btn btn-primary">LISTE ENSEIGNANTS AFFECTATES</a>
          </div>
              <!-- <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p> -->
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
                  
                  $req_recuperation = "SELECT * FROM enseignant WHERE MATRICULE ='$mc' OR NOMENSEIGNANT ='$mc' OR PRENNOMENSEIGNANT ='$mc' ";
                } else {
                  $req_recuperation = "SELECT * FROM enseignant LIMIT $start_from,$nombre_page";
                }

                $resultat = mysqli_query($congestschool, $req_recuperation);

                $req_select = "SELECT * FROM enseignant";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

                ?>
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-success">
                    <th scope="col">#</th>
                      <th scope="col">Matricule</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Prénom</th>
                      <th scope="col">Email</th>
                      <th scope="col">Telephone</th>
                      <th scope="col">Nationnalite</th>
                      <th scope="col">Photo</th>
                      <th scope="col">Modifer</th>
                      <th scope="col">Detail</th>
                      <th scope="col">Supprimer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   
                        while ($ligne = mysqli_fetch_assoc($resultat)) {
                          echo "<tr>";
                          echo "<td>" . $ligne['IDENSEIGNANT'] . "</td>";
                          echo "<td>" . $ligne['MATRICULE'] . "</td>";
                          echo "<td>" . $ligne['NOMENSEIGNANT'] . "</td>";
                          echo "<td>" . $ligne['PRENNOMENSEIGNANT'] . "</td>";
                          echo "<td>" . $ligne['EMAIL'] . "</td>";
                          echo "<td>" . $ligne['TEL'] . "</td>";
                          echo "<td>" . $ligne['NATIONNALITE'] . "</td>";
                          echo '<td><a href="'.$ligne['PHOTO'].' " download>' . $ligne['PHOTO'].'</a></td>';
                          echo '<td><a href="updateEnseignant.php?id=' . $ligne['IDENSEIGNANT'] . '" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a></td>';
                          echo '<td><a href="detailsEnseignant.php?id=' . $ligne['IDENSEIGNANT'] . '" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>';
                          echo '<td><a href="Delele/deleteEnseignant.php" class="btn btn-danger delete-btn" data-id="' . $ligne['IDENSEIGNANT'] . '" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a></td>';
                          echo "</tr>";
                      }
                      ?>

                   
                  </tbody>
                </table>
              </div><br>
              <?php
              $pr_query = "SELECT * FROM enseignant";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='listeEnseignants.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page+1; $i++) {
                if ($page != $i) {
                  echo "<a href='listeEnseignants.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='listeEnseignants.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
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
                    window.location.href = "./Delete/deleteEnseignant.php?id=" + id;
                }
            });
        });
    });
</script>
</body>

</html>