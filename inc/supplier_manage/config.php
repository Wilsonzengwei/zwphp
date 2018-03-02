<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/
$_SESSION['WorkType'] = isset($_GET['WorkType']) ?  $_GET['WorkType'] : $_SESSION['WorkType'];
$_SESSION['WorkType'] = $_SESSION['WorkType'] ?  $_SESSION['WorkType'] : 0;
include($site_root_path.'/inc/supplier_manage/config/1.php');	//加载配置文件，0：企业网站，1：商城网站
// include($site_root_path.'/inc/supplier_manage/config/'.$_SESSION['WorkType'].'.php');	//加载配置文件，0：企业网站，1：商城网站
include($site_root_path.'/inc/supplier_manage/reload_permit.php');	//载入权限配置

$_SESSION['ly200_SupplierLanguage']='supplier_cn';
if(is_file($site_root_path."/inc/lang/{$_SESSION['ly200_SupplierLanguage']}.php")){
	include($site_root_path."/inc/lang/{$_SESSION['ly200_SupplierLanguage']}.php");
}else{
	include($site_root_path.'/inc/lang/supplier_cn.php');
}
?>