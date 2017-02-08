

<?php 
 if($code=='403'){
  ?>   

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">          
            <div class="notfoundpanel" style="padding-bottom: 160px;">
                <img src="images/lock.png" style="width: 200px;"/>
    <h3>Usted no tiene permisos suficientes para acceder a este modulo.</h3> 
    <div class="mb40"></div>    
  </div><!-- notfoundpanel -->
        </div>           
         </div>

</div>



<?php
 }else{  
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>

 <?php } ?>

