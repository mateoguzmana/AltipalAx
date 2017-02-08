$("#codigoCiiunit").change(function (){
    
   var ciiu = $("#codigoCiiunit").val();
   var texto =  $("#codigoCiiunit option:selected").text();
   
   
  document.getElementById("codigoCiiu").innerHTML = ciiu; 
  document.getElementById("nombreciiu").innerHTML = texto;
  
});

jQuery(document).ready(function(){
  
   var codciudad = $("#Ciudades").children('option:selected').attr('data-ciudad');
    var coddepartamento = $("#Ciudades").children('option:selected').attr('data-depatamento');
    var codbarrio = $("#Ciudades").children('option:selected').attr('data-barrio');
    
    /*alert(codciudad);
    alert(coddepartamento);
    alert(codbarrio);*/
    
    verificaCiudades(codciudad,coddepartamento,codbarrio);
    
});



function verificaCiudades(codciudad,coddepartamento,codbarrio){   
      
    $.ajax({
        data: {
            "codciudad": codciudad,
            "coddepartamento": coddepartamento

        },
        url: 'index.php?r=ClientesNuevos/AjaxDepartamento',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-departamento").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            $("#Departamentos").html(response);
            $("#img-cargar-departamento").html('');
            jQuery(".chosen-select").chosen();


            $.ajax({
                data: {
                    "departamento": coddepartamento,
                    "ciudad": codciudad,
                    "codbarrio":codbarrio


                },
                url: 'index.php?r=ClientesNuevos/AjaxBarrios',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-ciudades").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {

                    $("#Barrios").html(response);
                    $("#img-cargar-ciudades").html('');
                    jQuery(".chosen-select").chosen();

                }
            });

        }
    });

}

$("#Ciudades").change(function() {

    var codciudad = $(this).children('option:selected').attr('data-ciudad');
    var coddepartamento = $(this).children('option:selected').attr('data-depatamento');
    verificaCiudades(codciudad,coddepartamento);

});

$("#retornarMenu").click(function (){
    
    $("#_alertConfirmationMenu  .text-modal-body").html('Está seguro que desea salir del módulo de clientes nuevos ?');
    $("#_alertConfirmationMenu").modal('show');
    
    
});


function FilterInput(event) {
    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;

    if (chCode == 8 || chCode == 0)
    {
        return chCode;
    } else {
        if (chCode > 47 & chCode < 58)
        {
            return chCode;
        } else {
            return false;
        }
    }
}

$("#agregardireccionclienteverificado").click(function (){
    
    
    var via = $("#via").val();
    var direc = $("#direc").val();
    var numero = $("#numero").val();
    var tipoviacomplemento = $("#tipoviacomplemento").val();
    var direccioncomplementaria = $("#direccioncomplementaria").val();
    
    if(via == 0){
        
       via = ''; 
    }
    
    if(tipoviacomplemento == 0){
        
       tipoviacomplemento = '' ;
    }
       
    $("#direccionP").val(via + " " + direc + " " + numero + " " +  tipoviacomplemento + " " + direccioncomplementaria); 
    
});