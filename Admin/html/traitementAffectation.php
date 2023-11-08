<?php
include('connexion.php');

if (isset($_POST['valider'])) {
    $idclasse = $_POST['idclasse'];
    $idenseignant = $_POST['idenseignant'];
    $date = $_POST['date'];

    // Vérifier s'il y a une affectation existante pour le même enseignant et la même année
    $requete_verification_enseignant = "SELECT * FROM affectation WHERE ID_ENSIGNANT = ? AND YEAR(date_affectation) = YEAR(?)";
    $stmt_verification_enseignant = mysqli_prepare($congestschool, $requete_verification_enseignant);
    mysqli_stmt_bind_param($stmt_verification_enseignant, 'ss', $idenseignant, $date);
    mysqli_stmt_execute($stmt_verification_enseignant);
    $resultat_verification_enseignant = mysqli_stmt_get_result($stmt_verification_enseignant);

    // Vérifier s'il y a une affectation existante pour la même classe et la même année
    $requete_verification_classe = "SELECT * FROM affectation WHERE ID_CLASSE = ? AND YEAR(date_affectation) = YEAR(?)";
    $stmt_verification_classe = mysqli_prepare($congestschool, $requete_verification_classe);
    mysqli_stmt_bind_param($stmt_verification_classe, 'ss', $idclasse, $date);
    mysqli_stmt_execute($stmt_verification_classe);
    $resultat_verification_classe = mysqli_stmt_get_result($stmt_verification_classe);

    if (mysqli_num_rows($resultat_verification_enseignant) > 0) {
        // Si une telle affectation existe pour l'enseignant, afficher un message d'erreur avec une couleur visuelle rouge pour l'enseignant
        echo "<script type=\"text/javascript\">
                alert(\"Cet enseignant est déjà affecté à une classe pour la même année académique\");
                document.getElementById('idenseignant').style.backgroundColor = 'red';
              </script>";
    } else if (mysqli_num_rows($resultat_verification_classe) > 0) {
        // Si une telle affectation existe pour la classe, afficher un message d'erreur avec une couleur visuelle rouge pour la classe
        echo "<script type=\"text/javascript\">
                alert(\"Cette classe a déjà un enseignant pour la même année académique\");
                document.getElementById('idclasse').style.backgroundColor = 'red';
              </script>";
    }
    else {
        // Si aucune affectation existante n'est trouvée, insérer l'affectation dans la base de données
        $requete_Ajout = "INSERT INTO affectation(ID_CLASSE, ID_ENSIGNANT, date_affectation) VALUES(?, ?, ?)";
        $stmt = mysqli_prepare($congestschool, $requete_Ajout);
        mysqli_stmt_bind_param($stmt, 'sss', $idclasse, $idenseignant, $date);
        $resultat = mysqli_stmt_execute($stmt);

        if ($resultat) {
            echo "<script type=\"text/javascript\">
                    alert (\"Enregistrement effectué avec succès!\");
                  </script>";
            echo '<meta http-equiv="refresh" content="1;url=formAffectation.php" />';
        } else {
            echo "<script type=\"text/javascript\">
                    alert (\"Enregistrement non effectué !\");
                  </script>";
            echo '<meta http-equiv="refresh" content="1;url=formAffectation.php" />';
        }
    }
}
?>
