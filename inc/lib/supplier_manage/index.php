<?php

$module=$_GET['module']?$_GET['module']:$_POST['module'];
$login_module_ary=array('product','index','ad_mod','product_mod','product_add','order','order_mod');	//需要登录的模块列表
$un_login_module_ary=array();	//不需要登录的模块列表

if((int)$_SESSION['member_MemberId']){	//已登录
	$module_ary=$login_module_ary;
	
}else{	//未登录
	in_array($module, $login_module_ary) && js_location("account.php?module=login&jump_url=".urlencode($_SERVER['PHP_SELF'].'?'.query_string()));	//访问需要登录的模块但用户并未登录
	$module_ary=$un_login_module_ary;	//重置模块列表
}
if(!$_SESSION['IsSupplier'] == '1'){
	echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}
!in_array($module, $module_ary) && $module=$module_ary[0];

ob_start();
echo '<script language="javascript" src="/js/cart.js"></script>';
include($site_root_path."/inc/lib/supplier_manage/module/$module.php");
//include($site_root_path.'/inc/common/footer.php');
$cart_page_contents=ob_get_contents();
ob_end_clean();
?>