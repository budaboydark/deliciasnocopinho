<?php

include('ws_class_connect.php');
include('ws_atividades.php');
include('ws_contribuinte.php');
include('ws_debitos.php');
include('ws_divida.php');
include('ws_contadores.php');
//$array['descricao'] = 'IND.ARTEF.CIMENTO,COM.VAREJ.MAT.CONSTR. E PREST.SERV. MONTAGEM PAVLH.CONCRETO';
$array['exercicio'] = '2015' ;
$var = getAtividade($array);
var_dump($var);

/*
$array['conhecimento'] = 886781;
var_dump(getDebitosSituacoes($array));
*/

//var_dump(getContribuintePorUnico($array = array(3725)));
/*
$array[] = 1;
$cadastro = getContribuintePorCadastro($array);
var_dump($cadastro);

foreach($cadastro as $contribuinte){
    
}

echo $contribuinte->nome;
$arr[] = (int) $contribuinte->id_unico;
var_dump(getAtividade($arr));
*/



//$array['numero_cadastro'] = 4; 
//$dados =  getParametros($array = array(4));
//$dados =  getDividas();
//var_dump($dados);

/*
$retorno = getByConhecimento(array(28074530));
var_dump($retorno);
echo $retorno->id;
*/
/*
 $acao  = ativaNotaFiscalEletronica($array);
var_dump($acao); // Metodo de Ativação de um cadastro
 * 
 */

//var_dump(getContribuintePorCnpj(array(90873118000206)));

/*
$ret = getContribuintePorCadastro(array(4));
foreach ($ret->contribuinte as $contribuinte) {
    echo '<br />';
    var_dump($contribuinte);
    var_dump(getContribuinteAtividades(array(4)));
}
$array['divida'] = 4;
$array['ano_debito'] = 2016;
$array['numero_parcela'] = 1;
$array['valor'] = 150.00;
$array['situacao_auxiliar'] = '';
$array['data_vencimento'] = '2016-01-18';
$array['valor_faturado'] = 300.00;
*/

//var_dump(incluirDebito($array));



?>
