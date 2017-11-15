<?php

function getContadores($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContadores';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contador/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

?>
