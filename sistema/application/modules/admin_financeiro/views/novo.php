<style>
    label{
        font-weight: bolder;
    }
</style>

<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <p>
            <label>Tipo de conta*</label>
            <?php
            $options = array(
                'P' => 'Pagar',
                'R' => 'Receber',
            );
            echo form_dropdown('tipo', $options,'P','large','data-validate="{validate:{required:true, messages:{required:\'O campo Tipo conta é obrigatório\'}}}"');
            ?>
        </p>

        <p>
            <label>Conta*:</label>
            <span class="field">
                <input type="text" name="conta" id="conta" class="mediuminput" data-validate="{validate:{required:true, messages:{required:'O campo Conta é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('conta')); ?>
            </span>
        </p>
        <p>
            <label>Qtd parcelas*:</label>
            <span class="field">
                <input type="text" name="qtd_parcelas" id="qtd_parcelas" class="mediuminput" data-validate="{validate:{required:true, messages:{required:'O campo Qtd parcelas é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('qtd_parcelas')); ?>
            </span>
        </p>
        <p>
            <label>Fornecedor*:</label>
            <span class="field">
                <input type="text" name="fornecedor" id="fornecedor" class="mediuminput" data-validate="{validate:{required:true, messages:{required:'O campo Fornecedor é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('fornecedor')); ?>
            </span>
        </p>
        <p>
            <label>Valor*:</label>
            <span class="field">
                <input type="text" name="valor" id="valor" class="smallinput" data-validate="{validate:{required:true, messages:{required:'O campo Valor é obrigat&oacute;rio'}}}"  />
                <?php echo ($this->error->form_error('valor')); ?>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Salvar</button>
        </p>
    </form>
</div>

