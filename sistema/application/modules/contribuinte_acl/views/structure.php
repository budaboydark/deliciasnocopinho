<div class="centercontent tables">    
	<?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader notab">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>        
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->admin_model->getAlert(); ?>
    
    	<?php echo $content; ?>
    </div><!--contentwrapper-->
    
</div><!-- centercontent -->