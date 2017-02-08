<style>
    td{
        text-align: center
    }
</style>

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body">
            
            <div> <img src="images/detalle_producto.png" style="width: 55px" class="cursorpointer DetalleInformacion"/><br/>
                  <span class="text-primary cursorpointer DetalleInformacion">Detalle</span></div>

            <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                <table  id="Datoszona" class="table table-bordered" style="width: 1500px;">
                    <thead>
                        <tr>
                            <th class="text-center">Codigo Zona Ventas</th>
                            <th class="text-center">Codigo Asesor</th>
                            <th class="text-center">Vendedor</th>
                            <th class="text-center">Agencia</th>
                            <th class="text-center">Grupo Ventas</th>
                            <th class="text-center">Nombre Grupo Ventas</th>
                            <th class="text-center">Clientes</th>  
                            <th class="text-center">Cartera</th>      
                            <th class="text-center">Portafolio</th>
                            <th class="text-center">Preventa</th>
                            <th class="text-center">Autoventa</th>  
                            <th class="text-center">Consignacion</th>
                            <th class="text-center">Venta Directa</th>      
                            <th class="text-center">Focalizados</th>


                        </tr>        
                    </thead>


                </table> 

            </div>

        </div>
    </div> 

</div>



<div class="modal fade" id="_modalinformation" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Detalle</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="Detalle">
                    <tr>
                        <td>Zonas Ventas</td>
                        <td><?php echo $CountZonas ?></td>
                    </tr>
                    <tr>    
                        <td>Codigo Asesor</td>
                    <td><?php echo $CodAsesor[0]['CodAsesor'] ?></td>
                    </tr>
                    <tr>
                        <td>Acuerdos Linea</td>
                        <td><?php echo $linea['linea'] ?></td>
                    </tr>
                    <tr>
                        <td>Acuerdos Multilinea</td>
                        <td><?php echo $multiliena['multilinea'] ?></td>
                    </tr>
                    <tr>
                        <td>Zonas Inactivas</td>
                       <td><?php echo $zonasInactivas['zonainactivas'] ?></td>
                    </tr>
                    <tr>
                        <td>Barrios</td>
                        <td><?php echo $barrios['barrios'] ?></td>
                    </tr>
                    <tr>
                        <td> Acuerdos Precio Venta</td>
                        <td><?php echo $precioventa['precioventa'] ?></td>
                    </tr>
                    <tr>
                        <td>Bancos</td>
                        <td><?php echo $bancos['bancos'] ?></td>
                    </tr>
                    <tr>
                        <td>Cuentas Bancarias</td>
                        <td><?php echo $cuentasbancarias['cuentasbancarias'] ?></td>
                    </tr>
                    <tr>
                        <td>Codigo Ciuu</td>
                        <td><?php echo $codigociiu['ciiu'] ?></td>
                    </tr>
                    
                    
                </table>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->