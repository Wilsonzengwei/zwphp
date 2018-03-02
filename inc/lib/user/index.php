<?php

$module=$_GET['module']?$_GET['module']:$_POST['module'];
$login_module_ary=array('orders_date','index','cart','coll','orders','service_info','address','order_list');	//需要登录的模块列表
$un_login_module_ary=array();	//不需要登录的模块列表

if((int)$_SESSION['member_MemberId']){	//已登录
	$module_ary=$login_module_ary;
	// exit;
	if($_SESSION['member_IsSupplier']){
		js_location("/supplier_manage/");
		exit;
	}
}else{	//未登录
	in_array($module, $login_module_ary) && js_location("account.php?module=login&jump_url=".urlencode($_SERVER['PHP_SELF'].'?'.query_string()));	//访问需要登录的模块但用户并未登录
	$module_ary=$un_login_module_ary;	//重置模块列表
}
!in_array($module, $module_ary) && $module=$module_ary[0];

ob_start();
echo '<script language="javascript" src="/js/cart.js"></script>';
include($site_root_path."/inc/lib/user/module/$module.php");
//include($site_root_path.'/inc/common/footer.php');
$cart_page_contents=ob_get_contents();
ob_end_clean();
?>