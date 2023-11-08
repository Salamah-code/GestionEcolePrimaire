<?php
require_once '../connexion.php';

if (isset($_GET['IDENSEIGNANT']) && !empty($_GET['IDENSEIGNANT'])) {
    $id = $_GET['IDENSEIGNANT'];
    
    // Utiliser le try-catch pour gérer les erreurs de préparation et d'exécution
    try {
        $stmt = $congestschool->prepare("DELETE FROM enseignant WHERE IDENSEIGNANT = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<script type=\"text/javascript\">
                alert(\"Enregistrement supprimé avec succès!\");
                window.location.href = '../listeEnseignants.php';
            </script>";
        } else {
            echo "<script type=\"text/javascript\">
                alert(\"Échec de la suppression.\");
                window.location.href = '../listeEnseignants.php';
            </script>";
        }
        
        // Fermer le statement après utilisation
        $stmt->close();
    } catch (Exception $e) {
        echo "<script type=\"text/javascript\">
            alert(\"Une erreur s'est produite lors de la suppression.\");
            window.location.href = '../listeEnseignants.php';
        </script>";
    }
} else {
    echo "<script type=\"text/javascript\">
        alert(\"ID  non spécifié.\");
        window.location.href = '../listeEnseignants.php';
    </script>";
}
?>
