 
                <div class="form-group">
                    <label class="col-sm-4 control-label">Código Artículo:</label>
                    <div class="col-sm-6">
                        <input type="text" id="codvariante"  class="form-control" value="<?php echo $arrayDatos['CodVariante'] ?>" readonly="true"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Nombre Artículo:</label>
                    <div class="col-sm-6">
                        <input type="text" id="nombrearticulo"  class="form-control" value="<?php echo $arrayDatos['NombreArticulo'] ?>" readonly="true"/>
                    </div>
                </div>
                
             
                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" id="unidadmedida"  class="form-control" value="<?php echo $arrayDatos['NombreUnidadMedida'] ?>" readonly="true"/>
                    </div>
                </div>
                
                 <input type="hidden" value="<?php echo $arrayDatos['CodigoUnidadMedida'] ?>" id="codunidad">   
               
                <div class="form-group">
                    <label class="col-sm-4 control-label">Lote:</label>
                    <div class="col-sm-6">
                         <input type="text" id="lote"  class="form-control" value="<?php echo $arrayDatos['Lote'] ?>" readonly="true"/>
                    </div>
                     <br>
                     <br>
                     <div class="col-sm-offset-5">
                    <div id="MsgError"></div>
                    </div>
                </div>
                 
                <div class="form-group">
                    <label class="col-sm-4 control-label">Precio Venta:</label>
                    <div class="col-sm-6">
                        <input type="text" id="precioventa"  class="form-control" onkeypress="return FilterInput (event)" value="<?php echo number_format($arrayDatos['PrecioVenta'],'2',',','.') ?>" readonly="true"/>
                    </div>
                </div>
                
                

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo Disponible:</label>
                    <div class="col-sm-6">
                        <input type="number" id="dis"  class="form-control" onkeypress="return FilterInput (event)" value="<?php echo $arrayDatos['dis'] ?>" readonly="true"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidad"  class="form-control" onkeypress="return FilterInput (event)" value="<?php echo $arrayDatos['Cantidad'] ?>"/>
                    </div>
                     <br>
                     <br>
                     <div class="col-sm-offset-5">  
                    <div  id="MsgErrorDis"></div>
                    </div>
                    
                </div>
                  
                    
                
                 <input type="hidden" value="<?php echo $arrayDatos['CodVariante'] ?>" id="variante">
                     

                 <input type="hidden" id="nombrearticulo" value="<?php echo $arrayDatos['NombreArticulo'] ?>">
                     
                 <input type="hidden" id="codarticulo" value="<?php echo $arrayDatos['CodigoArticulo'] ?>">
                 
                  <input type="hidden" id="precioventa" value="<?php echo $arrayDatos['PrecioVenta'] ?>">
                       
                 <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar">Adicionar</button>
            </div> 