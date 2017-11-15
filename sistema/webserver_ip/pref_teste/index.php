<?php
	$HOST = "10.0.0.7";
	$USUARIO = "root";
	$SENHA = "";
	$BANCO = "pmbomprincipio";

	$conectar_pref = mysql_connect($HOST,$USUARIO, $SENHA);
	$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
	
	$codigolivro	= 2030;
	$codemissor		= 12164;
	$sql_livro		= mysql_query("SELECT * FROM livro WHERE codigo = '$codigolivro'");
	$dados_livro	= mysql_fetch_array($sql_livro);
	$hoje           = date("Y-m-d");
	$dataem         = explode("-",$hoje);

	$multa = 0;
	
	$vencimento = $dados_livro["vencimento"];
	/*
	* Lucas 09/04/2012
	* Alteracao referente ao chamado 3344, a data de vencimento da guia deve ser a mesma do livro
	*/
	//$vencimentoguia = UltDiaUtil($vencimento[1],$vencimento[0],true);
	$vencimentoguia = $dados_livro["vencimento"];
	
	//Carrega a pagina que realiza a integracao do sistema
	require("../mysql_adicionardebito.php");
?>