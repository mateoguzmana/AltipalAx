<div class="pageheader">
  <h2> <a style="text-decoration: none;" class="salirReporestResumenDia"> <img src="images/home.png" class="cursorpointer" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> </a> transmisión de documentos<span></span></h2>
</div>
<input type="hidden" value="<?php echo $zonaVentas ?>" id="ZonaVentas">
<div class="contentpanel">
  <div class="panel-heading">
    <div class="widget widget-blue">
      <div class="widget-content">
        <div class="row">
          <div class="col-md-4 col-md-offset-2 text-center">
             <div  aling="center">
                  <label>Zona de ventas:</label><br>
                <input style="height: 30px; text-align: center;" type="text" id="zonaVentas" value = "<?php echo $zonaVentas ?>" disabled/><br>
            </div>
            <div class="form-group">

              <label>Fecha</label>
              <div  aling="center">
                <input style="height: 36px;" type="text"  class="form-control fechareport" id="fechainicial1" value = "<?php echo date('Y-m-d') ?>"/>
               
            </div>
            
            <div class="form-group">
              <label>Fecha FInal</label>
              <div  aling="center">
                <input style="height: 36px;" type="text"   class="form-control fechareport" id="fechafinal1" value = "<?php echo date('Y-m-d') ?>"/>
               
                <!--<span class="text-primary  cursorpointer">Aceptar</span>  </div>-->
            </div>
               <a href="javascript:cargarInformacion()"> <span class="cursorpointer"> <img src="images/aceptar.png" style="width: 55px"/><br/></span> </a>
          </div>
        </div>
        
      </div>
      
     
         
         
    </div>
    
    
  </div>
  
   <div class="row">
        
        <div id="informacion"></div>
        
         </div>
</div>
