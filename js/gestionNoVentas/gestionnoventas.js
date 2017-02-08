jQuery(document).ready(function() {


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


});


$("#retornarMenuGestionNoventas").click(function (){
    
   $('#_alertConfirmationMenuGestionClientesNoventas .text-modal-body').html('Ésta seguro que desea salir del modulo de gestion no ventas ?');
   $('#_alertConfirmationMenuGestionClientesNoventas').modal('show'); 
    
});


$('#_alertaGestionSucessNoVenta #sucess').html('Se registro una no venta para este cliente satisfactoriamente !');
$('#_alertaGestionSucessNoVenta').modal('show');

$("#formGestionNoventas").submit(function() {

    var txtmotivonoventa = $("#txtmotivonoventa").val();

    var ErrorNoventa = document.getElementById('ErrorNoventa');

    if (txtmotivonoventa == "") {

        ErrorNoventa.innerHTML = "<font color='red'>Por favor seleccione un motivo no venta</font>";
        return false;

    } else {

        $('#_alertConfirmation #confirm').html('Está seguro de registrar la no venta en este momento');
        $('#_alertConfirmation').modal('show');
        return false;

    }

});

$("#btnEnviarFormNoVentas").click(function() {


    document.getElementById("formGestionNoventas").submit();
});


function oe(){
    
     document.getElementById("ErrorNoventa").innerHTML = "";
    
} 


$('#btnRecibosCajaNoVentas').click(function() {
        $('#alertaCarteraPendiente').modal('hide');
        $('#alertaFrmRecibosCaja').modal('show');
});

 
$('#recaudarFacturaSiNoVenta').click(function() {
        var zona = $("#ZonaVentas").val();
        var cluentaCliente = $("#Cliente").val();
        
        
        window.location.href = "index.php?r=Recibos/index&cliente=" + cluentaCliente + "&zonaVentas=" + zona;
 });
 
 $('#recaudarFacturaNoVenta').click(function() {
        $('#alertaFrmRecibosCaja').modal('hide');
        $('#alertaFrmRecibosCajaNo').modal('show');
    });