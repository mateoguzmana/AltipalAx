<?php
 $pregunta = Consultas::model()->getPreguntasEncuestaId($siguientePregunta); 

 
?>
<h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5>                                                  
<table class="table table-striped" id="pregunta-respuesta">
    <?php foreach ($pregunta as $itemPreguntas) { ?>  
        <tr>
            <td>
                <span class="glyphicon glyphicon-question-sign"></span>   
                <?php echo $itemPreguntas['respuesta']; ?>
            </td>
            <td><?php
                if ($itemPreguntas['IdCampo'] == 1) {
                    ?>
                    <input data-respuesta="<?php echo $itemPreguntas['IdRespuesta']; ?>" data-siguiente-pregunta="<?php echo $itemPreguntas['IdSiguientePregunta']; ?>" type="radio" name="clienteNuevo[respuesta]" value="<?php echo $itemPreguntas['IdRespuesta']; ?>" class="item-respuestas"><br>
                    <?php
                }
                ?>                                                          
            </td>
        </tr>
    <?php } ?>
</table>      
