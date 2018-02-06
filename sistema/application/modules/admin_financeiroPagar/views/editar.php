<style>
    label{
        font-weight: bolder;
    }</style>

<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/update'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <!-- uf e municipio -->
        <?php
            $data['vencimento'] = date_create($data['vencimento']);
            $data['vencimento'] = date_format($data['vencimento'], 'd/m/Y H:i:m');
        ?>
        <p>
            <label>Vencimento</label>
            <span class="field">
                <input value="<?php if (htmlspecialchars($data['vencimento']) != '') echo htmlspecialchars($data['vencimento']); else echo $this->error->set_value('vencimento'); ?>" type="text" name="data_vencimento" id="data_vencimento" class="longinput datas" data-validate="{validate:{required:true, messages:{required:'O campo Vencimento é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('vencimento')); ?>
            </span>
        </p>
        <p>
            <label>Valor*:</label>
            <span class="field">
                <input value="<?php if (htmlspecialchars($data['valorparcela']) != '') echo htmlspecialchars($data['valorparcela']); else echo $this->error->set_value('valorparcela'); ?>" type="text" name="valor" id="valor" class="smallinput" data-validate="{validate:{required:true, messages:{required:'O campo Valor é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('valor')); ?>
            </span>
        </p>
        <p>
            <label>Situa&ccedil;&atilde;o*:</label>
            <span class="field">
                <?php
                $status_option = array('N' => 'A pagar', 'S' => 'Pago');
                ?>
                <?php echo form_dropdown('status', $status_option, $data['status'], ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo Situa&ccedil;&atilde;o é obrigat&oacute;rio\'}}}"'); ?>
                <label for="status" generated="true" class="error" style="display: none;">O campo Situa&ccedil;&atilde;o é obrigat&oacute;rio</label>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Salvar</button>
        </p>
    </form>
</div>
<script>
jQuery(function($) {
    $('.datas').setMask('99/99/9999');
    $('.phones').setMask('(99) 99999999');
    $('.cnpj').setMask('99.999.999/9999-99');
    $('.cep').setMask('99999-999');
});
</script>
