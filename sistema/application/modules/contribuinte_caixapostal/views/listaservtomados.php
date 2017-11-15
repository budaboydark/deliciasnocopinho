<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="contribuinte/<?php echo $this->uri->segment(2); ?>/index/list" >
        <colgroup>            
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 30%" />
            <col class="con1" style="width: 10%" />            
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
        </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_stop" href="javascript:void(0);"><span>Cancelar</span></a></th>
                <th class="head1">Data NF</th>
                <th class="head1">R Social Prestador</th>
                <th class="head1">Tpo Prestador</th>                
                <th class="head1">N&ordm; NF</th>                
                <th class="head1">Valor NF</th>
                <th class="head1">Al&iacute; %</th>
                <th class="head1">R$ ISS Retido</th>
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">
                <th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>
        <tbody data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/nftomada/'); ?>" >
            <?php
            $i = 0;
            $this->load->helper('util2');
            foreach ($data as $_data):
                ?>
                <?php
                if ($_data['situacao'] == 'N') {
                    $situacao = 'Normal';
                    $corlinha = 'white';
                } elseif ($_data['situacao'] == 'C') {
                    $situacao = 'Cancelada';
                    $corlinha = '#ff9999';
                } elseif ($_data['situacao'] == 'E') {
                    $situacao = 'Escriturada';
                    $corlinha = '#ccffcc';
                }

                // Tipo prestador 1 PF 2 PJ 3 PJ fora municipio 4 PJ fora pais
                if ($_data['tipo_prestador'] == '1') {
                    $tipoprestador = 'PF';
                } elseif ($_data['tipo_prestador'] == '2') {
                    $tipoprestador = 'PJ';
                } elseif ($_data['tipo_prestador'] == '3') {
                    $tipoprestador = 'PJ Fora';
                } elseif ($_data['tipo_prestador'] == '4') {
                    $tipoprestador = 'PJ Fora Pa&iacute;s';
                }
                ?>

                <tr style="background-color: <?php echo "$corlinha"; ?>" class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/nftomada/'); ?>">
                    <td align="center">
                        <span class="center">
                            <?php
                            if ($_data['situacao'] == 'N') {
                                ?>
                                <input type="checkbox" name="id[]" value="<?php echo $_data['id']; ?>" />

                            <?php } else { ?>
                                <input type="hidden" name="id" value="<?php echo $_data['id']; ?>" />
                            <?php } ?>
                        </span>
                    </td>
                    <td><?php echo $_data['dataservico_prestador']; ?></td>                                        
                    <td><?php echo $_data['razaosocial_prestador']; ?></td>
                    <td><?php echo $tipoprestador; ?></td>
                    <td><?php echo $_data['nronf_prestador']; ?></td>                    
                    <td><?php echo 'R$ ' . number_format($_data['valornf_prestador'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($_data['aliquota_prestador'], 2, ',', '.'); ?></td>
                    <td><?php echo 'R$ ' . number_format($_data['valorissqn'], 2, ',', '.') ?></td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">
                <table style="border: 1px #cccccc solid;">
                    <thead>
                        <th style="background-color: #ffffff"></th>                
                        <th>Situa&ccedil;&atilde;o ABERTA</th>
                        <th style="background-color: #ff9999"></th>
                        <th>Situa&ccedil;&atilde;o CANCELADA</th>
                        <th style="background-color: #ccffcc"></th>
                        <th>Situa&ccedil;&atilde;o ESCRITURADA</th>
                    </thead>
                </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" id="stitulo" value="cancelar" />
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/cancelar'); ?>" ></form>
    <form  id="form_declarar" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/declarar'); ?>"></form>
</div>