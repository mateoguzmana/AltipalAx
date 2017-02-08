<?php

$xml=new DomDocument("1.0","UTF-8");

$raiz=$xml->createElement("Panel");
$raiz=$xml->appendChild($raiz);

$header=$xml->createElement("Header");
$header=$raiz->appendChild($header);
 
$SalesAreaCode=$xml->createElement("SalesAreaCode", "564654");
$SalesAreaCode=$header->appendChild($SalesAreaCode);
 
$AdvisorCode=$xml->createElement("AdvisorCode", "056-154");
$AdvisorCode=$header->appendChild($AdvisorCode);

$xml->formatOut=true;
 
$strings_xml=$xml->saveXML();
 
if($xml->save("NotasCredito.xml")){
  echo "Termino de crear el xml.";
}else{
  echo "No pudimos guardar el xml.";
}

?>