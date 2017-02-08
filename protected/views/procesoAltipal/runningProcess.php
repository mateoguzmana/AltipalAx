<style>
    .table-responsive {
        width: 100%;
        max-width: 90%;
        margin-bottom: 20px;
    }
</style>
<body>
    <div class="pageheader">
        <h2>
            <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
            EJECUTAR PROCESO DE ACTUALIZACION</h2>      
    </div>
    <title>PROCESO DE ACTUALIZACION</title>
    <!--<div class="panel panel-default" style="padding: 10px;">        
        <div class="panel-footer">
            <small>Altipal - <?php echo date("Y"); ?></small>
        </div>
    </div>-->
</body>
<script>
    $(document).ready(function () {
        LoadRunningProcess2();
    });
    function LoadRunningProcess2() {
        /*$('#_alertaCargando .text-modal-body').html("Consultando servicio en ejecucion..!");
         $('#_alertaCargando').modal('show');*/
        $.ajax({
            url: 'index.php?r=ProcesoAltipal/AjaxQueryProcessExecution',
            type: 'post',
            data: {
            },
            success: function (response) {
                //$('#_alertaCargando').modal('hide');
                //alert(JSON.stringify(response));
                var ProcessJson = JSON.parse(response);
                if (ProcessJson['Cont'] == 0) {
                    if (ProcessJson['Status'] == 0) {
                        $('#_alertagif .text-modal-body').html("El servicio que se esta ejecutando es: <b>" + ProcessJson['Name'] + ".</b><br> Tiempo transcurrido: <b>" + ProcessJson['Time'] + "</b>");
                        $('#_alertagif').modal('show');
                        /*$('#_alerta .text-modal-body').html("El servicio que se esta ejecutando es: <b>" + ProcessJson['Name'] + "</b> Desde la fecha: <b>" + ProcessJson['Date'] + "</b> y Hora: <b>" + ProcessJson['Time'] + "</b>");
                         $('#_alerta').modal('show');*/
                    }
                    else if (ProcessJson['Status'] == null) {
                        window.open("index.php?r=ProcesoAltipal/Menu", '_self');
                    }
                }
                else {
                    $('#_alertagif .text-modal-body').html("El ultimo proceso no termino correctamente!!; Por favor comuniquese con Activity!!!");
                    //$('#_alerta .text-modal-body').html("El ultimo proceso no termino correctamente!!; El servicio que se ejecuto fue: <b>" + ProcessJson['Name'] + "</b> Desde la fecha: <b>" + ProcessJson['Date'] + "</b> y Hora: <b>" + ProcessJson['Time'] + "</b>");
                    $('#_alertagif').modal('show');
                }
            }
        });
        setTimeout("LoadRunningProcess2()", 45000);
    }
</script>
<?php $this->renderPartial('//mensajes/_alertagif'); ?>