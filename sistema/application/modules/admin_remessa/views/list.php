<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable3" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 15%" />
            <col class="con1" style="width: 25%" />
        </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_wifi" id="remessa" href="javascript:void(0);"><span>Transmitir</span></a></th>
                <th class="head1">T&iacute;tulo</th>
                <th class="head1">Valor R$</th>
                <th class="head1">Valor Atual R$</th>
                <th class="head1">CPF/CNPJ</th>
                <th class="head1">Devedor</th>
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
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>

        <tbody data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/'); ?>">
            <?php
            $i = 0;
            foreach ($data as $_data):
                $estatus = $this->db->where('id', $_data['idstatus'])->get('pref_status')->first_row('array');
                if ($_data['id_remessa']) {
                    $fundo = "#D9EDF7";
                } else {
                    $fundo = "#FFFFFF";
                }
                $msg = '';
                if ($_data['id_remessa']) {
                    $remessa_log = $this->db->get('pref_log_remessa', array('id_remessa' => $_data['id_remessa']))->first_row('object');
                    $dados2 = simplexml_load_string($remessa_log->log_texto);
                    foreach ($dados2->comarca as $comarca) {
                        
                        $msg = $this->db->get('pref_mensagens_remessa',array('codigo'=>$comarca->codigo))->first_row('object');
                    }
                }
                ?>
                <tr style="background-color:<?php echo $fundo; ?>" class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/' . $_data['id']); ?>">
                    <td class="noclick" align="center">
                        <?php if (!$_data['id_remessa']) { ?>
                            <span class="center"><input type="checkbox" name="id[]" value="<?php echo $_data['id']; ?>" /></span>
                        <?php } ?>
                    </td>
                    <td class="noclick"><?php echo $_data['titulo']; ?></td>
                    <td class="noclick"><?php echo DecToMoeda($_data['saldo_principal']); ?></td>
                    <td class="noclick"><?php echo DecToMoeda($_data['valor_atualizado']); ?></td>
                    <td class="noclick"><?php echo $_data['cpfcnpjdevedor']; ?></td>
                    <td class="noclick"><?php echo $_data['devedor']; ?></td>
                    <td class="noclick"><?php
                        if ($msg) {
                            echo $msg->descricao;
                        } else {
                            echo $estatus['status'];
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>	
        </tbody>
    </table>
    <form  id="form_enviar" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/enviar'); ?>"></form>
</div>