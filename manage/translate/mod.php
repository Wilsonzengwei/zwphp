<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='translate';
check_permit('translate', 'translate.mod');

if($_GET['action']=='delimg'){
	$LId=(int)$_POST['LId'];
	$LogoPath=$_GET['LogoPath'];
	
	del_file($LogoPath);
	del_file(str_replace('s_', '', $LogoPath));
	
	$db->update('translate', "LId='$LId'", array(
			'LogoPath'	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str'; parent.document.getElementById('img_list_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$LId=(int)$_POST['LId'];
	$query_string=$_POST['query_string'];
	$Name=$_POST['Name'];
	$Url=$_POST['Url'];
	$Language=count(get_cfg('ly200.lang_array'))?$_POST['Language']:get_cfg('ly200.lang_array.0');
	
	if(get_cfg('translate.upload_logo')){
		$S_LogoPath=$_POST['S_LogoPath'];
		$save_dir=get_cfg('ly200.up_file_base_dir').'translate/'.date('y_m_d/', $service_time);
		
		if($BigLogoPath=up_file($_FILES['LogoPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallLogoPath=img_resize($BigLogoPath, '', get_cfg('translate.logo_width'), get_cfg('translate.logo_height'));
			del_file($S_LogoPath);
			del_file(str_replace('s_', '', $S_LogoPath));
		}else{
			$SmallLogoPath=$S_LogoPath;
		}
	}
	
	$db->update('translate', "LId='$LId'", array(
			'Name'		=>	$Name,
			'Url'		=>	$Url,
			'LogoPath'	=>	$SmallLogoPath,
			'Language'	=>	$Language
		)
	);
	
	save_manage_log('编辑友情链接:'.$Name);
	
	header("Location: index.php?$query_string");
	exit;
}

$LId=(int)$_GET['LId'];
$query_string=query_string('LId');

$translate_row=$db->get_one('translate', "LId='$LId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('translate_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('translate.modelname');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('ly200.name');?>:</font>
                    <span class="fl">
                        <input name="Name" type="text" value="<?=htmlspecialchars($translate_row['Name']);?>" class="form_input" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
        	<div class="tr last">
                <div class="form_row">
                    <font class="fl"><?=get_lang('translate.url');?>:</font>
                    <span class="fl">
                        <input name="Url" type="text" value="<?=htmlspecialchars($translate_row['Url']);?>" class="form_input" size='60' maxlength="100">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select($translate_row['Language']));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('translate.upload_logo')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?></div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.logo');?>:</font>
                        <span class="fl">
                            <input name="LogoPath" type="file" size="50" class="form_input" contenteditable="false"><br>
                        </span>
                        <div class="clear"></div>
                        <?php if(is_file($site_root_path.$translate_row['LogoPath'])){?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
                            <tr>
                                <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list"><a href="<?=str_replace('s_', '', $translate_row['LogoPath']);?>" target="_blank"><img src="<?=$translate_row['LogoPath'];?>" <?=img_width_height(70, 70, $translate_row['LogoPath']);?> /></a><input type='hidden' name='S_LogoPath' value='<?=$translate_row['LogoPath'];?>'></td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a">&nbsp;<a href="mod.php?action=delimg&LId=<?=$LId;?>&LogoPath=<?=$translate_row['LogoPath'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                            </tr>
                        </table>
                        <?php }?>
                    </div>
                </div>
                
            <?php } ?>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="LId" value="<?=$LId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>