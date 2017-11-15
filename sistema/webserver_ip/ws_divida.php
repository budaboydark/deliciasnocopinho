<?php

function getDividas($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getDividas';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/divida/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getParametros($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getParametros';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/divida/index';
    /*
     * 	Retorna dados de configuração de emissão de boleto de uma dívida.
     */
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

?>
