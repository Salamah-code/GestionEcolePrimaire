<?php
require_once 'connexion.php'; // Inclure la connexion à la base de données

if (isset($_POST['valider'])) {
    $idclasse = addslashes(htmlspecialchars($_POST['idclasse']));
    $jour = addslashes(htmlspecialchars($_POST['jour']));
    $hdebut = $_POST['hdebut'];
    $hfin = $_POST['hfin'];

    // Vérifier s'il existe déjà une entrée similaire
    $verification_query = "SELECT * FROM emploidutemps WHERE ID_CLASSE_EMPT = '$idclasse' AND JOUR = '$jour' AND HDEBUT = '$hdebut' AND HFIN = '$hfin'";
    $verification_result = mysqli_query($congestschool, $verification_query);

    if (mysqli_num_rows($verification_result) > 0) {
        echo "<script type=\"text/javascript\">
            alert(\"Une entrée similaire existe déjà pour cette classe le même jour avec les mêmes heures de début et de fin.\");
            </script>";
        echo '<meta http-equiv="refresh" content="1;url=formEDT.php" />';
    } else {
        // Insérer les données dans la base de données car aucune entrée similaire n'a été trouvée
        $requete_Ajout = "INSERT INTO emploidutemps(ID_CLASSE_EMPT, JOUR, HDEBUT, HFIN)
            VALUES('$idclasse','$jour','$hdebut', '$hfin')";

        $resultat = mysqli_query($congestschool, $requete_Ajout);

        if ($resultat) {
            echo "<script type=\"text/javascript\">
                alert(\"Enregistrement effectué avec succès !\");
                </script>";
            echo '<meta http-equiv="refresh" content="1;url=formEDT.php" />';
        } else {
            echo "<script type=\"text/javascript\">
                alert(\"Enregistrement non effectué !\");
                </script>";
            echo '<meta http-equiv="refresh" content="1;url=formEDT.php" />';
        }
    }
}
