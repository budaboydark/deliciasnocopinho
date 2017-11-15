<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php echo doctype('html5')."\n"; ?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<meta name="title" content="{title}">
		<meta name="description" content="{description}">
		<meta name="keywords" content="{keywords}">
		<meta name="author" content="{author}">
		<meta name="robots" content="index,follow">
		<meta name="copyright" content="{copyright}">
		
		<meta property="og:title" content="{og_title}">
		<meta property="og:type" content="{og_type}">
		<meta property="og:url" content="{og_url}">
		<meta property="og:image" content="{og_image}">
		<meta property="og:site_name" content="{og_site_name}">
		<meta property="fb:admins" content="{fb_admins}">
		<meta property="og:description" content="{og_description}">
		
		<title>{title}</title>
		
		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo base_url(); ?>apple-touch-icon.png">
		
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

{css}
{js}
	
		<style>
		 article, aside, details, figcaption, figure, footer, header,
		 hgroup, menu, nav, section { display: block; }
		</style>
	</head>
	<body{body_cfg}>
		{top}
		
		<section>
			<article>
				{main}
			</article>
		</section>
		
		{bottom}
	</body>
</html>