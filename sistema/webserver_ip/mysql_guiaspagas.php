<?php
	echo "<pre>";
	
	//Verifica se o cadastro existe no banco do mysql
	$query = $con->prepare("SELECT codigo, codlivro, codnota FROM guia_pagamento WHERE pago = 'N' AND estado <> 'C'");
	$query->execute();
	$qntGuias = $query->rowCount();
	$guias_atualizadas = 0;
	if($qntGuias > 0){
		
		while($dados = $query->fetch(PDO::FETCH_ASSOC)){
			
			$arrGuias['conhecimento'] = (int) $dados['codigo'];
			$dadosGuia = getDebitosSituacoes($arrGuias);
			if($dadosGuia != ""){
				
				//Verifica se a guia
				if($dadosGuia->conhecimento->situacao == "P"){
					
					$guias = $con->exec("UPDATE guia_pagamento SET pago = 'S' WHERE codigo = '".$dados['codigo']."'");
					
					if($dados['codnota'] != ""){
						$notas = $con->exec("UPDATE notas SET estado = 'D' WHERE codigo = '".$dados['codnota']."'");
					}else{
						
						$query = $con->prepare("SELECT n.codigo AS codnota FROM notas AS n INNER JOIN livro_notas AS ln ON n.codigo = ln.codnota WHERE ln.codlivro = ? AND n.estado <> 'E' AND n.estado <> 'C'");
						$query->bindValue(1, $dados['codlivro']);
						$query->execute();
						$qntNotas = $query->rowCount();
						if($qntNotas > 0){
							while($dadosNota = $query->fetch(PDO::FETCH_ASSOC)){
								$notas = $con->exec("UPDATE notas SET estado = 'E' WHERE codigo = '".$dadosNota['codnota']."'");
							}
						}	
					}
					
					$guias_atualizadas++;
				}
				
			}
			
		}
		
	}
	
	die("Ambiente de testes: GUIAS");			
?>