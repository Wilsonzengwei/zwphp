<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'global_set';
check_permit('global_set');

if($_GET['action']=='delimg'){ //删除网站Logo
	$WebLogo=$_GET['WebLogo'];
	
	del_file($WebLogo);
	del_file(str_replace('s_', '', $WebLogo));
	
	$str=js_contents_code('No Logo');
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str';parent.document.getElementById('img_list').setAttribute('target','');parent.document.getElementById('img_list').setAttribute('href','javascript:void(0);');parent.document.getElementById('img_list_a').style.display='none';</script>";
	exit;
}

if($_POST){
    $WebName=format_post_value($_POST['WebName']);  
	$Pay_Number=format_post_value($_POST['Pay_Number']);	
	$ChinaIP=(int)$_POST['ChinaIP'];
	if(get_cfg('global_set.upload_logo')){
		$S_WebLogo=$_POST['S_WebLogo'];
		$save_dir=get_cfg('ly200.up_file_base_dir').'weblogo/';
		
		if($WebLogo=up_file($_FILES['WebLogo'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallWebLogo=img_resize($WebLogo, '', get_cfg('global_set.logo_width'), get_cfg('global_set.logo_height'));
		}else{
			$SmallWebLogo=$S_WebLogo;
		}
	}
	
	$php_contents="\$mCfg['WebName']='$WebName';\$mCfg['Pay_Number']='$Pay_Number';\$mCfg['WebLogo']='$SmallWebLogo';\$mCfg['ChinaIP']='$ChinaIP';\r\n\r\n";
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	$Level=format_post_value($_POST['Level']);
	$php_contents.="\$mCfg['Level']='$Level';\r\n\r\n";
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	$Phone=format_post_value($_POST['Phone'], 0);
	$Email=format_post_value($_POST['Email'], 0);
	$Address=format_post_value($_POST['Address'], 0);
	$CopyRight=format_post_value($_POST['CopyRight'], 0);
	$WorkTime=format_post_value($_POST['WorkTime'], 0);
	$LiveNum=format_post_value($_POST['LiveNum'], 0);
	$OrderLife=format_post_value($_POST['OrderLife'], 0);
	
	$php_contents.="\$mCfg['Phone']='$Phone';\r\n\$mCfg['LiveNum']='$LiveNum';\r\n\$mCfg['OrderLife']='$OrderLife';\r\n\$mCfg['WorkTime']='$WorkTime';\r\n\$mCfg['Email']='$Email';\r\n\$mCfg['Address']='$Address';\r\n\$mCfg['CopyRight']='$CopyRight';\r\n\r\n";
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$PhoneExt=format_post_value($_POST['Phone'.$field_ext]);
			$EmailExt=format_post_value($_POST['Email'.$field_ext]);
			$AddressExt=format_post_value($_POST['Address'.$field_ext]);
			$CopyRightExt=format_post_value($_POST['CopyRight'.$field_ext]);
			$WorkTime=format_post_value($_POST['WorkTime'.$field_ext]);
			$php_contents.="\$mCfg['Phone{$field_ext}']='$PhoneExt';\r\n\$mCfg['WorkTime{$field_ext}']='$WorkTime';\r\n\$mCfg['Email{$field_ext}']='$EmailExt';\r\n\$mCfg['Address{$field_ext}']='$AddressExt';\$mCfg['CopyRight{$field_ext}']='$CopyRightExt';\r\n\r\n\r\n";
		}
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------------
	
	write_file('/inc/set/', 'global.php', "<?php\r\n$php_contents?>");
	
	save_manage_log('系统全局设置');
	
	header('Location: global.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<link rel="stylesheet" href="../style.css">
<style>
    .y_title_txt{
        width:300px;height:29px;border-radius:3px;border:1px solid #ccc;color:#aaa;
    }
</style>
<div class="div_con">

    <form method="post" name="act_form" id="act_form" class="act_form" action="global.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table" id="mouse_trBgcolor_table">
        	<div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('set.global.baseinfo');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('set.global.web_name');?>:</font>
                    <span class="fl">
                        <input name="WebName" type="text" style="width: 500px;" value="<?=htmlspecialchars($mCfg['WebName']);?>" class="y_title_txt" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('set.global.web_name');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                <?php if(get_cfg('global_set.upload_logo')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('set.global.web_logo');?>:</font>
                        <span class="fl">
                            <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                            <div class="operation fl">
                                <input name="WebLogo" type="file" value="<?=htmlspecialchars($mCfg['WebLogo']);?>" class="form_file fl">
                                
                                <div class="clear"></div>
                                <input type="hidden" name="S_WebLogo" value="<?=$mCfg['WebLogo']?>" />
                            </div>
                            <a href="<?=is_file($site_root_path.$mCfg['WebLogo']) ? str_replace('s_','',$mCfg['WebLogo']) : 'javascript:void(0);'?>" class="logo_con fl" id="img_list" <?=is_file($site_root_path.$mCfg['WebLogo']) ? 'target="_blank"' : '';?> style="width:<?=get_cfg('global_set.logo_width')?>px;height:<?=get_cfg('global_set.logo_height')?>px;line-height:<?=get_cfg('global_set.logo_height')?>px;margin-left:20px">
                            	<?=is_file($site_root_path.$mCfg['WebLogo']) ? "<img src='{$mCfg['WebLogo']}' />" : 'No Logo';?>
                            </a>
                            <?php if(is_file($site_root_path.$mCfg['WebLogo'])){ ?>
                                    <a class="del fl" target="del_img_iframe" id="img_list_a" href="global.php?action=delimg&WebLogo=<?=$mCfg['WebLogo'];?>&ImgId=img_list"></a>
                                <?php } ?>
                            <div class="clear"></div>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('global_set.chinaip')){ ?>
                	
                <?php } ?>
               <!--  <div class="form_row">
                    <font class="fl">收款帐号:</font>
                    <span class="fl">
                        <input name="Pay_Number" type="text" value="<?=htmlspecialchars($mCfg['Pay_Number']);?>" class="y_title_txt" size="98" maxlength="200" check="收款帐号不能为空!~*">
                    </span>
                    <div class="clear"></div>
                </div> -->
            </div>
        	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                <div class="tr last">
                	<div class="tr_title"><?=get_lang('set.global.contactinfo').lang_name($i, 0);?></div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('set.global.phone');?>:</font>
                        <span class="fl">
							<input name="Phone<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['Phone'.lang_name($i, 1)]);?>" class="y_title_txt" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('set.global.phone');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('set.global.email');?>:</font>
                        <span class="fl">
							<input name="Email<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['Email'.lang_name($i, 1)]);?>" class="y_title_txt" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('set.global.keywords');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('set.global.address');?>:</font>
                        <span class="fl">
							<input name="Address<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['Address'.lang_name($i, 1)]);?>" class="y_title_txt" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('set.global.address');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('set.global.copyright');?>:</font>
                        <span class="fl">
							<input name="CopyRight<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($mCfg['CopyRight'.lang_name($i, 1)]);?>" class="y_title_txt" size="98" maxlength="200" check="<?=get_lang('ly200.filled_out').get_lang('set.global.copyright');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="button fr"><input type="submit" value="<?=get_lang('ly200.submit');?>" name="submit" class="form_button"></div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>