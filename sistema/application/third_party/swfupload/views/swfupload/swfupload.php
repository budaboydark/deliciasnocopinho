<script>
	var SWFU_SESSION 	= "<?php echo $swfu['session'] ?>";
	var SWFU_SIZE 	 	= "<?php echo $swfu['size'] ?>";
	var SWFU_UPLOAD_URL = "<?php echo $swfu['upload_url'] ?>";
	var SWFU_LIMIT 		= "<?php echo $swfu['limit'] ?>";
	var SWFU_FORMAT  	= "<?php echo $swfu['format'] ?>";
	var SWFU_FORMAT_DESCRIPTION = "<?php echo $swfu['format_description'] ?>";
</script>

<?php echo link_tag("application/third_party/swfupload/assets/swfupload.css"); ?>
<?php echo script_tag("application/third_party/swfupload/assets/swfupload.js"); ?>
<?php echo script_tag("application/third_party/swfupload/assets/handlers.js"); ?>
<?php echo script_tag("application/third_party/swfupload/assets/init.swfupload.js"); ?>

<div class="gallerywrapper" id="images_files" style="border: none;">
	<div class="prodhead">
		<a class="btn btn_search btn_add_foto"><span id="spanButtonPlaceholder"></span></a>
		
		<div class="text_swfupload_description">
			Os arquivos devem ter o tamanho máximo de <?php echo $swfu['size'] ?>(cada arquivo). <br />
			As fotos devem estar no formato <?php echo $swfu['format'] ?>. Clique no botão "Carregar imagens" <br />
			para localizar em seu computador as imagens que deseja incluir no anúncio.<br />
			Você pode selecionar várias fotos de uma só vez.
		</div>
		<br style="clear:both;" />
	</div>
	
	<div id="divFileProgressContainer"></div>
	<div id="thumbnails" data-rel="<?php echo $rel; ?>" data-folder="<?php echo $folder; ?>">
		 <ul class="imagelist">
	    	<?php foreach($result as $_result): $_result['folder'] = $folder; $_result['rel'] = $rel;?>
	    		<?php $this->load->view('swfupload/detail',$_result); ?>
	        <?php endforeach; ?>
	    </ul>
	</div>
	<br style="clear:both"; />
</div><!--gallerywrapper-->
<br style="clear:both"; />