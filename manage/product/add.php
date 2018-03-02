<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product';
check_permit('product', 'product.add');

/*$strtotime = strtotime("2017-08-14 00:00:00");
$strtotim2 = strtotime("2017-08-15 00:00:00");
$TotalPrice_row = $db->get_all('product',"AccTime>'$strtotime' and AccTime<'$strtotim2'",'ProId');
var_dump($TotalPrice_row);exit;*/
if($_POST){
	$save_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
	$Name=$_POST['Name'];
	$Name_lang_1=$_POST['Name_lang_1'];
	$Name_en=$_POST['Name_en'];
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
	$color_arr = $_POST['Color'];
	$ColorId = implode(",",$color_arr);
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
	$DefaultReviewTotalRating =$_POST['DefaultReviewTotalRating '];
	$DefaultLove=$_POST['DefaultLove'];
	$PreEXT=$$_POST['PreEXT'];
	
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
		include('../../inc/fun/img_resize.php');
		for($i=0; $i<get_cfg('product.pic_count'); $i++){
			$filesize[$i] = $_FILES['PicPath_'.$i];
			if($filesize[$i]['size'] > 3100000){
				echo '<script>alert("'.$filesize[$i]['name'].'图片大于3M,请重新上传该图片!")</script>';
				header("refresh:0;url=add.php");
				exit;
			}
			$PicAlt[]=$_POST['Alt_'.$i];
			if($tmp_path=up_file($_FILES['PicPath_'.$i], $save_dir)){
				$BigPicPath[$i]=$SmallPicPath[$i]=$tmp_path;
				foreach(get_cfg('product.pic_size') as $key=>$value){
					$w_h=@explode('X', $value);
					$filename="$key"=='default'?'':dirname($tmp_path).'/'.$value.'_'.basename($tmp_path);
					$path=img_resize($SmallPicPath[$i], $filename, (int)$w_h[0], (int)$w_h[1]);
					"$key"=='default' && $SmallPicPath[$i]=$path;
				}
			}
		}
		if(get_cfg('ly200.img_add_watermark')){
			include('../../inc/fun/img_add_watermark.php');
			foreach($BigPicPath as $value){
				img_add_watermark($value);
			}
		}
	}
	
	$db->insert('product', array(
			'CateId'			=>	$CateId,
			'Name'				=>	$Name,
			'Name_lang_1'		=>	$Name_lang_1,
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
			'Name_en'			=>	$Name_en,
			'Del'				=>	'1',
		)
	);
	
	$ProId=$db->get_insert_id();
	get_cfg('product.description') && $Description=save_remote_img($_POST['Description'], $save_dir);
	get_cfg('product.description') && $Description2=save_remote_img($_POST['Description2'], $save_dir);
	$db->insert('product_description', array(
			'ProId'			=>	$ProId,
			'Description'	=>	$Description,
			'Description2'	=>	$Description2
		)
	);
	
	//保存批发价
	if(get_cfg('product.price') && get_cfg('product.wholesale_price')){
		for($i=0; $i<count($_POST['Qty']); $i++){
			$qty=(int)$_POST['Qty'][$i];
			$price=(float)$_POST['WholesalePrice'][$i];
			$qty2=(int)$_POST['Qty2'][$i];
			$price2=(float)$_POST['WholesalePrice2'][$i];
			if($qty && $price){
				$db->insert('product_wholesale_price', array(
						'ProId'	=>	$ProId,
						'Qty'	=>	$qty,
						'Price'	=>	$price,
						'Qty2'	=>	$qty2,
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
				$data[$field_cfg]=up_file($_FILES[$field_cfg], $save_dir);
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
	$db->insert('product_ext', $data);
	set_page_url('product', "ProId='$ProId'", get_cfg('product.page_url'), 1);
	
	$db->update('manage_operation_log', 'Operation="product_add"', array(
			'Value'	=>	$CateId
		)
	);
	
	save_manage_log('添加产品:'.$Name);
	
	header('Location: index.php');
	exit;
}

include('../../inc/manage/header.php');
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
<form style="background:#fff;min-height:600px;width:95%" action="" method="post" class="act_form" enctype="multipart/form-data">

    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">添加产品</div>
		<div class="y_form1"><span class="y_title">产品名称(中文):</span><input class="y_title_txt" type="text" name="Name_lang_1"></div>
		<div class="y_form1"><span class="y_title">产品名称(西文):</span><input class="y_title_txt" type="text" name="Name"></div>
		<div class="y_form1"><span class="y_title">产品名称(英文):</span><input class="y_title_txt" type="text" name="Name_en"></div>
		<div class="y_form1">	
	        <span class="y_title">产品类别:</span>                            
	             <?=str_replace('<select','<select class="form_select" onchange="Param.changecate()"',ouput_Category_to_Select('CateId', $product_row['CateId'], 'product_category', 'UId="0,"', 1, get_lang('ly200.select')));?>
        </div>

   
    	<div style="position:relative;overflow:hidden;height:170px" class="y_form1">
                    <span class="y_title">产品审核:</span> 
                  	<span style="font-size:12px;color:#666">
                    	请正确选择审核选项 审核不通过的产品将不能上线<br />
                    </span>

                    <span style="font-size:12px;color:#666;margin-left:20px;position:absolute;top:30px;left:80px">
                        <span style="display:inline-block;width:200px">1. 该产品是否有专利?</span>
                       	<a class="y_input"><input class="input_r" type="radio" value="0" name="IsPatent" checked><span class='input_s'>没有</span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsPatent" id=""><span class='input_s'>有</span></a><br>

                        <span style="display:inline-block;width:200px">2. 该产品有没有专利证书? </span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsPatentCertificate" checked><span class='input_s'>没有</span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsPatentCertificate" id=""><span class='input_s'>有</span></a><br>

                        <span style="display:inline-block;width:200px">3. 该产品是否属于侵权产品？</span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsInfringement" checked><span class='input_s'>不是</span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsInfringement" id=""><span class='input_s'>是</span></a><br>

						<span style="display:inline-block;width:200px">3. 该产品是否可以正常生产？</span>
                        <a class="y_input"><input class="input_r" type="radio" value="0" name="IsInProduction" checked><span class='input_s'>不是</span></a>
						<a class="y_input"><input class="input_r" type="radio" value="1" name="IsInProduction" id=""><span class='input_s'>是</span></a><br>
                     </span>
                    <div class="clear"></div>
        </div>
        <div class="y_form"><span class="y_title">起订量：</span><input class="y_title_txt" type="text" name="StartFrom"></div>
        <div class="y_form"><span class="y_title">库存：</span><input class="y_title_txt" type="text" name="Stock"></div>  
        <div class="y_form1">
        	<span style="float:left" class="y_title">颜色：</span>
        	<div style="width:800px;float:left;overflow:hidden">
        	<?php 
        		$product_color_row = $db->get_all("product_color",'1');
        		for ($i=0; $i < count($product_color_row); $i++) { 
        	?>
        		<div style="min-width:100px;float:left;overflow:hidden"><a data='1' class="y_input2"><input class="input_r2" type="checkbox" value="<?=$product_color_row[$i]['CId']?>" name="Color" id=""><span class='input_s'><?=$product_color_row[$i]['Color_lang_1']?></span></a></div>
        	<?php }?>
        	</div>	        		
        </div>  
  		<div class="y_form1">
  			<span class="y_title">价格（单价）：</span><input class="y_title_txt" type="text" name="Price_1">美元（USD）
  			<input class="y_title_txt" type="text" name="Price_2">人民币（￥）
  		</div>
  		<div class="y_form1">
  			<span style="text-align:center;width:50px;margin-left:40px" class="y_title">批发数量区间价格</span>：
  			<table border="0" cellspacing="0" cellpadding="0" id="wholesale_price_list" class="item_data_table">
                
                <?php for($i=0; $i<count(get_cfg('gift.wholesale_price_n')); $i++){?>
                    <tr>
                    <td><?=get_lang('ly200.qty');?>:<input name="Qty[]" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="" class="form_input2" type="text" size="8" maxlength="10">≤<input name="Qty2[]" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="" class="form_input2" type="text" size="8" maxlength="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：<input name="WholesalePrice[]" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="" class="form_input2" type="text" size="8" maxlength="10">美元（USD）<input name="WholesalePrice2[]" value="" class="form_input2" type="text" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);">人民币（￥）<a href="javascript:void(0);"  onClick="this.blur(); add_wholesale_price_item('wholesale_price_list');" class="red">添加</a></td>
                    </tr>
                <?php }?>
            </table>
  		</div>
  		<div class="y_form1"><span class="y_title">产品图片:</span></div>
        <?php 
            $ad_path = array('one','two','three','four','five');
            $ad_path_2 = array('图一','图二','图三','图四','图五');
            $ad_path_3 = array('oneone','twotwo','threethree','fourfour','fivefive');
            for($i=0; $i<get_cfg('product.pic_count'); $i++){
        ?>
        <div class="y_form1">
            <div class="y_form" style="position:relative;"><input class="<?=$i+1?>" type="button" style="width:75px;height:31px;background:#0b8fff;border-radius:3px;border:none;position:absolute;left:105px;color:#fff" value="上传图片"><span class="y_title"><?=$i+1?>:</span><input id="<?=$ad_path_3[$i]?>" type="text" style="width:240px;height:33px;background:#fff;border-radius:3px;border:1px solid #ccc;position:absolute;left:180px;color:#000" value=""><input id="<?=$ad_path[$i]?>" onchange="preImg(this.id,'photo<?=$ad_path[$i]?>','<?=$ad_path_3[$i]?>');" class="y_title_txt a<?=$i+1?>" value="上传图片" type="file" name="PicPath_<?=$i?>" ></div>
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
                    <div style="float:left;width:100px;text-align: center;"><?=$ad_path_2[$i]?></div>
                    <!-- <a id="img_list_<?=$i;?>_a" style="float:left" class="yxx_del" href="add.php?action=delimg&AId=<?=$AId;?>&Field=PicPath_<?=$i;?>&PicPath=<?=$ad_row['PicPath_'.$i];?>">删除</a> -->

                </div>
            </div>
            <?php }?>    
        </div> 
		<div style="clear: both;"></div>
        <?php for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){?>
            <div class="editor_row" style="margin-top: 80px;color:#666;font-size:12px;    font-weight: bold;">
                <div class="editor_title fl"><?=get_lang('ly200.description').lang_name($i, 0);?>:</div>

                <div class="editor_con ck_editor fl">
                <textarea style="min-height: 400px;width: 780px;" name="Description<?=lang_name($i, 1);?>" id="<?='content_duo'.$i;?>" class="form-control"></textarea> 
                </div>
                <div class="clear"></div>
            </div>
        <?php } ?>
        <div class="y_submit">
        	<input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="ys_input">
			<input type="hidden" name="AId" value="<?=$AId;?>"><input type="hidden" name="AdType" value="<?=$ad_row['AdType'];?>" />
            <input type="hidden" name="PicCount" value="<?=$ad_row['PicCount'];?>" />
        </div>
        <div style='clear:both'></div>   
</form>
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
<?php include('../../inc/manage/footer.php');?>