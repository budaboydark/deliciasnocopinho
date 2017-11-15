<div id="list" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data">
    	
    	<?php foreach($config as $data): ?>
    		<?php if($data['group'] != $_group): ?>
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable">
                    <thead>
                        <tr>
                            <th colspan="2" class="head1"><h4><?php echo str_replace('_',' ',$data['group']); ?></h4></th>
                        </tr>
                    </thead>
                </table>
            <?php endif; ?>
            <p>
            	<label><?php echo $data['title']; ?></label>
                <span class="field">
                	<?php
                		switch($data['input_type']){
                			default:
	                		case 'text':
	                			echo form_input(array('name'=>$data['option'],'value'=>$data['value'],'class'=>'longinput'));
	                		break;
	                		case 'textarea':
	                			echo form_textarea(array('cols'=>'80','rows'=>'5','name'=>$data['option'],'value'=>$data['value'],'class'=>'longinput'));
	                		break;
	                		case 'image':
	                			echo form_upload(array('name'=>$data['option'],'class'=>'longinput'));
	                			echo '<br />';
	                			if(read_file($this->admin_model->config_directory.$data['value']))
	                				echo img(array('src'=>image("media/".$this->admin_model->config_directory.$data['value'], "100x0")  ,'class'=>'thumb_image'));
	                		break;
                		}                	
                	?>
                </span>
            </p>
             
        <?php
        		$_group = $data['group'];
        	endforeach; 
        ?>

        <p class="stdformbutton">
        	<button class="submit radius2">Enviar</button>
        </p>
        
    </form>
</div>