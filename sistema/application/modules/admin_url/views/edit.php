<div id="add" class="subcontent">
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/save'); ?>">
   		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
        	<label>URL</label>
            <span class="field">
            	<input type="text" name="url" id="url" class="longinput <?php if($this->error->form_error('url') != '') echo 'error'; ?>" value="<?php if(htmlspecialchars($data['url']) != '') echo htmlspecialchars($data['url']); else echo $this->error->set_value('url');  ?>"  />
	            <?php  echo ($this->error->form_error('url')); ?>
	        </span>
        </p>
        <p>
        	<label>Title</label>
            <span class="field"><input type="text" name="title" id="title" class="longinput" value="<?php if(htmlspecialchars($data['title']) != '') echo htmlspecialchars($data['title']); else echo $this->error->set_value('title');  ?>"  /></span>
        </p>
        <p>
        	<label>Keywords</label>
            <span class="field"><input type="text" name="keywords" id="keywords" class="longinput" value="<?php if(htmlspecialchars($data['keywords']) != '') echo htmlspecialchars($data['keywords']); else echo $this->error->set_value('keywords');  ?>"  /></span>
        </p>
        <p>
        	<label>Parâmetros</label>
            <span class="field"><input type="text" name="url_old" id="url_old" class="longinput" value="<?php if(htmlspecialchars($data['url_old']) != '') echo htmlspecialchars($data['url_old']); else echo $this->error->set_value('url_old');  ?>"  /></span>
        </p>
        <p>
        	<label>Descri&ccedil;&atilde;o</label>
            <span class="field"><textarea cols="80" rows="5" name="description" id="description" class="longinput"><?php if(htmlspecialchars($data['description']) != '') echo htmlspecialchars($data['description']); else echo $this->error->set_value('description');  ?></textarea></span> 
        </p>
        <p>
        	<label>Spam</label>
            <span class="field"><textarea cols="80" rows="5" name="spam" id="spam" class="longinput"><?php if(htmlspecialchars($data['spam']) != '') echo htmlspecialchars($data['spam']); else echo $this->error->set_value('spam');  ?></textarea></span> 
        </p>
        
         <p class="stdformbutton">
        	<button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>