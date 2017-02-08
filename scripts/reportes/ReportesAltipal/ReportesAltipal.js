
/*
 * se cargan los grupos de ventas por agencia
 */
$('.onchagegrupos').change(function() {

    var agencia = $("#selectchosenagencia").val();

    $.ajax({
        data: {
            'agencia': agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGruposVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $('#selectchosezonaventas2').val('').trigger('chosen:updated');
            $('#selectchosereportes').val('').trigger('chosen:updated');
            $('#TablaReporte').html('');

            $("#grupoventa").html('');
            $("#grupoventa").html(response);
            $("#selectchosegrupventas2").chosen();
        }
    });

});


$('.onchangegrupoventas').change(function() {

    $('#selectchosereportes').val('').trigger('chosen:updated');
    $('#TablaReporte').html('');

});


/*
 * se carga los reportes
 */
$(".CargarReportes").change(function() {

    var Reporte = $("#selectchosereportes").val();
    var agencia = $("#selectchosenagencia").val();
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var grupoventas = $("#selectchosegrupventas2").val();

    if (Reporte == 1) {

        $.ajax({
            url: 'index.php?r=reportes/ReportesAltipal/AjaxTablaReporteHoraVisita',
            type: 'post',
            beforeSend: function() {

            },
            success: function(response) {


                $("#TablaReporte").html(response);

                $('#Datoszona').dataTable({
                    "pagingType": "full_numbers",
                    "bProcessing": true,
                    "sAjaxSource": "index.php?r=reportes/ReportesAltipal/AjaxCargarReporteHoraVisita&agencia=" + agencia + "&fechaini=" + fechaini + "&fechafin=" + fechafin + "&grupoventas=" + grupoventas + "",
                    "aoColumns": [
                        {mData: 'ZonaVentas'},
                        {mData: 'Asesor'},
                        {mData: 'Supervisor'},
                        {mData: 'NoPedido'},
                        {mData: 'ValPedidos'},
                        {mData: 'ClientesNuevos'},
                        {mData: 'HoraIngreso'},
                        {mData: 'Hora1Pedido'},
                        {mData: 'HoraUltPedido'},
                        {mData: 'HoraRutCierre'},
                        {mData: 'ClientesVisitados'},
                        {mData: 'ClientesConCompra'},
                        {mData: 'ClientesSinCompras'},
                        {mData: 'CelAsesorEmpresarial'},
                        {mData: 'CelAsesorPersonal'},
                        {mData: 'CelSupervisor'}



                    ]
                });

            }
        });

    }


    if (Reporte == 2) {


        $.ajax({
            url: 'index.php?r=reportes/ReportesAltipal/AjaxTablaPedidosActivityAX',
            type: 'post',
            beforeSend: function() {

            },
            success: function(response) {


                $("#TablaReporte").html(response);

                $('#PedidosActivityAX').dataTable({
                    "pagingType": "full_numbers",
                    "bProcessing": true,
                    "sAjaxSource": "index.php?r=reportes/ReportesAltipal/AjaxCargarReportePedidosActivityAx&agencia=" + agencia + "&fechaini=" + fechaini + "&fechafin=" + fechafin + "&grupoventas=" + grupoventas + "",
                    "aoColumns": [
                        {mData: 'Agencia'},
                        {mData: 'GrupoVentas'},
                        {mData: 'ZonaVentas'},
                        {mData: 'NombreAsesor'},
                        {mData: 'PedidosActivity'},
                        {mData: 'PedidoAX'},
                        {mData: 'CantClienteRuta'},
                        {mData: 'PedidosExtraRuta'},
                        {mData: 'ClientesNuevos'},
                        {mData: 'verDettaleZona'}

                    ]
                });

            }
        });

    }


});



function DetalleZona(agencia, zona, fechaini, fechafin) {

    $.ajax({
        url: 'index.php?r=reportes/ReportesAltipal/AjaxTablaDetallePedidoZonaActivityAx',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#_modalinformationPedidosActivityAX").modal('show');
            $("#TablaDetalleReporte").html(response);
             
            $("#idagencia").val(agencia);
            $("#idzona").val(zona);
            $("#fechaini").val(fechaini);
            $("#fechafin").val(fechafin);


            $('#DetallePedidosZonaActivityAX').dataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=reportes/ReportesAltipal/AjaxCargarDetallePedidosZonaActivityAx&zona=" + zona + "&agencia=" + agencia + "&fechaini=" + fechaini + "&fechafin=" + fechafin + "",
                "aoColumns": [
                    {mData: 'ZonaVentas'},
                    {mData: 'NombreAsesor'},
                    {mData: 'IdPedidosActivity'},
                    {mData: 'IdPedidoAX'},
                    {mData: 'PedidosExtraRuta'},
                    {mData: 'PedidosExtraRuta'},
                    {mData: 'Hora'},
                    {mData: 'Fecha'},
                    {mData: 'Canal'},
                    {mData: 'Pedientes'},
                ]
            });

        }
    });


}

function DetallePendientes(agencia, pedido) {

    $.ajax({
        url: 'index.php?r=reportes/ReportesAltipal/AjaxTablaDetallePedidoDescripcionActivityAx',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#_modalinformationPedidosDescripcionActivityAX").css("z-index", "15000");
            $("#_modalinformationPedidosDescripcionActivityAX").modal('show');
            $("#TablaDescripcionDetalleReporte").html(response);
            
                 $("#idagencia").val(agencia);
                 $("#idpedido").val(pedido);
          
          
            $('#DescripcionDetallePedidosActivityAX').dataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=reportes/ReportesAltipal/AjaxCargarDetallePedidosDescripcionActivityAx&pedido=" + pedido + "&agencia=" + agencia + "",
                "aoColumns": [
                    {mData: 'cont'},
                    {mData: 'IdPedido'},
                    {mData: 'IdAx'},
                    {mData: 'CuentaCliente'},
                    {mData: 'NombreCliente'},
                    {mData: 'CodArticulo'},
                    {mData: 'CodVariante'},
                    {mData: 'Descripcion'},
                    {mData: 'Cantidad'},
                    {mData: 'CanirdadPedidente'}
                ]
            });

        }
    });


}

$('body').on('click', '.Exportar', function() {



    var Reporte = $("#selectchosereportes").val();
    var agencia = $("#selectchosenagencia").val();
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var grupoventas = $("#selectchosegrupventas2").val();

    if (Reporte != "") {

        if (Reporte == '2') {

            $.ajax({
                data: {
                    'fechaini': fechaini,
                    'fechafin': fechafin,
                    'agencia': agencia,
                    'grupoventas': grupoventas
                },
                url: 'index.php?r=reportes/ReportesAltipal/AjaxExportar',
                type: 'post',
                beforeSend: function() {
                    $("#cargando").css("display", "inline");
                },
                success: function(response) {

                    window.open(response);

                }
            });

        } else if (Reporte == '1') {
            
            
            $.ajax({
                data: {
                    'fechaini': fechaini,
                    'fechafin': fechafin,
                    'agencia': agencia,
                    'grupoventas': grupoventas
                },
                url: 'index.php?r=reportes/ReportesAltipal/AjaxExportarHoraVisita',
                type: 'post',
                beforeSend: function() {
                    $("#cargando").css("display", "inline");
                },
                success: function(response) {

                    window.open(response);

                }
            });


        }

    } else {

        $('#_alerta  .text-modal-body').html('Por favor seleccione el reporte a exportar ');
        $('#_alerta').modal('show');

    }

});


$('body').on('click','.ExportarDetalle',function(){
    
     
        var agencia =   $("#idagencia").val();
        var zonaventa =   $("#idzona").val();
        var fechaini =  $("#fechaini").val();
        var fechafin =  $("#fechafin").val();
        
          $.ajax({
                data: {
                    'fechaini': fechaini,
                    'fechafin': fechafin,
                    'agencia': agencia,
                    'zonaventa': zonaventa
                },
                url: 'index.php?r=reportes/ReportesAltipal/AjaxExportarDetalle',
                type: 'post',
                beforeSend: function() {
                    $("#cargando").css("display", "inline");
                },
                success: function(response) {

                    window.open(response);

                }
            });
    
    
    
});

$('body').on('click','.ExportarDetallePedido',function(){
    
     
        var agencia =   $("#idagencia").val();
        var pedido =   $("#idpedido").val();
    
          $.ajax({
                data: {
                    'pedido': pedido,
                    'agencia': agencia
                },
                url: 'index.php?r=reportes/ReportesAltipal/AjaxExportarDetallePedido',
                type: 'post',
                beforeSend: function() {
                    $("#cargando").css("display", "inline");
                },
                success: function(response) {

                    window.open(response);

                }
            });
    
    
    
});
