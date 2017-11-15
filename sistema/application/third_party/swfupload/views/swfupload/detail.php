<li data-file="<?php echo $file; ?>">
	<?php echo img(image('media/upload/'.$folder.'/'.$file,'250x150')); ?>
	<span>
		<a href="swfupload/edit/<?php echo $rel; ?>/<?php echo $file; ?>/load" class="name ajax"><?php echo $title; ?></a>
		<a href="swfupload/edit/<?php echo $rel; ?>/<?php echo $file; ?>/load" class="edit ajax"></a>
		<a href="<?php echo 'upload/'.$folder.'/'.$file; ?>" class="view"></a>
		<a class="delete"></a>
	</span>
	<div class="move_icon"><img src="assets/backend/img/move.png"  height="17" alt="Para ordenar arraste suas imagens" title="Para ordenar arraste suas imagens" /></div>
</li>

