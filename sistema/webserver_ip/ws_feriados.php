<?php
require_once "lib/nusoap.php";
include_once "ws_conctaws.php";

function montaBody($function, $namespace, $campos) {
	
	if($namespace){
	    $body .= '<' . $function . ' ' . $namespace . ' >'; // inicia o corpo do wsdl
	}else{
		$body .= '<' . $function . '>'; // inicia o corpo do wsdl
	}
    /*
     * monta os campos do wsdl citados acima.
     * 
     */
    foreach ($campos as $key => $value) {
		if(is_array($value)){
			$body .= '<' . $key . '>';
			foreach($value as $k => $v){
				$body .= '<' . $k . '>' . $v . '</' . $k. '>';
			}
			$body .= '</' . $key . '>';
		}else{
        	$body .= '<' . $key . '>' . $value . '</' . $key . '>';
		}
    }
    $body .= '</' . $function . '>'; //Finaliza a montagem do corpo do wsdl
    return $body;
}

function getFeriados($ano){
  $function = 'getFeriados';
  //$namespace = 'xmlns="getByConhecimento"';
  $url = $ip.'/path/sistemas/multi24/webservices/tributacao/nfse/feriado/index';
	/*
	*	Retorna informação dos feriados cadastros no sistema. Se ano não for informado, retornará todos os registros.
	*/
    $client = new nusoap_client($url);
    $client->soap_defencoding = 'UTF-8';
		
    $error = $client->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
    //$body = montaBody($function, $namespace, $campos);
    //$msg = $client->serializeEnvelope($body);
	if($ano){
    	$result = $client->call($function,array($ano));//$client->send($msg);
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

?>
