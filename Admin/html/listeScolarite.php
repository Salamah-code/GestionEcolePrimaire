<?php
require_once 'connexion.php';
?>

<!doctype html>
<html lang="en">
<?php include('header.php') ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
   data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
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

              <form class="d-flex" method="post" action="">
                <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search" style="width:500px;">
                <button class="btn btn-outline-info" name="search" type="submit">Search</button>
              </form>
            </div>
          </nav><br>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4 text-center">Regularisation de paiement</h5>
              <p><a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a></p>
              <div class="text-end">
            <a href="FormScolarite.php" class="btn btn-primary">Nouveau paiement</a>
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
                  $req_recuperation = "SELECT * FROM paiementscoloarite WHERE MOIS LIKE '$mc' OR MOTIF = '$mc' ";
                } else {
                  $req_recuperation = "SELECT * FROM paiementscoloarite   LIMIT $start_from,$nombre_page";
                }
                

                $req_select = "SELECT * FROM paiementscoloarite";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

                ?>
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-success">
                      <th scope="col">INSCRIPTION</th>
                      <th scope="col">DATE PAIEMENT</th>
                      <th scope="col">MONTANT </th>
                      <th scope="col">MOIS</th>
                      <th scope="col">MOTIF PAIEMENT </th>
                      <th scope="col">MODE PAIEMENT</th>
                      <th scope="col">DETAILS </th>
                      <th scope="col">Modifer</th>
                      <th scope="col">Detail</th>
                      <th scope="col">Supprimer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($ligne = mysqli_fetch_assoc($resultat2)) { 
                    echo "<tr>";
                    echo "<td>" . $ligne['NUMERO_INSC'] . "</td>";
                    echo "<td>" . $ligne['DATEPAIEMENT'] . "</td>";
                    echo "<td>" . $ligne['MONTANTPAIEMENT'] . "</td>";
                    echo "<td>" . $ligne['MOIS'] . "</td>";
                    echo "<td>" . $ligne['MOTIF'] . "</td>";
                    echo "<td>" . $ligne['MODEPAIEMENT'] . "</td>";
                    echo "<td>" . $ligne['DETAILS'] . "</td>";
                    echo '<td><a href="./updateScolarite.php?id=' . $ligne['IDPAIEMENT'] . '" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a></td>';
                    echo '<td><a href="./detailsScolarite.php?id=' . $ligne['IDPAIEMENT'] . '" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>';
                    echo '<td><a href="Delete/deleteScolarite" class="btn btn-danger delete-btn" data-id="' . $ligne['IDPAIEMENT'] . '"><i class="bi bi-trash3-fill"></i></a></td>';
                    echo "</tr>";
                    }
                      ?>
                  </tbody>
                </table>
              </div><br>
              <?php
              $pr_query = "SELECT * FROM paiementscoloarite";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='listeScolarite.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page+1; $i++) {
                if ($page != $i) {
                  echo "<a href='listeScolarite.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='listeScolarite.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('script.php') ?>
    
</body>

</html>