$('body').on('click','.salirsemana',function(){
    
    $("#_alertConfirmarSemana .text-modal-body").html('Esta seguro que desea salir del modulo de semanas ?');
    $("#_alertConfirmarSemana").modal('show');
});

jQuery(document).ready(function() {

    $('#DatosSemana').DataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionSemana",
        "aoColumns": [
            {mData: 'ano'},
            {mData: 'mes'},
            {mData: 'semana'},
            {mData: 'fechainicial'},
            {mData: 'fechafinal'},
            {mData: 'hora'},
            {mData: 'fecha'},
            {mData: 'usuario'},
            {mData: 'Boton'},
        ]
    });


});


$('body').on('click', '#btnGuardarSemanas', function() {

    var fechaini = $('#fechaini').val();
    var fechafin = $('#fechafin').val();
    var semana = $('#semana').val()
    
    
    if(fechaini == ''){
        
        $('#_alerta .text-modal-body').html('Por favor  seleccione la fecha inicial');
        $('#_alerta').modal('show');
        return;
    }
    
    
     if(fechafin == ''){
        
        $('#_alerta .text-modal-body').html('Por favor  seleccione la fecha final');
        $('#_alerta').modal('show');
        return;
    }

    if (fechafin < fechaini || fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('la fecha final no puede ser menor que la fecha inicial o la fecha inicial no puede ser  mayor  que la fecha final');
        $('#_alerta').modal('show');
        return;
    }

    if (semana == '0') {

        $('#_alerta .text-modal-body').html('Por favor seleccione una semana');
        $('#_alerta').modal('show');
        return;
    }


    $.ajax({
        data: {
            'fechaini': fechaini,
            'fechafin': fechafin,
            'semana': semana
        },
        url: 'index.php?r=AdministracionFocalizados/AjaxGuardarSemanas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            if (response == 1) {

                $('#_alerta .text-modal-body').html('Señor usuario  usted no puede agregar mas de 5 semana para el mismo mes');
                $('#_alerta').modal('show');
                return;
            }else if(response == 2){
                
                $('#_alerta .text-modal-body').html('la fechas seleccionadas no pertenecen al mismo mes');
                $('#_alerta').modal('show');
                return;
                
            }else if(response == 3){
                
                $('#_alerta .text-modal-body').html('Señor usuario ya se registro esta semana para este mes por favor seleccione otra');
                $('#_alerta').modal('show');
                return;
            }else if(response == 4){
                
                $('#_alerta .text-modal-body').html('El rango para la semana no debe ser menor a 1 dia ni mayor a 15 dias');
                $('#_alerta').modal('show');
                return;
            }else if(response == 5){
                
                $('#_alerta .text-modal-body').html('El rango de fechas seleccinada ya existe para este  mes');
                $('#_alerta').modal('show');
                return;
            }

            $("#_alertaSuccesPermisosPaginaWeb #sucess").html('Semana Registrada Correctamente');
            $("#_alertaSuccesPermisosPaginaWeb").modal('show');

            $('#DatosSemana').DataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionSemana",
                "aoColumns": [
                    {mData: 'ano'},
                    {mData: 'mes'},
                    {mData: 'semana'},
                    {mData: 'fechainicial'},
                    {mData: 'fechafinal'},
                    {mData: 'hora'},
                    {mData: 'fecha'},
                    {mData: 'usuario'},
                    {mData: 'Boton'},
                ]
            });

        }
    });

});



$('body').on('click', '.eliminarsemana', function() {

    var id = $(this).attr('data-id');
    var fechafin = $(this).attr('data-fechafin');
    var fechaini = $(this).attr('data-fechaini');

    $.ajax({
        data: {
            'id': id,
            'fechafin': fechafin,
            'fechaini': fechaini

        },
        url: 'index.php?r=AdministracionFocalizados/AjaxEliminarSemana',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            if (response == 1) {

                $('#_alerta .text-modal-body').html('La semana no se puede eliminar ya que esta fue ejecutada');
                $('#_alerta').modal('show');
                return;
            } else if (response == 2) {

                $('#_alerta .text-modal-body').html('La semana no puede ser eliminada ya que se esta ejecutando');
                $('#_alerta').modal('show');
                return;
            }

            $('#_alerta .text-modal-body').html('Semana eliminada correctamente');
            $('#_alerta').modal('show');

            $('#DatosSemana').DataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionSemana",
                "aoColumns": [
                    {mData: 'ano'},
                    {mData: 'mes'},
                    {mData: 'semana'},
                    {mData: 'fechainicial'},
                    {mData: 'fechafinal'},
                    {mData: 'hora'},
                    {mData: 'fecha'},
                    {mData: 'usuario'},
                    {mData: 'Boton'},
                ]
            });



        }
    });

});


$('body').on('change','.Buscar',function (){
    
   var ano  =  $('#ano').val();
   var mes  =  $('#mes').val();
   
   if(ano == 0){
     
     $('#_alerta .text-modal-body').html('Por favor seleccione el año');
     $('#mes').val('0').trigger('chosen:updated');
     $('#_alerta').modal('show');   
     return;
   }
    
   $('#DatosSemana').DataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": "index.php?r=AdministracionFocalizados/AjaxCargarInformacionSemana&ano="+ano+"&mes="+mes+"",
                "aoColumns": [
                    {mData: 'ano'},
                    {mData: 'mes'},
                    {mData: 'semana'},
                    {mData: 'fechainicial'},
                    {mData: 'fechafinal'},
                    {mData: 'hora'},
                    {mData: 'fecha'},
                    {mData: 'usuario'},
                    {mData: 'Boton'},
                ]
            });  
    
});
