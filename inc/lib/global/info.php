<?php
include('../../site_config.php');
include('../../set/ext_var.php');
include('../../fun/mysql.php');
include('../../function.php');

if($_POST['Typ']=='Newsletter'){
	$Email=$_POST['Email'];
	if(!$db->get_row_count('newsletter',"Email = '$Email'")){
		$db->insert('newsletter',array(
				'Email'		=>	$Email,
				'PostTime'	=>	time(),
		));
		js_back('Subscribe success!');
	}else{
		js_back('Your Email Already Subscribe!');
	}
}

if($_GET['currencies']!=''){
	$mCfg['ExchangeRate'][$_GET['currencies']]['Invocation']==1 && $_SESSION['Currency']=$_GET['currencies'];
	js_location($_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'/', '', '.top');
}

if($_GET['SortedBy']!=''){
	$SortedBy=(int)$_GET['SortedBy'];
	($SortedBy<0 || $SortedBy>3) && $SortedBy=0;
	$_SESSION['ProductSortedBy']=$SortedBy;
	js_location($_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'/', '', '.top');
}

if($_GET['Show']!=''){
	$Show=(int)$_GET['Show'];
	($Show<0 || $Show>2) && $Show=0;
	$_SESSION['ProductShow']=$Show;
	js_location($_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'/', '', '.top');
}

if($_GET['ListType']!=''){
	$ListType=(int)$_GET['ListType'];
	($ListType<0 || $ListType>2) && $ListType=0;
	$_SESSION['ProductListType']=$ListType;
	js_location($_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'/', '', '.top');
}
exit;
?>
<?php /*?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="save" content="history" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<?=seo_meta();?>
<script language="javascript" src="/js/lang/en.js"></script>
<script language="javascript" src="/js/global.js"></script>
</head>

<body>
<div id="lib_currency">
	<a href="#" class="index_a">Currencies:&nbsp;<span><?=$mCfg['ExchangeRate'][$_SESSION['Currency']]['Name'];?></span>&nbsp;<img src="/images/lib/currency/jt.jpg" /><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul>
		<li class="c_top">Currencies:&nbsp;<span><?=$mCfg['ExchangeRate'][$_SESSION['Currency']]['Name'];?></span>&nbsp;<img src="/images/lib/currency/jt.jpg" /></li>
		<?php
		$currencies=0;
		foreach($mCfg['ExchangeRate'] as $key=>$value){
			if(is_array($value) && $value['Invocation']==1){
				$currencies++;
		?>	
			<li><img src="/images/lib/currency/<?=$key;?>.jpg" align="absmiddle" /><a href="/inc/lib/global/info.php?currencies=<?=$key;?>" target="global_info_iframe"><?=$key;?></a></li>
		<?php
			}
		}
		?>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</div>
<div id="lib_member_info">
	<?php if((int)$_SESSION['member_MemberId']==0){?>
		<a href="<?=$member_url;?>?module=create" class="red">Sign up</a> or <a href="<?=$member_url;?>?module=login" class="red">Login</a>
	<?php }else{?>
		Welcome! <font class="fc_red"><?=htmlspecialchars($_SESSION['member_FirstName'].' '.$_SESSION['member_LastName']);?></font>&nbsp;&nbsp;&#8226; <a href="<?=$member_url;?>">My Account</a>&nbsp;&nbsp;&#8226; <a href="<?=$member_url;?>?module=logout">Sign Out</a>
	<?php }?>
</div>
<script language="javascript">
parent.$_('lib_member_info').innerHTML=$_('lib_member_info').innerHTML;
<?php if($currencies>1){?>
parent.$_('lib_currency').innerHTML=$_('lib_currency').innerHTML;
parent.$_('lib_currency').style.display='block';
<?php }?>
function add_css(str_css){
	try{
		var style=parent.document.createStyleSheet();
		style.cssText=str_css;
	}
	catch(e){
		var style=parent.document.createElement('style');
		style.type='text/css';
		style.textContent=str_css;
		parent.document.getElementsByTagName('head').item(0).appendChild(style);
	}
}
add_css('.price_item_<?=$_SESSION['Currency'];?>{display:inline;}');
</script>
</body>
</html>
<?php */?>