<ul class="breadcrumbs">
	<?php foreach($session as $_session): ?>
		<li><a href="<?php echo $_session['link']; ?>"><?php echo $_session['title']; ?></a></li>
    <?php endforeach; ?>
</ul>