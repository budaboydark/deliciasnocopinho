<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('DecToMoeda')) {

    function DecToMoeda($valor) {
        return number_format($valor, 2, ',', '.');
    }

}
if (!function_exists('geraCodigoDeBarras')) {

    function geraCodigoDeBarras($valor) {
        $fino = 1;
        $largo = 3;
        $altura = 50;
        $barcodes[0] = "00110";
        $barcodes[1] = "10001";
        $barcodes[2] = "01001";
        $barcodes[3] = "11000";
        $barcodes[4] = "00101";
        $barcodes[5] = "10100";
        $barcodes[6] = "01100";
        $barcodes[7] = "00011";
        $barcodes[8] = "10010";
        $barcodes[9] = "01010";
        for ($f1 = 9; $f1 >= 0; $f1--) {
            for ($f2 = 9; $f2 >= 0; $f2--) {
                $f = ($f1 * 10) + $f2;
                $texto = "";
                for ($i = 1; $i < 6; $i++) {
                    $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
                }
                $barcodes[$f] = $texto;
            }
        }
//Desenho da barra
//Guarda inicial
        ?>
        <img src=<?php echo base_url(); ?>assets/boleto/img/p.gif width=<?= $fino ?> height=<?= $altura ?> border=0><img 
            src=<?php echo base_url(); ?>assets/boleto/img/b.gif width=<?= $fino ?> height=<?= $altura ?> border=0><img 
            src=<?php echo base_url(); ?>assets/boleto/img/p.gif width=<?= $fino ?> height=<?= $altura ?> border=0><img 
            src=<?php echo base_url(); ?>assets/boleto/img/b.gif width=<?= $fino ?> height=<?= $altura ?> border=0><img 
            <?php
            $texto = $valor;
            if ((strlen($texto) % 2) <> 0) {
                $texto = "0" . $texto;
            }

// Draw dos dados
            while (strlen($texto) > 0) {
                $i = round(esquerda($texto, 2));
                $texto = direita($texto, strlen($texto) - 2);
                $f = $barcodes[$i];
                for ($i = 1; $i < 11; $i+=2) {
                    if (substr($f, ($i - 1), 1) == "0") {
                        $f1 = $fino;
                    } else {
                        $f1 = $largo;
                    }
                    ?>
                    src=<?php echo base_url(); ?>assets/boleto/img/p.gif width=<?= $f1 ?> height=<?= $altura ?> border=0><img 
                    <?php
                    if (substr($f, $i, 1) == "0") {
                        $f2 = $fino;
                    } else {
                        $f2 = $largo;
                    }
                    ?>
                    src=<?php echo base_url(); ?>assets/boleto/img/b.gif width=<?= $f2 ?> height=<?= $altura ?> border=0><img 
                    <?php
                }
            }

// Draw guarda final
            ?>
            src=<?php echo base_url(); ?>assets/boleto/img/p.gif width=<?= $largo ?> height=<?= $altura ?> border=0><img 
            src=<?php echo base_url(); ?>assets/boleto/img/b.gif width=<?= $fino ?> height=<?= $altura ?> border=0><img 
            src=<?php echo base_url(); ?>assets/boleto/img/p.gif width=<?= 1 ?> height=<?= $altura ?> border=0> 
        <?php
    }

}

//Fim da fun��o
if (!function_exists('esquerda')) {

    function esquerda($entra, $comp) {
        return substr($entra, 0, $comp);
    }

}
if (!function_exists('direita')) {

    function direita($entra, $comp) {
        return substr($entra, strlen($entra) - $comp, $comp);
    }

}
if (!function_exists('modulo_10')) {

    function modulo_10($num) {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // v�rias linhas removidas, vide fun��o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

}
if (!function_exists('formata_numero')) {

    function formata_numero($numero, $loop, $insert, $tipo = "geral") {
        if ($tipo == "geral") {
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "valor") {
            /*
              retira as virgulas
              formata o numero
              preenche com zeros
             */
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "convenio") {
            while (strlen($numero) < $loop) {
                $numero = $numero . $insert;
            }
        }
        return $numero;
    }

}
if (!function_exists('codtipo')) {

    function codtipo($tipo) {
        $sql_cargo = mysql_query("SELECT codigo FROM tipo WHERE tipo LIKE '$tipo'");
        return mysql_result($sql_cargo, 0);
    }

}

//pega o codigo do tipo solicitado de acordo com o banco
if (!function_exists('gerar_nossonumero')) {

    function gerar_nossonumero($convenio, $codigo, $loop = 25) {
        $numero = $codigo;
        while (strlen($numero) + strlen($convenio) < $loop) {
            $numero = 0 . $numero;
        }
        $nossonumero = $convenio . $numero;
        return $nossonumero;
    }

}

//Entra no formato AAAA-MM-DD  e sai DD/MM/AAAA  
/* if (!function_exists('DataPt')) {

  function DataPt($data) {
  return implode('/', array_reverse(explode('-', $data)));
  }

  } */
/*
  if (!function_exists('diasDecorridos')) {

  function diasDecorridos($dataInicio, $dataFim, $pt = NULL) {
  if (!isset($pt)) {
  //define data inicio
  $dataInicio = explode("/", $dataInicio);
  $ano1 = $dataInicio[2];
  $mes1 = $dataInicio[1];
  $dia1 = $dataInicio[0];

  //define data fim
  $dataFim = explode("/", $dataFim);
  $ano2 = $dataFim[2];
  $mes2 = $dataFim[1];
  $dia2 = $dataFim[0];
  } else {
  //define data inicio
  $dataInicio = explode("-", $dataInicio);
  $ano1 = $dataInicio[0];
  $mes1 = $dataInicio[1];
  $dia1 = $dataInicio[2];

  //define data fim
  $dataFim = explode("-", $dataFim);
  $ano2 = $dataFim[0];
  $mes2 = $dataFim[1];
  $dia2 = $dataFim[2];
  }

  //calcula timestam das duas datas
  $timestamp1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
  $timestamp2 = mktime(0, 0, 0, $mes2, $dia2, $ano2);

  //diminue a uma data a outra
  $segundos_diferenca = $timestamp2 - $timestamp1;
  //echo $segundos_diferenca;
  //converte segundos em dias
  $dias_diferenca = $segundos_diferenca / (60 * 60 * 24);

  //tira os decimais aos dias de diferenca
  $dias_diferenca = floor($dias_diferenca);

  return $dias_diferenca;
  }

  }
  if (!function_exists('calculaMultaDes')) {

  function calculaMultaDes($diasDec, $valor) {

  $sql_multas = mysql_query("
  SELECT
  codigo,
  dias,
  multa
  FROM
  multas
  WHERE
  estado='A'
  AND
  dias<='$diasDec'
  ORDER BY
  dias
  ASC
  ");
  $nroMultas = mysql_num_rows($sql_multas);
  $n = 0;
  while (list($multa_cod, $multa_dias, $multa_valor) = mysql_fetch_array($sql_multas)) {
  $multadias[$n] = $multa_dias;
  $multavalor[$n] = $multa_valor;
  $n++;
  }

  if ($diasDec > 0)
  $multa = 0;
  else
  $multa = -1;

  for ($c = 0; $c < $nroMultas; $c++) {
  if ($diasDec >= $multadias[$c]) {
  $multa = $c;
  if ($multa <= $nroMultas - 1)
  $multa++;
  }//end if
  }//end for

  if ($multa >= 0) {
  $multatotal += $valor * ($multavalor[$multa - 1] / 100);
  $totalpagar += $multatotal + $valor;
  }



  // calcula juros
  $sql_juros = mysql_query("
  SELECT
  codigo,
  dias,
  juro
  FROM
  juros
  WHERE
  estado='A'
  AND
  dias <= '$diasDec'
  ORDER BY
  dias
  ASC
  ");
  $nroJuros = mysql_num_rows($sql_juros);

  $n = 0;
  while (list($juros_cod, $juros_dias, $juros_valor) = mysql_fetch_array($sql_juros)) {
  $jurosdias[$n] = $juros_dias;
  $jurosvalor[$n] = $juros_valor;
  $n++;
  }

  if ($diasDec > 0)
  $juros = 0;
  else
  $juros = -1;

  for ($c = 0; $c < $nroJuros; $c++) {
  if ($diasDec >= $jurosdias[$c]) {
  $juros = $c;
  if ($juros <= $nroJuros - 1) {
  $juros++;
  }
  }//end if
  }//end for

  if ($juros >= 0) {

  for ($m = 0; $m < $n; $m++) {
  $jurostotal += $valor * ($jurosvalor[$m] / 100);
  }
  $mesdescontados = 30 * $m;
  $diasrestantes = $diasDec - $mesdescontados;
  $mesesrestantes = floor($diasrestantes / 30);
  for ($x = 0; $x < $mesesrestantes; $x++) {
  $jurostotal += $valor * ($jurosvalor[$m - 1] / 100);
  }
  }
  $total = $jurostotal + $multatotal;
  if ($total) {
  return $total;
  } else {
  return "";
  }
  //echo $jurostotal.'--'.$diasDec;
  }

  }

  /**
 * funcao UltDiaUtil
 * @param $mes = mes no formato de numero
 * @param $ano = o numero do ano atual ou o que for desejado
 * @return Ultimo dia util do mes subsequente e ano informados
 */
/*
  if (!function_exists('UltDiaUtil')) {

  function UltDiaUtil($mes, $ano, $var = NULL) {
  //$mes = date("m");
  //$ano = date("Y");
  if (!$var) {
  $mes = $mes + 1;
  }
  while ($mes > 12) {
  $mes -= 12;
  $ano = $ano + 1;
  }
  $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  $ultimo = mktime(0, 0, 0, $mes, $dias, $ano);
  $dia = date("j", $ultimo);
  $dia_semana = date("w", $ultimo);

  // domingo = 0;
  // sábado = 6;
  // verifica sábado e domingo

  if ($dia_semana == 0) {
  $dia--;
  $dia--;
  }
  if ($dia_semana == 6) {
  $dia--;
  }

  $ultimo = mktime(0, 0, 0, $mes, $dia, $ano);

  return date("Y-m-d", $ultimo);
  }

  } */
?>
