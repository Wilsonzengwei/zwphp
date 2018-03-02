<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='gift';
check_permit('gift', 'gift.mod');

if($_GET['action']=='delimg'){
	$ProId=(int)$_POST['ProId'];
	$Field=$_GET['Field'];
	$PicPath=$_GET['PicPath'];
	$ImgId=$_GET['ImgId'];
	
	foreach(get_cfg('gift.pic_size') as $key=>$value){
		if("$key"=='default'){
			del_file($PicPath);
			del_file(str_replace('s_', '', $PicPath));
		}else{
			del_file(str_replace('s_', $value.'_', $PicPath));
		}
	}
	
	$db->update('gift', "ProId='$ProId'", array(
			$Field	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('$ImgId').innerHTML='$str'; parent.document.getElementById('{$ImgId}_a').innerHTML='';</script>";
	exit;
}

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'gift/'.date('y_m_d/', $service_time);
	$ProId=(int)$_POST['ProId'];
	$query_string=$_POST['query_string'];
	
	$Name=$_POST['Name'];
	$CateId=$db->get_row_count('gift_category')>1?(int)$_POST['CateId']:$db->get_value('gift_category', 1, 'CateId');
	$ItemNumber=$_POST['ItemNumber'];
	$Model=$_POST['Model'];
	$IsInIndex=(int)$_POST['IsInIndex'];
	$IsHot=(int)$_POST['IsHot'];
	$IsRecommend=(int)$_POST['IsRecommend'];
	$IsNew=(int)$_POST['IsNew'];
	$SoldOut=(int)$_POST['SoldOut'];
	$ColorId=get_cfg('gift.color_ele_mode')?('|'.@implode('|', $_POST['ColorId']).'|'):(int)$_POST['ColorId'];
	$SizeId=get_cfg('gift.size_ele_mode')?('|'.@implode('|', $_POST['SizeId']).'|'):(int)$_POST['SizeId'];
	$BrandId=(int)$_POST['BrandId'];
	$Stock=(int)$_POST['Stock'];
	$StartFrom=(int)$_POST['StartFrom']?(int)$_POST['StartFrom']:1;
	$Weight=(float)$_POST['Weight'];
	$Price_0=(float)$_POST['Price_0'];
	$Price_1=(float)$_POST['Price_1'];
	$Price_2=(float)$_POST['Price_2'];
	$Price_3=(float)$_POST['Price_3'];
	$Integral=(int)$_POST['Integral'];
	$IsSpecialOffer=(int)$_POST['IsSpecialOffer'];
	$SpecialOfferPrice=(float)$_POST['SpecialOfferPrice'];
	$BriefDescription=$_POST['BriefDescription'];
	$SeoTitle=$_POST['SeoTitle'];
	$SeoKeywords=$_POST['SeoKeywords'];
	$SeoDescription=$_POST['SeoDescription'];
	
	$BigPicPath=$SmallPicPath=$PicAlt=array();	//$SmallPicPath存入数据库的
	if(get_cfg('gift.pic_count')){
		include('../../inc/fun/img_resize.php');
		for($i=0; $i<get_cfg('gift.pic_count'); $i++){
			$PicAlt[]=$_POST['Alt_'.$i];
			$S_PicPath=$_POST['S_PicPath_'.$i];
			if($tmp_path=up_file($_FILES['PicPath_'.$i], $save_dir)){
				$BigPicPath[$i]=$SmallPicPath[$i]=$tmp_path;
				del_file($S_PicPath);
				del_file(str_replace('s_', '', $S_PicPath));
				foreach(get_cfg('gift.pic_size') as $key=>$value){
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
	
	$db->update('gift', "ProId='$ProId'", array(
			'CateId'			=>	$CateId,
			'Name'				=>	$Name,
			'ItemNumber'		=>	$ItemNumber,
			'Model'				=>	$Model,
			'IsInIndex'			=>	$IsInIndex,
			'IsHot'				=>	$IsHot,
			'IsRecommend'		=>	$IsRecommend,
			'IsNew'				=>	$IsNew,
			'SoldOut'			=>	$SoldOut,
			'ColorId'			=>	$ColorId,
			'SizeId'			=>	$SizeId,
			'BrandId'			=>	$BrandId,
			'Stock'				=>	$Stock,
			'StartFrom'			=>	$StartFrom,
			'Weight'			=>	$Weight,
			'PicPath_0'			=>	$SmallPicPath[0],
			'PicPath_1'			=>	$SmallPicPath[1],
			'PicPath_2'			=>	$SmallPicPath[2],
			'PicPath_3'			=>	$SmallPicPath[3],
			'PicPath_4'			=>	$SmallPicPath[4],
			'PicPath_5'			=>	$SmallPicPath[5],
			'PicPath_6'			=>	$SmallPicPath[6],
			'PicPath_7'			=>	$SmallPicPath[7],
			'Alt_0'				=>	$PicAlt[0],
			'Alt_1'				=>	$PicAlt[1],
			'Alt_2'				=>	$PicAlt[2],
			'Alt_3'				=>	$PicAlt[3],
			'Alt_4'				=>	$PicAlt[4],
			'Alt_5'				=>	$PicAlt[5],
			'Alt_6'				=>	$PicAlt[6],
			'Alt_7'				=>	$PicAlt[7],
			'Price_0'			=>	$Price_0,
			'Price_1'			=>	$Price_1,
			'Price_2'			=>	$Price_2,
			'Price_3'			=>	$Price_3,
			'Integral'	        =>	$Integral,
			'IsSpecialOffer'	=>	$IsSpecialOffer,
			'SpecialOfferPrice'	=>	$SpecialOfferPrice,
			'BriefDescription'	=>	$BriefDescription,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeywords'		=>	$SeoKeywords,
			'SeoDescription'	=>	$SeoDescription,
			'AccTime'			=>	$service_time
		)
	);
	
	if(get_cfg('gift.description')){
		$Description=save_remote_img($_POST['Description'], $save_dir);
		$db->update('gift_description', "ProId='$ProId'", array(
				'Description'	=>	$Description
			)
		);
	}
	
	//保存批发价
	if(get_cfg('gift.price') && get_cfg('gift.wholesale_price')){
		$db->delete('gift_wholesale_price', "ProId='$ProId'");
		for($i=0; $i<count($_POST['Qty']); $i++){
			$qty=(int)$_POST['Qty'][$i];
			$price=(float)$_POST['WholesalePrice'][$i];
			if($qty && $price){
				$db->insert('gift_wholesale_price', array(
						'ProId'	=>	$ProId,
						'Qty'	=>	$qty,
						'Price'	=>	$price
					)
				);
			}
		}
	}
	
	//保存另外的语言版本的数据
	if(count(get_cfg('ly200.lang_array'))>1){
		add_lang_field('gift', array('Name', 'BriefDescription', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('gift_description', 'Description');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$NameExt=$_POST['Name'.$field_ext];
			$BriefDescriptionExt=$_POST['BriefDescription'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('gift', "ProId='$ProId'", array(
					'Name'.$field_ext				=>	$NameExt,
					'BriefDescription'.$field_ext	=>	$BriefDescriptionExt,
					'SeoTitle'.$field_ext			=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext		=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext		=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('gift.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('gift_description', "ProId='$ProId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}
	}
	
	//保存扩展数据
	$field=$field_type=array();
	$data['ProId']=$ProId;
	$columns=$db->show_columns('gift_ext', 1);	//获取数据表的所有字段名称
	foreach(get_cfg('gift.ext') as $form_type=>$field_list){	//扩展参数，form_type=>表单类型，field_list=>表单各项配置值
		foreach($field_list as $field_name=>$field_cfg){	//field_name=>表单名称，field_cfg=>表单配置
			if(in_array($form_type, array('input_text', 'textarea', 'ckeditor'))){
				if($field_cfg[0]){	//多语言输入
					for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){
						$data[$field_name.lang_name($i, 1)]=$form_type=='ckeditor'?save_remote_img($_POST[$field_name.lang_name($i, 1)], $save_dir):$_POST[$field_name.lang_name($i, 1)];
						$field[]=$field_name.lang_name($i, 1);
						$field_type[]=$form_type;
					}
				}else{	//不区分语言输入
					$data[$field_name]=$form_type=='ckeditor'?save_remote_img($_POST[$field_name], $save_dir):$_POST[$field_name];
					$field[]=$field_name;
					$field_type[]=$form_type;
				}
			}elseif(in_array($form_type, array('input_radio', 'input_checkbox', 'select'))){
				$data[$field_name]=$form_type=='input_checkbox'?('|'.@implode('|', $_POST[$field_name]).'|'):$_POST[$field_name];
				$field[]=$field_name;
				$field_type[]=$form_type;
			}elseif($form_type=='input_file'){
				if($temp_path=up_file($_FILES[$field_cfg], $save_dir)){
					$data[$field_cfg]=$temp_path;
					del_file($_POST['S_'.$field_cfg]);
				}else{
					$data[$field_cfg]=$_POST['S_'.$field_cfg];
				}
				$field[]=$field_cfg;
				$field_type[]=$form_type;
			}
		}
	}
	for($i=0; $i<count($field); $i++){	//添加字段
		if(!in_array($field[$i], $columns)){
			if($field_type[$i]=='textarea'){
				$f='varchar(255)';
			}elseif($field_type[$i]=='ckeditor'){
				$f='text';
			}else{
				$f='varchar(100)';
			}
			$db->query("alter table gift_ext add $field[$i] $f");
		}
	}
	$db->update('gift_ext', "ProId='$ProId'", $data);
	
	set_page_url('gift', "ProId='$ProId'", get_cfg('gift.page_url'), 1);
	
	save_manage_log('编辑礼品:'.$Name);
	
	header("Location: index.php?$query_string");
	exit;
}

$ProId=(int)$_GET['ProId'];
$query_string=query_string('ProId');

$gift_row=$db->get_one('gift', "ProId='$ProId'");
$gift_ext_row=$db->get_one('gift_ext', "ProId='$ProId'");
$gift_description_row=$db->get_one('gift_description', "ProId='$ProId'");
$gift_wholesale_price_row=$db->get_all('gift_wholesale_price', "ProId='$ProId'", '*', 'Price desc, PId desc');

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <?php include('../product/product_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('gift.modelname');?></div>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.name').lang_name($i, 0);?>:</font>
                        <span class="fl">
                        	<input name="Name<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($gift_row['Name'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
            </div>
            
            <?php if($db->get_row_count('gift_category')>1){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_Category_to_Select('CateId', $gift_row['CateId'], 'gift_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('gift.item_number')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.item_number');?>:</font>
                        <span class="fl">
                            <input name="ItemNumber" type="text" value="<?=htmlspecialchars($gift_row['ItemNumber']);?>" class="form_input" size="98" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('gift.model')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.model');?>:</font>
                        <span class="fl">
                            <input name="Model" type="text" value="<?=htmlspecialchars($gift_row['Model']);?>" class="form_input" size="98" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('gift.color_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.color');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',get_cfg('gift.color_ele_mode')?ouput_table_to_input('gift_color', 'CId', 'Color', 'ColorId[]', 'MyOrder desc, CId asc', 1, 1, 'checkbox', $gift_row['ColorId']):ouput_table_to_select('gift_color', 'CId', 'Color', 'ColorId', 'MyOrder desc, CId asc', 1, 1, $gift_row['ColorId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('gift.size_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.size');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',get_cfg('gift.size_ele_mode')?ouput_table_to_input('gift_size', 'SId', 'Size', 'SizeId[]', 'MyOrder desc, SId asc', 1, 1, 'checkbox', $gift_row['SizeId']):ouput_table_to_select('gift_size', 'SId', 'Size', 'SizeId', 'MyOrder desc, SId asc', 1, 1, $gift_row['SizeId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('gift.brand_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.brand');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_table_to_select('gift_brand', 'BId', 'Brand', 'BrandId', 'MyOrder desc, BId asc', 1, 1, $gift_row['BrandId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
			
            <?php if(get_cfg('gift.stock')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.stock');?>:</font>
                        <span class="fl">
                            <input name="Stock" type="text" value="<?=$gift_row['Stock'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>

			<?php if(get_cfg('gift.start_from')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.start_from');?>:</font>
                        <span class="fl">
                            <input name="StartFrom" type="text" value="<?=$gift_row['StartFrom'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('gift.weight')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.weight');?>:</font>
                        <span class="fl">
							<input name="Weight" type="text" value="<?=$gift_row['Weight'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);"><?=get_lang('gift.weight_unit');?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('gift.price')){?>
                <div class="tr">
                    <div class="form_row">
						<font class="fl"><?=get_lang('gift.price');?>:</font>
                        <span class="fl">
							<?php
                            $p_ary=get_cfg('gift.price_list');
                            for($i=0; $i<count($p_ary); $i++){
                            ?>
                                <?=get_lang('gift.price_list.'.$p_ary[$i]);?>:<?=get_lang('ly200.price_symbols');?><input name="Price_<?=$i;?>" type="text" value="<?=$gift_row['Price_'.$i];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);" check="<?=get_lang('ly200.filled_out').get_lang('gift.price_list.'.$p_ary[$i]);?>!~*">
                            <?php
                            }
                            if(get_cfg('gift.special_offer')){
                            ?>
                                <?=get_lang('gift.special_offer');?>:<input name="IsSpecialOffer" type="checkbox" <?=$gift_row['IsSpecialOffer']==1?'checked':'';?> value="1" onclick="if(this.checked){$_('SpecialOfferPriceInput').style.display='';}else{$_('SpecialOfferPriceInput').style.display='none';};"><span id="SpecialOfferPriceInput" style="display:<?=$gift_row['IsSpecialOffer']==1?'':'none';?>;"><?=get_lang('ly200.price_symbols');?><input name="SpecialOfferPrice" value="<?=$gift_row['SpecialOfferPrice'];?>" class="form_input" type="text" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);"></span>
                            <?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <?php if(get_cfg('gift.wholesale_price')){?>
                    	<div class="form_row">
                        	<font class="fl"><?=get_lang('gift.wholesale_price');?>:</font>
                            <span class="fl">
                                <table border="0" cellspacing="0" cellpadding="0" id="wholesale_price_list" class="item_data_table">
                                    <tr>
                                        <td><a href="javascript:void(0);" onClick="this.blur(); add_wholesale_price_item('wholesale_price_list');" class="red"><?=get_lang('ly200.add_item');?></a></td>
                                    </tr>
                                    <?php for($i=0; $i<count($gift_wholesale_price_row); $i++){?>
                                        <tr>
                                            <td><?=get_lang('ly200.qty');?>:<input name="Qty[]" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=$gift_wholesale_price_row[$i]['Qty'];?>" class="form_input" type="text" size="8" maxlength="10"><?=get_lang('ly200.price_symbols');?><input name="WholesalePrice[]" value="<?=$gift_wholesale_price_row[$i]['Price'];?>" class="form_input" type="text" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);"><a href="javascript:void(0)" onClick="$_('wholesale_price_list').deleteRow(this.parentNode.parentNode.rowIndex);"><img src="../images/del.gif" hspace="5" /></a></td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                    
                    
                </div>
            <?php } ?>

            <?php if(get_cfg('gift.integral')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('gift.integral');?>:</font>
                        <span class="fl">
							<input name="Integral" type="text" value="<?=htmlspecialchars($gift_row['Integral']);?>" class="form_input" size="10" maxlength="10" >
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>

			<?php
            foreach(get_cfg('gift.ext') as $form_type=>$field_list){	//扩展参数，form_type=>表单类型，field_list=>表单各项配置值
                foreach($field_list as $field_name=>$field_cfg){	//field_name=>表单名称，field_cfg=>表单配置
                    if($form_type=='input_text'){
                    ?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            	<div class="tr">
                                	<div class="form_row">
                                        <font class="fl"><?=get_lang('gift.ext.'.$field_name).lang_name($i, 0);?>:</font>
                                        <span class="fl">
                                            <input name="<?=$field_name.lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($gift_ext_row[$field_name.lang_name($i, 1)]);?>" class="form_input" size="<?=$field_cfg[1];?>" maxlength="<?=$field_cfg[2];?>">
                                        </span>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }else{?>
                            <div class="tr">
                                <div class="form_row">
                                    <font class="fl"><?=get_lang('gift.ext.'.$field_name);?>:</font>
                                    <span class="fl">
                                        <input name="<?=$field_name;?>" type="text" value="<?=htmlspecialchars($gift_ext_row[$field_name]);?>" class="form_input" size="<?=$field_cfg[1];?>" maxlength="<?=$field_cfg[2];?>">
                                    </span>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }elseif($form_type=='input_radio'){?>
                        <tr>
                            <td nowrap><?=get_lang('gift.ext.'.$field_name);?>:</td>
                            <td class="list_data"><?php
                            $value_list=@explode('|', $field_cfg[0]);
                            for($i=0; $i<count($value_list); $i++){
                                $check=$value_list[$i]==$gift_ext_row[$field_name]?'checked':'';
                                $value=htmlspecialchars($value_list[$i]);
                                echo "<div><input type='radio' name='$field_name' value=\"$value\" $check>{$value_list[$i]}</div>";
                            }?></td>
                        </tr>
                    <?php }elseif($form_type=='input_checkbox'){?>
                        <tr>
                            <td nowrap><?=get_lang('gift.ext.'.$field_name);?>:</td>
                            <td class="list_data"><?php
                            $value_list=@explode('|', $field_cfg[0]);
                            $checked_ary=@explode('|', $gift_ext_row[$field_name]);
                            for($i=0; $i<count($value_list); $i++){
                                $check=in_array($value_list[$i], $checked_ary)?'checked':'';
                                $value=htmlspecialchars($value_list[$i]);
                                echo "<div><input type='checkbox' name='{$field_name}[]' value=\"$value\" $check>{$value_list[$i]}</div>";
                            }?></td>
                        </tr>
                    <?php }elseif($form_type=='input_file'){?>
                        <tr>
                            <td nowrap><?=get_lang('gift.ext.'.$field_cfg);?>:</td>
                            <td><input name="<?=$field_cfg;?>" type="file" size="50" class="form_input" contenteditable="false"><input type="hidden" name="S_<?=$field_cfg;?>" value="<?=$gift_ext_row[$field_cfg];?>" /><?php if(is_file($site_root_path.$gift_ext_row[$field_cfg])){?>&nbsp;<?=get_lang('ly200.view');?>:<a href="../system/down_file.php?path=<?=$gift_ext_row[$field_cfg];?>" class="red"><?=$gift_ext_row[$field_cfg];?></a><?php }?></td>
                        </tr>
                    <?php }elseif($form_type=='select'){?>
                        <tr>
                            <td nowrap><?=get_lang('gift.ext.'.$field_name);?>:</td>
                            <td><select name="<?=$field_name;?>">
                                <option value="">--<?=get_lang('ly200.select');?>--</option>
                                <?php
                                $value_list=@explode('|', $field_cfg[0]);
                                for($i=0; $i<count($value_list); $i++){
                                    $select=$value_list[$i]==$gift_ext_row[$field_name]?'selected':'';
                                    $value=htmlspecialchars($value_list[$i]);
                                    echo "<option value=\"$value\" $select>{$value_list[$i]}</option>";
                                }?></select></td>
                        </tr>
                    <?php }elseif($form_type=='textarea'){?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                                <tr>
                                    <td nowrap><?=get_lang('gift.ext.'.$field_name).lang_name($i, 0);?>:</td>
                                    <td><textarea name="<?=$field_name.lang_name($i, 1);?>" rows="<?=$field_cfg[1];?>" cols="<?=$field_cfg[2];?>" class="form_area"><?=htmlspecialchars($gift_ext_row[$field_name.lang_name($i, 1)]);?></textarea></td>
                                </tr>
                            <?php }?>
                        <?php }else{?>
                            <tr>
                                <td nowrap><?=get_lang('gift.ext.'.$field_name);?>:</td>
                                <td><textarea name="<?=$field_name;?>" rows="<?=$field_cfg[1];?>" cols="<?=$field_cfg[2];?>" class="form_area"><?=htmlspecialchars($gift_ext_row[$field_name]);?></textarea></td>
                            </tr>
                        <?php }?>
                    <?php }elseif($form_type=='ckeditor'){?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                                <tr>
                                    <td nowrap><?=get_lang('gift.ext.'.$field_name).lang_name($i, 0);?>:</td>
                                    <td class="ck_editor"><textarea class="ckeditor" name="<?=$field_name.lang_name($i, 1);?>"><?=htmlspecialchars($gift_ext_row[$field_name.lang_name($i, 1)]);?></textarea></td>
                                </tr>
                            <?php }?>
                        <?php }else{?>
                            <tr>
                                <td nowrap><?=get_lang('gift.ext.'.$field_name);?>:</td>
                                <td class="ck_editor"><textarea class="ckeditor" name="<?=$field_name;?>"><?=htmlspecialchars($gift_ext_row[$field_name]);?></textarea></td>
                            </tr>
                        <?php }?>
                    <?php
                    }
                }
            }
            ?>
        
            <?php if(get_cfg('gift.pic_count')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                    	<?php for($i=0; $i<get_cfg('gift.pic_count'); $i++){ ?>
                            <font class="fl">图片<?=($i+1);?></font>
                            <span class="fl">
                                <input name="PicPath_<?=$i?>" type="file" class="form_largefile" contenteditable="false">
                                <?php if(get_cfg('gift.pic_alt')){?>
                                    &nbsp;&nbsp;<?=get_lang('ly200.alt');?>:<input name="Alt_<?=$i;?>" type="text" value="<?=htmlspecialchars($gift_row['Alt_'.$i]);?>" class="form_input" size="25" maxlength="100">
                                <?php }?>
                                <br /><br />
                            </span>
                            <div class="clear"></div>
                       	<?php } ?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px; margin-left:<?=get_cfg('gift.pic_count')>1?'12':'0';?>px;">
                          <tr>
                            <?php
                            for($i=0; $i<get_cfg('gift.pic_count'); $i++){
                                if(!is_file($site_root_path.$gift_row['PicPath_'.$i])){
                                    continue;
                                }
                            ?>
                                <td>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list_<?=$i;?>"><a href="<?=str_replace('s_', '', $gift_row['PicPath_'.$i]);?>" target="_blank"><img src="<?=$gift_row['PicPath_'.$i];?>" <?=img_width_height(70, 70, $instance_row['PicPath_'.$i]);?> /></a><input type='hidden' name='S_PicPath_<?=$i;?>' value='<?=$gift_row['PicPath_'.$i];?>'></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_<?=$i;?>_a">&nbsp;<a href="mod.php?action=delimg&ProId=<?=$ProId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$gift_row['PicPath_'.$i];?>&ImgId=img_list_<?=$i;?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
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
            
            <?php if(get_cfg('gift.seo_tkd')){?>
				<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo').lang_name($i, 0);?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($gift_row['SeoTitle'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($gift_row['SeoKeywords'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($gift_row['SeoDescription'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            
            <?php if(get_cfg('gift.is_in_index') || get_cfg('gift.is_hot') || get_cfg('gift.is_recommend') || get_cfg('gift.is_new') || get_cfg('gift.sold_out')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                        <span class="fl">
							<?php if(get_cfg('gift.is_in_index')){?>
                            	<div class="items<?=$gift_row['IsInIndex']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                            	<input name="IsInIndex" type="hidden" value="<?=$gift_row['IsInIndex']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('gift.is_hot')){?>
								<div class="items<?=$gift_row['IsHot']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('gift.is_hot');?></div>
                            	<input name="IsHot" type="hidden" value="<?=$gift_row['IsHot']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('gift.is_recommend')){?>
                            	<div class="items<?=$gift_row['IsRecommend']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('gift.is_recommend');?></div>
                            	<input name="IsRecommend" type="hidden" value="<?=$gift_row['IsRecommend']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('gift.is_new')){?>
								<div class="items<?=$gift_row['IsNew']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('gift.is_new');?></div>
                            	<input name="IsNew" type="hidden" value="<?=$gift_row['IsNew']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('gift.sold_out')){?>
                            	<div class="items<?=$gift_row['SoldOut']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('gift.sold_out');?></div>
                            	<input name="SoldOut" type="hidden" value="<?=$gift_row['SoldOut']==1?'1':'0';?>">
							<?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('gift.brief_description') || get_cfg('gift.brief_description')){?>
                <div class="tr last">
                	<div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
					<?php if(get_cfg('gift.brief_description')){?>
                        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.brief_description').lang_name($i, 0);?>:</font>
                                <span class="fl">
                                    <textarea name="BriefDescription<?=lang_name($i, 1);?>" rows="8" cols="106" class="form_area" ><?=htmlspecialchars($gift_row['BriefDescription'.lang_name($i, 1)])?></textarea>
                                </span>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>    
                    
					<?php if(get_cfg('gift.description')){?>
                        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="editor_row">
                                <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                                <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"><?=htmlspecialchars($gift_description_row['Description'.lang_name($i, 1)]);?></textarea></div>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="button fr">
            	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
				<input type="hidden" name="query_string" value="<?=$query_string;?>">
                <input type="hidden" name="ProId" value="<?=$ProId;?>">
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>