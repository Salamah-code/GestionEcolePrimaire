<!DOCTYPE html>
<html>
<head>
    <title>Bulletin de notes</title>
</head>
<body>
    <?php
    // Connexion à la base de données (à adapter à votre configuration)
    include('connexion.php');

    // Vérifier la connexion
    if(isset($_GET['idbulletin'])){
        $idbulletin = $_GET['idbulletin'];
      }
      

    // Récupérer le nom, prénom et classe de l'élève (à adapter à votre structure de base de données)
    $eleve_id = $_POST['id']; // Assurez-vous que vous avez l'ID de l'élève
    $eleve_query = "SELECT Nom, Prenom, Classe FROM eleves WHERE ID = $eleve_id";
    $eleve_result = $congestschool->query($eleve_query);
    $eleve = $eleve_result->fetch_assoc();

    // Récupérer les matières du bulletin
    $matieres_query = "SELECT * FROM matiere";
    $matieres_result = $congestschool->query($matieres_query);

    // Récupérer les notes du bulletin pour l'élève donné
    $bulletin_id = $_GET['bulletin_id']; // Assurez-vous que vous avez l'ID du bulletin
    $notes_query = "SELECT matiere.Libelle, notes.NOTE, matiere.COEFFICIENT
               FROM notes
               INNER JOIN matiere ON notes.ID_MATIERE_NOTE = matiere.IDMATIERE
               WHERE notes.ID_BULLETIN_NOTE = $bulletin_id";
    $notes_result = $congestschool->query($notes_query);

    ?>

    <h1>Bulletin de notes de <?php echo $eleve['Prenom'] . ' ' . $eleve['Nom']; ?> - Classe <?php echo $eleve['Classe']; ?></h1>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Coefficient</th>
                <th>Moyenne</th>
                <th>Appréciation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_points = 0;
            $total_coefficients = 0;
            while ($row = $notes_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Libelle'] . "</td>";
                echo "<td>" . $row['NOTE'] . "</td>";
                echo "<td>" . $row['COEFFICIENT'] . "</td>";

                $total_points += $row['NOTE'] * $row['COEFFICIENT'];
                $total_coefficients += $row['COEFFICIENT'];

                // Calculez la moyenne et l'appréciation ici
                $moyenne = $total_coefficients > 0 ? $total_points / $total_coefficients : 0;
                $appreciation = "Appréciation à définir";

                echo "<td>" . $moyenne . "</td>";
                echo "<td>" . $appreciation . "</td>";

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Fermez la connexion à la base de données à la fin
$congestschool->close();
?>
