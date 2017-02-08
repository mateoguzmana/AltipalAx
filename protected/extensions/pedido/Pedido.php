<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pedido {

    private $arrayAux;
    private $precio;
    private $cantidad;
    private $impoconsumo;
    private $descuentoProveedor;
    private $descuentoAltipal;
    private $descuentoEspecial;
    private $iva;
    private $valorSinImpoconsumo;
    private $valorDescuentoProveedor;
    private $valorDescuentoAltipal;
    private $valorDescuentoEspecial;
    private $valorDescuentos;
    private $precioNeto;
    private $precioIva;
    private $valorNetoUnitario;
    private $valorNeto;
    private $valorImpoconsumo;
    private $totalValorPrecioNeto;
    private $totalValorDescuentoProveedor;
    private $totalValorDescuentoAltipal;
    private $totalValorDescuentoEspecial;
    private $totalValorDescuentos;
    private $totalValorBaseIva;
    private $totalValorIva;
    private $totalValorImpoconsumo;
    private $toatalvalorBruto;
    private $valorProducto;

    public function __construct() {
        
    }

    public function getCalcularTotales() {
        $session = new CHttpSession;
        $session->open();

        $pedidoForm = $session['pedidoForm'];

        $arrayTotales = array();
        foreach ($pedidoForm as $itemPedidoForm) {

            $this->arrayAux = $itemPedidoForm;
            $this->precio = $itemPedidoForm['valorUnitario'];
            $this->cantidad = $itemPedidoForm['cantidad'];
            $this->impoconsumo = $itemPedidoForm['impoconsumo'];
            $this->descuentoProveedor = $itemPedidoForm['descuentoProveedor'];
            $this->descuentoAltipal = $itemPedidoForm['descuentoAltipal'];
            $this->descuentoEspecial = $itemPedidoForm['descuentoEspecial'];
            $this->iva = $itemPedidoForm['iva'];

            $this->arrayAux['valorSinImpoconsumo'] = $this->calculaValorImpoconsumo();
            $this->arrayAux['valorDescuentoProveedor'] = $this->caculaValorDescuentoProveedor();
            $this->arrayAux['valorDescuentoAltipal'] = $this->caculaValorDescuentoAltipal();
            $this->arrayAux['valorDescuentoEspecial'] = $this->caculaValorDescuentoEspecial();
            $this->arrayAux['valorDescuentos'] = $this->calculaValorDescuestos();
            $this->arrayAux['precioNeto'] = $this->calculaPrecioNeto();
            $this->arrayAux['precioIva'] = $this->calculaValorIva();
            $this->arrayAux['valorNetoUnitario'] = $this->calculaValorNetoUnitario();
            $this->arrayAux['valorNeto'] = $this->calculaValorNeto();
            $this->arrayAux['precio'] = $itemPedidoForm['valorUnitario'];
            $this->arrayAux['valorImpoconsumo'] = $this->calculaTotalImpoconsumo();
            $this->arrayAux['totalValorPrecioNeto'] = $this->calculaTotalValorPrecioNeto();
            $this->arrayAux['totalValorDescuentoProveedor'] = $this->calculaTotalValorDescuentoProveedor();
            $this->arrayAux['totalValorDescuentoAltipal'] = $this->calculaTotalValorDescuentoAltipal();
            $this->arrayAux['totalValorDescuentoEspecial'] = $this->calculaTotalValorDescuentoEspecial();
            $this->arrayAux['totalValorDescuentos'] = $this->calculaTotalValorDescuentos();
            $this->arrayAux['totalValorbaseIva'] = $this->calculaTotalValorBaseIva();
            $this->arrayAux['totalValorIva'] = $this->calculaTotalValorIva();
            $this->arrayAux['totalValorImpoconsumo'] = $this->calculaTotalValorImpoconsumo();
            $this->arrayAux['toatalvalorBruto'] = $this->calcularTotalvalorbruto();
            $this->arrayAux['valorProducto'] = $this->calculaValorProducto();


            array_push($arrayTotales, $this->arrayAux);
        }

        $session['pedidoForm'] = $arrayTotales;
    }

    private function calculaValorImpoconsumo() {

        $this->valorSinImpoconsumo = $this->precio;
        return $this->valorSinImpoconsumo;
    }

    public function caculaValorDescuentoProveedor() {
        $this->valorDescuentoProveedor = ( $this->valorSinImpoconsumo * $this->descuentoProveedor) / 100;
        return $this->valorDescuentoProveedor;
    }

    public function caculaValorDescuentoAltipal() {
        $this->valorDescuentoAltipal = ( ($this->valorSinImpoconsumo - $this->valorDescuentoProveedor) * $this->descuentoAltipal) / 100;
        return $this->valorDescuentoAltipal;
    }

    public function caculaValorDescuentoEspecial() {
        $this->valorDescuentoEspecial = ( ($this->valorSinImpoconsumo - $this->valorDescuentoProveedor - $this->valorDescuentoAltipal) * $this->descuentoEspecial) / 100;
        return $this->valorDescuentoEspecial;
    }

    public function calculaValorDescuestos() {
        $this->valorDescuentos = ($this->valorDescuentoProveedor + $this->valorDescuentoAltipal + $this->valorDescuentoEspecial);
        return $this->valorDescuentos;
    }

    public function calculaPrecioNeto() {
        $this->precioNeto = $this->precio * $this->cantidad;
        return $this->precioNeto;
    }

    public function calculaValorIva() {

        $this->precioIva = $this->precioNeto * ($this->iva / 100);
        return $this->precioIva;
    }

    public function calculaValorNetoUnitario() {
        $this->valorNetoUnitario = $this->precioNeto + $this->precioIva + $this->impoconsumo;
        return $this->valorNetoUnitario;
    }

    public function calculaValorNeto() {
        $this->valorNeto = (($this->baseIvaUnitario() + $this->impoconsumo + $this->IvaUnitario()) - $this->valorDescuentoEspecial) * $this->cantidad;
        return $this->valorNeto;
    }

    public function calculaValorProducto() {
        $this->valorProducto = (($this->baseIvaUnitario() + $this->impoconsumo + $this->IvaUnitario()) - $this->valorDescuentoEspecial);
        return $this->valorProducto;
    }

    private function baseIvaUnitario() {
        return $this->precio - $this->valorDescuentoProveedor - $this->valorDescuentoAltipal;
    }

    private function IvaUnitario() {
        return ($this->precio - $this->valorDescuentoProveedor - $this->valorDescuentoAltipal) * ($this->iva / 100);
    }

    public function calculaTotalImpoconsumo() {
        $this->valorImpoconsumo = $this->impoconsumo * $this->cantidad;
        return $this->valorImpoconsumo;
    }

    public function calculaTotalValorPrecioNeto() {
        $this->totalValorPrecioNeto = $this->precio * $this->cantidad;
        return $this->totalValorPrecioNeto;
    }

    public function calculaTotalValorDescuentoProveedor() {
        $this->totalValorDescuentoProveedor = $this->valorDescuentoProveedor * $this->cantidad;
        return $this->totalValorDescuentoProveedor;
    }

    public function calculaTotalValorDescuentoAltipal() {
        $this->totalValorDescuentoAltipal = $this->valorDescuentoAltipal * $this->cantidad;
        return $this->totalValorDescuentoAltipal;
    }

    public function calculaTotalValorDescuentoEspecial() {
        $this->totalValorDescuentoEspecial = (float) $this->valorDescuentoEspecial * $this->cantidad;
        return $this->totalValorDescuentoEspecial;
    }

    public function calculaTotalValorBaseIva() {
        $this->totalValorBaseIva = ($this->precio - $this->valorDescuentoProveedor - $this->valorDescuentoAltipal) * $this->cantidad;
        return $this->totalValorBaseIva;
    }

    public function calculaTotalValorIva() {
        $this->totalValorIva = (($this->precio - $this->valorDescuentoProveedor - $this->valorDescuentoAltipal) * ($this->iva / 100)) * $this->cantidad;
        return $this->totalValorIva;
    }

    public function calculaTotalValorImpoconsumo() {
        $this->totalValorImpoconsumo = $this->impoconsumo * $this->cantidad;
        return $this->totalValorImpoconsumo;
    }

    public function calculaTotalValorDescuentos() {
        $this->totalValorDescuentos = $this->valorDescuentos * $this->cantidad;
        return $this->totalValorDescuentos;
    }

    public function calcularTotalvalorbruto() {

        $this->toatalvalorBruto = $this->precio * $this->cantidad;
        return $this->toatalvalorBruto;
    }

}
