<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur = 'instance';
check_permit('instance', 'instance.mod');

if($_GET['action']=='delimg'){
	$CaseId=(int)$_POST['CaseId'];
	$Field=$_GET['Field'];
	$PicPath=$_GET['PicPath'];
	$ImgId=$_GET['ImgId'];
	
	foreach(get_cfg('instance.pic_size') as $key=>$value){
		if("$key"=='default'){
			del_file($PicPath);
			del_file(str_replace('s_', '', $PicPath));
		}else{
			del_file(str_replace('s_', $value.'_', $PicPath));
		}
	}
	
	$db->update('instance', "CaseId='$CaseId'", array(
			$Field	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('$ImgId').innerHTML='$str'; parent.document.getElementById('{$ImgId}_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'instance/'.date('y_m_d/', $service_time);
	$CaseId=(int)$_POST['CaseId'];
	$query_string=$_POST['query_string'];
	$Name=$_POST['Name'];
	$CateId=$db->get_row_count('instance_category')>1?(int)$_POST['CateId']:$db->get_value('instance_category', 1, 'CateId');
	$Language=(int)$_POST['Language'];
	$BriefDescription=$_POST['BriefDescription'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	$IsInIndex=(int)$_POST['IsInIndex'];
	$IsClassic=(int)$_POST['IsClassic'];
	
	$BigPicPath=$SmallPicPath=$PicAlt=array();	//$SmallPicPath存入数据库的
	if(get_cfg('instance.pic_count')){
		include('../../inc/fun/img_resize.php');
		for($i=0; $i<get_cfg('instance.pic_count'); $i++){
			$PicAlt[]=$_POST['Alt_'.$i];
			$S_PicPath=$_POST['S_PicPath_'.$i];
			if($tmp_path=up_file($_FILES['PicPath_'.$i], $save_dir)){
				$BigPicPath[$i]=$SmallPicPath[$i]=$tmp_path;
				del_file($S_PicPath);
				del_file(str_replace('s_', '', $S_PicPath));
				foreach(get_cfg('instance.pic_size') as $key=>$value){
					$w_h=@explode('X', $value);
					$filename="$key"=='default'?'':dirname($tmp_path).'/'.$value.'_'.basename($tmp_path);
					$path=img_resize($SmallPicPath[$i], $filename, (int)$w_h[0], (int)$w_h[1]);
					"$key"=='default' && $SmallPicPath[$i]=$path;
					del_file(str_replace('s_', $value.'_', $S_PicPath));
				}
			}else{
				$SmallPicPath[$i]=$S_PicPath;
			}
		}
		if(get_cfg('ly200.img_add_watermark')){
			include('../../inc/fun/img_add_watermark.php');
			foreach($BigPicPath as $value){
				img_add_watermark($value);
			}
		}
	}
	
	$db->update('instance', "CaseId='$CaseId'", array(
			'CateId'			=>	$CateId,
			'Name'				=>	$Name,
			'PicPath_0'			=>	$SmallPicPath[0],
			'PicPath_1'			=>	$SmallPicPath[1],
			'PicPath_2'			=>	$SmallPicPath[2],
			'PicPath_3'			=>	$SmallPicPath[3],
			'PicPath_4'			=>	$SmallPicPath[4],
			'Alt_0'				=>	$PicAlt[0],
			'Alt_1'				=>	$PicAlt[1],
			'Alt_2'				=>	$PicAlt[2],
			'Alt_3'				=>	$PicAlt[3],
			'Alt_4'				=>	$PicAlt[4],
			'BriefDescription'	=>	$BriefDescription,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeywords'		=>	$SeoKeywords,
			'SeoDescription'	=>	$SeoDescription,
			'IsInIndex'			=>	$IsInIndex,
			'IsClassic'			=>	$IsClassic,
			'UpdateTime'		=>	$service_time,
			'Language'			=>	$Language
		)
	);
	
	if(get_cfg('instance.description')){
		$Description=save_remote_img($_POST['Description'], $save_dir);
		$db->update('instance_description', "CaseId='$CaseId'", array(
				'Description'	=>	$Description
			)
		);
	}
	
	//保存另外的语言版本的数据
	if(get_cfg('instance.add_mode')){
		if(count(get_cfg('ly200.lang_array'))>1){
			add_lang_field('instance', array('Name', 'BriefDescription', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
			add_lang_field('instance_description', 'Description');
			
			for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
				$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
				$NameExt=$_POST['Name'.$field_ext];
				$BriefDescriptionExt=$_POST['BriefDescription'.$field_ext];
				$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
				$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
				$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
				$db->update('instance', "CaseId='$CaseId'", array(
						'Name'.$field_ext				=>	$NameExt,
						'BriefDescription'.$field_ext	=>	$BriefDescriptionExt,
						'SeoTitle'.$field_ext			=>	$SeoTitleExt,
						'SeoKeywords'.$field_ext		=>	$SeoKeywordsExt,
						'SeoDescription'.$field_ext		=>	$SeoDescriptionExt
					)
				);
				
				if(get_cfg('instance.description')){
					$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
					$db->update('instance_description', "CaseId='$CaseId'", array(
							'Description'.$field_ext	=>	$DescriptionExt
						)
					);
				}
			}
		}
	}
	
	set_page_url('instance', "CaseId='$CaseId'", get_cfg('instance.page_url'), 1);
	
	save_manage_log('编辑成功案例:'.$Name);
	
	header("Location: index.php?$query_string");
	exit;
}

$CaseId=(int)$_GET['CaseId'];
$query_string=query_string('CaseId');

$instance_row=$db->get_one('instance', "CaseId='$CaseId'");
$instance_description_row=$db->get_one('instance_description', "CaseId='$CaseId'");

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('ins_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('instance.modelname');?>:</div>
                <?php if(get_cfg('instance.add_mode')){?>
                	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.name').lang_name($i, 0);?>:</font>
                            <span class="fl">
                                <input name="Name<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($instance_row['Name'.lang_name($i, 1)]);?>" class="form_input" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                	<div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.name');?>:</font>
                        <span class="fl">
                        	<input name="Name" type="text" value="<?=htmlspecialchars($instance_row['Name']);?>" class="form_input" size="30" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                
				<?php if($db->get_row_count('instance_category')>1){?>
                    <div class="form_row">
                    	<font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                        	<?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $instance_row['CateId'], 'instance_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                    </div>
                    <br><br>
                <?php } ?>
                <?php if(count(get_cfg('ly200.lang_array'))>1 && !get_cfg('instance.add_mode')){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.language');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',output_language_select($instance_row['Language']));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php }?>
            </div>
            
            <?php if(get_cfg('instance.pic_count')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                    	<?php for($i=0; $i<get_cfg('instance.pic_count'); $i++){ ?>
                            <font class="fl">图片<?=($i+1);?></font>
                            <span class="fl">
                                <input name="PicPath_<?=$i?>" type="file" class="form_largefile" contenteditable="false">
                                <?php if(get_cfg('instance.pic_alt')){?>
                                    &nbsp;&nbsp;<?=get_lang('ly200.alt');?>:<input name="Alt_<?=$i;?>" type="text" value="<?=htmlspecialchars($instance_row['Alt_'.$i]);?>" class="form_input" size="25" maxlength="100">
                                <?php }?>
                                <br /><br />
                            </span>
                            <div class="clear"></div>
                       	<?php } ?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px; margin-left:<?=get_cfg('instance.pic_count')>1?'12':'0';?>px;">
                          <tr>
                            <?php
                            for($i=0; $i<get_cfg('instance.pic_count'); $i++){
                                if(!is_file($site_root_path.$instance_row['PicPath_'.$i])){
                                    continue;
                                }
                            ?>
                                <td>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list_<?=$i;?>"><a href="<?=str_replace('s_', '', $instance_row['PicPath_'.$i]);?>" target="_blank"><img src="<?=$instance_row['PicPath_'.$i];?>" <?=img_width_height(70, 70, $instance_row['PicPath_'.$i]);?> /></a><input type='hidden' name='S_PicPath_<?=$i;?>' value='<?=$instance_row['PicPath_'.$i];?>'></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_<?=$i;?>_a">&nbsp;<a href="mod.php?action=delimg&CaseId=<?=$CaseId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$instance_row['PicPath_'.$i];?>&ImgId=img_list_<?=$i;?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="5">&nbsp;&nbsp;</td>
                            <?php }?>
                          </tr>
                        </table>
                    </div>
                </div>                
            <?php } ?>
            
            <?php if(get_cfg('info.seo_tkd')){ ?>
            	<?php if(get_cfg('instance.add_mode')){?>
                	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                        <div class="tr">
                            <div class="tr_title"><?=get_lang('ly200.seo.seo').lang_name($i, 0);?>:</div>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                                <span class="fl">
                                    <input name="SeoTitle<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($instance_row['SeoTitle'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                                <span class="fl">
                                    <input name="SeoKeywords<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($instance_row['SeoKeywords'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                                </span>
                                <div class="clear"></div>
                            </div>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                                <span class="fl">
                                    <input name="SeoDescription<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($instance_row['SeoDescription'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle" type="text" value="<?=htmlspecialchars($instance_row['SeoTitle'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords" type="text" value="<?=htmlspecialchars($instance_row['SeoKeywords'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription" type="text" value="<?=htmlspecialchars($instance_row['SeoDescription'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            
            <?php if(get_cfg('instance.is_in_index') || get_cfg('instance.is_classic')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                        <span class="fl">
							<?php if(get_cfg('instance.is_in_index')){?>
                                <div class="items<?=$instance_row['IsInIndex']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                                <input name="IsInIndex" type="hidden" value="<?=$instance_row['IsInIndex']?'1':'0';?>">
                            <?php }?>
                            <?php if(get_cfg('instance.is_classic')){?>
                                <div class="items<?=$instance_row['IsClassic']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('instance.is_classic');?></div>
                                <input name="IsClassic" type="hidden" value="<?=$instance_row['IsClassic']?'1':'0';?>">
                            <?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <div class="tr last">
                <div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
                <?php if(get_cfg('instance.brief_description')){?>
                	<?php if(get_cfg('instance.add_mode')){?>
                    	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.brief_description').lang_name($i, 0);?>:</font>
                                <span class="fl">
                                    <textarea name="BriefDescription<?=lang_name($i, 1);?>" rows="8" cols="106" class="form_area" ><?=htmlspecialchars($instance_row['BriefDescription'.lang_name($i, 1)])?></textarea>
                                </span>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.brief_description');?>:</font>
                            <span class="fl">
                                <textarea name="BriefDescription" rows="8" cols="106" class="form_area" ><?=htmlspecialchars($instance_row['BriefDescription'])?></textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                <?php } ?>
                
                <?php if(get_cfg('instance.description')){?>
                	<?php if(get_cfg('instance.add_mode')){?>
                    	<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="editor_row">
                                <div class="editor_title fl"><?=get_lang('ly200.contents').lang_name($i, 0);?>:</div>
                                <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"><?=htmlspecialchars($instance_description_row['Description'.lang_name($i, 1)]);?></textarea></div>
                                <div class="clear"></div>
                            </div>
                    	<?php } ?>
                	<?php }else{ ?>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.contents');?>:</div>
                            <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description"><?=htmlspecialchars($instance_description_row['Description']);?></textarea></div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                <?php } ?>
                
            </div>
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="CaseId" value="<?=$CaseId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>