<?php
//print_r($_POST);
$this->load->library('table');
$this->load->helper('util2');
$this->load->helper('html');

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


$this->db->select('*');
$this->db->from('pref_planodecontas_identificacao');
$this->db->where('id', $id);
$identificacao = $this->db->get()->first_row('array');

$this->db->select('*');
$this->db->from('pref_planodecontas_contas ');
$this->db->where('idplanodecontas', $id);
$this->db->where('ressalva', 'S');
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
    $this->table->add_row(array('data' => '<center><img src="../../upload/others/image/' . $brasao . '" /></center>', 'width="106"'), array('data' => '<span class="style1"><center>'
        . '<p>PREFEITURA MUNICIPAL DE ' . $municipio . '</p>'
        . '<p>RELAT&Oacute;RIO DE PLANO GERAL DE CONTAS COMENTADO COM RESSALVAS</p></center></span>', 'width' => '584', 'height' => '33', 'colspan' => '2'));
    echo $this->table->generate();

    $template_contribuinte = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">');
    $this->table->set_template($template_contribuinte);
    $row_contribuinte = array(array('data' => 'CONTRIBUINTE: <strong>' . $data[0]->nome_fantasia . '</strong> - CCM/IM: <strong>' . $data[0]->inscr_municipal . '</strong>'));
    $this->table->add_row($row_contribuinte);
    echo $this->table->generate();
    ?>
    <!--<h1>RELAT&oacute;RIO DE PLANO GERAL DE CONTAS COMENTADO COM RESSALVAS</h1>
    <label>CONTRIBUINTE: <strong><?php echo $data[0]->nome_fantasia; ?></strong> - CCM/IM: <strong><?php echo $data[0]->inscr_municipal; ?></strong></label> 
    <br/><br/>-->
    <div>
        <?php
        $template = array('table_open' => '<table width="95%" style="margin-top:5px;" border="2" cellspacing="0" class="tabela">'
            , 'heading_cell_start' => '<th class="head1">');
        $heading = array('Data Ini/Fin', 'Conta Cont&aacute;bil', 'Nome', 'COSIF', 'Cod Trib', 'Resalva');
        $this->table->set_template($template);
        $this->table->set_heading($heading);
        $i = 0;
        foreach ($data as $_data):
            switch ($data[$i]->ressalva) {
                case 'S': $ressalva = 'Sim';
                    break;
                case 'N': $ressalva = 'N&atilde;o';
                    break;
            }
            $row = array(DataReversePT($identificacao['data_inicial']) . '  -  ' . DataReversePT($identificacao['data_final'])
                , $data[$i]->conta
                , $data[$i]->nome
                , $data[$i]->conta_cosif
                , $data[$i]->cod_trib_cosif
                , $ressalva);
            $this->table->add_row($row);
        endforeach;
        echo $this->table->generate();
        echo '</div>';
    }
 /*   if (sizeof($data) > 0) {
        //Modelo Vini
        ?>
        <h1>RELAT&oacute;RIO DE PLANO GERAL DE CONTAS COMENTADO COM RESSALVAS</h1>
        <label>CONTRIBUINTE: <strong><?php echo $data[0]->nome_fantasia; ?></strong> - CCM/IM: <strong><?php echo $data[0]->inscr_municipal; ?></strong></label> 
        <br/><br/>
        <div>
            <table cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th class="head1">Data Ini/Fin</th>
                        <th class="head1">Conta Cont&aacute;bil</th>
                        <th class="head1">Nome</th>
                        <th class="head1">COSIF</th>
                        <th class="head1">Cod Trib</th>
                        <th class="head1">Resalva</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $_data):
                        ?>
                        <tr>                    
                            <td><?php echo $data[$i]->data_inicial; ?>/<?php echo $data[$i]->data_final; ?></td>
                            <td><?php echo $data[$i]->conta; ?></td>
                            <td><?php echo $data[$i]->nome; ?></td>
                            <td><?php echo $data[$i]->conta_cosif; ?></td>
                            <td><?php echo $data[$i]->cod_trib_cosif; ?></td>
                            <td><?php echo $data[$i]->resalva_argumento; ?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                </tbody>

            </table>


        </div>
    <?php } ?>*/