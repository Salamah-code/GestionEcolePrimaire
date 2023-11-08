
<?php
require_once 'connexion.php';

if (isset($_GET['id'])) {
    $bulletinId = $_GET['id'];
        $selectedStudentId = isset($_GET['id']) ? $_GET['id'] : '';

        $req_bulletin = "SELECT bulletin.*, eleve.NOM, eleve.PRENOM, classe.NOMCLASSE, classe.ANNEACCADEMIQUE
        FROM bulletin 
        JOIN eleve ON eleve.IDELEVE = bulletin.IDELEVE_BUL
        JOIN inscription ON inscription.IDELEVE_INSC = eleve.IDELEVE
        JOIN classe ON classe.IDCLASSE = inscription.IDCLASSE_INSC
        JOIN affectation ON affectation.ID_CLASSE = classe.IDCLASSE
        WHERE IDELEVE = $selectedStudentId ";

    
    $result_bulletin = mysqli_query($congestschool, $req_bulletin);
    

    if (!$result_bulletin) {
        die("Erreur SQL: " . mysqli_error($congestschool));
    }

    if (mysqli_num_rows($result_bulletin) > 0) {
        $bulletinInfo = mysqli_fetch_assoc($result_bulletin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des notes</title>
</head>
<body>
    <h1>Informations sur l'élève :</h1>
    <p>Nom de l'élève : <?php echo $bulletinInfo['NOM']; ?></p>
    <p>Prénom de l'élève : <?php echo $bulletinInfo['PRENOM']; ?></p>
    <p>Classe : <?php echo $bulletinInfo['NOMCLASSE']; ?></p>
    <h1>Ajouter des notes au bulletin</h1>
    <h2>Informations sur le bulletin :</h2>
    <p>ID du bulletin : <?php echo $bulletinInfo['IDBULLETIN']; ?></p>
    <p>ID ELEVE: <?php echo $bulletinInfo['IDELEVE_BUL']; ?></p>
    <p>ANNEE SCOLAIRE : <?php echo $bulletinInfo['ANNEACCADEMIQUE']; ?></p>
    <p>TRIMESTRE : <?php echo $bulletinInfo['TRIMESTRE']; ?></p>
          <!-- Formulaire pour afficher le bulletin -->
          <form method="post" action="afficher_bulletin.php">
        <input type="hidden" name="id" value="<?php echo $selectedStudentId; ?>">
        <label for="trimestre">Sélectionner le trimestre :</label>
        <select name="trimestre" id="trimestre">
            <?php
            
            $req_trimestres = "SELECT DISTINCT TRIMESTRE FROM bulletin";
            $resultat_trimestres = mysqli_query($congestschool, $req_trimestres);
            if ($resultat_trimestres) {
                while ($ligne_trimestre = mysqli_fetch_assoc($resultat_trimestres)) {
                    $trimestre = $ligne_trimestre['TRIMESTRE'];
                    echo "<option value='$trimestre'>$trimestre</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Afficher_bulletin">
    </form>

    <form method="post" action='traitementNotes.php'>
    <input type="hidden" name="idbulletin" value="valeur_de_id_bulletin"> <!-- Assurez-vous de remplacer "valeur_de_id_bulletin" par la valeur réelle de l'ID du bulletin -->
        <label for="matiere">Matière :</label>
        <select name="matiere" id="matiere">
            <?php
            // Récupérer les matières de la base de données
            $req_matieres = "SELECT * FROM matiere";
            $result_matieres = mysqli_query($congestschool, $req_matieres);

            // Générer les options de la liste déroulante
            while ($matiere = mysqli_fetch_assoc($result_matieres)) {
                echo "<option value='" . $matiere['IDMATIERE'] . "'>" . $matiere['LIBELLE'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="note">Note :</label>
        <input type="number" step="0.01" id="note" name="note"><br><br>

        <label for="type_evaluation">Type d'évaluation :</label>
        <select name="type_evaluation" id="type_evaluation">
            <option value="Composition">Composition</option>
            <option value="Devoir">Devoir</option>
        </select><br><br>

        <label for="date_evaluation">Date d'évaluation :</label>
        <input type="date" id="date_evaluation" name="date_evaluation"><br><br>
        <input type="submit" name="ajouter_note" value="Ajouter la note">
    </form>

    <script>
    // Code JavaScript pour gérer le clic sur le bouton "Afficher"
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const selectedTrimestre = document.getElementById('trimestre').value;
        const selectedStudentId = "<?php echo $selectedStudentId; ?>";

        // Rediriger vers la page d'affichage du bulletin
        window.location.href = `afficher_bulletin.php?id=${selectedStudentId}&trimestre=${selectedTrimestre}`;
    });
</script>

</body>
</html>
        

<?php
}
else {
   
   
    require_once 'connexion.php';
    
    if (isset($_GET['id'])) {
        $selectedStudentId = $_GET['id'];
    
        // Requête SQL pour vérifier si l'élève a déjà un bulletin
        $req_bulletin = "SELECT IDBULLETIN FROM bulletin WHERE IDBULLETIN = $bulletinId";
        $result_bulletin = mysqli_query($congestschool, $req_bulletin);
    
        if (!$result_bulletin) {
            die("Erreur SQL: " . mysqli_error($congestschool));
        }
        
        if (mysqli_num_rows($result_bulletin) > 0) {
            // L'élève a déjà un bulletin, récupérez l'ID du bulletin pour ajouter des notes
            $bulletinInfo = mysqli_fetch_assoc($result_bulletin);
            $bulletinId = $bulletinInfo['IDBULLETIN'];
            // Afficher un message pour indiquer que l'élève a déjà un bulletin
            header("Location: ajouter_note.php?id=$bulletinId");
            // Vous pouvez ajouter votre formulaire pour ajouter des notes ici
        } else {
            // L'élève n'a pas de bulletin, affichez un message
            echo "L'élève n'a pas de bulletin.";
            // Récupérez l'ID de l'élève pour aller au formulaire d'ajout de bulletin
            $selectedStudentId = $_GET['id'];
            // Redirigez l'utilisateur vers le formulaire d'ajout de bulletin avec l'ID de l'élève
            header("Location: creer_bulletin.php?id=$selectedStudentId");
            exit;
        }
    }      
    
} }
?>

