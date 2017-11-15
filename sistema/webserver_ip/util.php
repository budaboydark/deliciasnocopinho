<?php
	/*
	* Funcao para colocar mascaras de cnpj, cpf, cep, telefone e data
	* @param $mask => informa o tipo de mascara ex: 
	* 	$cnpj = '17804682000198';
	*	echo Mask("##.###.###/####-##",$cnpj);
	*	$cpf = '21450479480';
	*	echo Mask("###.###.###-##",$cpf);
	*	$cep = '36970000';
	*	echo Mask("#####-###",$cep);
	*	$telefone = '3391922727';
	*	echo Mask("(##)####-####",$telefone);
	*	$data = '21072014';
	*	echo Mask("##/##/####",$data);
	* @param $str => string com o numero que vai receber a mascara
	*/
	function Mask($mask,$str){

		$str = str_replace(" ","",$str);
	
		for($i=0;$i<strlen($str);$i++){
			$mask[strpos($mask,"#")] = $str[$i];
		}
	
		return $mask;
	
	}
	
	function NossoNumero($codigo,$datavc=NULL){
		
		$dias_prazo = 5;
		$vencimento = date("Y-m-d", time() + ($dias_prazo * 86400));
		$vencimento = implode('-',array_reverse(explode('/',$vencimento)));
		$vencimento = str_replace("-","","$vencimento");
		
		$numero = 0;
		while(strlen($numero)< 17){
			if(strlen($numero)==6){				
				$numero = $numero.$codigo;
			}elseif(strlen($numero)>6)
			{
				$numero =  $numero . 0;
			}else{
				$numero =  0 . $numero ;	
			}	
		}	
		if(!$datavc){
			$nossonumero = $vencimento.$numero;
		}else{
			$datavc = str_replace('-','',$datavc);
			$nossonumero = $datavc.$numero;
		}	
		
		return $nossonumero;
	}
	
	function GerarChaveControle($cod_des,$cod_guia){
		$chavenum = rand(10,99);
		$cod_des_guia = $cod_des;
		while(strlen($cod_des_guia)< 4)
			$cod_des_guia = 0 . $cod_des_guia;
		$cod_doc = $cod_guia;
		while(strlen($cod_doc)< 4)
			$cod_doc = 0 . $cod_doc;
		$chavecontroledoc = $chavenum.$cod_des_guia.$cod_doc; 
		return $chavecontroledoc;
	}

?>