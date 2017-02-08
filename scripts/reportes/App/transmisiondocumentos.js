$(document).ready(function () {
    /*
     jQuery('.fechareport').datepicker({
     dateFormat: 'yy-mm-dd',
     beforeShow: function(i) {
     if ($(i).attr('readonly')) {
     return false;
     }
     }
     });*/



    $("#fechainicial1").datepicker({
        defaultDate: "+1w",
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function (selectedDate) {

            var sumarDias = parseInt(30);
            fecha = selectedDate.replace("-", "/").replace("-", "/");

            fecha = new Date(fecha);
            fecha.setDate(fecha.getDate() + sumarDias);

            var anio = fecha.getFullYear();
            var mes = fecha.getMonth() + 1;
            var dia = fecha.getDate();

            if (mes.toString().length < 2) {
                mes = "0".concat(mes);
            }

            if (dia.toString().length < 2) {
                dia = "0".concat(dia);
            }

            selectedDateDos = anio + "-" + mes + "-" + dia;

            $("#fechafinal1").datepicker("destroy");

            // $('#fechafinal1').attr('disabled', false);
            $("#fechafinal1").datepicker({
                minDate: selectedDate,
                maxDate: selectedDateDos,
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                numberOfMonths: 1,
            });
            $("#fechafinal1").datepicker("refresh");



            //$( "#fechafinal1" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
            //   $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
    });




});

$('.salirReporestResumenDia').click(function () {

    $('#_alertSalirReportesResumenDia .text-modal-body').html('Esta seguro que desea salir del modulo de resumen dia ?');
    $('#_alertSalirReportesResumenDia').modal('show');

});

//<meta name="csrf-token" content="<?= csrf_token() ?>">

function cargarInformacion()
{
   var fechaini = $("#fechainicial1").val();
   var fechafinal = $("#fechafinal1").val();
   var zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas' : zonaVentas
        },
        url: 'index.php?r=Webapp/Cargarinformacion',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
           // console.log(response);
            $("#informacion").html(response);
            //$('#tbllogerror').dataTable();

        }
    });
}

function abrirModal(tipo)
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas 
        },
        url: 'index.php?r=webapp/Cargardetallepedido',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {

            $("#datosConsultaPedido").html(response);
            $("#myModal").modal("show");
//$('#tbllogerror').dataTable();

        }
    });
}

function pedidosPendientes()
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data:{
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/Cargardetallepedidopendiente',
        type: 'post',
        beforeSend: function (){

        },
        success: function(response){
            $("#datosConsultaPedidoPendiente").html(response);
            $("#myModal").modal("show");
        }

    });
}

function abrirModalReciboCaja()
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarRecibosCaja',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaRecibosCaja").html(response);
            $("#myModalRc").modal("show");
        }
    });
}

function abrirModalDevoluciones()
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarDevoluciones',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaDevoluciones").html(response);
            $("#myModalDevoluciones").modal("show");
        }
    });
}

function abrirModalNotaCredito()
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val();

    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarNotacredito',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaNotacredito").html(response);
            $("#myModalNotacredito").modal("show");
        }
    });
}

function abrirModalClientenuevo()
{
    var fechaini = $("#fechainicial1").val();
    var fechafinal = $("#fechafinal1").val();
    var zonaVentas = $("#zonaVentas").val(); 
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarClienteNuevo',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaClientenuevo").html(response);
            $("#myModalClientenuevo").modal("show");
        }
    });
}

function abrirModalConsigvendedor()
{
    fechaini = $("#fechainicial1").val();
    fechafinal = $("#fechafinal1").val();
    zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarConsigvendedor',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaConsigvendedor").html(response);
            $("#myModalConsigvendedor").modal("show");
        }
    });
}

function abrirModalNorecaudado()
{
    fechaini = $("#fechainicial1").val();
    fechafinal = $("#fechafinal1").val();
    zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarNorecaudado',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaNorecaudado").html(response);
            $("#myModalNorecaudado").modal("show");
        }
    });
}

function abrirModalNovisita()
{
    fechaini = $("#fechainicial1").val();
    fechafinal = $("#fechafinal1").val();
    zonaVentas = $("#zonaVentas").val();
    $.ajax({
        data: {
            'fecha': fechaini,
            'fechafinal': fechafinal,
            'zonaVentas': zonaVentas
        },
        url: 'index.php?r=webapp/CargarNovisita',
        type: 'post',
        beforeSend: function () {


        },
        success: function (response) {
            $("#datosConsultaNovisita").html(response);
            $("#myModalNovisita").modal("show");
        }
    });


}