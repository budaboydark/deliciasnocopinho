<?php
$this->load->helpers('util2');
if ($_POST) {
    $CODIGOS = $_POST['print_id']; // array de codigos de guia
    foreach ($CODIGOS as $key => $value) {
        $CODIGO = $value;

        $ordemfiscal = $this->db->where('id', $CODIGO)->get('pref_processofiscal_ordemfiscal')->first_row('array');
        $dados_contribuinte = $this->db->where('id', $ordemfiscal['idcontribuinte'])->get('pref_contribuintes')->first_row('array');
        $dados_fiscal = $this->db->where('id', $ordemfiscal['idfiscal'])->get('user')->first_row('array');
        /*
         * Dados a serem mostrados em tabelas aqui.
         *  
         */
        ?>
        <style>
            table{
                border:1px solid #000;
            }
            table thead th {
                border-bottom:1px solid #000;
                border-right: 1px solid #000;
            }
            table tbody tr td{
                border-right: 1px solid #000;
            }
            tbody{
                text-align: center;
            }
        </style>
        <table cellspacing='0'>
            <thead>
            <th>N&ordm; OF</th>
            <th>IM</th>
            <th>Raz&atilde;o Social</th>
            <th>Per&iacute;odo Inicial</th>
            <th>Per&iacute;odo Final</th>
            <th>Data Abertura</th>
            <th>Data Prevista Conclus&atilde;o</th>
            <th>Fiscal</th>
            <th>Observa&ccedil;&atilde;o</th>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $CODIGO; ?></td>
                <td><?php echo $dados_contribuinte['inscr_municipal']; ?></td>
                <td><?php echo $dados_contribuinte['razao_social']; ?></td>
                <td><?php echo DataPt($ordemfiscal['periodoinicial']); ?></td>
                <td><?php echo DataPt($ordemfiscal['periodofinal']); ?></td>
                <td><?php echo DataPt($ordemfiscal['dataabertura']); ?></td>
                <td><?php echo DataPt($ordemfiscal['dataprevistaconclusao']); ?></td>
                <td><?php echo $dados_fiscal['name']; ?></td>
                <td><?php echo $ordemfiscal['observacao']; ?></td>
            </tr>
        </tbody>
        </table>
        <?php
    }
}
?>	



