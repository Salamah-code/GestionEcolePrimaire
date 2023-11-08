<?php
require_once 'connexion.php';

// Récupérer la liste des classes distinctes
$sql_classes = "SELECT DISTINCT c.IDCLASSE, c.NOMCLASSE, c.NIVEAU, c.ANNEACCADEMIQUE, c.EFFECTIF FROM classe c";
$result_classes = mysqli_query($congestschool, $sql_classes);

// Commencer la sortie HTML
echo '<div class="container">';
echo '<div class="row">';

// Parcourir chaque classe
$count = 0; // Compteur de classes par ligne
while ($row_class = mysqli_fetch_assoc($result_classes)) {
    $class_id = $row_class['IDCLASSE'];
    $class_name = $row_class['NOMCLASSE'];
    $class_level = $row_class['NIVEAU'];
    $class_academic_year = $row_class['ANNEACCADEMIQUE'];
    $class_capacity = $row_class['EFFECTIF'];

    // Vérifier si nous devons fermer la rangée actuelle et en ouvrir une nouvelle
    if ($count % 4 == 0 && $count != 0) {
        echo '</div>'; // Fermer la rangée précédente
        echo '<div class="row">'; // Ouvrir une nouvelle rangée
    }

    // Afficher les informations de la classe dans une div col-3
    echo '<div class="col-3">';
    echo "<h5>Classe : $class_name ($class_level)</h5>";
    echo "<p>Année académique : $class_academic_year</p>";
    echo "<p>Capacité : $class_capacity</p>";

    // Obtenir la liste des élèves dans cette classe
    $sql_students = "SELECT e.MATRICULE, e.NOM, e.PRENOM FROM eleve e
                     INNER JOIN affectation a ON e.IDELEVE = a.ID_ELEVE
                     WHERE a.ID_CLASSE = $class_id";
    $result_students = mysqli_query($congestschool, $sql_students);

    // Commencer la liste des élèves en colonnes
    echo '<ul>';
    while ($row_student = mysqli_fetch_assoc($result_students)) {
        $student_matricule = $row_student['MATRICULE'];
        $student_nom = $row_student['NOM'];
        $student_prenom = $row_student['PRENOM'];

        // Afficher chaque élève dans une colonne
        echo "<li>$student_matricule - $student_nom $student_prenom</li>";
    }
    echo '</ul>';
    echo '</div>'; // Fermer la div col-3

    $count++; // Incrémenter le compteur de classes
}

echo '</div>'; // Fermer la dernière rangée
echo '</div>'; // Fermer la container

// Fermer la connexion à la base de données
mysqli_close($congestschool);
?>
