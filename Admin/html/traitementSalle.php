<?php
require_once 'connexion.php'; // On inclu la connexion à la bdd

// Si les variables existent et qu'elles ne sont pas vides
if (isset($_POST['valider'])) {

    // $matricule = addslashes(htmlspecialchars($_POST['txtmatricule']));
    // $nom = addslashes(htmlspecialchars($_POST['txtnom']));
    // Patch XSS
    $nomsalle = addslashes(htmlspecialchars($_POST['nomsalle']));
    $capacite = addslashes(htmlspecialchars($_POST['capacite']));
   
    $existingAssignmentQuery = "SELECT IDSALLE FROM salle WHERE NOMSALLE = '$nomsalle'";   
    $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);
   $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);

 


   if (mysqli_num_rows($existingAssignmentResult) > 0) {
       echo "<script type=\"text/javascript\">
           alert (\"Cette salle existe déjà.\");
           </script>";
       echo '<meta http-equiv="refresh" content="1;url=formSalle.php" />';
   } else {

   $requete_Ajout = "INSERT INTO salle(NOMSALLE, CAPACITE) VALUES 
   ('$nomsalle','$capacite')";

   $resultat = mysqli_query($congestschool, $requete_Ajout);                           
                         
        $resultat = mysqli_query($congestschool, $requete_Ajout);

         if ($resultat) {
        echo "<script type=\"text/javascript\">

        alert (\"Enregistrement effectuer avec Succès!\");

   </script> ";
       echo '<meta http-equiv="refresh" content="1;url=formSalle.php" />';
   } else {
       echo "<script type=\"text/javascript\">

           alert (\"Enregistrement non effectuer !\");

           </script> ";
       echo '<meta http-equiv="refresh" content="1;url=formSalle.php" />';
   }
}

}
?>