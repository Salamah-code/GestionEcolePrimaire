<?php
require_once 'connexion.php';

if (isset($_POST['valider'])) {
    $libelle = mysqli_real_escape_string($congestschool, htmlspecialchars($_POST['libelle']));
    $coef = floatval($_POST['coef']);
    $idclasse = intval($_POST['idclasse']);

    // Vérifier si la matière existe déjà pour cette classe
    $existingAssignmentQuery = "SELECT IDMATIERE FROM matiere WHERE LIBELLE = ? AND ID_CLASS_MAT = ?";
    $stmt = mysqli_prepare($congestschool, $existingAssignmentQuery);
    mysqli_stmt_bind_param($stmt, "si", $libelle, $idclasse);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script type=\"text/javascript\">
           alert(\"Cette matière existe déjà pour cette classe.\");
           </script>";
        echo '<meta http-equiv="refresh" content="1;url=formMatiere.php" />';
    } else {
        // Commencer une transaction
        mysqli_begin_transaction($congestschool);

        $requete_Ajout = "INSERT INTO matiere(LIBELLE, COEFFICIENT, ID_CLASS_MAT) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($congestschool, $requete_Ajout);
        mysqli_stmt_bind_param($stmt, "sdi", $libelle, $coef, $idclasse);
        $resultat = mysqli_stmt_execute($stmt);

        if ($resultat) {
            // Valider la transaction
            mysqli_commit($congestschool);
            echo "<script type=\"text/javascript\">
                alert(\"Enregistrement effectué avec succès!\");
                </script>";
            echo '<meta http-equiv="refresh" content="1;url=formMatiere.php" />';
        } else {
            // Annuler la transaction en cas d'échec
            mysqli_rollback($congestschool);
            echo "<script type=\"text/javascript\">
                alert(\"Enregistrement non effectué !\");
                </script>";
            echo '<meta http-equiv="refresh" content="1;url=formMatiere.php" />';
        }
    }
}
?>
