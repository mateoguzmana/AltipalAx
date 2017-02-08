<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$session = new CHttpSession;
$session->open();

if ($session['ConceptosNotasCredito']) {
    $datos = $session['ConceptosNotasCredito'];
} else {
    $datos = array();
}
?>

<div class="panel panel-default">
    
     <div class="row">
            <div class="ckbox ckbox-primary">
                <input type="checkbox" id="chek" class="selecciona" onclick="marcarCheck(this)">
                <label for="chek">Todos</label>
            </div>
        </div>

    <?php foreach ($conceptosnotascreditos as $itemConceptosNotasCredito): ?> 
      
                        
                 <?php 
                   $check=FALSE;
                 
                   
                   foreach ($datos as $itemSeleccioando){
                       $conceptosnota=$itemSeleccioando['conceptosnotascreditos'];
                       if($itemConceptosNotasCredito['CodigoConceptoNotaCredito']==$conceptosnota){
                          $check=TRUE;
                      }                      
                       
                   } 
                 
                 ?>     

        <div class="ckbox ckbox-primary">
            <input 
               <?php if($check){echo "checked='checked'";} ?>
                type="checkbox" 
                value="" 
                class="chekcConceptosNotasCredito" 
                id="checkbox<?php echo $itemConceptosNotasCredito['CodigoConceptoNotaCredito']; ?>"
                data-conceptosnotascredito="<?php echo $itemConceptosNotasCredito['CodigoConceptoNotaCredito']?>"
                />
            <label for="checkbox<?php echo $itemConceptosNotasCredito['CodigoConceptoNotaCredito']; ?>"><?php echo $itemConceptosNotasCredito['CodigoConceptoNotaCredito']; ?>---<?php echo $itemConceptosNotasCredito['NombreConceptoNotaCredito']; ?></label>

        </div>
    
               

    <?php endforeach; ?>    

</div>    




