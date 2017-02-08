

<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Clientes Nuevos <span></span>
    </h2>      
</div>
    
    <div class="contentpanel">
      
       
        
    <?php 
    
      if($casoCliente){
      	
		 //echo $casoCliente;
		  
		  switch ($casoCliente) {
			    case 1:
					//formulario de registro
			        $this->renderPartial('formularios/formCaso1', array(
                                    'datosCliente'=>$datosCliente, 
                                    'identificacionCliente'=>$identificacionCliente,
                                    'departamentosZona'=>$departamentosZona,
                                    'rutaSeleccionada'=>$rutaSeleccionada,
                                    'zonaVentas'=>$zonaVentas
                                    ));
			        break;
			    case 2:
					//El cliente existe esta activo, esta en el mismo grupo de ventas para la misma zona 
			        $this->renderPartial(
                                        'formularios/formCaso2', array(
                                            'datosCliente'=>$datosCliente,
                                            'rutaSeleccionada'=>$rutaSeleccionada,
                                            'departamentosZona'=>$departamentosZona,
                                            'zonaVentas'=>$zonaVentas,                                            
                                    ));
			        break;
			    case 3:
					//Si el cliente exite, esta activo para el mismo grupo y zona de ventas y no se encuebtra enruatado
			         $this->renderPartial('formularios/formCaso3', array(
                                     'datosCliente'=>$datosCliente,
                                     'departamentosZona'=>$departamentosZona,
                                      'rutaSeleccionada'=>$rutaSeleccionada,
                                       'zonaVentas'=>$zonaVentas, 
                                    ));
			        break;
					
				case 4:
					//Si el cliente existe, esta inactivo para el mismo grupo y zona de ventas 
			         $this->renderPartial('formularios/formCaso4', array(
                                     'datosCliente'=>$datosCliente,
                                     'departamentosZona'=>$departamentosZona,
                                     'rutaSeleccionada'=>$rutaSeleccionada,
                                       'zonaVentas'=>$zonaVentas, 
                                     
                                        ));
			        break;
					
				case 5:
					//Si el cliente existe, esta activo para el mismo grupo 
			         $this->renderPartial('formularios/formCaso5', array(
                                     'datosCliente'=>$datosCliente,
                                     'departamentosZona'=>$departamentosZona,
                                     'rutaSeleccionada'=>$rutaSeleccionada,
                                       'zonaVentas'=>$zonaVentas, 
                                        ));
			        break;		
			}
		
		      	
      }
      
    ?>        
      
    </div><!-- contentpanel -->
    

<?php $this->renderPartial('//mensajes/_alertConfirmationClientesRuta');?> 
