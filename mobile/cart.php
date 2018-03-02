<?php
include('../inc/site_config.php');
include('../inc/set/ext_var.php');
include('../inc/function.php');
include('../inc/fun/mysql.php');
include('../inc/lib/cart/index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?=seo_meta();?>
<link href="/mobile/css/global.css" rel="stylesheet" type="text/css" />
<link href="/mobile/css/lib.css" rel="stylesheet" type="text/css" />
<link href="/mobile/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/cart.css"/>
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript" src="/js/checkform.js"></script>
<script language="javascript" src="/js/swf_obj.js"></script>
<script language="javascript" src="/js/date.js"></script>
<script language="javascript" src="/js/cart.js"></script>
</head>

<body>
<?php include('inc/header.php');?>
<div id="main" class="main_contents">
	<div class="w">
	<?=$cart_page_contents;?>
    </div>
</div>
<?php include('inc/footer.php');?>
</body>
</html>