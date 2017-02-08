<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$session = new CHttpSession;
$session->open();

if ($session['PerfilAprobacionDoc']) {
    $datos = $session['PerfilAprobacionDoc'];
} else {
    $datos = array();
}
?>


<div class="panel panel-default">

    <div class="row">      
    <div class="col-sm-3">
            <label>Proveedor</label>    
    </div>
          <div class="col-sm-7">
              <select id="proveedores" name="proveedores" class="form-control selectedPerfilesAprobacion" disabled="true">
                <option value="0">Seleccione un proveedor</option>

                <?php
                foreach ($proveedores as $itemProveedores):
                    ?>
                    <?php
                    $selected = FALSE;


                    foreach ($datos as $itemSeleccioando) {
                        $proveedores = $itemSeleccioando['proveedores'];
                        if ($itemProveedores['CodigoCuentaProveedor'] == $proveedores) {
                            $selected = TRUE;
                        }
                    }
                    ?>
                    <option <?php if ($selected) {
                    echo "selected='selected'";
                } ?> value="<?php echo $itemProveedores['CodigoCuentaProveedor']; ?>"><?php echo $itemProveedores['CodigoCuentaProveedor']; ?>---<?php echo $itemProveedores['NombreCuentaProveedor']; ?></option>

<?php endforeach; ?>    
            </select>
        </div>   
  </div> 
    
    <br>
    
<div class="row">      
    <div class="col-sm-3">
            <label>Perfil Aprobación</label>    
    </div>
          <div class="col-sm-7">
           <select id="perfilaprobaciondoc" name="perfilaprobaciondoc" class="form-control selectedPerfilesAprobacion">
                <option value="0">Seleccione un perfil</option>
                <?php
                foreach ($perfilaprobacion as $itemPerfilaprobacion):
                    ?>

                    <?php
                    $selectedPerfilApro = FALSE;
               

                    foreach ($datos as $itemSeleccioandoPerfilAproba) {
                        $perfilaprobaciones = $itemSeleccioandoPerfilAproba['perfilaprobaciondoc'];
                        if ($itemPerfilaprobacion['IdPerfilAprobacion'] == $perfilaprobaciones) {
                            $selectedPerfilApro = TRUE;
                        }
                    }
                    ?>

                    <option <?php if($selectedPerfilApro){echo "selected='selected'";} ?> value="<?php echo $itemPerfilaprobacion['IdPerfilAprobacion']; ?>"><?php echo $itemPerfilaprobacion['Descripcion']; ?></option>

                <?php endforeach; ?>    
            </select>
        </div>   
  </div>
  

    <br>
    
    
<div class="row">      
    <div class="col-sm-3">
            <label>Envio de Correo</label>    
    </div>
          <div class="col-sm-7">
            <select id="envio" name="envio" class="form-control selectedPerfilesAprobacion">
                <?php 
                 foreach ($envio as $itemenvio):
                ?>
                  <?php
                    $selectedEnvio = FALSE;


                    foreach ($datos as $itemSeleccioandoEnvio) {
                        $envios = $itemSeleccioandoEnvio['envio'];
                        if ($itemenvio['IdConfrimacion'] == $envios) {
                            $selectedEnvio = TRUE;
                        }
                    }
                    ?>
                <option <?php if($selectedEnvio){echo "selected='selected'";} ?> value="<?php echo $itemenvio['IdConfrimacion']; ?>"><?php echo $itemenvio['Descripcion']; ?></option>
                
                 <?php endforeach; ?>   
            </select>
        </div>   
  </div>
  
   