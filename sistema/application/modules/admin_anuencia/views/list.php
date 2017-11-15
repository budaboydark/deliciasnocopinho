<div id="list" class="subcontent">
    <a class="btn btn_print" id="cartaanuencia" href="javascript:void(0);"><span>Imprimir Carta</span></a>
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 20%" />
            <col class="con1" style="width: 20%" />
            <col class="con1" style="width: 20%" />
        </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_book" href="javascript:void(0);"><span>Escriturar</span></a></th>
                <th class="head1">C&oacute;digo</th>
                <th class="head1">Titulo</th>
                <th class="head1">Valor Atualizado</th>
                <th class="head1">Status</th>
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">
                <th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>

        <tbody data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/'); ?>">
            <?php
            $i = 0;
            foreach ($data as $_data):
                $dtbanco = array_reverse(explode('-', substr($_data['data_envio'], 0, 10)));
                $dt = mktime(0, 0, 0, $dtbanco[1], $dtbanco[0], $dtbanco[2]);
                $data_atual = explode('/', date('d/m/Y'));
                $dt2 = mktime(0, 0, 0, $data_atual[1], $data_atual[0], $data_atual[2]);
                $diferenca = $dt2 - $dt;
                $dias = (int) floor($diferenca / (60 * 60 * 24));
                $status = $this->db->where('id',$_data['idstatus'])->get('pref_status')->first_row('array');
                if ($dias >= 5) {
                    ?>
                    <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/' . $_data['id']); ?>">
                        <td align="center">
                            <span class="center"><input type="checkbox" name="id[]" value="<?php echo $_data['id']; ?>" /></span>
                        </td>
                        <td><?php echo $_data['id']; ?></td>
                        <td><?php echo $_data['titulo']; ?></td>
                        <td><?php echo DecToMoeda($_data['valor_atualizado']); ?></td>
                        <td><?php echo $status['status']; ?></td>
                    </tr>
                    <?php
                }
                $i++;
            endforeach;
            ?>	
        </tbody>
    </table>
    <form  id="form_cartaanuencia" target="_blank" method="post" action="<?php echo site_url('admin/imprimir/cartaanuencia'); ?>"></form>
</div>