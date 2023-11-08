<?php
require_once 'connexion.php';
?>

<!doctype html>
<html lang="en">
<?php include('header.php') ?>
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.js'></script>


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
              <form class="d-flex" method="post">
                <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search" style="width:500px;">
                <button class="btn btn-outline-info" name="action" type="submit">Search</button>
              </form>
            </div>
          </nav><br>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4 text-center">LISTE DES EMPLOIS DU TEMPS</h5>
              <div class="d-flex justify-content-between align-items-center">
                <a href="imprimer_etudiant.php" class="btn btn-primary"><i class="bi bi-printer"></i></a>
                <a href="formEDT.php" class="btn btn-primary">Nouvel Emploi du temps</a>
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
                  $req_recuperation = "SELECT * FROM emploidutemps WHERE  NUMEROEDT= '$mc' ";
                } else {
                  $req_recuperation = "SELECT * FROM emploidutemps   LIMIT $start_from,$nombre_page";
                }

                $resultat = mysqli_query($congestschool, $req_recuperation);

                $req_select = "SELECT * FROM emploidutemps";
                $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat2);
                echo "<p><b class='pagination'>Page : " . $page . " sur " . $nbr2 . " enregistrements(s) </b></p>";

                ?>
                  <?php


                  // Tableau de correspondance pour les jours
                  $jours = array(
                    'lundi' => 'Lundi',
                    'mardi' => 'Mardi',
                    'mercredi' => 'Mercredi',
                    'jeudi' => 'Jeudi',
                    'vendredi' => 'Vendredi',
                    'samedi' => 'Samedi'
                );
                
                  // Sélectionnez toutes les classes
                  $req_classes = "SELECT * FROM classe";
                  $result_classes = mysqli_query($congestschool, $req_classes);

                  echo "<div class='row'>";
                  while ($row_class = mysqli_fetch_assoc($result_classes)) {
                      $id_classe = $row_class['IDCLASSE'];
                      $nom_classe = $row_class['NOMCLASSE'];

                      echo "<div class='col-md-6'>";
                      echo "<div class='class-card'>";
                      echo "<div class='card'>";
                      echo "<div class='card-header'><a href='votre_page.php?id_classe=".$id_classe."'>$nom_classe</a></div>"; // En-tête du card avec le nom de la classe
                      //  Ajouter un lien pour ajouter un emploi du temps pour cette classe
                                          // Ajouter un lien pour modifier l'emploi du temps pour cette classe

                      echo "<div class='card-header'>$nom_classe
                      <a href='updateEDT.php?id_classe=".$id_classe."' class='btn btn-primary'>Modifier</a>
                      <a href='formEDT.php?id_classe=".$id_classe."' class='btn btn-success'>Ajouter</a>
                  </div>";
              
                      // Sélectionnez les emplois du temps pour cette classe
                      $req_edt = "SELECT * FROM emploidutemps WHERE ID_CLASSE_EMPT = '$id_classe' ORDER BY JOUR";
                      $result_edt = mysqli_query($congestschool, $req_edt);
                      
                      echo "<ul class='list-group list-group-flush'>";
                      while ($row_edt = mysqli_fetch_assoc($result_edt)) {
                        $jour = $row_edt['JOUR'];
                        $hdebut = $row_edt['HDEBUT'];
                        $hfin = $row_edt['HFIN'];
                    
                        // Vérifier si la clé existe avant d'y accéder
                        if (array_key_exists($jour, $jours)) {
                            $nom_jour = $jours[$jour];
                            echo "<li class='list-group-item'>$nom_jour : $hdebut - $hfin</li>";
                        } else {
                            echo "<li class='list-group-item'>Jour inconnu : $hdebut - $hfin</li>";
                        }
                    }
                      echo "</ul>";
                      
                      echo "</div>"; // Fermez le card de la classe
                      echo "</div>"; // Fermez le div de class-card
                      echo "</div>"; // Fermez la colonne Bootstrap
                    }
                  echo "</div>"; // Fermez la rangée Bootstrap
                  ?>



               
              </div><br>
              <?php
              $pr_query = "SELECT * FROM emargement";
              $pr_resultat = mysqli_query($congestschool, $pr_query);
              $total_record = mysqli_num_rows($pr_resultat);
              $total_page = ceil($total_record / $nombre_page);

              if ($page > 1) {
                echo "<a href='listeEDT.php?page=" . ($page - 1) . "' class='btn btn-primary' id='bouton_page2'> << </a>";
              }

              for ($i = 1; $i < $total_page+1; $i++) {
                if ($page != $i) {
                  echo "<a href='listeEDT.php?page=" . $i . "' class='btn btn-primary' id='bouton_page'>$i</a>";
                } else {
                  echo "<a class='btn btn-succes' id='bouton_actif'>$i</a>";
                }
              }

              if ($i > $page) {
                echo "<a href='listeEDT.php?page=" . ($page + 1) . "' class='btn btn-primary' id='bouton_page2'> >> </a>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('script.php') ?>
    <div id='calendar'></div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                const id = this.getAttribute("data-id");
                const confirmDelete = confirm("Êtes-vous sûr de vouloir supprimer cet enregistrement ?");

                if (confirmDelete) {
                    window.location.href = "./Delete/deleteEDT.php?id=" + id;
                }
            });
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth', // Afficher le calendrier par mois
      events: {
        url: 'events.php', // L'URL qui renvoie les événements depuis la base de données
        method: 'POST',
        extraParams: {
          action: 'getEvents' // Vous pouvez définir un paramètre pour la requête AJAX
        },
        failure: function() {
          alert('Erreur lors du chargement des événements.');
        }
      }
    });

    calendar.render();
  });
</script>

</body>

</html>