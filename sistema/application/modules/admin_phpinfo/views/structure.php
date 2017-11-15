<div class="centercontent tables">    
	<?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->admin_model->getAlert(); ?>
    
    	<?php 
            ob_start();
            phpinfo();
            $resultado = ob_get_contents();
            ob_end_clean();

            $returnArray = array();
            preg_match_all("/\<body\>(.*)\<\/body\>/Uis", $resultado, $returnArray, PREG_SET_ORDER);
            echo '<div class="phpinfo">'.$returnArray[0][1].'</div>'; 
        ?>

    </div><!--contentwrapper-->
    
</div><!-- centercontent -->

<style>
    .phpinfo table { border-collapse:collapse; }
    .phpinfo table tr td { border: 1px solid #333; padding: 2px 5px; background: #f1f1f1;}
    .phpinfo h1 { padding-bottom: 20px; width: 100% !important; }
    .phpinfo h2 { padding-bottom: 20px; width: 100% !important; } 
</style>