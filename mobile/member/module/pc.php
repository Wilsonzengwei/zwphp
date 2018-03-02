<?php
include('../inc/include.php');
include($site_root_path.'/inc/fun/verification_code.php');
include($site_root_path.$mobile_url.'/member/index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta();?>
<link href="<?=$mobile_url; ?>/css/global.css" rel="stylesheet" type="text/css" />
<link href="<?=$mobile_url; ?>/css/lib.css" rel="stylesheet" type="text/css" />
<link href="<?=$mobile_url; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript" src="/js/swf_obj.js"></script>
<script language="javascript" src="/js/date.js"></script>
</head>

<body>
<?php include($site_root_path.$mobile_url.'/inc/header.php');?>
<div id="customer">
	<div class="global">
		<div class="top_title">
			<a href="javascript:;" class="close"></a>
		</div>
		<div class="content">
			<div class="supplier_tips">
				<?//=$website_language['member'.$lang]['login']['tips3']; ?>
				手机不支持商户后台操作，请用电脑登陆商户后台进行操作！
				<br />
				<a href="<?=$mobile_url; ?>" class="return trans5"><?=$website_language['member'.$lang]['login']['return']; ?></a>
			</div>
		</div>
	</div>
</div>
</body>
</html>