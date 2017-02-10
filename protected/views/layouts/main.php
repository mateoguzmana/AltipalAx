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
        <link href="css/bootstrap-select.css" rel="stylesheet">

        <link rel="stylesheet" href="css/jquery.tagsinput.css" />
        <link rel="stylesheet" href="css/colorpicker.css" />
        <link rel="stylesheet" href="css/dropzone.css" />
        <link rel="stylesheet" href="css/tinyscrollbar.css" />

        <link rel="stylesheet" href="css/bootstrap-table.css" />

        <!--se estaba usanado este jquey pero se pasa a la version 11-->
        <script src="js/jquery-1.10.2.min.js"></script> 
        <!--<script src="js/jquery-1.11.3.min.js"></script>-->
        <script src="js/jquery.numberFormat.js"></script> 
        <script src="js/jquery.dataTables.yadcf.js"></script> 
        <script src="js/jquery.dataTables.columnFilter.js"></script> 
        <script src="js/FixedColumns.js"></script>

<!--<script src="https://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>-->

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnS1Z91KOQBmgrSStFLEDbw-IWa-yA6wQ" type="text/javascript"></script>
        <script src="assets/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body data-ruta='<?php echo Yii::app()->request->baseUrl; ?>'>

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
                    <br>
                    <ul class="nav nav-pills nav-stacked nav-bracket" style="font-weight: 300">
                        <li class=""><a href="index.php?r=site/inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>        

                        <?php
                        if (isset(Yii::app()->user->_idPerfil)) {
                            $idPerfil = Yii::app()->user->_idPerfil;
                            $modulos = Consultas::model()->getMenuModulos($idPerfil);

                            foreach ($modulos as $clave => $itemModulos) {
                                ?>
                                <li style=""><a href="index.php?r=<?php echo $itemModulos['UrlPredeterminada']; ?>"><i class="fa fa-circle-o"></i>  <span><?php
                                            if ($itemModulos['Descripcion'] == "ADMINISTRACION_FOCALIZADOS") {
                                                $itemModulos['Descripcion'] = "ADMIN FOCALIZADOS";
                                            }
                                            echo $itemModulos['Descripcion'];
                                            ?></span></a></li>
                                <?php
                            }
                        }
                        ?> 
                        <?php
                        $cedula = Yii::app()->getUser()->getState('_cedula');
                        if ($cedula == '11200') {
                            ?>
                            <li class=""><a href="index.php?r=Logs/index"><i class="fa fa-circle-o"></i> <span>Logs</span></a></li>    
                            <li class=""><a href="index.php?r=site/ControlVersion"><i class="fa fa-circle-o"></i> <span>Control Version</span></a></li>
                            <li class=""><a href="index.php?r=site/PermisosPaginWeb"><i class="fa fa-circle-o"></i> <span>Permisos Pagina Web</span></a></li>
                            <li class=""><a href="http://altipal.datosmovil.info/ScriptPendientesTransmitir.php" target="_blank"><i class="fa fa-circle-o"></i> <span>Pendientes Por Transmitir</span></a></li>
                        <?php } ?>    

                    </ul>
                </div><!-- leftpanelinner -->
            </div><!-- leftpanel -->
            <div class="mainpanel" >
                <div class="headerbar">
                    <a class="menutoggle"><i class="fa fa-bars"></i></a>
                    <div class="header-right">
                        <ul class="headermenu" >
                            <li style="margin-top: 2px; border: none">
                                <button type="button" style="margin-top: 1px; height: 100%; font-weight: 100; font-size: 1.1em;letter-spacing: 1px; text-transform: uppercase" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <?php
                                    if (!Yii::app()->user->isGuest) {
                                        print(Yii::app()->user->_nombres . " " . Yii::app()->user->_apellidos);
                                    }
                                    ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">               
                                    <li><a href="index.php?r=site/logout"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- header-right -->
                </div><!-- headerbar -->
                <?php echo $content; ?>
            </div><!-- mainpanel -->
            <style>
                ul li{
                    text-transform: uppercase;
                    font-size: 0.8em;
                }
                .leftpanelinner ul li a:hover{
                    background-color: #24D29B; 
                    color: white;
                }
                .leftpanelinner ul li a:focus{
                    background-color: #24D29B; 
                    color: white;
                }
            </style>
        </section>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/jquery-ui-1.10.3.min.js"></script>
        <!--<script src="js/jquery-ui-1.11.3.min.js"></script>-->
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

    <script src="js/jquery.tinyscrollbar.js"></script>
    <script src="js/highcharts.js"></script>
    <script src="js/exporting.js"></script>
    <script src="js/highcharts-3d.js"></script>

    <script src="js/jquery.prettyPhoto.js"></script>

    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-es-AR.js"></script>

    <script src="js/funciones.js"></script>
    <script src="js/custom.js"></script>
    <!--  <script src="js/jsnumberFormat/jquery-1.6.1.min.js"></script>
      <script src="js/jsnumberFormat/jquery.numberformatter-1.2.3.min.js"></script>
      <script src="js/jsnumberFormat/jshashtable-2.1.js"></script>-->
    <script src="js/bootstrap-select.js"></script>
    <script>
        jQuery(document).ready(function () {
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
