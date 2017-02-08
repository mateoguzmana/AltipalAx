
$(function() {

    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function() {
            history.pushState('newjibberish', null, null);
            // Handle the back (or forward) buttons here
            // Will NOT handle refresh, use onbeforeunload for this.
        };
    }
    else {
        var ignoreHashChange = true;
        window.onhashchange = function() {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            }
            else {
                ignoreHashChange = false;
            }
        };
    }
    
    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
           
          $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');  
          $('#_alertaRecargarPagina').modal('show');
          return false;
        }
    });
    
    

 $('#txtFabricante').hide();

});


$('body').on('click','.ok',function(){
    
   location.reload(); 
});



$("#txtResponNota").change(function() {

    if ($("#txtResponNota").val() == 1) {

       /// document.getElementById("txtFabricante").disabled = true;
        $('#txtFabricante').hide();

    } else {
       // document.getElementById("txtFabricante").disabled = false;
        $('#txtFabricante').show();
    }

})


///Aqui esta la funcion que muestra el modal con la rspectiva informacion


function verdetalle() {


    
    var fac = $("#txtFactura").val();
    var fabricante = $('#txtFabricante').val();

     

    if (fac === "") {


        $('#_alerta .text-modal-body').html('Por favor seleccione una factura');
        $('#_alerta').modal('show');
        return;

    }
    
    

        $.ajax({
            data: {
                'fac': fac,
                'fabricante':fabricante
            },
            url: 'index.php?r=NotasCredito/AjaxGenerarDetalle',
            type: 'post',
            beforeSend: function() {

            },
            success: function(response) {
                $('#myModal  .modal-body').html(response);
                $('#myModal').modal('show');

            }
        });


    




}

$('#btnEnviarFormNotasCredito').click(function() {


    var valor = $("#valor").val();
    var obser = $("#observacion").val();
    var responsable = $("#txtResponNota").val();
    var conceptos = $("#txtConcepto").val();
    var factura = $("#txtFactura").val();
    var Fabricante = $("#txtFabricante").val();
    var cliente = $("#cuenta").val();
    var codzona = $("#codzona").val();
    var fot = $("#foto").val();
    var fot1 = $("#foto1").val();
    var fot2 = $("#foto2").val();
    var asesor = $("#codasesor").val();
    var responsablecanal = $("#Responsable").val();
    var canal = $("#canal").val();
    var codagencia = $("#codagencia").val();
    var id=0;

      
    /*if(fot == "" || fot1 == "" || fot2 == ""){
    
     $('#_alerta .text-modal-body').html('Por favor agregue almenos una foto');
     $('#_alerta').modal('show');
     return false;   
    }*/  
      
    var elem = fot.split("\\");
    
     for(var i=0;i<elem.length;i++){
         
         fot = elem[i];
        
    }
    
    
     var elem = fot1.split("\\");
    
     for(var i=0;i<elem.length;i++){
         
         fot1 = elem[i];
        
    }
    
    
    var elem = fot2.split("\\");
    
     for(var i=0;i<elem.length;i++){
         
         fot2 = elem[i];
        
    }
       

    $.ajax({
        data: {
            'valor': valor,
            'responsable': responsable,
            'obser': obser,
            'conceptos': conceptos,
            'factura': factura,
            'Fabricante': Fabricante,
            'cliente': cliente,
            'codzona': codzona,
            'codagencia':codagencia,
            'fot': fot,
            'asesor': asesor,
            'responsablecanal':responsablecanal,
            'canal':canal,
            'fot1':fot1,
            'fot2':fot2
            
        },
        url: 'index.php?r=NotasCredito/AjaxGuardar',
        type: 'post',
        beforeSend: function() {
          $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">...Enviando');
        },
        success: function(response) {
            valor=parseInt(response);
            if (valor>0)
            {
                 id=response;
                 guardarFotosNotas(id);
                 

            } else {

                alert(response);
                $('#_alertNotasCredito').modal('hide');
            }



        }
    });
});

function guardarFotosNotas(id){
    var datos = new FormData();
     $('#_alertNotasCredito').modal('hide');
    datos.append("foto", $("#foto")[0].files[0]); 
    datos.append("foto1", $("#foto1")[0].files[0]);
    datos.append("foto2", $("#foto2")[0].files[0]);
    
    datos.append("factura",$("#txtFactura").val());
    datos.append("cliente",$("#cuenta").val());
    datos.append("codzona",$("#codzona").val());
    datos.append("id", id);
    
  
    
    $.ajax({
        data: datos,
        url: 'index.php?r=NotasCredito/AjaxGuardar',
        type: 'post',
        contentType: false,
        processData: false,
        multiple: true,
        beforeSend: function() {

        },
        success: function(response) {
             
           
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $('#mensaje').modal('show');


        }
    });
}

function guardarnotascredito() {


    var valor = $("#valor").val();
    var obser = $("#observacion").val();
    var responsable = $("#txtResponNota").val();
    var conceptos = $("#txtConcepto").val();
    var factura = $("#txtFactura").val();
    var Fabricante = $("#txtFabricante").val();
    var fot = $("#foto").val();
    var fot1 = $("#foto1").val();
    var fot2 = $("#foto2").val();



    var ErrorFT = document.getElementById('ErrorFT');
    var ErrorRESPO = document.getElementById('ErrorRESPO');

    var ErrorCONCP = document.getElementById('ErrorCONCP');
    var ErrorFAC = document.getElementById('ErrorFAC');
    var ErrorFABR = document.getElementById('ErrorFABR');
    var ErrorVAL = document.getElementById('ErrorVAL');

    var ErrorOBSER = document.getElementById('ErrorOBSER');

    if (fot == "" && fot1 == "" && fot2 == "" ) {

        ErrorFT.innerHTML = "<font color='red'>Por favor seleccione una foto</font>";
         return;

    }
     if (responsable == "") {

        ErrorRESPO.innerHTML = "<font color='red'>Por favor seleccione un responsable</font>";
        return;
        

    }
    if (conceptos == "") {

        ErrorCONCP.innerHTML = "<font color='red'>Por favor seleccione un concepto</font>";
       return;
        

    }
    if (factura == "") {

        ErrorFAC.innerHTML = "<font color='red'>Por favor seleccione una factura</font>";
     return;
         

    }
    if (valor == "") {

        ErrorVAL.innerHTML = "<font color='red'>Por favor digite un valor</font>";
        return;
        


    }
    if (obser == "") {

        ErrorOBSER.innerHTML = "<font color='red'>Por favor digite una observación</font>";
        return;
       

    }


    //var formdata =  new FormData($("form1")[0]);
    if ((responsable == 2)) {

        if (Fabricante == "") {
            ErrorFABR.innerHTML = "<font color='red'>Por favor seleccione un fabricante</font>";
            return;
        }
    }

    if(valor == 0){
        
        ErrorVAL.innerHTML = "<font color='red'>El valor de la nota credito no puede ser 0</font>";
        return;
        
    }


    $('#_alertNotasCredito #confirm').html('Está seguro de registrar la nota credito en este momento ?');
    $('#_alertNotasCredito').modal('show');




}


function recargar() {

    location.reload();

}

function control(f) {
    
     
    document.getElementById("ErrorFT").innerHTML = "";
    
    var ext = ['gif', 'jpg', 'jpeg', 'png'];
    var v = f.value.split('.').pop().toLowerCase();
    for (var i = 0, n; n = ext[i]; i++) {
        if (n.toLowerCase() == v)
            return
    }
    var t = f.cloneNode(true);
    t.value = '';
    f.parentNode.replaceChild(t, f);
    $('#_alerta .text-modal-body').html('El archivo seleccionado no es una imagen');
    $('#_alerta').modal('show');

}


$('#retornarMenuNotaCredito').click(function() {

    $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro que desea salir del modulo de notas credito?');
    $('#_alertConfirmationMenu').modal('show');

});


function FilterInput(event) {

    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;

    document.getElementById("ErrorVAL").innerHTML = "";
    document.getElementById("ErrorOBSER").innerHTML = "";
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


$('.limp').change(function (){
    
     document.getElementById("ErrorRESPO").innerHTML = "";
    $('#txtFactura').find('option:first').attr('selected', 'selected').parent('select');
    $('#valor').val('');
    
});


$('.limpConcep').change(function (){
    
     document.getElementById("ErrorCONCP").innerHTML = "";
    
});


$('.limpFabri').change(function (){
    
     document.getElementById("ErrorFABR").innerHTML = "";
    
});


$('.limpFactu').change(function (){
    
     document.getElementById("ErrorFAC").innerHTML = "";
    
});


function valorfac(){
    
    if($("#txtResponNota").val() == 1){
    
    var fac = $("#txtFactura").val();
    
    $.ajax({
        data: {
            'fac': fac
        
        },
        url: 'index.php?r=NotasCredito/AjaxValorADigita',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
          
           
          $("#valor").val(response);
           document.getElementById("ErrorVAL").innerHTML = "";
         
        }
    });
    
    }
    
}


function valorfacproveedor(){
    
    var fac = $("#txtFactura").val();
    var fabricante = $("#txtFabricante").val();
    
    if(fabricante == 0){
        
        return false;
    }
    
   
    $.ajax({
        data: {
            'fac': fac,
            'fabricante':fabricante
        
        },
        url: 'index.php?r=NotasCredito/AjaxValorADigitarProveedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
          
          $("#valor").val(response);

        }
    });
    
    
    
}
