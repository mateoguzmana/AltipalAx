//////acciones dodne se cargan los grupos de ventas y la zona de vantas 
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
            
            $('#selectchosegrupventas2').val('').trigger('chosen:updated');
            $('#selectchosezonaventas2').val('').trigger('chosen:updated');
           
            $("#grupoventa").html('');
            $("#grupoventa").html(response);
            $("#selectchosegrupventas2").chosen();


        }
    });

});


$('.onchangezonaventas').change(function() {


    var grupoventa = $("#selectchosegrupventas2").val();
    var agencia = $("#selectchosenagencia").val();


    $.ajax({
        data: {
            'grupoventa': grupoventa,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarZonasVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#zonasventas").html('');
            $("#zonasventas").html(response);

            $("#selectchosezonaventas2").chosen();
        }
    });



});

////////Aciondes donde se carga las graficas y la informacion //////

$('.GenrarRepoteAgencia').change(function() {

    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();


    $.ajax({
        data: {
            'fecha': fecha,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasXProveedorAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#graf").html(response);

            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            jQuery('#datepickerVistaLink').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });


        }
    });

});


$('.GenrarRepoteCanal').change(function() {

    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
    var canal = $("#selectchosencanal").val();


    $.ajax({
        data: {
            'fecha': fecha,
            'agencia': agencia,
            'canal': canal


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasXProveedorCanal',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#graf").html(response);

            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            jQuery('#datepickerVistaLink').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });

        }
    });

});


$('.GenrarRepoteGrupVenta').change(function() {

    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
    var grupo = $("#selectchosegrupventas2").val();


    $.ajax({
        data: {
            'fecha': fecha,
            'agencia': agencia,
            'grupo': grupo


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasXProveedorGrupoVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#graf").html(response);

            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            jQuery('#datepickerVistaLink').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });

        }
    });

});


$('.GenrarRepoteZonaVenta').change(function() {

    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
    var zona = $("#selectchosezonaventas2").val();


    $.ajax({
        data: {
            'fecha': fecha,
            'agencia': agencia,
            'zona': zona


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasXProveedorZonaVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#graf").html(response);

            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            jQuery('#datepickerVistaLink').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });

        }
    });

});


$('.GenrarRepotFecha').change(function() {

    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();


    $.ajax({
        data: {
            'fecha': fecha,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasXProveedorFecha',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#graf").html(response);

            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            jQuery('#datepickerVistaLink').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShow: function(i) {
                    if ($(i).attr('readonly')) {
                        return false;
                    }
                }
            });


        }
    });

});


///////////////AQUI EMPIESAN LOS FILTROS Y REPORTES CATEGORIA,GRUPO Y MARCA///////////////////////////////////

$("body").on('change','.GenerarReporteCGMxAgencia',function (){

    var agencia = $("#selectAgencia").val();
    var fecha = $("#datepickerVistaLink").val();
    
    $('#selectchosegrupos').val('').trigger('chosen:updated');
    $('#selectchosecategoria').val('').trigger('chosen:updated');
    $('#selectProveedor').val('').trigger('chosen:updated');
    $('#selectchosemarcas').val('').trigger('chosen:updated');
    
    

    $.ajax({
        data: {
            'agencia': agencia,
            'fecha': fecha


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarCGMAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#grafCGM").html(response);
          
        }
    });

});

$("body").on('change','.GenerarReporteCGMxFecha',function (){

    var agencia = $("#selectAgencia").val();
    var fecha = $("#datepickerVistaLink").val();

    $.ajax({
        data: {
            'agencia': agencia,
            'fecha': fecha


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarCGMAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#grafCGM").html(response);

        }
    });

});

$("body").on('change','.GenerarReporteCGMxProveedor',function (){

    var agencia = $("#selectAgencia").val();
    var fecha = $("#datepickerVistaLink").val();
    var proveedor = $("#selectProveedor").val();
    
    $('#selectchosegrupos').val('').trigger('chosen:updated');
    $('#selectchosecategoria').val('').trigger('chosen:updated');
    $('#selectchosemarcas').val('').trigger('chosen:updated');

    
    $.ajax({
        data: {
            'agencia': agencia,
            'fecha': fecha,
            'proveedor': proveedor


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarCGMProveedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#grafCGM").html(response);


            $.ajax({
                data: {
                    'agencia': agencia,
                    'proveedor': proveedor


                },
                url: 'index.php?r=reportes/Reportes/AjaxCargarCategorias',
                type: 'post',
                beforeSend: function() {

                },
                success: function(response) {


                   $("#categorias").html('');
                   $("#categorias").html(response);
                   $("#selectchosecategoria").chosen();

                }
            });



        }
    });

});

$("body").on('change','.onchangeGruposByMarcas',function (){

    var Categoria = $("#selectchosecategoria").val();
    var agencia = $("#selectAgencia").val();

    $.ajax({
        data: {
            'Categoria': Categoria


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGrupos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#grupos").html('');
            $("#grupos").html(response);
            $("#selectchosegrupos").chosen();


            ///se cargan las marcas

            $.ajax({
                data: {
                    'Categoria': Categoria,
                    'agencia': agencia


                },
                url: 'index.php?r=reportes/Reportes/AjaxCargararcas',
                type: 'post',
                beforeSend: function() {

                },
                success: function(response) {

                    $("#marcas").html('');
                    $("#marcas").html(response);
                    $("#selectchosemarcas").chosen();


                }
            });


        }
    });


});

$("body").on('change','.GenrarReporteCategoriaVentasVistaLink',function (){

    var agencia = $("#selectAgencia").val();
    var fecha = $("#datepickerVistaLink").val();
    var categoria = $("#selectchosecategoria").val();

    $.ajax({
        data: {
            'agencia': agencia,
            'fecha': fecha,
            'categoria': categoria


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarCGMCategoria',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#grafCGM").html(response);




        }
    });

});


$("body").on('change','.GenrarReporteMarcasVentasVistaLink',function (){

    var agencia = $("#selectAgencia").val();
    var fecha = $("#datepickerVistaLink").val();
    var marca = $("#selectchosemarcas").val();

    $.ajax({
        data: {
            'agencia': agencia,
            'fecha': fecha,
            'marca': marca


        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarCGMMarcas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#grafCGM").html(response);




        }
    });

});








