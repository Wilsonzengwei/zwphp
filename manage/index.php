<?php
include('../inc/site_config.php');
include('../inc/set/ext_var.php');
include('../inc/fun/mysql.php');
include('../inc/function.php');
include('../inc/manage/config.php');

if(isset($_GET['ver'])){
	$version=base64_decode($_GET['ver']);
	setcookie('version', $version);
	js_location('/manage');
}

$n=date('w');
//$n=rand(0, 6);

if((int)$_GET['setTips']!=1){
	$_SESSION['ly200_AdminLoginTips']=get_lang('login.tips');
}
//$_SESSION['ly200_AdminUserId']=$_SESSION['ly200_AdminUserName']=$_SESSION['ly200_AdminGroupId']=1;
if((int)$_SESSION['ly200_AdminUserId']!=0){
	header('Location: main.php');
	exit;
}

if($_POST){
	$username=$_POST['username'];
	$password=password($_POST['password']);
	$log_excode=strtoupper($_POST['excode']);
	
	if($log_excode!=$_SESSION[md5('manage')] || $_SESSION[md5('manage')]==''){
		$_SESSION['ly200_AdminLoginTips']=get_lang('login.tips_v_code_error');
	}else{
		if($user_info=$db->get_one('admin_info', "UserName='$username' and Del=1")){	
		//if($user_info['Del'] != '1'){	
			if($user_info['Status'] != '1'){
				$_SESSION['ly200_AdminLoginTips']=get_lang('login.tips_locked');
			}elseif($user_info['Password']==$password){
				
				$db->update('admin_info', "UId='{$user_info['UId']}'", array(

						'LastLoginTime'	=>	$service_time,
						'LastLoginIp'	=>	get_ip()
					)
				);
				
				$_SESSION['ly200_AdminUserId']=(int)$user_info['UId'];
				$_SESSION['ly200_AdminUserName']=$user_info['UserName'];
				$_SESSION['ly200_AdminPassword']=$user_info['Password'];
				$_SESSION['ly200_AdminLastLoginTime']=$user_info['LastLoginTime']?$user_info['LastLoginTime']:$service_time;
				$_SESSION['ly200_AdminLastLoginIp']=$user_info['LastLoginIp']?$user_info['LastLoginIp']:get_ip();
				$_SESSION['ly200_AdminNowLoginTime']=$service_time;
				$_SESSION['ly200_AdminGroupId']=$user_info['AUersName'];
				$_SESSION['ly200_AdminSalesmanName']=$user_info['Name'];
				save_manage_log(get_lang('login.success'));
				unset($_SESSION['ly200_AdminLoginTips'], $_SESSION['tmp_username'], $_SESSION[md5('manage')]);
				
				header('Location: main.php');
				exit;
			}else{
				$_SESSION['ly200_AdminLoginTips']=get_lang('login.tips_failed');
			}
		}else{
			$_SESSION['ly200_AdminLoginTips']=get_lang('login.tips_failed');
		}
	}
	$_SESSION['tmp_username']=stripslashes($username);
	$_SESSION[md5('manage')]='';
	unset($_SESSION[md5('manage')]);
	
	save_manage_log("<font class='fc_red'>$username</font>尝试登录后台，返回状态:{$_SESSION['ly200_AdminLoginTips']}");
	
	header('Location: index.php?setTips=1');
	exit;
}

include('../inc/fun/verification_code.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<title><?=get_lang('ly200.system_title');?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">html,body{width:100%;height:100%;overflow:hidden;}.ver{ margin-left:214px; color:#429eee; text-decoration:underline; font-size:14px;}.ver:hover{text-decoration:underline;}</style>
<script language="javascript" src="/js/lang/manage.php"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript" src="/js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="/js/manage.js"></script>
</head>

<body>
<img style="position:absolute;width:100%;height:100%" src="images/login_bg.jpg" alt="" />
<img style="position:absolute;width:100%;height:100%" src="images/login_bg.jpg" alt="" />
<img style="position:absolute;width:100%;height:100%" src="images/login_bg.jpg" alt="" />
<img style="position:absolute;width:100%;height:100%" src="images/login_bg.jpg" alt="" />
<img style="position:absolute;width:100%;height:100%" src="images/login_bg.jpg" alt="" />
<div id="new_login">
	<div class="login_title_en">EAEGLSELL</div>
    <div class="login_title_cn">鹰洋 • 后台管理系统</div>
    <div class="login_form_div">
    	<form action="index.php" method="post" name="login_form" id="login_form" onSubmit="return login(this);">
        	<div class="item_rows">
            	<input type="text" name="username" id="username" class="username" maxlength="20" value="<?=htmlspecialchars($_SESSION['tmp_username'])?>" tabindex="1" autocomplete="off" placeholder="账号" />
            </div>
            <div class="item_rows">
            	<input type="password" name="password" id="password" class="password" maxlength="20" value="" tabindex="2" autocomplete="off" placeholder="密码"/>
            </div>
            <div class="item_rows">
            	<input type="text" name="excode" id="excode" class="excode fl" maxlength="4" value="" tabindex="3" autocomplete="off" placeholder="验证码"/>
                <div class="code fr"><?=verification_code('manage');?>&nbsp;&nbsp;<a href='javascript:void(0);' onclick='this.blur(); obj=$_("<?=md5('manage');?>"); obj.src=obj.src+Math.random(); return false' class="blue"><?=get_lang('login.reload_v_code');?></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="clear"></div>
            </div>
             <div class="tips fc_red" style="background:url(images/new_form_bg.png);text-align:center;font-size: 12px;"><?=$_SESSION['ly200_AdminLoginTips'];?></div>
            <div class="icon_rows"><input type="image" id="c" class="fl" src="images/new_login.png" /></div>
        </form>
    </div>
</div>



<div id="info">
    <div class="time" id="timeElem"><?=date('H:i')?></div>
    <div class="date"><?=date('n月j日')?> / <?=$week_ary[$n]?></div>
    <div class="con"><?=$week_con_ary[$n]?></div>
</div>


<div id="copyright">©<?=date('Y')?> 深圳市（前海）鹰洋国际贸易有限公司 </div>
<script>
$(function(){
	new_page_init();
	time_count()
	rows_change();
	new_version_animate();	
})
$(function(){
	var aget=window.localStorage.getItem('loginname');
	$('.username').val(aget);
	$("#c").click(function(){		
		var a=$('.username').val();
		window.localStorage.setItem('loginname',a);		
	})
})
</script>

</body>
</html>