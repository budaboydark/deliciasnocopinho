<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nusoap
 *
 * @author Rafa
 */
class CI_Nusoap {

    function __construct() {
        require_once ('nusoap/nusoap' . EXT);
    }

    function request($user_arq, $url, $login, $senha, $body) {

        $soapclient = new nusoap_client($url, 'wsdl', '10.0.0.1', '3128');
        $soapclient->setCredentials($senha, $login, 'basic');
        $soapclient->soap_defencoding = 'ISO-8859-1';
        //$soapclient->soap_defencoding = 'UTF-8';
        $error = $soapclient->getError();
        if ($error) {
            $er = "<h2>Constructor error</h2><pre>" . $error . "</pre>";
            return $er;
            exit;
        }
        $msg = $soapclient->serializeEnvelope($body);
        $result = $soapclient->send($msg);
        $valida = false;
        if ($soapclient->fault) {
            echo "<h2>Fault</h2><pre>";
            print_r($result);
            echo "</pre>";
        } else {
            $error = $soapclient->getError();
            if ($error) {
                echo "<h2>Error(Erro)</h2><pre>" . $error . "</pre>";
                echo '<h2>Request(Requisi&ccedil;&atilde;o)</h2><pre>' . htmlspecialchars($soapclient->request, ENT_QUOTES) . '</pre>';
                echo '<h2>Response(Resposta)</h2><pre>' . htmlspecialchars($soapclient->response, ENT_QUOTES) . '</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';
            } else {
                $valida = true;
            }
        }
        if ($valida) {
            //echo '<pre>';
            echo '<h2>Request (Requisi&ccedil;&atilde;o)</h2><pre>' . htmlspecialchars($soapclient->request, ENT_QUOTES) . '</pre>';
            echo utf8_encode($result['return']);
            var_dump($result);
            echo '<br />Conex&atilde;o Estabelecida';
            //echo '</pre>';
        } else {
            echo '<pre>';
            print_r($valida);
            echo '</pre>';
        }
    }

}
