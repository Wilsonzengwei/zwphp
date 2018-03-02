<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_upload';
check_permit('product_upload');

if($_POST || $_GET){
	$save_dir=get_cfg('ly200.up_file_base_dir').'excle/'.date('y_m_d/', $service_time);
	
	if($_GET){
		$start=$_GET['Start'];
		$count = $start+20;
		$auto = (int)$_GET['Auto']; //自动继续采集
		$FilePath=$_GET['FilePath'];
		$SheetName=(int)$_GET['SheetName'];
		$pro_count=(int)$_GET['pro_count'];
		$count>$pro_count && $count=$pro_count;
	}else{
		$start=2;
		$count = 22;
		$auto = 1; //自动继续采集
		
		$FilePath=up_file($_FILES['excle'],$save_dir);
		$SheetName=(int)$_POST['SheetName'];
	}
	
	$category=array();
	$cate_row=$db->get_all('product_category','SubCate=0','*','CateId asc');
	for($j=0; $j<count($cate_row); $j++){
		$category[md5($cate_row[$j]['Category'])]=$cate_row[$j]['CateId'];
	}
	
	include('../../inc/read_excel.php');
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('utf-8');
	$data->read($site_root_path.$FilePath);
	
	if($data->sheets[$SheetName]['numCols']!='22')
	{
		js_location('upload.php','表格的列数不匹配，请检查！');
		exit;
	}

	include('../../inc/fun/img_resize.php');
	include('../../inc/fun/img_add_watermark.php');
	$pro_count=$data->sheets[$SheetName]['numRows']; //numRows行数
	$pro_count<$count && $count=$pro_count;
	
	for($i=$start; $i<=$count; $i++){	//numCols列数，数组下标都是从1开始
		$BigPicPath=$SmallPicPath=$tmp_path='';
		unset($BigPicPath,$SmallPicPath,$tmp_path);

		$Name=addslashes(trim($data->sheets[$SheetName]['cells'][$i][1]));	//产品名称
		$CateId=$category[md5(trim($data->sheets[$SheetName]['cells'][$i][2]))];	//产品分类
		$ItemNumber=addslashes(trim($data->sheets[$SheetName]['cells'][$i][3]));	//产品编号
		$PicPath_0=$data->sheets[$SheetName]['cells'][$i][4];	//图片一
		$PicPath_1=$data->sheets[$SheetName]['cells'][$i][5];	//图片二
		$PicPath_2=$data->sheets[$SheetName]['cells'][$i][6];	//图片三
		$PicPath_3=$data->sheets[$SheetName]['cells'][$i][7];	//图片四
		$PicPath_4=$data->sheets[$SheetName]['cells'][$i][8];	//图片五
		$Stock=addslashes(trim($data->sheets[$SheetName]['cells'][$i][9]));	//库存
		$Weight=addslashes(trim($data->sheets[$SheetName]['cells'][$i][10]));	//产品重量
		$Price_0=(int)$data->sheets[$SheetName]['cells'][$i][11];	//市场价
		$Price_1=(int)$data->sheets[$SheetName]['cells'][$i][12];	//会员价
		$WholesalePrice=addslashes($data->sheets[$SheetName]['cells'][$i][13]);	//批发价
		$BriefDescription=addslashes($data->sheets[$SheetName]['cells'][$i][14]);	//简单介绍
		$SeoTitle=addslashes($data->sheets[$SheetName]['cells'][$i][15]);
		$SeoKeywords=addslashes($data->sheets[$SheetName]['cells'][$i][16]);
		$SeoDescription=addslashes($data->sheets[$SheetName]['cells'][$i][17]);
		$IsHot=(int)$data->sheets[$SheetName]['cells'][$i][18];		//Hot Sale
		$IsRecommend=(int)$data->sheets[$SheetName]['cells'][$i][19];	//Recommended
		$IsNew=(int)$data->sheets[$SheetName]['cells'][$i][20];		//New Arrivals
		//$IsBestDeals=(int)$data->sheets[$SheetName]['cells'][$i][21];	//Best Deals
		$SoldOut=(int)$data->sheets[$SheetName]['cells'][$i][21];	//下架
		$Description=addslashes($data->sheets[$SheetName]['cells'][$i][22]);	//详细介绍
		
		$DPicrow=array();
		$DPicrow[0]='/u_file/madeimg/'.$PicPath_0;
		$DPicrow[1]='/u_file/madeimg/'.$PicPath_1;
		$DPicrow[2]='/u_file/madeimg/'.$PicPath_2;
		$DPicrow[3]='/u_file/madeimg/'.$PicPath_3;
		$DPicrow[4]='/u_file/madeimg/'.$PicPath_4;
		
		$save_pro_dir=get_cfg('ly200.up_file_base_dir').'product/'.date('y_m_d/', $service_time);
				
		for($k=0; $k<5; $k++){
			if(is_file($site_root_path.$DPicrow[$k])){	//已正确上传大图到空间上
				mk_dir( $save_pro_dir );   //建立目录，返回保存文件的物理路径
				$SaveName = date( 'YmdHis' ) . rand( 10000, 99999 ) . '.jpg';
				$copy = @copy( $site_root_path.$DPicrow[$k], $site_root_path.$save_pro_dir.$SaveName );	//复制大图到目标文件夹
				$tmp_path=$save_pro_dir.$SaveName;
				$BigPicPath[$k]=$SmallPicPath[$k]=$tmp_path;
				foreach(get_cfg('product.pic_size') as $key=>$value){
					$w_h=@explode('X', $value);
					$filename="$key"=='default'?'':dirname($tmp_path).'/'.$value.'_'.basename($tmp_path);
					$path=img_resize($SmallPicPath[$k], $filename, (int)$w_h[0], (int)$w_h[1]);
					"$key"=='default' && $SmallPicPath[$k]=$path;
				}
			}
		}
		
		if($CateId){
			$pro_one=$db->get_one('product',"CateId='$CateId' and Name='$Name' and ItemNumber='$ItemNumber'");
			if($pro_one){
				$ProId=$pro_one['ProId'];
				$db->update('product', "ProId='$ProId'", array(
					'CateId'			=>	$CateId,
					'Name'				=>	$Name,
					'ItemNumber'		=>	$ItemNumber,
					'IsHot'				=>	$IsHot,
					'IsRecommend'		=>	$IsRecommend,
					'IsNew'				=>	$IsNew,
					//'IsBestDeals'		=>	$IsBestDeals,
					'SoldOut'			=>	$SoldOut,
					'Stock'				=>	$Stock,
					'Weight'			=>	$Weight,
					'PicPath_0'			=>	$SmallPicPath[0],
					'PicPath_1'			=>	$SmallPicPath[1],
					'PicPath_2'			=>	$SmallPicPath[2],
					'PicPath_3'			=>	$SmallPicPath[3],
					'PicPath_4'			=>	$SmallPicPath[4],
					'Price_0'			=>	$Price_0,
					'Price_1'			=>	$Price_1,
					'BriefDescription'	=>	$BriefDescription,
					'SeoTitle'			=>	$SeoTitle,
					'SeoKeywords'		=>	$SeoKeywords,
					'SeoDescription'	=>	$SeoDescription,
					'AccTime'			=>	$service_time
					)
				);
				
				$db->update('product_description',"ProId='$ProId'",array(
						'Description'	=>	$Description
					)
				);
				if($WholesalePrice!=''){
					$wholesale_arr=explode(';',$WholesalePrice);
					$wholesale_count=count($wholesale_arr);
					for($f=0; $f<$wholesale_count; $f++){
						$row=explode(':',$wholesale_arr[$f]);
						$qty=(int)$row[0];
						$price=(float)$row[1];
						if($qty && $price){
							$db->update('product_wholesale_price',"ProId='$ProId'", array(
									'Qty'	=>	$qty,
									'Price'	=>	$price
								)
							);
						}
					}
				}
				
				echo "$Name 更新成功！<br/>";
			}else{
				$db->insert('product', array(
					'CateId'			=>	$CateId,
					'Name'				=>	$Name,
					'ItemNumber'		=>	$ItemNumber,
					'IsHot'				=>	$IsHot,
					'IsRecommend'		=>	$IsRecommend,
					'IsNew'				=>	$IsNew,
					//'IsBestDeals'		=>	$IsBestDeals,
					'SoldOut'			=>	$SoldOut,
					'Stock'				=>	$Stock,
					'Weight'			=>	$Weight,
					'PicPath_0'			=>	$SmallPicPath[0],
					'PicPath_1'			=>	$SmallPicPath[1],
					'PicPath_2'			=>	$SmallPicPath[2],
					'PicPath_3'			=>	$SmallPicPath[3],
					'PicPath_4'			=>	$SmallPicPath[4],
					'Price_0'			=>	$Price_0,
					'Price_1'			=>	$Price_1,
					'BriefDescription'	=>	$BriefDescription,
					'SeoTitle'			=>	$SeoTitle,
					'SeoKeywords'		=>	$SeoKeywords,
					'SeoDescription'	=>	$SeoDescription,
					'AccTime'			=>	$service_time
					)
				);
				$ProId=$db->get_insert_id();
				
				$db->insert('product_description', array(
						'ProId'			=>	$ProId,
						'Description'	=>	$Description
					)
				);
				
				if($WholesalePrice!=''){
					$wholesale_arr=explode(';',$WholesalePrice);
					$wholesale_count=count($wholesale_arr);
					for($f=0; $f<$wholesale_count; $f++){
						$row=explode(':',$wholesale_arr[$f]);
						$qty=(int)$row[0];
						$price=(float)$row[1];
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
				
				echo "$Name 上传成功！<br/>";
			}
		}else{
			echo "$Name 此产品的产品分类不正确，请检查！<br/>";
		}
		
		set_page_url('product', "ProId='$ProId'", get_cfg('product.page_url'), 1);
	}
	
	if($auto==1 && $i<=$pro_count){
		echo "<meta http-equiv='refresh' content='1; URL=upload.php?Start=$i&Auto=$auto&FilePath=$FilePath&SheetName=$SheetName&pro_count=$pro_count'><br>";
		echo sprintf(get_lang('upload.step_info'), $pro_count, $i-3, "upload.php?Start=$i&Auto=$auto&FilePath=$FilePath&SheetName=$SheetName&pro_count=$pro_count");
		echo "<br><a href='upload.php'>返回</a><br><br>";
		exit;
	}elseif($auto==1 && $i>$pro_count){
		echo "处理完成！";
		echo "<br><a href='upload.php'>返回</a><br><br>";
	}
	
	save_manage_log('批量添加产品');
	echo "<script language='javascript'>alert('批量上传成功！');</script>";
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('product_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="upload.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
        <tr> 
            <td width="7%" nowrap>EXCEL文件：</td>
            <td width="93%"><input name="excle" type="file" class="form_input" size="35"></td>
        </tr>
        <tr>
          <td nowrap>工作簿序号：</td>
          <td><input type="text" name="SheetName" class="form_input" maxlength="2" size="5">（从0算起）</td>
        </tr>
        <tr> 
            <td width="7%" nowrap>上传表格样式：</td>
            <td width="93%"><a href="model.xls" target="_top" title="下载" class="download" style="margin-left:15px;"></a></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value=" 上传产品 " name="submit" class="form_button"><?php /*?><a href='upload.php' class="return"><?=get_lang('ly200.return');?></a><?php */?></td>
        </tr>
    </table>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>