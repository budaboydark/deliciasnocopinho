<div class="centercontent tables">
    <?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>

        <ul class="hornav">
            <li class="<?php if ($this->uri->segments[3] == '') echo 'current'; ?>"><a href="<?php echo site_url('admin/' . $this->uri->segment(2)); ?>">T&iacute;tulos</a></li>
            <!--<li class="<?php if ($this->uri->segments[4] == 'titulos' && $this->uri->segments[5] == '') echo 'current'; ?>"><a href="Javascript:void();">T&iacute;tulos</a></li>-->
        </ul>
    </div><!--pageheader-->

    <div id="contentwrapper" class="contentwrapper">
        <?php echo $this->admin_model->getAlert(); ?>
        <span id="transmitindo"></span>
        <?php echo $content; ?>
    </div><!--contentwrapper-->

</div><!-- centercontent -->