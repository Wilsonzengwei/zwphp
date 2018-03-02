<?php 
include($site_root_path.'/inc/lang/cn.php');
include($site_root_path.'/inc/manage/config/1.php');
/*if($_SESSION['IsSupplier'] !== '1'){
  
    echo '<script>alert("只有商户才能访问");</script>';
    header("Refresh:0;url=/");
    exit;
}*/
$ProId=(int)$_GET['ProId'];
if(!$ProId){
	$ProId=(int)$_POST['ProId'];
}
$SupplierId = $_SESSION['member_MemberId'];
if(!$db->get_one("product","ProId=".$ProId." and SupplierId=".$SupplierId)){
	echo '<script>alert("请不要进行非法操作");</script>';
	header("Refresh:0;url=/supplier_manage.php?module=product");
	exit;
}
if($_GET['action']=='delimg'){
	$ProId=(int)$_GET['ProId'];
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
	header('Location: mod.php?ProId='.$ProId);
	exit;
}
//商户权限限制
$product_userId = $_GET['UserId'];
$product_GroupId = $db->get_one('userinfo', "UserId='$product_userId'",'GroupId');
$SupplierId = $_SESSION['member_MemberId'];
$ProId = $_GET['ProId'];
if($_POST['IsUse']=="2"){
	$SupplierId = $_POST['SupplierId'];
	$ProId = $_POST['ProId'];
	$Product_CodeId = $SupplierId."0000";
	if($db->get_one("product","SupplierId='$SupplierId' and ProId='$ProId' and ProductCodeId!=''")){

	}else{
		$product_rows = $db->get_all('product',"SupplierId='$SupplierId' and ProductCodeId!=''",'*',"ProductCodeId asc");
		$product_count = count($product_rows);

		if($product_count == '0'){
			$ProductCodeId = $SupplierId."0000";
			//var_dump($ProductCodeId);exit;
		}else{
			$ProductCodeId = $product_rows[$product_count-1]['ProductCodeId']+1;
			
		}
		$db->update('product',"ProId='$ProId'",array(
				'ProductCodeId' => $ProductCodeId
			));
	}
}
if($_POST){
	$ProId=(int)$_POST['ProId'];
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
	$query_string=$_POST['query_string'];
	$Name_lang_1 = $_POST['Name_lang_1'];
	$Name = $_POST['Name'];
	$Name_en = $_POST['Name_en'];
	$ProId=$_POST['ProId'];
	
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
	$color_arr = $_POST['Color'];

	if($color_arr){
		$ColorId = implode(",",$color_arr);
		
	}else{
		echo '<script>alert("必须选择最少一种颜色");history.go(-1);</script>';
		exit;
		
	}
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

	$CateId_1 = $_POST['CateId_1'];
	$CateId_2 = $_POST['CateId_2'];
	$CateId_3 = $_POST['CateId_3'];
	$CateId_arr = array($CateId_1,$CateId_2,$CateId_3);
	$CateId_implode = implode(',',$CateId_arr);
	if($CateId_1 != 0 && $CateId_2 != 0 && $CateId_3 != 0){

		$CateId=$db->get_row_count('product_category')>1?(int)$CateId_3:$db->get_value('product_category', 1, 'CateId');
	}elseif($CateId_1 != 0 && $CateId_2 != 0 && $CateId_3 == 0) {
		$CateId=$db->get_row_count('product_category')>1?(int)$CateId_2:$db->get_value('product_category', 1, 'CateId');
	}elseif($CateId_1 != 0 && $CateId_2 == 0 && $CateId_3 == 0) {
		$CateId=$db->get_row_count('product_category')>1?(int)$CateId_1:$db->get_value('product_category', 1, 'CateId');
	}elseif($CateId_1 == 0 && $CateId_2 == 0 && $CateId_3 == 0) {
		$CateId=$db->get_value('product_category', 1, 'CateId');
	}
	//var_dump($CateId_implode);exit;
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
	
	$BigPicPath=$SmallPicPath=$PicAlt=$filesize=array();	//$SmallPicPath存入数据库的
	if(get_cfg('product.pic_count')){
		include($site_root_path.'/inc/fun/img_resize.php');
		for($i=0; $i<get_cfg('product.pic_count'); $i++){
			$filesize[$i] = $_FILES['PicPath_'.$i];
			if($filesize[$i]['size'] > 2100000){
				echo '<script>alert("'.$filesize[$i]['name'].'图片大于2M,请重新上传该图片!")</script>';
				header("refresh:0;url=add.php");
				exit;
			}
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
			'SupplierId'		=>	$SupplierId,
			'Name'				=>	$Name,
			'Name_lang_1'		=>	$Name_lang_1,
			'Name_lang_2'		=>	$Name_en,
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
			'CateId2'			=>	$CateId_implode,
			
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
			$qty2=(int)$_POST['Qty2'][$i];
			$price2=(float)$_POST['WholesalePrice2'][$i];
			if($qty && $price){
				$db->insert('product_wholesale_price',array(
						'ProId'	=>	$ProId,
						'Qty'	=>	$qty,
						'Qty2'	=>	$qty2,
						'Price'	=>	$price,
						'Price2'=>	$price2
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
	
	header('Location: /supplier_manage.php?module=product');
	exit;
}

$ProId=(int)$_GET['ProId'];
$query_string=query_string('ProId');

$product_row=$db->get_one('product', "ProId='$ProId'");
$product_ext_row=$db->get_one('product_ext', "ProId='$ProId'");
$product_description_row=$db->get_one('product_description', "ProId='$ProId'");
$product_wholesale_price_row=$db->get_all('product_wholesale_price', "ProId='$ProId'", '*', 'Price asc, PId asc');
?>

	<script charset="utf-8" src="/plugin/kindeditor/kindeditor.js"></script>
    <script charset="utf-8" src="/plugin/kindeditor/lang/zh_CN.js"></script>
    <script charset="utf-8" src="/plugin/kindeditor/plugins/code/prettify.js"></script>
    <script>
    <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
        KindEditor.ready(function(K) {
            var editor1 = K.create('<?="#content_duo".$i;?>', {
                cssPath: '/plugin/kindeditor/plugins/code/prettify.css',
                uploadJson: '/plugin/kindeditor/php/upload_json.php',
                fileManagerJson: '/plugin/kindeditor/php/file_manager_json.php',
                allowFileManager: true,
                afterCreate: function() {
                    var self = this;
                    K.ctrl(document, 13, function() {
                        self.sync();
                        K('form[name=info]')[0].submit();
                    });
                    K.ctrl(self.edit.doc, 13, function() {
                        self.sync();
                        K('form[name=info]')[0].submit();
                    });
                }
            });
            prettyPrint();
        });
        <?php }?>
     </script> 
     <?php
     	echo '<link rel="stylesheet" href="/css/supplier_m/product_mod'.$lang.'.css">'
     ?>

<form action="/supplier_manage.php" method="post" enctype="multipart/form-data">
<div class="mask2">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['header'.$lang]['mjzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=1" class='s1'><?=$website_language['supplier_m_index'.$lang]['dpgl']?></a>						
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=index&act=2" class='s1'><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=product&act=3" class='s2'><?=$website_language['supplier_m_index'.$lang]['cpgl']?></a>			
		</li>
		<li class="y" data='1'><a href="/supplier_manage.php?module=order&act=4" class='s1'><?=$website_language['supplier_m_index'.$lang]['ddgl']?></a>		
		</li>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['header'.$lang]['cpgl']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>		
		<div class="yhh">
			<div class="biaoti"><?=$website_language['supplier_m_productm'.$lang]['cplbxg']?></div>
			<div class="y_form1">
				<span class="y_titless"><?=$website_language['supplier_m_productm'.$lang]['cpmc']?>(<?=$website_language['ylfy'.$lang]['zw']?>)：</span><div class="bitian">*</div><input class="y_title_txtbg ac" type="text" name="Name_lang_1" value="<?=$product_row['Name_lang_1']?>">
			</div>
			<div class="y_form1">
				<span class="y_titless"><?=$website_language['supplier_m_productm'.$lang]['cpmc']?>(<?=$website_language['ylfy'.$lang]['xw']?>)：</span><div class="bitian">*</div><input class="y_title_txtbg ac" type="text" name="Name" value="<?=$product_row['Name']?>">
			</div>
			<div class="y_form1">
				<span class="y_titless"><?=$website_language['supplier_m_productm'.$lang]['cpmc']?>(<?=$website_language['ylfy'.$lang]['yw']?>)：</span><div class="bitian">*</div><input class="y_title_txtbg ac" type="text" name="Name_en" value="<?=$product_row['Name_lang_2']?>">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['cplb']?>：</span>
				<div class="bitian">*</div>
				<select name="CateId_1" class="form_select" id="a1">
					<option value="0"><?=$website_language['ylfy'.$lang]['xz']?></option>
					<?php 
					$CateId2 = $product_row['CateId2'];
					$CateId2_im = explode(',',$CateId2);

					foreach((array)$All_Category_row['0,'] as $k => $v){ 
								
						if($lang == '_en'){
					    	$name = $v['Category_lang_2'];
					    }else{
							$name = $v['Category'.$lang];
					    }
						$name = $v['Category'.$lang];
						$vCateId = $v['CateId'];
						$vCateId1[] = $vCateId;
						$url = get_url('product_category',$v);
						$count_where="(CateId in(select CateId from product_category where UId like '%{$v[UId]}{$vCateId},%') or CateId='{$vCateId}')";
						$logo_ary = $menu_logo_ary1[$k];
					    $logobg = $logo_ary[0];
					    //var_dump($logo_ary[0]);exit;
					    $logocurbg = $logo_ary[1];     
					?>
						<option value="<?=$vCateId?>" <?=$vCateId == $CateId2_im['0'] ? selected :'';?>><?=$name?></option>
					<?php }?>
				</select>
				
				<select name="CateId_2" class="form_select" id="a2">
				<option value="0"><?=$website_language['ylfy'.$lang]['xz']?></option>
				<?php 
					if($CateId2_im['1'] != 0){
					
						foreach((array)$All_Category_row['0,'.$CateId2_im['0'].','] as $k1 => $v1){ 
					    if($lang == '_en'){
					    	$name1 = $v1['Category_lang_2'];
					    }else{
							$name1 = $v1['Category'.$lang];
					    }
					    
					    $v1CateId = $v1['CateId'];
					    $v1CateId1[] = $v1CateId;
					    $url1 = get_url('product_category',$v1);
				?>
					<option value="<?=$v1CateId?>" <?=$v1CateId == $CateId2_im['1'] ? selected :'';?>><?=$name1?></option>
				<?php }}else{?>

				<?php }?>
					
				</select>
				
				<select name="CateId_3" class="form_select" id="a3">
					<option value="0"><?=$website_language['ylfy'.$lang]['xz']?></option>
				<?php 
				if($CateId2_im['2']){
				foreach ($vCateId1 as $keymod2 => $valmod2) {
				foreach ($v1CateId1 as $keymod3 => $valmod3) {
					foreach((array)$All_Category_row['0,'.$valmod2.','.$valmod3.','] as $k2 => $v2){ 
					if($lang == '_en'){
						$name2 = $v2['Category_lang_2'];
					}else{
						$name2 = $v2['Category'.$lang];
					}
					$v2CateId = $v2['CateId'];
					$url2 = get_url('product_category',$v2);
				?>
				<option value="<?=$v2CateId?>" <?=$v2CateId == $CateId2_im['2'] ? selected :'';?>><?=$name2?></option>
				<?php }}}}else{?>
					
				<?php }?>
				</select>
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['kc']?>：</span><input class="y_title_txt" type="text" name="Stock" value="<?=$product_row['Stock']?>">
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['qdl']?>：</span><div class="bitian">*</div><input class="y_title_txt ust ac" type="text" name="StartFrom" value="<?=$product_row['StartFrom']?>">
			</div>
			<div class="y_form1" style="width:100%;float:left;margin-top:10px;min-height:31px;line-height:31px;font-size:12px;color:#333;line-height: 31px;">
	        	<span style="float:left" class="y_title"><?=$website_language['supplier_m_productm'.$lang]['ys']?>：</span><div class="bitian">*</div>
	        	<div style="width:800px;float:left;overflow:hidden;margin-left:6px">
		        <?php 
	        		$product_color_row = $db->get_all("product_color",'1');
	        		for ($i=0; $i < count($product_color_row); $i++) { 
	        			$color_id = $product_row['ColorId'];
        				$color_id_arr = explode(",",$color_id);
	        	?>
	        		<div style="min-width:100px;float:left;overflow:hidden"><a data='1' class="y_input2"><input class="input_r2" type="checkbox" value="<?=$product_color_row[$i]['CId']?>" name="Color[]" id="" <?=in_array($product_color_row[$i]['CId'],$color_id_arr) ? checked : '';?>><span class='input_s'><?=$product_color_row[$i]['Color'.$lang]?></span></a></div>
	        	<?php }?>
	        	</div>	        		
	       	</div>
			<div style="position:relative;overflow:hidden;height:170px;float:left;margin-top:20px;width:900px">
                    <span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['cpsh']?>：</span> 
                  	<span style="font-size:12px;color:#666">
                    	<?=$website_language['supplier_m_productm'.$lang]['shxx']?><br />
                    </span>
                    <span style="font-size:12px;color:#666;margin-left:20px;position:absolute;top:30px;left:120px">
                        <span style="display:inline-block;width:285px">1. <?=$website_language['supplier_m_productm'.$lang]['zl']?>?</span>
                       	<a class="y_input"><input class="input_r" type="radio" value="0" name="IsPatent" <?=$product_row['IsPatent'] ? '' : 'checked="checked"'; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['my']?></span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsPatent" <?=$product_row['IsPatent'] ? 'checked="checked"' : '';?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['you']?></span></a><br><br>

                        <span style="display:inline-block;width:285px">2. <?=$website_language['supplier_m_productm'.$lang]['zlzs']?>? </span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsPatentCertificate" <?=$product_row['IsPatentCertificate'] ? '' : 'checked="checked"'; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['my']?></span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsPatentCertificate" <?=$product_row['IsPatentCertificate'] ? 'checked="checked"' : ''; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['you']?></span></a><br><br>

                        <span style="display:inline-block;width:285px">3. <?=$website_language['supplier_m_productm'.$lang]['qqcp']?>？</span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsInfringement" <?=$product_row['IsInfringement'] ? '' : 'checked="checked"'; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['my']?></span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsInfringement" <?=$product_row['IsInfringement'] ? 'checked="checked"' : ''; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['you']?></span></a><br><br>

						<span style="display:inline-block;width:285px">4. <?=$website_language['supplier_m_productm'.$lang]['zcsc']?>？</span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsInProduction" <?=$product_row['IsInProduction'] ? '' : 'checked="checked"'; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['my']?></span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsInProduction" <?=$product_row['IsInProduction'] ? 'checked="checked"' : ''; ?>><span class='input_s'><?=$website_language['supplier_m_productm'.$lang]['you']?></span></a><br><br>
                     </span>
                    <div class="clear"></div>
       		</div>   
       		 <div class="clear"></div> 
       		<div class="y_form1 cc" style="color:#666;font-size:12px;line-height:31px">
				<span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['jg']?>（<?=$website_language['supplier_m_productm'.$lang]['dj']?>）：</span><div class="bitian">*</div><input class="y_title_txt2 usd ac" type="text" name="Price_1" value="<?=$product_row['Price_1']?>">USD
				<input class="y_title_txt2 rmb ac" type="text" name="Price_2" value="<?=$product_row['Price_2']?>">RMB
				<span class="y_title3"><?=$website_language['supplier_m_productm'.$lang]['zli']?>：</span><input class="y_title_txt2" type="text" name="Weight" value="<?=$product_row['Weight']?>">KG
			</div>  
	  		
	  		<div class="y_form1">
  				<span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['pfzk']?>：</span><span><a onClick="this.blur(); add_wholesale_price_item('wholesale_price_list');" class="red"><?=$website_language['supplier_m_productm'.$lang]['tj']?></a></span>
	  			<table class="table_p" border="0" cellspacing="0" cellpadding="0" id="wholesale_price_list" class="item_data_table">
	  			<?php for($i=0; $i<count($product_wholesale_price_row); $i++){?>
	                <tr>	               		
                		<td class="cc"><?=$website_language['supplier_m_productm'.$lang]['sl']?>：<div class="bitian">*</div><input type="text" class="form_input2 us1" name="Qty[]"  value="<?=$product_wholesale_price_row[$i]['Qty']?>">≤<input type="text" class="form_input2 us2" name="Qty2[]"  value="<?=$product_wholesale_price_row[$i]['Qty2']?>"><i style="margin-left:30px"></i><?=$website_language['supplier_m_productm'.$lang]['dj']?>：<input type="text" class="form_input2 usd" name="WholesalePrice[]" id="" value="<?=$product_wholesale_price_row[$i]['Price']?>">USD<input type="text" class="form_input2 rmb" name="WholesalePrice2[]" id="" value="<?=$product_wholesale_price_row[$i]['Price2']?>">￥<i style="margin-left:30px"></i><a onclick="document.getElementById(\'wholesale_price_list\').deleteRow(this.parentNode.parentNode.rowIndex);" class="del2">&nbsp;</a></td>
	                </tr>
	                <?php } //var_dump($product_wholesale_price_row);exit;?>
	            </table>
			</div>
			 <div class="y_form1">
	            <div class="y_form1"><span class="y_title"><?=$website_language['supplier_m_productm'.$lang]['cptp']?>：</span><span><?=$website_language['supplier_m_productm'.$lang]['zdsc']?>！</span></div>
	           
	    	<?php 
            $ad_path = array('one','two','three','four','five');
           	$ad_path_2 = array($website_language['ylfy'.$lang]['t1'],$website_language['ylfy'.$lang]['t2'],$website_language['ylfy'.$lang]['t3'],$website_language['ylfy'.$lang]['t4'],$website_language['ylfy'.$lang]['t5']);
            $ad_path_3 = array('oneone','twotwo','threethree','fourfour','fivefive');
            for($i=0; $i<get_cfg('product.pic_count'); $i++){
            	$strstr = strstr($product_row['PicPath_'.$i],"product/");
            	$substr = substr($strstr,17);
            	
        ?>
        <div class="y_form1">
            <div class="y_form" style="position:relative;"><input class="<?=$i+1?>" type="button" style="width:100px;height:31px;background:#0b8fff;border-radius:3px;border:none;position:absolute;left:105px;color:#fff" value="<?=$website_language['supplier_m_productm'.$lang]['sctp']?>"><span class="y_title"><?=$i+1?>:</span><input id="<?=$ad_path_3[$i]?>" type="text" style="width:240px;height:28px;background:#fff;border-radius:3px;border:1px solid #ccc;position:absolute;left:205px;color:#000" value="<?=$substr?>"><input id="<?=$ad_path[$i]?>" onchange="preImg(this.id,'photo<?=$ad_path[$i]?>','<?=$ad_path_3[$i]?>');" class="y_title_txt a<?=$i+1?>" value="上传图片" type="file" name="PicPath_<?=$i?>" ><input type='hidden' name='S_PicPath_<?=$i;?>' value='<?=$product_row['PicPath_'.$i];?>'></div>
        </div> 
        <?php }?>
       
        <div style="width:800px;float:left;margin-top:40px;margin-left:90px">
            <?php 
                
                for($i=0; $i<get_cfg('product.pic_count'); $i++){
                	if($product_row['PicPath_'.$i]){
                        $src = 'src='.$product_row['PicPath_'.$i];
                    }else{
                        $src = "";
                    }
            ?>
            <div style="width:100px;height:70px;float:left;padding:10px;color:#666;font-size:12px">
                    <a id="img_list_<?=$i;?>" href="<?=str_replace('s_', '', $product_row['PicPath_'.$i]);?>" target="_blank"><img id="photo<?=$ad_path[$i]?>" <?=$src;?> style="display: block;width:100%;height:100%;" /></a>
                <div style="height:20px;line-height:20px;margin-top:10px" >
                    <div style="float:left"><?=$ad_path_2[$i]?></div>
                    <a id="img_list_<?=$i;?>_a" style="float:left" class="yxx_del" href="mod.php?action=delimg&ProId=<?=$ProId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$product_row['PicPath_'.$i];?>&ImgId=img_list_<?=$i;?>" ><?=$website_language['supplier_m_productm'.$lang]['sc']?></a>

                </div>
            </div>
            <?php }?> 
            <div style="clear: both;"></div>
        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
            <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
                <div class="editor_title fl"><?=get_lang('ly200.description1').lang_name($i, 0);?>:</div>

                <div class="editor_con ck_editor fl">
                <textarea style="min-height: 400px;width: 780px;" name="Description<?=lang_name($i, 1);?>" id="<?='content_duo'.$i;?>" class="form-control"><?=htmlspecialchars($product_description_row['Description'.lang_name($i, 1)]);?></textarea> 
                </div>
                <div class="clear"></div>
            </div>
        <?php } ?>
	        <div class="y_submit">	
	        	<input type="hidden" name="ProId" value="<?=$ProId;?>">	  
	        	<input type="hidden" name="module" value="<?=$_GET['module'];?>">
	        	<input type="hidden" name="SupplierId" value="<?=$SupplierId;?>">	     
		        <input class="ys_input psa" type="submit" value="<?=$website_language['supplier_m_productm'.$lang]['bc']?>">
		    </div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</form>
<script>
	$(function(){
		var acdd="<?=$website_language['ylfy'.$lang]['xz']?>";
		
		$('#a1').change(function(){
			var val = $(this).val();
			$.get('/ajax/ajax_leimu.php',{'act':val,'mode':'1'},function(data){
 					$('#a2').html(data);
 				})
			$('#a3').html('<option value="0">'+acdd+'</option>');
		})		
		$('#a2').change(function(){
			var val2 = $(this).val();
			var val = $('#a1').val();

			$.get('/ajax/ajax_leimu.php',{'act':val,'mode':'2','act2':val2},function(data){
		
 					$('#a3').html(data);
 				})
		})		
	})
</script>
<script>
	$('.input_r2').each(function(){
		var ad=$(this).attr('checked');		
		if(ad){
			$(this).parent('.y_input2').attr('data','2');
			$(this).parent('.y_input2').addClass('hh');
		}
	})
	$('.ac').blur(function(){
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){		
					$('.ac').css('border','1px solid #ccc');			
					$(this).css('border','1px solid red');				
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{				
					$(this).css('border','1px solid #ccc');
					window.sessionStorage.setItem('none','3');						
				}
			})
		})
	window.sessionStorage.setItem('none','1');
		$('.psa').click(function(){			
			var noneget=window.sessionStorage.getItem('none');
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){					
					$(this).css('border','1px solid red');
					$(this).focus();
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{ 				
					$(this).css('border','1px solid #ccc');					
					window.sessionStorage.setItem('none','3');						
				}
			})			
			if(noneget=='1'){
				return false;
			}
		})
		$('.psa').hover(function(){
			$('.y_input2').each(function(){
			var da=$(this).attr('data');
			if(da==1){				
				window.sessionStorage.setItem('dc','1');				
				return false;
			}else{				
				window.sessionStorage.setItem('dc','2');
			}
		});
			var noneget=window.sessionStorage.getItem('none');
			$('.ac').each(function(){
				var ac=$(this).val();	
				if(ac==''){							
					window.sessionStorage.setItem('none','1');	
					return false;							
				}else{				
					$(this).css('border','1px solid #ccc');					
					window.sessionStorage.setItem('none','3');						
				}
			})	
			if(noneget=='1'){
				return false;
			}
		})
	var color_t="<?=$website_language['ylfy'.$lang]['zsxz1ys']?>";
	$('.ys_input').click(function(){
		var a=$('.y_input2').hasClass('hh');
		if(!a){
			alert(color_t);
			return false;
		}
		var da1=$('#a1').val();
		if(da1=='0'){
			$('#a1').focus();
			return false;
		}
	})
	function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
	 function preImg(sourceId,id){   
                var url = getFileUrl(sourceId);                   
                document.getElementById(id).value=document.getElementById(sourceId).value; 
              
            }  
	$('.222').click(function(){
		$('#bb1').click();
	})
	$('.333').click(function(){
		$('#cc1').click();
	})
	$('.red').hover(function(){
		$(this).css('color','#fff');
	})
	function usd(){
		var RMB=window.localStorage.getItem('RMB');
		$('.usd').keyup(function(){	
			var a=$(this).val();			
			$(this).next('.rmb').val((a*RMB).toFixed(2));
		})
		$('.rmb').keyup(function(){	
			var a=$(this).val();
			$(this).prev('.usd').val((a/RMB).toFixed(2));
		})
	}
	usd();
	function us1(){		
		var ust=parseInt($('.ust').val());
		$('.us1').each(function(){
			$(this).blur(function(){	
			var ac=parseInt($(this).val());		
			if(ac<ust){		
				console.log(ac+','+ust);
				$(this).val(ust);
			}
		})
	})		
	}
	us1();
	function add_wholesale_price_item(obj){
	newcell=document.getElementById(obj).insertRow();
	cell= newcell.insertCell();
	cell.classList.add("cc");
	cell.innerHTML='<?=$website_language["supplier_m_productm".$lang]["sl"]?>：<input type="text" class="form_input2 us1" name="Qty[]" id="">≤<input type="text" class="form_input2 us2" name="Qty2[]" id=""><i style="margin-left:30px"></i><?=$website_language["supplier_m_productm".$lang]["dj"]?>：<input type="text" class="form_input2 usd" name="WholesalePrice[]" id="">USD<input type="text" class="form_input2 rmb" name="WholesalePrice2[]" id="">RMB<i style="margin-left:30px"></i><a onclick="document.getElementById(\'wholesale_price_list\').deleteRow(this.parentNode.parentNode.rowIndex);" class="del2">&nbsp;</a>';
	usd();
	us1();
	}	
	
	$('.input_r').click(function(){
			$('.y_input').css('color','#666');
			$(this).parent('.y_input').css('color','#006ac3');
		})
	$('.input_r2').click(function(){		
    		var a=$(this).parent('.y_input2').attr('data');    
    		if(a==1){
    			$(this).parent('.y_input2').css('color','#006ac3');
    			$(this).parent('.y_input2').attr('data',2);       			
    			$(this).parent('.y_input2').addClass('hh');
    		}else if(a==2){
    			$(this).parent('.y_input2').css('color','#666');
    			$(this).parent('.y_input2').attr('data',1);  
    			$(this).parent('.y_input2').removeClass('hh');  		
    		}			
		})

</script>
<script>
    function getFileUrl(sourceId) {  
                var url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));    
                return url;  
            }  
    function preImg(sourceId, targetId,id) {   
        var url = getFileUrl(sourceId);   
        var imgPre = document.getElementById(targetId);  
        document.getElementById(id).value=document.getElementById(sourceId).value; 
        imgPre.src = url;   
    }   
    $(function(){
        $(".y_form1").find('.1').click(function(){
          
        })
        $(".y_form1").find('.2').click(function(){
           
        })
        $(".y_form1").find('.3').click(function(){
           
        })
        $(".y_form1").find('.4').click(function(){
           
        })
        $(".y_form1").find('.5').click(function(){
          
        })
    })
    
</script>