<?php

class WebappController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {

        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        $zonaVentas = $_GET["zonaventas"];

        $this->layout = "mainapp";
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.min.js', CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/DT_bootstrap.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.columnFilter.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/rutero.js', CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/App/transmisiondocumentos.js', CClientScript::POS_END
        );

        $this->render('index', array('zonaVentas' => $zonaVentas));
    }

    public function actionCargarinformacion() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();

        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];


        //$fecha = '2016-04-01';
        //$fechafinal = '2016-04-12';
        //echo '<script> alert("entro al controlador");</script>';

        $detallePedido = Transmisiondocumentos::model()->getDatosPedido($fecha, $fechafinal, $zonaVentas);
        $detallePedidoPendiente = Transmisiondocumentos::model()->getDatosPedidoPendiente($fecha, $fechafinal, $zonaVentas);
        $detalleReciboCaja = Transmisiondocumentos::model()->getDatosRecibo($fecha, $fechafinal, $zonaVentas);
        $detalleDevoluciones = Transmisiondocumentos::model()->getDatosDevoluciones($fecha, $fechafinal, $zonaVentas);
        $detallenotas = Transmisiondocumentos::model()->getDatosNotas($fecha, $fechafinal, $zonaVentas);
        $detalleClienteNuevo = Transmisiondocumentos::model()->getDatosClientesNuevos($fecha, $fechafinal, $zonaVentas);
        $detalleNoVenta = Transmisiondocumentos::model()->getDatosNoVisitas($fecha, $fechafinal, $zonaVentas);
        $detalleConsignacion = Transmisiondocumentos::model()->getDatosConsignacion($fecha, $fechafinal, $zonaVentas);
        $detalleNoRecaudo = Transmisiondocumentos::model()->getDatosNoRecaudos($fecha, $fechafinal, $zonaVentas);


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/App/transmisiondocumentos.js', CClientScript::POS_END
        );

        $this->renderPartial('reporte', array('detallepedido' => $detallePedido, 'detallePedidoPendiente' => $detallePedidoPendiente, 'detalleReciboCaja' => $detalleReciboCaja, 'detalleDevoluciones' => $detalleDevoluciones, 'detallenotas' => $detallenotas, 'detalleClienteNuevo' => $detalleClienteNuevo, 'detalleNoVenta' => $detalleNoVenta, 'detalleConsignacion' => $detalleConsignacion, 'detalleNoRecaudo' => $detalleNoRecaudo));
    }

    public function actionCargarRecibosCaja() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleRecibocaja = Transmisiondocumentos::model()->getDatosReciboCaja($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosReciboCaja').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 10px;
                -moz-border-radius: 1px;
                -webkit-border-radius: 1px;
                border-radius: 1px;
                margin-left: 1px;
                width: 100%;
                height: 100%;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosReciboCaja" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre cliente</th>
                                    <th class="text-left">Fecha</th>
                                    <!-- <th class="text-left">Valor pedido</th> -->
                                    <th class="text-left">Hora</th>
                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleRecibocaja as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['Fecha']; ?></td>
                                     <!--   <td><?php echo "$" . number_format($row['ValorPedido'], 0, ',', '.'); ?></td> -->
                                        <td><?php echo $row['Hora']; ?></td>             

                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargardetallepedido() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detallePedido = Transmisiondocumentos::model()->getDatosPedidoDetallado($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosPedido').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosPedido" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre cliente</th>
                                    <th class="text-left">Hora</th>
                                    <th class="text-left">Valor pedido</th>
                                    <th class="text-left">Forma de pago</th>
                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detallePedido as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['HoraDigitado']; ?></td>
                                        <td><?php echo "$" . number_format($row['ValorPedido'], 0, ',', '.'); ?></td>
                                        <td><?php echo $row['FormaPago']; ?></td>             

                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargardetallepedidopendiente() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detallesPedidoPendiente = Transmisiondocumentos::model()->getDatosDetallePedidoPendiente($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosPedido').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosPedido" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre cliente</th>
                                    <th class="text-left">Hora</th>
                                    <th class="text-left">Valor pedido</th>
                                    <th class="text-left">Forma de pago</th>
                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detallesPedidoPendiente as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['HoraDigitado']; ?></td>
                                        <td><?php echo "$" . number_format($row['ValorPedido'], 0, ',', '.'); ?></td>
                                        <td><?php echo $row['FormaPago']; ?></td>             

                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarDevoluciones() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleDevoluciones = Transmisiondocumentos::model()->getDatosDevolucion($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosDevolucion').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosDevolucion" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre cliente</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Hora</th>
                                    <th class="text-left">Valor devolucion</th>
                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleDevoluciones as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['FechaDevolucion']; ?></td>                                       
                                        <td><?php echo $row['HoraInicio']; ?></td>   
                                        <td><?php echo "$" . number_format($row['ValorDevolucion'], 0, ',', '.'); ?></td>

                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarNotacredito() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleNotacredito = Transmisiondocumentos::model()->getDatosNotacredito($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosNotacredito').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosNotacredito" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre cliente</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Hora</th>
                                    <th class="text-left">Valor</th>
                                    <th class="text-left">Factura</th>
                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleNotacredito as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['Fecha']; ?></td>              
                                        <td><?php echo $row['Hora']; ?></td>     
                                        <td><?php echo $row['Valor']; ?></td>              
                                        <td><?php echo $row['Factura']; ?></td>   

                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarClienteNuevo() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleClienteNuevo = Transmisiondocumentos::model()->getDatosClienteNuevo($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosClientenuevo').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosClientenuevo" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Cuenta Cliente</th>
                                    <th class="text-left">Nombre</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Hora</th>

                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleNotacredito as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['CuentaCliente']; ?></td>
                                        <td><?php echo $row['Nombre']; ?></td>              
                                        <td><?php echo $row['FechaRegistro']; ?></td>     
                                        <td><?php echo $row['HoraRegistro']; ?></td>              


                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarConsigvendedor() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleConsigvendedor = Transmisiondocumentos::model()->getDatosConsigvendedor($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosConsigvendedor').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosConsigvendedor" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre asesor</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Banco</th>
                                    <th class="text-left">Valor efectivo</th>
                                    <th class="text-left">Valor cheque</th>

                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleConsigvendedor as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['Nombre']; ?></td>
                                        <td><?php echo $row['FechaConsignacion']; ?></td>              
                                        <td><?php echo $row['Banco']; ?></td>     
                                        <td><?php echo $row['ValorConsignadoEfectivo']; ?></td>        
                                        <td><?php echo $row['ValorConsignadoCheque']; ?></td> 


                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarNovisita() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleNovisita = Transmisiondocumentos::model()->getDatosNovisita($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosNovisita').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosNovisita" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Hora </th>
                                    <th class="text-left">Motivo</th>

                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleNovisita as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['FechaNoVenta']; ?></td>              
                                        <td><?php echo $row['HoraNoVenta']; ?></td>     
                                        <td><?php echo $row['Nombre']; ?></td>        
                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionCargarNorecaudado() {
        $this->layout = "mainapp";
        $session = new CHttpSession;
        $session->open();
        $fecha = $_POST["fecha"];
        $fechafinal = $_POST["fechafinal"];
        $zonaVentas = $_POST["zonaVentas"];

        $detalleNorecaudado = Transmisiondocumentos::model()->getDatosNorecaudado($fecha, $fechafinal, $zonaVentas);
        ?>
        <script>
            jQuery(document).ready(function () {

                jQuery('#DatosNorecaudado').dataTable();
            });

        </script>
        <style>
            td
            { font-size:10px}
            .table.dataTable th, .table.dataTable td {
                font-size: 13px;
                min-width: 60px;
            }
            .dataTables_filter input {
                border: 1px solid #ddd;
                padding: 3px;
                font-zize: 13px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 1px;
                margin-left: 5px;
                width: auto;
                height: 32px;
            }
        </style>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table  id="DatosNorecaudado" class="table table-bordered dataTable">
                            <thead>
                                <tr >
                                    <th class="text-left">Nombre</th>
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Hora </th>
                                    <th class="text-left">Fecha Proxima Visita</th>

                                </tr>     
                            </thead>
                            <tbody>
        <?php foreach ($detalleNorecaudado as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['NombreCliente']; ?></td>
                                        <td><?php echo $row['Fecha']; ?></td>              
                                        <td><?php echo $row['FechaProximaVisita']; ?></td>     
                                        <td><?php echo $row['Hora']; ?></td>        
                                    </tr>
            <?php
        }
        ?>   

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>

        <?php
    }

    public function actionDetalleRutero() {

        $this->layout = "mainapp";

        $session = new CHttpSession;
        $session->open();
        $session['_zonaVentas'] = $_GET["zonaventas"];



        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.min.js', CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/DT_bootstrap.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/jquery.dataTables.columnFilter.js', CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/rutero.js', CClientScript::POS_END
        );


        $FilaRutero = Transmisiondocumentos::model()->getRutero();
        $this->render('detalle', array('FilaRutero' => $FilaRutero));
    }

    public function actionAjaxJsonDetalleRutero() {

        $this->layout = "mainapp";

        $session = new CHttpSession;
        $session->open();
        $session['_zonaVentas'] = $_GET["zonaventas"];

        $FilaRutero = Transmisiondocumentos::model()->getRutero();

        /*  $this->render('detalle',array('FilaRutero'=>$FilaRutero)); */
        $report = array();
        foreach ($FilaRutero as $row) {



            $json = array(
                'NumeroVisita' => $row['NumeroVisita'],
                'CodFrecuencia' => $row['CodFrecuencia'],
                'R1' => $row['R1'],
                'R2' => $row['R2'],
                'R3' => $row['R3'],
                'R4' => $row['R4'],
                'CuentaCliente' => $row['CuentaCliente'],
                'NombreCliente' => $row['NombreCliente'],
                'DireccionEntrega' => $row['DireccionEntrega'],
                'Telefono' => $row['Telefono'],
                'TelefonoMovil' => $row['TelefonoMovil'],
                'NombreBarrio' => $row['NombreBarrio'],
                'Valorcupo' => $row['Valorcupo']
            );

            array_push($report, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($report),
            "iTotalDisplayRecords" => count($report),
            "aaData" => $report);
        echo json_encode($results);
    }

    public function actionCargarMapaCliente() {
        $session = new CHttpSession;
        $session->open();
        $session['_zonaVentas'] = $_GET["vendedor"];

        $detalleCoordenadas = Transmisiondocumentos::model()->getBuscarCoordenadas($_GET["vendedor"], $_GET["cliente"]);

        $this->layout = "mainmapa";



        $this->render('localizacliente', array("detalleCoordenadas" => $detalleCoordenadas));
    }

}
