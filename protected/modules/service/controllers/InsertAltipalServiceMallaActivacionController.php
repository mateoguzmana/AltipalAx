<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class InsertAltipalServiceMallaActivacionController extends Controller
{
    
    
    public function actions()
    {
        return array(
            'Insert'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
    }    
    
    /*
     * se crea la funcion para el llamado de la zona de ventas
     * @param string $cadena estructura
     * @soap
     */
    
    public  function getZonaVentasGlobales($cadena){
        
      $zonaVentasGloables =ServiceAltipal::model()->getZonaVentasGlo();
        
      $cadena='<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<Zona>';  
        foreach ($zonaVentasGloables as $item){
            $cadena.='<ZonaVentasItem>';               
            $cadena.='<zonaventas>';
            $cadena.=$item['CodZonaVentas'];
            $cadena.='</zonaventas>';
            $cadena.='</ZonaVentasItem>';
        }
        $cadena.='</Zona>';  
        
        
        return $cadena;        
      
    }
    
}

