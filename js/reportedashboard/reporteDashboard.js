$(document).ready(function() {

    $("#_alerta .text-modal-body").html("Sr(a) usuario recuerde tener la configuracion de las ventanas emergentes del navegador habilitadas para poder exportar los informes");
    $("#_alerta").modal('show');

});



function notastramitadas(){
debugger;
    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaNotasTramitadas',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');
        },
        success: function(response) {
            
//            $.ajax({
//            url: "index.php?r=ReportesDashboard/AjaxCargarReporteNotasTramitadas&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
//            type: 'post',
//             success: function(response) {
//                 
//                 debugger;
//             }
//            });
            $("#reportesDashboard").html(response);
            $("#_alertaCargando").modal('hide');
            $('#DatosNotasTramitadas').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteNotasTramitadas&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "aoColumns": [
                    {mData: 'TipoConsulta'},
                    {mData: 'ZonaVentas'},
                    {mData: 'Asesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCanal'},
                    {mData: 'Fecha'},
                    {mData: 'Hora'},
                    {mData: 'FechaAutorizacion'},
                    {mData: 'HoraAutorizacion'},
                    {mData: 'NombreCliente'},
                    {mData: 'Factura'},
                    {mData: 'NombreConceptoNotaCredito'},
                    {mData: 'Comentario'},
                    {mData: 'ObservacionCartera'},
                    {mData: 'IdDocumento'},
                    {mData: 'NombreArticulo'},
                    {mData: 'Cantidad'},
                    {mData: 'DsctoEspecial'},
                    {mData: 'DsctoEspecialAltipal'},
                    {mData: 'DsctoEspecialProveedor'},
                    {mData: 'Valor'},
                    {mData: 'Estado'},
                    {mData: 'ResponsableNota'}
                    
                ]
            });

        }
    });

}


function notaspendientesporautrizar(){
    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaNotasPendientes',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {


            $("#reportesDashboard").html(response);

            var tablaNotas =  $('#DatosNotasPendientes').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteNotasPendientes&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "aoColumns": [
                    {mData: 'ZonaVentas'},
                    {mData: 'Asesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCanal'},
                    {mData: 'NombreCliente'},
                    {mData: 'NombreBusqueda'},
                    {mData: 'NombreCiudad'},
                    {mData: 'NombreCuentaProveedor'},
                    {mData: 'Fecha'},
                    {mData: 'Hora'},
                    {mData: 'Valor'},
                    {mData: 'Factura'},
                    {mData: 'NombreConceptoNotaCredito'},
                    {mData: 'Comentario'},
                    {mData: 'ObservacionCartera'},
                    {mData: 'Estado'},
                    {mData: 'ResponsableNota'}

                ]
            });

            $('#DatosNotasPendientes thead  th').each( function () {
                var title = $('#DatosNotasPendientes thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder=" '+title+'" />');
            } );


            tablaNotas.columns().eq(0).each(function(colIdx) {
                $('input', tablaNotas.column(colIdx).header()).on('keyup change', function() {
                    tablaNotas
                        .column(colIdx)
                        .search(this.value)
                        .draw();
                });

                $('input', tablaNotas.column(colIdx).header()).on('click', function(e) {
                    e.stopPropagation();
                });
            });

            $("#_alertaCargando").modal('hide');
        }
    });


}

function reportedevoluciones(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaDevoluciones',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {


            $("#reportesDashboard").html(response);

            $('#DatosReporteDevolcuiones').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteDevoluciones&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "aoColumns": [
                    {mData: 'Responsable'},
                    {mData: 'Asesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCliente'},
                    {mData: 'ValorDevolucion'},
                    {mData: 'TotalDevolucion'},
                    {mData: 'Comentario'},
                    {mData: 'FechaAutorizacion'},
                    {mData: 'Autoriza'},
                    {mData: 'Detalle'}



                ]
            });

            $("#_alertaCargando").modal('hide');
        }
    });

}

function verdetalle(id,agencia){


    $("#DetalleDevolcuiones").modal('show');
    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxDetalleTablaDevoluciones',
        type: 'post',
        beforeSend: function() {


        },
        success: function(response) {


            $("#reportesDetalle").html(response);

            $('#DatosDetalleDevolcuiones').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarDetalleDevoluciones&id="+id+"&agencia="+agencia+"",
                "aoColumns": [
                    {mData: 'NombreArticulo'},
                    {mData: 'Cantidad'},
                    {mData: 'ValorUnitario'},
                    {mData: 'NombreUnidadMedida'},
                    {mData: 'ValorTotalProducto'},
                    {mData: 'NombreMotivoDevolucion'},


                ]
            });

        }
    });

}

function graficanotastramitadas(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxGraficosNotas',
        type: 'post',
        beforeSend: function() {

            $("#_alertaCargando").modal('show');
            $("#_alertaCargando .text-modal-body").html("Cargando....");

        },
        success: function(response) {
            $("#_alertaCargando").modal('hide');
            $("#reportesDashboard").html(response);
            // $("#_alertaCargando").modal('hide');
        },
        complete: function() {
            /*alert('terminó');
             $("#_alertaCargando").modal('hide');*/
        }

    });

}




function greficavalorgrupoventas(){

//$('body').on('click', '.oeoe', function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxValoresNotasAprobadas',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');
        },
        success: function(response) {

            $("#reportesDashboard").html(response);
            $("#_alertaCargando").modal('hide');
        }
    });

}

$('body').on('click','.verTabla',function (){

    $("#Information").modal('show');
    $("#informacion").DataTable();

});


function descuentospendientes(){


    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaDescuentsPendientes',
        type: 'post',
        beforeSend: function() {

            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');
        },
        success: function(response) {


            $("#reportesDashboard").html(response);


            var  tabla = $('#DatosDescuentosPendientes').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteDescuentosPendientes&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "aoColumns": [
                    {mData: 'IdPedido'},
                    {mData: 'NombreCliente'},
                    {mData: 'razonsoscial'},
                    {mData: 'NombreCiudad'},
                    {mData: 'nombreAsesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCanal'},
                    {mData: 'NombreArticulo'},
                    {mData: 'NombreUnidadMedida'},
                    {mData: 'Cantidad'},
                    {mData: 'DsctoEspecialAltipal'},
                    {mData: 'DsctoEspecialProveedor'},
                    {mData: 'QuienfaltaporAutorizar'}

                ]
            });


            $('#DatosDescuentosPendientes thead  th').each( function () {
                var title = $('#DatosDescuentosPendientes thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder=" '+title+'" />' );
            } );


            tabla.columns().eq(0).each(function(colIdx) {
                $('input', tabla.column(colIdx).header()).on('keyup change', function() {
                    tabla
                        .column(colIdx)
                        .search(this.value)
                        .draw();
                });

                $('input', tabla.column(colIdx).header()).on('click', function(e) {
                    e.stopPropagation();
                });
            });

            $("#_alertaCargando").modal('hide');
        }
    });


}


function descuentosaprobadosporproveedor(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaDescuentosAprobvadosPorProveedor',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {


            $("#reportesDashboard").html(response);

            var tablaDesAprovados = $('#DatosDescuentosAprobadosProveedor').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteDescuentosAprobadosProveedor&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "aoColumns": [
                    {mData: 'IdPedido'},
                    {mData: 'NombreCliente'},
                    {mData: 'razonsoscial'},
                    {mData: 'NombreCiudad'},
                    {mData: 'nombreAsesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCanal'},
                    {mData: 'NombreArticulo'},
                    {mData: 'NombreUnidadMedida'},
                    {mData: 'Cantidad'},
                    {mData: 'DsctoEspecialProveedor'},
                    {mData: 'proveedor'}

                ]
            });

            $('#DatosDescuentosAprobadosProveedor thead  th').each( function () {
                var title = $('#DatosDescuentosAprobadosProveedor thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder=" '+title+'" />' );
            } );


            tablaDesAprovados.columns().eq(0).each(function(colIdx) {
                $('input', tablaDesAprovados.column(colIdx).header()).on('keyup change', function() {
                    tablaDesAprovados
                        .column(colIdx)
                        .search(this.value)
                        .draw();
                });

                $('input', tablaDesAprovados.column(colIdx).header()).on('click', function(e) {
                    e.stopPropagation();
                });
            });

            $("#_alertaCargando").modal('hide');

        }
    });

}

function descuentosaprobadosporcartera(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaNotasCreditoAprobvadosPorCartera',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');
        },
        success: function(response) {


            $("#reportesDashboard").html(response);

            $('#DatosNotasCreditoAprobvadosPorCartera').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteNotasCreditoAprobvadosPorCartera&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    $('td', nRow).attr('nowrap','nowrap');
                    return nRow;
                },
                "aoColumns": [
                    {mData: 'ZonaVentas'},
                    {mData: 'Asesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'NombreCliente'},
                    {mData: 'NombreConceptoNotaCredito'},
                    {mData: 'Fecha'},
                    {mData: 'Hora'},
                    {mData: 'Autoriza'},
                    {mData: 'FechaAutorizacion'},
                    {mData: 'HoraAutorizacion'},
                    {mData: 'Valor'},
                    {mData: 'Factura'},
                    {mData: 'Comentario'},
                    {mData: 'ObservacionCartera'},
                    {mData: 'Estado'},
                    {mData: 'ResponsableNota'},
                    {mData: 'Audio'}

                ]
            });
            $("#_alertaCargando").modal('hide');

        }
    });


}



function  descuentostramitadosporcartera(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        url: 'index.php?r=ReportesDashboard/AjaxTablaDescuentoFueradelRango',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');
        },
        success: function(response) {


            $("#reportesDashboard").html(response);

            $('#DatosDescuentoFueradelRango').DataTable({
                "language": {
                    "emptyTable": "Para el rango de fecha seleccionado no hay informacion"
                },
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=ReportesDashboard/AjaxCargarReporteDescuentoFueradelRango&fechaini="+fechaIni+"&fechafin="+fechaFin+"",
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    $('td', nRow).attr('nowrap','nowrap');
                    return nRow;
                },
                "aoColumns": [
                    {mData: 'IdPedido'},
                    {mData: 'NombreCliente'},
                    {mData: 'razonsoscial'},
                    {mData: 'NombreCiudad'},
                    {mData: 'nombreAsesor'},
                    {mData: 'NombreGrupoVentas'},
                    {mData: 'ValorPedido'},
                    {mData: 'Cantidad'},
                    {mData: 'FechaPedido'},
                    {mData: 'FechaAutorizaAltipal'},
                    {mData: 'NombreAutorizoDsctoAltipal'},
                    {mData: 'Cartera'}

                ]
            });

            $("#_alertaCargando").modal('hide');
        }
    });

}

function notascreditotimeaot(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxGraficosNotasTimeOut',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {
            $("#_alertaCargando").modal('hide');
            $("#reportesDashboard").html(response);

        }
    });


}


function notasgestionadastimeaot(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxGraficosNotasGestinadasTimeOut',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            if(response == 1){

                $("#_alertaCargando").modal('hide');
                $("#_alerta .text-modal-body").html("Para el rango de fecha seleccionado no hay informacion");
                $("#_alerta").modal('show');
                return;

            }

            $("#reportesDashboard").html(response);
            $("#_alertaCargando").modal('hide');
        }
    });

}

////////EXPROTAR A EXCEL////////


$('body').on('click','.NotasTramitadasExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();


    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin': fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxNotasTramitadasExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {
            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});




$('body').on('click','.NotasPendientesPorAutorizarExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxNotasPendientesPorAutorizarExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});



$('body').on('click','.DevolucionesExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxDevolucionesExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});


$('body').on('click','.DescuentosPendientesExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxDescuentosPendientesExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});


$('body').on('click','.DescuentosAprobadosPorProveedorExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxDescuentosAprobadosPorProveedorExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});


$('body').on('click','.NotasAprobadasPorCarteraExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxNotasAprobadasPorCarteraExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});


$('body').on('click','.DescuentosFueraDelRangoExcel',function(){

    var fechaIni = $("#fechainiDahsboard").val();
    var fechaFin = $("#fechafinDahsboard").val();

    if(fechaFin < fechaIni || fechaIni > fechaFin){

        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaIni': fechaIni,
            'fechaFin':fechaFin
        },
        url: 'index.php?r=ReportesDashboard/AjaxDescuentosFueraDelRangoExcel',
        type: 'post',
        beforeSend: function() {
            $("#_alertaCargando .text-modal-body").html("Cargando....");
            $("#_alertaCargando").modal('show');

        },
        success: function(response) {

            $("#_alertaCargando").modal('hide');
            window.open(response);

        }
    });
});

