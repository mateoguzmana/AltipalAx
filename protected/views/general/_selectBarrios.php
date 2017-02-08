 <option value="">Barrios</option>
<?php 
if($barrios){
 foreach($barrios as $itemBarrios){
  ?>
  <option value="<?php echo $itemBarrios['CodBarrio']; ?>"><?php echo $itemBarrios['Nombre']; ?></option>
 <?php 
 }
}
?>  