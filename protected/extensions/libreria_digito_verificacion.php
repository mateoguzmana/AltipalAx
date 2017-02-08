<?php

class libreria_digito_verificacion {

    public function calcular_digito($codcliente) {

        $longitud = strlen($codcliente);
        $ceros = 11 - $longitud;

        $empieza = $ceros + 1;
        $cad = 0;
        $cadena = $codcliente;
        for ($i = $empieza; $i <= 11; $i++) {

            $array[$i] = $cadena[$cad];

            $cad = $cad + 1;
        }
        $vector[1] = 47;
        $vector[2] = 43;
        $vector[3] = 41;
        $vector[4] = 37;
        $vector[5] = 29;
        $vector[6] = 23;
        $vector[7] = 19;
        $vector[8] = 17;
        $vector[9] = 13;
        $vector[10] = 7;
        $vector[11] = 3;

        $suma = 0;
        for ($z = 1; $z <= 11; $z++) {

            if ($array[$z] == '') {
                
            } else {
                $multiplicacion = $array[$z] * $vector[$z];

                $suma = $suma + $multiplicacion;
            }
        }
        $division = $suma / 11;

        $entero = floor($division);

        $parteenteraporonce = $entero * 11;

        $resultadoparcial = $suma - $parteenteraporonce;


        if ($resultadoparcial == 0 or $resultadoparcial == 1) {
            $digito = $resultadoparcial;
        } else {
            $digito = 11 - $resultadoparcial;
        }

        return $digito;
    }

}

?>