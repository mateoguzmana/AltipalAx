<?php
/* @var $this AdministarUsuariosController */
/* @var $model Administrador */
/* @var $form CActiveForm */

if (empty($donde)) {
    $donde = FALSE;
} else {
    $donde = TRUE;
}

$session = new CHttpSession;
$session->open();

if($datos){
  $session['AgenciaGrupoUsuario'] = $datos;  
    
}  else {
    
    unset($session['AgenciaGrupoUsuario']);
}


if($datosNotas){
  $session['ConceptosNotasCredito'] = $datosNotas;  
    
}  else {
    
    unset($session['ConceptosNotasCredito']);
}


if($datosPerfilAproba){
  $session['PerfilAprobacionDoc'] = $datosPerfilAproba;  
    
}  else {
    
  unset($session['PerfilAprobacionDoc']);
}
 
$totalagencias = count($datos);
$totalperfilesdoc = count($datosPerfilAproba);
$totalconceptos = count($datosNotas);

 
 if($donde){
     
   $totalagencias = 1;
     
 }
 
?>

<div class="col-sm-6 col-sm-offset-2">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'administrador-form',
        
    
         'enableAjaxValidation'=>true,
    
            'clientOptions'=>array(
              'validateOnSubmit'=>true,
            ),
    
        'htmlOptions'=>array(
               'class'=>'form-horizontal',
              // 'onsubmit'=>'javascript:valida()'
            
        ),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	
        
)); ?>

	
    <input type="hidden" id="totalagenciasasignadas" value="<?php echo $totalagencias ?>"/>
    <input type="hidden" id="totalperfilesasignacos" value="<?php echo $totalperfilesdoc ?>"/>
    <input type="hidden" id="totalconceptos" value="<?php echo $totalconceptos ?>"/>
    
     <div class="col-sm-offset-4">
        <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
       </div>
    
         <div class="form-group">
		<?php echo $form->labelEx($model,'Perfil *', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                
                <select class="form-control" name="Administrador[IdPerfil]" id="Administrador_IdPerfil" onchange="ValidarConceptosByCampos()">
             
                <?php
                $pe;
                if ($donde) {
                   $perfil2 = Perfil::model()->findByPk($model->IdPerfil);
                   $pe = $perfil2->IdPerfil;
                    
                } else {
                    ?>
                    <option value="0">Seleccione un perfil</option>
                    <?php
                }

                $modelsPerfil = Perfil::model()->findAll();
                foreach ($modelsPerfil as $itemperfil) {
                    ?>
                     <option <?php if ($pe == $itemperfil['IdPerfil'])  { ?> selected="selected" <?php }?>     value="<?php echo $itemperfil['IdPerfil']; ?>"><?php echo $itemperfil['Descripcion']; ?></option>
                    <?php
                }
                ?>

                  
            </select>
                
                
               
            </div>
             <div id="ErrorPerfil" class="col-sm-offset-6"></div>
	</div>
      
         <div class="form-group">
		<?php echo $form->labelEx($model,'TipoUsuario *', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                  
                <select class="form-control" name="Administrador[IdTipoUsuario]" id="Administrador_IdTipoUsuario" onchange="tipouser()">
             
                <?php
                $es;
                if ($donde) {
                   $tipouser2 = Tipousuario::model()->findByPk($model->IdTipoUsuario);
                   $es = $tipouser2->Id;
                    
                } else {
                    ?>
                    <option value="0">Seleccione un tipo de usuario</option>
                    <?php
                }

                $models = Tipousuario::model()->findAll();
                
                print_r($models);
                
                foreach ($models as $itemtipo) {
                    ?>
                     <option <?php if ($es == $itemtipo['Id'])  { ?> selected="selected" <?php }?>     value="<?php echo $itemtipo['Id']; ?>"><?php echo $itemtipo['Descripcion']; ?></option>
                    <?php
                }
                ?>

                  
            </select>
              
		
            </div>    
              <div id="ErrorTipoUser" class="col-sm-offset-6"></div>
	</div>
              
         
        <div class="form-group">
            
                  <?php echo $form->labelEx($model,'Cedula', array('class'=>'col-sm-4 control-label')); ?> 
                  
            <div class="col-sm-8">   
                    <?php echo $form->textField($model,'Cedula', array('class'=>'form-control','onkeypress'=>'return FilterInput (event)')); ?>                    
                  </div>
            <div style="color: red;" class="col-sm-offset-6">
                  <?php echo $form->error($model,'Cedula'); ?>
            </div>    
                </div>
        
	

	<div class="form-group">
		<?php echo $form->labelEx($model,'Usuario', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Usuario',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
            </div>
            <div style="color: red;" class="col-sm-offset-6">
		<?php echo $form->error($model,'Usuario'); ?>
            </div>    
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Clave', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Clave',array('size'=>16,'maxlength'=>16, 'class'=>'form-control')); ?>
             </div>
            <div style="color: red;" class="col-sm-offset-6">
		<?php echo $form->error($model,'Clave'); ?>
            </div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Nombres', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Nombres',array('size'=>25,'maxlength'=>25, 'class'=>'form-control')); ?>
            </div> 
            <div style="color: red;" class="col-sm-offset-6">
		<?php echo $form->error($model,'Nombres'); ?>
            </div>    
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Apellidos', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Apellidos',array('size'=>25,'maxlength'=>25, 'class'=>'form-control')); ?>
              </div>
            <div style="color: red;" class="col-sm-offset-6">
		<?php echo $form->error($model,'Apellidos'); ?>
            </div>    
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Email', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Email',array('size'=>50,'maxlength'=>50, 'class'=>'form-control', 'onblur'=>'validarEmail()', 'onkeypress'=>'return BarraEspce(event)')); ?>
            </div>  
            <div id="ErrorEmail" class="col-sm-offset-6"></div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Telefono', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Telefono',array('size'=>30,'maxlength'=>30, 'class'=>'form-control','onkeypress'=>'return FilterInput (event)')); ?>
            </div>    
		<?php echo $form->error($model,'Telefono'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Celular', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Celular',array('size'=>20,'maxlength'=>20,'class'=>'form-control','onkeypress'=>'return FilterInput (event)')); ?>
            </div>    
		<?php echo $form->error($model,'Celular'); ?>
	</div>

	

	<div class="form-group">
		<?php echo $form->labelEx($model,'Direccion', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
		<?php echo $form->textField($model,'Direccion',array('size'=>50,'maxlength'=>50,'class'=>'form-control' )); ?>
            </div>
            <div style="color: red;" class="col-sm-offset-6">
		<?php echo $form->error($model,'Direccion'); ?>
            </div>    
	</div>
 
	<div class="form-group">
		<?php echo $form->labelEx($model,'Activo', array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                
                 <select class="form-control" name="Administrador[Activo]" id="Administrador_Activo">
             
                <?php
                $esta;
                if ($donde) {
                   $estado2 = Tipoestado::model()->findByPk($model->Activo);
                   $esta = $estado2->Id;
                    
                } else {
                    ?>
                     
                    <?php
                }

                $modelsEstado = Tipoestado::model()->findAll(array('order'=>'Descripcion'));
                foreach ($modelsEstado as $itemestado) {
                    ?>
                     <option <?php if ($esta == $itemestado['Id'])  { ?> selected="selected" <?php }?>     value="<?php echo $itemestado['Id']; ?>"><?php echo $itemestado['Descripcion']; ?></option>
                    <?php
                }
                ?>

                  
            </select>
                 
            </div>     
		<?php echo $form->error($model,'Activo'); ?>
	</div>
            
	 
        
        <div class="col-sm-12 col-sm-offset-3">
           
            <button type="button" class="btn btn-default text-center" id="btnCargarGrupoVentas">
                <img src="images/agencias_grupos.png" style="width: 25px;">           
                <span class="text-primary"><b>Agencias -- Grupo Ventas</b></span> 
            </button>
           
            <?php foreach ($verificacionconfig as $itemupdate){
                
            $configiracion = $itemupdate['perimisoparaconceptos'];  
                
            }  ?>
            
            <?php if($configiracion > 0)
            {
                   
                ?>
            <button type="button" class="btn btn-default text-center" id="btnCargarConceptosNotasCredito">
                <img src="images/config_concept_not.png" style="width: 25px;">           
                <span class="text-primary"><b>Conceptos Notas Credito</b></span> 
            </button>
            <?php }else{ ?>
            <button type="button" class="btn btn-default text-center" id="btnCargarConceptosNotasCredito" disabled="true">
                <img src="images/config_concept_not.png" style="width: 25px;">           
                <span class="text-primary"><b>Conceptos Notas Credito</b></span> 
            </button>
            
            <?php } ?>
            
           
             
        </div>
        <br>
        <br>
        
        <div class="col-sm-12 col-sm-offset-5">
            
          <?php foreach ($verificacionconfig as $itemupdate){
                
            $configiracion = $itemupdate['perimisoparaconceptos'];  
                
            }  ?>
              
       
            
             <?php if($configiracion > 0)
            {
                ?>
           <button type="button" class="btn btn-default text-center" id="btnCargarPerfilAprovacionDoc">
                <img src="images/perfilaprovaciondoc.png" style="width: 25px;">           
                <span class="text-primary"><b>Perfil Aprobación Documentos</b></span> 
            </button>
            <?php }else{ ?>
            <button type="button" class="btn btn-default text-center" id="btnCargarPerfilAprovacionDoc" disabled="true">
                <img src="images/perfilaprovaciondoc.png" style="width: 25px;">           
                <span class="text-primary"><b>Perfil Aprobación Documentos</b></span> 
            </button>
            
            <?php } ?>
          
          
        
        
         </div>
        <input type="hidden" id="validaciondebotones">
	<div class="form-group buttons">
              <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar'); ?> 
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php if($donde){ ?>

     
<div class="modal fade" id="mdlAgenciaGrupoVentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Agencias y grupo de ventas</h4>
      </div>
      <div class="modal-body" style="height: 450px; overflow-y: scroll">
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnAsignarAgenciaGrupoVentasModal" class="btn btn-primary">Asignar Configuración</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
<?php }else{ ?>

<div class="modal fade" id="mdlAgenciaGrupoVentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Agencias y grupo de ventas</h4>
      </div>
      <div class="modal-body" style="height: 450px; overflow-y: scroll">
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnAsignarAgenciaGrupoVentas" class="btn btn-primary">Asignar Configuración</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<?php } ?>


<div class="modal fade" id="mdlConceptosNotasCredito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Conceptos Notas Credito</h4>
      </div>
      <div class="modal-body" style="height: 215px; overflow-y: scroll">
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnAsignarCopceptosNotasCreditos" class="btn btn-primary">Asignar Configuración</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="mdlInformacionPerfilAprobacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Perfil Aprobación Documentos</h4>
      </div>
      <div class="modal-body" style="height: 215px; overflow-y: scroll">
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnAsignarPerfilAprobacionDocumentos" class="btn btn-primary">Asignar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

      
<div class="modal fade" id="_alerta" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


 <div class="modal fade" id="_alertAsignarAgenciaUpdate" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" id="bntcerrarmodal" class="btn btn-primary" type="button">Si</button>   
                <button data-dismiss="modal" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

