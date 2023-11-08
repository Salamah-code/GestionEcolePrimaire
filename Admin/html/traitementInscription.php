<?php
require_once 'connexion.php'; // On inclut la connexion à la base de données

if (isset($_POST['valider'])) {
    $ideleve = addslashes(htmlspecialchars($_POST['ideleve']));
    $idclasse = addslashes(htmlspecialchars($_POST['idclasse']));
    $date = $_POST['date'];
    $montant = addslashes(htmlspecialchars($_POST['montant']));
    $details = addslashes(htmlspecialchars($_POST['details']));
  
    // Vérifier si l'élève est déjà inscrit la même année
    $annee = date('Y', strtotime($date));
    $requete_Verification = "SELECT * FROM inscription WHERE IDELEVE_INSC = '$ideleve' AND YEAR(DATE) = $annee";
    $resultat_Verification = mysqli_query($congestschool, $requete_Verification);

    if (mysqli_num_rows($resultat_Verification) > 0) {
        echo "<script type=\"text/javascript\">
            alert (\"L'élève est déjà inscrit pour cette année!\");
        </script>";
        echo '<meta http-equiv="refresh" content="1;url=formInscription.php" />';
    } else {
        // Si l'élève n'est pas déjà inscrit pour cette année, effectuer l'inscription
        $requete_Ajout = "INSERT INTO inscription(IDELEVE_INSC,IDCLASSE_INSC, DATE, MONTANTPAYE, DETAILS)
            VALUES('$ideleve','$idclasse','$date','$montant', '$details')";

        $resultat = mysqli_query($congestschool, $requete_Ajout);

        if ($resultat) {
            echo "<script type=\"text/javascript\">
                alert (\"Enregistrement effectué avec Succès!\");
            </script>";
            echo '<meta http-equiv="refresh" content="1;url=formInscription.php" />';
        } else {
            echo "<script type=\"text/javascript\">
                alert (\"Enregistrement non effectué !\");
            </script>";
            echo '<meta http-equiv="refresh" content="1;url=formInscription.php" />';
        }
    }
}
?>
