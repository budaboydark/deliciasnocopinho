<?php

function getAtividade($array = array()) {
    $clws = new ws_class_connect();
    $url = 'sistemas/multi24/webservices/tributacao/nfse/atividades/index';
    $metodo = 'getAtividades';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $xml = new SimpleXMLElement('<?xml version="1.0" ?><atividade/>');
    
    foreach($array as $key=>$value){
        $xml->addChild($key, $value);
    }
    $dom = dom_import_simplexml($xml)->ownerDocument;
    $dom->formatOutput = true;
    $ret = $clws->connecta(array($dom->saveXML()));
    return $ret;
}

?>
