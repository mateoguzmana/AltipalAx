$('body').on('click','.saliractividad',function(){
    
    $("#_alertConfirmarSemana .text-modal-body").html('Esta seguro que desea salir del modulo de actividades ?');
    $("#_alertConfirmarSemana").modal('show');
});


$(".ChangeZonasVentas").change(function() {

    var agencia = $("#agencia").val();

    $.ajax({
        data: {
            'agencia': agencia

        },
        url: 'index.php?r=AdministracionFocalizados/AjaxZonaVentasAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#zonaventas").html('');
            $("#zonaventas").html(response);
            $("#selectchosezonaventas2").chosen();
            $('#selectchosezonaventas2').val('0').trigger('chosen:updated');
            $('#selectchoseclientes2').val('0').trigger('chosen:updated');
             
           
        }
    });

});


$(".CargarClientes").change(function() {

    var agencia = $("#agencia").val();
    var zona = $('#selectchosezonaventas2').val();

    $.ajax({
        data: {
            'agencia': agencia,
            'zona': zona

        },
        url: 'index.php?r=AdministracionFocalizados/AjaxClientesZonaVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#cuentacliente").html('');
            $("#cuentacliente").html(response);
            $("#selectchoseclientes2").chosen();
            
            
            $('#DatosActividades').DataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionActividad&zona="+zona+"&agencia="+agencia+"&cuentacliente=",
                "aoColumns": [
                    {mData: 'zona'},
                    {mData: 'cuentacliente'},
                    {mData: 'fechaini'},
                    {mData: 'fechafin'},
                    {mData: 'descripcion'},
                    {mData: 'inversion'},
                    {mData: 'ejecutado'},
                ]
            });

        }
    });

});

$(".CargarActividad").change(function() {
    
    var cliente = $("#selectchoseclientes2").val();
    var agencia = $("#agencia").val();
    
        $('#DatosActividades').DataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionActividad&zona=&agencia="+agencia+"&cuentacliente="+cliente+"",
                "aoColumns": [
                    {mData: 'zona'},
                    {mData: 'cuentacliente'},
                    {mData: 'fechaini'},
                    {mData: 'fechafin'},
                    {mData: 'descripcion'},
                    {mData: 'inversion'},
                    {mData: 'ejecutado'},
                ]
            });
    
});



$('body').on('click', '#btnGuardarActividad', function() {


    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    var zona = $("#zonaVentas").val();
    var cliente = $("#clientes").val();

    var descripcion = $("#descripcion").val();
    var inversionactividad = $("#inversionactividad").val();


    if (fechaini == "" && fechafin == "" && agencia == "0" && zona == "0" && cliente == "0" && descripcion == "" && inversionactividad == "") {

        $("#ErroAgencia").html('Seleccione una agencia');
        $("#ErroAgencia").css("color", "red");
        $("#ErroAgencia").show();

        $("#ErrozonaVentas").html('Seleccione una zona ventas');
        $("#ErrozonaVentas").css("color", "red");
        $("#ErrozonaVentas").show();

        $("#Errocliente").html('Seleccione un cliente');
        $("#Errocliente").css("color", "red");
        $("#Errocliente").show();

        $("#ErroFechaini").html('Seleccione la fecha inicial');
        $("#ErroFechaini").css("color", "red");
        $("#ErroFechaini").show();

        $("#ErroFechaFin").html('Seleccione la fecha final');
        $("#ErroFechaFin").css("color", "red");
        $("#ErroFechaFin").show();

        $("#Errordescripcion").html('ingrese  una descripcion');
        $("#Errordescripcion").css("color", "red");
        $("#Errordescripcion").show();


        $("#Errorinversion").html('ingrese  una  inversion');
        $("#Errorinversion").css("color", "red");
        $("#Errorinversion").show();

        return false;

    }

    var zonas = $("#selectchosezonaventas2").val();
    var clientes = $("#selectchoseclientes2").val();





    if (fechaini == "") {

        $("#ErroFechaini").html('Seleccione la fecha inicial');
        $("#ErroFechaini").css("color", "red");
        $("#ErroFechaini").show();
        return false;

    }

    if (fechafin == "") {

        $("#ErroFechaFin").html('Seleccione la fecha final');
        $("#ErroFechaFin").css("color", "red");
        $("#ErroFechaFin").show();
        $("#ErroFechaini").hide();
        return false;

    }


    if (agencia == "0") {

        $("#ErroAgencia").html('Seleccione una agencia');
        $("#ErroAgencia").css("color", "red");
        $("#ErroAgencia").show();
        $("#ErroFechaFin").hide();
        return false;
    }

    if (zonas == "0") {

        $("#ErrozonaVentas").html('Seleccione una zona ventas');
        $("#ErrozonaVentas").css("color", "red");
        $("#ErrozonaVentas").show();
        $("#ErroAgencia").hide();
        return false;

    }


    if (clientes == "0") {

        $("#Errocliente").html('Seleccione un cliente');
        $("#Errocliente").css("color", "red");
        $("#Errocliente").show();
        $("#ErrozonaVentas").hide();
        return false;

    }


    if (descripcion == "") {

        $("#Errordescripcion").html('ingrese  una  descripcion');
        $("#Errordescripcion").css("color", "red");
        $("#Errordescripcion").show();
        $("#Errocliente").hide();
        return false;

    }


    if (inversionactividad == "") {

        $("#Errorinversion").html('ingrese  una inversion');
        $("#Errorinversion").css("color", "red");
        $("#Errorinversion").show();
        $("#Errordescripcion").hide();
        return false;

    }

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;
    }


    $.ajax({
        data: {
            'agencia': agencia,
            'zonas': zonas,
            'clientes': clientes,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'descripcion': descripcion,
            'inversionactividad': inversionactividad

        },
        url: 'index.php?r=AdministracionFocalizados/AjaxGuardarActividad',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $('#agencia').val('0').trigger('chosen:updated');
            $('#selectchosezonaventas2').val('0').trigger('chosen:updated');
            $('#selectchoseclientes2').val('0').trigger('chosen:updated');
            $("#fechaini").val('');
            $("#fechafin").val('');
            $("#descripcion").val('');
            $("#inversionactividad").val('');
            $("#Errorinversion").hide();

            $("#_alertaSuccesPermisosPaginaWeb #sucess").html('Actividad Registrada Correctamente');
            $("#_alertaSuccesPermisosPaginaWeb").modal('show');

        }
    });



});