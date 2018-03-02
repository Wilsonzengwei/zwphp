<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='admin_update_pwd';
check_permit('admin_update_pwd');

if($_POST){
	$NewPassword=password($_POST['NewPassword']);
	
	
	$db->update('admin_info', "UId='{$_SESSION['ly200_AdminUserId']}'", array(
			'Password'	=>	$NewPassword
		)
	);
	
	$_SESSION['ly200_AdminPassword']=$NewPassword;
	save_manage_log('修改密码');
	js_location('password.php', get_lang('admin.update_pwd_success'));
}


include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:600px;width:95%" action="" method="post" class="act_form" enctype="multipart/form-data">
    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">修改密码</div>
    <div class="y_form1"><span class="y_title">新密码：</span><input class="y_title_txt" type="text" name="NewPassword" check="<?=get_lang('ly200.filled_out').get_lang('admin.new_password');?>!~8m|<?=get_lang('admin.new_pwd_left_len');?>*" size="98" maxlength="16"></div>
    <div class="y_form1"><span class="y_title">确认密码：</span><input class="y_title_txt" type="text" name="ReNewPassword" check="<?=get_lang('ly200.filled_out').get_lang('admin.re_password');?>!~=NewPassword|<?=get_lang('admin.repwd_dif_pwd');?>*" size="98" maxlength="16"></div>
    <div class="y_submit">
        <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="ys_input">
    </div>
<?php include('../../inc/manage/footer.php');?>