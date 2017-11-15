<style>
label{
    font-weight: bolder;
}</style>
<div id="add" class="subcontent">
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data" >
   		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <?php 
        $dateStart = date_create($data['date']);
        $dateStart = date_format($dateStart, 'd/m/Y H:i:m');
        ?>
        <p>
            <label>Qualidade:</label>
            <span class="field">
                <?php
                    $category_value = $data['id_quality'] != '' ? htmlspecialchars($data['id_quality']) : $this->error->set_value('id_quality');
                    
                    foreach ($data_category as $_data_category):
                        $category_option[$_data_category['id']] = utf8_decode($_data_category['quality']);
                    endforeach;
                ?>
                <?php echo form_dropdown('id_quality', $category_option, $category_value,""); ?>
            </span>
        </p>
        <p>
            <label>Email</label>
            <span class="field">
                <input type="text" name="email" id="email" class="longinput" value="<?php if(htmlspecialchars($data['email']) != '') echo htmlspecialchars($data['email']); else echo $this->error->set_value('email');  ?>"   data-validate="{validate:{required:true, email: true, messages:{required:'O campo Email é obrigat&oacute;rio',email:'O campo Email é inv&aacute;lido'}}}"  />
                <?php  echo ($this->error->form_error('email')); ?>
            </span>
        </p>
        <p>
            <label>Nome:</label>
            <span class="field" style="padding-top:5px;">
                <?php if(htmlspecialchars($data['name']) != '') echo htmlspecialchars($data['name']); else echo $this->error->set_value('name');  echo ($this->error->form_error('name')); ?>
            </span>
        </p>
        <p>
            <label>Palavra:</label>
            <span class="field" style="padding-top:5px;">
                <?php if(htmlspecialchars($data['word']) != '') echo htmlspecialchars($data['word']); else echo $this->error->set_value('word');  echo ($this->error->form_error('word')); ?>
            </span>
        </p>
        <p>
            <label>P&aacute;gina:</label>
            <span class="field" style="padding-top:5px;">
                <?php if(htmlspecialchars($data['page']) != '') echo htmlspecialchars($data['page']); else echo $this->error->set_value('page');  echo ($this->error->form_error('page')); ?>
            </span>
        </p>
        <p>
            <label>Mensagem:</label>
            <span class="field" style="padding-top:5px;">
                <?php if(htmlspecialchars($data['message']) != '') echo htmlspecialchars($data['message']); else echo $this->error->set_value('message');  echo ($this->error->form_error('message')); ?>
            </span>
        </p>
        <p>
            <label>Empresa:</label>
            <span class="field" style="padding-top:5px;">
                <?php if(htmlspecialchars($data['company']) != '') echo htmlspecialchars($data['company']); else echo $this->error->set_value('company');  echo ($this->error->form_error('company')); ?>
            </span>
        </p>
        <p>
            <label>Lead gerado em:</label>
            <span class="field" style="padding-top: 5px;">   
                <?php if(htmlspecialchars($dateStart) != '') echo htmlspecialchars($dateStart); else echo $this->error->set_value('date'); echo ($this->error->form_error('date')); ?>
            </span>
        </p>
        <p>
            <label>Telefone:</label>
            <span class="field">   
                <input type="text" rel="phones" name="phone" id="phone" class="longinput" value="<?php if(htmlspecialchars($data['phone']) != '') echo htmlspecialchars($data['phone']); else echo $this->error->set_value('phone');  ?>"  />
                <?php  echo ($this->error->form_error('phone')); ?>
            </span>
        </p>
        <p>
            <label>Telefone 2:</label>
            <span class="field">   
                <input type="text" rel="phones" name="phone2" id="phone2" class="longinput" value="<?php if(htmlspecialchars($data['phone2']) != '') echo htmlspecialchars($data['phone2']); else echo $this->error->set_value('phone2');  ?>"  />
                <?php  echo ($this->error->form_error('phone2')); ?>
            </span>
        </p>
        <p>
            <label>Observa&ccedil;&atilde;o:</label>
            <span class="field">   
                <input type="text" name="obs" id="obs" class="longinput" value="<?php if(htmlspecialchars($data['obs']) != '') echo htmlspecialchars($data['obs']); else echo $this->error->set_value('obs');  ?>"  />
                <?php  echo ($this->error->form_error('obs')); ?>
            </span>
        </p>
         <p class="stdformbutton">
        	<button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>
<script>
jQuery(function($) {
    $('input[rel^="phones"]').setMask('(99) 99999999');
});
</script>