<div class="contentpanel">

    <div class="panel panel-default">



        <div class="panel-body">
            
            <input type="button" value="Actualizar Version" class="btn btn-primary ActualizarVersion" style="width: 200px; height: 40px;">
            <br>
            <br>
            <input type="button" value="Ver Vesiones" class="btn btn-primary Versiones" style="width: 200px; height: 40px;">
            <br>
            <br>
            
            <div class="table-responsive">
                
                
                <table  id="Datoszona" class="table table-bordered">

                    <thead>
                        <tr>
                            <th class="text-center">Zona Ventas</th>
                            <th class="text-center">Cedula</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Clave</th>
                            <th class="text-center">Version</th>
                            <th class="text-center">Nueva Version</th>  
                            <th class="text-center">Agencia</th>
                            <th class="text-center">Actualizar<br>Todos<input type="checkbox" id="todos" onclick="marcarCheck(this);"></th>
                        </tr>        
                    </thead>


                </table> 

            </div>

        </div>
    </div> 

</div>


<div class="modal fade" id="_modalinformationVersiones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 960px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Versiones</h4>
            </div>
            <div class="modal-body" style="width: 1040px;">

                <div id="TablaVersiones" style=" position:relative; top:20px; left:-40px"></div>

            </div>
            <div class="modal-footer">
                 <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>



<?php $this->renderPartial('//mensajes/_alertaActualizacionVercion');?>
<?php $this->renderPartial('//mensajes/_alerta');?> 