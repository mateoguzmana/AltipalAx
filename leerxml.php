<?php
 
$archivo="bandas.xml";
 
if (!file_exists($archivo)){
  die("No encontramos el archivo xml");
}
$xml=simplexml_load_file($archivo);
foreach($xml->banda as $banda){
  echo $banda->nombre." - ".$banda->cancion."<br/>";
}
?>
