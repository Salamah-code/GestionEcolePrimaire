<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>


<?php
include('../connexion.php');

$req_select = "SELECT * FROM classe";
$resultat2 = mysqli_query($congestschool, $req_select);
$nbr2 = mysqli_num_rows($resultat2);


// Vérification de l'ID de l'élève dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $class_id = $_GET['id'];

    // Requête préparée pour récupérer les détails de l'élève
    $sql = "SELECT * FROM `matiere` WHERE IDMATIERE = ?";
    $stmt = $congestschool->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo'<div class="d-flex flex-row bg-warning m-4">';


        while ($ligne = mysqli_fetch_assoc($result)) {
         
            
             echo' <div class="p-2 border border-dark bg-info">Libellé de la matiere : '. $ligne['LIBELLE'].'</div>';
             echo' <div class="p-2 border border-dark bg-info">Coefficient : ' . $ligne['COEFFICIENT'] . '</div>';
             echo' <div class="p-2 border border-dark bg-info">L identifiant de la classe : ' . $ligne['ID_CLASS_MAT'].'</div>';
               
            
        }
        echo "</div>";

        echo "</div>";
    } else {
        echo 'Aucune classe trouvé';
    }

    $stmt->close();
} else {
    echo 'ID classe non valide.';
}

// Fermeture de la connexion
$congestschool->close();
?>
