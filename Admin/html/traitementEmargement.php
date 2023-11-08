<?php
require_once 'connexion.php'; // On inclu la connexion à la bdd

if (isset($_POST['valider'])) {

 
    $idclasse = addslashes(htmlspecialchars($_POST['idclasse']));
    $idenseignant = addslashes(htmlspecialchars($_POST['idenseignant']));
    $idmatiere = addslashes(htmlspecialchars($_POST['idmatiere']));
    $heure = addslashes(htmlspecialchars($_POST['heure']));
    $date =$_POST['date'];
    $trimestre = addslashes(htmlspecialchars($_POST['trimestre']));
    $annee = addslashes(htmlspecialchars($_POST['annee']));
  


    $requete_Ajout = "INSERT INTO emargement(ID_CLASSE, ID_ENSEIGNANT, ID_MATIERE,HEURE,DATE,TRIMESTRE,ANNEE)
        VALUES('$idclasse','$idenseignant','$idmatiere', '$heure','$date','$trimestre','$annee')";

    $resultat = mysqli_query($congestschool, $requete_Ajout);


    if ($resultat) {
        echo "<script type=\"text/javascript\">

         alert (\"Enregistrement effectuer avec Succès!\");

    </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formEmargement.php" />';
    } else {
        echo "<script type=\"text/javascript\">

            alert (\"Enregistrement non effectuer !\");

            </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formEmargement.php" />';
    }
}
