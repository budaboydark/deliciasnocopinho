<?php

function getByConhecimento($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getByConhecimento';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function incluirDebito($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'incluirDebito';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);

    $xml = new SimpleXMLElement('<?xml version="1.0" ?><debito/>');
    $xml->addChild('numero_cadastro', $array['numero_cadastro']);
    $xml->addChild('divida', $array['divida']);
    $xml->addChild('ano_debito',$array['ano_debito']);
    $xml->addChild('numero_parcela',$array['numero_parcela']);
    $xml->addChild('valor',$array['valor']);
    /*$xml->addChild('situacao_auxiliar', $array['situacao_auxiliar']);*/
    $xml->addChild('data_vencimento', $array['data_vencimento']);
    $xml->addChild('valor_faturado',$array['valor_faturado']);
    /*
    $xml->addChild('taxas');
    $xml->taxa->addChild('id_divida_taxa',2);
    $xml->taxa->addChild('valor',2.30);
     * 
     */
    $dom = dom_import_simplexml($xml)->ownerDocument;
    $dom->formatOutput = true;
    //$ret =  $dom->saveXML();
    $ret = $clws->connecta(array($dom->saveXML()));
    return $ret;
}

function lancarSemMovimento($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'lancarSemMovimento';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function AtualizarConhecimento($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'debito';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getDebitosSituacoes($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getDebitosSituacoes';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $xml = new SimpleXMLElement('<?xml version="1.0" ?><GetDebitosSituacao/>');
    $xml->addChild('conhecimento', $array['conhecimento']);
    $dom = dom_import_simplexml($xml)->ownerDocument;
    $dom->formatOutput = true;
    //$ret =  $dom->saveXML();
    $ret = $clws->connecta(array($dom->saveXML()));
    return $ret;
}

function incluirDebitoPorConhecimento($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'debito';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function gerarGuia($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'gerarGuia';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function incluirDebitoPorGuia($array = array()) {
    $metodo = 'debito';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function cancelarDebito($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'cancelarDebito';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/debitos/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

?>
