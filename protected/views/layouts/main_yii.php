<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/png">

  <title>Altipal S.A</title>

  <link href="css/style.default.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" />
  <link href="css/jquery.datatables.css" rel="stylesheet">
  <link href="css/altipalAx.css" rel="stylesheet">
  
  <link rel="stylesheet" href="css/jquery.tagsinput.css" />
  <link rel="stylesheet" href="css/colorpicker.css" />
  <link rel="stylesheet" href="css/dropzone.css" />
  <link rel="stylesheet" href="css/tinyscrollbar.css" />
  
  


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body data-ruta='<?php echo Yii::app()->request->baseUrl;?>'>

<!-- Preloader -->
<div id="preloader">
    <div id="status"><img alt="" src="images/loaders/loader6.gif"></div>
</div>

<section>
  
  <div class="leftpanel">
    
    <div class="logopanel text-center">
        <h1><img src="images/altipal-logo.png" style="width: 135px;"/></h1>
    </div><!-- logopanel -->
        
    <div class="leftpanelinner">    
      
       <h5 class="sidebartitle">Menu</h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
        <li class=""><a href="index.php?r=site/inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>        
       
        <?php 
        if(isset(Yii::app()->user->_idPerfil )){
            $idPerfil = Yii::app()->user->_idPerfil;         
            $modulos=  Consultas::model()->getMenuModulos($idPerfil);
            
            foreach ($modulos as $clave=>$itemModulos){                                
                ?>
           <li class=""><a href="index.php?r=<?php echo $itemModulos['UrlPredeterminada']; ?>"><i class="fa fa-book"></i>  <span><?php echo $itemModulos['Descripcion']; ?></span></a></li>
           <?php
          }
         }
        ?>        
       
      </ul>
      
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->
  
  <div class="mainpanel">
    
    <div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
      
      <form class="searchform" action="http://themepixels.com/demo/webpage/bracket/index.html" method="post">
        <input type="text" class="form-control" name="keyword" placeholder="Buscar" />
      </form>
      
      
      <div class="header-right">
      	
        <ul class="headermenu">
     
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <?php 
                    if(!Yii::app()->user->isGuest) {                       
                        print(Yii::app()->user->_nombres." ".Yii::app()->user->_apellidos);                        
                    } 
                ?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">               
                <li><a href="index.php?r=site/logout"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>
              </ul>
            </div>
          </li>
         
        </ul>
      
      </div><!-- header-right -->
      
    </div><!-- headerbar -->
    
   <?php echo $content;?>
    
  </div><!-- mainpanel -->
  
  
  
  
</section>


<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/toggles.min.js"></script>

<script src="js/jquery.cookies.js"></script>

<script src="js/flot/flot.min.js"></script>
<script src="js/flot/flot.resize.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/raphael-2.1.0.min.js"></script>


<script src="js/jquery.datatables.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/725b2a2115b/api/fnFilterClear.js"/></script>
<script src="js/chosen.jquery.min.js"></script>


<script src="js/bootstrap-wizard.min.js"></script>
<script src="js/jquery.validate.min.js"></script>

<script src="js/bootstrap-timepicker.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.tinyscrollbar.js"></script>
<script src="js/highcharts.js"></script>
  <script src="js/exporting.js"></script>
  <script src="js/highcharts-3d.js"></script>
  
<script src="js/funciones.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>



<script>
  jQuery(document).ready(function() {
    
    jQuery('#table1').dataTable();
    
  
<?php
$session = new CHttpSession;
$session->open();
$dato = $session['diferencia'];
foreach ($dato as $d) {
    $script.='$( ".' . $d . 'Action" ).remove();';
}
echo $script;
?>
});
    
</script>    

</body>
</html>
