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
	$intimacao = $this->db->select('*')->from('pref_processofiscal_intimacao')->where(array('id' => $id))->get()->first_row('array');
	$ordemfiscal = $this->db->select('*')->from('pref_processofiscal_ordemfiscal')->where(array('id' => $intimacao['idordemfiscal']))->get()->first_row('array');
	$contribuintes = $this->db->select('*')->from('pref_contribuintes')->where(array('id' => $ordemfiscal['idcontribuinte']))->get()->first_row('array');
	$tipointimacao = $intimacao['tipointimacao'] == "N" ? "NORMAL" : "RETROATIVA";
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
                    <p style="font-family:sans-serif;font-size: 18px;">PREFEITURA MUNICIPAL DE <?php echo $municipio . ' - ' . $uf; ?> <br /><?php echo strtoupper(utf8_decode($conf->secretaria)); ?><br />
                    SETOR DE FISCALIZA&Ccedil;&Atilde;O DO ISSQN</p></span></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" >
        <tr>
          <td style="background-color:#CCCCCC;border:1px solid black;font-size:18px;padding:5px;text-align: center;" colspan="2">INTIMA&Ccedil;&Atilde;O N&deg; <?php echo $id."/".date("Y");?> - TRIBUTO: ISSQN</td></tr>
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
            	
                <?php echo utf8_decode($preliminar['termos']); ?>, referente(s) ao per&iacute;odo de <?php echo $intimacao['periodo']; ?>.<br /><br />
                <?php echo utf8_decode($preliminar['penalidade']); ?><br /><br />
                <?php
				if($intimacao['tipointimacao'] == "N"){
				?>
                1) Plano Geral de Contas Comentado (PGCC) da Institui&ccedil;&atilde;o, no padr&atilde;o COSIF, em arquivo magn&eacute;tico formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                2) Contabiliza&ccedil;&atilde;o das tarifas banc&aacute;rias: Informar em qual conta cont&aacute;bil &eacute; lan&ccedil;ada cada uma das tarifas banc&aacute;rias constantes da tabela de tarifas vigente, formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                3) Demonstrativo da apura&ccedil;&atilde;o da receita tribut&aacute;vel e do ISSQN mensal devido por Subt&iacute;tulo, formato TXT, conforme Padr&atilde;o ABRASF;<br /><br /><br>
                4) Guias de recolhimento referente ISS Pr&oacute;prio pago mensalmente.<br /><br /><br>
                5) Relat&oacute;rio mensal, em arquivo magn&eacute;tico no formato XLS ou formato PDF, com o demonstrativo das contas que foram tributadas pela Institui&ccedil;&atilde;o;<br /><br /><br>
                <?php
				}else{
					
				?>
                1 &ndash; Plano de Contas da Institui&ccedil;&atilde;o, no padr&atilde;o COSIF, em arquivo magn&eacute;tico formato XLS (planilha), contendo:<br />
                a) Elenco das Contas;<br />
                b) C&oacute;digo Cont&aacute;bil;<br />
                c) Nome da Conta;<br />
                d) Fun&ccedil;&atilde;o da Conta: Detalhamento da finalidade e da natureza dos lan&ccedil;amentos efetuados nesta conta;<br />
                e) Se poss&iacute;vel padr&atilde;o ABRASF.<br /><br />
                2 &ndash; Contabiliza&ccedil;&atilde;o das tarifas banc&aacute;rias: Informar em qual conta cont&aacute;bil &eacute; lan&ccedil;ada cada uma das tarifas banc&aacute;rias constantes da tabela de tarifas vigente. Se poss&iacute;vel padr&atilde;o ABRASF.<br /><br />
                3 &ndash; C&oacute;pia dos Balancetes Cont&aacute;beis Mensais &ndash; em &uacute;ltimo n&iacute;vel, do grupo de receitas, em arquivo magn&eacute;tico formato XLS (planilha), Padr&atilde;o COSIF, observado:<br />
                a) Per&iacute;odo: <?php echo $intimacao['periodo']; ?>, com periodicidade mensal;<br />
                b) Conter Elenco de Contas at&eacute; o &uacute;ltimo n&iacute;vel (&uacute;ltimo d&iacute;gito);<br />
                c) Composi&ccedil;&atilde;o do movimento mensal:<br />
                c.1) o saldo anterior;<br />
                c.2) os d&eacute;bitos e os cr&eacute;ditos realizados no m&ecirc;s;<br />
                c.3) o saldo resultante, com indica&ccedil;&atilde;o dos credores e dos devedores;<br />
                d) Se poss&iacute;vel padr&atilde;o ABRASF.<br /><br />
                4 &ndash; Informa&ccedil;&otilde;es referentes &agrave; exist&ecirc;ncia de postos de atendimento (PAB, PAT, PCO, PAE, PAC, etc) vinculados a esta ag&ecirc;ncia, informando o local onde estes est&atilde;o estabelecidos e a data de abertura e encerramento, se o posto foi fechado.</p>
                5 &ndash; Guias de recolhimento referente ISS Pr&oacute;prio pago mensalmente.<br /><br />
                6 &ndash; Relat&oacute;rio mensal, em arquivo magn&eacute;tico no formato XLS, com o demonstrativo das contas que foram tributadas pela Institui&ccedil;&atilde;o, inclusive contas zeradas e ou sem movimento contendo:<br />
                a) C&oacute;digo Cont&aacute;bil; <br />
                b) Nome da Conta;<br />
                c) Valor da Receita Tribut&aacute;vel; <br />
                d) Se poss&iacute;vel padr&atilde;o ABRASF.<br /><br />
                <?php
				}
				?>
                <strong>OBSERVA&Ccedil;&Atilde;O: A documenta&ccedil;&atilde;o e os modelos referentes ao Padr&atilde;o ABRASF se encontram no menu "AJUDA" no perfil do contribuinte, no endere&ccedil;o <?php echo base_url('contribuinte'); ?>.</strong><br /><br />
                Todos os documentos solicitados acima dever&atilde;o ser entregues na rua <?php echo $conf->endereco; ?>. Informa&ccedil;&otilde;es podem ser obtidas pelo site <?php echo $conf->site; ?>. Devem ser apresentados os documentos originais ou c&oacute;pias.<br>
                
                
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
