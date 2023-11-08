traitement ajout eleve                                         
<?php
require_once 'connexion.php'; // On inclu la connexion à la bdd

if (isset($_POST['valider'])) {

     $idbulletin = addslashes(htmlspecialchars($_POST['idbulletin'])); 
    $idmatiere= addslashes(htmlspecialchars($_POST['idmatiere']));
    $note= addslashes(htmlspecialchars($_POST['txtnote']));
    $evaluation= addslashes(htmlspecialchars($_POST['txtevaluation']));
    $date= addslashes(htmlspecialchars($_POST['txtdate']));

  


    $existingAssignmentQuery = "SELECT IDNOTE FROM notes WHERE ID_BULLETIN_NOTE = '$idbulletin' AND ID_MATIERE_NOTE ='$idmatiere' AND TYPE_EVALUATION='$evaluation' AND
    year(DATE_EVALUATION)='$date'";   
     $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);
    $existingAssignmentResult = mysqli_query($congestschool, $existingAssignmentQuery);

    // if (!$existingAssignmentResult) {
    //     echo "Erreur SQL : " . mysqli_error($congestschool);
            //   pour verifier les elements de la base de donnees
    // }


    if (mysqli_num_rows($existingAssignmentResult) > 0) {
        echo "<script type=\"text/javascript\">
            alert (\"Cet eleve a deja une note sur cette matiere pour cette eveluation.\");
            </script>";
        echo '<meta http-equiv="refresh" content="1;url=formNotes.php" />';
    } else {
 
    $requete_Ajout = "INSERT INTO notes(ID_BULLETIN_NOTE, ID_MATIERE_NOTE , NOTE, TYPE_EVALUATION, DATE_EVALUATION) VALUES 
    ('$idbulletin','$idmatiere','$note','$evaluation',' $date')";

    $resultat = mysqli_query($congestschool, $requete_Ajout);


    if ($resultat) {
        echo "<script type=\"text/javascript\">

         alert (\"Enregistrement effectuer avec Succès!\");

    </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formNotes.php" />';
    } else {
        echo "<script type=\"text/javascript\">

            alert (\"Enregistrement non effectuer !\");

            </script> ";
        echo '<meta http-equiv="refresh" content="1;url=formNotes.php" />';
    }
}
}