<div id="add" class="subcontent">
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data" >
   		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
        	<label>T&iacute;tulo</label>
            <span class="field">
            	<input type="text" name="title" id="title" class="longinput <?php if($this->error->form_error('title') != '') echo 'error'; ?>" value="<?php if(htmlspecialchars($data['title']) != '') echo htmlspecialchars($data['title']); else echo $this->error->set_value('title');  ?>" data-validate="{validate:{required:true, messages:{required:'O campo T&iacute;tulo é obrigat&oacute;rio'}}}" />
	            <?php  echo ($this->error->form_error('title')); ?>
	        </span>
        </p>
        <p class="stdformbutton">
        	<button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>