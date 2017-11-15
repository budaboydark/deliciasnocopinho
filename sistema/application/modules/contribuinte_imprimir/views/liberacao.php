
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
$IDs = $_POST['delete_id'];
foreach ($IDs as $id) {
    $this->db->where('id', $id);
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
        <td style="text-align: center;font-family: sans-serif;font-size:18px;" colspan="2">FORMUL&Aacute;RIO DE LIBERA&Ccedil;&Atilde;O DE SISTEMA</td></tr>
    <tr>
        <td style="text-align: center;font-family: sans-serif;" colspan="2">
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr><td  style="background-color:#CCCCCC;border-bottom:1px solid black;font-size:18px;" colspan="3">&nbsp;</td></tr>
                <tr>
                    <td style="text-align: left;font-size:14px;padding:5px;"><strong>Sistema:</strong> DESIF</td>
                    <td style="text-align: left;font-size:14px;border-left:1px solid black;padding:5px;"><strong>Endere&ccedil;o para acesso:</strong><br /><br /><?php echo base_url('contribuinte'); ?></td>
                    <td style="text-align: left;font-size:14px;border-left:1px solid black;padding:5px;">
                        <strong>Data Solicita&ccedil;&atilde;o:</strong> <?php echo date('d/m/Y'); ?><br /><br />
                        <strong>Data Libera&ccedil;&atilde;o:</strong> <?php echo date('d/m/Y'); ?>
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
                <tr><td  style="background-color: #CCCCCC;border-top:1px solid black;border-bottom:1px solid black;font-size:18px;height: 30px;vertical-align: text-top;" colspan="2">Endere&ccedil;o de Localiza&ccedil;&atilde;o da Empresa</td></tr>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Endere&ccedil;o:</strong> <?php echo $contribuintes['logradouro']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-bottom:1px solid black;border-left:1px solid black;text-align: left;font-size:14px;"><strong>N&uacute;mero:</strong> <?php echo $contribuintes['numero']; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Bairro:</strong> <?php echo $contribuintes['bairro']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-bottom:1px solid black;border-left:1px solid black;text-align: left;font-size:14px;"><strong>Complemento:</strong> <?php echo $contribuintes['complemento']; ?><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding:5px;text-align: left;font-size:14px;width: 500px;"><strong>Munic&iacute;pio:</strong> <?php echo $contribuintes['municipio']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><strong>CEP:</strong> <?php echo $contribuintes['cep']; ?><br />&nbsp;</td>
                </tr>
            </table>
            <!-- TELEFONES PARA CONTATO -->
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr><td  style="background-color: #CCCCCC;border-top:1px solid black;border-bottom:1px solid black;font-size:18px;height: 30px;vertical-align: text-top;" colspan="3">Telefones para Contato</td></tr>
                <tr>
                    <td style="padding:5px;text-align: left;font-size:14px;"><strong>Telefone (1):</strong> <?php echo $contribuintes['fone01']; ?><br />&nbsp;</td>
                    <td style="padding:5px;text-align: left;font-size:14px;"><strong>Telefone (2):</strong> <?php echo $contribuintes['fone02']; ?><br />&nbsp;</td>
                    <td style="padding:5px;text-align: left;font-size:14px;width: 200px;"><br />&nbsp;</td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" style="font-family:sans-serif;border:1px solid black;">
                <tr><td  style="background-color: #CCCCCC;border-bottom:1px solid black;font-size:18px;height: 30px;vertical-align: text-top;" colspan="2">Dados do Respons&aacute;vel (Gerente da Ag&ecirc;ncia)</td></tr>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid black;text-align: left;font-size:14px;"><strong>Nome do Respons&aacute;vel:</strong> <?php echo $contribuintes['responsavel']; ?><br />&nbsp;</td>
                    <td style="padding:5px;border-bottom:1px solid black;border-left:1px solid black;text-align: left;font-size:14px;width: 300px;"><strong>CPF:</strong><br />&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid black;padding:5px;text-align: left;font-size:14px;"><strong>Email:</strong><br />&nbsp;</td>
                    <td style="border-bottom:1px solid black;padding:5px;border-left:1px solid black;text-align: left;font-size:14px;"><strong>Login (CNPJ):</strong> <?php echo cnpj_mask($contribuintes['cnpj']); ?></strong><br />&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:5px;text-align: center;;font-size:14px;"><strong>*A senha inicial de acesso ao sistema ser&aacute; de 1 a 6. Ficando de responsabilidade do contribuinte a troca da mesma.</strong></td>
                </tr>

            </table>
            <table width="100%" cellspacing="0" style="font-family:sans-serif;padding:5px;margin-top:50px;">
                <tr>
                    <td style="padding:3px;text-align:right;font-family: sans-serif;font-size: 14px;font-weight: bold;">Data <?php echo date('d/m/Y'); ?></td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" style="font-family:sans-serif;padding: 5px;margin-top:60px;">
                <tr>
                    <td style="padding:3px;text-align: center;">______________________________________________________________________</td>
                </tr>
                <tr>
                    <td style="padding:3px;text-align: center;font-family: sans-serif;font-size: 14px;font-weight: bold;">Assinatura do Respons&aacute;vel pelo preenchimento dos dados</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>