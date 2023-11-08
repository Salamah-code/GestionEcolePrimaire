<!doctype html>
<html lang="en">
<?php include('header.php');
require_once 'connexion.php';
?>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <?php include('nav.php') ?>
                <!-- End Sidebar navigation -->
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
                            <h5 class="text-center bg-light">FORMAULIARE D'AFFECTATION</h5><br>

                            <form action="traitementAffectation.php" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputEmail1" class="form-label">CLASSE</label>

                                        <select name="idclasse" id='idclasse' class="form-control">

                                            <?php
                                            include 'connexion.php';
                                            $req_select = "SELECT * from classe  ";
                                            $resultat2 = mysqli_query($congestschool, $req_select);
                                            $nbr2 = mysqli_num_rows($resultat2);

                                            while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                                $idclasse = $ligne['IDCLASSE'];
                                                $clas = $ligne['NOMCLASSE'];
                                            ?>
                                                <option value="<?php echo $idclasse ?>">
                                                    <?php echo $idclasse . ' ' . $clas; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                        include 'connexion.php';

                                        // Récupérer la liste des enseignants non affectés
                                        $req_select_enseignants = "SELECT * FROM enseignant e WHERE NOT EXISTS (SELECT 1 FROM affectation a WHERE a.ID_ENSIGNANT = e.IDENSEIGNANT)";
                                        $resultat_enseignants = mysqli_query($congestschool, $req_select_enseignants);
                                        $nbr_enseignants = mysqli_num_rows($resultat_enseignants);
                                        ?>
                                    <div class="form-group col-6">
                                        <label for="exampleInputEmail1" class="form-label">Enseignant</label>
                                        <select name="idenseignant" id='idenseignant' class="form-control"
                                            onchange="checkAffectation('idenseignant')">
                                            <?php

                                            while ($ligne = mysqli_fetch_assoc($resultat_enseignants)) {
                                                $idenseignant = $ligne['IDENSEIGNANT'];
                                                $nom = $ligne['NOMENSEIGNANT'];
                                                $prenom = $ligne['PRENNOMENSEIGNANT'];
                                            ?>
                                                <option value="<?php echo $idenseignant ?>">
                                                    <?php echo $idenseignant . ' ' . $nom . ' ' . $prenom; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div><br>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="exampleInputEmail1" class="form-label">DATE</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" name="date">
                                    </div>
                                </div><br>
                                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                                <button type="reset" class="btn btn-dark" onclick="annulerFormulaire()">Annuler</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function annulerFormulaire() {
            // Récupérer le formulaire
            var formulaire = document.getElementById("monFormulaire");

            // Réinitialiser les champs du formulaire
            formulaire.reset();

            // Rediriger vers la page précédente
            window.history.back();
        }

        function checkAffectation(enseignantId) {
            var selectedTeacherId = document.getElementById(enseignantId).value;
            // Effectuer une requête pour vérifier si l'enseignant est déjà affecté
            // ... Votre code de requête AJAX ici ...
                            SELECT * FROM affectation 
                WHERE ID_ENSIGNANT = $idenseignant
                AND YEAR(date_affectation) = $date;


            // Supposons que vous recevez un résultat indiquant si l'enseignant est déjà affecté
            var isAlreadyAssigned = true; // Mettez la valeur appropriée en fonction du résultat de la requête

            if (isAlreadyAssigned) {
                // Mettre en surbrillance l'enseignant sélectionné en rouge
                document.getElementById(enseignantId).style.border = '2px solid red';
                // Afficher un message d'avertissement
                var warningMessage = document.createElement('p');
                warningMessage.textContent = 'Cet enseignant est déjà affecté à une classe pour la même année académique.';
                warningMessage.style.color = 'red';
                document.getElementById(enseignantId).parentNode.appendChild(warningMessage);
            } else {
                // Réinitialiser les styles ou messages d'avertissement
                document.getElementById(enseignantId).style.border = '1px solid #ced4da'; // Réinitialiser la bordure
                var warningMessage = document.getElementById(enseignantId).parentNode.querySelector('p');
                if (warningMessage) {
                    warningMessage.remove();
                }
            }
        }
    </script>

</body>

</html>
