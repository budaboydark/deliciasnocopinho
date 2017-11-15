<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('DataVencimento')) {

    function DataVencimento() {
        $dias_prazo = 5;
        return date("Y-m-d", time() + ($dias_prazo * 86400));
    }

}
if (!function_exists('gerarSenha')) {

    function geraSenha($tamanho, $maiusculas, $numeros, $simbolos) {
        //$lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        //$caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;
        if ($simbolos)
            $caracteres .= $simb;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

}

if (!function_exists('proximoDiaVencimento')) {

    function proximoDiaVencimento($mes = NULL, $ano = NULL, $dia = NULL) {
        if (!$dia) {
            $dia = 10;
        }
        if ($mes != "" && $ano != "") {
            $dataemissao = date($ano . "-" . $mes . "-" . $dia);
            $datavencimento = strtotime("$dataemissao +1 month");
        } else {
            $dataemissao = date("Y-m-10");
            $datavencimento = strtotime("$dataemissao +1 month");
        }
        $vencimentof = date('Y-m-d', $datavencimento);

        $diasemana = diasemana($vencimentof);
        if ($diasemana == 0) {//domingo 
            $vencimentof = strtotime("$vencimentof +1 day");
        } elseif ($diasemana == 6) { //sabado
            $vencimentof = strtotime("$vencimentof +2 day");
        } else {
            $vencimentof = strtotime($vencimentof);
        }


        $vencimentof = date('Y-m-d', $vencimentof);
        return $vencimentof;
    }

}
if (!function_exists('diasemana')) {

    function diasemana($data) {
        $ano = substr("$data", 0, 4);
        $mes = substr("$data", 5, -3);
        $dia = substr("$data", 8, 9);
        return $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    }

}


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
        // sÃ¡bado = 6;
        // verifica sÃ¡bado e domingo

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

}

if (!function_exists('diasDecorridos')) {

    function diasDecorridos($dataInicio, $dataFim, $pt = NULL) {
        if (!isset($pt)) {
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
        } else {
            //define data inicio
            $dataInicio = explode("/", $dataInicio);
            $ano1 = $dataInicio[0];
            $mes1 = $dataInicio[1];
            $dia1 = $dataInicio[2];

            //define data fim
            $dataFim = explode("/", $dataFim);
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

        $segdecimal = $segundos_diferenca / (60 * 60 * 24);

        //tira os decimais aos dias de diferenca
        $dias_diferenca = floor($dias_diferenca);

        return $dias_diferenca;
        //return $timestamp2.' - '.$timestamp1.'-'.$segdecimal;
    }

}


if (!function_exists('calculaMultaDes')) {

    function calculaMultaDes($diasDec, $valor, $iddebito) {
        $CI = & get_instance();


        $CI->db->select('*');
        $CI->db->where(array('estado' => 'A', 'dias <' => $diasDec));
        $qmultas = $CI->db->get('pref_guias_multas')->result_array();
        $nroMultas = count($qmultas);


        $n = 0;
        foreach ($qmultas as $dmultas) {
            $multadias[$n] = $dmultas['dias'];
            $multavalor[$n] = $dmultas['multa'];
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

        $CI->db->set('valor_multa', $multatotal)->where('id', $iddebito)->update('pref_debitos');
        // calcula juros
        $qjuros = $CI->db->select('*')->where(array('estado' => 'A', 'dias <' => $diasDec))->from('pref_guias_juros')->get()->result_array();
        $nroJuros = count($qjuros);
        $nroJuros;
        $n = 0;
        foreach ($qjuros as $djuros) {
            $jurosdias[$n] = $djuros['dias'];
            $jurosvalor[$n] = $djuros['juro'];
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
            $CI->db->set('valor_juros', $jurostotal)->where('id', $iddebito)->update('pref_debitos');
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

if (!function_exists('gerar_nossonumero')) {

    function gerar_nossonumero($codigo, $datavc = NULL) {
        $numero = $codigo;
        while (strlen($numero) < 9) {
            $numero = "0" . $numero;
        }

        $datavc = str_replace('-', '', $datavc);
        $dataEmissao = date("Ymd");
        $nossonumero = $datavc . $dataEmissao . $numero;

        return $nossonumero;
    }

    /*
      function gerar_nossonumero($codigo, $datavc = NULL) {
      $vencimento = DataVencimento();
      $vencimento = DataMysql($vencimento);
      $vencimento = str_replace("-", "", "$vencimento");
      $numero = 0;
      while (strlen($numero) < 17) {
      if (strlen($numero) == 6) {
      $numero = $numero . $codigo;
      } elseif (strlen($numero) > 6) {
      $numero = $numero . 0;
      } else {
      $numero = 0 . $numero;
      }
      }
      if (!$datavc) {
      $nossonumero = $vencimento . $numero;
      } else {
      $datavc = str_replace('-', '', $datavc);
      $nossonumero = $datavc . $numero;
      }

      return $nossonumero;
      }
     */
}

/**
 * Entra no formato DD/MM/AAAA e sai AAAA-MM-DD
 * @param string $data data em formato DD/MM/AAAA
 * @return string data em formado AAAA-MM-DD
 */
if (!function_exists('DataMysql')) {

    function DataMysql($data) {
        return implode('-', array_reverse(explode('/', $data)));
    }

}
if (!function_exists('DataReverse')) {

    function DataReverse($data) {
        $dt = substr($data, -2, 2) . '-' . substr($data, 0, 4);
        return $dt;
    }

}
if (!function_exists('DataReversePT')) {

    function DataReversePT($data) {
        $dt = substr($data, -2, 2) . '/' . substr($data, 0, 4);
        return $dt;
    }

}

/**
 * Entra no formato AAAA-MM-DD  e sai DD/MM/AAAA  
 * @param string $data data em formado AAAA-MM-DD
 * @return string data em formato DD/MM/AAAA
 */
if (!function_exists('DataPt')) {

    function DataPt($data) {
        return implode('/', array_reverse(explode('-', $data)));
    }

}
if (!function_exists('cnpj_mask')) {

    function cnpj_mask($cnpj) {
        $cnpj = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
        return $cnpj;
    }

}

/**
 * Converte de Decimal para Moeda
 * @param $valor float valor para ser convertido
 * @return string valor em moeda
 */
if (!function_exists('MoedaToDec')) {

    function MoedaToDec($valor) {
        return number_format($valor, 2, ',', '.');
    }

}
/*if (!function_exists('DecToMoeda')) {

    function DecToMoeda($valor) {
        return number_format($valor, 2, '.', ',');
    }

}
*/
if (!function_exists('DataVencimento')) {

    function DataVencimento() {
        $dias_prazo = 5;
        return date("Y-m-d", time() + ($dias_prazo * 86400));
    }

}

if(!function_exists('mes')){
    function mes($mes){
        
        $meses['01'] = 'Janeiro';
        $meses['02'] = 'Fevereiro';
        $meses['03'] = 'Mar&ccedil;o';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Maio';
        $meses['06'] = 'Junho';
        $meses['07'] = 'Julho';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Setembro';
        $meses['10'] = 'Outubro';
        $meses['11'] = 'Novembro';
        $meses['12'] = 'Dezembro';
        
        
        return $meses[$mes];
        
        
    }
}



if (!function_exists('DataExtenso')) {

    function DataExtenso($data) {
        
        if($data){
            
        }else{
            $data = date('Y-m-d');
        }
        $dt = explode('-',$data);
        
        $dte = $dt[2].' de '.mes($dt[1]).' de '.$dt[0];
        
        return $dte;
    }

}
?>