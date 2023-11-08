<!doctype html>
<html lang="en">
<?php include('header.php'); ?>
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
                <?php include('nav.php'); ?>
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
                <div class="card">
                    <nav class="card-body">
                        <h5 class="text-left">FORMULAIRE AJOUT NOTES</h5><br>
                        <?php
                        require_once 'connexion.php';
                        if (isset($_GET['id']) && isset($_GET['bulletin'])) {
                            $eleveId = $_GET['id'];
                            $bulletinId = $_GET['bulletin'];
                            ?>
                            <form action="traitementNote.php" method="post" enctype="multipart/form-data">
                              <div class="form-group col-6">
                                <label for="exampleInputEmail1" class="form-label">BULLETIN</label>                      
                                  <input type=" " name="bulletinId" class="form-control bg-light" id="idbulletin" readonly
                                 value="<?php echo $bulletinId; ?>">
                                 <input type="hidden" name="eleveId" value="<?php echo $eleveId; ?>">
                                </div><br>
                                
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">MATIERE</label>
                                    <select name="idmatiere" id='idmatiere' class="form-control">
                                        <?php
                                        $req_select = "SELECT * from matiere ";
                                        $resultat2 = mysqli_query($congestschool, $req_select);
                                        while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                            $idmatiere = $ligne['IDMATIERE'];
                                            $matiere = $ligne['LIBELLE'];
                                            ?>
                                            <option value="<?php echo $idmatiere ?>">
                                                <?php echo $idmatiere . ' ' . $matiere; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div> <br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">LA NOTE</label>
                                    <input type="number" step="0.01" class="form-control" id="exampleInputEmail1"
                                           name="txtnote" placeholder="Entrer la note obtenue">
                                </div><br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">TYPE D'EVALUATION</label>
                                    <select class="form-select" aria-label="Default select example" name="txtevaluation">
                                        <option value="Devoir">DEVOIR</option>
                                        <option value="Controle">CONTROLE</option>
                                        <option value="Composition">COMPOSITION</option>
                                    </select>
                                </div><br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">DATE</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="txtdate"
                                           placeholder="">
                                </div><br>
                                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                                <button type="reset" class="btn btn-dark" onclick="annulerFormulaire()">Annuler</button>
                            </form>
                            </div>
                            <?php
                            
                        } else {
                            ?>
           <nav class="navbar navbar-light">
            <form class="d-flex justify-content-between" method="get">
             <div class="row align-items-end">
               <div class="form-group col-6">
                <label for="classe" class="form-label">Classe :</label>
                 <select name="classe" id="classe" class="form-control">
                    <option value="">Sélectionnez une classe</option>
                    <?php
                    // Récupérez la liste des classes depuis votre base de données
                    $req_classes = "SELECT IDCLASSE, NOMCLASSE, ANNEACCADEMIQUE FROM classe";
                    $result_classes = mysqli_query($congestschool, $req_classes);

                    if ($result_classes) {
                        while ($row_classe = mysqli_fetch_assoc($result_classes)) {
                            echo '<option value="' . $row_classe['IDCLASSE'] . '">' . $row_classe['NOMCLASSE'] . ' ' . $row_classe['ANNEACCADEMIQUE'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-4">
                <label for="trimestre" class="form-label">Trimestre :</label>
                <select class="form-select" name="trimestre">
                    <option value="">Sélectionnez un trimestre</option>
                    <option value="1er trimestre">Trimestre 1</option>
                    <option value="2em trimestre">Trimestre 2</option>
                    <option value="3em trimestre">Trimestre 3</option>
                </select>
            </div>
            <div class="form-group col-2">
                <button class="btn btn-outline-info" type="submit" name="action">Rechercher</button>
            </div>
        </div></br>
    </form>
</nav>
                           <?php
                              if (isset($_GET['action'])) {
                               if (isset($_GET['classe']) && isset($_GET['trimestre'])) {
                                  $classeId = $_GET['classe'];
                                  $trimestreId = $_GET['trimestre'];
                                //   echo'<nav class="navbar navbar-light">';  
                                 echo '<form action="traitementNotes.php" method="post" enctype="multipart/form-data">';
                               // Effectuez une requête pour récupérer les bulletins des élèves de la classe et du trimestre spécifiés
                                     $req_bulletins = "SELECT B.IDBULLETIN, E.MATRICULE, E.NOM, E.PRENOM, C.NOMCLASSE, B.TRIMESTRE
                                     FROM bulletin B
                                     JOIN eleve E ON B.IDELEVE_BUL = E.IDELEVE
                                     JOIN inscription I ON E.IDELEVE = I.IDELEVE_INSC
                                     JOIN classe C ON I.IDCLASSE_INSC = C.IDCLASSE
                                                     WHERE C.IDCLASSE = '$classeId' 
                                                     AND B.TRIMESTRE = '$trimestreId'";

        $result_bulletins = mysqli_query($congestschool, $req_bulletins);

        if (!$result_bulletins) {
            die("Erreur SQL: " . mysqli_error($congestschool));
        }

        if (mysqli_num_rows($result_bulletins) > 0) {
            echo '<form action="traitementNote.php" method="post" enctype="multipart/form-data">';
            echo '<div class="form-group col-6">';
            echo '<label for="idbulletin" class="form-label">BULLETIN</label>';
            echo '<select name="idbulletin" id="idbulletin" class="form-control">';

            while ($row_bulletin = mysqli_fetch_assoc($result_bulletins)) {
                $bulletinId = $row_bulletin['IDBULLETIN'];
                $matricule = $row_bulletin['MATRICULE'];
                $nom = $row_bulletin['NOM'];
                $prenom = $row_bulletin['PRENOM'];
                $nomclasse = $row_bulletin['NOMCLASSE'];
                $trimestre = $row_bulletin['TRIMESTRE'];

                echo '<option value="' . $bulletinId . '">';
                echo $matricule . ' ' . $nom . ' ' . $prenom . ' ' . $nomclasse . ' ' . $trimestre;
                echo '</option>';
            }

            echo '</select>';
            echo '</div><br>';?>
                               
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">MATIERE</label>
                                    <select name="idmatiere" id='idmatiere' class="form-control">
                                        <?php
                                        $req_select = "SELECT * from matiere ";
                                        $resultat2 = mysqli_query($congestschool, $req_select);
                                        while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                            $idmatiere = $ligne['IDMATIERE'];
                                            $matiere = $ligne['LIBELLE'];
                                            ?>
                                            <option value="<?php echo $idmatiere ?>">
                                                <?php echo $idmatiere . ' ' . $matiere; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div> <br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">LA NOTE</label>
                                    <input type="number" step="0.01" class="form-control" id="exampleInputEmail1"
                                           name="txtnote" placeholder="Entrer la note obtenue">
                                </div><br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">TYPE D'EVALUATION</label>
                                    <select class="form-select" aria-label="Default select example" name="txtevaluation">
                                        <option value="Devoir">DEVOIR</option>
                                        <option value="Controle">CONTROLE</option>
                                        <option value="Composition">COMPOSITION</option>
                                    </select>
                                </div><br>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1" class="form-label">DATE</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="txtdate"
                                           placeholder="">
                                </div><br>
                                <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                                <button type="reset" class="btn btn-dark" onclick="annulerFormulaire()">Annuler</button>
                            </form>';
                            <?php
                               } else {
                                   echo "Aucun bulletin trouvé pour la classe et le trimestre sélectionnés.";
                               }
                             }
                            }
                          }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>


<script>
    function annulerFormulaire() {
            // Récupérer le formulaire
            var formulaire = document.getElementById("monFormulaire");

            // Réinitialiser les champs du formulaire
            formulaire.reset();

            // Rediriger vers la page précédente
            window.history.back();
        }

</script>

</html>


