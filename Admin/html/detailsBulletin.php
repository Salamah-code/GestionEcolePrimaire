<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper .no-print " id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div class=".no-print">
        <div class="brand-logo d-flex align-items-center justify-content-between no-print ">
          <a href="MenuAdmin.php" class=" no-print text-nowrap logo-img  ">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" class="" />
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
      <style>
        @media print {
          .no-print {
            display: none;
          }
        }

        div.ridge {
          border-style: ridge;
          border-width: 6px;
        }

        div.groove {
          border-style: groove;
          border-width: 6px;
        }
      </style>
      <div class="container-fluid  ">
        <div class="container-fluid ">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-0 text-center no-print">DETAILS DU BULLETIN </h5>
              <p>
              <div class="position-relative">
                <button class="position-absolute top-0 start-0 btn btn-primary p-2 fs-2 no-print"
                  onclick="imprimerPage()">
                  <i class="bi bi-printer"></i>
                </button><br />
              </div>
              </p>
              <div class="position-relative pb-5">
                <div class="position-absolute top-0 start-0">

                  <h6>IA:</h6>
                  <h6>IEF:</h6>
                  <h6>ECOLE:</h6>
                </div>
                <div class="position-absolute top-0 end-0">
                  <?php
                  require_once 'connexion.php';
                  if (isset($_GET['id'])) {
                    $bulletinId = $_GET['id'];
                    $req_bulletin = "SELECT 
          B.*, E.*, N.*, M.*, A.*, ENS.NOMENSEIGNANT, ENS.PRENNOMENSEIGNANT, C.NOMCLASSE, C.ANNEACCADEMIQUE  
        FROM 
          bulletin B
        JOIN 
          eleve E ON B.IDELEVE_BUL = E.IDELEVE
        JOIN 
          notes N ON B.IDBULLETIN = N.ID_BULLETIN_NOTE  
        JOIN 
          matiere M ON N.ID_MATIERE_NOTE = M.IDMATIERE
        JOIN 
          inscription I ON E.IDELEVE = I.IDELEVE_INSC
        JOIN 
          classe C ON I.IDCLASSE_INSC = C.IDCLASSE
        JOIN 
          affectation A ON C.IDCLASSE = A.ID_CLASSE
        JOIN 
          enseignant ENS ON A.ID_ENSIGNANT = ENS.IDENSEIGNANT 
        WHERE 
          B.IDBULLETIN = $bulletinId";
                    $result_bulletin = mysqli_query($congestschool, $req_bulletin);
                    // Vérifiez si la requête a réussi et si des données ont été retournées
                    if (!$result_bulletin) {
                      die("Erreur SQL: " . mysqli_error($congestschool));
                    }

                    // Requête SQL pour obtenir les notes et coefficients du bulletin donné
                                $req_notes = "SELECT N.NOTE, M.*
              FROM notes N
              JOIN matiere M ON N.ID_MATIERE_NOTE = M.IDMATIERE
              WHERE  N.ID_BULLETIN_NOTE  = $bulletinId";

                    $result_notes = mysqli_query($congestschool, $req_notes);

                    if (!$result_notes) {
                      die("Erreur SQL: " . mysqli_error($congestschool));
                    }
                    $bulletin = mysqli_fetch_assoc($result_bulletin);
                    if (mysqli_num_rows($result_bulletin) > 0) {
                      $nomClasse = $bulletin['NOMCLASSE'];
                      $trimestre = $bulletin['TRIMESTRE'];
                      $eleveId = $bulletin['IDELEVE_BUL'];
                      $sql = "SELECT E.IDELEVE, E.NOM, E.PRENOM,N.*, SUM(NOTE * M.COEFFICIENT)/SUM(M.COEFFICIENT)AS moyenne_eleve,
               RANK() OVER (ORDER BY SUM(NOTE * M.COEFFICIENT)/SUM(M.COEFFICIENT) DESC) AS rang_classe
        FROM eleve E
        JOIN bulletin B ON E.IDELEVE = B.IDELEVE_BUL
        JOIN notes N ON B.IDBULLETIN = N.ID_BULLETIN_NOTE 
        JOIN matiere M ON N.ID_MATIERE_NOTE = M.IDMATIERE 
        WHERE B.TRIMESTRE = '$trimestre'
        GROUP BY E.IDELEVE, E.NOM, E.PRENOM";

                      $result = mysqli_query($congestschool, $sql);

                      if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          if ($row['IDELEVE'] == $eleveId) {
                            //  echo "Rang de l'élève " . $row['NOM'] . " " . $row['PRENOM'] . " dans sa classe : " . $row['rang_classe'];
                            break;
                          }
                        }
                      } else {
                        echo "Erreur lors de la récupération du rang de l'élève : " . mysqli_error($congestschool);
                      }

                      $total_eleves_classe = 0; // Initialisation de la variable avec une valeur par défaut
                  
                      $req_total_eleves = "SELECT COUNT(I.IDELEVE_INSC) AS total_eleves
                          FROM classe C
                          LEFT JOIN inscription I ON C.IDCLASSE = I.IDCLASSE_INSC
                          WHERE C.NOMCLASSE = '$nomClasse'";

                      $result_total_eleves_classe = mysqli_query($congestschool, $req_total_eleves);

                      if ($result_total_eleves_classe) {
                        $row_total_eleves_classe = mysqli_fetch_assoc($result_total_eleves_classe);
                        $total_eleves_classe = $row_total_eleves_classe['total_eleves'];
                        // echo "Total des élèves dans la classe '$nomClasse' : $total_eleves_classe";
                      } else {
                        echo "Aucun résultat trouvé pour la classe '$nomClasse'.";
                      }


                      function getAppreciation($note)
                      {
                        if ($note >= 9) {
                          return "Très bien";
                        } elseif ($note >= 7) {
                          return "Bien";
                        } elseif ($note >= 6) {
                          return "Assez bien";
                        } elseif ($note >= 5) {
                          return "Passable";
                        } else {
                          return "Insuffisant";
                        }
                      }
                      function getAppreciationMoyenne($moyenne)
                      {
                        if ($moyenne >= 9) {
                          return "Très bien";
                        } elseif ($moyenne >= 8) {
                          return "Bien";
                        } elseif ($moyenne >= 7) {
                          return "Assez bien";
                        } elseif ($moyenne >= 5) {
                          return "Passable";
                        } else {
                          return "Insuffisant";
                        }
                      }
                      function getDecision($moyenne_generale, $nomClasse) {
                        if ($moyenne_generale >= 5) {
                            return "Passe en classe supérieure";
                        } else {
                            return "Retourne en " . $nomClasse;
                        }
                        $decision = getDecision($moyenne_generale, $nomClasse);

                    }
                    
                    
                    } else {
                      $error_message = "ID de bulletin non spécifié.";
                    }
                     if (($bulletin)): ?>
                      <h6>ANNEE SCOLAIRE:
                        <?php echo $bulletin['ANNEESCOLAIRE']; ?>
                      </h6>
                      <h6>CLASSE:
                        <?php echo $bulletin['NOMCLASSE']; ?>
                      </h6>
                      <h6>ENSEIGNANT: Mr/Mme
                        <?php echo $bulletin['PRENNOMENSEIGNANT'] . ' ' . $bulletin['NOMENSEIGNANT']; ?>
                      </h6>
                    </div>
                    </div></br><br>
                    <div class="ridge  shadow p-1 mb-2 bg-body-tertiary rounded mx-auto " style="width: 79%;">
                      <h3 class="text-center text-decoration-underline">BULLETIN DE NOTES DU
                        <?php echo $bulletin['TRIMESTRE']; ?>
                      </h3>
                    </div>
                    <p class="fw-bold"><span class="mx-4 "> <span>Matricule:</span>
                        <?php echo $bulletin['MATRICULE']; ?>
                      </span>
                      <span class="mx-4"><span>Nom:</span>
                        <?php echo $bulletin['NOM']; ?>
                      </span>
                      <span class="mx-4"><span>Prénom:</span>
                        <?php echo $bulletin['PRENOM']; ?>
                      </span>
                    </p>
                    <?php endif; ?>
                    
                    <!-- Code pour le tableau des notes -->
                    <!-- ... -->
                    
                    

<?php
                if (isset($bulletin['TRIMESTRE'])) {
                  // Personnalisez ce code pour récupérer et afficher les moyennes
                  if ($bulletin['TRIMESTRE'] == '1er trimestre') { ?>

                    <div class="ridge ">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-success">
                            <th scope="col">MATIERES</th>
                            <th scope="col">COEFFICIENT</th>
                            <th scope="col">NOTES</th>
                            <th scope="col">APPRECIATIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $somme_notes_ponderees = 0;
                          $total_coefficients = 0;
                          if (isset($result_notes)) {

                            // $sommeNotes = 0; // Variable pour la somme des notes
                            // $sommeCoefficients = 0; // Variable pour la somme des coefficients
                    
                            while ($row_note = mysqli_fetch_assoc($result_notes)) {
                              echo "<tr>";
                              echo "<td>" . $row_note['LIBELLE'] . "</td>";
                              echo "<td>" . $row_note['COEFFICIENT'] . "</td>";
                              echo "<td>" . $row_note['NOTE'] . "</td>";
                              echo "<td>" . getAppreciation($row_note['NOTE']) . "</td>";
                              echo "</tr>";
                              $note = $row_note['NOTE'];
                              $coefficient = $row_note['COEFFICIENT'];


                              $note_ponderee = $note * $coefficient; // Calcul de la note pondérée
                              $somme_notes_ponderees += $note_ponderee; // Ajout à la somme des notes pondérées
                              $total_coefficients += $coefficient;
                            }
                            if ($total_coefficients > 0) {
                              $moyenne_ponderee = $somme_notes_ponderees / $total_coefficients;

                              //echo "La moyenne pondérée est : " . number_format($moyenne_ponderee, 2);
                            } else {
                              echo "Aucun coefficient valide trouvé pour calculer la moyenne pondérée.";
                            }
                            ?>
                            <tr>
                              <th scope="row">Total</th>
                              <td colspan="1">
                                <?php echo $total_coefficients; ?>
                              </td>
                              <td colspan="1">
                                <?php echo $somme_notes_ponderees; ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Moyenne</th>
                              <td colspan="2" class="fw-bold fs-4">
                                <?php echo number_format($moyenne_ponderee, 2); ?>/10
                              </td>
                              <td>
                                <?php echo getAppreciationMoyenne($moyenne_ponderee); ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Rang</th>
                              <td colspan="2">
                                <?php echo $row['rang_classe']; ?>/
                                <?php echo $total_eleves_classe; ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div><br>
                    <?php
                          } elseif (isset($error_message)) {
                            echo "<tr><td colspan='9'>$error_message</td></tr>";
                          }
                  } elseif ($bulletin['TRIMESTRE'] == '2em trimestre') { ?>
                    <div class="ridge ">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-success">
                            <th scope="col">MATIERES</th>
                            <th scope="col">COEFFICIENT</th>
                            <th scope="col">NOTES</th>
                            <th scope="col">APPRECIATIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $somme_notes_ponderees = 0;
                          $total_coefficients = 0;
                          if (isset($result_notes)) {

                            // $sommeNotes = 0; // Variable pour la somme des notes
                            // $sommeCoefficients = 0; // Variable pour la somme des coefficients
                    
                            while ($row_note = mysqli_fetch_assoc($result_notes)) {
                              echo "<tr>";
                              echo "<td>" . $row_note['LIBELLE'] . "</td>";
                              echo "<td>" . $row_note['COEFFICIENT'] . "</td>";
                              echo "<td>" . $row_note['NOTE'] . "</td>";
                              echo "<td>" . getAppreciation($row_note['NOTE']) . "</td>";
                              echo "</tr>";
                              $note = $row_note['NOTE'];
                              $coefficient = $row_note['COEFFICIENT'];


                              $note_ponderee = $note * $coefficient; // Calcul de la note pondérée
                              $somme_notes_ponderees += $note_ponderee; // Ajout à la somme des notes pondérées
                              $total_coefficients += $coefficient;
                            }
                            if ($total_coefficients > 0) {
                              $moyenne_ponderee = $somme_notes_ponderees / $total_coefficients;
                              //echo "La moyenne pondérée est : " . number_format($moyenne_ponderee, 2);
                            } else {
                              echo "Aucun coefficient valide trouvé pour calculer la moyenne pondérée.";
                            }

                            ?>

                            <tr>
                              <th scope="row">Total</th>
                              <td colspan="1">
                                <?php echo $total_coefficients; ?>
                              </td>
                              <td colspan="1">
                                <?php echo $somme_notes_ponderees; ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Moyenne</th>
                              <td colspan="2" class="fw-bold fs-4">
                                <?php echo number_format($moyenne_ponderee, 2); ?>/10
                              </td>
                              <td>
                                <?php echo getAppreciationMoyenne($moyenne_ponderee); ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Rang</th>
                              <td colspan="2">
                                <?php echo $row['rang_classe']; ?>/
                                <?php echo $total_eleves_classe; ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div><br>
                    <?php
                          } elseif (isset($error_message)) {
                            echo "<tr><td colspan='9'>$error_message</td></tr>";
                          }


                  } elseif ($bulletin['TRIMESTRE'] == '3em trimestre') {
                    $anneeScolaire = $bulletin['ANNEESCOLAIRE'];
                    $trimestreActuel = '3em trimestre';
                    $eleve = $bulletin['IDELEVE_BUL'];
                    ?>

                    <div class="ridge ">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-success">
                            <th scope="col">MATIERES</th>
                            <th scope="col">COEFFICIENT</th>
                            <th scope="col">NOTES</th>
                            <th scope="col">APPRECIATIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php



                          $somme_notes_ponderees = 0;
                          $total_coefficients = 0;

                          if (isset($result_notes)) {
                            $somme_notes_ponderees = 0;
                            $total_coefficients = 0;
                            while ($row_note = mysqli_fetch_assoc($result_notes)) {
                              echo "<tr>";
                              echo "<td>" . $row_note['LIBELLE'] . "</td>";
                              echo "<td>" . $row_note['COEFFICIENT'] . "</td>";
                              echo "<td>" . $row_note['NOTE'] . "</td>";
                              echo "<td>" . getAppreciation($row_note['NOTE']) . "</td>";
                              echo "</tr>";
                              $note = $row_note['NOTE'];
                              $coefficient = $row_note['COEFFICIENT'];
                              $note_ponderee = $note * $coefficient; // Calcul de la note pondérée
                              $somme_notes_ponderees += $note_ponderee; // Ajout à la somme des notes pondérées
                              $total_coefficients += $coefficient;
                            }
                            if ($total_coefficients > 0) {
                              $moyenne_ponderee = $somme_notes_ponderees / $total_coefficients;
                              // echo "La moyenne pondérée est : " . number_format($moyenne_ponderee, 2);
                            } else {
                              echo "Aucun coefficient valide trouvé pour calculer la moyenne pondérée.";
                            }

                            ?>
                            <tr>
                              <th scope="row">Total</th>
                              <td colspan="1">
                                <?php echo $total_coefficients; ?>
                              </td>
                              <td colspan="1">
                                <?php echo $somme_notes_ponderees . ' points'; ?>
                              </td>
                            <tr>
                              <th scope="row">Moyenne</th>
                              <td colspan="2" class="fw-bold fs-4">
                                <?php echo number_format($moyenne_ponderee, 2); ?>/10
                              </td>
                              <td>
                                <?php echo getAppreciationMoyenne($moyenne_ponderee); ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Rang</th>
                              <td colspan="2">
                                <?php echo $row['rang_classe'];
                                ; ?>/
                                <?php echo $total_eleves_classe; ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div><br>

                      <div class="ridge ">
                        <div class="row g-0 text-start  bortder border-2">
                          <div class="col-sm-6 col-md-6 border  border-end">
                          <?php
                          } elseif (isset($error_message)) {
                            echo "<tr><td colspan='9'>$error_message</td></tr>";
                          }
                          // Requête SQL pour obtenir l'ID du bulletin du Trimestre 1 de la même année scolaire
                          $req_id_bulletin_trimestre1 = "SELECT N.*, M.COEFFICIENT, B.*
                                      FROM notes N
                                      JOIN bulletin B on N.ID_BULLETIN_NOTE =B.IDBULLETIN
                                      JOIN matiere M ON N.ID_MATIERE_NOTE = M.IDMATIERE
                                      JOIN eleve E ON B.IDELEVE_BUL= E.IDELEVE
                                      WHERE   B.ANNEESCOLAIRE = '$anneeScolaire' 
                                      AND B.TRIMESTRE = '1er trimestre' AND E.IDELEVE= '$eleve '";
                          $result_notes1 = mysqli_query($congestschool, $req_id_bulletin_trimestre1);
                          $somme_notes_ponderees1 = 0;
                          $total_coefficients1 = 0;
                          $moyenne_ponderee1 = 0;
                          if (!$result_notes1) {
                            die("Erreur SQL: " . mysqli_error($congestschool));
                          }
                          // Calcul de la somme des notes pondérées et de la somme des coefficients
                          while ($row = mysqli_fetch_assoc($result_notes1)) {
                            $note1 = $row['NOTE'];
                            $coefficient1 = $row['COEFFICIENT'];
                            $note_ponderee1 = $note1 * $coefficient1; // Calcul de la note pondérée
                            $somme_notes_ponderees1 += $note_ponderee1; // Ajout à la somme des notes pondérées
                            $total_coefficients1 += $coefficient1;
                          }
                          if ($total_coefficients1 > 0) {
                            $moyenne_ponderee1 = $somme_notes_ponderees1 / $total_coefficients1;
                            echo "Moyenne du  1er Trimestre est : " . number_format($moyenne_ponderee1, 2);
                            echo '</br>';
                          } else {
                            echo "Aucun coefficient valide trouvé pour calculer la moyenne pondérée.";
                          }



                          // Requête SQL pour obtenir l'ID du bulletin du Trimestre 2 de la même année scolaire
                          $req_id_bulletin_trimestre2 = "SELECT N.*, M.COEFFICIENT, B.*
                          FROM notes N
                          JOIN bulletin B ON N.ID_BULLETIN_NOTE = B.IDBULLETIN
                          JOIN matiere M ON N.ID_MATIERE_NOTE = M.IDMATIERE
                          JOIN eleve E ON B.IDELEVE_BUL = E.IDELEVE
                          WHERE B.ANNEESCOLAIRE = '$anneeScolaire' 
                          AND B.TRIMESTRE = '2em trimestre' AND E.IDELEVE = '$eleve'";
 

                          $result_notes2 = mysqli_query($congestschool, $req_id_bulletin_trimestre2);
                          $somme_notes_ponderees2 = 0;
                          $total_coefficients2 = 0;
                          if (!$result_notes2) {
                            die("Erreur SQL: " . mysqli_error($congestschool));
                          }
                          // Calcul de la somme des notes pondérées et de la somme des coefficients
                          while ($row_note2 = mysqli_fetch_assoc($result_notes2)) {
                            $note2 = $row_note2['NOTE'];
                            $coefficient2 = $row_note2['COEFFICIENT'];


                            $note_ponderee2 = $note2 * $coefficient2; // Calcul de la note pondérée
                            $somme_notes_ponderees2 += $note_ponderee2; // Ajout à la somme des notes pondérées
                            $total_coefficients2 += $coefficient2;
                          }
                          if ($total_coefficients2 > 0) {
                            $moyenne_ponderee2 = $somme_notes_ponderees2 / $total_coefficients2;
                            echo "Moyenne du  2er Trimestre est : " . number_format($moyenne_ponderee2, 2);
                          } else {
                            echo "Aucun coefficient valide trouvé pour calculer la moyenne pondérée.";
                          }
                          $nombre_trimestres = 3;
                          // Calcul de la moyenne générale
                          $nombre_trimestres = 3; // Nombre total de trimestres
                          $somme_moyennes = $moyenne_ponderee1 + $moyenne_ponderee2 + $moyenne_ponderee;
                          $moyenne_generale = $somme_moyennes / $nombre_trimestres;
                          echo '</br>';
                          echo ' Moyenne du 3ème trimestre : ' . number_format($moyenne_ponderee, 2);
                          echo '</br>';
                          echo 'Moyenne générale : ' . number_format($moyenne_generale, 2);
                          ?>
                        </div>

                        <div class="col-6 col-md-6 border-start">
                          <p class="fs-5"> <span class="text-decoration-underline"> DECISION DU CONSEIL:</br></span>
                            <?php echo getDecision($moyenne_generale,$nomClasse) ?>
                          </p>
                          <?php echo '</div>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                          echo '</br>';
                          echo '</br>';
                  } else {
                    echo "Impossible de calculer la moyenne générale.";
                  }
                }

                ?>


                      <div class="container text-center">
                        <div class="row">
                          <div class="col">
                            <p>L'ENSEIGNANT</p>
                            <p>...............</p>
                          </div>
                          <div class="col">
                            <p>LE DIRECTEUR </p>
                            <p>...............</p>
                          </div>
                          <div class="col">
                            <p>Tuteur(trice)</p>
                            <p>...............</p>
                          </div>
                        </div>
                      </div>


                      
  <?php
                  } else {
                    $error_message = "ID de bulletin non spécifié.";
                  }
                  ?>
                    </div>
                  </div>
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
