<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('gift', 'gift.add');

$ProId=(int)$_GET['ProId'];

$gift_row=$db->get_one('gift', "ProId='$ProId'");
$gift_ext_row=$db->get_one('gift_ext', "ProId='$ProId'");
$gift_description_row=$db->get_one('gift_description', "ProId='$ProId'");
$gift_wholesale_price_row=$db->get_all('gift_wholesale_price', "ProId='$ProId'", '*', 'Price desc, PId desc');

$save_dir=mk_dir(get_cfg('ly200.up_file_base_dir').'gift/'.date('y_m_d/', $service_time));
$SmallPicPath=array();
if(get_cfg('gift.pic_count')){
	for($i=0; $i<get_cfg('gift.pic_count'); $i++){
		if(is_file($site_root_path.$gift_row['PicPath_'.$i])){
			$dir=dirname($gift_row['PicPath_'.$i]).'/';
			$file=str_replace('s_', '', basename($gift_row['PicPath_'.$i]));
			$new_name=rand_code().'.'.get_ext_name($file);
			foreach(get_cfg('gift.pic_size') as $key=>$value){
				@copy($site_root_path.$dir.$value.'_'.$file, $site_root_path.$save_dir.$value.'_'.$new_name);
			}
			@copy($site_root_path.$dir.$file, $site_root_path.$save_dir.$new_name);
			@copy($site_root_path.$gift_row['PicPath_'.$i], $site_root_path.$save_dir.'s_'.$new_name);
			$SmallPicPath[]=$save_dir.'s_'.$new_name;
		}
	}
}

$db->insert('gift', array(
		'CateId'			=>	(int)$gift_row['CateId'],
		'Name'				=>	addslashes($gift_row['Name']),
		'ItemNumber'		=>	addslashes($gift_row['ItemNumber']),
		'Model'				=>	addslashes($gift_row['Model']),
		'IsInIndex'			=>	(int)$gift_row['IsInIndex'],
		'IsHot'				=>	(int)$gift_row['IsHot'],
		'IsRecommend'		=>	(int)$gift_row['IsRecommend'],
		'IsNew'				=>	(int)$gift_row['IsNew'],
		//'IsBestDeals'		=>	(int)$gift_row['IsBestDeals'],
		'SoldOut'			=>	(int)$gift_row['SoldOut'],
		'ColorId'			=>	addslashes($gift_row['ColorId']),
		'SizeId'			=>	addslashes($gift_row['SizeId']),
		'BrandId'			=>	(int)$gift_row['BrandId'],
		'Stock'				=>	(int)$gift_row['Stock'],
		'Weight'			=>	(float)$gift_row['Weight'],
		'PicPath_0'			=>	$SmallPicPath[0],
		'PicPath_1'			=>	$SmallPicPath[1],
		'PicPath_2'			=>	$SmallPicPath[2],
		'PicPath_3'			=>	$SmallPicPath[3],
		'PicPath_4'			=>	$SmallPicPath[4],
		'PicPath_5'			=>	$SmallPicPath[5],
		'PicPath_6'			=>	$SmallPicPath[6],
		'PicPath_7'			=>	$SmallPicPath[7],
		'Alt_0'				=>	addslashes($gift_row['Alt_0']),
		'Alt_1'				=>	addslashes($gift_row['Alt_1']),
		'Alt_2'				=>	addslashes($gift_row['Alt_2']),
		'Alt_3'				=>	addslashes($gift_row['Alt_3']),
		'Alt_4'				=>	addslashes($gift_row['Alt_4']),
		'Alt_5'				=>	addslashes($gift_row['Alt_5']),
		'Alt_6'				=>	addslashes($gift_row['Alt_6']),
		'Alt_7'				=>	addslashes($gift_row['Alt_7']),
		'Price_0'			=>	(float)$gift_row['Price_0'],
		'Price_1'			=>	(float)$gift_row['Price_1'],
		'Price_2'			=>	(float)$gift_row['Price_2'],
		'Price_3'			=>	(float)$gift_row['Price_3'],
		'Integral'	        =>	(int)$gift_row['Integral'],
		'IsSpecialOffer'	=>	(int)$gift_row['IsSpecialOffer'],
		'SpecialOfferPrice'	=>	(float)$gift_row['SpecialOfferPrice'],
		'BriefDescription'	=>	addslashes($gift_row['BriefDescription']),
		'SeoTitle'			=>	addslashes($gift_row['SeoTitle']),
		'SeoKeywords'		=>	addslashes($gift_row['SeoKeywords']),
		'SeoDescription'	=>	addslashes($gift_row['SeoDescription']),
		'LimitControl'		=>	(int)$gift_row['LimitControl'],
		'Deadline'			=>	(int)$gift_row['Deadline'],
		'Discount'			=>	(float)$gift_row['Discount'],
		'AccTime'			=>	(int)$gift_row['AccTime']
	)
);

$ProId=$db->get_insert_id();
$db->insert('gift_description', array(
		'ProId'			=>	$ProId,
		'Description'	=>	addslashes($gift_description_row['Description'])
	)
);

//保存批发价
if(get_cfg('gift.price') && get_cfg('gift.wholesale_price')){
	for($i=0; $i<count($gift_wholesale_price_row); $i++){
		$qty=(int)$gift_wholesale_price_row[$i]['Qty'];
		$price=(float)$gift_wholesale_price_row[$i]['Price'];
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
		$NameExt=$gift_row['Name'.$field_ext];
		$BriefDescriptionExt=$gift_row['BriefDescription'.$field_ext];
		$SeoTitleExt=$gift_row['SeoTitle'.$field_ext];
		$SeoKeywordsExt=$gift_row['SeoKeywords'.$field_ext];
		$SeoDescriptionExt=$gift_row['SeoDescription'.$field_ext];
		$db->update('gift', "ProId='$ProId'", array(
				'Name'.$field_ext				=>	addslashes($NameExt),
				'BriefDescription'.$field_ext	=>	addslashes($BriefDescriptionExt),
				'SeoTitle'.$field_ext			=>	addslashes($SeoTitleExt),
				'SeoKeywords'.$field_ext		=>	addslashes($SeoKeywordsExt),
				'SeoDescription'.$field_ext		=>	addslashes($SeoDescriptionExt)
			)
		);
		
		if(get_cfg('gift.description')){
			$DescriptionExt=$gift_description_row['Description'.$field_ext];
			$db->update('gift_description', "ProId='$ProId'", array(
					'Description'.$field_ext	=>	addslashes($DescriptionExt)
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
					$data[$field_name.lang_name($i, 1)]=addslashes($gift_ext_row[$field_name.lang_name($i, 1)]);
					$field[]=$field_name.lang_name($i, 1);
					$field_type[]=$form_type;
				}
			}else{	//不区分语言输入
				$data[$field_name]=addslashes($gift_ext_row[$field_name]);
				$field[]=$field_name;
				$field_type[]=$form_type;
			}
		}elseif(in_array($form_type, array('input_radio', 'input_checkbox', 'select'))){
			$data[$field_name]=addslashes($gift_ext_row[$field_name]);
			$field[]=$field_name;
			$field_type[]=$form_type;
		}elseif($form_type=='input_file'){
			$data[$field_cfg]=addslashes($gift_ext_row[$field_cfg]);
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
$db->insert('gift_ext', $data);

set_page_url('gift', "ProId='$ProId'", get_cfg('gift.page_url'), 1);

save_manage_log('复制礼品:'.addslashes($gift_row['Name']));

js_location("mod.php?ProId=$ProId", get_lang('gift.copy_success'));
exit;
?>