<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$session = new CHttpSession;
$session->open();

if ($session['AgenciaGrupoUsuario']) {
    $datos = $session['AgenciaGrupoUsuario'];
} else {
    $datos = array();
}
?>


<div id="accordion" class="panel-group">

    <?php
    $cont = 0;
    $contpanel = 0;
    ?>
    <?php foreach ($agencias as $itemAgencias) {
        $contpanel++; ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">

                    <a href="#<?php echo $itemAgencias['CodAgencia'] ?>" data-parent="#<?php echo $itemAgencias['CodAgencia'] ?>" data-toggle="collapse" class="collapsed">
                        <img src="images/map.png" style="width: 25px;"/>  <?php echo $itemAgencias['Nombre']; ?>
                        <small class="text-right text-primary">Asignar grupo de ventas  <span class="glyphicon glyphicon-chevron-down text-primary"></span> </small>

                    </a>
                </h4>
            </div>
            <div class="panel-collapse collapse" id="<?php echo $itemAgencias['CodAgencia'] ?>" style="height: 0px;">
                <div class="panel-body" id="pa" data-id="<?php echo $contpanel ?>">
                    <?php
                    $grupoventas = AdministarUsuarios::model()->getGrupoVentasAgencia($itemAgencias['CodAgencia']);

                    $cont++;
                    ?>
                    <div class="row">
                        <div class="ckbox ckbox-primary">
                            <input type="checkbox" id="<?php echo $cont ?>" class="selecciona">
                            <label for="<?php echo $cont ?>">Todos</label>
                        </div>
                    </div>
                    <div class="row">   
                        <?php foreach ($grupoventas as $itemGrupos) { ?>    

                            <?php
                            $check = FALSE;

                            foreach ($datos as $itemSeleccioando) {
                                $agencia = $itemSeleccioando['agencia'];
                                $grupoVentasItem = $itemSeleccioando['grupoVentas'];
                                if ($itemAgencias['CodAgencia'] == $agencia && $itemGrupos['CodigoGrupoVentas'] == $grupoVentasItem) {
                                    $check = TRUE;
                                }
                            }
                            ?>     
                            <div class="ckbox ckbox-primary col-sm-6">

                                <input 
                                <?php
                                if ($check) {
                                    echo "checked='checked'";
                                }
                                ?>
                                    type="checkbox" 
                                    value="" 
                                    class="ckboxAgencia<?php echo $cont ?> chekcGuardar" 
                                    id="checkbox<?php echo $itemGrupos['CodigoGrupoVentas']; ?>-<?php echo $cont ?>"
                                    data-agencia="<?php echo $itemAgencias['CodAgencia']; ?>"                            
                                    data-grupo-ventas="<?php echo $itemGrupos['CodigoGrupoVentas']; ?>"
                                    />
                                <label for="checkbox<?php echo $itemGrupos['CodigoGrupoVentas']; ?>-<?php echo $cont ?>"><?php echo $itemGrupos['CodigoGrupoVentas']; ?>--<?php echo $itemGrupos['NombreGrupoVentas']; ?></label>
                      </div>
    <?php }; ?>   
                    </div>
                </div>
            </div>
        </div>
<?php }; ?> 
</div>