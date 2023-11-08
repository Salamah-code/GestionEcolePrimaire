<?php
include('header.php');
require_once 'connexion.php';
$classeId='';

?>

<!doctype html>
<html lang="en">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
        @media print {
            .no-print {
                display: none;
            }
        }
          .no-border {
            border: none;
        }
    </style>
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
                <div class="d-flex align-items-center no-print">
                <p><a href="javascript:void(0);" class="btn btn-link" id="imprimerRecu">
                    <i class="bi bi-printer"></i> Imprimer le Reçu
                </a></p>
            </div>

     <div class="container border">

    <?php
    // Inclure le fichier de connexion
    include('connexion.php');

if (isset($_GET['trimestre'])) {
    $trimestre = $_GET['trimestre'];
    if ($trimestre == '1er trimestre') {
        // Insérez ici le code pour le 1er et le 2ème trimestre
    
            if (isset($_GET['id'])) {
                $selectedStudentId = $_GET['id'];
                $selectedBulletinId = $_GET['id'];
            
                // Récupérer les informations de l'élève
                $req_eleve = "SELECT * FROM eleve join bulletin ON bulletin.IDELEVE_BUL = eleve.IDELEVE WHERE IDELEVE = $selectedStudentId";
                $resultat_eleve = mysqli_query($congestschool, $req_eleve);
            
                if ($resultat_eleve && mysqli_num_rows($resultat_eleve) > 0) {
                    $eleve = mysqli_fetch_assoc($resultat_eleve);
                    // Afficher les informations de l'élève
                    echo '<h6 class="text-center text-dark">BULLETIN DE NOTES</h6></br>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Nom : " . $eleve['NOM'] . " </strong></p>";
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Prénom :" . $eleve['PRENOM'] . " </strong></p>";
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>TRIMESTRE : " . $eleve['TRIMESTRE'] . " </strong></p>";
                    echo '</div>';

                
                    // Récupérer les informations de la classe de l'élève depuis la table d'affectation
                    $req_affectation = "SELECT * FROM affectation  WHERE ID_ELEVE = $selectedStudentId";
                    $resultat_affectation = mysqli_query($congestschool, $req_affectation);
            
                    if ($resultat_affectation && mysqli_num_rows($resultat_affectation) > 0) {
                        $affectation = mysqli_fetch_assoc($resultat_affectation);
                        $classeId = $affectation['ID_CLASSE'];
                        $enseignantId = $affectation['ID_ENSIGNANT'];
            
                        // Récupérer les informations de la classe à partir de son ID
                        $req_classe = "SELECT * FROM classe WHERE IDCLASSE = $classeId";
                        $resultat_classe = mysqli_query($congestschool, $req_classe);
            
                        if ($resultat_classe && mysqli_num_rows($resultat_classe) > 0) {
                            $classe = mysqli_fetch_assoc($resultat_classe);
                            // Afficher les informations sur la classe
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Classe :" . $classe['NOMCLASSE'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                            echo '<div  class="row">';

                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Année scolaire :" . $classe['ANNEACCADEMIQUE'] . " </strong></p>";
                            echo '</div>';
                        
                            }
                        $req_classe1 = "SELECT * FROM enseignant WHERE IDENSEIGNANT = $enseignantId";
                        $resultat_enseignant1 = mysqli_query($congestschool, $req_classe1);
            
                        if ($resultat_enseignant1 && mysqli_num_rows($resultat_enseignant1) > 0) {
                            $enseignant = mysqli_fetch_assoc($resultat_enseignant1);
                            // Afficher les informations sur l'enseignant
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Enseignant :" . $enseignant['NOMENSEIGNANT'] . ' ' . $enseignant['PRENNOMENSEIGNANT'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
        ?>

        <?php
                // Récupérer les données du bulletin pour l'élève spécifique
                $req_bulletin = "SELECT bulletin.*, notes.*, matiere.* 
                                FROM bulletin 
                                JOIN notes ON notes.ID_BULLETIN_NOTE = bulletin.IDBULLETIN 
                                JOIN matiere ON matiere.IDMATIERE = notes.ID_MATIERE_NOTE 
                                WHERE IDELEVE_BUL = $selectedBulletinId";
                $result_bulletin = mysqli_query($congestschool, $req_bulletin);

                // Vérifier si la requête a réussi
                if (!$result_bulletin) {
                    die('Requête invalide : ' . mysqli_error($congestschool));
                }

                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>Matière</th>';
                echo '<th>Note</th>';
                echo '<th>Coefficient</th>';
                echo '<th>Nombre de points</th>';
                echo '<th>Appréciation</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $rows = [];
                
                $sum = 0;
                $totalCoefficient = 0;
                while ($row = mysqli_fetch_assoc($result_bulletin)) {
                    // Utiliser les données de la base de données pour chaque ligne du bulletin
                    $rows[] = $row;
                    echo '<tr>';
                    echo '<td>' . $row['LIBELLE'] . '</td>';
                    echo '<td>' . $row['NOTE'] . '</td>';
                    echo '<td>' . $row['COEFFICIENT'] . '</td>';
                
                    $sum += $row['NOTE'] * $row['COEFFICIENT'];
                    $totalCoefficient += $row['COEFFICIENT'];
                
                    echo '<td>' . ($row['NOTE'] * $row['COEFFICIENT']) . ' points </td>';
                    echo '</tr>';
                }
                
                echo '<tr>';
                echo '<td colspan="2"><b>Total</b></td>';
                echo '<td><b>' . $totalCoefficient . '</b></td>';
                echo '<td><b>' . $sum . ' points </b></td>';
                echo '<td></td>';
                echo '</tr>';
                
                // Calculer et afficher la moyenne
                if ($totalCoefficient != 0) {
                    $average = $sum / $totalCoefficient;
                } else {
                    $average = 0;
                }
                
                echo '<tr>';
                echo '<td colspan="3"><strong>Moyenne</strong></td>';
                echo '<td>' . $average . '</td>';
                echo '<td class="no-border">';        
                if ($average < 5) {
                    echo '<b>Insuffisant</b>';
                } else if ($average >= 5 && $average < 7) {
                    echo '<b>Passable</b>';
                } else if ($average >= 7 && $average < 9) {
                    echo '<b>Bien</b>';
                } else if ($average >= 9 && $average < 10) {
                    echo '<b>Très bien</b>';
                } else {
                    echo '<b>Excellent';
                }
                
                echo '</td>';
                echo '</tr>';
            //...

        $req_moyennes = "SELECT eleve.IDELEVE, AVG(notes.NOTE * matiere.COEFFICIENT) AS MOYENNE 
        FROM eleve 
        JOIN affectation ON eleve.IDELEVE = affectation.ID_ELEVE 
        JOIN bulletin ON eleve.IDELEVE = bulletin.IDELEVE_BUL 
        JOIN notes ON bulletin.IDBULLETIN = notes.ID_BULLETIN_NOTE 
        JOIN matiere ON notes.ID_MATIERE_NOTE = matiere.IDMATIERE
        WHERE affectation.ID_CLASSE = $classeId 
        GROUP BY eleve.IDELEVE";

        $result_moyennes = mysqli_query($congestschool, $req_moyennes);

        if (!$result_moyennes) {
        printf("Erreur : %s\n", mysqli_error($congestschool));
        exit();
        }

        $moyennes = [];
        while ($row_moyenne = mysqli_fetch_assoc($result_moyennes)) {
        $moyennes[$row_moyenne['IDELEVE']] = $row_moyenne['MOYENNE'];
        }
        arsort($moyennes);
        $rang = array_search($average, $moyennes) + 1;

        // Ajouter une ligne dans le tableau avec le rang de l'élève
        echo '<tr>';
        echo '<td colspan="4"><strong>Rang</strong></td>';
        echo '<td>' . $rang . '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        //...

                
            }   
        }
        else if($trimestre == '2em trimestre') {
            if (isset($_GET['id'])) {
                $selectedStudentId = $_GET['id'];
                $selectedBulletinId = $_GET['id'];
            
                // Récupérer les informations de l'élève
                $req_eleve = "SELECT * FROM eleve join bulletin ON bulletin.IDELEVE_BUL = eleve.IDELEVE WHERE IDELEVE = $selectedStudentId";
                $resultat_eleve = mysqli_query($congestschool, $req_eleve);
            
                if ($resultat_eleve && mysqli_num_rows($resultat_eleve) > 0) {
                    $eleve = mysqli_fetch_assoc($resultat_eleve);
                    // Afficher les informations de l'élève
                    echo '<h6 class="text-center text-dark">BULLETIN DE NOTES</h6></br>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Nom : " . $eleve['NOM'] . " </strong></p>";
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Prénom :" . $eleve['PRENOM'] . " </strong></p>";
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>TRIMESTRE : " . $eleve['TRIMESTRE'] . " </strong></p>";
                    echo '</div>';

                
                    // Récupérer les informations de la classe de l'élève depuis la table d'affectation
                    $req_affectation = "SELECT * FROM affectation  WHERE ID_ELEVE = $selectedStudentId";
                    $resultat_affectation = mysqli_query($congestschool, $req_affectation);
            
                    if ($resultat_affectation && mysqli_num_rows($resultat_affectation) > 0) {
                        $affectation = mysqli_fetch_assoc($resultat_affectation);
                        $classeId = $affectation['ID_CLASSE'];
                        $enseignantId = $affectation['ID_ENSIGNANT'];
            
                        // Récupérer les informations de la classe à partir de son ID
                        $req_classe = "SELECT * FROM classe WHERE IDCLASSE = $classeId";
                        $resultat_classe = mysqli_query($congestschool, $req_classe);
            
                        if ($resultat_classe && mysqli_num_rows($resultat_classe) > 0) {
                            $classe = mysqli_fetch_assoc($resultat_classe);
                            // Afficher les informations sur la classe
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Classe :" . $classe['NOMCLASSE'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                            echo '<div  class="row">';

                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Année scolaire :" . $classe['ANNEACCADEMIQUE'] . " </strong></p>";
                            echo '</div>';
                        
                            }
                        $req_classe1 = "SELECT * FROM enseignant WHERE IDENSEIGNANT = $enseignantId";
                        $resultat_enseignant1 = mysqli_query($congestschool, $req_classe1);
            
                        if ($resultat_enseignant1 && mysqli_num_rows($resultat_enseignant1) > 0) {
                            $enseignant = mysqli_fetch_assoc($resultat_enseignant1);
                            // Afficher les informations sur l'enseignant
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Enseignant :" . $enseignant['NOMENSEIGNANT'] . ' ' . $enseignant['PRENNOMENSEIGNANT'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
        ?>

        <?php
                // Récupérer les données du bulletin pour l'élève spécifique

                    $req_bulletin = "SELECT bulletin.*, notes.*, matiere.* 
                                        FROM bulletin 
                                        JOIN notes ON notes.ID_BULLETIN_NOTE = bulletin.IDBULLETIN 
                                        JOIN matiere ON matiere.IDMATIERE = notes.ID_MATIERE_NOTE 
                                        WHERE IDELEVE_BUL = $selectedBulletinId 
                                        AND TRIMESTRE = '2em trimestre'";
                $result_bulletin = mysqli_query($congestschool, $req_bulletin);

                // Vérifier si la requête a réussi
                if (!$result_bulletin) {
                    die('Requête invalide : ' . mysqli_error($congestschool));
                }

                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>Matière</th>';
                echo '<th>Note</th>';
                echo '<th>Coefficient</th>';
                echo '<th>Nombre de points</th>';
                echo '<th>Appréciation</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $rows = [];
                
                $sum = 0;
                $totalCoefficient = 0;
                while ($row = mysqli_fetch_assoc($result_bulletin)) {
                    // Utiliser les données de la base de données pour chaque ligne du bulletin
                    $rows[] = $row;
                    echo '<tr>';
                    echo '<td>' . $row['LIBELLE'] . '</td>';
                    echo '<td>' . $row['NOTE'] . '</td>';
                    echo '<td>' . $row['COEFFICIENT'] . '</td>';
                
                    $sum += $row['NOTE'] * $row['COEFFICIENT'];
                    $totalCoefficient += $row['COEFFICIENT'];
                
                    echo '<td>' . ($row['NOTE'] * $row['COEFFICIENT']) . ' points </td>';
                    echo '</tr>';
                }
                
                echo '<tr>';
                echo '<td colspan="2"><b>Total</b></td>';
                echo '<td><b>' . $totalCoefficient . '</b></td>';
                echo '<td><b>' . $sum . ' points </b></td>';
                echo '<td></td>';
                echo '</tr>';
                
                // Calculer et afficher la moyenne
                if ($totalCoefficient != 0) {
                    $average = $sum / $totalCoefficient;
                } else {
                    $average = 0;
                }
                
                echo '<tr>';
                echo '<td colspan="3"><strong>Moyenne</strong></td>';
                echo '<td>' . $average . '</td>';
                echo '<td class="no-border">';        
                if ($average < 5) {
                    echo '<b>Insuffisant</b>';
                } else if ($average >= 5 && $average < 7) {
                    echo '<b>Passable</b>';
                } else if ($average >= 7 && $average < 9) {
                    echo '<b>Bien</b>';
                } else if ($average >= 9 && $average < 10) {
                    echo '<b>Très bien</b>';
                } else {
                    echo '<b>Excellent';
                }
                
                echo '</td>';
                echo '</tr>';
            //...

        $req_moyennes = "SELECT eleve.IDELEVE, AVG(notes.NOTE * matiere.COEFFICIENT) AS MOYENNE 
        FROM eleve 
        JOIN affectation ON eleve.IDELEVE = affectation.ID_ELEVE 
        JOIN bulletin ON eleve.IDELEVE = bulletin.IDELEVE_BUL 
        JOIN notes ON bulletin.IDBULLETIN = notes.ID_BULLETIN_NOTE 
        JOIN matiere ON notes.ID_MATIERE_NOTE = matiere.IDMATIERE
        WHERE affectation.ID_CLASSE = $classeId 
        GROUP BY eleve.IDELEVE";

        $result_moyennes = mysqli_query($congestschool, $req_moyennes);

        if (!$result_moyennes) {
        printf("Erreur : %s\n", mysqli_error($congestschool));
        exit();
        }

        $moyennes = [];
        while ($row_moyenne = mysqli_fetch_assoc($result_moyennes)) {
        $moyennes[$row_moyenne['IDELEVE']] = $row_moyenne['MOYENNE'];
        }
        arsort($moyennes);
        $rang = array_search($average, $moyennes) + 1;

        // Ajouter une ligne dans le tableau avec le rang de l'élève
        echo '<tr>';
        echo '<td colspan="4"><strong>Rang</strong></td>';
        echo '<td>' . $rang . '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        //...

                
            }  
        }
        else if($trimestre =='3em trimestre') {
            // Code pour le 3ème trimestre
            $selectedStudentId=$_GET['id'];
            $selectedBulletinId=$_GET['id'];
    
                // Récupérer les informations de l'élève
                $req_eleve = "SELECT * FROM eleve join bulletin ON bulletin.IDELEVE_BUL = eleve.IDELEVE WHERE IDELEVE = $selectedStudentId";
                $resultat_eleve = mysqli_query($congestschool, $req_eleve);
            
                if ($resultat_eleve && mysqli_num_rows($resultat_eleve) > 0) {
                    $eleve = mysqli_fetch_assoc($resultat_eleve);
                    // Afficher les informations de l'élève
                    echo '<h6 class="text-center text-dark">BULLETIN DE NOTES</h6></br>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Nom : " . $eleve['NOM'] . " </strong></p>";
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>Prénom :" . $eleve['PRENOM'] . " </strong></p>";
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<div class="col-md-6">';
                    echo "<p class='text-dark'><strong>TRIMESTRE : " . $eleve['TRIMESTRE'] . " </strong></p>";
                    echo '</div>';

                
                    // Récupérer les informations de la classe de l'élève depuis la table d'affectation
                    $req_affectation = "SELECT * FROM affectation  WHERE ID_ELEVE = $selectedStudentId";
                    $resultat_affectation = mysqli_query($congestschool, $req_affectation);
            
                    if ($resultat_affectation && mysqli_num_rows($resultat_affectation) > 0) {
                        $affectation = mysqli_fetch_assoc($resultat_affectation);
                        $classeId = $affectation['ID_CLASSE'];
                        $enseignantId = $affectation['ID_ENSIGNANT'];
            
                        // Récupérer les informations de la classe à partir de son ID
                        $req_classe = "SELECT * FROM classe WHERE IDCLASSE = $classeId";
                        $resultat_classe = mysqli_query($congestschool, $req_classe);
            
                        if ($resultat_classe && mysqli_num_rows($resultat_classe) > 0) {
                            $classe = mysqli_fetch_assoc($resultat_classe);
                            // Afficher les informations sur la classe
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Classe :" . $classe['NOMCLASSE'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                            echo '<div  class="row">';

                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Année scolaire :" . $classe['ANNEACCADEMIQUE'] . " </strong></p>";
                            echo '</div>';
                        
                            }
                        $req_classe1 = "SELECT * FROM enseignant WHERE IDENSEIGNANT = $enseignantId";
                        $resultat_enseignant1 = mysqli_query($congestschool, $req_classe1);
            
                        if ($resultat_enseignant1 && mysqli_num_rows($resultat_enseignant1) > 0) {
                            $enseignant = mysqli_fetch_assoc($resultat_enseignant1);
                            // Afficher les informations sur l'enseignant
                        
                            echo '<div class="col-md-6">';
                            echo "<p class='text-dark'><strong>Enseignant :" . $enseignant['NOMENSEIGNANT'] . ' ' . $enseignant['PRENNOMENSEIGNANT'] . " </strong></p>";
                            echo '</div>';
                            echo '</div>';
                        }
                  
        ?>

        <?php
        $classeId='';
        
                // Récupérer les données du bulletin pour l'élève spécifique
                $req_bulletin = "SELECT bulletin.*, notes.*, matiere.* 
                                FROM bulletin 
                                JOIN notes ON notes.ID_BULLETIN_NOTE = bulletin.IDBULLETIN 
                                JOIN matiere ON matiere.IDMATIERE = notes.ID_MATIERE_NOTE 
                                WHERE IDELEVE_BUL = $selectedBulletinId ";
                $result_bulletin = mysqli_query($congestschool, $req_bulletin);

                // Vérifier si la requête a réussi
                if (!$result_bulletin) {
                    die('Requête invalide : ' . mysqli_error($congestschool));
                }

                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>Matière</th>';
                echo '<th>Note</th>';
                echo '<th>Coefficient</th>';
                echo '<th>Nombre de points</th>';
                echo '<th>Appréciation</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $rows = [];
                
                $sum = 0;
                $totalCoefficient = 0;
                while ($row = mysqli_fetch_assoc($result_bulletin)) {
                    // Utiliser les données de la base de données pour chaque ligne du bulletin
                    $rows[] = $row;
                    echo '<tr>';
                    echo '<td>' . $row['LIBELLE'] . '</td>';
                    echo '<td>' . $row['NOTE'] . '</td>';
                    echo '<td>' . $row['COEFFICIENT'] . '</td>';
                
                    $sum += $row['NOTE'] * $row['COEFFICIENT'];
                    $totalCoefficient += $row['COEFFICIENT'];
                
                    echo '<td>' . ($row['NOTE'] * $row['COEFFICIENT']) . ' points </td>';
                    echo '</tr>';
                }
                
                echo '<tr>';
                echo '<td colspan="2"><b>Total</b></td>';
                echo '<td><b>' . $totalCoefficient . '</b></td>';
                echo '<td><b>' . $sum . ' points </b></td>';
                echo '<td></td>';
                echo '</tr>';
                
                // Calculer et afficher la moyenne
                if ($totalCoefficient != 0) {
                    $average = $sum / $totalCoefficient;
                } else {
                    $average = 0;
                }
                
                echo '<tr>';
                echo '<td colspan="3"><strong>Moyenne</strong></td>';
                echo '<td>' . $average . '</td>';
                echo '<td class="no-border">';        
                if ($average < 5) {
                    echo '<b>Insuffisant</b>';
                } else if ($average >= 5 && $average < 7) {
                    echo '<b>Passable</b>';
                } else if ($average >= 7 && $average < 9) {
                    echo '<b>Bien</b>';
                } else if ($average >= 9 && $average < 10) {
                    echo '<b>Très bien</b>';
                } else {
                    echo '<b>Excellent';
                }
                
                echo '</td>';
                echo '</tr>';
            //...

            $req_moyennes = "SELECT eleve.IDELEVE, AVG(notes.NOTE * matiere.COEFFICIENT) AS MOYENNE 
            FROM eleve 
            JOIN affectation ON eleve.IDELEVE = affectation.ID_ELEVE 
            JOIN bulletin ON eleve.IDELEVE = bulletin.IDELEVE_BUL 
            JOIN notes ON bulletin.IDBULLETIN = notes.ID_BULLETIN_NOTE 
            JOIN matiere ON notes.ID_MATIERE_NOTE = matiere.IDMATIERE
            WHERE affectation.ID_CLASSE = '$classeId' 
            GROUP BY eleve.IDELEVE";
    
    
        $result_moyennes = mysqli_query($congestschool, $req_moyennes);

        if (!$result_moyennes) {
        printf("Erreur : %s\n", mysqli_error($congestschool));
        exit();
        }

        $moyennes = [];
        while ($row_moyenne = mysqli_fetch_assoc($result_moyennes)) {
        $moyennes[$row_moyenne['IDELEVE']] = $row_moyenne['MOYENNE'];
        }
        arsort($moyennes);
        $rang = array_search($average, $moyennes) + 1;

        // Ajouter une ligne dans le tableau avec le rang de l'élève
        echo '<tr>';
        echo '<td colspan="4"><strong>Rang</strong></td>';
        echo '<td>' . $rang . '</td>';
        echo '</tr>';
        // Calcul des moyennes des trois trimestres
$req_moyenne_trimestre = "SELECT AVG(notes.NOTE * matiere.COEFFICIENT) AS MOYENNE_TRIMESTRE
FROM eleve
JOIN affectation ON eleve.IDELEVE = affectation.ID_ELEVE
JOIN bulletin ON eleve.IDELEVE = bulletin.IDELEVE_BUL
JOIN notes ON bulletin.IDBULLETIN = notes.ID_BULLETIN_NOTE
JOIN matiere ON notes.ID_MATIERE_NOTE = matiere.IDMATIERE
WHERE eleve.IDELEVE = $selectedStudentId
AND eleve.TRIMESTRE IN ('1er trimestre', '2em trimestre', '3em trimestre')"; // Vous pouvez ajuster cette condition en fonction de la manière dont les trimestres sont enregistrés dans votre base de données

$result_moyenne_trimestre = mysqli_query($congestschool, $req_moyenne_trimestre);

$sum_moyennes_trimestre = 0;
$count_moyennes_trimestre = 0;

while ($row_moyenne_trimestre = mysqli_fetch_assoc($result_moyenne_trimestre)) {
    $sum_moyennes_trimestre += $row_moyenne_trimestre['MOYENNE_TRIMESTRE'];
    $count_moyennes_trimestre++;
}

// Calcul de la moyenne générale
if ($count_moyennes_trimestre > 0) {
    $moyenne_generale_value = $sum_moyennes_trimestre / $count_moyennes_trimestre;
    // Afficher la moyenne générale
    echo '<tr>';
    echo '<td colspan="3"><strong>Moyenne Générale</strong></td>';
    echo '<td>' . $moyenne_generale_value . '</td>';
    echo '<td></td>';
    echo '</tr>';

    // Calcul du rang annuel
    // Vous pouvez utiliser la même logique que précédemment pour calculer le rang annuel en fonction de la moyenne générale calculée ici.
}


        echo '</tbody>';
        echo '</table>';
        //...

                
            }   
        }
        }
    }
    ?>
   </div>
      </div>
    </div>
</div>
<script>
            document.getElementById('imprimerRecu').addEventListener('click', function () {
                window.print();
            });
        </script>
</body>
</html>
