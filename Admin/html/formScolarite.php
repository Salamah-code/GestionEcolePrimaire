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
              <h5 class="text-center">FORMAULIARE PAIEMENT SCOLARITE</h5><br>
                              <form action="traitementScolarite.php" method="post">                  
                        <div class="row">
                        <div class="form-group col-6"> 
                        <label for="exampleInputEmail1" class="form-label">INSCRIPTION</label>  
                        <select name="numero" id='numero' class="form-control">
                           
                         <?php
                        include 'connexion.php';
                        $req_select = "SELECT E.NOM,E.PRENOM, I.NUMERO from  eleve E join inscription I  ON  E.IDELEVE= I.IDELEVE_INSC" ;
                        $resultat2 = mysqli_query($congestschool, $req_select);
                                while ($ligne = mysqli_fetch_assoc($resultat2)) {
                                     $numero= $ligne['NUMERO'];
                                     $no= $ligne['NOM'];
                                     $preno= $ligne['PRENOM'];
                                  ?>   <option value="<?php echo $numero ?>">
                                         <?php echo $numero. ' ' .$no.' '.$preno?>
                                </option>                                   
                                <?php    }          
                         ?> 
                         </select>
                         </div> 
                         <div class="form-group col-6"> 
                     <label for="exampleInputEmail1" class="form-label">DATE PAIEMENT</label>
                     <input type="date" class="form-control" id="exampleInputEmail1" name="date">
                     </div>
                     </div><br>
                     <div class="row"> 
                     <div class="form-group col-6">    
                      <label for="exampleInputEmail1" class="form-label">MONTANT PAIEMENT</label>
                      <input type="double" class="form-control" id="exampleInputEmail1" placeholder="Montant à payé"  
                      required name="montant">  
                  </div>
                 
                  <div class="form-group col-6">
                      <label for="exampleInputEmail1" class="form-label">MOIS</label>
                        <select name="mois" id="mois" class="form-control w-10">
                            <option value="janvier">Janvier</option>
                            <option value="fevrier">Février</option>
                            <option value="mars">Mars</option>
                            <option value="avril">Avril</option>
                            <option value="mai">Mai</option>
                            <option value="juin">Juin</option>
                            <option value="juillet">Juillet</option>
                            <option value="aout">Aout</option>
                            <option value="septembre">Septembre</option>
                            <option value="octobre">Octobre</option>
                            <option value="novembre">Novembre</option>
                            <option value="decembre">Décembre</option>
                        </select>
                        </div> 
                  </div>
                  <div class="row"> 

                  <div class="form-group col-6">
                      <label for="exampleInputEmail1" class="form-label">MOTIF DE PAIEMENT</label>
                      <select name="motif" id="motif" class="form-control">
                      
                        <option value="reinscription">Réinscription</option>
                        <option value="mensuel">Mensualité</option>
                        <option value="cantine">Cantine</option>
                        <option value="transport">Transport </option>


                      </select>
                      </div> 
                      <div class="form-group col-6">     
                      <label for="exampleInputEmail1" class="form-label">MODE DE PAIEMENT</label>
                      <select name="mode" id="mode"  class="form-control">
                        <option value="espece">Espece</option>
                        <option value="cheque">Cheque</option>
                        <option value="virement">Virement</option>
                      </select> 
                  </div>
                 
                                </div> 

                  <div class="form-group col-12">
                    <label for="votre_champ" class="form-label">DETAILS DU PAIEMENT</label>
                    <textarea class="form-control" name="detail" id="detail" cols="50" rows="10"></textarea>
                </div> </br>

                  

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