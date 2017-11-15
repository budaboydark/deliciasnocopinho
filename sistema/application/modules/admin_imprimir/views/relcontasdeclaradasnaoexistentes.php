<?php
//print_r($_POST);
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


$did = $this->db->select('*')->where('id', $id)->get('pref_apuracao_mensal_issqn_identificacao')->first_row('array');
$compet = explode('-', $did['data_competencia']);
$competencia = $compet[0] . $compet[1];
$pid = $this->db->select('*')->where('idcontribuinte', $did['idcontribuinte'])->where('data_inicial >=', $competencia)->or_where('data_final <=', $competencia)->get('pref_planodecontas_identificacao')->first_row('array');
$this->db->select('*');
$this->db->from('pref_apuracao_mensal_issqn_demo_receita');
$this->db->where('ididentificacao', $id);
$this->db->where('sub_titu NOT IN(SELECT conta from pref_planodecontas_contas where idplanodecontas = ' . $pid['id'] . ' AND cod_trib_cosif <> "\r\n" )');

$query_data = $this->db->get();
$data = $query_data->result();


if (sizeof($data) > 0) {
    ?>
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
    $template_topo = array('table_open' => '<table width="95%" border="2" cellspacing="0" class="tabela">');
    $this->table->set_template($template_topo);
    $this->table->add_row(array('data' => '<center><img src="../../../upload/others/image/' . $brasao . '" /></center>', 'width="106"'), array('data' => '<span class="style1"><center>'
        . '<p>PREFEITURA MUNICIPAL DE ' . $municipio . '</p>'
        . '<p>RELAT&Oacute;RIO DE DEMO RECEITA - DECLARADAS N&Atilde;O EXISTENTES </p></center></span>', 'width' => '584', 'height' => '33', 'colspan' => '2'));
    echo $this->table->generate();

    $template_contribuinte = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">');
    $this->table->set_template($template_contribuinte);
    $row_contribuinte = array(array('data' => 'COMPET&Ecirc;NCIA: <strong>' . DataPt($did["data_competencia"]) .'</strong>'));
    $this->table->add_row($row_contribuinte);
    echo $this->table->generate();
    ?>
    <div>
        <?php
        $template = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">'
            , 'heading_cell_start' => '<th class="head1">');
        $heading = array('Conta Cont&aacute;bil', 'Cod Trib Desif', 'Receita declarada', 'Base de Cálculo', 'Declarado');
        $this->table->set_template($template);
        $this->table->set_heading($heading);
        $i = 0;
        foreach ($data as $_data):
            $dec = $data[$i]->declarado == 'S' ? 'Sim' : 'Não';
            $row = array($data[$i]->sub_titu
                , $data[$i]->cod_trib_desif
                , MoedaToDec($data[$i]->rece_decl)
                , MoedaToDec($data[$i]->base_calc)
                , $dec);
            $this->table->add_row($row);
        endforeach;
        echo $this->table->generate();
        echo '</div>';
    }
 