
<?php
$mes = date('m');
$dia = date('d');
$ano = date('Y');
switch ($mes) {
    case 1: $mes = "Janeiro";
        break;
    case 2: $mes = "Fevereiro";
        break;
    case 3: $mes = "Mar&ccedil;o";
        break;
    case 4: $mes = "Abril";
        break;
    case 5: $mes = "Maio";
        break;
    case 6: $mes = "Junho";
        break;
    case 7: $mes = "Julho";
        break;
    case 8: $mes = "Agosto";
        break;
    case 9: $mes = "Setembro";
        break;
    case 10: $mes = "Outubro";
        break;
    case 11: $mes = "Novembro";
        break;
    case 12: $mes = "Dezembro";
        break;
}

$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');

$core_c = $this->db->where('id', 21)->get('core_config')->first_row('array');

$this->db->select('municipio,uf,brasao,endereco,cpf,rg,responsavel,cnpj,idn_cida');
$this->db->from('pref_configuracoes');
$query_conf = $this->db->get();

foreach ($query_conf->result() as $conf) {
    $municipio = $conf->municipio;
    $uf = $conf->uf;
    $brasao = $conf->brasao;
}
$cidade = $this->db->where('idn_cida', $conf->idn_cida)->get('pref_abrasf_cidades')->first_row('object');
/*
  $this->load->helper('directory');
  $map = directory_map('../sistema/upload/others/image/');
  print_r($map);
 */
?>
<!-- CSS -->
<style type="text/css"  media="screen">
    .style1 {font-family: Georgia, "Times New Roman", Times, serif}

    .tabela {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        /*border-collapse:collapse;
        border: 1px solid #000000;
        */
        margin:0 auto;
    }
    .tabelameio {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        /*
        border-collapse:collapse;
        border: 1px solid #000000;
        */
    }
    .tabela tr td{
        /*border: 1px solid #000000;*/
    }
    .fonte{
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    .botao{
        margin: 0 auto;
    }

</style>
<style media="print">
    .botao{
        display:none;
    }
</style>
<?php
$IDs = $post['id']; //array('id'=>'2');
setlocale(LC_CTYPE, 'pt_BR');
foreach ($IDs as $id) {

    $this->db->where('id', $id);
    $titulo = $this->db->get('pref_titulo')->first_row('object');
    ?>
    <div class="botao" align="center">
        <INPUT NAME="print"  TYPE="button" VALUE="Imprimir este documento" ONCLICK="javascript:window.print();">
    </div>
    <table  width="630px" style="page-break-after: auto;padding:10px;" cellspacing="0" class="tabela">
        <tr >
            <td width="80"><img width="80" height="80" src="../../upload/config/<?php echo $core_c['value']; ?>"</td>

            <td width="714" style="font-family:'arial' ;font-size: 18px; text-align:center;"><strong><?php echo $municipio; ?><br/>Secretaria de Fazenda<br/>Unidade de Arrecadação / Dívida Ativa</strong></td></tr>
        <tr>	
            <td colspan="2" style="font-family: 'Times New Roman', Times, serif;font-size:18px;"><div align="left"><br/>Ao<br/>Tabeli&atilde;o de Notas e de Protesto de Letras e T&iacute;tulos</div></td>
        </tr>
        <tr>
            <td style="text-align: center;font-family: 'Times New Roman', Times, serif;" colspan="2">

                <!-- DADOS DA INSTITUIÇÃO--->
                <table width="100%" cellspacing="0" >
                    <tr><td colspan="2" valign="middle"  style="font-size:20px;height: 30px;vertical-align: text-top; font-family:'Times New Roman', Times, serif"><strong>Carta de Anu&ecirc;ncia</strong></td></tr>
                    <tr style="font-size:18px;height: 30px;vertical-align: text-top; font-family:'Times New Roman', Times, serif"><br/><br/>
                    <td style="text-align: justify;text-indent:15em;">
                        <p>
                            <strong><i><?php echo strtoupper($municipio); ?></i></strong>, inscrita no CNPJ. sob  Nº <strong><?php echo cnpj_mask($conf->cnpj); ?></strong>, estabelecida na cidade de <?php echo $cidade->nom_cida . '/' . $cidade->sig_uf; ?>., na Avenida Brasil,  nº 85, representada neste ato pelo Sr. <?php echo $conf->responsavel; ?>, portador do CPF  <?php echo $conf->cpf; ?> e RG <?php echo $conf->rg; ?>, declara para devidos fins, que <strong>  <?php echo $titulo->devedor; ?> </strong>. portador do <strong>CNPJ <?php echo cnpj_mask($titulo->cpfcnpjdevedor) ?> </strong> quitou o(s) título(s) abaixo qualificado(s). Portanto não se opõe ao cancelamento do(s) mesmo(s).
                        </p>
                    </td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" style="font-family:sans-serif;">
        <tr>
            <td align="left" style="font-size:12px;height: 30px; font-family:'Times New Roman', Times, serif" colspan="2"><br/><br/>Espécie:  <?php echo $titulo->espec_titulos; ?> <strong><?php echo $titulo->titulo . '/' . substr($titulo->emissao, 0, 4); ?></strong><br/><br/>Emissão:  <strong><?php echo DataPt($titulo->emissao); ?></strong><br/><br/>Vencimento:  <strong><?php echo DataPt($titulo->vencimento); ?></strong><br/><br/>Valor:  <strong>R$ <?php echo DecToMoeda($titulo->valor_atualizado); ?></strong>
            </td></tr>
    </table>

    <table width="100%" cellspacing="0" style="font-family: 'Times New Roman', Times, serif;">
        <tr><td align="left" style="font-size:18px;height: 30px;vertical-align: text-top;" colspan="3"><br/><br/><?php echo $cidade->nom_cida, ","; ?><strong><?php echo " ", $dia, " ", "de", " ", $mes, " de ", substr($ano,0,1).'.'.substr($ano,1,3); ?></strong>
            </td></tr>

    </table>

    <table width="100%" cellspacing="0" style="font-family: 'Times New Roman', Times, serif;padding: 5px;margin-top:60px;">
        <tr>
            <td style="padding-bottom:3px;text-align: left; font-size:12px">___________________________________________________</td>
            <td style="padding-bottom:3px;text-align: center;"> </td>
        </tr>
        <tr>
            <td style="padding:3px;text-align: left;font-family: 'Times New Roman', Times, serif;font-size: 16px;"><?php echo $conf->responsavel; ?></td>
        </tr>

        <tr>
            <td style="padding:3px;text-align: left;font-family: 'Times New Roman', Times, serif;font-size: 14px;font-weight: bold;"> <br/><br/><br/><br/>Válido somente com firma reconhecida.</td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
<?php } ?>
