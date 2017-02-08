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
    
    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
           
          $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');  
          $('#_alertaRecargarPagina').modal('show');
          return false;
        }
    });


});

$('body').on('click','.ok',function(){
    
   location.reload(); 
});




$('#retornarMenuNoventas').click(function() {

    $('#_alertConfirmationMenu .text-modal-body').html('Ésta seguro que desea salir del modulo de no ventas ?');
    $('#_alertConfirmationMenu').modal('show');

});




$('#_alertaSucessNoVenta #sucess').html('Se registro una no venta para este cliente satisfactoriamente !');
$('#_alertaSucessNoVenta').modal('show');




$("#formNoventas").submit(function() {

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


    document.getElementById("formNoventas").submit();
});


function oe(){
    
     document.getElementById("ErrorNoventa").innerHTML = "";
    
} 


$('#btnRecibosCaja').click(function() {
        $('#alertaCarteraPendiente').modal('hide');
        $('#alertaFrmRecibosCaja').modal('show');
});

 
$('#recaudarFacturaSi').click(function() {
        var zona = $("#ZonaVentas").val();
        var cluentaCliente = $("#Cliente").val();
        
        alert(zona);
         alert(cluentaCliente);

        //window.location.href = "index.php?r=Recibos/index&cliente=" + cluentaCliente + "&zonaVentas=" + zona;
 });
 
 $('#recaudarFacturaNo').click(function() {
        $('#alertaFrmRecibosCaja').modal('hide');
        $('#alertaFrmRecibosCajaNo').modal('show');
    });