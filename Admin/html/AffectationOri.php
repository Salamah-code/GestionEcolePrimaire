<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestschool";

// Création de la connexion
$congestschool = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$congestschool) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}
?>



<?php
// Inclure le fichier de connexion à la base de données
require_once 'connexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$classeId = isset($_GET['id']) ? $_GET['id'] : null;
$classe = null;
$enseignantHasClass = false;

if (!is_null($classeId)) {
    $req_eleve = "SELECT classe.*, enseignant.* FROM classe
                  LEFT JOIN affectation ON affectation.ID_CLASSE = classe.IDCLASSE
                  LEFT JOIN enseignant ON affectation.ID_ENSIGNANT = enseignant.IDENSEIGNANT
                  WHERE classe.IDCLASSE = $classeId";
    $result_eleve = mysqli_query($congestschool, $req_eleve);
    $classe = mysqli_fetch_assoc($result_eleve);

    // Vérifier si un enregistrement existe dans la table d'affectation pour la classe actuelle
    $enseignantHasClass = !empty($classe['NOMENSEIGNANT']);
}
if (isset($_POST['valider'])) {
    $ideleve = $_POST['ideleve'];
    $idenseignant = $_POST['idenseignant'];
    $idclasse = $classeId;
    $date = $_POST['date'];

    $insertion_reussie = false;

    // Requête d'insertion
    // Requête d'insertion
$req_insertion = "INSERT INTO affectation (ID_ELEVE, ID_ENSIGNANT, ID_CLASSE, date_affectation) 
VALUES ('$ideleve', '$idenseignant', '$idclasse', '$date')";
$resultat_insertion = mysqli_query($congestschool, $req_insertion);

if ($resultat_insertion) {
$insertion_reussie = true;
} else {
$insertion_reussie = false;
echo "Erreur d'insertion : " . mysqli_error($congestschool);
}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header.php'); ?>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <!-- ... (code de la barre latérale) ... -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <!--  Header End -->
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-left">FORMULAIRE DES AFFECTATIONS</h5><br>

                            <form action="" method="post">
                            <div class="row">
                                    <div class="form-group col-6">
                                        <label for="ideleve" class="form-label">NOM DE L'ÉLÈVE</label>
                                        <select name="ideleve" id="ideleve" class="form-control">
                                            <?php
                                            include 'connexion.php';
                                            $req_recuperation = "SELECT * FROM eleve";
                                            $resultat = mysqli_query($congestschool, $req_recuperation);
                                            while ($row = mysqli_fetch_assoc($resultat)) {
                                                $ideleve = $row['IDELEVE'];
                                                $nom = $row['NOM'];
                                                $prenom = $row['PRENOM'];
                                                echo "<option value='$ideleve'>$ideleve - $nom $prenom</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <?php if ($enseignantHasClass): ?>
                                        <div class="form-group col-6">
                                            <label for="nomenseignant" class="form-label">NOM DE L'ENSEIGNANT</label>
                                            <input type="text" name="idenseignant" id="idenseignant" class="form-control" 
                                                value="<?= $classe['IDENSEIGNANT'].' '.$classe['NOMENSEIGNANT'].''.$classe['PRENNOMENSEIGNANT'] ?>" readonly>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group col-6">
                                            <label for="idenseignant" class="form-label">Enseignant</label>
                                            <select name="idenseignant" id="idenseignant" class="form-control">
                                                <?php
                                                $req_enseignants = "SELECT IDENSEIGNANT, NOMENSEIGNANT, PRENNOMENSEIGNANT FROM enseignant";
                                                $result_enseignants = mysqli_query($congestschool, $req_enseignants);
                                                if ($result_enseignants) {
                                                    while ($row = mysqli_fetch_assoc($result_enseignants)) {
                                                        $idenseignant = $row['IDENSEIGNANT'];
                                                        $nomenseignant = $row['NOMENSEIGNANT'];
                                                        $prenomenseignant = $row['PRENNOMENSEIGNANT'];
                                                        echo "<option value='$idenseignant'>$idenseignant $nomenseignant $prenomenseignant</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
    
                                 <div class="form-group col-6">
                                    <label for="nomclasse" class="form-label">NOM DE LA CLASSE</label>
                                    <?php if ($enseignantHasClass): ?>
                                        <input type="text" name="nomclasse" id="nomclasse" class="form-control" 
                                            value="<?= $classe['NOMCLASSE'] ?>" readonly>
                                    <?php else: ?>
                                        <input type="text" name="nomclasse" id="nomclasse" class="form-control" 
                                            value="<?= $classe['NOMCLASSE'] ?>" readonly>
                                    <?php endif; ?>
                                </div>




                                    <div class="form-group col-6">
                                                    <label for="date" class="form-label">DATE</label>
                                                    <input type="date" class="form-control" id="date" name="date">
                                                        </div>

                               </div><br>

                                  
                                        <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                                        <button type="reset" class="btn btn-dark">Annuler</button>
                                  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('script.php'); ?>

    <script>
    var insertion_reussie = <?php echo json_encode($insertion_reussie); ?>;
    if (insertion_reussie) {
        alert("L'ajout a été effectué avec succès !");
    } else {
        alert("L'ajout a échoué. Veuillez réessayer.");
    }
</script>
</body>

</html>
