<?php
include('inc/include.php');

include('inc/lib/supplier_manage/index.php');
include('inc/manage/config/1.php');
include('inc/fun/img_resize.php');
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
<script language="javascript" src="/js/cart.js"></script>
<script language="javascript" src="/js/manage.js"></script>
</head>

<body>
<?php include('inc/common/header.php');?>
<div id="main" class="main_contents">
	<div class="w">
	<?=$cart_page_contents;?>
    </div>
</div>
<?php include('inc/common/footer.php');?>
</body>
</html>