<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php echo doctype('html5') . "\n"; ?>
<html lang="pt-br">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8" />
        <meta name="title" content="{title}">
        <meta name="description" content="{description}">
        <meta name="keywords" content="{keywords}">
        <meta name="author" content="{author}">
        <meta name="robots" content="index,follow">
        <meta name="copyright" content="{copyright}">

        <title>{title}</title>

        <base href="<?php echo base_url(); ?>" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>apple-touch-icon.png">
        
        <?php //echo script_tag("assets/backend/js/plugins/datepicker/external/jquery/jquery.js"); //datepicker ?>
        <?php //echo script_tag("assets/backend/js/plugins/datepicker/jquery-ui.js"); //datepicker ?>

        <?php echo link_tag("assets/backend/css/style.default.css"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery-1.7.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery-ui-1.8.16.custom.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.colorbox-min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.cookie.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/tinymce/jquery.tinymce.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.dataTables.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.metadata.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.uniform.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.validate.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.tagsinput.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.meiomask.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/charCount.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/ui.spinner.min.js"); ?>
        <?php echo script_tag("assets/backend/js/plugins/jquery.alerts.js"); ?>
        <?php echo script_tag("assets/backend/js/general.js"); ?>
        <?php echo script_tag("assets/backend/js/general_tables.js"); ?>
        <?php echo script_tag("assets/backend/js/general_tinymce.js"); ?>
        <?php echo script_tag("assets/backend/js/general_validate.js"); ?>

        {css}
        {js}
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="/assets/backend/css/style.ie9.css"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="/assets/backend/css/style.ie8.css"/>
        <![endif]-->
        <!--[if lte IE 8]>
                <script language="javascript" type="text/javascript" src="/assets/backend/js/plugins/excanvas.min.js"></script>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->

    </head>
    <body {body_cfg}>
        <div class="bodywrapper">
            {top}
            {menu}
            {main}
        </div><!--bodywrapper-->
    </body>
</html>