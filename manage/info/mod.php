<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'info';
check_permit('info', 'info.mod');

if($_GET['action']=='delimg'){
	$InfoId=(int)$_POST['InfoId'];
	$PicPath=$_GET['PicPath'];
	
	del_file($PicPath);
	del_file(str_replace('s_', '', $PicPath));
	
	$db->update('info', "InfoId='$InfoId'", array(
			'PicPath'	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str'; parent.document.getElementById('img_list_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'info/'.date('y_m_d/', $service_time);
	$InfoId=(int)$_POST['InfoId'];
	$query_string=$_POST['query_string'];
	
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
		$S_PicPath=$_POST['S_PicPath'];
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('info.pic_width'), get_cfg('info.pic_height'));
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
	
	$db->update('info', "InfoId='$InfoId'", array(
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
	$db->update('info_contents', "InfoId='$InfoId'", array(
			'Contents'	=>	$Contents
		)
	);
	
	set_page_url('info', "InfoId='$InfoId'", get_cfg('info.page_url'), 1);
	
	save_manage_log('编辑文章:'.$Title);
	
	header("Location: index.php?$query_string");
	exit;
}

$InfoId=(int)$_GET['InfoId'];
$query_string=query_string('InfoId');

$info_row=$db->get_one('info', "InfoId='$InfoId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('info_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table" id="mouse_trBgcolor_table">
        	<div class="table_bg"></div>
           	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('info.modelname');?>:</div>
                <div class="form_row">
                    <font class="fl"><?=get_lang('ly200.title');?>:</font>
                    <span class="fl">
                        <input name="Title" type="text" value="<?=htmlspecialchars($info_row['Title'])?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.title');?>!~*">
                    </span>
                    <div class="clear"></div>
                </div>
                
                <?php if($db->get_row_count('info_category')>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $info_row['CateId'], 'info_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <?php if(count(get_cfg('ly200.lang_array'))>1){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select($info_row['Language']));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
                
                <?php if(get_cfg('info.ext_url')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.ext_url');?>:</font>
                        <span class="fl">
                            <input name="ExtUrl" type="text" value="<?=htmlspecialchars($info_row['ExtUrl'])?>" class="form_input" size='60' maxlength="100">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.author')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('info.author');?>:</font>
                        <span class="fl">
                            <input name="Author" type="text" value="<?=htmlspecialchars($info_row['Author'])?>" class="form_input" size="25" maxlength="50">
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
                            <input name="Burden" type="text" value="<?=htmlspecialchars($info_row['Burden'])?>" class="form_input" size="25" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
                <?php if(get_cfg('info.acc_time')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.time');?>:</font>
                        <span class="fl">
                            <input name="AccTime" type="text" size="12" contenteditable="false" id="SelectDate" value="<?=date('Y-m-d', $info_row['AccTime']);?>" class="form_input" />
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
                        <?php if(is_file($site_root_path.$info_row['PicPath'])){?>
                            <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                            <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
                                <tr>
                                    <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list"><a href="<?=str_replace('s_', '', $info_row['PicPath']);?>" target="_blank"><img src="<?=$info_row['PicPath'];?>" <?=img_width_height(70, 70, $info_row['PicPath']);?> /></a><input type='hidden' name='S_PicPath' value='<?=$info_row['PicPath'];?>'></td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a">&nbsp;<a href="mod.php?action=delimg&InfoId=<?=$InfoId;?>&PicPath=<?=$info_row['PicPath'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                                </tr>
                            </table>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('info.seo_tkd')){ ?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                        <span class="fl">
                            <input name="SeoTitle" type="text" value="<?=htmlspecialchars($info_row['SeoTitle'])?>" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                        <span class="fl">
                            <input name="SeoKeywords" type="text" value="<?=htmlspecialchars($info_row['SeoKeywords'])?>" class="form_input" size="98" maxlength="200">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                        <span class="fl">
                            <input name="SeoDescription" type="text" value="<?=htmlspecialchars($info_row['SeoDescription'])?>" class="form_input" size="98" maxlength="200">
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
                                <div class="items<?=$info_row['IsInIndex']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                                <input name="IsInIndex" type="hidden" value="<?=$info_row['IsInIndex']?'1':'0';?>">
                            <?php }?>
                            <?php if(get_cfg('info.is_hot')){?>
                                <div class="items<?=$info_row['IsHot']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('info.is_hot');?></div>
                                <input name="IsHot" type="hidden" value="<?=$info_row['IsHot']?'1':'0';?>">
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
                            <textarea name="BriefDescription" rows="8" cols="106" class="form_area" ><?=htmlspecialchars($info_row['BriefDescription'])?></textarea>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
				<div class="editor_row">
                	<div class="editor_title fl"><?=get_lang('ly200.contents');?>:</div>
                    <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Contents"><?=htmlspecialchars($db->get_value('info_contents', "InfoId='$InfoId'", 'Contents'));?></textarea></div>
                    <div class="clear"></div>
                </div>
            </div>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
                <input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="InfoId" value="<?=$InfoId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>