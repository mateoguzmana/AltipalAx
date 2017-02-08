<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/redmond/jquery-ui.css"/>
<div class="contentpanel">
  <center><h5>MAPA</h5></center>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="btn-group">
        <div class="form-group">
            
        </div>
      </div>
      <div id="gmap_marker" style="height: 600px; position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);">
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  jQuery(document).ready(function() {    
    initialize();
    //  MapsGoogle.init();
  });
  function initialize() {
    var myLatlng = new google.maps.LatLng(6.14784251,-75.62440858);
    var mapOptions = {
      zoom: 4,
      center: myLatlng
    }
    var map = new google.maps.Map(document.getElementById('gmap_marker'), mapOptions);
    
    var contentString = '<div id="div_ejemplo"></div>';
    
    var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 400,
      maxHeight: 1500
    });
    //var point=new google.maps.LatLng(6.14784251,-75.62440858);
    <?php foreach ($coordenadas as $coord) {
        $direccionCliente = $coord['direccion'];
        ?>
      
      var html="<p style='color:black'>Zona Ventas: <?php echo $coord['CodZonaVentas'] ?></p><p style='color:black'>Cliente: <?php echo $coord['CuentaCliente'] ?> </p><p style='color:black'>Fecha: <?php echo $coord['Fecha'] ?></p><p style='color:black'>Hora: <?php echo $coord['Hora'] ?> </p><p style='color:black'>Direccion: <?php echo str_replace("\n","",$direccionCliente); ?> </p>";
      <?php if($coord['Origen'] == '1'){ ?>
      icono = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|a7cafa|000000'; 
      title = 'Pedido';
      <?php }elseif($coord['Origen'] == '4'){ ?>
       icono = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|ff0000|000000';    
       title = 'No Venta';
      <?php } ?>    
      var point=new google.maps.LatLng(<?php echo $coord['Latitud'] ?>, <?php echo $coord['Longitud'] ?>);
      marker = new google.maps.Marker({
        position: point,
        map: map,
        title: title,
        icon: icono
      });
      bindInfoWindow(marker, map, infowindow, html);
    <?php } ?>
  //  var marker = new google.maps.Marker({
  //      position: new google.maps.LatLng(6.14784251,-75.62440858),
  //      map: map,
  //      title: 'Hello World!'
  //  });
    
    
  }
  function bindInfoWindow(marker, map, infowindow, html) { 
   google.maps.event.addListener(marker, 'click', function() { 
    infowindow.setContent(html); 
    infowindow.open(map, marker); 
   }); 
  }

  jQuery(document).ready(function() {    
    google.maps.event.addDomListener(window, 'load', initialize);
  });
</script>