<?php
require_once 'connexion.php';

// Générer la liste des années académiques distinctes
$queryAnnees = "SELECT DISTINCT ANNEACCADEMIQUE FROM classe";
$resultAnnees = mysqli_query($congestschool, $queryAnnees);

$selectedAnnee = ""; // Définir une valeur par défaut pour éviter l'erreur


if (isset($_POST['submit'])) {
    if (isset($_POST['annee'])) {
        $selectedAnnee = mysqli_real_escape_string($congestschool, $_POST['annee']);
$query = "SELECT c.IDCLASSE, c.NOMCLASSE, COUNT(i.IDELEVE_INSC) AS EFFECTIF
FROM classe c
LEFT JOIN inscription i ON c.IDCLASSE = i.IDCLASSE_INSC
WHERE c.ANNEACCADEMIQUE = '$selectedAnnee'
GROUP BY c.IDCLASSE, c.NOMCLASSE";


        $result = mysqli_query($congestschool, $query);
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<?php include('header.php') ?>

<head>
    <!-- Styles CSS, etc. -->
    <style>
        /* Styles pour le reçu */
        body {
            font-family: Arial, sans-serif;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
        }

        /* Styles pour masquer le bouton lors de l'impression */
        @media print {
            .no-print {
                display: none;
            }
        }

        .custom-select {
            width: 20%;
            /* Vous pouvez ajuster la largeur en pourcentage ou en pixels selon vos besoins */
        }
    </style>
</head>

<body>
    <!-- Wrapper du corps de la page -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Début de la barre latérale -->
        <aside class="left-sidebar">
            <!-- Défilement de la barre latérale -->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="MenuAdmin.php" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Navigation de la barre latérale -->
                <?php include('nav.php') ?>
                <!-- Fin de la navigation de la barre latérale -->
            </div>
            <!-- Fin du défilement de la barre latérale -->
        </aside>
        <!-- Fin de la barre latérale -->
        <!-- Enveloppe principale -->
        <div class="body-wrapper">
            <h1>LISTE DES CLASSES PAR ANNEE ACCADEMIQUE</h1>
            <!-- Wrapper du corps de la page -->

            <form method="POST" class="mt-3" id="annee-form">
                <label for="annee">Sélectionnez une année académique :</label>
                <select name="annee" id="annee" class="form-select custom-select">
                    <?php
                    // Afficher les années académiques distinctes
                    while ($rowAnnee = mysqli_fetch_assoc($resultAnnees)) {
                        $annee = $rowAnnee['ANNEACCADEMIQUE'];
                        echo "<option value='$annee'>$annee</option>";
                    }
                    ?>
                </select> <br>
                <button id="afficher-classes" class="btn btn-primary" name="submit">Liste des classes</button>
            </form>

            <div class="row mt-4">
    <?php
    $counter = 0; // Compteur pour suivre le nombre de classes affichées

    if (isset($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nomClasse = $row['NOMCLASSE'];
            $classeId = $row['IDCLASSE'];
            $effectif = $row['EFFECTIF'];

            // Affichez la carte pour la classe
            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo "<h5 class='card-title'>$nomClasse</h5>";
            echo "<p class='card-text'>Effectif total : $effectif</p>";
            echo "<a href='#' class='btn btn-primary' onclick='afficherEleves($classeId, \"$selectedAnnee\")'>Voir les élèves</a>";
            echo '</div>';
            echo '</div>';
            echo '</div>';

            $counter++;

            // Si le compteur atteint 4, fermez la ligne et réinitialisez le compteur
            if ($counter % 4 == 0) {
                echo '</div><div class="row mt-4">';
            }
        }
    }
    ?>
</div>

            <!-- ... (votre code HTML pour afficher la liste des élèves) ... -->
            <div id="liste-eleves" class="mt-4" style="display: none;">
                <!-- Les élèves seront affichés ici lorsque vous cliquez sur une classe -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les élèves seront insérés ici via JavaScript -->
                    </tbody>
                </table>

                <!-- Bouton de retour à la liste des classes -->
                <button id="retour-liste" class="btn btn-primary" style="display: none;">Retour à la liste des
                    classes</button>
            </div>

        </div>
    </div>

    <script>
    // Fonction pour afficher la liste des élèves de la classe sélectionnée
    function afficherEleves(classeId, selectedAnnee) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const listeEleves = xhr.responseText;
                document.getElementById("liste-eleves").style.display = "block"; // Affichez le tableau
                document.querySelector("#liste-eleves tbody").innerHTML = listeEleves;
            }
        };

        // Utilisez une URL relative ou absolue pour votre requête AJAX
        // Assurez-vous que l'URL pointe vers le bon script PHP pour afficher les élèves
        xhr.open("GET", "scriptPourAfficherEleves.php?id=" + classeId + "&selectedAnnee=" + selectedAnnee, true);
        xhr.send();
    }
</script>




</body>

</html>