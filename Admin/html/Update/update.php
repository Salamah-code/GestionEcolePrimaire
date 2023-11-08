
<?php
require_once '../connexion.php';
function updateEleve($congestschool, $id, $txtnom, $txtprenom, $txtsexe, $txtdatenaiss, $txtlieu, $txtphoto, $txtadresse, $txtnomtuteur, $txtprenomtuteur, $txttelephonetuteur) {
    $req = "UPDATE eleve SET NOM = '$txtnom', PRENOM = '$txtprenom', SEXE='$txtsexe', DATE_DE_NAISSANCE = '$txtdatenaiss' , LIEU_DE_NAISSANCE='$txtlieu', PHOTO='$txtphoto',
     ADRESSE='$txtadresse', NOM_TUTEUR='$txtnomtuteur', PRENOM_TUTEUR='$txtprenomtuteur', TEL_TUTEUR='$txttelephonetuteur' WHERE IDELEVE='$id'";
    
    if ($congestschool->query($req) ) {
        echo "<script type=\"text/javascript\">
                alert(\"Enregistrement modifié avec succès!\");
                window.location.href = '../listeEleves.php';
              </script>";
    } else {
        echo "<script type=\"text/javascript\">
                alert(\"Échec de la modification.\");
                window.location.href = '../listeEleves.php';
              </script>";
    }
}

?>
