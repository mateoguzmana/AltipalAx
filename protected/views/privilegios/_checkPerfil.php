
<form method="post" action="">

<?php  if($accionesController){ ?>  

<div class="row">   
    
    <?php    
    
    
    
        $contController=0;
        $bloque=0;
        $contColumnas=1;
        
        //echo '<pre>';
        //print_r($accionesRegistradas);
        
        foreach ($accionesController as  $accionesControllerItem){  
            
        $idMenu=$accionesRegistradas[$contController]['IdListaMenu'];
        
        
         if($idMenu!=$bloque){            
             $bloque=$idMenu;
             echo '</div>';
             echo '<div class="row" style="border: 1px solid #3891CB; margin-bottom:15px; padding:15px; ">';
             $menu=  Listamenu::model()->findByPk($idMenu);
             echo '<h4 style="color:#2C92D6;"><b>'.$menu->Descripcion.'</b> <input type="checkbox" class="all-bloque" data-bloque="'.$bloque.'"/></h4>';
             $contColumnas=1;
         } 
            
    ?>
        <div class="col-sm-2"> 
         <h4><?php echo $accionesRegistradas[$contController]['Descripcion']; $contColumnas++; ?></h4>
     
         <?php  
         
           
            $listaLink=$accionesRegistradas[$contController]['IdListaLink'];  
            $idMenu= Consultas::model()->getIdMenu($listaLink);
            $idMenu=$idMenu['IdListaMenu'];           
            
         ?>
         
         
         <input type="hidden" name="PerfilUsuario[]" value="<?php echo $idPerfil;?>">
         <input type="hidden" name="LinkLista[]" value="<?php echo $listaLink;?>">
         <input type="hidden" name="MenuLista[]" value="<?php echo $idMenu;?>">
         
    <?php foreach ($accionesControllerItem as $item){ ?> 
        <div class="row">
        <div class="col-sm-12">
        
             <?php 
              $registro=FALSE;              
              
             
              
             foreach ($perfilConfiguracion as $itemPerfil){                 
                 if( strtolower($item)==$itemPerfil['Descripcion'] &&  strtolower($accionesRegistradas[$contController]['Controlador'])==strtolower( $itemPerfil['Controlador'])){
                    $registro=TRUE;
                    break;
                 }                 
             } ?> 
            
            <?php
              $idAccion=  Consultas::model()->getIdAccion($item);
              $textoAccion=$idAccion['TextoMostrar'];
              $idAccion=$idAccion['IdAccion'];
              
              
              if(!empty($idAccion)){
                ?>
            <label class="checkbox-inline">    
                <input type="checkbox" class="bloque-<?php echo $bloque;?>" name="LinkListaDatos[<?php echo $listaLink;?>][]" value="<?php echo $idAccion;?>" <?php if($registro) echo "checked"  ?> id="inlineCheckbox3"> 
                <small><?php echo $textoAccion;?>
            <?php
            if($idAccion=='1'){
                echo ' '.$accionesRegistradas[$contController]['Descripcion']; 
            }                
                ?> 
                    </small>
           </label>
            
            <?php      
              }  
            ?>
       
                        
          </div>
        </div>
    <?php  } ?> 
          </div> 
   <?php  $contController++; 
            if($contColumnas==7){
                echo '<div class="row" style="padding:30px;"></div>';
                $contColumnas=0;
            }
              } ?>  
        <?php } ?> 
  
</div>
<div class="row">
    <div class="col-sm-12">
        <br/>
          <input type="submit" value="Guardar" class="btn btn-primary" />
    </div>
</div>

</form>