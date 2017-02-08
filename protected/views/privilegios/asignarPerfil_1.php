  <script>
        $(document).ready(function() {
        $('#tablaCliente').dataTable();
        } );
  </script>
    
<h1>Asignar perfil</h1>
     <div class="widget widget-blue">
      <div class="widget-title">
          
        <h3><i class="icon-table"></i> Asignar perfil</h3>
      </div>
      <div class="widget-content">
        <div class="table-responsive">
        <table class="table table-bordered table-hover datatable" id="tablaCliente">
          <thead>
            <tr>
              <th></th>
              <th>Cédula</th>
              <th>Nombre</th>            
              <th>                     
              </th>              
            </tr>
          </thead>
          <tbody>
              <?php
              $con=0;
              foreach ($model as $m)
              {
                  $con++;
              ?>
            <tr>
              <td><?php echo $con; ?></td>
              <td><?php echo $m['Cedula']; ?></td>
              <td><?php echo $m['Usuario']; ?></td>
              <td><?php //echo $m['IdPerfil']; 
                 
              ?>
                  <div class="row">
                      <div class="col-sm-8">
                          <select class="form-control selectActualizaPerfil" data-usuario="<?php echo $m['Cedula']; ?>">
                            <?php                    
                             if(!empty($perfiles)){
                                 foreach ($perfiles as $item){
                                ?> 
                                <option  <?php if(!empty($m['IdPerfil'])){if($m['IdPerfil']==$item['IdPerfil'])echo "selected";} ?>  value="<?php echo $item['IdPerfil'];?>"> <?php echo $item['Descripcion'];?></option>
                                <?php     
                                 }
                             }                  
                            ?>
                            </select>
                      </div>
                       <div class="col-sm-4">
                           <div class="actualizar-perfil" id="actualizar-perfil-<?php echo $m['Cedula'];?>">
                               
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

