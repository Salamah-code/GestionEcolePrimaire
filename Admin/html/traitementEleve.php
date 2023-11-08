<?php
require_once 'connexion.php';

if (isset($_POST['valider'])) {
    $matricule = trim($_POST['txtmatricule']);
    $nom = trim($_POST['txtnom']);
    $prenom = trim($_POST['txtprenom']);
    $sexe = trim($_POST['txtsexe']);
    $datenaisse = trim($_POST['txtdatenaiss']);
    $lieunaiss = trim($_POST['txtlieu']);
    
    $adresse = trim($_POST['txtadresse']);
    $nomtuteur = trim($_POST['txtnomtuteur']);
    $prenomtuteur = trim($_POST['txtprenomtuteur']);
    $teltuteur = trim($_POST['txttelephonetuteur']);

    // Vérification si l'élève existe déjà
    $requete_Recherche = "SELECT COUNT(*) FROM eleve WHERE (NOM='$nom' AND PRENOM='$prenom' AND DATE_DE_NAISSANCE='$datenaisse' AND NOM_TUTEUR='$nomtuteur')";
    $resultat_recherche = mysqli_query($congestschool, $requete_Recherche);
    
    if ($resultat_recherche) {
        $nombre_eleves = mysqli_fetch_row($resultat_recherche)[0];
    
        if ($nombre_eleves > 0) {
            echo "<script type=\"text/javascript\">
            alert(\"Cet élève existe déjà dans la base de données avec les mêmes informations !\");
            window.location.href = './formEleve.php';
            </script>";
            exit;
        }
    
    } else {
        $cheminacces = "";
    if (!empty($_FILES['txtphoto']['name'])) {
        $image = $_FILES['txtphoto'];
        $image_nom = $image['name'];
        $image_type = $image['type'];
        $image_taille = $image['size'];
        $image_tmp = $image['tmp_name'];

        // Vérification des extensions autorisées pour les fichiers
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        $fileExtension = strtolower(pathinfo($image_nom, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $cheminacces = "images/" . $image_nom;
            if (!move_uploaded_file($image_tmp, $cheminacces)) {
                echo "Une erreur s'est produite lors du téléchargement de l'image.";
                exit;
            }
        } else {
            echo "Format de fichier non valide. Veuillez utiliser un fichier jpg, jpeg ou png.";
            exit;
        }
    }

    // Effectuer l'insertion dans la base de données pour l'élève
    $requete_Ajout = "INSERT INTO eleve(MATRICULE, NOM, PRENOM, SEXE, DATE_DE_NAISSANCE, LIEU_DE_NAISSANCE, PHOTO, ADRESSE, NOM_TUTEUR, PRENOM_TUTEUR, TEL_TUTEUR)
                    VALUES('$matricule','$nom','$prenom','$sexe','$datenaisse','$lieunaiss','$cheminacces','$adresse','$nomtuteur','$prenomtuteur','$teltuteur')";

    $resultat = mysqli_query($congestschool, $requete_Ajout);

    if ($resultat) {
        echo "<script type=\"text/javascript\">
        alert(\"Élève ajouté avec succès !\");
        window.location.href = './listeEleves.php';
        </script>";   
     } else {
        echo "<script type=\"text/javascript\">
        alert(\"Erreur!!! Ajout non réussi !\");
        window.location.href = './formEleve.php';
        </script>";
    }
      
    }

    // Traitement de l'image de l'élève s'il y en a une
    
}
?>
