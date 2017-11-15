<?php
$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');
$core_c =$this->db->where('id',21)->get('core_config')->first_row('array');
$this->db->select('municipio,uf,brasao');
$this->db->from('pref_configuracoes');
$query_conf = $this->db->get();
foreach ($query_conf->result() as $conf) {
    $municipio = $conf->municipio;
    $uf = $conf->uf;
    $brasao = $conf->brasao;
}
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
foreach($id as $id){
    $identificacao = $this->db->select('*')->where('id',$id)->get('pref_apuracao_mensal_issqn_identificacao')->first_row('array');
	$consolidacao = $this->db->select('*')->where('id',$identificacao['tipo_decl'])->get('pref_abrasf_tiposconsolidacao')->first_row('array');	
	
	switch($identificacao['tipo_decl']){
		case "1": $tipo = "Normal"; break;
		case "2": $tipo = "Retificadora"; break;
	}
	
	switch($identificacao['situacao']){
		case "A": $situacao = "Aberta"; break;
		case "C": $situacao = "Cancelada"; break;
		case "E": $situacao = "Escriturada"; break;
	}
    $this->db->where('id', $identificacao['idcontribuinte']);
    $contribuintes = $this->db->get('pref_contribuintes')->first_row('array');
    ?>
    <div class="botao" align="center">
        <INPUT NAME="print"  TYPE="button" VALUE="Imprimir este documento" ONCLICK="javascript:window.print();">
    </div>
    <table  width="800px" style="page-break-after: auto;padding:10px;" cellspacing="0" class="tabela">
        <tr>
            <td><center><img src="../../upload/config/<?php echo $core_c['value']; ?>" width="80" height="80" /></center></td>
    <td><span class="style1"><p style="font-family:sans-serif;font-size: 18px;">PREFEITURA MUNICIPAL DE <?php echo $municipio . ' - ' . $uf; ?></p></span></td>
    </tr>
    <tr>
        <td style="text-align: center;font-family: sans-serif;font-size:18px;" colspan="2">PROTOCOLO DA DECLARAÇÃO DE APURAÇÃO DO ISSQN</td></tr>
    <tr>
        <td style="text-align: center;font-family: sans-serif;" colspan="2">
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr><td  style="background-color:#CCCCCC;border-bottom:1px solid black;font-size:18px;" colspan="3">&nbsp;</td></tr>
                <tr>
                    <td style="text-align: left;font-size:14px;padding:5px;"><strong>Sistema:</strong> DESIF</td>
                    <td style="text-align: left;font-size:14px;border-left:1px solid black;padding:5px;"><strong>Endere&ccedil;o para acesso:</strong><br /><br /><?php echo base_url('contribuinte'); ?></td>
                    <td style="text-align: left;font-size:14px;border-left:1px solid black;padding:5px;">
                        <strong>Data Declara&ccedil;&atilde;o:</strong> <?php echo DataPt($identificacao['data_declaracao']); ?><br /><br />
                        <strong>Data Compet&ecirc;ncia:</strong> <?php echo DataPt($identificacao['data_competencia']); ?>
                    </td>
                </tr>
            </table>
            <!-- OBSERVAÇÕES -->
            <table width="100%" cellspacing="0" style="font-family:sans-serif;padding: 5px;">
                <tr>
                    <td style="padding: 3px;font-size:11px;"> &#8594; Este formul&aacute;rio dever&aacute; ser preenchido por todas as Institui&ccedil;&otilde;es Financeiras e equiparados, autorizado a funcionar pelo Banco Central do Brasil - BACEN e as demais pessoas jur&iacute;dicas obrigadas a utilizar o Plano Cont&aacute;bil das Institui&ccedil;&otilde;es do Sistema Financeiro Nacional - COSIF.</td>
                </tr>
            </table>
            <!-- DADOS DA INSTITUIÇÃO--->
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr><td colspan="2" valign="middle"  style="background-color: #CCCCCC;border-bottom:1px solid black;font-size:18px;height: 30px;vertical-align: text-top;">Dados da Institui&ccedil;&atilde;o</td></tr>
                <tr>
                    <td colspan="2" style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Raz&atilde;o Social:</strong> <?php echo $contribuintes['razao_social']; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>CNPJ:</strong> <?php echo cnpj_mask($contribuintes['cnpj']); ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Inscri&ccedil;&atilde;o Municipal:</strong> <?php echo $contribuintes['inscr_municipal']; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding:5px;text-align: left;font-size:14px;"><strong>Ag&ecirc;ncia:</strong> <?php echo $contribuintes['razao_social']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><strong>C&oacute;digo do Banco:</strong> <?php echo $contribuintes['codagencia']; ?><br />&nbsp;</td>
                </tr>
            </table>
            <!-- ENDEREÇO DE LOCALIZAÇÃO DA EMPRESA-->
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr>
                  <td  style="background-color: #CCCCCC;border-top:1px solid black;border-bottom:1px solid black;font-size:18px;height: 30px;vertical-align: text-top;" colspan="2">Dados da Declaração</td></tr>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Protocolo:</strong> <?php echo $identificacao['protocolo']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-bottom:1px solid black;border-left:1px solid black;text-align: left;font-size:14px;"><strong>Tipo:</strong> <?php echo $tipo; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Prtc. Declaração Anterior:</strong> <?php echo $identificacao['prtc_decl_anterior']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-bottom:1px solid black;border-left:1px solid black;text-align: left;font-size:14px;"><strong>Consolidação:</strong> <?php echo $consolidacao['tipo']; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding:5px;text-align: left;font-size:14px;width: 500px;" colspan="2"><strong>Situação:</strong> <?php echo $situacao; ?><br />&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>

