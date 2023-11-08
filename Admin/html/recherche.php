<?php
require_once 'config.php';
if($bdd)
    {
    echo"<table id= reche>";
    if(!empty($_POST['search']))
    {
        $rech=$_POST['search'];
        $ress=$conn->prepare("SELECT * from inscription where IDELEVE_INSC =? or NUMERO=? or DATE=? ");
        $ress->execute(array($rech,$rech,$rech));
      
       

?>
        
         <table class="table table-bordered">
         <thead>
           <tr class="table-success">
             <th scope="col">#</th>
             <th scope="col">ELEVES</th>
             <th scope="col">DATE</th>
             <th scope="col">MONTANT</th>
             <th scope="col">DETAILS</th>
             <th scope="col">Modifer</th>
             <th scope="col">Detail</th>
             <th scope="col">Supprimer</th>
           </tr>
         </thead>
         <tbody>
           <?php
           while ($ligne = $ress->fetch()) {
           ?>
             <tr>
               <td><?php echo $ligne['NUMERO']; ?></td>
               <td><?php echo $ligne['IDELEVE_INSC']; ?></td>
               <td><?php echo $ligne['DATE']; ?></td>
               <td><?php echo $ligne['MONTANTPAYE']; ?></td>
               <td><?php echo $ligne['DETAILS']; ?></td>
               <td><a href="modifier_salle.php?id=<?php echo $ligne['NUMERO'] ?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a></td>
               <td><a href="liste_det_sallet.php?id=<?php echo $ligne['NUMERO'] ?>" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>
               <td><a href="supprimer_salle.php?id=<?php echo $ligne['NUMERO'] ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a></td>
             <?php
           }
             ?>
         </tbody>
       </table>

  <?php  }

        
}
?>