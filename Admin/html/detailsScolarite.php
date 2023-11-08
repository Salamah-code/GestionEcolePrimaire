<!DOCTYPE html>
<html lang="fr">
<?php include('header.php') ?>

<head>
    <style>
        /* Styles pour le reçu */
        body {
            font-family: Arial, sans-serif;
            background-color: transparent;
            /* Ajoutez cette ligne pour rendre l'arrière-plan transparent */
        }

        .signature {
            margin-top: 20px;
            text-align: center;
        }

        /* Styles pour masquer le bouton lors de l'impression */
        @media print {
            body {
                font-size: 10px;
                /* Modifier la taille de la police pour l'impression */
            }

            .no-print {
                display: none;
            }
        }

        /* Styles pour les deux parties du reçu */
        .receipt {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            /* Réduisez la marge interne à 10px pour réduire la distance */
        }

        .top-receipt,
        .bottom-receipt {
            page-break-after: always;
            /* Pour la séparation en pages */
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
            <!-- Début de l'en-tête -->
            <div class="container-fluid">
                    <!-- Supprimer la bordure inférieure de la barre de navigation -->
                    <nav class="navbar navbar-light border-0">
                        <div class="container-fluid">
                            <!-- Ajoutez le nom de l'école et le logo -->
                            <div class="d-flex align-items-center">
                                <p class="no-print"><a href="javascript:void(0);" class="btn btn-link"
                                        id="imprimerRecu">
                                        <i class="bi bi-printer"></i> Imprimer le Reçu </a></p>
                            </div>
                        </div>
                    </nav><br>
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                        <div style="width: 50%; margin-bottom: 50px;">
                            <?php
                            // Inclure le fichier de connexion à la base de données
                            require_once 'connexion.php';

                            // Effectuer une requête pour récupérer l'année académique depuis la base de données
                            $condition = $_GET['id']; // Remplacez par votre condition appropriée
                            $query_annee_academique = "SELECT ANNEACCADEMIQUE FROM classe WHERE IDCLASSE = '$condition'";
                            $result_annee_academique = mysqli_query($congestschool, $query_annee_academique);

                            // Vérifier si la requête a réussi
                            if ($result_annee_academique) {
                                if (mysqli_num_rows($result_annee_academique) > 0) {
                                    $row = mysqli_fetch_assoc($result_annee_academique);
                                    $anneeAcademique = $row["ANNEACCADEMIQUE"];
                                } else {
                                    echo "Aucun résultat trouvé.";
                                }
                            } else {
                                echo "Erreur de requête : " . mysqli_error($congestschool);
                            }

                            ?>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <div class="logo">
                                        <img src="images/2.png" alt="Logo de l'école" width="70" height="50">
                                        <div class="school-name">Modernize</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Contenu du reçu pour l'école -->
                            <?php
                            require_once 'connexion.php';
                            if (isset($_GET['id'])) {
                                $paiementId = $_GET['id'];
                                $req_recuperation = "SELECT P.*, I.*,E.* FROM paiementscoloarite P JOIN inscription I  ON P.NUMERO_INSC=I.NUMERO JOIN eleve E ON I.IDELEVE_INSC =E.IDELEVE WHERE P.IDPAIEMENT=$paiementId";

                                $result_recuperation = mysqli_query($congestschool, $req_recuperation);
                                if (isset($result_recuperation)) {
                                    while ($inscription = mysqli_fetch_assoc($result_recuperation)) {
                                        echo '<h3 class="text-center bg-primary">Reçu de Paiement Scolaire</h3>';
                                        echo '<div class="position-relative">';
                                        echo '<div class="position-absolute top-0 start-0">';
                                        echo '<p><strong>Numéro de Paiement :</strong> ' . $inscription['IDPAIEMENT'] . '</p>';
                                        echo '<p><strong>Date de Paiement :</strong> ' . $inscription['DATEPAIEMENT'] . '</p>';
                                        echo '<p><strong>Montant :</strong> ' . $inscription['MONTANTPAIEMENT'] . '</p>';
                                        echo '<p><strong>Mois :</strong> ' . $inscription['MOIS'] . '</p>';
                                        echo '<p>Secretariat : _______________</p>';

                                        echo '</div>';

                                        echo '<div class="position-absolute top-0 end-0">   ';
                                        echo '<p><strong>Motif de Paiement :</strong> ' . $inscription['MOTIF'] . '</p>';
                                        echo '<p><strong>Mode de Paiement :</strong> ' . $inscription['MODEPAIEMENT'] . '</p>';

                                        // Informations de l'élève
                                        echo '<p><strong>Nom de l\'élève :</strong> ' . $inscription['NOM'] . '</p>';
                                        echo '<p><strong>Prénom de l\'élève :</strong> ' . $inscription['PRENOM'] . '</p>';
                                        echo '<p>Parent : ______________</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } elseif (isset($error_message)) {
                                    echo '<p>' . $error_message . '</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div style="margin-top: 200px;"> </div>


                    <div style="width: 50%; margin-top: 50px;">

                        <?php
                        // Inclure le fichier de connexion à la base de données
                        require_once 'connexion.php';


                        // Effectuer une requête pour récupérer l'année académique depuis la base de données
                        $condition = $_GET['id']; // Remplacez par votre condition appropriée
                        $query_annee_academique = "SELECT ANNEACCADEMIQUE FROM classe WHERE IDCLASSE = '$condition'";
                        $result_annee_academique = mysqli_query($congestschool, $query_annee_academique);

                        // Vérifier si la requête a réussi
                        if ($result_annee_academique) {
                            if (mysqli_num_rows($result_annee_academique) > 0) {
                                $row = mysqli_fetch_assoc($result_annee_academique);
                                $anneeAcademique = $row["ANNEACCADEMIQUE"];
                            } else {
                                echo "Aucun résultat trouvé.";
                            }
                        } else {
                            echo "Erreur de requête : " . mysqli_error($congestschool);
                        }

                        ?>

                        <p class="text-center"><strong>Année Scolaire
                                <?php echo $anneeAcademique; ?>
                            </strong></p>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="logo">
                                    <img src="images/2.png" alt="Logo de l'école" width="60" height="50">
                                    <div class="school-name">Modernize</div>
                                </div>
                            </div>
                        </div>
                        <!-- Contenu du reçu pour l'école -->
                        <?php
                        require_once 'connexion.php';
                        if (isset($_GET['id'])) {
                            $paiementId = $_GET['id'];
                            $req_recuperation = "SELECT P.*, I.*,E.* FROM paiementscoloarite P JOIN inscription I  ON P.NUMERO_INSC=I.NUMERO JOIN eleve E ON I.IDELEVE_INSC =E.IDELEVE WHERE P.IDPAIEMENT=$paiementId";

                            $result_recuperation = mysqli_query($congestschool, $req_recuperation);
                            if (isset($result_recuperation)) {
                                while ($inscription = mysqli_fetch_assoc($result_recuperation)) {
                                    echo '<h3 class="text-center bg-primary">Reçu de Paiement Scolaire</h3>';
                                    echo '<div class="position-relative">';
                                    echo '<div class="position-absolute top-0 start-0">';
                                    echo '<p><strong>Numéro de Paiement :</strong> ' . $inscription['IDPAIEMENT'] . '</p>';
                                    echo '<p><strong>Date de Paiement :</strong> ' . $inscription['DATEPAIEMENT'] . '</p>';
                                    echo '<p><strong>Montant :</strong> ' . $inscription['MONTANTPAIEMENT'] . '</p>';
                                    echo '<p><strong>Mois :</strong> ' . $inscription['MOIS'] . '</p>';
                                    echo '<p>Secretariat : ______________</p>';

                                    echo '</div>';

                                    echo '<div class="position-absolute top-0 end-0">   ';
                                    echo '<p><strong>Motif de Paiement :</strong> ' . $inscription['MOTIF'] . '</p>';
                                    echo '<p><strong>Mode de Paiement :</strong> ' . $inscription['MODEPAIEMENT'] . '</p>';

                                    // Informations de l'élève
                                    echo '<p><strong>Nom de l\'élève :</strong> ' . $inscription['NOM'] . '</p>';
                                    echo '<p><strong>Prénom de l\'élève :</strong> ' . $inscription['PRENOM'] . '</p>';
                                    echo '<p>Parent : _______________</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } elseif (isset($error_message)) {
                                echo '<p>' . $error_message . '</p>';
                            }
                        }
                        ?>
                    </div>



                
                </div>


        </div>
    </div>

        <script>
            document.getElementById('imprimerRecu').addEventListener('click', function () {
                window.print();
            });
        </script>
       


</body>

</html>