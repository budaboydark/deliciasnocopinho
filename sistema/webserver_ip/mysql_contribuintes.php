<?php
$sitAti = array('1', '2', '3', '8', '9');
echo "<pre>";

//Lista todos os contribuintes do banco da IP
//$arr[] = 12;
$contribuintesAtualizados = 0;
$novosContribuintes = 0;
$listaCadastros = getContribuintePorCadastro();
foreach ($listaCadastros as $_listaCadastros) {

    print_r($_listaCadastros);
	//Verifica se o cadastro existe no banco do mysql
    $query = $con->prepare("SELECT codigo FROM cadastro WHERE codigo = ?");
    $query->bindValue(1, $_listaCadastros->numero_cadastro);
    $query->execute();
	
	if (strlen($_listaCadastros->cpf_cnpj) > 11) {
		$cnpj = Mask('##.###.###/####-##', $_listaCadastros->cpf_cnpj);
		$cpf = "";
	} else {
		$cnpj = "";
		$cpf = Mask('###.###.###-##', $_listaCadastros->cpf_cnpj);
	}

    if ($query->rowCount() > 0) {

		//Atualiza os campos do contribuinte no mysql
        if($_listaCadastros->fantasia != ""){
            $razaosocial = $_listaCadastros->fantasia;
        }else{
			$razaosocial = $_listaCadastros->nome;
		}
		
		/**
		* Lucas - 06/09/2013
		* Devido a solicitacao do Jonatas Weber, o middleware nao atualizara alguns dados dos contribuintes, para que ele possa controlar esses dados pelo SEP
		* CAMPOS REMOVIDOS DO UPDATE: codtipodeclaracao, email, isentoiss, logradouro, numero, municipio, complemento, bairro, cep, uf, estado, 
		* fonecomercial, fonecelular
		*/
        $query = ("UPDATE cadastro SET nome = ?, razaosocial = ?, cnpj = ?, cpf = ?, inscrestadual = ?, pispasep = ?, datafim = ? WHERE codigo = ?");
        //echo $query;

        $query = $con->prepare($query);

		$query->bindValue(1, $_listaCadastros->nome);
		$query->bindValue(2, $razaosocial);
		$query->bindValue(3, $cnpj);
		$query->bindValue(4, $cpf);
		$query->bindValue(5, $_listaCadastros->inscricao_estadual);
		$query->bindValue(6, $_listaCadastros->pis_pasep);
		$query->bindValue(7, $_listaCadastros->encerrado_data);
		$query->bindValue(8, $_listaCadastros->numero_cadastro);
		$query->execute();
		
        $contribuintesAtualizados++;
		
    } else {

        //Adiciona o contribuinte no mysql
        if (!$_listaCadastros->nome_completo) {
            $nome = $_listaCadastros->nome;
        }

        if (!$_listaCadastros->nome_fantasia) {
            $razaosocial = $nome;
        }
        if ($_listaCadastros->contador === 't') {
            $codtipo = '10';
        } else {
            $codtipo = '1';
        }
		
        /*
         * INCLUSAO DE TIPO DECLARACAO NO BANCO DE DADOS MYSQL... REFERENCIAS NO INICIO DO CODIGO.
		 * codigo   situacao atividade      
		 * 1        Isento de Imposto
		 * 2        Simples Nacional
		 * 3        MEI
		 * 8        S.Simples fora munic
		 * 9        Encerrado
		*/
		$isentoiss = "N";
        if (in_array($_listaCadastros->situacao_atividade, $sitAti)) {
            if ($_listaCadastros->situacao_atividade === '9') {
                $codtipodeclaracao = '2'; // CONVENCIONAL
                $status = 'I'; // INATIVO
            } elseif ($_listaCadastros->situacao_atividade === '3') {
                $codtipodeclaracao = '4'; // MEI
            } elseif ($_listaCadastros->situacao_atividade === '2') {
                $codtipodeclaracao = '3'; // SIMPLES NACIONAL
            } elseif ($_listaCadastros->situacao_atividade === '1') {
                $codtipodeclaracao = '2'; // CONVENCIONAL
                $isentoiss = 'S'; // ISENTO DE ISS
            }else{
				$codtipodeclaracao = '2';
			}
        } else {
            $codtipodeclaracao = '2'; // CONVENCIONAL
        }
		
		$codContador = 0;
        $senha = md5("123456");

        $query = ("INSERT INTO cadastro (email, codigo, codtipo, codtipodeclaracao, nome, razaosocial, cnpj, cpf, senha, inscrestadual, inscrmunicipal, isentoiss, logradouro, numero, complemento, bairro, cep, municipio, uf, estado, codcontador, nfe, fonecomercial, pispasep, datafim) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //echo $query;
		
        $query = $con->prepare($query);

		$query->bindValue(1, $_listaCadastros->email);
		$query->bindValue(2, $_listaCadastros->numero_cadastro);
		$query->bindValue(3, $codtipo);
		$query->bindValue(4, $codtipodeclaracao);
		$query->bindValue(5, $nome);
		$query->bindValue(6, $razaosocial);
		$query->bindValue(7, $cnpj);
		$query->bindValue(8, $cpf);
		$query->bindValue(9, $senha);
		$query->bindValue(10, $_listaCadastros->inscricao_estadual);
		$query->bindValue(11, $_listaCadastros->numero_cadastro);
		$query->bindValue(12, $isentoiss);
		$query->bindValue(13, $_listaCadastros->nome_rua);
		$query->bindValue(14, $_listaCadastros->imovel_numero);
		$query->bindValue(15, $_listaCadastros->imovel_complemento);
		$query->bindValue(16, $_listaCadastros->nome_bairro);
		$query->bindValue(17, $_listaCadastros->imovel_cep);
		if($_listaCadastros->nome_cidade != ""){
			$municipio = $_listaCadastros->nome_cidade;
		}else{
			$municipio = "BOM PRINCIPIO";
		}
		$query->bindValue(18, $municipio);
		if($_listaCadastros->estado != ""){
			$uf = $_listaCadastros->estado;
		}else{
			$uf = "RS";
		}
		$query->bindValue(19, $uf);
		if($_listaCadastros->encerrado == "t"){
			$status = "I";
		}else{
			$status = "A";
		}
		$query->bindValue(20, $status);
		if($_listaCadastros->cpf_cnpj_contador != ""){
			if(strlen($_listaCadastros->cpf_cnpj_contador) > 11){
				$campo = "cnpj";
				$cpfcnpj = Mask('##.###.###/####-##', $_listaCadastros->cpf_cnpj);
			}else{
				$campo = "cpf";
				$cpfcnpj = Mask('###.###.###-##', $_listaCadastros->cpf_cnpj);
			}
			$queryContador = $con->prepare("SELECT codigo FROM cadastro WHERE $campo = ?");
			$queryContador->bindValue(1, $cpfcnpj);
			$queryContador->execute();
			$dadosContador = $queryContador->fetch(PDO::FETCH_ASSOC);
			$codContador = $dadosContador['codigo'];
		}
		$query->bindValue(21, $codContador);
		$query->bindValue(22, "S");
		//$telefone = Mask('(##)####-####', $_listaCadastros->telefone);
		$query->bindValue(23, $_listaCadastros->telefone);
		$query->bindValue(24, $_listaCadastros->pis_pasep);
		$query->bindValue(25, $_listaCadastros->encerrado_data);
		$query->execute();
		
		$novosContribuintes++;
		
    }
	
	//Adiciona os socios que ainda nao estao no banco mysql e estao vinculados aos contribuintes
	$arrSoc[] = (int) $_listaCadastros->numero_cadastro;
	$socios = getContribuinteSocios($arrSoc);
	foreach($socios as $_socios){
		
		if($_socios->proprietario_principal == "t"){
			$codcargo = "1";
		}else{
			$codcargo = "3";
		}
		
		if(strlen($_listaCadastros->tipopessoa) > "J"){
			$cnpjcpfSocio = Mask('##.###.###/####-##', $_socios->cpf_cnpj);
		}else{
			$cnpjcpfSocio = Mask('###.###.###-##', $_socios->cpf_cnpj);
		}
		
		$query = $con->prepare("SELECT codigo FROM cadastro_resp WHERE codemissor = ? AND cpf = ?");
		$query->bindValue(1, $_listaCadastros->numero_cadastro);
		$query->bindValue(2, $cnpjcpfSocio);
		$query->execute();
		$qntResultados = $query->rowCount();
		if($qntResultados == 0){
			
			$qntSociosInseridos = $con->exec("INSERT INTO cadastro_resp SET codemissor = '".$_listaCadastros->numero_cadastro."', codcargo = '".$codcargo."', nome = '".$_socios->nome."', cpf = '".$cnpjcpfSocio."'");
			
		}	
	}
    
    die("<br /><br />Ambiente de teste:CONTRIBUINTE");
}
?>