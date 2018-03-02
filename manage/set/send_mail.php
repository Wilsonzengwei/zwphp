<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='send_mail_set';
check_permit('send_mail_set');

if($_POST){
	$Module=(int)$_POST['Module'];
	$FromEmail=format_post_value($_POST['FromEmail'], 1);
	$FromName=format_post_value($_POST['FromName'], 1);
	$Smtp=format_post_value($_POST['Smtp'], 1);
	$Port=format_post_value($_POST['Port'], 1);
	$Email=format_post_value($_POST['Email'], 1);
	$Password=format_post_value($_POST['Password'], 1);
	
	$php_contents=str_replace("\t", '', "<?php
	//邮件发送设置
	\$mCfg['SendMail']['Module']=$Module;
	\$mCfg['SendMail']['FromEmail']='$FromEmail';
	\$mCfg['SendMail']['FromName']='$FromName';
	\$mCfg['SendMail']['Smtp']='$Smtp';
	\$mCfg['SendMail']['Port']='$Port';
	\$mCfg['SendMail']['Email']='$Email';
	\$mCfg['SendMail']['Password']='$Password';
	?>");
	
	write_file('/inc/set/', 'send_mail.php', $php_contents);
	
	save_manage_log('邮件发送设置');
	
	header('Location: send_mail.php');
	exit;
}

include('../../inc/manage/header.php');
?>

<div class="div_con">
    <form style="background:#fff;min-height:600px;width:95%" method="post" name="act_form" id="act_form" class="act_form" action="send_mail.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	
            <div class="tr">
                <div class="form_row">
                	<div style="float:left;width:100px;color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加角色</div>
                    <div style="float:left;color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">
                        <a class="y_input"><input class="input_r" name="Module" <?=$mCfg['SendMail']['Module']==0?'checked':'';?> type="radio" value="0" onclick="change_module(this.value);">默认设置</a>
                        <a class="y_input"><input class="input_r" name="Module" <?=$mCfg['SendMail']['Module']==1?'checked':'';?> type="radio" value="1" onclick="change_module(this.value);">自定义设置</a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="y_form1">               
            	<span class="y_title"><?=get_lang('set.send_mail.from_email');?>:</span>                    
                <input name="FromEmail" type="text" value="<?=htmlspecialchars($mCfg['SendMail']['FromEmail']);?>" class="y_title_txt" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.send_mail.from_email');?>!~*">                                    
            </div>
            <div class="y_form1">               
            	<span class="y_title"><?=get_lang('set.send_mail.from_name');?>:</span>                    
                <input name="FromName" type="text" value="<?=htmlspecialchars($mCfg['SendMail']['FromName']);?>" class="y_title_txt" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('set.send_mail.from_name');?>!~*">
            </div>
            <div class="y_form1" id="send_mail_input_0">                
            	<span class="y_title"><?=get_lang('set.send_mail.smtp');?>:</span>                    
                <input name="Smtp" type="text" value="<?=htmlspecialchars($mCfg['SendMail']['Smtp']);?>" class="y_title_txt" size="50" maxlength="100">
            </div>            
            <div class="y_form1" id="send_mail_input_1">               
            	<span class="y_title"><?=get_lang('set.send_mail.port');?>:</span>                    
                <input name="Port" type="text" value="<?=htmlspecialchars($mCfg['SendMail']['Port']);?>" class="y_title_txt" size="5" maxlength="5">
            </div>          
            <div class="y_form1" id="send_mail_input_2">              
            	<span class="y_title"><?=get_lang('set.send_mail.email');?>:</span>                   
                <input name="Email" type="text" value="<?=htmlspecialchars($mCfg['SendMail']['Email']);?>" class="y_title_txt" size="30" maxlength="100">
            </div>
            <div class="y_form1" id="send_mail_input_3">                
            	<span class="y_title"><?=get_lang('set.send_mail.password');?>:</span>                    
                <input name="Password" type="password" value="<?=htmlspecialchars($mCfg['SendMail']['Password']);?>" class="y_title_txt" size="30" maxlength="100">
            </div>
            <div class="y_submit">
                <input type="submit" value="保存" name="submit" class="ys_input">
                <input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="InfoId" value="<?=$InfoId;?>">
            </div>
            </div>
            
            
        </div>
    </form>
</div>
<script language="javascript">
function change_module(v){
	if(v==0){
		$_('send_mail_input_0').style.display=$_('send_mail_input_1').style.display=$_('send_mail_input_2').style.display=$_('send_mail_input_3').style.display='none';
	}else{
		$_('send_mail_input_0').style.display=$_('send_mail_input_1').style.display=$_('send_mail_input_2').style.display=$_('send_mail_input_3').style.display='';
	}
}

change_module(<?=(int)$mCfg['SendMail']['Module'];?>);
</script>
<?php include('../../inc/manage/footer.php');?>