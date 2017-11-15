<?php
	include('ws_class_connect.php');
	include('ws_debitos.php');
	include('ws_divida.php');
	include('mysql_connect.php');
	include('util.php');
	
	$con = new conecta_mysql();
	$con = $con->conecta_mysql();
	
	echo "<pre>";
	
	//Pega a divida referente ao iss mensal para utilizar no debito
	$dividas = getDividas();
	foreach($dividas as $_divida){
		if($_divida->descricao == "ISS MENSAL"){
			$codDivida = $_divida->id;
		}
	}
	
	//Adiciona um debito
	if(!isset($notaAvulsa)){
		$coddes = $dados_livro['codigo'];
		$codlivro = $dados_livro['codigo'];
		$codnota = "";
		$vencimento = $dados_livro['vencimento'];
		$multa = 0; // Devido ao sistema gerar a guia com a data vencimento do livro, na sera calculado multa, somente em caso de segunda via
		$valor = $dados_livro['valorisstotal'];
		$baseCalculo = $dados_livro['basecalculo'];
		$codigolivro = $dados_livro['codigo'];
		$periodo = $dados_livro['periodo'];
	}else{
		$coddes = $dados_guia['codigo'];
		$codlivro = "";
		$codnota = $dados_guia['codigo'];
		$vencimento = $vencimentoguia;
		$multa = 0;
		$valor = $dados_guia['valoriss'];
		$baseCalculo = $dados_guia['basecalculo'];
		$codigolivro = $dados_guia['codigo'];
		$periodo = substr($dados_guia['datahoraemissao'],0,7);
	}
	
	$ano_debito = substr($periodo, 0, 4);
	$arr_debito['numero_cadastro'] = (int) $codemissor; 
	$arr_debito['divida'] = $codDivida; //Codigo que representa o ISS MENSAL no banco da IP
	$arr_debito['ano_debito'] = (int) $ano_debito; 
	$arr_debito['numero_parcela'] = 1; 
	$arr_debito['valor'] = $valor; //Valor do iss
	$arr_debito['data_vencimento'] = $vencimento; 
	$arr_debito['valor_faturado'] = $baseCalculo; //Base de calculo
	
	$retorno = incluirDebito($arr_debito);
	$novoConhecimento = $retorno->conhecimento;
	
	$arrTeste['conhecimento'] = (int) $novoConhecimento;
	$dadosGuia = getDebitosSituacoes($arrTeste);
	print_r($dadosGuia);
	echo "<br /><br /> ------------------------------------------ <br /><br />";
	
	$nossonumero = NossoNumero($novoConhecimento, $vencimento);
	$chavecontrole = GerarChaveControle($coddes,$novoConhecimento);
	
	if($dadosGuia != ""){
		//Adciona no banco do mysql a guia previamente inserida
		$insert = $con->exec("INSERT INTO guia_pagamento SET dataemissao = NOW(), datavencimento = '$vencimento', valor = '$valor', nossonumero = '$nossonumero', chavecontroledoc = '$chavecontrole', pago = 'N', estado = 'N', codlivro = '$codlivro', codnota = '$codnota'");
		
		if($codlivro != ""){
			$update = $con->exec("UPDATE livro SET estado = 'B' WHERE codigo = '$codlivro'");
		}
	}
	
	
	die("Ambiente de testes: Adicionar Debito");
?>