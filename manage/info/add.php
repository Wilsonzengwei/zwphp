<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'info';
check_permit('info', 'info.add');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'info/'.date('y_m_d/', $service_time);
	$Title=$_POST['Title'];
	$CateId=$db->get_row_count('info_category')>1?(int)$_POST['CateId']:$db->get_value('info_category', 1, 'CateId');
	$Language=(int)$_POST['Language'];
	$ExtUrl=$_POST['ExtUrl'];
	$Author=$_POST['Author'];
	$Provenance=$_POST['Provenance'];
	$Burden=$_POST['Burden'];
	$BriefDescription=$_POST['BriefDescription'];
	$IsInIndex=(int)$_POST['IsInIndex'];
	$IsHot=(int)$_POST['IsHot'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	$AccTime=@strtotime($_POST['AccTime']);
	$Contents=save_remote_img($_POST['Contents'], $save_dir);
	
	if(get_cfg('info.upload_pic')){
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('info.pic_width'), get_cfg('info.pic_height'));
			if(get_cfg('ly200.img_add_watermark')){
				include('../../inc/fun/img_add_watermark.php');
				img_add_watermark($BigPicPath);
			}
		}
	}
	
	$db->insert('info', array(
			'CateId'			=>	$CateId,
			'Title'				=>	$Title,
			'PicPath'			=>	$SmallPicPath,
			'ExtUrl'			=>	$ExtUrl,
			'Author'			=>	$Author,
			'Provenance'		=>	$Provenance,
			'Burden'			=>	$Burden,
			'BriefDescription'	=>	$BriefDescription,
			'IsInIndex'			=>	$IsInIndex,
			'IsHot'				=>	$IsHot,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeywords'		=>	$SeoKeywords,
			'SeoDescription'	=>	$SeoDescription,
			'AccTime'			=>	$AccTime,
			'Language'			=>	$Language
		)
	);
	
	$InfoId=$db->get_insert_id();
	$db->insert('info_contents', array(
			'InfoId'	=>	$InfoId,
			'Contents'	=>	$Contents
		)
	);
	
	set_page_url('info', "InfoId='$InfoId'", get_cfg('info.page_url'), 1);
	
	$db->update('manage_operation_log', 'Operation="info_add"', array(
			'Value'	=>	$CateId
		)
	);
	
	save_manage_log('添加文章:'.$Title);
	
	header('Location: index.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('info_header.php');?>	
    <form method="post" name="act_form" id="act_form" class="act_form" action="add.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    
    	<div class="table" id="mouse_trBgcolor_table">
        	<div class="table_bg"></div>
           	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.add').get_lang('info.modelname');?>:</div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('ly200.title');?>:</font>
                    <span class="fl">
                        <input name="Title" type="text" value="" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.title');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                
                <?php if($db->get_row_count('info_category')>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $db->get_value('manage_operation_log', 'Operation="info_add"', 'Value'), 'info_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
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
                
                <?php if(get_cfg('info.ext_url')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.ext_url');?>:</font>
                        <span class="fl">
                            <input name="ExtUrl" type="text" value="" class="form_input" size='60' maxlength="100">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.author')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.author');?>:</font>
                        <span class="fl">
                            <input name="Author" type="text" value="" class="form_input" size="25" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.provenance')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.provenance');?>:</font>
                        <span class="fl">
                            <input name="Provenance" type="text" value="" class="form_input" size="25" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.burden')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.burden');?>:</font>
                        <span class="fl">
                            <input name="Burden" type="text" value="" class="form_input" size="25" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.acc_time')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.time');?>:</font>
                        <span class="fl">
                            <input name="AccTime" type="text" size="12" contenteditable="false" id="SelectDate" value="<?=date('Y-m-d', $service_time);?>" class="form_input" />
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
            </div>
            
            <?php if(get_cfg('info.upload_pic')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" class="form_largefile" contenteditable="false"> <b>图片大小建议：<?=get_lang('info.picsizetips')?></b>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('info.seo_tkd')){ ?>
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
            
            <?php if(get_cfg('info.is_in_index') || get_cfg('info.is_hot')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.other');?>:</font>
                        <span class="fl">
							<?php if(get_cfg('info.is_in_index')){?>
                                <div class="items" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                                <input name="IsInIndex" type="hidden" value="0">
                            <?php }?>
                            <?php if(get_cfg('info.is_hot')){?>
                                <div class="items" onClick="checkproperty(this)"><?=get_lang('info.is_hot');?></div>
                                <input name="IsHot" type="hidden" value="0">
                            <?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <div class="tr last">
                <div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
                <?php if(get_cfg('info.brief_description')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.brief_description');?>:</font>
                        <span class="fl">
                            <textarea name="BriefDescription" rows="8" cols="106" class="form_area" ></textarea>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
				<div class="editor_row">
                	<div class="editor_title fl"><?=get_lang('ly200.contents');?>:</div>
                    <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Contents"></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="button fr"><input type="submit" value="<?=get_lang('ly200.add');?>" name="submit" class="form_button"></div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>