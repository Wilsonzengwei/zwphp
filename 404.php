<?php
include('inc/site_config.php');
include('inc/set/ext_var.php');
include('inc/fun/mysql.php');
include('inc/function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta('Page is unavailable');?>
<link href="/css/global.css" rel="stylesheet" type="text/css" />
<link href="/css/lib.css" rel="stylesheet" type="text/css" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body, html{background:#fff;}
</style>
</head>

<body>
<div id="lib_unavailable">
	<div class="logo"><a href="/"><img src="/images/logo.jpg" /></a></div>
	<div class="title"><?=get_domain(0);?> is temporarily unavailable</div>
	<div class="info">
		<strong>Dear:</strong><br />
		<div class="txt">
			We're sorry! Our website currently unavailable. Please check back soon, or contact us via the contact form.<br /><br />
			
			If you have any questions about unavailable or any other question,<br />
			Please Email us, We will answer your question in 24 hours.<br /><br />
			
			<a href="/" class="return">Return to the homepage</a>
		</div>
	</div>
	<div class="copyright">&copy; <?=date('Y', $service_time);?>. All Rights Reserved</div>
</div>
</body>
</html>