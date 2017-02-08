  <option value="">Ciudades</option>
 <?php 
 if($ciudades){
    foreach($ciudades as $itemCiudades){
?>
<option value="<?php echo $itemCiudades['CodigoCiudad']; ?>"><?php echo $itemCiudades['NombreCiudad']; ?></option>
<?php
	}
	}
 ?>  