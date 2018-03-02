<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='translate';
check_permit('translate', 'translate.add');

if($_POST){
	$Name=$_POST['Name'];
	$Url=$_POST['Url'];
	$Language=count(get_cfg('ly200.lang_array'))?$_POST['Language']:get_cfg('ly200.lang_array.0');
	
	if(get_cfg('translate.upload_logo')){
		$save_dir=get_cfg('ly200.up_file_base_dir').'translate/'.date('y_m_d/', $service_time);
		if($BigLogoPath=up_file($_FILES['LogoPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallLogoPath=img_resize($BigLogoPath, '', get_cfg('translate.logo_width'), get_cfg('translate.logo_height'));
		}
	}
	
	$db->insert('translate', array(
			'Name'		=>	$Name,
			'Url'		=>	$Url,
			'LogoPath'	=>	$SmallLogoPath,
			'Language'	=>	$Language
		)
	);
	
	save_manage_log('添加友情链接:'.$Name);
	
	header('Location: index.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('translate_header.php')?>
	<form method="post" name="act_form" id="act_form" class="act_form" action="add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.add').get_lang('translate.modelname');?></div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('ly200.name');?>:</font>
                    <span class="fl">
                        <input name="Name" type="text" value="" class="form_input" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
        	<div class="tr last">
                <div class="form_row">
                    <font class="fl"><?=get_lang('translate.url');?>:</font>
                    <span class="fl">
                        <input name="Url" type="text" value="" class="form_input" size='60' maxlength="100">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if(count(get_cfg('ly200.lang_array'))>1){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select());?>
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
                    </div>
                </div>
                
            <?php } ?>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.add');?>" name="submit" class="form_button">
            </div>
            <div class="clear"></div>
        </div>
	</form>
</div>
<?php include('../../inc/manage/footer.php');?>