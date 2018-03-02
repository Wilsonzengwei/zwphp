<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_category';
check_permit('product_category', 'product.category.mod');

if($_GET['action']=='delimg'){
	$CateId=(int)$_POST['CateId'];
	$PicPath=$_GET['PicPath'];
	
	del_file($PicPath);
	del_file(str_replace('s_', '', $PicPath));
	
	$db->update('product_category', "CateId='$CateId'", array(
			'PicPath'	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('img_list').innerHTML='$str'; parent.document.getElementById('img_list_a').innerHTML='';</script>";
	exit;
}
if($_GET['action']=='delimg_1'){
	$CateId=(int)$_POST['CateId'];
	$PicPath_1=$_GET['PicPath_1'];
	
	del_file($PicPath_1);
	del_file(str_replace('s_', '', $PicPath_1));
	
	$db->update('product_category', "CateId='$CateId'", array(
			'PicPath_1'	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('img_list_1').innerHTML='$str'; parent.document.getElementById('img_list_a_1').innerHTML='';</script>";
	exit;
}

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
	$CateId=(int)$_POST['CateId'];	
	$IsInIndex=(int)$_POST['IsInIndex'];	
	$UnderTheCateId=(int)$_POST['UnderTheCateId'];
	$Category=$_POST['Category_lang_1'];
	!$Category && $Category=$_POST['S_Category'];
	$SeoTitle=$_POST['SeoTitle_lang_1'];
	$SeoKeywords=$_POST['SeoKeywords_lang_1'];
	$SeoDescription=$_POST['SeoDescription_lang_1'];
	$PIdCateId=(int)$_POST['PIdCateId'];
	
	
	if(get_cfg('product.category.upload_pic')){
		$S_PicPath=$_POST['S_PicPath'];
		if($BigPicPath=up_file($_FILES['PicPath'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath=img_resize($BigPicPath, '', get_cfg('product.category.pic_width'), get_cfg('product.category.pic_height'));
			del_file($S_PicPath);
			del_file(str_replace('s_', '', $S_PicPath));
		}else{
			$SmallPicPath=$S_PicPath;
		}
		$S_PicPath_1=$_POST['S_PicPath_1'];
		if($BigPicPath_1=up_file($_FILES['PicPath_1'], $save_dir)){
			include('../../inc/fun/img_resize.php');
			$SmallPicPath_1=img_resize($BigPicPath_1, '', get_cfg('product.category.pic_width'), get_cfg('product.category.pic_height'));
			del_file($S_PicPath_1);
			del_file(str_replace('s_', '', $S_PicPath_1));
		}else{
			$SmallPicPath_1=$S_PicPath_1;
		}
	}
	
	if($UnderTheCateId==0){
		$UId='0,';
		$Dept=1;
	}else{
		$UId=get_UId_by_CateId($UnderTheCateId, 'product_category');
		$Dept=substr_count($UId, ',');
	}
	
	$SubUId=get_UId_by_CateId($CateId, 'product_category');	//下级类别的UId
	$CurUId=$db->get_value('product_category', "CateId='$CateId'", 'UId');
	$db->query("update product_category set UId=replace(UId, '$CurUId', '$UId') where UId like '{$SubUId}%'");
	
	$db->update('product_category', "CateId='$CateId'", array(
			'UId'			=>	$UId,
			'Category_lang_1'		=>	$Category,
			'IsInIndex'		=>	$IsInIndex,
			'PicPath'		=>	$SmallPicPath,
			'PicPath_1'		=>	$SmallPicPath_1,
			'SeoTitle_lang_1'		=>	$SeoTitle,
			'SeoKeywords_lang_1'	=>	$SeoKeywords,
			'SeoDescription_lang_1'=>	$SeoDescription,
			'Dept'			=>	$Dept,
			'PIdCateId'		=>	$PIdCateId
		)
	);
	
	if(get_cfg('product.category.description')){
		$Description=save_remote_img($_POST['Description'], $save_dir);
		
		$db->update('product_category_description', "CateId='$CateId'", array(
				'Description'	=>	$Description
			)
		);
	}

	//保存另外的语言版本的数据
	$Category=$_POST['Category'];
	$Category_lang_1=$_POST['Category_lang_1'];
	$Category_lang_2=$_POST['Category_lang_2'];
	!$Category && $Category=$_POST['S_Category'];
	!$Category_lang_1 && $Category_lang_1=$_POST['S_Category_lang_1'];
	!$Category_lang_2 && $Category_lang_2=$_POST['S_Category_lang_2'];
	$db->update('product_category', "CateId='$CateId'", array(
					'Category'			=>	$Category,
					'Category_lang_1'	=>	$Category_lang_1,
					'Category_lang_2'	=>	$Category_lang_2,
					
				)
			);
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('product_category', array('Category', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('product_category_description', 'Description');
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);

			$CategoryExt=$_POST['Category'.$field_ext];
			!$CategoryExt && $CategoryExt=$_POST['S_Category'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('product_category', "CateId='$CateId'", array(
					
					'SeoTitle'.$field_ext		=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext	=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext	=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('product.category.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('product_category_description', "CateId='$CateId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}

	}
	
	category_subcate_statistic('product_category');
	set_page_url('product_category', "CateId='$CateId'", get_cfg('product.category.page_url'), 0);
	
	save_manage_log('更新产品类别:'.$Category);
	
	header('Location: category.php');
	exit;
}

$CateId=(int)$_GET['CateId'];
$category_row=$db->get_one('product_category', "CateId='$CateId'");
$category_description_row=$db->get_one('product_category_description', "CateId='$CateId'");

include('../../inc/manage/header.php');
?>

<div class="div_con">
    <form method="post" name="act_form" id="act_form" class="act_form" action="category_mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
        <div class="table">
            <div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('ly200.category');?></div>
                 <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category_name').lang_name($i, 0);?>:</font>
                        <span class="fl">
                            <input name="Category<?=lang_name($i, 1);?>" value="<?=htmlspecialchars($category_row['Category'.lang_name($i, 1)]);?>" class="form_input" type="text" size="98" maxlength="40" check="<?=get_lang('ly200.filled_out').get_lang('ly200.category_name');?>!~*" <?=get_cfg('product.category.mod_name')?'':'disabled';?>><input type="hidden" name="S_Category<?=lang_name($i, 1);?>" value="<?=htmlspecialchars($category_row['Category'.lang_name($i, 1)]);?>" />
                        </span>
                        <div class="clear"></div>
                    </div>
                 <?php } ?> 
            </div>
            
			<?php
            if(get_cfg('product.category.dept')>1){
                $o_dept=$category_row['Dept']-($db->get_max('product_category', "UId like '{$category_row['UId']}{$category_row['CateId']},%'", 'Dept')-get_cfg('product.category.dept'));	//剩余可用的级数
                $e_where="CateId!='{$category_row['CateId']}' and Dept<".($category_row['SubCate']?$o_dept:get_cfg('product.category.dept'));
            ?>
                <div class="tr">
                	<div class="form_row">
                        <font class="fl"><?=get_lang('ly200.under_the');?>:</font>
                        <span class="fl">
							<?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('UnderTheCateId', get_CateId_by_UId($category_row['UId']), 'product_category', "UId='0,' and $e_where", $e_where, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            <?php if(get_cfg('product.category.upload_pic')){?>
                <div class="tr">
                    <div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
                        <span class="fl">
                            <input name="PicPath" type="file" size="50" class="form_input" contenteditable="false">
							<b>图片尺寸  <?=$category_row['Dept']==1 ? '290*520' : '420*240' ?> 像素</b>
                            <br />
                        </span>
                        <div class="clear"></div>
                        
                    </div>
                    <?php if(is_file($site_root_path.$category_row['PicPath'])){?>
                    <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                    <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
                        <tr>
                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list"><a href="<?=str_replace('s_', '', $category_row['PicPath']);?>" target="_blank"><img src="<?=$category_row['PicPath'];?>" <?=img_width_height(70, 70, $category_row['PicPath']);?> /></a><input type='hidden' name='S_PicPath' value='<?=$category_row['PicPath'];?>'></td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a">&nbsp;<a href="category_mod.php?action=delimg&CateId=<?=$CateId;?>&PicPath=<?=$category_row['PicPath'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
                        </tr>
                    </table>
                    <?php }?>
                </div>
                <?php if($category_row['Dept']==1){ ?>
	                <div class="tr">
	                    <div class="tr_title">手机版<?=get_lang('ly200.upload_pic');?>:</div>
	                    <div class="form_row">
	                        <font class="fl"><?=get_lang('ly200.photo');?>:</font>
	                        <span class="fl">
	                            <input name="PicPath_1" type="file" size="50" class="form_input" contenteditable="false">
								<b>图片尺寸  60*60 像素</b>
	                            <br />
	                        </span>
	                        <div class="clear"></div>
	                        
	                    </div>
	                    <?php if(is_file($site_root_path.$category_row['PicPath_1'])){?>
	                    <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
	                    <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px;">
	                        <tr>
	                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list_1"><a href="<?=str_replace('s_', '', $category_row['PicPath_1']);?>" target="_blank"><img src="<?=$category_row['PicPath_1'];?>" <?=img_width_height(70, 70, $category_row['PicPath_1']);?> /></a><input type='hidden' name='S_PicPath_1' value='<?=$category_row['PicPath_1'];?>'></td>
	                        </tr>
	                        <tr>
	                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_a_1">&nbsp;<a href="category_mod.php?action=delimg_1&CateId=<?=$CateId;?>&PicPath_1=<?=$category_row['PicPath_1'];?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
	                        </tr>
	                    </table>
	                    <?php }?>
	                </div>
                <?php } ?>
            <?php }?>
            <?php if(get_cfg('product.category.is_in_index') && $category_row['Dept']==1){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                        <span class="fl">
							<?php if(get_cfg('product.is_in_index')){?>
                            	<div class="items<?=$category_row['IsInIndex']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                            	<input name="IsInIndex" type="hidden" value="<?=$category_row['IsInIndex']==1?'1':'0';?>">
							<?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            <?php if(get_cfg('product.category.seo_tkd')){?>
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo');?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle_lang_1" type="text" value="<?=htmlspecialchars($category_row['SeoTitle_lang_1'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords_lang_1" type="text" value="<?=htmlspecialchars($category_row['SeoKeywords_lang_1'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription_lang_1" type="text" value="<?=htmlspecialchars($category_row['SeoDescription_lang_1'])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
            <?php } ?>

			<?php if(get_cfg('product.category.description')){?>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr<?=$i==count(get_cfg('ly200.lang_array'))-1?' last':'';?>">
                    	<div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
                        <div class="editor_row">
                            <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                            <div class="editor_con ck_editor fl">
                                <textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"><?=htmlspecialchars($category_description_row['Description'.lang_name($i, 1)]);?></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
            
            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="CateId" value="<?=$CateId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>