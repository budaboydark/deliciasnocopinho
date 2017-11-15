<?php
	$arr['descricao'] = "";

	$listaServicos = getAtividade($arr);
	echo "<pre>";
	$cont = 0;
	foreach($listaServicos as $_listaServicos){
		//print_r($listaServicos);
		$aliquota = number_format(floatval($_listaServicos->iss_variavel), 2, '.', '');
		$descricaoNaozuada = utf8_decode($_listaServicos->descricao);
		
		$query = $con->prepare("SELECT id FROM servicosip WHERE id = '".$_listaServicos->id."'");
		$query->execute();
		if($query->rowCount() == 0){
			
			$qnt = $con->exec("INSERT INTO servicosip SET id = '".$_listaServicos->id."', id_subgrupo = '".$_listaServicos->id_subgrupo."', cod_atividade = '".$_listaServicos->cod_atividade."', descricao = '".$descricaoNaozuada."', aliquota = '".$aliquota."'");
			if($qnt > 0){
				$cont++;
			}
		}
	}
	
	echo "SERVICOS INSERIDOS: ".$cont;
	
	/*$query = $con->prepare("SELECT descricao FROM servicos LIMIT 15");
	$query->execute();
	$contEx = 0;
	$diferente = 0;
	while($dados = $query->fetch(PDO::FETCH_ASSOC)){
		$arr['descricao'] = utf8_encode($dados['descricao']);
		$listaServicos = getAtividade($arr);
		if($listaServicos != ""){
			$contEx++;
		}else{
			$diferente++;
		}
	}
	
	//echo "<br />SERVI&Ccedil;OS IP: ".$cont;
	echo "<br />SERVI&Ccedil;OS MYSQL: ".$query->rowCount();
	echo "<br />CONT EXTRA: ".$contEx." ---- DIFERENTES: ".$diferente;*/
	
	die("<br />Ambiente de testes: SERVI&Ccedil;OS");
?>