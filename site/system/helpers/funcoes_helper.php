<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('SendSMS')) {

    /**
     * Função que envia o SMS
     * @return string Mensagem de Sucesso de Envio de SMS
     * @param string $host Host onde foi instalado seu Now SMS
     * @param string $port A Porta que você está usando
     * @param string $username Pode deixar em branco
     * @param string $password Pode deixar em branco
     * @param string $phoneNoRecip Telefone, no formato +55[DDD sem o 0][Telefone, com 8 posições]
     * @param string $msgText Mensagem que deseja enviar, limite em 160 caracteres, senão ele manda quantas mensagens necessárias para atingir o limite.
     */
    function SendSMS($host, $port, $username, $password, $phoneNoRecip, $msgText) {

        $fp = fsockopen($host, $port, $errno, $errstr);
        $res = array('conexao'=>'');
        if (!$fp) {
            echo "errno: ".$errno." \n";
            echo "errstr: ".$errstr." \n";
            return $result;
            $res['erro'] = $result;
        }
        fwrite($fp, "GET /PhoneNumber=" . rawurlencode($phoneNoRecip) . "&Text=" . rawurlencode($msgText) . " HTTP/1.0\n");
        //echo $aux3;
        if ($username != "") {
            $auth = $username . ":" . $password;
            echo "auth: $auth\n";
            $auth = base64_encode($auth);
            echo "auth: $auth\n";
            fwrite($fp, "Authorization: Basic " . $auth . "\n");
        }
        fwrite($fp, "\n");

        

        while (!feof($fp)) {
            $res['conexao'] .= fread($fp, 1);
        }
        fclose($fp);


        return $res;
    }

}
