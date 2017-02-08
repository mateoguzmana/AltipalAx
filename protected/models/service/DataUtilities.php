<?php

/**
 * Created by Activity Technology SAS.
 */
class DataUtilities {

    public function ValidateItemSpecChar($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        return $var2;
    }

    public function ValidateItem1cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '0' : $var2;
        return $var2;
    }

    public function ValidateItem1cero2($var) {
        $var = strtolower(trim($var));
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '0' : $var2;
        return $var2;
    }

    public function ValidateItem2cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var = str_replace($SpecialChar, $ValidChar, $var);
        $var = $var == '' ? '00' : $var;
        return $var;
    }

    public function ValidateItem3cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '000' : $var2;
        return $var2;
    }

    public function ValidateItem4cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '0000' : $var2;
        return $var2;
    }

    public function ValidateItem5cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '00000' : $var2;
        return $var2;
    }

    public function ValidateItem6cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '000000' : $var2;
        return $var2;
    }

    public function ValidateItem7cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '0000000' : $var2;
        return $var2;
    }

    public function ValidateItem8cero($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? '00000000' : $var2;
        return $var2;
    }

    public function ValidateItemEmpty($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? 'EMPTY' : $var2;
        return $var2;
    }

    public function ValidateItemSinDato($var) {
        $var = trim($var);
        $SpecialChar = array("'", "&", '"');
        $ValidChar = array("", "y", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        $var2 = $var2 == '' ? 'Sin Dato' : $var2;
        return $var2;
    }

    public function ValidateItemStringToInt($var) {
        $var = strtolower(trim($var));
        $var = $var == 'falso' ? '0' : $var;
        $var = $var == '' ? '0' : $var;
        $var = $var != '0' ? '1' : $var;
        return $var;
    }

    public function ValidateItemCodigoTipoActivity($var) {
        $var = trim($var);
        $var = $var == '0.00' ? 'OB' : 'R';
        return $var;
    }

    public function ValidateItemFalso($var) {
        $var = trim($var);
        $var = $var == '' ? 'falso' : $var;
        return $var;
    }

    public function ValidateBlankTo1($var) {
        $var = trim($var);
        $var = $var == '' ? '1' : $var;
        return $var;
    }

    public function ValidateItemFalsoL($var) {
        $var = strtolower(trim($var));
        $var = $var == '' ? 'falso' : $var;
        return $var;
    }

    public function ValidateItemFecha($var) {
        $var = trim($var);
        $var = $var == '' ? '0000-00-00' : $var;
        return $var;
    }

    public function ValidateAccountType($var) {
        $var = strtolower(trim($var));
        $var = $var == '' ? '0' : $var;
        $SpecialChar = array("'", "&", "tabla", "grupo", "todo", '"');
        $ValidChar = array("", "y", "1", "2", "3", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        return $var2;
    }

    public function ValidateUnitCode($var) {
        $var = trim($var);
        $var = $var == '' ? '000' : $var;
        $var = strtolower($var);
        //$var = $var == 'unidad' ? '003' : $var;        
        $SpecialChar = array("'", "&", "caja", "display", "unidad", '"');
        $ValidChar = array("", "y", "001", "002", "003", "");
        $var2 = str_replace($SpecialChar, $ValidChar, $var);
        return $var2;
    }

    public function ValidateToLower($var) {
        $var = strtolower(trim($var));
        return $var;
    }

    public function ValidateToUpper($var) {
        $var = strtoupper(trim($var));
        return $var;
    }

}
