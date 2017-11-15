<style type="text/css"  media="screen">
    .style1 {font-family: Georgia, "Times New Roman", Times, serif}

    .tabela {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        border-collapse:collapse;
        border: 1px solid #000000;
        margin:0 auto;
    }
    .tabelameio {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        border-collapse:collapse;
        border: 1px solid #000000;
    }
    .tabela tr td{
        border: 1px solid #000000;
    }
    .fonte{
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    table, th, td {
        border: 1px solid black;
    }

</style>
<style type="text/css"  media="print">
    #DivImprimir{
        display: none;
    }
</style>
<?php
$this->load->library('table');
$this->load->helper('util2');
$this->db->select('municipio,uf,brasao');
$this->db->from('pref_configuracoes');
$query_conf = $this->db->get();
foreach ($query_conf->result() as $conf) {
    $municipio = $conf->municipio;
    $uf = $conf->uf;
    $brasao = $conf->brasao;
}
$query_data = $this->db->query('SELECT * FROM pref_planodecontas_contas ORDER BY id ASC LIMIT 1');
$data = $query_data->result();
if (sizeof($data) > 0) {
    $template_topo = array('table_open' => '<table width="95%" border="2" cellspacing="0" class="tabela">');
    $this->table->set_template($template_topo);
    $this->table->add_row(array('data' => '<center><img src="../../upload/others/image/'.$brasao.'" /></center>', 'width="106"'), array('data' => '<span class="style1"><center>'
        . '<p>PREFEITURA MUNICIPAL DE ' . $municipio . '</p>'
        . '<p>Relat&oacute;rio que demonstra as contas declaradas com valor zerado</p></center></span>', 'width' => '584', 'height' => '33', 'colspan' => '2'));
    echo $this->table->generate();
    /*
      $template_contribuinte = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">');
      $this->table->set_template($template_contribuinte);
      $row_contribuinte = array(array('data' => 'CONTRIBUINTE: <strong>' . $data[0]->nome_fantasia . '</strong> - CCM/IM: <strong>' . $data[0]->inscr_municipal . '</strong>'));
      $this->table->add_row($row_contribuinte);
      echo $this->table->generate();
     */
    echo '<div>';
    $template = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">'
        , 'heading_cell_start' => '<th class="head1">');
    $heading = array('Conta Cont&aacute;bil', 'Nome', 'COSIF', 'Cod Trib', 'Resalva');
    $this->table->set_template($template);
    $this->table->set_heading($heading);
    $i = 0;
    foreach ($data as $_data):
        $row = array($_data->conta
            , $_data->nome
            , $_data->conta_cosif
            , $_data->cod_trib_cosif
            , $_data->resalva_argumento);
        $this->table->add_row($row);
        ;
    endforeach;
    echo $this->table->generate();
    echo '</div>';
}
?>
