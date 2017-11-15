<?php

function ativaNotaFiscalEletronica($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'ativaNotaFiscalEletronica';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuintePorCnpj($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuintePorCnpj';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuintePorCadastro($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuintePorCadastro';
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getDebitosAbertos($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getDebitosAbertos';
    /*
     * Retorna os dados dos débitos abertos de um contribuinte pelo seu número de cadastro. Débitos estes retornarão corrigidos.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getDebitosMes($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getDebitosMes';
    /*
     * Retorna os débitos abertos de um contribuinte em um determinado mês. Os dados possíveis para filtro são
     * numero_cadastro, divida, ano, mês. Débitos estes não serão corrigidos.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuinteAtividades($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuinteAtividades';
    /*
     * 	Retorna as atividades de um determinado cadastro pelo seu número de cadastro. Se nenhum numero_cadastro for
     * 	informado, todas as atividades de todos os cadastros serão retornadas.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuinteSocios($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuinteSocios';
    /*
     * 	Retorna os sócios de todos os cadastros, pode ou não receber o número de cadastro para filtro.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuintePorCpf($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuintePorCpf';
    /*
     * 	Retorna os dados de um contribuinte baseado no CPF. Dados esses são resgatados de uma store procedure já definida
     * 	no schema nfse com nome de sp_consulta_contribuinte_cpf
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getContribuintePorUnico($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getContribuintePorUnico';
    /*
     * 	Retorna os dados de um contribuinte baseado no Código Único. Dados esses são resgatados de uma store procedure
     * 	já definida no schema nfse com nome de sp_consulta_contribuinte_unico
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function lancarSemMovimentoMes($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'lancarSemMovimentoMes';
    /*
     * 	Define como sem movimento no mês para um contribuinte.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

function getImoveisPorUnico($array = array()) {
    $clws = new ws_class_connect();
    $metodo = 'getImoveisPorUnico';
    /*
     * 	Retorna os imóveis de um determinado contribuinte pelo seu código único. Se nenhum id_unico for informado, todos
     * 	os imóveis serão retornados.
     */
    $url = 'sistemas/multi24/webservices/tributacao/nfse/contribuinte/index';
    $clws->setLink($url);
    $clws->setMetodo($metodo);
    $ret = $clws->connecta($array);
    return $ret;
}

?>
