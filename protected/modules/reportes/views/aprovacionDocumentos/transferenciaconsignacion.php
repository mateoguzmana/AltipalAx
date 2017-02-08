<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        Transferencia Consignación <span></span></h2>
</div>



<div class="contentpanel">

    <div class="panel panel-default">


        <div class="panel-body" style="max-height: 550px; min-height: 100%">
            <div class="widget widget-blue">
                <div class="widget-content">


                    <div class="row">

                        <div class="mb30"></div>

                        <div class="col-md-12">

                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table table-hover table-striped mb30" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <span class="glyphicon glyphicon-import"></span>
                                                <?php $acum=0; ?>
                                                <?php foreach ($totaltansferenia as $itemtotaltransferencia){ $acum=$acum+$itemtotaltransferencia['transferencias'];} ?>
                                                TOTAL TRANSFERENCIAS (<?php echo $acum;?>)
                                            </th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                    <?php foreach ($transferencias as $itemTransferencia): ?>
                                        <tr>
                                            <td class="text-right" style="width: 40%;">
                                                <img src="images/transferenciadahsboar.png" style="width: 60px; margin: 0px 30px;  height: 60px;" />
                                            </td>
                                            <td>
                                                <span class="text-primary"><b><?php echo $itemtotaltransferencia['transferencias']?></b> </span><br/>
                                                <span class="text-danger">  Agencia: <?php echo $itemTransferencia['NombreAgencia'];  ?> </span><br/>
                                                <span class="text-danger">Grupo ventas: <?php echo $itemTransferencia['NombreGrupoVentas'];  ?> </span>
                                            </td>
                                            <td>
                                               <a href="index.php?r=reportes/AprovacionDocumentos/AjaxDetalleTransferenciaConsignacion&agencia=<?php echo $itemTransferencia['CodAgencia'];?>&grupoVentas=<?php echo $itemTransferencia['CodigoGrupoVentas'];?>">
                                                <span class="fa fa-edit text-danger text-left" style="font-size: 35px;"></span>
                                                </a>
                                            </td>

                                        </tr>

                                      <?php endforeach;?>
                                    </tbody>


                                </table>
                            </div><!-- table-responsive -->

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


