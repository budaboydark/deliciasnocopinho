<?php
$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');
$core_c =$this->db->where('id',21)->get('core_config')->first_row('array');
$this->db->select('municipio,uf,brasao,secretaria,site,endereco');
$this->db->from('pref_configuracoes');
$query_conf = $this->db->get();
//var_dump($user);
foreach ($query_conf->result() as $conf) {
    $municipio = $conf->municipio;
    $uf = $conf->uf;
    $brasao = $conf->brasao;
}
$usuario = $this->db->select('*')->where('id', $user['user_id'])->get('user')->first_row('array');
/*
  $this->load->helper('directory');
  $map = directory_map('../sistema/upload/others/image/');
  print_r($map);
 */
 setlocale(LC_CTYPE, 'pt_BR');
//setlocale(LC_ALL, "pt_BR", "ptb");
//setlocale(LC_ALL, 'Portuguese_Brazil.1252');
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
//$IDs = $_POST['delete_id'];
$IDs = $_POST['print_id'];
foreach ($IDs as $id) {
	$tif = $this->db->select('*')->from('pref_processofiscal_tif')->where(array('id' => $id))->get()->first_row('array');
	$dispositivoslegais = $this->db->select('*')->from('pref_processofiscal_dispositivoslegais')->where(array('id' => $tif['iddispositivolegal']))->get()->first_row('array');
	$ordemfiscal = $this->db->select('*')->from('pref_processofiscal_ordemfiscal')->where(array('id' => $tif['idordemfiscal']))->get()->first_row('array');
	$contribuintes = $this->db->select('*')->from('pref_contribuintes')->where(array('id' => $ordemfiscal['idcontribuinte']))->get()->first_row('array');
	$preliminar = $this->db->select('*')->from('pref_processofiscal_intimacao_termos')->where(array('tipointimacao' => $tipointimacao))->get()->first_row('array');
    ?>
    <div class="botao" align="center">
        <INPUT NAME="print"  TYPE="button" VALUE="Imprimir este documento!" ONCLICK="javascript:window.print();">
    </div>
	<div style="clear:both;page-break-after:always;">
    <table  width="790px" style="page-break-after: auto;padding:10px;" cellspacing="0" class="tabela">
        <tr>
            <td style="font-size:18px;">
                <table width="100%" cellspacing="0" >
                    <tr>
                        <td style="font-size:18px;padding: 5px;vertical-align: top;">
                    <center><img src="../../upload/config/<?php echo $core_c['value']; ?>" width="80" height="80" /></center></td>
            <td style="font-size:18px;padding: 5px;vertical-align: top;">
                <span class="style1">
                    <p style="font-family:sans-serif;font-size: 18px;">PREFEITURA MUNICIPAL DE <?php echo $municipio . ' - ' . $uf; ?> <br /><?php echo strtoupper($conf->secretaria); ?><br />
                    SETOR DE FISCALIZA&Ccedil;&Atilde;O DO ISSQN</p></span></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" >
        <tr>
          <td style="background-color:#CCCCCC;border:1px solid black;font-size:18px;padding:5px;text-align: center;" colspan="2">TERMO DE INÍCIO FISCAL N&deg; <?php echo $id."/".date("Y");?> - TRIBUTO: ISSQN</td></tr>
    </table>
    <table width="100%" style="font-family:sans-serif;" cellspacing="0" >
        <tr>
            <td style="text-align: left;font-size:14px;border:1px solid black;padding:5px;"><strong>Inscri&ccedil;&atilde;o:</strong> <?php echo $contribuintes['inscr_municipal']; ?></td>
            <td style="text-align: left;font-size:14px;border:1px solid black;padding:5px;"><strong>CNPJ:</strong> <?php echo cnpj_mask($contribuintes['cnpj']); ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;font-size:14px;border:1px solid black;padding:5px;"><strong>Raz&atilde;o Social:</strong> <?php echo $contribuintes['razao_social']; ?></td>
        </tr>
        <tr>
            <td style="text-align: left;font-size:14px;border:1px solid black;padding:5px;"><strong>Endere&ccedil;o:</strong> <?php echo $contribuintes['logradouro'] . ', ' . $contribuintes['numero']; ?></td>
            <td style="text-align: left;font-size:14px;border:1px solid black;padding:5px;"><strong><?php echo $contribuintes['municipio'] . ' - ' . $contribuintes['uf']; ?></strong></td>
        </tr>
    </table>
    <!-- OBSERVAÇÕES -->
    <table width="100%" cellspacing="0" style="font-family:sans-serif;padding: 5px;border:1px solid black;">
        <tr>
            <td style="padding: 3px;font-size:11px;">
            	
                <!-- Conteudo do meio do arquivo aqui... -->                
                Dispositivo Legal: <?php echo $dispositivoslegais['titulo']."<br />".$dispositivoslegais['introducao']."<br />".nl2br($dispositivoslegais['texto']);?>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
        <tr>
            <td style="border-bottom:1px solid #000000;background-color: #CCCCCC;padding:5px;text-align:left;font-size:14px;"><strong>Agente Fiscal da Receita Municipal:</strong></td>
            <td style="border-bottom:1px solid #000000;background-color: #CCCCCC;padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><strong>Matr&iacute;cula n&ordm;:</strong></td>
            <td style="border-bottom:1px solid #000000;background-color: #CCCCCC;padding:5px;border-left:1px solid black;text-align: left;font-size:14px;width: 200px;"><strong>Assinatura:</strong></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align:left;font-size:14px;height: 16px;"><?php //echo $usuario['name']; ?></td>
            <td style="padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><?php //echo $usuario['matricula']; ?></td>
            <td style="padding:5px;border-left:1px solid black;text-align: left;font-size:14px;width: 200px;"></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
        <tr>
            <td style="border-bottom:1px solid #000000;background-color: #CCCCCC;padding:5px;text-align:center;font-size:14px;"><strong>Ci&ecirc;ncia do Sujeito Passivo</strong></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
        <tr>
            <td colspan="2" style="padding:5px;text-align:left;font-size:14px;">Recebi esta intima&ccedil;&atilde;o em _____/_____/<?php echo date('Y'); ?>,&agrave;s____________h</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align:left;font-size:14px;">Nome:______________________________________________</td>
            <td style="text-align:left;font-size:14px;">RG/CPF:__________________________________</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align:left;font-size:14px;">Assinatura:______________________________________________</td>
            <td style="text-align:left;font-size:14px;">Telefone:__________________________________</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #CCCCCC;padding:5px;text-align:left;font-size:14px;">A recusa do sujeito passivo ser&aacute; declarada pelo Agente Fiscal no campo abaixo, a partir do que, considera-se feita a intima&ccedil;&atilde;o com a entrega deste documento.</td>
        </tr>
        <tr>
            <td colspan="2" style="padding:5px;text-align:left;font-size:14px;"><input type="checkbox" />O intimando negou-se a assinar:</td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 1px solid #000000;padding:5px;text-align:left;font-size:14px;">Testemunhas:    ___________________________________________________________________</td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
<?php } ?>