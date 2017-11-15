<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 15%" />
            <col class="con1" style="width: 25%" />
            <col class="con1" style="width: 25%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 25%" />
            <col class="con1" style="width: 10%" />
        </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
                <th class="head1">Inscr. Municipal</th>
                <th class="head1">Nome Fantasia</th>
                <th class="head1">Raz&atilde;o Social</th>
                <th class="head1">CNPJ</th>
                <th class="head1">Logradouro</th>
                <th class="head1">Situa&ccedil;&atilde;o</th>
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
            $this->load->helper('date');
            $i = 0;
            foreach ($data as $_data):
                $cnpj = $_data['cnpj'];
                $_data['cnpj'] = cnpj_mask($cnpj);
                ?>
                <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/' . $_data['id']); ?>">
                    <td align="center">
                        <span class="center"><input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" /></span>
                    </td>
                    <td><?php echo $_data['inscr_municipal']; ?></td>
                    <td><?php echo $_data['nome_fantasia']; ?></td>
                    <td><?php echo $_data['razao_social']; ?></td>
                    <td><?php echo $_data['cnpj']; ?></td>
                    <td><?php echo $_data['logradouro']; ?></td>
                    <td><?php echo $_data['estado'] == 'A' ? 'Ativo' : 'Inativo'; ?></td>
                </tr>
    <?php $i++;
endforeach; ?>
        </tbody>

    </table>
    <form  id="form_delete" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/delete'); ?>"></form>
</div>