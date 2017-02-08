

<div class="contentpanel">
    
    <div class="panel panel-default">
        
         <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <form class="form-inline" method="post" action="">
                        <div class="mb30"></div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="">
                                    <table class="table table-hover" id="tblEncuestas">
                                        <thead>
                                            <tr>
                                                <th>Cedula: <span class="text-primary"><?php echo $datosCliente['Identificacion'];  ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Razon Social: <span class="text-primary"><?php echo $datosCliente['NombreBusqueda']; ?></th>
                                            </tr>
                                            <tr>
                                              <th>
                                                  <h5> Encuestas:</h5> 
                                              </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont = 1;
                                            foreach ($Encuestas as $itemEncuesta) {
                                                ?>
                                                <tr class="odd gradeX seleccionarEncuesta cursorpointer" data-IdEncuesta="<?php echo $itemEncuesta['IdTitulo']; ?>" data-CuentaCliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-zona="<?php echo $datosCliente['CodZonaVentas']; ?>" data-CodAsesor="<?php echo $CodAsesor ?>">
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="mb20"></div>
                                                            <img src="images/ruta.png" class="img-rounded" style="width: 75px;"/>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h3 class="text-primary">
                                                                             <input type="hidden" value="<?php echo $cont ?>" class="Contador">
                                                                            <?php echo $cont++ . ' - ' . $itemEncuesta['Titulo']; ?>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>
                                                                              Fecha Inicio 
                                                                            </b>
                                                                            <?php echo $itemEncuesta['FechaInicio']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Fecha Fin: </b>
                                                                            <?php echo $itemEncuesta['FechaFin']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Descripcion: </b>
                                                                            <?php echo $itemEncuesta['Descripcion'];?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                         <?php if($itemEncuesta['Tipo'] == 1){
                                                                             
                                                                             $tipo = 'Obligatoria';
                                                                             
                                                                         }else{
                                                                             
                                                                             $tipo = 'No Obligatoria';
                                                                         }?>
                                                                        <span>
                                                                            <b>Tipo: </b>
                                                                              <?php echo $tipo ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
    </div>
    
    
</div>


<script>

$('body').on('click','.seleccionarEncuesta',function (){
    
  var idEncuesta = $(this).attr('data-IdEncuesta');
  var cuentaCliente = $(this).attr('data-CuentaCliente');
  var zonaVentas = $(this).attr('data-zona');
  var codAsesor = $(this).attr('data-CodAsesor');
  
   $.ajax({
            data: {
                "idEncuesta": idEncuesta,
                "cuentaCliente":cuentaCliente,
                "zonaVentas":zonaVentas,
                "codAsesor":codAsesor
            },
            async: false,
            url: 'index.php?r=clientes/AjaxSetEncuesta',
            type: 'post',
            success: function(response) {
                 window.location.href = "index.php?r=Clientes/Encuestar&cliente=" + cuentaCliente + "&zonaVentas=" + zonaVentas;
            }
        });
   
   
});


</script>