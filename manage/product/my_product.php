<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product';
check_permit('product', 'product.mod');

if($_GET['action']=='delimg'){
	$ProId=(int)$_POST['ProId'];
	$Field=$_GET['Field'];
	$PicPath=$_GET['PicPath'];
	$ImgId=$_GET['ImgId'];
	
	foreach(get_cfg('product.pic_size') as $key=>$value){
		if("$key"=='default'){
			del_file($PicPath);
			del_file(str_replace('s_', '', $PicPath));
		}else{
			del_file(str_replace('s_', $value.'_', $PicPath));
		}
	}
	
	$db->update('product', "ProId='$ProId'", array(
			$Field	=>	''
		)
	);
	
	$str=js_contents_code(get_lang('ly200.del_success'));
	echo "<script language=javascript>parent.document.getElementById('$ImgId').innerHTML='$str'; parent.document.getElementById('{$ImgId}_a').innerHTML='';</script>";
	exit;
}
//商户权限限制
$product_userId = $_GET['UserId'];
$product_GroupId = $db->get_one('userinfo', "UserId='$product_userId'",'GroupId');

if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
	$ProId=(int)$_POST['ProId'];
	$query_string=$_POST['query_string'];
	
	$Name=$_POST['Name'];
	$CateId=$db->get_row_count('product_category')>1?(int)$_POST['CateId']:$db->get_value('product_category', 1, 'CateId');
	$ItemNumber=$_POST['ItemNumber'];
	$Model=$_POST['Model'];
	$IsInIndex=(int)$_POST['IsInIndex'];
	$IsFeatured=(int)$_POST['IsFeatured'];
	$IsHot=(int)$_POST['IsHot'];
	$IsPatent=(int)$_POST['IsPatent'];
	$IsPatentCertificate=(int)$_POST['IsPatentCertificate'];
	$IsInfringement=(int)$_POST['IsInfringement'];
	$IsInProduction=(int)$_POST['IsInProduction'];
	$IsUse=(int)$_POST['IsUse'];
	$IsRecommend=(int)$_POST['IsRecommend'];
	$IsNew=(int)$_POST['IsNew'];
	$SoldOut=(int)$_POST['SoldOut'];
	$ColorId=get_cfg('product.color_ele_mode')?('|'.@implode('|', $_POST['ColorId']).'|'):(int)$_POST['ColorId'];
	$SizeId=get_cfg('product.size_ele_mode')?('|'.@implode('|', $_POST['SizeId']).'|'):(int)$_POST['SizeId'];
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
	$ItemNumber2=$_POST['ItemNumber2'];
	$PreSTime=@strtotime($_POST['PreSTime']);
	$PreETime=@strtotime($_POST['PreETime']);
	$StartTime=@strtotime($_POST['StartTime']);
	$EndTime=@strtotime($_POST['EndTime']);
	$IsBest=$_POST['IsBest'];
	$IsPromotion=$_POST['IsPromotion'];
	$Discount=$_POST['Discount'];
	$IsDefaultReview=$_POST['IsDefaultReview'];
	$DefaultReviewRating=$_POST['DefaultReviewRating'];
	$DefaultReviewTotalRating =$_POST['DefaultReviewTotalRating'];
	$DefaultLove=$_POST['DefaultLove'];
	$PreEXT=$_POST['PreEXT'];
	$Param_Price=$_POST['Param_Price'];
	
	//产品属性
	if($CateId && $Param_Price){
		$cate_row=$db->get_one('product_category',"CateId = '$CateId'",'UId,CateId');
		if($cate_row['UId']=='0,'){
			$TopCateId=	$cate_row['CateId'];
		}else{
			$TopCateId=get_top_CateId_by_UId($cate_row['UId']);
		}
		$TopCate_row=$db->get_one('product_category',"CateId='$TopCateId'",'PIdCateId');
		$attr_ary=$ext_ary=array();
		$row=$db->get_all('param',"CateId='{$TopCate_row['PIdCateId']}'");
		
		$attr_loop=0;//记录属性类个数
		foreach((array)$row as $v){
			$id=$v['PId'];
			$attr_ary[$id]=(array)$_POST['AttrId_'.$attr_loop];//记录一共选择的参数，用于前台详细页参数输出
			$attr_loop++;
		}
		
		for($i=0;$i<count($_POST['Param_Price']);$i++){
			$key='';
			for($t=0;$t<$attr_loop;$t++){
					if($t==0){
						$key.=$row[$t]['PId'].$_POST['AttrId_'.$t][$i];
					}else{
						$key.='_'.$row[$t]['PId'].$_POST['AttrId_'.$t][$i];
					}
			}
			if(isset($ext_ary[$key])){
				js_back('产品属性不能存在相同！');
			}
			$ext_ary[$key]=array($_POST['Param_Price'][$i],$_POST['Param_Stock'][$i]);
			
		}
		$Attr=addslashes(str::json_data(str::str_code($attr_ary, 'stripslashes')));
		$ExtAttr=addslashes(str::json_data(str::str_code($ext_ary, 'stripslashes')));
	}	
	
	$BigPicPath=$SmallPicPath=$PicAlt=array();	//$SmallPicPath存入数据库的
	if(get_cfg('product.pic_count')){
		include('../../inc/fun/img_resize.php');
		for($i=0; $i<get_cfg('product.pic_count'); $i++){
			$PicAlt[]=$_POST['Alt_'.$i];
			$S_PicPath=$_POST['S_PicPath_'.$i];
			if($tmp_path=up_file($_FILES['PicPath_'.$i], $save_dir)){
				$BigPicPath[$i]=$SmallPicPath[$i]=$tmp_path;
				del_file($S_PicPath);
				del_file(str_replace('s_', '', $S_PicPath));
				foreach(get_cfg('product.pic_size') as $key=>$value){
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
	
	$db->update('product', "ProId='$ProId'", array(
			'CateId'			=>	$CateId,
			'Name'				=>	$Name,
			'ItemNumber'		=>	$ItemNumber,
			'ItemNumber2'		=>	$ItemNumber2,
			'Model'				=>	$Model,
			'IsInIndex'			=>	$IsInIndex,
			'IsFeatured'		=>	$IsFeatured,
			'IsHot'				=>	$IsHot,
			'IsPatent'				=>	$IsPatent,
			'IsPatentCertificate'	=>	$IsPatentCertificate,
			'IsInfringement'		=>	$IsInfringement,
			'IsInProduction'		=>	$IsInProduction,
			'IsUse'				=>	$IsUse,
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
            'Integral'          =>  $Integral,
			'IsSpecialOffer'	=>	$IsSpecialOffer,
			'SpecialOfferPrice'	=>	$SpecialOfferPrice,
			'BriefDescription'	=>	$BriefDescription,
			'SeoTitle'			=>	$SeoTitle,
			'SeoKeywords'		=>	$SeoKeywords,
			'SeoDescription'	=>	$SeoDescription,
			'AccTime'			=>	$service_time,
			'PreSTime'			=>	$PreSTime,
			'PreETime'			=>	$PreETime,
			'StartTime'			=>	$StartTime,
			'EndTime'			=>	$EndTime,
			'IsBest'			=>	$IsBest,
			'IsPromotion'		=>	$IsPromotion,
			'Discount'			=>	$Discount,
			'IsDefaultReview'	=>	$IsDefaultReview,
			'DefaultReviewRating'=>	$DefaultReviewRating,
			'DefaultReviewTotalRating'=>$DefaultReviewTotalRating,
			'DefaultLove'		=>	$DefaultLove,
			'PreEXT'			=>	$PreEXT,
			'Attr'				=>	$Attr,
			'ExtAttr'			=>	$ExtAttr,
		)
	);
	
	if(get_cfg('product.description')){
		$Description=save_remote_img($_POST['Description'], $save_dir);
		$Description2=save_remote_img($_POST['Description2'], $save_dir);
		$db->update('product_description', "ProId='$ProId'", array(
				'Description'	=>	$Description,
				'Description2'	=>	$Description2
			)
		);
	}
	
	//保存批发价
	if(get_cfg('product.price') && get_cfg('product.wholesale_price')){
		$db->delete('product_wholesale_price', "ProId='$ProId'");
		for($i=0; $i<count($_POST['Qty']); $i++){
			$qty=(int)$_POST['Qty'][$i];
			$price=(float)$_POST['WholesalePrice'][$i];
			if($qty && $price){
				$db->insert('product_wholesale_price', array(
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
		add_lang_field('product', array('Name', 'BriefDescription', 'SeoTitle', 'SeoKeywords', 'SeoDescription'));
		add_lang_field('product_description', 'Description');
		
		for($i=1; $i<count(get_cfg('ly200.lang_array')); $i++){
			$field_ext='_'.get_cfg('ly200.lang_array.'.$i);
			$NameExt=$_POST['Name'.$field_ext];
			$BriefDescriptionExt=$_POST['BriefDescription'.$field_ext];
			$SeoTitleExt=$_POST['SeoTitle'.$field_ext];
			$SeoKeywordsExt=$_POST['SeoKeywords'.$field_ext];
			$SeoDescriptionExt=$_POST['SeoDescription'.$field_ext];
			$db->update('product', "ProId='$ProId'", array(
					'Name'.$field_ext				=>	$NameExt,
					'BriefDescription'.$field_ext	=>	$BriefDescriptionExt,
					'SeoTitle'.$field_ext			=>	$SeoTitleExt,
					'SeoKeywords'.$field_ext		=>	$SeoKeywordsExt,
					'SeoDescription'.$field_ext		=>	$SeoDescriptionExt
				)
			);
			
			if(get_cfg('product.description')){
				$DescriptionExt=save_remote_img($_POST['Description'.$field_ext], $save_dir);
				$db->update('product_description', "ProId='$ProId'", array(
						'Description'.$field_ext	=>	$DescriptionExt
					)
				);
			}
		}
	}
	
	//保存扩展数据
	$field=$field_type=array();
	$data['ProId']=$ProId;
	$columns=$db->show_columns('product_ext', 1);	//获取数据表的所有字段名称
	foreach(get_cfg('product.ext') as $form_type=>$field_list){	//扩展参数，form_type=>表单类型，field_list=>表单各项配置值
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
			$db->query("alter table product_ext add $field[$i] $f");
		}
	}
	$db->update('product_ext', "ProId='$ProId'", $data);
	
	set_page_url('product', "ProId='$ProId'", get_cfg('product.page_url'), 1);
	
	save_manage_log('编辑产品:'.$Name);
	
	header("Location: index.php?$query_string");
	exit;
}

$ProId=(int)$_GET['ProId'];
$query_string=query_string('ProId');

$product_row=$db->get_one('product', "ProId='$ProId'");
$product_ext_row=$db->get_one('product_ext', "ProId='$ProId'");
$product_description_row=$db->get_one('product_description', "ProId='$ProId'");
$product_wholesale_price_row=$db->get_all('product_wholesale_price', "ProId='$ProId'", '*', 'Price desc, PId desc');

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('product_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
            <div class="tr">
                <div class="tr_title"><?=get_lang('ly200.mod').get_lang('product.modelname');?></div>
                <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.name').lang_name($i, 0);?>:</font>
                        <span class="fl">
                        	<input name="Name<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($product_row['Name'.lang_name($i, 1)]);?>" class="form_input" size="98" maxlength="100" check="<?=get_lang('ly200.filled_out').get_lang('ly200.name');?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
            </div>
            <div class="tr">
                <div class="form_row">
                    <font class="fl">产品审核:</font>
                    <span class="fl">
                    	<b>请正确选择审核选项 审核不通过的产品将不能上线</b><br />
                        1. 该产品是否有专利？<br /> 
                        <input type="radio" name="IsPatent" <?=$product_row['IsPatent'] ? '' : 'checked="checked"'; ?> value="0" id=""> 没有 &nbsp;&nbsp;
                        <input type="radio" name="IsPatent" <?=$product_row['IsPatent'] ? 'checked="checked"' : ''; ?> value="1" id=""> 有 <br />
                        2. 该产品有没有专利证书? <br />
                        <input type="radio" name="IsPatentCertificate" <?=$product_row['IsPatentCertificate'] ? '' : 'checked="checked"'; ?> value="0" id=""> 没有 &nbsp;&nbsp;
                        <input type="radio" name="IsPatentCertificate" <?=$product_row['IsPatentCertificate'] ? 'checked="checked"' : ''; ?> value="1" id=""> 有 <br />
                        3. 该产品属于侵权产品？<br />
                        <input type="radio" name="IsInfringement" <?=$product_row['IsInfringement'] ? '' : 'checked="checked"'; ?> value="0" id=""> 不是 &nbsp;&nbsp;
                        <input type="radio" name="IsInfringement" <?=$product_row['IsInfringement'] ? 'checked="checked"' : ''; ?> value="1" id=""> 是 <br />
                        4. 该产品是否已经可以进入正常投产当中？<br />
                        <input type="radio" name="IsInProduction" <?=$product_row['IsInProduction'] ? '' : 'checked="checked"'; ?> value="0" id=""> 不是 &nbsp;&nbsp;
                        <input type="radio" name="IsInProduction" <?=$product_row['IsInProduction'] ? 'checked="checked"' : ''; ?> value="1" id=""> 是 <br />
                     </span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if($product_GroupId['GroupId'] !== '4' && $product_GroupId['GroupId'] !== '3'){?>
            <div class="tr">
                <div class="form_row">
                    <font class="fl">审核结果:</font>
                    <span class="fl">
                    	<b>请正确选择审核结果 审核不通过的产品将不能上线</b><br />
                        1. 该产品是否审核通过？<br /> 
                        <input type="radio" name="IsUse" <?=$product_row['IsUse'] ? '' : 'checked="checked"'; ?> value="0" id=""> 审核中 &nbsp;&nbsp;
                        <input type="radio" name="IsUse" <?=$product_row['IsUse']==1 ? 'checked="checked"' : ''; ?> value="1" id=""> 审核不通过 <br />
                        <input type="radio" name="IsUse" <?=$product_row['IsUse']==2 ? 'checked="checked"' : ''; ?> value="2" id=""> 审核通过 <br />
                     </span>
                    <div class="clear"></div>
                </div>
            </div>
            <?php }?>
            <?php if($db->get_row_count('product_category')>1){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('ly200.category');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select" onchange="Param.changecate()"',ouput_Category_to_Select('CateId', $product_row['CateId'], 'product_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
            
            <?php if(get_cfg('product.item_number')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.item_number');?>:</font>
                        <span class="fl">
                            <input name="ItemNumber" type="text" value="<?=htmlspecialchars($product_row['ItemNumber']);?>" class="form_input" size="98" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl">Warehouse NO.:</font>
                        <span class="fl">
                            <input name="ItemNumber2" type="text" value="<?=htmlspecialchars($product_row['ItemNumber2']);?>" class="form_input" size="98" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('product.model')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.model');?>:</font>
                        <span class="fl">
                            <input name="Model" type="text" value="<?=htmlspecialchars($product_row['Model']);?>" class="form_input" size="98" maxlength="50">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('product.color_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.color');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',get_cfg('product.color_ele_mode')?ouput_table_to_input('product_color', 'CId', 'Color', 'ColorId[]', 'MyOrder desc, CId asc', 1, 1, 'checkbox', $product_row['ColorId']):ouput_table_to_select('product_color', 'CId', 'Color', 'ColorId', 'MyOrder desc, CId asc', 1, 1, $product_row['ColorId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('product.size_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.size');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',get_cfg('product.size_ele_mode')?ouput_table_to_input('product_size', 'SId', 'Size', 'SizeId[]', 'MyOrder desc, SId asc', 1, 1, 'checkbox', $product_row['SizeId']):ouput_table_to_select('product_size', 'SId', 'Size', 'SizeId', 'MyOrder desc, SId asc', 1, 1, $product_row['SizeId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if(get_cfg('product.brand_ele')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.brand');?>:</font>
                        <span class="fl">
                            <?=str_replace('<select','<select class="form_select"',ouput_table_to_select('product_brand', 'BId', 'Brand', 'BrandId', 'MyOrder desc, BId asc', 1, 1, $product_row['BrandId'], '', get_lang('ly200.select')));?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>
			
            <?php if(get_cfg('product.stock')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.stock');?>:</font>
                        <span class="fl">
                            <input name="Stock" type="text" value="<?=$product_row['Stock'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>

			<?php if(get_cfg('product.start_from')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.start_from');?>:</font>
                        <span class="fl">
                            <input name="StartFrom" type="text" value="<?=$product_row['StartFrom'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);">
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('product.weight')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.weight');?>:</font>
                        <span class="fl">
							<input name="Weight" type="text" value="<?=$product_row['Weight'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);"><?=get_lang('product.weight_unit');?>&nbsp;&nbsp;（重量包括产品自身重量和包装重量！）
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
			
            <?php if(get_cfg('product.price')){?>
                <div class="tr">
                    <div class="form_row">
						<font class="fl"><?=get_lang('product.price');?>:</font>
                        <span class="fl">
						
                            
                            美元价格:¥<input name="Price_1" type="text" value="<?=$product_row['Price_1'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);" check="<?=get_lang('ly200.filled_out').美元价格;?>!~*">&nbsp;&nbsp;
							人民币价格:¥<input name="Price_2" type="text" value="<?=$product_row['Price_2'];?>" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);" check="<?=get_lang('ly200.filled_out').人民币价格;?>!~*">
                        </span>
                        <div class="clear"></div>
                    </div>
                    <?php if(get_cfg('product.wholesale_price')){?>
                    	<div class="form_row">
                        	<font class="fl"><?=get_lang('product.wholesale_price');?>:</font>
                            <span class="fl">
                                <table border="0" cellspacing="0" cellpadding="0" id="wholesale_price_list" class="item_data_table">
                                    <tr>
                                        <td><a href="javascript:void(0);" onClick="this.blur(); add_wholesale_price_item('wholesale_price_list');" class="red"><?=get_lang('ly200.add_item');?></a></td>
                                    </tr>
                                    <?php for($i=0; $i<count($product_wholesale_price_row); $i++){?>
                                        <tr>
                                            <td><?=get_lang('ly200.qty');?>:<input name="Qty[]" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=$product_wholesale_price_row[$i]['Qty'];?>" class="form_input" type="text" size="8" maxlength="10">&nbsp;&nbsp;单价（美元）：<input name="WholesalePrice[]" value="<?=$product_wholesale_price_row[$i]['Price'];?>" class="form_input" type="text" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);"><a href="javascript:void(0)" onClick="$_('wholesale_price_list').deleteRow(this.parentNode.parentNode.rowIndex);"><img src="../images/del.gif" hspace="5" /></a></td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </span>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if(get_cfg('product.is_promotion')){?>
            <div class="tr">
                    <div class="form_row">
						<font class="fl"><?=get_lang('product.is_promotion');?>:</font>
                        <span class="fl">
                        	<input type="checkbox" name="IsPromotion" value="1" <?=$product_row['IsPromotion']?'checked="checked"':''?>  />
                           &nbsp;&nbsp; 折扣<input type="text" name="Discount" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" class="form_input" value="<?=$product_row['Discount']?>" />(10,10%的减价)
                           &nbsp;&nbsp; 开始时间<input type="text" name="StartTime" id="StartTime" class="form_input" value="<?=date('Y-m-d',$product_row['StartTime'])?>" />
                           &nbsp;&nbsp; 结束时间<input type="text" name="EndTime" id="EndTime" class="form_input" value="<?=date('Y-m-d',$product_row['EndTime'])?>" />
                        </span>
                         <div class="clear"></div>
                    </div>
            </div>
            <?php }?>
            <?php if(get_cfg('product.review')){?>
            <div class="tr">
                    <div class="form_row">
						<font class="fl">评论:</font>
                        <span class="fl">
                        	<input type="checkbox" name="IsDefaultReview" value="1" <?=$product_row['IsDefaultReview']?'checked="checked"':''?> />
                            &nbsp;&nbsp; 默认评论数<input type="text" name="DefaultReviewRating" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" class="form_input" value="<?=$product_row['DefaultReviewRating']?>" />
                            &nbsp;&nbsp; 默认星星数<input type="text" name="DefaultReviewTotalRating" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" class="form_input" value="<?=$product_row['DefaultReviewTotalRating']?>" />
                        </span>
                         <div class="clear"></div>
                    </div>
            </div>
            <?php }?>
            <?php if(get_cfg('product.love')){?>
            <div class="tr">
                    <div class="form_row">
						<font class="fl">收藏:</font>
                        <span class="fl">
                            &nbsp;&nbsp; 默认收藏数<input type="text" name="DefaultLove" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" class="form_input" value="<?=$product_row['DefaultReviewRating']?>" />
                        </span>
                        <div class="clear"></div>
                    </div>
            </div>
            <?php }?>

            <?php if(get_cfg('product.integral')){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product.integral');?>:</font>
                        <span class="fl">
							<input name="Integral" type="text" value="<?=htmlspecialchars($product_row['Integral']);?>" class="form_input" size="10" maxlength="10" >
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }?>

			
        
            <?php if(get_cfg('product.pic_count')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.upload_pic');?>:</div>
                    <div class="form_row">
                    	<?php for($i=0; $i<get_cfg('product.pic_count'); $i++){ ?>
                            <font class="fl">图片<?=($i+1);?></font>
                            <span class="fl">
                                <input name="PicPath_<?=$i?>" type="file" class="form_largefile" contenteditable="false">
                                <?php if(get_cfg('product.pic_alt')){?>
                                    &nbsp;&nbsp;<?=get_lang('ly200.alt');?>:<input name="Alt_<?=$i;?>" type="text" value="<?=htmlspecialchars($product_row['Alt_'.$i]);?>" class="form_input" size="25" maxlength="100">
                                <?php }?>
                                <br /><br />
                            </span>
                            <div class="clear"></div>
                       	<?php } ?>
                        <iframe src="about:blank" name="del_img_iframe" style="display:none;"></iframe>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top:8px; margin-left:<?=get_cfg('product.pic_count')>1?'12':'0';?>px;">
                          <tr>
                            <?php
                            for($i=0; $i<get_cfg('product.pic_count'); $i++){
                                if(!is_file($site_root_path.$product_row['PicPath_'.$i])){
                                    continue;
                                }
                            ?>
                                <td>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="70" height="70" style="border:1px solid #ddd; background:#fff;" align="center" id="img_list_<?=$i;?>"><a href="<?=str_replace('s_', '', $product_row['PicPath_'.$i]);?>" target="_blank"><img src="<?=$product_row['PicPath_'.$i];?>" <?=img_width_height(70, 70, $instance_row['PicPath_'.$i]);?> /></a><input type='hidden' name='S_PicPath_<?=$i;?>' value='<?=$product_row['PicPath_'.$i];?>'></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding-top:4px;"><?=get_lang('ly200.photo');?><span id="img_list_<?=$i;?>_a">&nbsp;<a href="mod.php?action=delimg&ProId=<?=$ProId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$product_row['PicPath_'.$i];?>&ImgId=img_list_<?=$i;?>" target="del_img_iframe" class="blue">(<?=get_lang('ly200.del');?>)</a></span></td>
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
            
            <?php if(get_cfg('product.seo_tkd')){?>
				<?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.seo.seo').lang_name($i, 0);?>:</div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.title');?>:</font>
                            <span class="fl">
                                <input name="SeoTitle<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($product_row['SeoTitle'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.keywords');?>:</font>
                            <span class="fl">
                                <input name="SeoKeywords<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($product_row['SeoKeywords'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.seo.description');?>:</font>
                            <span class="fl">
                                <input name="SeoDescription<?=lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($product_row['SeoDescription'.lang_name($i, 1)])?>" class="form_input" size="98" maxlength="200">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            
            <?php /*if(get_cfg('product.is_new')){?>
	            <div class="tr">
	                <div class="tr_title">新品预订:</div>
	                <div class="form_row">
	                    <span class="fl">
	                            <div class="items<?=$product_row['IsNew']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_new');?></div>
	                            <input name="IsNew" class="isnew" type="hidden" value="<?=$product_row['IsNew']==1?'1':'0';?>">
	                            &nbsp; &nbsp;预订上架时间：<input name="PreSTime" class="form_input" type="text" size="12" id="SelectDateS" value="<?=date('Y-m-d',$product_row['PreSTime'])?>" >
	                            &nbsp; &nbsp;预订下架时间：<input name="PreETime" class="form_input" type="text" size="12" id="SelectDateE" value="<?=date('Y-m-d',$product_row['PreETime'])?>" >
	                             &nbsp; &nbsp;类型：Sample Products<input name="PreEXT" type="radio" value="1" <?=$product_row['PreEXT']==1?'checked="checked"':''?> >&nbsp; &nbsp;&nbsp; &nbsp;Off The Shelf<input name="PreEXT" type="radio" value="2" <?=$product_row['PreEXT']==2?'checked="checked"':''?> >
	                    </span>
	                    <div class="clear"></div>
	                </div>
	            </div>
            <?php }*/ ?>
            <?php if(get_cfg('product.is_in_index') || get_cfg('product.is_hot') || get_cfg('product.is_recommend') || get_cfg('product.is_new') || get_cfg('product.sold_out')){?>
            	<div class="tr">
                	<div class="tr_title"><?=get_lang('ly200.other_property');?>:</div>
                    <div class="form_row">
                        <span class="fl">
							<?php if(get_cfg('product.is_in_index')){?>
                            	<div class="items<?=$product_row['IsInIndex']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('ly200.is_in_index');?></div>
                            	<input name="IsInIndex" type="hidden" value="<?=$product_row['IsInIndex']==1?'1':'0';?>">
							<?php }?>
							<?php if(get_cfg('product.is_new')){?>
                            	<div class="items<?=$product_row['IsNew']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_new');?></div>
                            	<input name="IsNew" type="hidden" value="<?=$product_row['IsNew']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('product.is_hot')){?>
								<div class="items<?=$product_row['IsHot']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_hot');?></div>
                            	<input name="IsHot" type="hidden" value="<?=$product_row['IsHot']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('product.is_recommend')){?>
                            	<div class="items<?=$product_row['IsRecommend']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_recommend');?></div>
                            	<input name="IsRecommend" type="hidden" value="<?=$product_row['IsRecommend']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('product.sold_out')){?>
                            	<div class="items<?=$product_row['SoldOut']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.sold_out');?></div>
                            	<input name="SoldOut" type="hidden" value="<?=$product_row['SoldOut']==1?'1':'0';?>">
							<?php }?>
                            <?php if(get_cfg('product.is_best')){?>
                            	<div class="items<?=$product_row['IsBest']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_best');?></div>
                            	<input name="IsBest" type="hidden" value="<?=$product_row['IsBest']==1?'1':'0';?>">
							<?php }?>
							<?php if(get_cfg('product.is_featured')){?>
                            	<div class="items<?=$product_row['IsFeatured']?' cur':''?>" onClick="checkproperty(this)"><?=get_lang('product.is_featured');?></div>
                            	<input name="IsFeatured" type="hidden" value="<?=$product_row['IsFeatured']==1?'1':'0';?>">
							<?php }?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php
            foreach(get_cfg('product.ext') as $form_type=>$field_list){	//扩展参数，form_type=>表单类型，field_list=>表单各项配置值
                foreach($field_list as $field_name=>$field_cfg){	//field_name=>表单名称，field_cfg=>表单配置
                    if($form_type=='input_text'){
                    ?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            	<div class="tr">
                                	<div class="form_row">
                                        <font class="fl"><?=get_lang('product.ext.'.$field_name).lang_name($i, 0);?>:</font>
                                        <span class="fl">
                                            <input name="<?=$field_name.lang_name($i, 1);?>" type="text" value="<?=htmlspecialchars($product_ext_row[$field_name.lang_name($i, 1)]);?>" class="form_input" size="<?=$field_cfg[1];?>" maxlength="<?=$field_cfg[2];?>">
                                        </span>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }else{?>
                            <div class="tr">
                                <div class="form_row">
                                    <font class="fl"><?=get_lang('product.ext.'.$field_name);?>:</font>
                                    <span class="fl">
                                        <input name="<?=$field_name;?>" type="text" value="<?=htmlspecialchars($product_ext_row[$field_name]);?>" class="form_input" size="<?=$field_cfg[1];?>" maxlength="<?=$field_cfg[2];?>">
                                    </span>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }elseif($form_type=='input_radio'){?>
                        <div class="tr">
                        	<div class="form_row">
	                            <font class="fl"><?=get_lang('product.ext.'.$field_name);?>:</font>
	                            <?php
	                            $value_list=@explode('|', $field_cfg[0]);
	                            for($i=0; $i<count($value_list); $i++){
	                                $check=$value_list[$i]==$product_ext_row[$field_name]?'checked':'';
	                                $value=htmlspecialchars($value_list[$i]);
	                                echo "<div class='fl ext_radio'><label><input type='radio' name='$field_name' value=\"$value\" $check>{$value_list[$i]}</label></div>";
	                            }?>
                                <div class="clear"></div>
	                        </div>
                       	</div>
                    <?php }elseif($form_type=='input_checkbox'){?>
                        <div class="tr">
                        	<div class="form_row">
	                            <font class="fl"><?=get_lang('product.ext.'.$field_name);?>:</font>
                            <?php
                            $value_list=@explode('|', $field_cfg[0]);
                            $checked_ary=@explode('|', $product_ext_row[$field_name]);
                            for($i=0; $i<count($value_list); $i++){
                                $check=in_array($value_list[$i], $checked_ary)?'checked':'';
                                $value=htmlspecialchars($value_list[$i]);
                                echo "<div class='fl ext_checkbox'><label><input type='checkbox' name='{$field_name}[]' value=\"$value\" $check>{$value_list[$i]}</label></div>";
                            }?>
                            </div>
                        </div>
                    <?php }elseif($form_type=='input_file'){?>
                        <div class="tr">
                            <div class="form_row">
	                            <font class="fl"><?=get_lang('product.ext.'.$field_cfg);?>:</font>
                            	<input name="<?=$field_cfg;?>" type="file" size="50" class="form_input" contenteditable="false"><input type="hidden" name="S_<?=$field_cfg;?>" value="<?=$product_ext_row[$field_cfg];?>" /><?php if(is_file($site_root_path.$product_ext_row[$field_cfg])){?>&nbsp;<?=get_lang('ly200.view');?>:<a href="../system/down_file.php?path=<?=$product_ext_row[$field_cfg];?>" class="red"><?=$product_ext_row[$field_cfg];?></a><?php }?>
                            </div>
                        </div>
                    <?php }elseif($form_type=='select'){?>
                        <div class="tr">
                            <div class="form_row">
                            <font class="fl"><?=get_lang('product.ext.'.$field_name);?>:</font>
	                            <select name="<?=$field_name;?>" class="form_select"> 
	                                <option value="">--<?=get_lang('ly200.select');?>--</option>
	                                <?php
	                                $value_list=@explode('|', $field_cfg[0]);
	                                for($i=0; $i<count($value_list); $i++){
	                                    $select=$value_list[$i]==$product_ext_row[$field_name]?'selected':'';
	                                    $value=htmlspecialchars($value_list[$i]);
	                                    echo "<option value=\"$value\" $select>{$value_list[$i]}</option>";
	                                }?>
	                            </select>
                            </div>
                        </div>
                    <?php }elseif($form_type=='textarea'){?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                                <div class="tr">
                           			<div class="form_row">
                                    	<font class="fl"><?=get_lang('product.ext.'.$field_name).lang_name($i, 0);?>:</font>
                                    	<span class="fl">
                                    		<textarea name="<?=$field_name.lang_name($i, 1);?>" rows="<?=$field_cfg[1];?>" cols="<?=$field_cfg[2];?>" class="form_area"><?=htmlspecialchars($product_ext_row[$field_name.lang_name($i, 1)]);?></textarea>
                                    	</span>
                                    	<div class="clear"></div>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }else{?>
                            <div class="tr">
                           		<div class="form_row">
                               		<font class="fl"><?=get_lang('product.ext.'.$field_name);?>:</font>
                                	<span class="fl">
                                		<textarea name="<?=$field_name;?>" rows="<?=$field_cfg[1];?>" cols="<?=$field_cfg[2];?>" class="form_area"><?=htmlspecialchars($product_ext_row[$field_name]);?></textarea>
                                	</span>
                                	<div class="clear"></div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }elseif($form_type=='ckeditor'){?>
                        <?php if($field_cfg[0]){	//多语言输入?>
                            <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="tr last">
                                <div class="editor_row">
	                                <div class="editor_title fl"><?=get_lang('product.ext.'.$field_name).lang_name($i, 0);?>:</div>
	                                <div class="editor_con ck_editor fl"><textarea class="ckeditor" style="width: 740px;"> name="<?=$field_name.lang_name($i, 1);?>"><?=htmlspecialchars($product_ext_row[$field_name.lang_name($i, 1)]);?></textarea></div>
	                                <div class="clear"></div>
                            	</div>
                            </div>
                            <?php }?>
                        <?php }else{?>
                            <tr>
                                <td nowrap><?=get_lang('product.ext.'.$field_name);?>:</td>
                                <td class="ck_editor"><textarea class="ckeditor" name="<?=$field_name;?>"><?=htmlspecialchars($product_ext_row[$field_name]);?></textarea></td>
                            </tr>
                        <?php }?>
                    <?php
                    }
                }
            }
            ?>

            <?php if(get_cfg('product.brief_description') || get_cfg('product.brief_description')){?>
                <div class="tr last">
                	<div class="tr_title"><?=get_lang('ly200.briefinfo');?>:</div>
					<?php if(get_cfg('product.brief_description')){?>
                        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="form_row">
                                <font class="fl"><?=get_lang('ly200.brief_description').lang_name($i, 0);?>:</font>
                                <span class="fl">
                                    <textarea name="BriefDescription<?=lang_name($i, 1);?>" rows="8" cols="106" class="form_area" ><?=htmlspecialchars($product_row['BriefDescription'.lang_name($i, 1)])?></textarea>
                                </span>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>    
                    
					<?php if(get_cfg('product.description')){?>
                        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="editor_row">
                                <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                                <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description<?=lang_name($i, 1);?>"><?=htmlspecialchars($product_description_row['Description'.lang_name($i, 1)]);?></textarea></div>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php /*if(get_cfg('product.description')){?>
                        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
                            <div class="editor_row">
                                <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>
                                <div class="editor_con ck_editor fl"><textarea class="ckeditor" name="Description2<?=lang_name($i, 1);?>"><?=htmlspecialchars($product_description_row['Description2'.lang_name($i, 1)]);?></textarea></div>
                                <div class="clear"></div>
                            </div>
                        <?php } ?>
                    <?php }*/ ?>
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