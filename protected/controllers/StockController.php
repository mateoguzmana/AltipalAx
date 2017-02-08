<?php

class StockController extends CController {

    public function actions() {
        return array(
            'quote' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string $symbol  the symbol of the stock
     * @param string $toto  toto
     * @return string  the stock price
     * @soap
     */
    public function getPrice($symbol, $toto = 'toto') {
        $prices = array('IBM' => 100, 'GOOGLE' => 111);
        $return = isset($prices[$symbol]) ? $prices[$symbol] : 0;
        return $return . ' ' . $toto;
    }

    /**
     * @return string  Dato desde 
     * @soap
     */
    public function getNombre() {
        return "Dato desde el servidor";
    }

    /**
     * @param string $toto  toto
     * @return string  the stock price
     * @soap
     */
    public function setNombre($cadena) {
        if ($cadena) {
            return $cadena;
        } else {
            return "No se pudo retornar un valor";
        }
    }

}
