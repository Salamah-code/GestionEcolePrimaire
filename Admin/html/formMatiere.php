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
              <h5 class="text-center">FORMAULIARE AJOUT MATIERES</h5><br>
             
                   <form action="traitementMatiere.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                      
                    
                        <label for="exampleInputEmail1" class="form-label">LIBELLE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer le libellé"  
                        required name="libelle">
                     
                    </div><br>
                   

                        <div class="row">
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
                                         <?php echo  $clas;  }
                                
                               
                         ?>
                          </option>
                         </select>
                         </div><br>
                         
                         <div class="row">
                     
                     <label for="exampleInputEmail1" class="form-label">COEFFICIENT</label>
                     <input type="text" class="form-control" id="exampleInputEmail1" name="coef"
                     placeholder="Entrer le coéfficient de lq matière">
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