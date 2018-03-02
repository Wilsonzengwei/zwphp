<?php
$module=$_GET['module']?$_GET['module']:$_POST['module'];
$login_module_ary=array('index', 'profile', 'password', 'addressbook', 'orders', 'wishlists', 'logout','pc');	//需要登录的模块列表
$un_login_module_ary=array('login', 'forgot', 'create','confirm_email');	//不需要登录的模块列表

if((int)$_SESSION['member_MemberId']){	//已登录
	if((int)$_SESSION['member_MemberId']){
		$module_ary=$login_module_ary;
		// exit;
		if($_SESSION['member_IsSupplier']&&!$_SESSION['Supplier_Login']){
			js_location("{$mobile_url}/member/pc.php");
			exit;
		}
	}else{
		$module_ary=$login_module_ary;
	}
}else{	//未登录
	in_array($module, $login_module_ary) && js_location("{$_SERVER['PHP_SELF']}?module=login&jump_url=".urlencode($_SERVER['PHP_SELF'].'?'.query_string()));	//访问需要登录的模块但用户并未登录
	$module_ary=$un_login_module_ary;	//重置模块列表
}

!in_array($module, $module_ary) && $module=$module_ary[0];
ob_start();

if((int)$_SESSION['member_MemberId']){	//已登录的，架构会员中心页面内容排版
	$where="MemberId='{$_SESSION['member_MemberId']}'";
?>
<div id="lib_member">
	<div class="rightContents">
		<div class="member_module"><?php include($site_root_path.$mobile_url."/member/module/$module.php");?></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php
}else{
	include($site_root_path.$mobile_url."/member/module/$file_base_dir/$module.php");
}

$member_page_contents=ob_get_contents();
ob_end_clean();
?>