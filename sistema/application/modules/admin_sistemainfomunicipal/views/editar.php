<style>
label{
    font-weight: bolder;
}</style>
<div id="add" class="subcontent">
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data" >
   		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <?php 
        $data['data_inicio'] = date_create($data['data_inicio']);
        $data['data_inicio'] = date_format($data['data_inicio'], 'd/m/Y H:i:m');
        $data['data_fim'] = date_create($data['data_fim']);
        $data['data_fim'] = date_format($data['data_fim'], 'd/m/Y H:i:m');
        ?>
        <p>
            <label>C&oacute;d Trib DESIF*:</label>
            <span class="field">
                <?php
                    $category_value = $data['des_trib_desif'] != '' ? htmlspecialchars($data['des_trib_desif']) : $this->error->set_value('des_trib_desif');
                    $category_option[''] = 'Selecione um t&iacute;tulo';
                    foreach ($data_category as $_data_category):
                        $category_option[$_data_category['id']] = utf8_decode($_data_category['des_trib_desif']);
                    endforeach;
                ?>
                <?php echo form_dropdown('idtitulo', $category_option, $category_value,' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo T&iacute;tulo é obrigat&oacute;rio\'}}}"'); ?>
                <label for="idtitulo" generated="true" class="error" style="display: none;">O campo T&iacute;tulo é obrigat&oacute;rio</label>
            </span>
        </p>        
        <p>
            <label>C&oacute;d de Trib Municipal*:</label>
            <span class="field">
                <input type="text" name="cod_trib_muni" id="cod_trib_muni" class="longinput" value="<?php if(htmlspecialchars($data['cod_trib_muni']) != '') echo htmlspecialchars($data['cod_trib_muni']); else echo $this->error->set_value('cod_trib_muni');  ?>"   data-validate="{validate:{required:true, messages:{required:'O campo COD TRIB MUNICIPAL é obrigat&oacute;rio'}}}"  />
                <?php  echo ($this->error->form_error('cod_trib_muni')); ?>
            </span>
        </p>
        <p>
            <label>Al&iacute;quota %:</label>
            <span class="field">
                <input type="text" name="val_aliq" id="val_aliq" class="longinput" value="<?php if(htmlspecialchars($data['val_aliq']) != '') echo htmlspecialchars($data['val_aliq']); else echo $this->error->set_value('val_aliq');  ?>"   data-validate="{validate:{required:true, messages:{required:'O campo ALIQUOTA é obrigat&oacute;rio'}}}"  />
                <?php  echo ($this->error->form_error('val_aliq')); ?>
            </span>
        </p>
        <p>
            <label>Data In&iacute;cio*:</label>
            <span class="field">
                <input type="text" name="dat_inic" id="dat_inic" class="longinput datas" value="<?php if(htmlspecialchars($data['dat_inic']) != '') echo htmlspecialchars($data['dat_inic']); else echo $this->error->set_value('dat_inic');  ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Data In&iacute;cio é obrigat&oacute;rio'}}}"  />
                <?php  echo ($this->error->form_error('dat_inicio')); ?>
            </span>
        </p>
        <p>
            <label>Data Fim:</label>
            <span class="field">
                <input type="text" name="dat_fim" id="dat_fim" class="longinput datas" value="<?php if(htmlspecialchars($data['dat_fim']) != '') echo htmlspecialchars($data['dat_fim']); else echo $this->error->set_value('dat_fim');  ?>" />
                <?php  echo ($this->error->form_error('dat_fim')); ?>
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