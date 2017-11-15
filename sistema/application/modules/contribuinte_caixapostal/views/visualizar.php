<?php
if(($data['idmensagempai'] != 0)  && ($data['idmensagempai'] != "")){
	$id = $data['idmensagempai'];
	$idmsgoriginal = $data['id'];
}else{
	$id = $data['id'];
	$idmsgoriginal = "";
}

if($data['id']){ $readonly = "readonly"; }
?>
<div id="add" class="subcontent">
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data" >
   		<input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="idmsgoriginal" value="<?php echo $idmsgoriginal; ?>" />
        <?php
		if($data['id']){
		?>
        <p>
        	<label>Autor</label>
            <span class="field">   
            	<input type="text" name="autor" id="autor" class="longinput" value="<?php if($data['autor']){ echo utf8_decode($data['autor']); }?>" <?php echo $readonly;?>/>
            </span>
        </p>
        <?php
		}
			if(isset($data['destinatario'])){
			?>
            <p>
                <label>Destinat&aacute;rio</label>
                <span class="field">   
                    <input type="text" name="destinatario" id="destinatario" class="longinput" value="<?php if($data['destinatario']){ echo utf8_decode($data['destinatario']); }?>" <?php echo $readonly;?>/>
                </span>
            </p>
            <?php
			}else{
		?>
            <p>
                <label>Destinat&aacute;rio</label>
                <span class="field">   
                    <?php
						$category_option[] = '-------------------';
						foreach($data as $_data){
							$category_option[$_data['name']] = $_data['name'];
						}
						echo form_dropdown('destinatario', $category_option, "", ' class="longinput"'); 
					?>
                </span>
            </p>
        <?php	
			}
		?>
        <p>
        	<label>Assunto</label>
            <span class="field">
                <input type="text" name="assunto" id="assunto" class="longinput" value="<?php if($data['titulo']){ echo utf8_decode($data['titulo']);}?>" <?php echo $readonly;?> />
            </span>
        </p>
        <p>
        	<label>Mensagem</label>
            <span class="field">
		        <textarea name="mensagem" <?php echo $readonly;?>><?php echo $data['texto'];?></textarea>
            </span>
        </p>
        <?php
		if($this->session->userdata['contribuinte']['user_name'] != $data['autor']){
			if($data['id']){
		?>
        <p>
			<label>Resposta</label>
			<span class="field">
				<textarea name="resposta"></textarea>
			</span>
		</p>
        <?php
			}
		?>
		<p class="stdformbutton">
			<button class="submit radius2"><?php if($data['id']){ echo "Responder"; }else{ echo "Enviar"; }?></button>
		</p>
        <?php
		}
		?>
    </form>
</div>