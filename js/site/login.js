/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#btnValidarIdentificacion').click(function(){
    var txtIdentificacion=$('#txtIdentificacion').val();   
    
    $.ajax({
        data: {
            "txtIdentificacion":txtIdentificacion          
        },
        url: 'index.php?r=site/AjaxValidarIdentificacion',
        type: 'post',
        success: function(response) {
           if(response == 1){
               window.location.href="index.php?r=site/inicio";
           }
           else{
                $('#Accesodenegado').modal('show');
           }
        }
    });
    
});

$('#btnReset').click(function(){
    window.location.href="index.php";
});