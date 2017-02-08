$('#retornarMenu').click(function() {    
    window.location.href='index.php?r=reportes/AprovacionDocumentos/AprobarDevoluciones';  

});


$('.btnDetalleDevoluciones').click(function() {

    var idDevoluciones = $(this).attr('data-id-devoluciones');
    var agencia = $(this).attr('data-agencia');

    $.ajax({
        data: {
            'idDevoluciones': idDevoluciones,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetalladoDevoluciones',
        type: 'post',
        beforeSend: function() {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $("#imgCargando1").html('');
            $('#mdlDetalleDevolucion .modal-body').html(response);
            $('#mdlDetalleDevolucion').modal('show');

            $("#checkAll").click(function() {
                $('.check-autorizar-devolucion').not(this).prop('checked', this.checked);
                if ($(this).is(':checked'))
                {
                    $(".selectpicker").val("");

                    $('.checkbox-rechazo').removeAttr("checked");
                    $(".checkbox-rechazo").attr('checked', false);
                    $('#checkAll-rechazo').removeAttr("checked");
                    $('#checkAll-rechazo').attr('checked', false);
                }

            });


            $("#checkAll-rechazo").click(function() {
                $('.checkbox-rechazo').not(this).prop('checked', this.checked);
                if ($(this).is(':checked'))
                {
                    $(".selectpicker").val("");

                    $('.check-autorizar-devolucion').removeAttr("checked");
                    $(".check-autorizar-devolucion").attr('checked', false);
                    $('#checkAll').removeAttr("checked");
                    $('#checkAll').attr('checked', false);
                }
            });

            $(".check-on").click(function() {
                if ($(this).is(':checked')) {

                    var producto = $(this).attr('rel');
                    //        alert('Produ:'+producto);             
                    $('#checkAll-rechazo').removeAttr("checked");
                    $('#checkAll-rechazo').attr('checked', false);
                    $('#off-' + producto).removeAttr("checked");
                    $('#off-' + producto).attr('checked', false);
                }
            });


            $(".check-off").click(function() {
                if ($(this).is(':checked')) {

                    var producto = $(this).attr('rel');
                    //        alert('Produ:'+producto);             
                    $('#checkAll').removeAttr("checked");
                    $('#checkAll').attr('checked', false);
                    $('#on-' + producto).removeAttr("checked");
                    $('#on-' + producto).attr('checked', false);
                }
            });


        }
    });
});


$('#btnGuardarDevolucion').click(function() {

    var id = $("#devolucion").val();
    var agencia = $("#Agencia").val();
    var grupoventas = $("#Gupo").val();
    var observacion = $("#observacion").val();
    var valordevolucion = $("#valordevolucion").val();
    var zona = $("#Zona").val();
    var cliente = $("#cliente").val();
    var asesor = $("#asesor").val();
     
    
    var rowNoSeleccionado = 0;



    $("#detalle > tbody > tr").each(function() {
        var numberOfChecked = $('th > input:checkbox:checked', this).length;
        if (numberOfChecked === 0) {
            rowNoSeleccionado++;
        }
    });


    if (rowNoSeleccionado > 0) {

        $('#_alerta .text-modal-body').html('Debe de Autorizar o Rechazar todos los artículos antes de guardar la devolución');
        $('#_alerta').modal('show');
        return false;
    } else {


        
        var arr_chequiados = new Array();
        var z = 0;

        $(".check-autorizar-devolucion").each(function() {
            if ($(this).is(":checked")) {
                arr_chequiados[z] = $(this).attr('data-prueba');
            }
            z++;
        });
        z = 0;
        
        var arr_chequiadosRechazados = new Array();
        var r = 0;

        $(".checkbox-rechazo").each(function() {
            if ($(this).is(":checked")) {
                arr_chequiadosRechazados[r] = $(this).attr('data-prueba');
            }
            r++;
        });
        r = 0;
            
        $.ajax({
            data: {
                'estado': arr_chequiados,
                'id': id,
                'agencia': agencia,
                'estadorechazado':arr_chequiadosRechazados,
                'observacion':observacion,
                'valordevolucion':valordevolucion,
                'zona':zona,
                'cliente':cliente,
                'asesor':asesor
                 
            },
            url: 'index.php?r=reportes/AprovacionDocumentos/AjaxGuardaAprovacionDevoluciones',
            type: 'post',
            beforeSend: function() {
                $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
              
                
                location.href = "index.php?r=reportes/AprovacionDocumentos/AjaxDetalleDevoluciones&agencia=" + agencia + "&grupoVentas=" + grupoventas + "";

            }
        });


    }





});

 