function vistaenviarmensaje() {

    $.ajax({
        url: 'index.php?r=mensajes/AjaxVistaEnviarMensajes',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#vistaenviuarmensaje").html(response);
            $("#selectchosensupervisores").chosen();


        }
    });


}


$("body").on('change', '.onchenSupervisor', function() {

    var supervisor = $("#selectchosensupervisores").val();
    
    
    if(supervisor == '1'){
        
     $.ajax({
        data: {
            'supervisor': supervisor
        },
        url: 'index.php?r=mensajes/AjaxAsesoresSupervisor',
        type: 'post',
        dataType: 'html',
        beforeSend: function() {

        },
        success: function(response) {

            $("#zonaaenviarmensaje").html(response);
            $('#tblAsesores').DataTable({
                "sPaginationType": "full_numbers",
            });

        }
    });
        
        
        
    }else{


    $.ajax({
        data: {
            'supervisor': supervisor
        },
        url: 'index.php?r=mensajes/AjaxAsesoresSupervisor',
        type: 'post',
        dataType: 'html',
        beforeSend: function() {

        },
        success: function(response) {

            $("#zonaaenviarmensaje").html(response);
            $('#tblAsesores').DataTable({
                "sPaginationType": "full_numbers",
            });

        }
    });
    
    }

});




$("body").on('click', '.EnviarMensaje', function() {


    var mensaje = $("#mensaje").val();
    var supervisor = $("#selectchosensupervisores").val();



    var arr_asesores = new Array();
    var z = 0;

    var totalasesores = 0;
    var checkNoAsesores = 0;

    $(".chckAsesores").each(function() {
        totalasesores++;
        if ($(this).is(":checked")) {
            checkNoAsesores++;
        }

    });


    if (checkNoAsesores == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione almenos un asesor');
        $('#_alerta').modal('show');
        return false;
    }

    if (mensaje == 0) {

        $('#_alerta .text-modal-body').html('digite el mensaje');
        $('#_alerta').modal('show');
        return false;
    }


    if (supervisor == "") {

        $('#_alerta .text-modal-body').html('Por favor seleccione un supervisor');
        $('#_alerta').modal('show');
        return false;
    }

    $(".chckAsesores").each(function() {
        if ($(this).is(":checked")) {
            arr_asesores[z] = $(this).val();
        }
        z++;
    });
    z = 0;


    $.ajax({
        data: {
            'asesores': arr_asesores,
            'mensaje': mensaje,
            'supervisor': supervisor
        },
        url: 'index.php?r=mensajes/AjaxEnviarMnesajeaAsesores',
        type: 'post',
        dataType: 'html',
        beforeSend: function() {

        },
        success: function(response) {

            $('#_alertaMensajeCorrecto .text-modal-body').html('Mensaje Enviado Correctamente');
            $('#_alertaMensajeCorrecto').modal('show')
            $("#mensaje").val('');

        }
    });

});




function marcarCheck(source)
{
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
        }
    }
}

function mensajes() {

    $.ajax({
        url: 'index.php?r=mensajes/AjaxVerMensajes',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#vistaenviuarmensaje").html(response);
            $("#selectchosenagencia").chosen();

            jQuery('#fechaini').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });

            jQuery('#fechafin').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });


        }
    });

}


$("body").on('change', '.onchenAgenciaMensaje', function() {
 
   var  fechaini = $("#fechaini").val();
   var  fechafin = $("#fechafin").val();
   var  agencia = $("#selectchosenagencia").val();
  
  
   if(fechafin < fechaini || fechaini > fechafin){
        
        $("#_alerta .text-modal-body").html("la fecha Final no puede ser menor que la inicial o fecha final no puede ser superior a la fecha inicial");
        $("#_alerta").modal('show');
        return;
    }

   $.ajax({
            url: 'index.php?r=mensajes/AjaxCargarTablaMensajes',
            type: 'post',
            beforeSend: function() {

            },
            success: function(response) {


                $("#zonaaenviarmensaje").html(response);
               
                
                $('#DatosMensaje').DataTable({
                    "pagingType": "full_numbers",
                    "bProcessing": true,
                    "sAjaxSource": "index.php?r=mensajes/AjaxCargarReporteMensajes&fechaini="+fechaini+"&fechafin="+fechafin+"&agencia="+agencia+"",
                    "aoColumns": [
                        {mData: 'IdDestinatario'},
                        {mData: 'NombreZonadeVentas'},
                        {mData: 'IdRemitente'},
                        {mData: 'FechaMensaje'},
                        {mData: 'HoraMensaje'},
                        {mData: 'Mensaje'},
                        {mData: 'CodAsesor'},
                        {mData: 'Estado'}
                     ]
                });

            }
        }); 

});