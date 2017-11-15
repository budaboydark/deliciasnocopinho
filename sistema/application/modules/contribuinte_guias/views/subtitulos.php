<style>
    label{
        font-weight: bolder;
    }</style>

<div id="list" class="subcontent">
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="contribuinte/<?php echo $this->uri->segment(2); ?>/index/list">
        <colgroup>
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
                <th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
                <th class="head1">Conta</th>
                <th class="head1">C&oacute;d Trib</th>
                <th class="head1">Vlr Cr&eacute;d R$</th>
                <th class="head1">Vlr D&eacute;b R$</th>
                <th class="head1">Rec Decl R$</th>
                <th class="head1">Dedu Rec R$</th>
                <th class="head1">Desc Dedu</th>                
                <th class="head1">Base C&aacute;lculo R$</th>
                <th class="head1">Al&iacute;q %</th>
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
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
            </tr>
        </thead>        
        <tbody data-rel="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/subtitulos/'); ?>">
            <?php $i = 0;
            foreach ($data as $_data):
                ?>
                <tr class="gradeX con<?php echo ($i % 2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('contribuintes/' . $this->uri->segment(2) . '/subtitulos/' . $_data['id']); ?>">   
                    <td>
                        <span class="center">
                            <input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" />
                        </span>    
                    </td>
                    <td><?php echo $_data['sub_titu']; ?></td>
                    <td><?php echo $_data['cod_trib_desif']; ?></td>
                    <td><?php echo $_data['valr_cred_mens']; ?></td>
                    <td><?php echo $_data['valr_debt_mens']; ?></td>
                    <td><?php echo $_data['rece_decl']; ?></td>
                    <td><?php echo $_data['dedu_rece_decl']; ?></td>
                    <td><?php echo $_data['desc_dedu']; ?></td>
                    <td><?php echo $_data['base_calc']; ?></td>
                    <td><?php echo $_data['aliq_issqn']; ?></td>
                </tr>
                <?php $i++;
            endforeach;
            ?>
        </tbody>
    </table>

</div>
<script>
    jQuery(function($) {
        $('.datas').setMask('99/99/9999');
        $('.phones').setMask('(99) 99999999');
        $('.cnpj').setMask('99.999.999/9999-99');
        $('.cep').setMask('99999-999');
    });
</script>