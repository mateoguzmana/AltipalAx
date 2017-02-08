<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/
$cont=0;

$session=new CHttpSession;
$session->open();

if( $session['listaMateriales']){
     $datosKit=$session['listaMateriales'];
}else{
    $datosKit=array();
 }
 
 
 foreach ($datosKit as $itemKit){
 ?>
<tr>
    
    
</tr>
     
<?php      
 }
?>



