<?php
$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');


$core_c = $this->db->where('id', 21)->get('core_config')->first_row('array');
$this->db->select('municipio,uf,brasao,secretaria,site,endereco,email');
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
    $notificacao = $this->db->select('*')->from('pref_processofiscal_notificacao')->where(array('id' => $id))->get()->first_row('array');
    $ordemfiscal = $this->db->select('*')->from('pref_processofiscal_ordemfiscal')->where(array('id' => $notificacao['idordemfiscal']))->get()->first_row('array');
    $contribuintes = $this->db->select('*')->from('pref_contribuintes')->where(array('id' => $ordemfiscal['idcontribuinte']))->get()->first_row('array');
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
                <td style="background-color:#CCCCCC;border:1px solid black;font-size:18px;padding:5px;text-align: center;" colspan="2">NOTIFICA&Ccedil;&Atilde;O N&deg; <?php echo $id . "/" . date("Y"); ?> - TRIBUTO: ISSQN</td></tr>
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
                    <?php
                    /*
                     * Contas Incontroversas.   
                     *                      
                     */
                    if ($notificacao['pgcc_incontroversas'] == 'S') {
                        $CI = $this->db->select('*')->where('ressalva_tipo', 'CI')->where('idplanodecontas', $notificacao['pgcc_id'])->get('pref_planodecontas_contas')->result_array();
                        if (count($CI) > 0) {
                            ?>
                    Vimos por meio dessa, solicitar a Vsa. Senhoria, informa&ccedil;&atilde;o a respeito do grupo de contas cont&aacute;beis em anexo, que n&atilde;o apareceram 
                    os seus respectivos c&oacute;digos de tributa&ccedil;&atilde;o em rela&ccedil;&atilde;o ao Plano Geral de Contas Comentados (PGCC) do ano 2015, encaminhado por essa 
                    Institui&ccedil;&atilde;o Financeira.                    
                            <table cellspacing="0" style="border:1px solid #000000;">
                                <th>Conta Cont&aacute;bil</th>
                                <th>Nome</th>
                                <th>Conta COSIF</th>
                                <?php
                                foreach ($CI as $CIs) {
                                    echo "<tr><td  style=\"border:1px solid black;\">" . $CIs['conta'] . '</td><td  style="border:1px solid black;">' . $CIs['nome'] . '</td><td  style="border:1px solid black;">' . $CIs['conta_cosif'] . '</td><tr>';
                                }
                                ?>
                            </table>
                            <?php
                        }
                    }
                    /*
                     * Contas Controversas.   
                     *                      
                     */
                    if ($notificacao['pgcc_controversas'] == 'S') {
                        $CC = $this->db->select('*')->where('ressalva_tipo', 'CC')->where('idplanodecontas', $notificacao['pgcc_id'])->get('pref_planodecontas_contas')->result_array();
                        if (count($CC) > 0) {
                            ?>
                            <table cellspacing="0" style="border:1px solid #000000;">
                                <th>Conta Cont&aacute;bil</th>
                                <th>Nome</th>
                                <th>Conta COSIF</th>
                                <?php
                                foreach ($CC as $CCs) {
                                    echo "<tr><td  style=\"border:1px solid black;\">" . $CCs['conta'] . '</td><td  style="border:1px solid black;">' . $CCs['nome'] . '</td><td style="border:1px solid black;">' . $CCs['conta_cosif'] . '</td><tr>';
                                }
                                ?>
                            </table>
                            <?php
                        }
                    }
                    /*
                     * Contas Imprecisas.   
                     *                      
                     */
                    if ($notificacao['pgcc_imprecisas'] == 'S') {
                        $IM = $this->db->select('*')->where('ressalva_tipo', 'IM')->where('idplanodecontas', $notificacao['pgcc_id'])->get('pref_planodecontas_contas')->result_array();
                        if (count($IM) > 0) {
                            ?>
                            <br />
                            Ao mesmo tempo, que seja apresentado das contas elencadas abaixo, a sua respectiva “fun&ccedil;&atilde;o e funcionamento” no Plano Geral de 
                            Contas Comentados (PGCC) de 2015 encaminhado por essa Institui&ccedil;&atilde;o Financeira.                        
                            <br /><br />
                            <table cellspacing="0" style="border:1px solid black;">
                                <th>Conta Cont&aacute;bil</th>
                                <th>Nome</th>
                                <th>Conta COSIF</th>
                                <?php
                                foreach ($IM as $IMs) {
                                    echo '<tr ><td style="border:1px solid black;">  ' . $IMs['conta'] . '</td><td  style="border:1px solid black;">' . $IMs['nome'] . '</td><td  style="border:1px solid black;">' . $IMs['conta_cosif'] . '</td><tr>';
                                }
                                ?>
                            </table>
                            Solicitamos, ainda, a descrição detalhada das receitas registadas nestas contas cont&aacute;beis tendo em vista a 
                            nomenclatura utilizada por esta institui&ccedil;&atilde;o é imprecisa. As informa&ccedil;&otilde;es poder&atilde;o ser fornecidas por meio eletr&ocirc;nico e 
                            encaminhadas para o seguinte endere&ccedil;o de e-mail; <?php echo $conf->email; ?>                     
                            <br /><br /><br />
                            <?php
                        }
                    }
                    ?>
                            <strong>Todos os documentos solicitados acima dever&atilde;o ser entregues na <?php echo $conf->endereco ?>, nos dias de semana, exceto
                                feriados, das 08h30min &agrave;s 12h00min e das 13h30min &agrave;s 18h00min.
                                Informa&ccedil;&otilde;es podem ser obtidas pelo telefone XXXXXXXXXXXXX - Secretaria da Fazenda
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
                                <td style="padding:5px;text-align:left;font-size:14px;height: 16px;"><?php //echo $usuario['name'];                         ?></td>
                                <td style="padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><?php //echo $usuario['matricula'];                         ?></td>
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

