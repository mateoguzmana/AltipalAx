<?php
function Conectarse() 
{ 
    if (!($link=mysql_connect("localhost","altipalbd14ax","xSon4WkbFpkhx"))) 
   { 
      echo "<h2 align='center'>ERROR:Imposible establecer conexion con el servidor.</h2>"; 
      exit(); 
   } 
  if (!mysql_select_db("Altipal_bdax",$link)) 
   { 
      echo "Error la base de datos."; 
      exit(); 
   } 
   return $link; 
}

$link=Conectarse();


function Conectarse_pereira($usuario,$clave,$bd,$sitio) 
{ 
    if (!($link=mysql_connect($sitio,$usuario,$clave))) 
   { 
      //echo "<h2 align='center'>ERROR:Imposible establecer conexion con el servidor.</h2>"; 
	  return "NO"; 
      exit(); 
   } 
  if (!mysql_select_db($bd,$link)) 
   { 
     // echo "Error la base de datos."; 
	  return "NO"; 
      exit(); 
   } 
   return $link; 
}
?>


<html>

<head>
<title>MONITOR ACTIVITY</title>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" oncontextmenu="return false">
<script language="JavaScript">
 
    //setTimeout("location.href='monitor_activity.php'", 120000);
//	 setTimeout("location.href='monitor_activity1.php'", 20000);
  
  </script>

  <?	

$consulta4 = "SELECT Usuario,Password,BaseDatos,CodAgencia FROM `agencia` WHERE CodAgencia = '002' ";
$rrs6=mysql_query($consulta4,$link);	
while($renglonusu4=mysql_fetch_row($rrs6))
{
	$usuario = trim($renglonusu4[0]);
	$clave = trim($renglonusu4[1]);
	$bd = trim($renglonusu4[2]);
	$sitio =  trim($renglonusu4[4]);	
	$link_pereira=Conectarse_pereira($usuario,$clave,$bd,$sitio);
		/*echo "SELECT SUM(cantidad) FROM `descripcion_pedido` WHERE id_producto = '065024' AND id_pedido IN(SELECT id_pedido FROM `pedidos` WHERE fecha_pedido = curdate())<br>";*/
		echo $bd."<br>";
$rs_pedidossindetalles=mysql_query("SELECT * FROM `pedidos` WHERE FechaPedido >= '2015-05-27'",$link_pereira) or die(mysql_error);
while($rs_pedidossindetalles1=mysql_fetch_row($rs_pedidossindetalles))

		{
			
      $MaxIdPedido=mysql_query("SELECT MAX(IdPedido) AS Conteo FROM `pedidos`",$link_pereira);   
      $MaxIdPedido=mysql_result($MaxIdPedido,0,"Conteo");     
      $MaxIdPedido++;
      mysql_query("INSERT INTO `pedidos`(`IdPedido`, `Conjunto`, `CodAsesor`, `CodZonaVentas`, `CuentaCliente`, `CodGrupoVenta`, `CodGrupoPrecios`,
       `CodigoSitio`, `CodigoAlmacen`, `FechaPedido`, `HoraDigitado`, `HoraEnviado`, `FechaEntrega`, `FormaPago`, `Plazo`, `TipoVenta`, `ActividadEspecial`,
        `Observacion`, `NroFactura`, `ValorPedido`, `TotalPedido`, `TotalValorIva`, `TotalSubtotalBaseIva`, `TotalValorImpoconsumo`, `TotalValorDescuento`, 
        `Estado`, `ArchivoXml`, `FechaTerminacion`, `HoraTerminacion`, `EstadoPedido`, `AutorizaDescuentoEspecial`, `Web`, `PedidoMaquina`, `IdentificadorEnvio`, 
        `CodigoCanal`, `Responsable`, `ExtraRuta`, `Ruta`, `Imei`, `CodigoGrupodeImpuestos`, `CodigoZonaLogistica`, `Resolucion`, `Prefijo`) VALUES 
        ('$MaxIdPedido','$rs_pedidossindetalles1[1]','$rs_pedidossindetalles1[2]','$rs_pedidossindetalles1[3]','$rs_pedidossindetalles1[4]','$rs_pedidossindetalles1[5]','$rs_pedidossindetalles1[6]','$rs_pedidossindetalles1[7]',
          '$rs_pedidossindetalles1[8]',CURDATE(),'$rs_pedidossindetalles1[10]','$rs_pedidossindetalles1[11]','$rs_pedidossindetalles1[12]','$rs_pedidossindetalles1[13]','$rs_pedidossindetalles1[14]','$rs_pedidossindetalles1[15]',
          '$rs_pedidossindetalles1[16]','$rs_pedidossindetalles1[17]','$rs_pedidossindetalles1[18]','$rs_pedidossindetalles1[19]','$rs_pedidossindetalles1[20]','$rs_pedidossindetalles1[21]','$rs_pedidossindetalles1[22]','',
          '','$rs_pedidossindetalles1[25]','$rs_pedidossindetalles1[26]','','','$rs_pedidossindetalles1[29]','$rs_pedidossindetalles1[30]','$rs_pedidossindetalles1[31]',
          '$rs_pedidossindetalles1[32]','$rs_pedidossindetalles1[33]','$rs_pedidossindetalles1[34]','$rs_pedidossindetalles1[35]','$rs_pedidossindetalles1[36]','$rs_pedidossindetalles1[37]','$rs_pedidossindetalles1[38]','$rs_pedidossindetalles1[39]',
          '$rs_pedidossindetalles1[40]','$rs_pedidossindetalles1[41]','$rs_pedidossindetalles1[42]')",$link_pereira) or die(mysql_error());

      $rs_pedidossindetallesPedido=mysql_query("SELECT * FROM `descripcionpedido` WHERE IdPedido = '$rs_pedidossindetalles1[0]'",$link_pereira) or die(mysql_error);
while($rs_pedidossindetallesPedido1=mysql_fetch_array($rs_pedidossindetallesPedido))
      {

         mysql_query("INSERT INTO `descripcionpedido`(`IdPedido`, `CodVariante`, `CodigoArticulo`, `NombreArticulo`, `CodigoTipo`, `Cantidad`, `ValorUnitario`, `Iva`, `Impoconsumo`, `CodigoUnidadMedida`, `NombreUnidadMedida`, `CuentaProveedor`, `Saldo`, `DsctoLinea`, `DsctoMultiLinea`, `DsctoEspecial`, `DsctoEspecialAltipal`, `DsctoEspecialProveedor`, `ValorBruto`, `ValorDsctoLinea`, `ValorDsctoMultiLinea`, `ValorDsctoEspecial`, `BaseIva`, `ValorIva`, `ValorImpoconsumo`, `TotalPrecioNeto`, `PedidoMaquina`, `IdentificadorEnvio`, `EstadoTerminacion`, `CodLote`, `IdAcuerdoPrecioVenta`, `IdAcuerdoLinea`, `IdAcuerdoMultilinea`, `Factor`) VALUES 
          ('$MaxIdPedido','$rs_pedidossindetallesPedido1[2]','$rs_pedidossindetallesPedido1[3]','$rs_pedidossindetallesPedido1[4]','$rs_pedidossindetallesPedido1[5]','$rs_pedidossindetallesPedido1[6]',
            '$rs_pedidossindetallesPedido1[7]','$rs_pedidossindetallesPedido1[8]','$rs_pedidossindetallesPedido1[9]','$rs_pedidossindetallesPedido1[10]','$rs_pedidossindetallesPedido1[11]','$rs_pedidossindetallesPedido1[12]','$rs_pedidossindetallesPedido1[13]',
            '$rs_pedidossindetallesPedido1[14]','$rs_pedidossindetallesPedido1[15]','$rs_pedidossindetallesPedido1[16]','$rs_pedidossindetallesPedido1[17]','$rs_pedidossindetallesPedido1[18]','$rs_pedidossindetallesPedido1[19]','$rs_pedidossindetallesPedido1[20]',
            '$rs_pedidossindetallesPedido1[21]','$rs_pedidossindetallesPedido1[22]','$rs_pedidossindetallesPedido1[23]','$rs_pedidossindetallesPedido1[24]','$rs_pedidossindetallesPedido1[25]','$rs_pedidossindetallesPedido1[26]','$rs_pedidossindetallesPedido1[27]',
            '$rs_pedidossindetallesPedido1[28]','$rs_pedidossindetallesPedido1[29]','$rs_pedidossindetallesPedido1[30]','$rs_pedidossindetallesPedido1[31]','$rs_pedidossindetallesPedido1[32]','$rs_pedidossindetallesPedido1[33]','$rs_pedidossindetallesPedido1[34]')",$link_pereira) or die(mysql_error());
      }

        echo "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('1','$MaxIdPedido','$renglonusu4[3]','0')<br>";
        mysql_query("INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('1','$MaxIdPedido','$renglonusu4[3]','0')",$link_pereira) or die(mysql_error());

      //Verificamos si tiene pedidos
			 echo "<pre>"; print_r($rs_pedidossindetalles1);echo "</pre>"; 	
		}	

    /*$rs_pedidossindetalles=mysql_query("SELECT * FROM `transaccionesax` WHERE EstadoTransaccion = '0' AND CodTipoDocumentoActivity = '1'",$link_pereira) or die(mysql_error);
while($rs_pedidossindetalles1=mysql_fetch_row($rs_pedidossindetalles))
    {
      echo "<pre>"; print_r($rs_pedidossindetalles1);echo "</pre>"; 
       mysql_query("UPDATE `pedidos` SET ArchivoXml = '', Estado = '' WHERE IdPedido = '$rs_pedidossindetalles1[1]'",$link_pereira) or die(mysql_error());
    }
*/
    //mysql_query("UPDATE pedidos SET Estado = '0', ArchivoXml = '' WHERE FechaPedido = CURDATE()",$link_pereira) or die(mysql_error());
   
}
?>



</body>
</html>