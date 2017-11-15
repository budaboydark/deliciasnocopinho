<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>

            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 5%" />
            <col class="con1" style="width: 12%" />
            <col class="con1" style="width: 15%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 10%" />
            <col class="con1" style="width: 40%" />
        </colgroup>
        <thead>
            <tr>

                <th class="head1"></th>
                <th class="head1">IP</th>
                <th class="head1">DataHora</th>                                                                        
                <th class="head1">M&oacute;dulo</th>
                <th class="head1">Usu&aacute;rio</th>
                <th class="head1">A&ccedil;&atilde;o</th>
                <th class="head1">Tabela</th>
            </tr>
        </thead>
        <thead>
            <tr class="unique_search">
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>		    
        <tbody data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/intimacoes/'); ?>">
            <?php $i = 0;
            foreach ($data as $_data):
                ?>
                <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/' . $this->uri->segment(2) . '/intimacoes/' . $_data['id']); ?>">
                    <td class="noclick">
                        <input type="hidden" name="delete_id[]" value="<?php echo $_data['id']; ?>" />
    <?php echo $_data['id']; ?>
                    </td>
                    <td class="noclick"><?php echo $_data['ip']; ?></td>
                    <td class="noclick"><?php echo $_data['datahora']; ?></td>
                    <td class="noclick"><?php echo $_data['modulo']; ?></td>
                    <td class="noclick"><?php echo $_data['name']; ?></td>
                    <td class="noclick"><?php echo $_data['acao']; ?></td>
                    <td class="noclick"><?php echo $_data['tabela']; ?></td>
                </tr>
                <?php $i++;
            endforeach;
            ?>
        </tbody>

    </table>
    <form  id="form_delete" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/delete'); ?>"></form>
</div>