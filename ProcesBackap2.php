<?php

$hora = date("H:i:s");
$fecha = date("Y-m-d");

$imagenes = glob("{*.zip}", GLOB_BRACE);
$nombre_archivo = "ZIPTXT-" . $fecha . "-" . $hora . "-raiz";
foreach ($imagenes as $ima) {
    copy($ima, 'backup/' . $ima);
    unlink($ima);
}

 
$Directorio = array(
    'Apartado' => $dir = '../SM/Apartado/Log/',
    'Bogota' => $dir = '../SM/Bogota/Log/',
    'Cali' => $dir = '../SM/Cali/Log/',
    'Duitama' => $dir = '../SM/Duitama/Log/',
    'Ibague' => $dir = '../SM/Ibague/Log/',
    'Medellin' => $dir = '../SM/Medellin/Log/',
    'Monteria' => $dir = '../SM/Monteria/Log/',
    'Pasto' => $dir = '../SM/Pasto/Log/',
    'Pereira' => $dir = '../SM/Pereira/Log/',
    'Popayan' => $dir = '../SM/Popayan/Log/',
    'Villavicencio' => $dir = '../SM/Villavicencio/Log/',
);


$Directorio_log_txt_array = array(
    'Apartado' => $dir = '../SM/Apartado/Log/*.txt',
    'Bogota' => $dir = '../SM/Bogota/Log/*.txt',
    'Cali' => $dir = '../SM/Cali/Log/*.txt',
    'Duitama' => $dir = '../SM/Duitama/Log/*.txt',
    'Ibague' => $dir = '../SM/Ibague/Log/*.txt',
    'Medellin' => $dir = '../SM/Medellin/Log/*.txt',
    'Monteria' => $dir = '../SM/Monteria/Log/*.txt',
    'Pasto' => $dir = '../SM/Pasto/Log/*.txt',
    'Pereira' => $dir = '../SM/Pereira/Log/*.txt',
    'Popayan' => $dir = '../SM/Popayan/Log/*.txt',
    'Villavicencio' => $dir = '../SM/Villavicencio/Log/*.txt',
);


function agregar_zip($dir, $zip) {
    //verificamos si $dir es un directorio
    if (is_dir($dir)) {
        //abrimos el directorio y lo asignamos a $da
        if ($da = opendir($dir)) {
            //leemos del directorio hasta que termine
            while (($archivo = readdir($da)) !== false) {
                //Si es un directorio imprimimos la ruta
                //y llamamos recursivamente esta funciÃ³n 
                //para que verifique dentro del nuevo directorio
                //por mas directorios o archivos
                if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
                    agregar_zip($dir . $archivo . "/", $zip);

                    //si encuentra un archivo imprimimos la ruta donde se encuentra
                    //y agregamos el archivo al zip junto con su ruta
                } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    echo "Agregando archivo: $dir$archivo <br/>";
                    $zip->addFile($dir . $archivo, $dir . $archivo);
                }
            }
            //cerramos el directorio abierto en el momento
            closedir($da);
        }
    }
}

//fin de la funciÃ³n
//creamos una instancia de ZipArchive
$j = 0;

foreach ($Directorio as $item) {

   
    $zip = new ZipArchive();

    //directorio a comprimir
    //la barra inclinada al final es importante
    //la ruta debe ser relativa no absoluta     
    $dir = $item;
    
    //ruta donde guardar los archivos zip, ya debe existir
    $rutaFinal = "";

    $archivoZip=$nombre_archivo.".zip";

    if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
        agregar_zip($dir, $zip);
        $zip->close();

        //Muevo el archivo a una ruta
        //donde no se mezcle los zip con los demas archivos
        @rename($archivoZip, "$rutaFinal$archivoZip");

        //Hasta aqui el archivo zip ya esta creado
        //Verifico si el archivo ha sido creado
        if (file_exists($rutaFinal . $archivoZip)) {
            echo "Proceso Finalizado!! <br/><br/>
                Descargar: <a href='$rutaFinal$archivoZip'>$archivoZip</a>";
        } else {
            echo "Error, archivo zip no ha sido creado!!";
        }
    }
}


$j = 0;	
foreach ($Directorio_log_txt_array as $itemDirectorio){
    
    $Directorio_log_txt = glob($itemDirectorio,GLOB_BRACE);
   
       foreach ($Directorio_log_txt as  $direc){
     
       
     $nombres_txt_log[]=array_pop(split("/",$direc));
    
    
          	$fecha_creacion = date("Y-m-d",filemtime($direc));
                $dias_resta = 1; 	
		$fecha_hoy = date("Y-m-d");
		$fecha_carpeta1 = date("Y-m-d", strtotime("$fecha_hoy - $dias_resta day"));
                if($fecha_creacion<=$fecha_carpeta1) 
		{	
                    
		      unlink($direc);						
		}
		$j++;
     
 }
    
}


$directorio = opendir("backup/");
while ($archivo = readdir($directorio))
{
    	$nombreArch = $archivo;	
	$archivo_partido = explode("-",$nombreArch);
        $a�o_archivo = $archivo_partido[1];
        $mes_archivo = $archivo_partido[2]; 
	$dia_archivo = $archivo_partido[3];
	$fecha_archivo = trim($a�o_archivo)."-".trim($mes_archivo)."-".trim($dia_archivo);
        $dias_resta = 10; 	
	$fecha_hoy = date("Y-m-d");
 	$fecha_carpeta1 = date("Y-m-d", strtotime("$fecha_hoy - $dias_resta day"));  	
	//echo $fecha_archivo."</br>";
	if($fecha_archivo<$fecha_carpeta1) 
	{
		if($nombreArch != ".")
		{
			if($nombreArch != "..")
			{
				unlink("backup/".$nombreArch);
			}
		}
	}
}



    

      
  

  
  
