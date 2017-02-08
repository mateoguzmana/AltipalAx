<table class="table table-email">
    <tbody>

        <?php
        if ($chequesAldia) {
            $numreodelCheque = "";
            /* echo '<pre>';
              print_r($chequesAldia); */
            foreach ($chequesAldia as $itemCheque) {
                if($numreodelCheque!= $itemCheque['NroCheque']) {
                    ?>
                    <tr>
                        <td class="itemFacturasRecaudos" style="width: 8% !important;" >
                            
                            <input class="agregarChequeConsignacion" type="checkbox" id = "agregarCheque" 
                                data-numero="<?php echo $itemCheque['NroCheque']; ?>"                               
                                data-CodigoBanco="<?php echo $itemCheque['CodBanco']; ?>"                                     
                                data-Cuenta="<?php echo $itemCheque['CuentaCheque']; ?>"
                                data-Fecha="<?php echo $itemCheque['Fecha']; ?>"
                                data-Girado="<?php echo $itemCheque['Girado']; ?>"
                                data-Valor="<?php echo $itemCheque['ValorTotal']; ?>"
                                data-Otro="<?php echo $itemCheque['Otro']; ?>"  >
                        </td>                                 
                        <td class="itemFacturasRecaudos"  
                            data-numero="<?php echo $itemCheque['NroCheque']; ?> "                               
                            data-CodigoBanco="<?php echo $itemCheque['CodBanco']; ?>"                                     
                            data-Cuenta="<?php echo $itemCheque['CuentaCheque']; ?>"
                            data-Fecha="<?php echo $itemCheque['Fecha']; ?>"
                            data-Girado="<?php echo $itemCheque['Girado']; ?>"
                            data-Valor="<?php echo $itemCheque['ValorTotal']; ?>"
                            data-Otro="<?php echo $itemCheque['Otro']; ?>" 

                            style="padding: 15px;">
                            <div class="media">                                        
                                <div class="media-body">
                                    <table style="width: 480px;">
                                        <tr>
                                            <td><strong>Numero #:</strong> <?php echo $itemCheque['NroCheque'] ?></td>                                                  
                                        </tr>

                                        <tr>
                                            <td><strong>Banco:</strong>  <?php
                                                $bancoName = ConsignacionVendedor::model()->ConsultarBancosCheques($itemCheque['CodBanco']);
                                                echo $itemCheque['CodBanco'] . " - " . $bancoName['Nombre'];
                                                ?></td>
                                            <td><strong>Cuenta:</strong> <?php echo $itemCheque['CuentaCheque'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Valor:</strong>$ <?php echo number_format(floor($itemCheque['ValorTotal']), '0', ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                $numreodelCheque = $itemCheque['NroCheque'];
           }
        }
        ?>   

    </tbody>
</table>

