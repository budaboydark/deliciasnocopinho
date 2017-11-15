<?php
require_once "lib/nusoap.php";
include_once "ws_conctaws.php";

function montaBody($function, $namespace, $campos) {
    $body .= '<' . $function . ' ' . $namespace . ' >'; // inicia o corpo do wsdl
    /*
     * monta os campos do wsdl citados acima.
     * 
     */
    foreach ($campos as $key => $value) {
        $body .= '<' . $key . '>' . $value . '</' . $key . '>';
    }
    $body .= '</' . $function . '>'; //Finaliza a montagem do corpo do wsdl
    return $body;
}

function getCorrecaoMonetaria($id = NULL,$nome = NULL,$ano = NULL,$mes = NULL,$ano_inicial = NULL,$ano_final = NULL,$mes_inicial = NULL,$mes_final = NULL){// 
  $function = 'getCorrecaoMonetaria';
  
  //$namespace = 'xmlns="getByConhecimento"';
  /*
  *	Retorna dados de correção monetária e suas alíquotas.
  */
  $url = $ip.'/path/sistemas/multi24/webservices/tributacao/nfse/correcao_monetaria/index';

    $client = new nusoap_client($url);
    $client->soap_defencoding = 'UTF-8';
	
    $error = $client->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
	if($id){
		$campos[0] = $id;
	}    
	if($nome){
		$campos[1] = $nome;
	}    
	if($ano){
		$campos[2] = $ano;
	}    
	if($mes){
		$campos[3] = $mes;
	}    
	if($ano_inicial){
		$campos[4] = $ano_inicial;
	}    
	if($ano_final){
		$campos[5] = $ano_final;
	}    
	if($mes_inicial){
		$campos[6] = $mes_inicial;
	}    
	if($mes_final){
		$campos[7] = $mes_final;
	}    
	
	if($campos){
		$result = $client->call($function,$campos);//$client->send($msg);
	}else{
		$result = $client->call($function);//$client->send($msg);
	}
	
    $valida = false;
    if ($client->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            $valida = true;
        }
    }
	
    if ($valida) {
        return $result; // retorno do metodo getByConhecimento.
    } else {
        return $valida;
    }

}
















function RetornaSituacao($divida,$ip) {

  $function = 'PConsultaDividaSGA.Execute';
  $namespace = 'xmlns="Tributos"';
  $campos['Dividanumero'] = $divida; // teste
  $url = $ip.'/TributosJavaEnvironment/servlet/com.tche.tributos.apconsultadividasga';
  /*
  A = Aberta
  P = Paga
  C = Cancelada
  N = Não Encontrada
  R = Parcelada
 */

    $client = new nusoap_client($url);
    $client->soap_defencoding = 'UTF-8';
    $error = $client->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
    $body = montaBody($function, $namespace, $campos);
    $msg = $client->serializeEnvelope($body);
    $result = $client->send($msg);
    $valida = false;
    if ($client->fault) {

        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            $valida = true;
        }
    }
    if ($valida) {
        return $result;
    } else {
        return $valida;
    }
    
}
function DeclaraISS($function, $namespace, $campos, $url) {
    $client = new nusoap_client($url);
    $client->soap_defencoding = 'UTF-8';
    $error = $client->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
    $body = montaBody($function, $namespace, $campos);
    $msg = $client->serializeEnvelope($body);
    $result = $client->send($msg);
    $valida = false;
    if ($client->fault) {

        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $client->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            /* echo "<h2>Enviado</h2><pre>";
              echo $guia;
              echo "<h2>resposta</h2>";
              echo 'situa&ccedil;&atilde;o = ' . $result["Situacao"];
              echo "</pre>";
              /* variaveis que iram receber os dados via webservice.
              $numerodivida = $result["NumeroDivida"];
              $arquivo = $result["Arquivo"];
             * 
             */
            $valida = true;
        }
    }
    if ($valida) {
        return $result;
    } else {
        return $valida;
    }
}

?>
