 <option value="">Sub Segmentos</option>
<?php 
if($subSementos){
 foreach($subSementos as $itemSubSegmentos){
  ?>
  <option value="<?php echo $itemSubSegmentos['CodSubSegmento']; ?>"><?php echo $itemSubSegmentos['Nombre']; ?></option>
 <?php 
 }
}
?>  