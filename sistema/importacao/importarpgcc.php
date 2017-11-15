<?php

$conexao = mysql_connect("localhost", "root");
if ($conexao) {
    mysql_select_db("giban", $conexao) or die("O banco solicitado não pode ser utilizado :  . mysql_error()");
} else {
    echo "não foi possivel estabelecer uma conecção";
}

//========================================

$tabela = "teste"; //tabela do banco
$arquivo = 'pgcc.txt'; // aquivo a ver importado txt ou

$arq = fopen($arquivo, 'r'); // le o arquivo txt

while (!feof($arq)) {
    for ($i = 0; $i < 1; $i++) {
        if ($conteudo = fgets($arq)) {//se extrair uma linha e não for false
            $ll++; // $ll recebe mais 1 ==== em quanto o existir linha sera somada aqui
            $linha = explode('|', $conteudo); // divide por coluna onde tiver pipeline
        } // FIM IF
        //
        // TESTA PRIMEIRA LINHA PARA IDENTIFICACAO DA IF
        // TESTA TIPO DE REGISTRO IGUAL 0000
        if ($linha[1] == "0000") {
            echo " | " . $linha[0] . " | " . " REG " . $linha[1] . " | ";

            //TESTA CNPJ E RAZAO SOCIAL
            $consulta_contribuinte = mysql_query("SELECT id, cnpj, razao_social, data_inicio, data_fim, idcontribuinte_resp_recolhimento FROM pref_contribuintes WHERE cnpj LIKE '%$linha[2]%' AND razao_social LIKE '$linha[3]%'");
            $consulta_contribuinte = mysql_fetch_array($consulta_contribuinte, MYSQL_ASSOC);
            if ($linha[2] == substr($consulta_contribuinte["cnpj"], 0, 8) and $linha[3] == $consulta_contribuinte["razao_social"]) {
                echo "CNPJ " . $linha[2] . " | " . " RS " . $linha[3] . " | TITULO " . $linha[4] . " | ";
            } else {
                echo 'Campo CNPJ e/ou NOME inválido(s): ED001 EG009 ED002 EG009<br />';
                break 2;
            }

            //TESTA CODIGO MUNICIPIO
            if ($linha[5] <> NULL) {
                $consulta_codmunicipio = mysql_query("SELECT pref_configuracoes.idn_cida, pref_abrasf_cidades.nom_cida, pref_abrasf_cidades.sig_uf FROM pref_configuracoes INNER JOIN pref_abrasf_cidades ON pref_configuracoes.idn_cida = pref_abrasf_cidades.idn_cida WHERE pref_configuracoes.idn_cida = $linha[5]");
                $consulta_codmunicipio = mysql_fetch_array($consulta_codmunicipio, MYSQL_ASSOC);
                if ($linha[5] == $consulta_codmunicipio["idn_cida"]) {
                    echo ('CODMUNICIPIO: ' . $linha[5] . ' (' . $consulta_codmunicipio["nom_cida"] . $consulta_codmunicipio["sig_uf"] . ') | ');
                } else {
                    echo 'Campo COD_MUNC inválido(s): EG001 EG008 EG009 <br />';
                    break 2;
                }
            } else {
                echo 'Campo COD_MUNC inválido(s): EG010 <br />';
                break 2;
            }

            //TESTA COMPETENCIA INICIO
            // calculo de ano
            $anoini = substr($linha[6], 0, 4);
            $anoini = date(Y) - $anoini;


            // converte string para data
            $dataini = substr($linha[6], 0, 4) . "-" . substr($linha[6], 5, 2) . "-01";
            sscanf($dataini, "%d-%d", $y, $m);
            //printf( "%d/%d\n", $m, $y );

            $datafim = substr($linha[7], 0, 4) . "-" . substr($linha[7], 5, 2) . "-01";
            sscanf($datafim, "%d-%d", $y, $m);
            //printf( "%d/%d\n", $m, $y );

            $contribuinte_dataini = $consulta_contribuinte["data_inicio"];
            sscanf($contribuinte_dataini, "%d-%d", $y, $m);
            //printf( "%d/%d\n", $m, $y );

            if ($linha[6] == NULL) {
                echo 'Campo ANO_MES_INIC_CMPE inválido: EG007 <br />';
                break 2;
            } elseif (strlen($linha[6]) !== 6) {
                echo 'Campo ANO_MES_INIC_CMPE inválido: EG009 <br />';
                break 2;
            } elseif ($anoini > 10 or $anoini < 0) {
                echo 'Campo ANO_MES_INIC_CMPE inválido: ED004 ED005 <br />';
                break 2;
            } elseif ($dataini > $datafim) {
                echo 'Campo ANO_MES_INIC_CMPE inválido: ED054 <br />';
                break 2;
            } elseif ($dataini < $contribuinte_dataini) {
                echo 'Campo ANO_MES_INIC_CMPE inválido: A002 A007 <br />';
                break 2;
            } else {
                echo 'COMP INI: ' . $linha[6] . " | ";
            }


            //TESTA COMPETENCIA FINAL
            // calculo de ano
            $anofim = substr($linha[7], 0, 4);
            $anofim = date(Y) - $anofim;

            $mesfim = substr($linha[7], 4, 2);

            $contribuinte_datafim = $consulta_contribuinte["data_fim"];
            sscanf($contribuinte_datafim, "%d-%d", $y, $m);
            //printf( "%d/%d\n", $m, $y );

            if ($linha[7] == NULL) {
                echo 'Campo ANO_MES_FIM_CMPE inválido: EG007 <br />';
                break 2;
            } elseif (strlen($linha[7]) !== 6) {
                echo 'Campo ANO_MES_FIM_CMPE inválido: EG009 <br />';
                break 2;
            } elseif ($anofim > 10 or $anofim < 0) {
                echo 'Campo ANO_MES_FIM_CMPE inválido: ED004 ED005 <br />';
                break 2;
            } elseif (($linha[8] == "1" or $linha[8] == "3") and $mesfim !== "12") {
                echo 'Campo ANO_MES_FIM_CMPE inválido: ED052 <br />';
                break 2;
            } elseif ($linha[8] == "2" and $datafim !== $dataini) {
                echo 'Campo ANO_MES_FIM_CMPE inválido: ED023 <br />';
                break 2;
            } else {
                echo 'COMP FIN: ' . $linha[7] . " | ";
            }

            //TESTA MODULO DECLARACAO
            if ($linha[8] == NULL or $linha[8] == " ") {
                echo 'Campo MODU_DECL inválido: ED014 <br />';
                break 2;
            } elseif ($linha[8] !== "1" and $linha[8] !== "2" and $linha[8] !== "3") {
                echo 'Campo MODU_DECL inválido: ED015 EG008<br />';
                break 2;
            } elseif (strlen($linha[8]) !== 1) {
                echo 'Campo MODU_DECL inválido: EG009 <br />';
                break 2;
            } else {
                echo 'MOD DECLARACAO: ' . $linha[8] . " | ";
            }

            //TESTA TIPO DE DECLARACAO
            if ($linha[9] !== "1" and $linha[9] !== "2") {
                echo 'Campo TIPO_DECL inválido: ED006 EG008 <br />';
                break 2;
            } elseif ($linha[9] == NULL or $linha[9] == " ") {
                echo 'Campo MODU_DECL inválido: ED018 <br />';
                break 2;
            } elseif ($linha[8] == "3" and $linha[9] !== "1") {
                echo 'Campo MODU_DECL inválido: ED046 <br />';
                break 2;
            } elseif (strlen($linha[9]) !== 1) {
                echo 'Campo MODU_DECL inválido: EG009 <br />';
                break 2;
            } else {
                echo 'TIPO DECLAR: ' . $linha[9] . " | ";
            }

            //TESTA PROTOCOLO DE DECLARACAO RETIFICADA
            if ($linha[9] == "2" and ($linha[10] == NULL or $linha[10] == " ")) {
                echo 'Campo PRTC_DECL_ANTE inválido: ED024 ED026 <br />';
                break 2;
            } elseif (strlen($linha[10]) > 30) {
                echo 'Campo MODU_DECL inválido: EG009 ED025 <br />';
                break 2;
            }
            if ($linha[9] == "1" and ($linha[10] !== "")) {
                echo 'Campo PRTC_DECL_ANTE inválido: Não deve ser informado para Tipo_Decl igual a 1 (Normal) <br />';
                break 2;
            } else {
                echo 'PROTOCOLO DECL ANT: ' . $linha[10] . " | ";
            }

            //TESTA TIPO DE CONSOLIDACAO            
            if ($linha[8] == "2" and ($linha[11] == NULL or $linha[11] == " ")) {
                echo 'Campo TIPO_CNSO inválido: ED012 <br />';
                break 2;
            } elseif ($linha[8] == "2" and $linha[11] == "") {
                echo 'Campo TIPO_CNSO inválido: ED021 <br />';
                break 2;
            } elseif ($linha[11] <= "0" and $linha[11] >= "5") {
                echo 'Campo TIPO_CNSO inválido: ED031 EG008 <br />';
                break 2;
            } elseif (($linha[8] == "1" or $linha[8] == "3") and $linha[11] !== "") {
                echo 'Campo TIPO_CNSO inválido: ED047 <br />';
                break 2;
            } elseif (strlen($linha[11]) > 1) {
                echo 'Campo TIPO_CNSO inválido: EG009 <br />';
                break 2;
            } else {
                echo 'TIPO CONSOL: ' . $linha[11] . " | ";
            }

            //TESTA CNPJ RESPONSAVEL PELO RECOLHIMENTO

            if ($linha[12] !== "") {
                echo 'Campo CNPJ_RESP_RCLH inválido: Campo deverá estar em branco <br />';
                break 2;
            } else {
                echo 'CNPJ RESP RECOLH: ' . $linha[12] . " | ";
            }

            //TESTA VERSAO ABRASF

            if (strlen($linha[13]) > 10) {
                echo 'Campo Idn_Versao inválido: EG009 <br />';
                break 2;
            } elseif ($linha[13] == NULL or $linha[13] == "") {
                echo 'Campo Idn_Versao inválido: ED042 <br />';
                break 2;
            }
            $consulta_versao = mysql_query("SELECT versao_abrasf FROM pref_configuracoes");
            $consulta_versao = mysql_fetch_array($consulta_versao, MYSQL_ASSOC);

            if ($linha[13] !== $consulta_versao["versao_abrasf"]) {
                echo 'Campo Idn_Versao inválido: ED043 <br />';
                break 2;
            } else {
                echo 'VERSAO ABRASF: ' . $linha[13] . " | ";
            }

            //TESTA ARREDONDAMENTO

            if (strlen($linha[14]) > 1) {
                echo 'Campo TIPO_ARRED inválido: EG009 <br />';
                break 2;
            } elseif ($linha[14] !== "1") {
                echo 'Campo TIPO_ARRED inválido: de acordo com o Fisco Municipal só será aceito TIPO ARREDONDAMENTO = 1 <br />';
                break 2;
            } else {
                echo 'TIPO ARRED: ' . $linha[14] . "<br />";
            }

            //GRAVA NO BANCO
            //$sql_pgcc_insere = "INSERT INTO pref_planodecontas_iddeclarante SET idcontribuinte=".$consulta_contribuinte["id"].",data_primeiro_upload=now(),nrorevisao=1,estado='A',data_inicial='".$linha[6]."',data_final='".$linha[7]."';";
            //mysql_query($sql_pgcc_insere);
            //echo mysql_result($sql_pgcc_insere,0);
            // LIMPA O ARRRAY $linha E VOLTA PARA O for
            $linha = array();
        }
        // TIPO DE REGISTRO <> 0000
        else {
            //TESTA NRO LINHA
            if ($linha[0] !== NULL and strlen($linha[0]) < 7) {

                // TESTA TIPO DE REGISTRO IGUAL 0100
                if ($linha[1] == "0100") {

                    // TESTA CONTA CONTABIL
                    if ((strlen($linha[2]) <= 30 ) and ($linha[2] !== '')) {
                        echo $linha[2] . '|';
                        
                        //TESTA NOME DA CONTA
                        if ((strlen($linha[3]) <= 100 ) and ($linha[3] !== '')) {
                            echo $linha[3] . '|';
                            
                            //TESTA DESC DA CONTA
                            if ((strlen($linha[4]) <= 600 ) and ($linha[4] !== '')) {
                                echo $linha[4] . '|';
                                
                                //TESTA CONTA SUPERIOR DA CONTA
                                if ((strlen($linha[5]) <= 8 ) and ($linha[5] !== $linha[2]) and ($linha[2] !== '')) {
                                    echo $linha[5] . '|';
                                    
                                    //TESTA CONTA COSIF DA CONTA
                                    if ((strlen($linha[6]) <= 8 ) and (is_numeric($linha[6]))) {
                                        echo $linha[6] . '|';
                                        
                                        //TESTA COD TRIB DESIF DA CONTA
                                        if ((strlen($linha[7]) <= 9 ) and (is_numeric($linha[6]))) {
                                            echo $linha[7] . '<br>';
                                        } else {
                                            echo 'Campo COD TRIB DESIF inválido EG008 EG009 EI008 EI009 EI018 EI027 EI028 EI029 EI032 <br />';
                                            break 2;
                                        }
                                    } else {
                                        echo 'Campo CONTA_COSIF inválido EG008 EG009 EI008 EI009 EI018 EI027 EI028 EI029 EI032 <br />';
                                        break 2;
                                    }
                                } else {
                                    echo 'Campo CONTA_SUPE inválido EG009 EI005 EI006 EI007 EI031 EI033<br />';
                                    break 2;
                                }
                                
                            } else {
                                echo 'Campo DESC_CONTA inválido EG009 EI004<br />';
                                break 2;
                            }
                            
                        } else {
                            echo 'Campo NOME inválido EG009 EI003<br />';
                            break 2;
                        }
                        
                    } else {
                        echo 'Campo CONTA inválido EG009 EG016 EI001<br />';
                        break 2;
                    }
                } else {
                    echo 'Campo REG inválido ED035 EG009 EG012 EG014 ED037 <br />';
                    break 2;
                }
            } else {
                echo 'Campo NUM_LINHA inválido: EG009 EG013 <br />';
                break 2;
            }
        }
    } // FIM FOR
} // FIM WHILE
echo "quantidade de linhas lidas = " . $ll;
//$sql = "INSERT INTO $tabela (NROLINHA, REG, CONTA, NOME, DESCRICAO, CONTASUPERIOR, COSIF, CODTRIBDESIF) VALUES ('$linha[0]', '$linha[1]', '$linha[2]', '$linha[3]', '$linha[4]', '$linha[5]', '$linha[6]', '$linha[7]')";
//$result = mysql_query($sql) or die(mysql_error());
?>