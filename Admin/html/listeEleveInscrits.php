<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>

<body>
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
    <div class="body-wrapper">

    <div class="container-fluid">
        <div class="card">
        <div class="position-relative">
                <button class="position-absolute top-0 start-0 btn btn-primary p-2 fs-2 no-print"
                  onclick="imprimerPage()">
                  <i class="bi bi-printer"></i>
                </button><br />
              </div>
            <div class="card-body">
                <!-- Ajoutez le menu déroulant pour sélectionner l'année académique -->
                <form method="post" action="">
                    <div class="form-group">
                        <label for="annee_academique">Sélectionnez l'année académique :</label>
                        <select class="form-select" id="annee_academique" name="annee_academique">
                            <?php
                            require_once 'connexion.php';

                            // Requête SQL pour récupérer les années académiques disponibles depuis la base de données
                            $req_annees_academiques = "SELECT DISTINCT ANNEACCADEMIQUE FROM classe ORDER BY ANNEACCADEMIQUE DESC";
                            $resultat_annees_academiques = mysqli_query($congestschool, $req_annees_academiques);

                            if ($resultat_annees_academiques) {
                                while ($row_annee_academique = mysqli_fetch_assoc($resultat_annees_academiques)) {
                                    $annee_academique = $row_annee_academique['ANNEACCADEMIQUE'];
                                    echo "<option value=\"$annee_academique\">$annee_academique</option>";
                                }
                            } else {
                                die("Erreur SQL: " . mysqli_error($congestschool));
                            }

                            // Ne fermez pas la connexion à la base de données ici
                            // mysqli_close($congestschool);
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-1">Afficher</button>
                </form>
                <!-- Fin du menu déroulant -->

                <!-- Affichez l'année académique sélectionnée au-dessus du tableau -->
                <?php if(isset($_POST['annee_academique'])): ?>
                <h5 class="card-title fw-semibold mb-4 text-center">LISTE DES ELEVES INSCRITS POUR L'ANNÉE ACADEMIQUE  <?php echo $_POST['annee_academique']; ?></h5>
                <?php endif; ?>
                <!-- Fin de l'affichage de l'année académique -->

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">Nom </th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Classe</th>
                            </tr>
                        </thead>
                        <tbody>
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
                  $req_recuperation = "SELECT * FROM inscription WHERE IDELEVE_INSC LIKE '$mc' OR DATE = '$mc' ";
                } else {
                  $req_recuperation = "SELECT * FROM inscription   LIMIT $start_from,$nombre_page";
                }
                

                $req_select = "SELECT * FROM inscription join eleve ON inscription.IDELEVE_INSC= eleve.IDELEVE";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

            

                
                            // ... Votre code existant ...

                $req_classes = "SELECT classe.NOMCLASSE, eleve.NOM, eleve.PRENOM
                FROM classe
                JOIN inscription ON classe.IDCLASSE = inscription.IDCLASSE_INSC
                JOIN eleve ON inscription.IDELEVE_INSC = eleve.IDELEVE
                WHERE classe.ANNEACCADEMIQUE = '$annee_academique'
                GROUP BY classe.IDCLASSE, eleve.NOM, eleve.PRENOM
                LIMIT $start_from, $nombre_page";

// ... Votre code existant ...


                                $resultat_classes = mysqli_query($congestschool, $req_classes);
                        


                                if ($resultat_classes) {
                                    while ($row = mysqli_fetch_assoc($resultat_classes)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['NOM'] . "</td>";
                                        echo "<td>" . $row['PRENOM'] . "</td>";
                                        echo "<td>" . $row['NOMCLASSE'] . "</td>";
                                        echo " </tr>";
                                    }
                                
                            echo '</div>';
                                } else {
                                    die("Erreur SQL: " . mysqli_error($congestschool));
                                }
                        
                            // Ne fermez pas la connexion à la base de données ici
                            // mysqli_close($congestschool);
                            ?>
                        </tbody>
             
                    </table>
                    </tbody>
</table>
      <?php
              $pr_query = "SELECT * FROM inscription";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='listeEleveInscrits.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page+1; $i++) {
                if ($page != $i) {
                  echo "<a href='listeEleveInscrits.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='listeEleveInscrits.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
              }
              ?>
                </div>
            </div>
        </div>
    </div>
    <script>
            function imprimerPage() {
              window.print();
            }
          </script>
</body>
</html>
