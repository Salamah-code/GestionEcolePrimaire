<!doctype html>
<html lang="en">
<?php include('header.php');
require_once 'connexion.php';
?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="MenuAdmin.php" class="text-nowrap logo-img">
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
              <h5 class="text-center">FORMAULIARE D'INSCRIPTION</h5><br>
              
                  <form action="traitementInscription.php" method="post" enctype="multipart/form-data">                  
                        <div class="row">
                     <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">ELEVE</label>  
                        <select name="ideleve" id='ideleve' class="form-control">
                            <?php
                                $req_select_eleves = "SELECT * FROM eleve e WHERE NOT EXISTS (SELECT 1 FROM inscription i WHERE i.IDELEVE_INSC = e.IDELEVE)";
                                $resultat_eleves = mysqli_query($congestschool, $req_select_eleves);
                                while ($ligne = mysqli_fetch_assoc($resultat_eleves)) {
                                    $ideleve= $ligne['IDELEVE'];
                                    $no= $ligne['NOM'];
                                    $preno= $ligne['PRENOM'];
                            ?>   
                            <option value="<?php echo $ideleve ?>">
                                <?php echo $ideleve.' ' .$no.' '.$preno;  
                            }          
                            ?>
                            </option>
                        </select>
                    </div>

                         <div class="form-group col-6">
                                        <label for="exampleInputEmail1" class="form-label">Classe</label>
                                        <select name="idclasse" id='idclasse' class="form-control">
                                            <?php
                                            include 'connexion.php';
                                            $req_select = "SELECT * from classe ";
                                            $resultat2 = mysqli_query($congestschool, $req_select);
                                            $nbr2 = mysqli_num_rows($resultat2);

                                            while (
                                                $ligne =
                                                mysqli_fetch_assoc($resultat2)
                                            ) {
                                                $idclasse = $ligne['IDCLASSE'];
                                                $nom_classe = $ligne['NOMCLASSE'];
                                                $annee = $ligne['ANNEACCADEMIQUE'];
                                                ?>
                                                <option value="<?php echo $idclasse ?>">
                                                    <?php echo $idclasse . '' . $nom_classe . ' ' . $annee;
                                            }
                                            ?>
                                            </option>
                                        </select>
                                    </div>
                         </div><br>  
                   <div class="row"> 
                       <div class="form-group col-6">
                     <label for="exampleInputEmail1" class="form-label">DATE</label>
                     <input type="date" class="form-control" id="exampleInputEmail1" name="date">
                       </div>
                       <div class="form-group col-6">
                      <label for="exampleInputEmail1" class="form-label">MONTANT PAYE</label>
                      <input type="double" class="form-control" id="exampleInputEmail1" placeholder="Montant à payé"  
                      required name="montant">  
                       </div>
                  </div><br>
                  <div class="row">
                  <div class="form-group col-6">
                      <label for="exampleInputEmail1" class="form-label">DETAILS</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Details Inscription"  
                      required name="details">  
                  </div>
                  </div><br>
                    <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                    <button type="rest" class="btn btn-dark">Annuler</button>
                 
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>