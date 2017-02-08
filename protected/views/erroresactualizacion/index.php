

<div class="contentpanel">


    <div class="panel-body" style="min-height: 1000px;">

        <div class="panel-heading">
            <div align="center">
			 <div class="row">
                        <div class="col-md-3 col-md-offset-2 text-center">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <div  aling="center">
                                    <input style="height: 36px;" type="text"  class="form-control fechareport" id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                                 </div>
                                
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control fechareport"  id='fechafin' value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
						
						<div class="col-md-3 text-center">
                            <div class="form-group">
                                <label></label>
                                <div>
									<input type="button" class="btnbuscar btn btn-primary" style="height: 25px; width: 100px;"  value="Buscar" />
                                </div>
                            </div>
                        </div>
						
                         
                    </div>
                 
            </div>
            <br>
            <br>
		
            <div class="table-responsive" id="tablaerrores">
                <table class="table table-bordered" id="tbllogerror">
                    <thead>
                    <tr style="background-color: #8DB4E2;">
                        <th>
                        Mensaje Activity
                        </th>
                        <th>
                        MensajeServicio
                        </th>
                        <th>
                          Fecha
                        </th>      
						<th>
                          Hora
                        </th>                    
						<th>
                          ServicioSRF
                        </th>            
						<th>
                        Tablas a actualizar
                        </th>                      
						<th>
                          Parametros
                        </th>                   
						<th>
                          Agencia
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($errores as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['MensajeActivity']; ?></td>
                            <td><?php echo $item['MensajeServicio']; ?></td>
                            <td><?php echo $item['Fecha']; ?></td>
                            <td><?php echo $item['Hora']; ?></td>
                            <td><?php echo $item['ServicioSRF']; ?></td>
                            <td><?php echo $item['TablasActualizar']; ?></td>
                            <td><?php echo $item['Parametros']; ?></td>
                            <td><?php echo $item['Agencia']; ?></td>
                           
                        </tr>

                    <?php } ?>
                        </tbody>


                </table>
            </div>
		
        </div>

    </div>


</div>