<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'download';
check_permit('download', 'download.mod');

if($_GET['action']=='delimg'){
	$DId=(int)$_POST['DId'];
	$PicPath=$_GET['PicPath'];
	
	del_file($PicPath);
	del_file(str_replace('s_', '', $PicPath));
	
	$db->update('download', "DId='$DId'", array(
			'PicPath'	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str'; parent.document.getElementById('img_list_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'download/'.date('y_m_d/', $service_time);
	$DId=(int)$_POST['DId'];
	$query_string=$_POST['query_string'];
	$Name=$_POST['Name'];
	$FilePathExt=$_POST['FilePathExt'];
	$S_FilePath=$_POST['S_FilePath'];
	$S_FileName=$_POST['S_FileName'];
	if($FilePath=up_file($_FILES['FilePath'], $save_dir)){
		$FileName=basename($_FILES['FilePath']['name']);
		del_file($S_FilePath);
	}else{
		$FilePath=$FilePathExt;
		$FileName=$S_FileName;
		$S_FilePath!=$FilePath && $FileName=basename($FilePath);
	}
	$CateId=$db->get_row_count('download_category')>1?(int)$_POST['CateId']:$db->get_value('download_category', 1, 'CateId');
	$Language=(int)$_POST['Language'];
	$BriefDescription=$_POST['BriefDescription'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	
	if(get_cfg('download.upload_pic')){
		$S_PicPath=$_POST['S_PicPath'];
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('download.pic_width'), get_cfg('download.pic_height'));
			if(get_cfg('ly200.img_add_watermark')){
				include('../../inc/fun/img_add_watermark.php');
				img_add_watermark($BigPicPath);
			}
			del_file($S_PicPath);
			del_file(str_replace('s_', '', $S_PicPath));
		}else{
			$SmallPicPath=$S_PicPath;
		}
	}
	
	$db->update('download', "DId='$DId'", array(
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
	
	if(get_cfg('download.description')){
		$Description=save_remote_img($_POST['Description'], $save_dir);
		$db->update('download_description', "DId='$DId'", array(
				'Description'	=>	$Description
			)
		);
	}
	
	set_page_url('download', "DId='$DId'", get_cfg('download.page_url'), 1);
	
	save_manage_log('编辑下载文件:'.$Name);
	
	header("Location: index.php?$query_string");
	exit;
}

$DId=(int)$_GET['DId'];
$query_string=query_string('DId');

$download_row=$db->get_one('download', "DId='$DId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('download_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="tr last">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('download.modelname');?></div>
                <div class="form_row">
                	<font class="fl"><?=get_lang('ly200.name');?>:</font>
                    <span class="fl">
                    	<input name="Name" type="text" value="<?=htmlspecialchars($download_row['Name'])?>" class="form_input" size="50" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                
                <?php if($db->get_row_count('download_category')>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $download_row['CateId'], 'download_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <?php if(count(get_cfg('ly200.lang_array'))>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select($download_row['Language']));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <div class="form_row">
                	<font class="fl"><?=get_lang('download.file');?>:</font>
                    <span class="fl">
                    	<?=get_lang('download.upload_file');?>:<input name="FilePath" class="form_input" type="file" size="50" contenteditable="false"><br /><br />
                        <?=get_lang('download.file_path');?>:<input name="FilePathExt" class="form_input" type="text" value="<?=htmlspecialchars($download_row['FilePath']);?>" size="50" maxlength="200">
                        <input type='hidden' name='S_FilePath' value='<?=htmlspecialchars($download_row['FilePath']);?>'>
                        <input type='hidden' name='S_FileName' value='<?=htmlspecialchars($download_row['FileName']);?>'>
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
						<?php if(is_file($site_root_path.$download_row['PicPath'])){?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
                            <tr>
                                <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list"><a href="<?=str_replace('s_', '', $download_row['PicPath']);?>" target="_blank"><img src="<?=$download_row['PicPath'];?>" <?=img_width_height(70, 70, $download_row['PicPath']);?> /></a><input type='hidden' name='S_PicPath' value='<?=$download_row['PicPath'];?>'></td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a">&nbsp;<a href="mod.php?action=delimg&DId=<?=$DId;?>&PicPath=<?=$download_row['PicPath'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                            </tr>
                        </table>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('download.seo_tkd')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                        <span class="fl">
                            <input name="SeoTitle" type="text" value="<?=htmlspecialchars($download_row['SeoTitle'])?>" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                        <span class="fl">
                            <input name="SeoKeywords" type="text" value="<?=htmlspecialchars($download_row['SeoKeywords'])?>" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                        <span class="fl">
                            <input name="SeoDescription" type="text" value="<?=htmlspecialchars($download_row['SeoDescription'])?>" class="form_input" size="98" maxlength="200">
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
                                <textarea name="BriefDescription" rows="5" cols="60" class="form_area"><?=htmlspecialchars($download_row['BriefDescription'])?></textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php }?>
                    
                    <?php if(get_cfg('download.description')){?>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.description');?>:</div>
                            <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Contents"><?=htmlspecialchars($db->get_value('download_description', "DId='$DId'", 'Description'));?></textarea></div>
                            <div class="clear"></div>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="DId" value="<?=$DId;?>">
            </div>
            <div class="clear"></div>
            
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>