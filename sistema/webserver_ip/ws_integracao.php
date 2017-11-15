<?php
	/*
	*	Tem como finalidade efetuar a integração dos dados atualizados na prefeitura com a nota fiscal dos registros do base de
	*	ISSQN que tenham a o campo utiliza_nfse = true.
	*	Para que a integração seja ativada, é necessário alterar a configuração Ativar integração na aba Webservice NFS-e das
	*	Configurações Gerais do sistema de Administração Tributária.
	*	Apenas com a integração ativada que os dados inseridos e alterados serão logados na tabela nfse.integracao.
	*/
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

function getIntegracao($ano){
  $function = 'getIntegracao';
  //$namespace = 'xmlns="getByConhecimento"';
  $url = $ip.'/path/sistemas/multi24/webservices/tributacao/nfse/integracao/index';
	/*
	*	Responsável por retornar a relação de serviços no webservice que deverão ser consultados pela nota para atualização
	*	dos dados.
	*/
	/*
	*	Composição  da tabela e exemplo:
		-------------------------------------------------	
		|id	|webservice_metodo 			|chave_pesquisa	|
		-------------------------------------------------
		|1 	|getContribuintePorCadastro |		904		|
		-------------------------------------------------
		|2 	|getContribuinteAtividades 	|		902		|
		-------------------------------------------------
		|3 	|getContribuinteSocios 		|		908		|
		-------------------------------------------------
		|4 	|integracaoUnico 			|		910		|
		-------------------------------------------------	
	*	Os dados acima informam respectivamente que:
	*	1) Houveram alterações de dados cadastrais do contribuinte de cadastro número 904 do ISSQN.
	*	2) Houveram alterações nas atividades do contribuinte de cadastro número 902 do ISSQN.
	*	3) Houveram alterações nos sócios do contribuinte de cadastro número 908 do ISSQN.
	*	4) Houveram alterações nos dados do único do contribuinte de cadastro número 910 do ISSQN.	
	*	Parâmetros Disponíveis:
		_____________________________________________________
		|campo	|Descrição				|Tipo	|Obrigatório|
		-----------------------------------------------------
		|offset | Último id do registro |Integer|não		|
		-----------------------------------------------------
	*/	
    $client = new nusoap_client($url);
    $client->soap_defencoding = 'UTF-8';
	
    $error = $client->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
    //$body = montaBody($function, $namespace, $campos);
    //$msg = $client->serializeEnvelope($body);
    $result = $client->call($function,array());//$client->send($msg);
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
