


<div class="pageheader">
    <h2><i class="fa fa-truck"></i> Clientes<span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            
                <a class="minimize maximize" href="#">+</a>
            </div>
            <h4 class="panel-title">Clientes</h4>           
            <h5> Ruta: <span class="text-primary"><?php echo $diaRuta; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 No. Clientes Ruta: <span class="text-primary"><?php echo count($clientesRuta); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 No. Clientes Extraruta: <span class="text-primary"><?php echo count($clientesExtraruta); ?></span>
            </h5>

        </div>
        <div class="panel-body" style="min-height: 450px;">


            <div class="widget widget-blue">                

                <div class="widget-content">                    
                     <form class="form-inline" method="post" action="">   
                         
                    <div class="mb30"></div>
                    
                    <div class="row">
                        
                       
                        
                        <div class="col-sm-10 col-sm-offset-1">
                            
                                
                       
                             <div class="table-responsive">
            <table class="table table-hover" id="table1">
              <thead>
                 <tr>                   
                    <th > <h5> Clientes:</h5>  </th>                                 
                 </tr>
              </thead>
              <tbody>
                    <?php
                    $cont=1;
                       foreach ($clientesRuta as $itemClientes) {
                    ?>
                 <tr class="odd gradeX seleccionarCliente" data-cuenta-cliente=" <?php echo $itemClientes['CuentaCliente'];  ?>" data-zona-ventas="<?php echo $zonaVentas;?>">
                   
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
                           <?php echo $cont++.' - '.$itemClientes['NombreBusqueda'];  ?> 
                             </h3>
                        
                        </div>
                            
                            <div class="col-sm-12">
                                <span>
                                    <b>                                      
                                    <?php echo $itemClientes['Identificacion'];  ?> -
                                    </b>
                                    <?php echo $itemClientes['NombreBusqueda'];  ?> 
                                 </span>
                            </div>
                            
                            <div class="col-sm-12">
                                 <span>
                                      <b>Dirección: </b> 
                                    <?php echo $itemClientes['DireccionEntrega'];  ?> 
                                 </span>
                            </div>
                            
                             <div class="col-sm-12">
                                 <span>
                                      <b>Teléfono: </b> 
                                     <?php echo $itemClientes['Telefono'];  ?> 
                                 </span>
                            </div>
                           
                            
                               <div class="col-sm-12">
                                 <span>
                                      <b>Hora: </b> 
                                     <?php echo $itemClientes['Posicion'];  ?> 
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
          </div><!-- table-responsive -->
        
                            
                        </div>
                    </div>
                    
                     </form>  
                    
                </div>
            </div>



        </div>
    </div>      



</div>




<script>

 $(".seleccionarCliente").click(function(){
    var cuentaCliente=$(this).attr('data-cuenta-cliente');  
    var zonaVentas=$(this).attr('data-zona-ventas');
    
    
    var cuentaCliente=cuentaCliente.trim();
    var zonaVentas=zonaVentas.trim();
    
    window.location.href="index.php?r=Pedido/menuClientes&cliente="+cuentaCliente+"&zonaVentas="+zonaVentas;
    
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