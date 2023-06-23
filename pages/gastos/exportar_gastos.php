
<?php 
include('../../dist/includes/dbcon.php'); //$branch=$_SESSION['branch'];
?>

      <?php
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
                      ?>
    


 <!--end of modal-->
 <!--end of modal-->
                    

<?php 
$subtotal=0;
$total=0;
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>


                
 <table border=1 cellspacing=0 cellpadding=2 bordercolor="black">
                    <center><p>GASTOS </p></center>

  <P>COMENTARIOS:_______________________________________________________________________________</P>                  
                    <thead>



                      <tr>

    
                         <th>FECHA DE OPERACION</th>
                        <th>DESCRIPCION DE OPERACION</th>
                  
                        <th> SUB TOTAL </th>
                          

                          <th> TOTAL </th>
                      </tr>
                    </thead>
                    <tbody>
<?php

    $query=mysqli_query($con,"select * from gastos where fecha >='$fecha_inicio' and fecha <='$fecha_final'")or die(mysqli_error());
    $i=1;
    while($row=mysqli_fetch_array($query)){
        $subtotal=$subtotal+$row['cantidad'];

}     
?>


<?php

    $query=mysqli_query($con,"select * from gastos  where fecha >='$fecha_inicio' and fecha <='$fecha_final'")or die(mysqli_error());
    $i=1;
    while($row=mysqli_fetch_array($query)){
        $subtotal=$subtotal+$row['cantidad'];

    
?>

                      <tr >


                        <td><?php echo $row['fecha'];?></td>

                        <td><?php echo $row['descripcion'];?></td>
                        <td><?php echo number_format($row['cantidad'],2);?></td>
                        <td><?php echo number_format($row['cantidad'],2);?></td>
    
                      </tr>


 <!--end of modal-->

<?php 
}?>

                <tr >
          
                   <td></td>

                        <td></td>
                        <td>TOTAL</td>
                        <td><?php echo number_format($subtotal/2,2);?></td>
    
                      </tr>

                    </tbody>

                  </table>
        

