<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Integra&ccedil;&atilde;o</title>
</head>

<body>

<?php
//Arquivos de metodos para acesso ao banco da IP
include('ws_class_connect.php');
include('ws_atividades.php');
include('ws_contribuinte.php');
include('ws_debitos.php');
include('ws_divida.php');
include('ws_contadores.php');
include('util.php');

//Conexao ao banco do mysql
include('mysql_connect.php');

$con = new conecta_mysql();
$con = $con->conecta_mysql();

/*$query = $con->prepare("SELECT * FROM cadastro WHERE codigo = '900000000'");
$query->execute();
$dados = $query->fetch(PDO::FETCH_ASSOC);*/

echo "\n\n Integracao iniciada: ".date("d/m/Y H:i:s")."\n\n";

echo "\n\n Progresso: [          ] 0% \n";

//Verifica se as atividades estao sincronizadas entre o banco da ip e o mysql
include("mysql_servicos.php"); //Nao utilizado por causa da diferenca no cadastro dos servicos

echo "\n Progresso: [---       ] 30% \n";
 
//Verifica se a tabela de cadastro esta em branco, caso esteja, adiciona todos do sistema da IP, caso ja tenha algum atualiza os que ja tem e adiciona os novos
//include("mysql_contribuintes.php");

echo "\n Progresso: [------    ] 60% \n";

//Lista as guias nao pagas do mysql e verifica uma por uma atravez do numero de conhecimento se elas ja estao pagas no sistema da IP
//include("mysql_guiaspagas.php");

echo "\n Progresso: [-------   ] 75% \n";

//Adiciona uma data de inicio aos cadastros que nao possuirem uma para que nao haja conflito na hora do contribuinte usar o sistema e-nota
//include("mysql_atualizadatas.php");

echo "\n Progresso: [----------] 100%";
echo "\n Integracao Finalizada: ".date("d/m/Y H:i:s")."\n\n";
echo "\n\n Novos Contribuintes: ".$novosContribuintes." \nContribuintes Atualizados: ".$contribuintesAtualizados." \nGuias Atualizadas: ".$guias_atualizadas;
?>

</body>
</html>