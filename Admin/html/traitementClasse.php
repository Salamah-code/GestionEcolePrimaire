
<?php
require_once 'connexion.php'; // On inclu la connexion à la bdd

if (isset($_POST['valider'])) {

     $idsalle = addslashes(htmlspecialchars($_POST['idsalle'])); 
    $libelle= addslashes(htmlspecialchars($_POST['txtnom']));
    $niveau= addslashes(htmlspecialchars($_POST['txtniveau']));
    $annee= addslashes(htmlspecialchars($_POST['txtannee']));
    $effectif= addslashes(htmlspecialchars($_POST['txteffectif']));

  


    $existingAssignmentQuery = "SELECT IDCLASSE FROM classe WHERE ID_SALLE = '$idsalle' OR NOMCLASSE='$libelle' AND NIVEAU='$niveau' AND ANNEACCADEMIQUE='$annee' AND EFFECTIF='$effectif'";   
     $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);
    $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);

  


    if (mysqli_num_rows($existingAssignmentResult) > 0) {
        echo "<script type=\"text/javascript\">
            alert (\"Cette classe existe déjà.\");
            </script>";
        echo '<meta http-equiv="refresh" content="1;url=formClasse.php" />';
    } else {
 
    $requete_Ajout = "INSERT INTO classe(ID_SALLE,NOMCLASSE, NIVEAU, ANNEACCADEMIQUE, EFFECTIF) VALUES 
    ('$idsalle','$libelle','$niveau','$annee',' $effectif')";

    $resultat = mysqli_query($congestschool, $requete_Ajout);


    if ($resultat) {
        echo "<script type=\"text/javascript\">

         alert (\"Enregistrement effectuer avec Succès!\");

    </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formClasse.php" />';
    } else {
        echo "<script type=\"text/javascript\">

            alert (\"Enregistrement non effectuer !\");

            </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formClasse.php" />';
    }
}
}
