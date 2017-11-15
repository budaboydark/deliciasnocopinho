<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>Arquivo</label>
            <span class="field">
                <?php 
				echo form_upload(array('name' => 'arquivo', 'class' => 'longinput'));
                ?>
            </span>
        </p>
        
        <p class="stdformbutton">
            <button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>