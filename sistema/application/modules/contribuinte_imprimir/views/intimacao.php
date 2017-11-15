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
$preliminar = $this->db->get('pref_intimacao_preliminar')->first_row('array');
$usuario = $this->db->select('*')->where('id', $user['user_id'])->get('user')->first_row('array');
/*
  $this->load->helper('directory');
  $map = directory_map('../sistema/upload/others/image/');
  print_r($map);
 */
 setlocale(LC_CTYPE, 'pt_BR');
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
$IDs = $_POST['delete_id'];
foreach ($IDs as $id) {
    $this->db->where('id', $id);
    $contribuintes = $this->db->get('pref_contribuintes')->first_row('array');
    ?>
    <div class="botao" align="center">
        <INPUT NAME="print"  TYPE="button" VALUE="Imprimir este documento!" ONCLICK="javascript:window.print();">
    </div>

    <table  width="800px" style="page-break-after: auto;padding:10px;" cellspacing="0" class="tabela">
        <tr>
            <td style="font-size:18px;">
                <table width="100%" cellspacing="0" >
                    <tr>
                        <td style="font-size:18px;padding: 5px;vertical-align: top;">
                    <center><img src="../../upload/config/<?php echo $core_c['value']; ?>" width="80" height="80" /></center></td>
            <td style="font-size:18px;padding: 5px;vertical-align: top;">
                <span class="style1">
                    <p style="font-family:sans-serif;font-size: 18px;">PREFEITURA MUNICIPAL DE <?php echo $municipio . ' - ' . $uf; ?> <br /><?php echo strtoupper(utf8_decode($conf->secretaria)); ?><br />SETOR DE FISCALIZA&Ccedil;&Atilde;O DO ISS</p></span></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" >
        <tr><td style="background-color:#CCCCCC;border:1px solid black;font-size:18px;padding:5px;text-align: center;" colspan="2">INTIMA&Ccedil;&Atilde;O PRELIMINAR 2015 - TRIBUTO: ISS</td></tr>
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
                <?php echo utf8_decode($preliminar['termos']); ?>, referentes ao per&iacute;odo de <?php echo $preliminar['periodo']; ?><br /><br /><br>
                <?php echo utf8_decode($preliminar['penalidade']); ?><br /><br /><br>
                1) Plano Geral de Contas Comentado (PGCC) da Institui&ccedil;&atilde;o, no padr&atilde;o COSIF, em arquivo magn&eacute;tico formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                2) Contabiliza&ccedil;&atilde;o das tarifas banc&aacute;rias: Informar em qual conta cont&aacute;bil &eacute; lan&ccedil;ada cada uma das tarifas banc&aacute;rias constantes da tabela de tarifas vigente, formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                3) Demonstrativo da apura&ccedil;&atilde;o da receita tribut&aacute;vel e do ISSQN mensal devido por Subt&iacute;tulo, formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                4) Guias de recolhimento referente ISS Pr&oacute;prio pago mensalmente.<br /><br /><br>
                5) Relat&oacute;rio mensal, em arquivo magn&eacute;tico no formato XLS ou formato PDF, com o demonstrativo das contas que foram tributadas pela Institui&ccedil;&atilde;o;<br /><br /><br>
                <strong>OBSERVA&Ccedil;&Atilde;O I: Os documentos solicitados nos itens  1, 2 e 3 poder&atilde;o ser dispensados de apresenta&ccedil;&atilde;o se houver o preenchimento do Sistema GIBAN - Gest&atilde;o do ISSQN de Bancos e Institui&ccedil;&otilde;es Financeiras no seguinte endere&ccedil;o eletr&ocirc;nico: <?php echo $conf->site; ?>.</strong><br /><br />
                <strong>OBSERVA&Ccedil;&Atilde;O II: A documenta&ccedil;&atilde;o e os modelos referentes ao Padr&atilde;o ABRASF se encontram no menu "AJUDA" no perfil do contribuinte, no endere&ccedil;o <?php echo base_url('contribuinte'); ?>.</strong><br /><br />
                Todos os documentos solicitados acima dever&atilde;o ser entregues na rua <?php echo $conf->endereco; ?><br>
                Informa&ccedil;&otilde;es podem ser obtidas pelo site <?php echo $conf->site; ?>.<br>
                Devem ser apresentados os documentos originais ou c&oacute;pias.<br>
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
<?php } ?>