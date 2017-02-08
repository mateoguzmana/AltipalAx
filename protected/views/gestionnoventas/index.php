<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Ruta de clientes gestión no ventas<span></span>
    </h2>      
</div>
  
<div class="contentpanel">

    <div class="panel panel-default">
   
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">   
                <div class="widget-content">                    
                    <form class="form-inline" method="post" action="">  
                        <div class="mb30"></div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tblClientesRutaNoVentas">
                                        <thead>
                                            <tr>                   
                                                <th > <h5> Clientes:</h5>  </th>                                 
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont = 1;
                                            $contNov = 0;
                                            foreach ($clientesRuta as $itemClientes) {
                                                
                                                 
                                                $pedidos = Gestionnoventa::model()->ContarPedidos($itemClientes['CuentaCliente']);
                                                $noventas = Gestionnoventa::model()->ContarNoventas($itemClientes['CuentaCliente']);
                                                  //foreach ($pedidos as $itempedido){
                                                      
                                                      ///foreach ($noventas as $itemventas){
                                                
                                                $pedidos['pedidos'];
                                                $noventas['noventas'];
                                                
                                                
                                            
                                                ?>
                                                <?php 
                                                
                                                if($pedidos['pedidos'] > 0 || $noventas['noventas'] > 0 ){
                                                
                                                 $contNov ++;
                                                 $cli = count($clientesRuta);
                                                
                                                 
                                                if($contNov == count($clientesRuta)){
                                                   
                                                ?>
                                            
                                                <script>
                                                
                                                $(document).ready(function() {
                                                    
                                                    $('#_alertClientesGestionados .text-modal-body').html('Usted no tiene mas clientes por gestionar');
                                                    $('#_alertClientesGestionados').modal('show');
                                                    $('#_alertInformationGestionNoVenta').modal('hide');

                                                });
                                                
                                                </script>
                                                
                                               
                                                <?php 
                                                    }
                                                  }else{
                                                
                                                ?>
                                                <tr class="odd gradeX seleccionarClienteNoventa" data-cuenta-cliente=" <?php echo $itemClientes['CuentaCliente']; ?>" data-zona-ventas="<?php echo $zonaVentas; ?>">
                                                    <td> 
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="mb20"></div>
                                                                <img src="images/cliente.png" class="img-rounded" style="width: 75px;"/>
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
                                                                            <?php echo $itemClientes['Telefono']; ?> 
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


<div class="modal fade" id="alertaCarteraPendiente" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Recaudos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary btn-small-template" id="btnRecibosCaja">OK</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<?php $this->renderPartial('//mensajes/_alertConfirmationMenuGestionNoVenta');?>
<?php $this->renderPartial('//mensajes/_alertInformationGestionNoVenta');?>
<?php $this->renderPartial('//mensajes/_alertClientesGestionados');?>


<script>

    $(".seleccionarClienteNoventa").click(function() {
        var cuentaCliente = $(this).attr('data-cuenta-cliente');
        var zonaVentas = $(this).attr('data-zona-ventas');


        var cuentaCliente = cuentaCliente.trim();
        var zonaVentas = zonaVentas.trim();

        window.location.href = "index.php?r=Noventas/AjaxGestionNoventa&cliente=" + cuentaCliente + "&zonaVentas=" + zonaVentas;
        
        

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