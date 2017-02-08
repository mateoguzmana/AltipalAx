<?php

$target_path  = "./";
$fecha = date("His");
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
/*$target_path = explode('.jpg',$target_path); 
$target_path = $target_path[0].$fecha.".jpg";*/

$nombre_fichero = $target_path;

if (file_exists($nombre_fichero)) {
   unlink($target_path);
} else {
  
}

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	

 echo "OK";
} else{
 echo "There was an error uploading the file, please try again!";
}
?>