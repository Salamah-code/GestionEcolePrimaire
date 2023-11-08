<?php
require_once 'connexion.php'; // Inclure la connexion à la base de données

if (isset($_POST['valider'])) {
    $numero = mysqli_real_escape_string($congestschool, $_POST['numero']);
    $date = mysqli_real_escape_string($congestschool, $_POST['date']);
    $montant = mysqli_real_escape_string($congestschool, $_POST['montant']);
    $mois = mysqli_real_escape_string($congestschool, $_POST['mois']);
    $motif = mysqli_real_escape_string($congestschool, $_POST['motif']);
    $mode = mysqli_real_escape_string($congestschool, $_POST['mode']);
    $details = mysqli_real_escape_string($congestschool, $_POST['detail']);

    // Vérifier si l'élève a déjà payé pour ce mois
    $requeteVerification = "SELECT * FROM paiementscoloarite WHERE NUMERO_INSC = '$numero' AND MOIS = '$mois' AND MOTIF ='$motif' AND YEAR(DATEPAIEMENT)='$date'";
    $resultatVerification = mysqli_query($congestschool, $requeteVerification);

    if ($resultatVerification) {
        if (mysqli_num_rows($resultatVerification) > 0) {
            echo "<script type=\"text/javascript\">
                alert(\"Cet élève a déjà effectué un paiement pour ce mois.\");
            </script>";
            echo '<meta http-equiv="refresh" content="1;url=formScolarite.php" />';
        } else {
            // Aucun paiement existant pour ce mois, procéder à l'ajout
            $requeteAjout = "INSERT INTO paiementscoloarite(NUMERO_INSC, DATEPAIEMENT, MONTANTPAIEMENT, MOIS, MOTIF, MODEPAIEMENT, DETAILS)
            VALUES('$numero','$date','$montant', '$mois','$motif','$mode', '$details')";
            $resultatAjout = mysqli_query($congestschool, $requeteAjout);

            if ($resultatAjout) {
                echo "<script type=\"text/javascript\">
                    alert(\"Enregistrement effectué avec succès!\");
                </script>";
                echo '<meta http-equiv="refresh" content="1;url=formScolarite.php" />';
            } else {
                echo "<script type=\"text/javascript\">
                    alert(\"Erreur lors de l'enregistrement!\");
                </script>";
                echo '<meta http-equiv="refresh" content="1;url=formScolarite.php" />';
            }
        }
    } else {
        echo "Erreur de requête : " . mysqli_error($congestschool);
    }
}
?>
