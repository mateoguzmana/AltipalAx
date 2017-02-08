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

<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status"><img alt="" src="images/loaders/loader6.gif"></div>
</div>

<section>
  
 
   
  
  <div class="">
    
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
