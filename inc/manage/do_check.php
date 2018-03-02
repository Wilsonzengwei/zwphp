<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

((int)$_SESSION['ly200_AdminUserId']==9 || $_SESSION['ly200_AdminUserName']=='') && js_location('/manage/', '', '.top');

function check_permit($v0='', $v1=''){	//第一个参数为大栏目权限，第二个参数为具体权限
	if((int)$_SESSION['ly200_AdminGroupId']!=9){	//非超级管理员
		global $menu;
		($v0!='' && (int)$menu[$v0]!=1) && no_permit();
		($v1!='' && (int)get_cfg($v1)!=1) && no_permit();
	}
}

function no_permit(){
	include('../../inc/manage/header.php');
	echo '<div class="no_permit">'.get_lang('ly200.no_permit').'</div>';
	include('../../inc/manage/footer.php');
	exit;
}
?>