<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>            
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
        </colgroup>

        <thead>
            <tr> 
                <th class="head1 nosort"><a class="btn btn_dollartag" href="javascript:void(0);"><span>Gerar</span></a></th>                
                <th class="head1">C&oacute;d Livro</th>
                <th class="head1">Compet&ecirc;ncia</th>
                <th class="head1">Base C&aacute;lculo</th>
                <th class="head1">ISS Devido</th>
                <th class="head1">ISS Pago</th>
                <th class="head1">Saldo R$</th>
                <th class="head1">Multa R$</th>
                <th class="head1">Juros R$</th>
                <th class="head1">Corre&ccedil;&atilde;o R$</th>
                <th class="head1">Total R$</th>                
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">  
                <th class="head1"></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>
        <tbody data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/gerarpasso2/'); ?>">
            <?php
            $i = 0;
            foreach ($data as $_data):
                if ($_data['situacao'] == 'A') {
                    $corlinha = 'white';
                } elseif ($_data['situacao'] == 'C') {
                    $corlinha = '#ff9999';
                } elseif ($_data['situacao'] == 'P') {
                    $corlinha = '#ccffcc';
                }

                $guias = $this->db->where('iddebito', $_data['id'])->get('pref_guias')->first_row('array');
                ?>
                <tr style="background-color: <?php echo "$corlinha"; ?>" class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/gerarpasso2/' . $_data['id']); ?>">                    
                    <td align="center">
                        <span class="center">
                            <?php
                            if (count($guias) > 0) {
                                
                            } else {
                                if ($_data['situacao'] == 'A') {
                                    ?>
                                    <input type="checkbox" name="id[]" value="<?php echo $_data['id']; ?>" />

                                <?php } else { ?>
                                    <input type="hidden" name="id" value="<?php echo $_data['id']; ?>" />
                                <?php }
                            }
                            ?>
                        </span>
                    </td>
                    <td class="noclick"><?php echo $_data['idlivro']; ?></td>
                    <td class="noclick">
                    <!--<span class="" style="visibility: hidden;position:absolute;">
                        <input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" />
                    </span>-->
                        <?php echo DataPt($_data['competencia']); ?>
                    </td>
                    <td class="noclick"><?php echo MoedaToDec($_data['base_calculo']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_issqn_devido']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_issqn_pago']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_saldo']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_multa']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_juros']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_correcao']); ?></td>
                    <td class="noclick"><?php echo MoedaToDec($_data['valor_total']); ?></td>                    
                </tr>
                <?php $i++;
            endforeach;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="11">
                    <table style="border: 1px #cccccc solid;">
                        <thead>
                        <th style="background-color: #ffffff"></th>                
                        <th>Situa&ccedil;&atilde;o ABERTO</th>
                        <th style="background-color: #ff9999"></th>
                        <th>Situa&ccedil;&atilde;o CANCELADA</th>
                        <th style="background-color: #ccffcc"></th>
                        <th>Situa&ccedil;&atilde;o QUITADO</th>
                        </thead>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <form  id="form_delete" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/gerarguiadebito'); ?>"></form>
</div>