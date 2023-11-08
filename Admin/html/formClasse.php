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
              <h5 class="text-left">FORMAULIARE D'AJOUT CLASSES</h5><br>
            
                  <form action="traitementClasse.php" method="post" >
                <div class="row">
                    <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NOM DE LA SALLE</label> 
                        <select name="idsalle" id='idsalle' class="form-control">

                <?php
                    include 'connexion.php';

                    $req_recuperation = "SELECT * FROM salle";
            
                $resultat = mysqli_query($congestschool, $req_recuperation);

                // $req_select = "SELECT * FROM salle";
                // $resultat2 = mysqli_query($congestschool, $req_select);
                $nbr2 = mysqli_num_rows($resultat);
                while ($row = mysqli_fetch_assoc($resultat)) {
                    
                                $idsalle=$row['IDSALLE'];
                                $nom_salle = $row['NOMSALLE'];?>
                            <option value='<?php echo $idsalle?>'>
                            <?php echo $idsalle.' '. $nom_salle ;}
                        
                            
                ?>
                </optgroup>

            </select>
                </div>
                </div><br> 
                                  
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">LIBELLE </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtnom" placeholder='ex:CIA'>
                      </div>
                     </div><br>
                     <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">NIVEAU</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtniveau" placeholder='ex: 6eme'>
                      </div>
                     </div><br> 
                     
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">ANNEE ACCADEMIQUE</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="txtannee" placeholder='ex:06-9-2023'>
                      </div>
                     
                    </div><br>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="exampleInputEmail1" class="form-label">EFFECTIF DE LA CLASSE</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" name="txteffectif">
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
  <?php include('script.php') ?>



</body>

</html>