<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable3" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 40%" />
        </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
                <th class="head1">C&oacute;d.Cart&oacute;rio</th>
                <th class="head1">Nome</th>
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">
                <th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>
        
        <tbody data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/'); ?>">
            <?php $i = 0;
            foreach ($data as $_data): ?>
                <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/editar/' . $_data['id']); ?>">
                    <td align="center">
                        <span class="center"><input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" /></span>
                    </td>
                    <td><?php echo $_data['codigo']; ?></td>
                    <td><?php echo $_data['nome']; ?></td>
                </tr>
    <?php $i++;
endforeach; ?>	
        </tbody>
    </table>
    <form  id="form_delete" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/delete'); ?>"></form>
</div>