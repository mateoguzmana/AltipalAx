<?php if(Yii::app()->user->hasFlash('success')):?>
<script>    
    $(document).ready(function() {        
    $('#_alertaSucess #msg').html('Mensaje Cliente');  
    $('#_alertaSucess #sucess').html('<?php echo Yii::app()->user->getFlash('success'); ?>');
   // $('#_alertaSucess #sucess').html('Datos guardados satisfactoriamente');
    $('#_alertaSucess #btnAceptar').click(function (){ location.reload(true)});
    $('#_alertaSucess').modal('show');
     });
</script>   
<?php endif; ?>

<?php $this->renderPartial('//mensajes/_alertSucess');?> 

<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        Ruta de Clientes<span></span>
    </h2>
</div>

<div class="contentpanel">


<?php $ClientesDisponible = count($clientesExtraRuta); ?>


    <div class="panel panel-default">

         <ul class="nav nav-tabs">
          <li class="active"><a href="#ruta" data-toggle="tab">
                   <img src="images/ruta.png" style="width: 24px; padding-right: 2px;"/>
                  <strong>Ruta</strong></a>
          </li>
          <li><a href="#extraruta" data-toggle="tab">
                <img src="images/terminar_ru.png" style="width: 24px; padding-right: 2px;"/>
                  <strong>Extraruta</strong>
              </a></li>

          <li><a href="#clientesNuevos" data-toggle="tab">
                <img src="images/clientes_nuevos.png" style="width: 24px; padding-right: 2px;"/>
                  <strong>Clientes Nuevos</strong>
              </a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content mb30">
          <div class="tab-pane active" id="ruta">


                <div class="panel-heading">
            <h5> Ruta: <span class="text-primary"><?php echo $diaRuta; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No. Clientes Ruta: <span class="text-primary"><?php echo count($clientesRuta); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No. Clientes Extraruta: <span class="text-primary"><?php echo count($clientesExtraRuta); ?></span>
            </h5>
                    <?php
                    $Clientes = count($clientesRuta);
                    if($Clientes == 0){?>
                        <script>    
                            $(document).ready(function() {
                            $('#_alertaSucessNoHayClientes').modal('show');
                             });
                        </script>   
                    <?php } 
                    ?>

        </div>
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <form class="form-inline" method="post" action="">
                        <div class="mb30"></div>
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="">
                                    <table class="table table-hover" id="tblClientesRuta">
                                        <thead>
                                            <tr>
                                                <th > <h5> Clientes:</h5>  </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont = 1;
                                            foreach ($clientesRuta as $itemClientes) {
                                                
                                                       $facturasClienteZona = Consultas::model()->getFacturasClienteZona($itemClientes['Identificacion']);
                                                       
                                                       $Fecha="";
                                                       if(!empty($facturasClienteZona)){
                                                        foreach ($facturasClienteZona as $item) {

                                                            $Dias = Consultas::model()->getDiasAdicionaGraciasCliente($itemClientes['CuentaCliente'], $zonaVentas);

                                                            $diasGracia = $Dias[0]['diasgracia'];


                                                            $fecha = date_create($item['FechaVencimientoFactura']);
                                                            //date_add($fecha, date_interval_create_from_date_string($diasGracia . 'days'));
                                                            $Fecha = date_format($fecha, 'Y-m-d');
                                                        }
                                                      }
                                                        
                                                         $noRecaudos = Consultas::model()->getNoRecaudos($zonaVentas,$codigoAsesor,$itemClientes['CuentaCliente']);
                                                         $totalNoRecaudos=  count($noRecaudos);
                                                         
                                                        $facturasCliente=  Consultas::model()->getFacturasCliente($itemClientes['Identificacion']);
                                                        
                                                      $contadorzona=0;  
                                                      foreach ($facturasCliente as $itemFacliente){
                                                              if(trim($itemClientes['CuentaCliente']) == trim($itemFacliente['CuentaCliente'])){
                                                               $contadorzona++; 
                                                               }
                                                       }
                                                       
                                                       $tipoPago = Consultas::model()->getTipoPago($zonaVentas);
                                                          
                                                       $fechaActual=  date('Y-m-d'); 
                                                
                                                ?>
                                                <tr class="odd gradeX seleccionarCliente" data-ruta="<?php echo $diaRuta; ?>" data-extraruta="0" data-cuenta-cliente=" <?php echo $itemClientes['CuentaCliente']; ?>" data-zona-ventas="<?php echo $zonaVentas; ?>">
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="mb20"></div>
                                                                <?php
                                                                    $terminarruta = ClientesRuta::model()->TerminarRuta($zonaVentas);
                                                                  
                                                                    
                                                                    if(count($terminarruta) > 0){
                                                                
                                                                     $noventas = ClientesRuta::model()->ContarNoventas($itemClientes['CuentaCliente'],$terminarruta[0]['FechaMensaje'],$terminarruta[0]['HoraMensaje']);
 
                                                                     
                                                                     $pedidos = ClientesRuta::model()->ContarPedidos($itemClientes['CuentaCliente'],$terminarruta[0]['FechaMensaje'],$terminarruta[0]['HoraMensaje']);
                                                                     //print_r($terminarruta);
                                                                     //die();
                                                                    }else{
                                                                        
                                                                       $noventas = ClientesRuta::model()->ContarNoventasRutaSinTerminar($itemClientes['CuentaCliente'],$zonaVentas); 
                                                                       
                                                                       $pedidos = ClientesRuta::model()->ContarPedidosRutaSinTerminar($itemClientes['CuentaCliente'],$zonaVentas);
                                                                        
                                                                    }
                                                                   
                                                                     $noventas['noventas'];
                                                                     $pedidos['pedidos'];
                                                                ?>
                                                                <?php
                                                                    if($noventas['noventas'] > 0){

                                                                ?>
                                                                <img src="images/cliente_novisita2.png" class="img-rounded" style="width: 75px;"/>

                                                                <?php
                                                                    }else if($pedidos['pedidos'] > 0){

                                                                ?>
                                                                <img src="images/cliente_pedido.png" class="img-rounded" style="width: 75px;"/>

                                                                <?php
                                                                    }else{
                                                                ?>
                                                                    <img src="images/cliente.png" class="img-rounded" style="width: 75px;"/>
                                                                <?php
                                                                   }
                                                                 ?> 

                                                            </div>
                                                            <div class="col-sm-11">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h3 class="text-primary">
                                                                             <input type="hidden" value="<?php echo $cont ?>" class="Contador">
                                                                            <?php echo $cont++ . ' - ' . $itemClientes['NombreBusqueda']; ?>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Nit: </b>
                                                                            <?php echo $itemClientes['Identificacion']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>
                                                                                <?php echo $itemClientes['CuentaCliente']; ?> -
                                                                            </b>
                                                                            <?php echo $itemClientes['NombreCliente']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Dirección: </b>
                                                                            <?php echo $itemClientes['DireccionEntrega']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Teléfono: </b>
                                                                            <?php echo $itemClientes['Telefono']; if($itemClientes['TelefonoMovil']) echo '--'.$itemClientes['TelefonoMovil']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Hora: </b>
                                                                            <?php echo $itemClientes['Posicion']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Cartera Vencida: </b>
                                                                            <?php if($Fecha !="" && $totalNoRecaudos=='0' && $tipoPago['AplicaContado']=="falso" && $fechaActual>$Fecha){ ?>
                                                                                     <?php echo 'Si' ?>
                                                                            <?php }else{  ?>
                                                                                      <?php echo 'No' ?>
                                                                            <?php } ?>
                                                                            
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
          <div class="tab-pane" id="extraruta">

               <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <form class="form-inline" method="post" action="">
                        <div class="mb30"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-hover" id="tblClientesExtraRuta">
                                        <thead>
                                            <tr>
                                                <th > <h5> Clientes:</h5>  </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont = 1;
                                            foreach ($clientesExtraRuta as $itemClientes) {
                                                ?>
                                                <tr class="odd gradeX seleccionarCliente" data-ruta="<?php echo $diaRuta; ?>" data-extraruta="1" data-cuenta-cliente=" <?php echo $itemClientes['CuentaCliente']; ?>" data-zona-ventas="<?php echo $zonaVentas; ?>">
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="mb20"></div>
                                                                <?php
                                                                 $terminarruta = ClientesRuta::model()->TerminarRuta($zonaVentas);
                                                                    
                                                                    
                                                                    if(count($terminarruta) > 0){
                                                                
                                                                     $noventas = ClientesRuta::model()->ContarNoventas($itemClientes['CuentaCliente'],$terminarruta[0]['FechaMensaje'],$terminarruta[0]['HoraMensaje']);

                                                                     $pedidos = ClientesRuta::model()->ContarPedidos($itemClientes['CuentaCliente'],$terminarruta[0]['FechaMensaje'],$terminarruta[0]['HoraMensaje']);
                                                                     
                                                                    }
                                                                     $noventas['noventas'];
                                                                     $pedidos['pedidos'];
                                                                ?>
                                                                <?php
                                                                    if($noventas['noventas'] > 0){

                                                                ?>
                                                                <img src="images/cliente_novisita2.png" class="img-rounded" style="width: 75px;"/>

                                                                <?php
                                                                    }elseif($pedidos['pedidos'] > 0){

                                                                ?>
                                                                <img src="images/cliente_pedido.png" class="img-rounded" style="width: 75px;"/>

                                                                <?php
                                                                    }else{
                                                                ?>
                                                                    <img src="images/cliente.png" class="img-rounded" style="width: 75px;"/>
                                                                <?php

                                                                    }

                                                                ?>

                                                            </div>
                                                            <div class="col-sm-11">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h3 class="text-primary">
                                                                            <?php echo $cont++ . ' - ' . $itemClientes['NombreBusqueda']; ?>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Nit: </b>
                                                                            <?php echo $itemClientes['Identificacion']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>
                                                                                <?php echo $itemClientes['CuentaCliente']; ?> -
                                                                            </b>
                                                                            <?php echo $itemClientes['NombreCliente']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Dirección: </b>
                                                                            <?php echo $itemClientes['DireccionEntrega']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Teléfono: </b>
                                                                            <?php echo $itemClientes['Telefono']; if($itemClientes['TelefonoMovil']) echo '--'.$itemClientes['TelefonoMovil']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Hora: </b>
                                                                            <?php echo $itemClientes['Posicion']; ?>
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

          <div class="tab-pane" id="clientesNuevos">

               <div class="panel-body" style="min-height: 550px;">
            <div class="widget widget-blue">
                <div class="widget-content">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6 col-sm-offset-3">
                                <form class="form-inline" action="index.php?r=ClientesNuevos/ClientesNuevos" method="post" id="frmConsultarCliente">

                                    <div class="panel panel-default">             
                                        <div class="panel-body">

                                            <div class="form-group" style="display: block">
                                                <label class="col-sm-4 control-label">Tipo Identificación:</label>
                                                <div class="col-sm-8">              

                                                    <select required class="form-control" name="tipoIdentificacion" id="tipoIdentificacion" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php
                                                        $tipoDocumento = Consultas::model()->getTipoDocumento();
                                                        if ($tipoDocumento) {
                                                            foreach ($tipoDocumento as $itemTipoDocumento) {
                                                                ?>
                                                                <option value="<?php echo $itemTipoDocumento['Codigo']; ?>"  <?php if ($itemTipoDocumento['Codigo'] == $tipoIdentificacion) echo "selected" ?> ><?php echo $itemTipoDocumento['Nombre']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="mb15"></div>
                                            <div class="form-group" style="display: block">
                                                <label class="col-sm-4 control-label">Identificación:</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" name="rutaSeleccionada" value="<?php echo trim($diaRuta); ?>" id="rutaSeleccionada"/>
                                                    <input type="hidden" name="zonaVentas" value="<?php echo trim($zonaVentas); ?>" id="zonaVentas"/>
                                                    <input type="text" placeholder="Identificación" id="identificacionCliente" name="identificacionCliente" class="form-control" required value="" style="width: 100%">
                                                    <div id="img">
                                                    <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
                                                     Cargando.....
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- panel-body -->
                                        <div class="panel-footer">
                                            <button class="btn btn-primary  ValidarCaracteres" type="submit">Consultar cliente</button>
                                        </div><!-- panel-footer -->
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div><!-- panel-body -->
                </div>
            </div>
        </div>

          </div>


        </div>
    </div>
</div>

<?php $this->renderPartial('//mensajes/_alertConfirmationMenuRutas');?>
<?php $this->renderPartial('//mensajes/_alerta');?>

<script>
    
    
    $("#tipoIdentificacion").change(function (){
        
        var tipo =  $("#tipoIdentificacion").val();
        
        if(tipo == '001'){
           
          $("#identificacionCliente").attr('maxlength','9');
        }else{
            
            $("#identificacionCliente").removeAttr('maxlength','9'); 
        }
        
    });
   
    $('#identificacionCliente').keypress(function(){
      if($(this).val() !== ''){
          var value = $.trim($(this).val());
          $(this).val(value);
      } 
    });

    $(".seleccionarCliente").click(function() {
        var cuentaCliente = $(this).attr('data-cuenta-cliente');
        var zonaVentas = $(this).attr('data-zona-ventas');
        var cuentaCliente = cuentaCliente.trim();
        var zonaVentas = zonaVentas.trim();
        var extraRuta=$(this).attr('data-extraruta');
        var rutaSeleccionada=$(this).attr('data-ruta');
        var Contador = $(".Contador",this).val();
        
        
        $.ajax({
            data: {
                "extraRuta": extraRuta,
                "rutaSeleccionada":rutaSeleccionada,
                "Contador":Contador
            },
            async: false,
            url: 'index.php?r=clientes/AjaxSetExtraRuta',
            type: 'post',
            success: function(response) {
                 window.location.href = "index.php?r=Clientes/menuClientes&cliente=" + cuentaCliente + "&zonaVentas=" + zonaVentas;
            }
        });



    });

</script>


<style>

    .table-rutero td:hover{
        background-color: #FFF !important;
        cursor: pointer;
    }

    tr:hover{
        cursor: pointer;
    }

    .ui-menu{
        background-color: #FFF;
        border: 1px solid #ccc;
    }

    .ui-menu .ui-menu-item a:focus{
        color: #C7254E;
        border-radius: 0px;
        border: 1px solid #454545;
    }
</style>