<?php
require_once '../connexion.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $congestschool->prepare("DELETE FROM notes WHERE IDNOTE  = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script type=\"text/javascript\">
            alert(\"Enregistrement supprimé avec succès!\");
            window.location.href = '../listeNote.php';
        </script>";
    } else {
        echo "<script type=\"text/javascript\">
            alert(\"Échec de la suppression.\");
            window.location.href = '../listeNote.php';
        </script>";
    }
    $stmt->close();
} else {
    echo "<script type=\"text/javascript\">
        alert(\"ID de la Note non spécifié.\");
        window.location.href = '../listeNote.php';
    </script>";
}
?>