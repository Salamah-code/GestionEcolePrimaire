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
                  <h5 class="text-center bg-light">INFORMATIONS DU CAHIER DE TEXT</h5><br>
                  <form action="traitementEmargement.php" method="post" enctype="multipart/form-data">
                    
                   

                        <div class="row">
                        <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">CLASSE</label>
                        
                        <select name="idclasse" id='idclasse' class="form-control">
                             
                         <?php
                        include 'connexion.php';
                        $req_select = "SELECT * from classe ";
                        $resultat2 = mysqli_query($congestschool, $req_select);
                        $nbr2 = mysqli_num_rows($resultat2);

                                while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                     $idclasse= $ligne['IDCLASSE'];
                                     $clas= $ligne['NOMCLASSE'];
                                  ?>   <option value="<?php echo $idclasse ?>">
                                         <?php echo  $idclasse.' '. $clas;
                                   }
       
                         ?>
                          </option>
                         </select>
                        </div>
                        <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">Enseignant</label>
                        
                        <select name="idenseignant" id='idenseignant' class="form-control">
                             
                         <?php
                        include 'connexion.php';
                        $req_select = "SELECT * from enseignant ";
                        $resultat2 = mysqli_query($congestschool, $req_select);
                        $nbr2 = mysqli_num_rows($resultat2);

                                while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                     $idclasse= $ligne['IDENSEIGNANT'];
                                     $nom= $ligne['NOMENSEIGNANT'];
                                     $prenom= $ligne['PRENNOMENSEIGNANT'];
                                  ?>   <option value="<?php echo $idclasse ?>">
                                         <?php echo  $idclasse .' '.$nom.' '.$prenom;
                                 
                                    
                                  }
                         ?>
                          </option>
                         </select>
                        </div>
                       </div><br>
                       <div class="row">
                       <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">MATIERE</label>
                        
                        <select name="idmatiere" id='idmatiere' class="form-control">
                            
                         <?php
                        include 'connexion.php';
                        $req_select = "SELECT IDMATIERE,LIBELLE from matiere ";
                        $resultat2 = mysqli_query($congestschool, $req_select);
                        $nbr2 = mysqli_num_rows($resultat2);

                                while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                     $idmatiere= $ligne['IDMATIERE'];
                                     $clas= $ligne['LIBELLE'];
                                  ?>   <option value="<?php echo $idmatiere ?>">
                                         <?php echo $idmatiere.' '. $clas;
                       }
                        
                            
                ?>

                         </select>
                        </div>
                    <div class="form-group col-6">
                     <label for="exampleInputEmail1" class="form-label">HEURE</label>
                     <input type="number" class="form-control" id="exampleInputEmail1" name="heure">
                     </div>
                     </div><br>
                     <div class="row">
                       <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">DATE</label>
                        <input type="date" class="form-control" id="exampleInputEmail1"  name="date"> 
                       </div>
                     <div class="form-group col-6">
                     <select class="form-select" aria-label="Default select example" name="trimestre">
                            <option selected>Trimestre</option>
                            <option  >1er Trimestre</option>
                            <option  >2eme Trimestre</option>
                            <option  >3eme Trimestre</option>
                          
                          </select>
                   </div>
                    </div><br>
                    <div class="form-group col-6"> 
                        <label for="exampleInputEmail1" class="form-label">ANNEE ACCADEMIQUE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name=annee >
                    </div><br><br>
            
                    <div class="form-group col-6">
                     <button type="submit" class="btn btn-primary" name="valider">Valider</button>
                     <button type="rest" class="btn btn-dark">Annuler</button>
                </div>
              </form>
        
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 

</body>

</html>