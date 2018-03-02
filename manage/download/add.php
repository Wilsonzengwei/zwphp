<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'download';
check_permit('download', 'download.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'download/'.date('y_m_d/', $service_time);
	$Name=$_POST['Name'];
	$FilePathExt=$_POST['FilePathExt'];
	if($FilePath=up_file($_FILES['FilePath'], $save_dir)){
		$FileName=basename($_FILES['FilePath']['name']);
	}else{
		$FilePath=$FilePathExt;
		$FileName=basename($FilePathExt);
	}
	$CateId=$db->get_row_count('download_category')>1?(int)$_POST['CateId']:$db->get_value('download_category', 1, 'CateId');
	$Language=(int)$_POST['Language'];
	$BriefDescription=$_POST['BriefDescription'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	
	if(get_cfg('download.upload_pic')){
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('download.pic_width'), get_cfg('download.pic_height'));
			if(get_cfg('ly200.img_add_watermark')){
				include('../../inc/fun/img_add_watermark.php');
				img_add_watermark($BigPicPath);
			}
		}
	}
	
	$db->insert('download', array(
			'CateId'			=>	$CateId,
			'Name'				=>	$Name,
			'PicPath'			=>	$SmallPicPath,
			'FilePath'			=>	$FilePath,
			'FileName'			=>	$FileName,
			'BriefDescription'	=>	$BriefDescription,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeywords'		=>	$SeoKeywords,
			'SeoDescription'	=>	$SeoDescription,
			'Language'			=>	$Language
		)
	);
	
	$DId=$db->get_insert_id();
	get_cfg('download.description') && $Description=save_remote_img($_POST['Description'], $save_dir);
	$db->insert('download_description', array(
			'DId'			=>	$DId,
			'Description'	=>	$Description
		)
	);
	
	set_page_url('download', "DId='$DId'", get_cfg('download.page_url'), 1);
	
	$db->update('manage_operation_log', 'Operation="download_add"', array(
			'Value'	=>	$CateId
		)
	);
	
	save_manage_log('添加下载文件:'.$Name);
	
	header('Location: index.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('download_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="tr last">
            	<div class="tr_title"><?=get_lang('ly200.add').get_lang('download.modelname');?></div>
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.name');?>:</font>
                    <span class="fl">
                    	<input name="Name" type="text" value="" class="form_input" size="50" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                
                <?php if($db->get_row_count('download_category')>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $db->get_value('manage_operation_log', 'Operation="download_add"', 'Value'), 'download_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <?php if(count(get_cfg('ly200.lang_array'))>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select());?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <div class="form_row">
                	<font class="fl"><?=get_lang('download.file');?>:</font>
                    <span class="fl">
                    	<?=get_lang('download.upload_file');?>:<input name="FilePath" class="form_input" type="file" size="50" contenteditable="false"><br /><br />
                        <?=get_lang('download.file_path');?>:<input name="FilePathExt" class="form_input" type="text" value="" size="50" maxlength="200">
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            
            <?php if(get_cfg('download.upload_pic')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl"><input name="PicPath" type="file" size="50" class="form_input" contenteditable="false"></span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('download.seo_tkd')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                        <span class="fl">
                            <input name="SeoTitle" type="text" value="" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                        <span class="fl">
                            <input name="SeoKeywords" type="text" value="" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                        <span class="fl">
                            <input name="SeoDescription" type="text" value="" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
			<?php } ?>
            
            <?php if(get_cfg('download.brief_description') || get_cfg('download.description')){ ?>
                <div class="tr last">
                    <div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
                    
                    <?php if(get_cfg('download.brief_description')){?>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.brief_description');?>:</font>
                            <span class="fl">
                                <textarea name="BriefDescription" rows="5" cols="60" class="form_area"></textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php }?>
                    
                    <?php if(get_cfg('download.description')){?>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.description');?>:</div>
                            <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Contents"></textarea></div>
                            <div class="clear"></div>
                        </div>
                    <?php }?>
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