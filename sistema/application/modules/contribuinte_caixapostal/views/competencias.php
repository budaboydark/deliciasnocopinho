<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="contribuinte/<?php echo $this->uri->segment(2); ?>/index/competencias">
        <colgroup>            
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 20%" />
            <col class="con1" style="width: 20%" />
        </colgroup>

        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_book" href="javascript:void(0);"><span>Declarar</span></a></th>
                <th class="head1">Compet&ecirc;ncia</th>
                <th class="head1">Situa&ccedil;&atilde;o</th>
                <th class="head1">Total Tomado (R$)</th>
                <th class="head1">Valor ISSQN</th>
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">
                <th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>
        <tbody data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/'); ?>">
            <?php
            $i = 0;
            $this->load->helper('util2');

            foreach ($data as $_data):
                ?>
                <?php
                if ($_data['situacao'] == 'A') {
                    $situacao = 'Aberta';
                } elseif ($_data['situacao'] == 'C') {
                    $situacao = 'Cancelada';
                } elseif ($_data['situacao'] == 'E') {
                    $situacao = 'Escriturada';
                }
                ?>

                <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/listaservtomados/'); ?>">
                    <td align="center" class="noclick">
                        <span class="center">
                            <?php
                            if ($_data['situacao'] == 'A') {
                                ?>
                                <input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" />
                            </span>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?php echo $_data['id']; ?>" />
                        <?php } ?>
                    </td>
                    <td class="noclick"><?php echo DataPt($_data['data_competencia']); ?></td>                                        
                    <td class="noclick"><?php echo $situacao; ?></td>
                    <td class="noclick"><?php echo 'R$ ' . number_format($_data['base_calculo'], 2, ',', '.'); ?></td>
                    <td class="noclick"><?php echo 'R$ ' . number_format($_data['vlr_issqn'], 2, ',', '.') ?></td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>
        </tbody>

    </table>
    <form  id="form_declarar" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/declarar'); ?>"></form>
</div>