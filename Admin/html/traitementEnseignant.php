<?php
require_once 'connexion.php';

if (isset($_POST['valider'])) {
    $matricule = trim($_POST['txtmatricule']);
    $nom = trim($_POST['txtnom']);
    $prenom = trim($_POST['txtprenom']);
    $email = trim($_POST['txtemail']);
    $tel = trim($_POST['txttel']);
    $nationnalite = trim($_POST['txtnation']);

    // Vérification des extensions autorisées pour les fichiers
    $allowedExtensions = array('pdf', 'docx');
    
    // Vérification si un fichier a été sélectionné
    if ($_FILES['txtfile']['error'] == UPLOAD_ERR_NO_FILE) {
        echo "<script type=\"text/javascript\">
            alert(\"Veuillez sélectionner un fichier.\");
        </script>";
    } else {
        $fileExtension = strtolower(pathinfo($_FILES['txtfile']['name'], PATHINFO_EXTENSION));

        // Vérification des champs obligatoires
        if (empty($matricule) || empty($nom) || empty($prenom) || empty($email) || empty($tel) || empty($nationnalite)) {
            echo "Veuillez remplir tous les champs obligatoires.";
        } elseif (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script type=\"text/javascript\">
                alert(\"Format de fichier non valide. Veuillez utiliser un fichier PDF ou Word.\");
            </script>";
        } else {
            // Vérification si l'enseignant existe déjà dans la base de données
            $requete_verif = "SELECT MATRICULE FROM enseignant WHERE  EMAIL = '$email' AND TEL = '$tel'";
            $resultat_verif = mysqli_query($congestschool, $requete_verif);

            if (mysqli_num_rows($resultat_verif) > 0) {
                echo "<script type=\"text/javascript\">
                alert(\"Échec, cet enseignant existe deja dans la base de données.\");
            </script>";           
         } else {
                // Reste du code pour le téléchargement et l'insertion dans la base de données
                $filename = $_FILES['txtfile']['name'];
                $fileTmpName = $_FILES['txtfile']['tmp_name'];
                $cheminacces = "fichiers/" . $filename;

                if (move_uploaded_file($fileTmpName, $cheminacces)) {
                    // Effectuez l'insertion dans la base de données
                    $requete_Ajout = "INSERT INTO enseignant (MATRICULE, NOMENSEIGNANT, PRENNOMENSEIGNANT, EMAIL, TEL, NATIONNALITE, PHOTO)
                                     VALUES ('$matricule','$nom','$prenom','$email','$tel','$nationnalite','$cheminacces')";

                    $resultat = mysqli_query($congestschool, $requete_Ajout);

                    if ($resultat) {
                        echo "<script type=\"text/javascript\">
                        alert(\"Enregistrement effectué avec succes.\");
                    </script>";                    } else {
                        echo "<script type=\"text/javascript\">
                            alert(\"Échec de l'enregistrement.\");
                        </script>";
                    }            
                } else {
                    echo "<script type=\"text/javascript\">
                    alert(\"Échec de téléchargement du fichier.\");
                </script>";                }
            }
        }
    }
}
?>
