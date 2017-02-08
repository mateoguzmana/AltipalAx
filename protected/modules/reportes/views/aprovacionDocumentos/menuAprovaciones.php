<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer salir" id=""  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Menu Aprobaciones <span></span></h2>      
</div>

<!--notas creditos-->
 
<?php if ($_SESSION["AprobarNotas"]==1): ?>
  
    <?php $this->renderPartial('//mensajes/_alertDhNotasCredito');
    $_SESSION["AprobarNotas"] = 0;
    ?>    
    
<script>
jQuery(document).ready(function() {
$('#_alertDhNotasCredito').modal('show');
});
</script>
<?php endif; ?>

<!--descuentos-->

<?php if (Yii::app()->user->hasFlash('errorDescuentos')): ?>
  
    <?php $this->renderPartial('//mensajes/_alertDhDescuentos'); ?>    
    
<script>
jQuery(document).ready(function() {
$('#_alertDhDescuentos').modal('show');
});
</script>
<?php endif; ?>

<!--devoluciones-->

<?php if ($_SESSION["AprobarDevol"]==1): ?>  
 <?php $this->renderPartial('//mensajes/_alertDhDevoluciones');
 $_SESSION["AprobarDevol"]=0;
 ?>    
<script>
jQuery(document).ready(function() {
$('#_alertDhDevoluciones').modal('show');
});
</script>
<?php endif; ?>

<!--transferencia consignacion-->

<?php if ($_SESSION["AprobarTrans"]==1): ?>  
    <?php $this->renderPartial('//mensajes/_alertDhTransfeConsig'); 
    $_SESSION["AprobarTrans"]=0;
    ?>    
<script>
jQuery(document).ready(function() {
$('#_alertDhTransfeConsig').modal('show');
});
</script>
<?php endif; ?>

<!--actividad especial-->

<?php if ($_SESSION["AprobarActiv"]==1): ?>
    <?php $this->renderPartial('//mensajes/_alertDhActividadEspecial');
    $_SESSION["AprobarActiv"]=0;?>    
<script>
jQuery(document).ready(function() {
$('#_alertDhActividadEspecial').modal('show');
});
</script>
<?php endif; ?>
<?php if ($_SESSION["AprobarDes"]==1): ?>  
    <?php $this->renderPartial('//mensajes/_alertDhDescuentos');
    $_SESSION["AprobarDes"]=0;?>
<script>
jQuery(document).ready(function() {
$('#_alertDhDescuentos').modal('show');
});
</script>
<?php endif; ?>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                   <div class="widget-content">
                    <div class="container-fluid">
                    <div class="row text-center"> 
                        <?php $idAdmin = Yii::app()->user->getState('_Id');
                        $conceptosAsignados = AprovacionDocumentos::model()->conceptosAdministradorNotasCredito($idAdmin);
                        ?> 
                        <?php if(!empty($conceptosAsignados)){ ?>
                        <div class="col-md-6 aprobarnotascreditoAction">
                            <a  href="index.php?r=reportes/AprovacionDocumentos/AprobarNotasCredito">
                                <i class="fa fa-credit-card fa-5x"></i>
                                <br/>
                                <span class="text-primary">NOTAS CREDITO</span>
                            </a>
                        </div>
                        <?php }else{ ?>
                        <div class="col-md-6 aprobarnotascreditoAction">
                            <a  href="javascript:ConceptosAsignados()">
                                <i class="fa fa-credit-card fa-5x"></i>
                                <br/>
                                <span class="text-primary">NOTAS CREDITO</span>
                            </a>
                        </div>                        
                        <?php } ?>                        
                        <div class="col-md-6 descuentosAction">
                            <a  href="index.php?r=reportes/AprovacionDocumentos/Descuentos">
                                <i class="fa fa-exchange fa-5x"></i>
                                <br/>                             
                                <span class="text-primary">DESCUENTOS</span>
                            </a>
                        </div>
                        <div class="col-md-6 aprobardevolucionesAction">
                            <a  href="index.php?r=reportes/AprovacionDocumentos/AprobarDevoluciones">
                                <i class="fa fa-refresh fa-5x"></i>
                                <br/>   
                                <span class="text-primary">DEVOLUCIONES</span>
                            </a>
                        </div>
                        <div class="col-md-6 aprobartransconsignacionAction">
                            <a  href="index.php?r=reportes/AprovacionDocumentos/AprobarTransConsignacion">
                                <i class="fa fa-external-link-square fa-5x"></i>
                                <br/>   
                                <span class="text-primary">TRANSFERENCIA CONSIGNACIÓN</span>
                            </a>
                        </div>
                           <div class="col-md-6 aprobaractividadespeciaAction">
                            <a  href="index.php?r=reportes/AprovacionDocumentos/AprobarActividadEspecial">
                                <i class="fa fa-calendar fa-5x"></i>
                                <br/>   
                                <span class="text-primary">ACTIVIDAD ESPECIAL</span>
                            </a>
                        </div>
                    </div>
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .col-md-6 a{
        text-decoration: none;
         color: #24D29B
    }    
     .col-md-6 a:hover{
        color: rgba(29, 156, 115, 1);
    }    
    .text-primary{
        font-size: 0.8em;
        text-decoration: none;
        font-weight: 100;
        color: black;
        letter-spacing: 1px;
    }
    .col-md-6{
        margin-top: 25px;
    }
</style>
<?php $this->renderPartial('//mensajes/_alerta'); ?>