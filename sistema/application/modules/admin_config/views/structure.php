<div class="centercontent tables">    
	<?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
        
        <ul class="hornav">
            <li class="current"><a href="#list">Listar</a></li>
        </ul>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->admin_model->getAlert(); ?>
    
    	<?php echo $content; ?>
    </div><!--contentwrapper-->
    
</div><!-- centercontent -->