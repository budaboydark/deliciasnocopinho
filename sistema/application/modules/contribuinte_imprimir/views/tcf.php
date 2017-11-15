<?php
$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');


$core_c = $this->db->where('id', 21)->get('core_config')->first_row('array');
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
$IDs = $_POST['print_id'];
foreach ($IDs as $id) {
    $this->db->where('id', $id);
    $proc_tcf = $this->db->get('pref_processofiscal_tcf')->first_row('array');
    $query = $this->db->select('po.*,pc.razao_social FROM pref_processofiscal_ordemfiscal po INNER JOIN pref_contribuintes pc ON(pc.id = po.idcontribuinte) INNER JOIN pref_processofiscal_tcf tcf ON(tcf.idordemfiscal=po.id) WHERE tcf.id = ' . $id . ' ORDER BY po.id DESC');
    $query = $this->db->get()->first_row('array');

    $this->db->where('id', $query['idcontribuinte']);
    $contribuintes = $this->db->get('pref_contribuintes')->first_row('array');
    
    $this->db->where('id',$contribuintes['idinstituicao']);
    $instituicao = $this->db->get('pref_contribuintes_instituicoes')->first_row('array');
    
    $this->db->where('id',$query['idfiscal']);
    $fiscal = $this->db->get('user')->first_row('array');
    
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
                    <p style="font-family:sans-serif;font-size: 18px;">PREFEITURA MUNICIPAL DE <?php echo $municipio . ' - ' . $uf; ?> <br /><?php echo strtoupper(utf8_decode($conf->secretaria)); ?><br />SETOR DE FISCALIZA&Ccedil;&Atilde;O DO ISS</p></span>
            </td>
        </tr>
    </table>
    </td>
    </tr>


    <tr>
        <td style="font-size:18px;">
            <table width="100%" cellspacing="0">
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: center;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 36px;">TERMO DE CONCLUS&Atilde;O FISCAL </p></span></td>
                </tr>
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: center;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 24px;">Imposto Sobre Servi&ccedil;o de Qualquer Natureza - ISS</p></span></td>
                </tr>
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: center;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 24px;font-weight: bold;"><?php echo $instituicao['nome']; ?></p>
                            <p style="font-family:sans-serif;font-size: 24px;font-weight: bold;">AG&Ecirc;NCIA N&ordm; <?php echo $contribuintes['codagencia']. ' - '.$contribuintes['razao_social']; ?></p>
                            <p style="font-family:sans-serif;font-size: 24px;font-weight: bold;">Inscri&ccedil;&atilde;o Municipal: <?php echo $contribuintes['inscr_municipal']; ?></p>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: left;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 18px;">CNPJ: <b><?php echo cnpj_mask($contribuintes['cnpj']); ?></b><br />
                                Endere&ccedil;o: <b><?php echo $contribuintes['logradouro']; ?></b>
                            </p>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: left;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 18px;">Agentes Fiscais da Receita Municipal: <b><?php echo $fiscal['name']; ?></b>
                            </p>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:18px;padding:5px;vertical-align:top;text-align: center;vertical-align: bottom;">
                        <span class="style1">
                            <p style="font-family:sans-serif;font-size: 18px;font-weight: bold;">
                                <?php echo $conf->municipio.' , '.  DataExtenso(); ?>
                            </p>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>