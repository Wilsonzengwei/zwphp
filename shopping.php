<?php
include('inc/site_config.php');
include('inc/set/ext_var.php');
include('inc/function.php');
include('inc/fun/mysql.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta();?>
<link href="/css/global.css" rel="stylesheet" type="text/css" />
<link href="/css/lib.css" rel="stylesheet" type="text/css" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript" src="/js/checkform.js"></script>
<script language="javascript" src="/js/swf_obj.js"></script>
<script language="javascript" src="/js/date.js"></script>
</head>

<body>
<?php include('inc/common/cart_header.php');?>
<div class="shopping_selsect_top">
<a href="/" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a> - <?=$website_language['head'.$lang]['shipping']; ?>
</div>
    <div class="shopping_selsect">
    
    </div>
</div>
<?php include('inc/common/footer.php');?>
</body>
</html>