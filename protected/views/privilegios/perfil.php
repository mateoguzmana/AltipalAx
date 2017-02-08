<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<div class="pageheader">
    <h2><i class="fa fa-unlock-alt"></i> Privilegios <span></span></h2>      
</div>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            
                <a class="minimize maximize" href="#">+</a>
            </div>
            <h4 class="panel-title">Administrar perfiles</h4>

        </div>
        <div class="panel-body">


            <div class="widget widget-blue">



                <div class="widget-content">

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Perfiles</label>
                                <div class="col-md-6">                  
                                    
                                    <?php //echo Yii::app()->user->_idPerfil;?>
                                    <select class="form-control" id="seleccionarPerfil">
                                        
                                        <option>Seleccionar perfil</option>
                                        <?php foreach ($perfiles as $itemPerfiles) { ?> 
                                        <?php if($itemPerfiles['IdPerfil']!='11'): ?>
                                            <option  <?php
                                            if (!empty($idPerfil)) {
                                                if ($idPerfil == $itemPerfiles['IdPerfil'])
                                                    echo "selected";
                                            }
                                            ?>   value="<?php echo $itemPerfiles['IdPerfil']; ?>" id="option-perfil-<?php echo $itemPerfiles['IdPerfil']; ?>"><?php echo $itemPerfiles['Descripcion']; ?></option>
                                            <?php endif;?>
                                        <?php } ?>
                                        <?php    
                                          if(Yii::app()->user->_idPerfil=="11"){
                                           ?>   
                                            
                                            <option  <?php
                                            if (!empty($idPerfil)) {
                                                if ($idPerfil == Yii::app()->user->_idPerfil)
                                                    echo "selected";
                                            }
                                            ?>   value="<?php echo Yii::app()->user->_idPerfil; ?>" id="option-perfil-<?php echo Yii::app()->user->_idPerfil; ?>">Administrador Root</option>
                                            
                                            <?php
                                          }  
                                         ?>   
                                    </select>
                                    <br/>
                                    <div id="loading2"></div>
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary" id="agregarPrefil">Agregar perfil</button>                    
                                </div>

                            </div>
                        </div>    
                    </div>

                    <div id="content-perfil">

                    </div>

                </div>
            </div>



        </div>
    </div>      



</div>



<div class="modal fade" id="modalAgregarPerfil" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Administrar Perfil</h4>
            </div>

            <div class="modal-body">

                <form action="" role="form" method="post" class="form-horizontal" id="form">
                    <div class="form-group">
                        <label class="col-md-3 control-label">perfil</label>
                        <div class="col-md-7">
                            <input style="height: 26px;" type="text"  id="perfil"  class="form-control" name="perfil['nombrePerfil']" placeholder="Ingrese el nombre del perfil">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" class="btn btn-primary" value="Crear Perfil"/>                                  
                        </div>
                    </div>    

                    <div class="row">


                        <div class="col-md-10 col-md-offset-1">

                            <div id="mensaje-eliminar-perfil"></div>                                          

                            <table class="table table-hover ">   
                                <tr>
                                    <th>PERFILES</th>
                                    <th></th>
                                </tr>
<?php foreach ($perfiles as $itemPerfiles) { ?> 
                                    <tr id="tr-eliminar-<?php echo $itemPerfiles['IdPerfil']; ?>">
                                        <th><?php echo $itemPerfiles['Descripcion']; ?></th>
                                        <th><a class="btn btn-danger btn-xs eliminar-perfil" href="#" data-id="<?php echo $itemPerfiles['IdPerfil']; ?>">Eliminar</a></th>
                                    </tr>                                  
<?php } ?>
                            </table>                              

                        </div>                                      
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<?php $this->renderPartial('//mensajes/_alerta');?>

<script>

$("#form").submit(function() {
    
    var perfil = $("#perfil").val();
    
    if (perfil == "") {

        $('#_alerta .text-modal-body').html("Por favor ingrese el nombre del nuevo perfil");
        $('#_alerta').modal('show');
        return false;

    }
    
});


</script>

<?php
if (!empty($idPerfil)) {
    ?>
    <script>
        
         
    window.onload = function() {

        $.ajax({
            data: {
                "idPerfil": <?php echo $idPerfil; ?>
            },
            url: 'index.php?r=Privilegios/AjaxConfiguracionPerfil',
            type: 'post',
            beforeSend: function() {
                $load = '<img id="imagenGif" src="images/loaders/loader9.gif"> Cargando perfil...';
                $("#loading2").html($load);
            },
            success: function(response) {
                $("#loading2").html('');
                $('#content-perfil').html(response);

                $('.all-bloque').click(function() {
                    var bloque = $(this).attr('data-bloque');
                    if ($(this).is(':checked')) {

                        $('.bloque-' + bloque).each(function() {
                            $(this).prop('checked', true);
                        });

                    } else {
                        $('.bloque-' + bloque).each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                })
            }


        });

}


    </script>  

    <?php
}
?>