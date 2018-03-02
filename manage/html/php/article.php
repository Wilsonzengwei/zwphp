<?php
$AId=(int)$_GET['AId'];
$where='1';
$AId && $where.=" and AId='$AId'";
$html_row=$db->get_all('article', $where, '*', 'MyOrder desc, AId asc');

for($html=0; $html<count($html_row); $html++){
	//---------------------------------------------------------------------------------------------------------------------------------------------
	$article_row=$html_row[$html];
	include($site_root_path.'/inc/lib/article/detail_lang_0.php');	//在适当的地方输出$article_detail_lang_0即可
	//---------------------------------------------------------------------------------------------------------------------------------------------
	
	ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="save" content="history" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta($html_row[$html]['SeoTitle'], $html_row[$html]['SeoKeywords'], $html_row[$html]['SeoDescription']);?>
<link href="/css/global.css" rel="stylesheet" type="text/css" />
<link href="/css/lib.css" rel="stylesheet" type="text/css" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
</head>

<body>
<?=$include_header_info;?>
<div id="main">
	
</div>
<?=$include_footer_info;?>
</body>
</html>
<?php
	$html_contents=ob_get_contents();
	ob_end_clean();
	$file=write_file(dirname($html_row[$html]['PageUrl']).'/', basename($html_row[$html]['PageUrl']), $html_contents, 1);
	echo get_lang('html.write_success').": {$file}<br>";
}
?>