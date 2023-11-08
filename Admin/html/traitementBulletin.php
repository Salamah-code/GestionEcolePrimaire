<?php
// Connexion à la base de données
require_once 'connexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Initialisation de la variable $insertResult
$insertResult = false;

// ... (autres parties de votre code)


if (isset($_POST['valider'])) {
    // Récupérer les données du formulaire
    $ideleve = addslashes(htmlspecialchars($_POST['ideleve']));
    $an = addslashes(htmlspecialchars($_POST['txtannee']));
    $trimestre = addslashes(htmlspecialchars($_POST['trimestre']));

    // Validation et traitement des données si nécessaire

   // Vérifier si un bulletin existe déjà pour cet élève, cette année scolaire et ce trimestre
$existingBulletinsQuery = "SELECT * FROM bulletin WHERE IDELEVE_BUL='$ideleve' AND ANNEESCOLAIRE='$an' AND TRIMESTRE='$trimestre'";
$existingBulletinsResult = mysqli_query($congestschool, $existingBulletinsQuery);

if (mysqli_num_rows($existingBulletinsResult) > 0) {
    echo "<script type=\"text/javascript\">
        alert (\"Un bulletin pour ce trimestre et cette année existe déjà pour cet élève!\");
    </script>";
    // Rediriger vers une page appropriée ou faire d'autres actions en conséquence
} else {
    // Aucun bulletin n'existe pour cet élève, cette année scolaire et ce trimestre, procéder à l'insertion
    $insertQuery = "INSERT INTO `bulletin`(`IDELEVE_BUL`, `ANNEESCOLAIRE`, `TRIMESTRE`) VALUES ('$ideleve', '$an', '$trimestre')";
    $insertResult = mysqli_query($congestschool, $insertQuery);

    if ($insertResult) {
        $idbulletin = mysqli_insert_id($congestschool); // Récupération de l'ID du dernier enregistrement inséré

        echo "<script type=\"text/javascript\">
            alert (\"Enregistrement effectué avec Succès!\");
        </script>";
        echo '<meta http-equiv="refresh" content="1;url=ajouter_note.php?idbulletin=' . $idbulletin . '" />';
    } else {
        echo "<script type=\"text/javascript\">
            alert (\"Enregistrement non effectué!\");
        </script>";
        // Rediriger vers une page appropriée ou faire d'autres actions en conséquence
    }
}

}
?>
