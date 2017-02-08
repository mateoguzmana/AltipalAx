<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/
$cont=0;

$session=new CHttpSession;
$session->open();

if( $session['componenteKitDinamico']){
     $datosKit=$session['componenteKitDinamico'];
}else{
    $datosKit=array();
 }
 
 
  print_r($datosKit);
?>

<?php foreach ($componenetesKid['detalle'] as $item): ?>
<?php 
    
    $cantidadFijoDigitado="";
    $cantidadOpcionalDigitado="";      
      
    //echo '<tr><td colspan="4">';
    
   
     $contItemd=0;
     
     foreach ($datosKit as $itemKit){   
        //echo $itemKit['txtCodigoLista'].'=='.$item['CodigoListaMateriales'] .' && '. ($itemKit['txtCodigoArticulo']).'=='.$cont."-".$item['CodigoArticuloComponente'].'</br>';
        if($itemKit['txtCodigoLista']==$item['CodigoListaMateriales'] && ($itemKit['txtCodigoArticulo'])== ($cont."-".$item['CodigoArticuloComponente'])){
           
              $cantidadFijoDigitado=$itemKit['txtCantidadItemFijo'];
              $cantidadOpcionalDigitado=$itemKit['txtCantidadItemOpcional'];
        }
        $contItemd++;
    }
    //echo '</td></tr>';
   
?>
<tr>
       
    <?php  if($item['Fijo']=='1' && $item['Opcional']=='0'){ ?>
    
        <td class="info"><?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?></td>
        <td class="info"><?php echo $item['CodigoTipo'];?>  <?php //echo $item['Fijo'];?><?php //echo $item['Opcional'];?></td>
    
    
         <td class="info">
             <input 
                 type="text" 
                 id="txtKitFijo-<?php echo $cont;?>"
                 value="<?php  if($cantidadFijoDigitado){echo $cantidadFijoDigitado;} else {echo $item['CantidadComponente'];}?>" 
                 data-obligatorio="1"
                 data-minimo="<?php echo $item['CantidadComponente'];?>"  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>" 
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 class="text-center kitDetalleFijo" 
                 style="width: 60px; font-weight: bold;"
                 />            
             
             
         </td>
         <td  class="info" >
             <input
                 type="text"
                 id="txtKitOpcional-<?php echo $cont;?>"
                 value="" 
                 readonly="readonly" 
                 data-minimo=""  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>"
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 class="text-center kitDetalleOpcional"  
                 style="width: 60px; background-color: #EEEEEE;"
                 /> 
         </td>
         
         
    <?php }else if($item['Fijo']=='0' && $item['Opcional']=='1'){ ?>  
         
        <td class="info"><?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?></td>
        <td class="info"><?php echo $item['CodigoTipo'];?>  <?php //echo $item['Fijo'];?> <?php //echo $item['Opcional'];?></td>
        
         <td class="info">
             <input 
                 type="text" 
                 id="txtKitFijo-<?php echo $cont;?>"
                 value="" 
                 readonly="readonly" 
                 data-minimo=""  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>"  
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 class="text-center kitDetalleFijo" 
                 style="width: 60px; background-color: #EEEEEE;"
                 />  
         </td>
         <td  class="info">
             <input 
                 type="text" 
                 id="txtKitOpcional-<?php echo $cont;?>"
                 value="<?php if($cantidadOpcionalDigitado){echo $cantidadOpcionalDigitado;} else {echo $item['CantidadComponente'];}?>"                  
                 class="text-center kitDetalleOpcional"
                 data-obligatorio="1"
                 data-minimo="<?php echo $item['CantidadComponente'];?>"  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>"                 
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 style="width: 60px; font-weight: bold"
                 /> 
         </td>
    
    <?php }else{ ?>
         
         <td><?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?></td>
        <td><?php echo $item['CodigoTipo'];?>  <?php //echo $item['Fijo'];?> <?php //echo $item['Opcional'];?></td>
         <td>
             <input 
                 type="text" 
                 id="txtKitFijo-<?php echo $cont;?>"
                 value="<?php echo $cantidadFijoDigitado;?>"
                 placeholder="<?php echo $item['CantidadComponente'];?>" 
                 class="text-center kitDetalleFijo" 
                 data-minimo="0"  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>"                 
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 style="width: 60px;"
                 />  
         </td>
         <td>
             <input 
                 type="text" 
                 readonly="readonly" 
                 id="txtKitOpcional-<?php echo $cont;?>"
                 value="<?php echo $cantidadOpcionalDigitado;?>"                  
                 class="text-center kitDetalleOpcional" 
                 data-minimo="<?php echo $item['CantidadComponente'];?>"  
                 data-unidad="<?php echo $item['CodigoUnidadMedida'];?>"
                 data-tipo="<?php echo $item['CodigoTipo'];?>"
                 data-codigo-lista="<?php echo $item['CodigoListaMateriales'];?>"
                 data-codigo-articulo-kit="<?php echo $item['CodigoArticuloKit'];?>"
                 data-codigo-articulo="<?php echo $cont;?>-<?php echo $item['CodigoArticuloComponente'];?>"                 
                 data-nombre="<?php echo $item['NombreArticulo'];?> <?php echo $item['CodigoCaracteristica1D'];?> <?php echo $item['CodigoCaracteristica2'];?>" 
                 style="width: 60px; background-color: #EEEEEE;"
                 /> 
         </td>
    
    <?php } ?>     
    
</tr>
<?php  $cont++; endforeach; ?>

<tr>
    <td colspan="4">
        <i style="padding: 17px;">            
        Los componentes que tienen un valor en el campo cantidad es obligatorio incluirlos en el kit
        </i>
    </td>
</tr>

<tr>
    <td colspan="4">
        <span class="text-center text-primary">Cantidad de produtos del Kit</span></br>
        Fijos: <span id="totalKitFijo" > <?php echo $componenetesKid['encabezado']['CantidadFijos']?> </span></br>
        Opcionales: <span id="totalKitOpcional"> <?php echo $componenetesKid['encabezado']['CantidadOpcionales']?> </span>
    </td>   
   
</tr>

