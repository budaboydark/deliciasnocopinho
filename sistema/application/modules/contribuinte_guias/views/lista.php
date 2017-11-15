
    <div id="list" class="subcontent">    

        <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="contribuinte/<?php echo $this->uri->segment(2); ?>/index/lista">
            <colgroup>            
                <col class="con1" style="width: 20%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 20%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 20%" />
            </colgroup>
            <thead>
                <tr>
                    <th class="head1 nosort">
                        <a class="btn btn_print" id="print" style="cursor: pointer;" ><span>Imprimir</span></a>&nbsp;
                        <a class="btn btn_dollartag" id="segundavia" href="javascript:void(0);"><span>2&ordf; Via</span></a>
                    </th>
                    <th class="head1">C&oacute;digo Guia</th>
                    <th class="head1">Vencimento</th>
                    <th class="head1">Emiss&atilde;o</th>
                    <th class="head1">Total R$</th>                    
                    <th class="head1">Situa&ccedil;&atilde;o</th>
                    <th class="head1">Motivo Cancelamento</th>
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
                </tr>
            </thead>
            <tbody >

                <?php
                $i = 0;
                foreach ($data as $_data):
                    ?>
                    <tr  class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" >
                        <td align="center" style="cursor:default;">
                            <span class="center"><input type="checkbox" name="print_id[]" value="<?php echo $_data['id']; ?>" /></span>
                        </td>
                        <td><?php echo $_data['id']; ?></td>
                        <td><?php echo DataPt($_data['data_vencimento']); ?></td>
                        <td><?php echo DataPt($_data['data_emissao']); ?></td>
                        <td><?php echo MoedaToDec($_data['valor_total']); ?></td>
                        <td>
                            <?php
                            if ($_data['situacao'] == 'A') {
                                echo 'Aberto';
                            } elseif ($_data['situacao'] == 'P') {
                                echo 'Paga';
                            } elseif ($_data['situacao'] == 'C') {
                                echo 'Cancelada: ';
                                ;
                            }
                            ?>
                        </td>
                        <td><?php echo $_data['motivo_cancelamento']; ?></td>
                    </tr>
                    <?php
                    $i++;
                endforeach;
                ?>

            </tbody>

        </table>

        <form method="post" target="_blank" id="guias_imprimir" action="<?php echo site_url('contribuinte/boleto/guia'); ?>" ></form>
        <form method="post" target="_blank" id="segundavia_imprimir" action="<?php echo site_url('contribuinte/boleto/segundavia'); ?>" ></form>
    </div>
