<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='transport';
check_permit('transport', 'transport.add');
$TId = $_GET['TId'];
if($_POST['act'] == 'basic_info'){
	$time = time();
	$orders_t = $_POST['orders_t'];
	$f_name = $_POST['f_name'];
	$f_mobile = $_POST['f_mobile'];
	$f_address = $_POST['f_address'];
	$s_name = $_POST['s_name'];
	$s_mobile = $_POST['s_mobile'];
	$s_address = $_POST['s_address'];
	$log_com = $_POST['log_com'];
	$myqty = $_POST['myqty'];
	$Weight = $_POST['weight'];
	$product_name = $_POST['product_name'];
	$shipping_prc = $_POST['shipping_prc'];
	$TId = $_POST['TId'];//var_dump($TId);exit;
	$db->update('transport',"TId=$TId",array(
		'TOId'				=> $orders_t,
		'Qty'  				=> $myqty,
		'TotalPrice'		=> $shipping_prc,
		'ShippingTime' 		=> $time,
		'ProductName' 		=> $product_name,
		'FNAME'				=> $f_name,
		'FMoble' 			=> $f_mobile,
		'Fdeliveryaddress'  => $f_address,
		'SNAME'				=> $s_name,
		'SMoble' 			=> $s_mobile,
		'Sdeliveryaddress'  => $s_address,
		'Weight' 			=> $Weight,
		'Company' 			=> $log_com,
		));


}
if($_POST['add_logistics'] == 'add_logistics'){
	$logistics_time = $_POST['logistics_time'];
	$transport_tracking = $_POST['transport_tracking'];
	$TId = $_POST['TId'];
	$log_com =  $_POST['log_com'];
	$db->insert('logistics',array(
			'TId' 			=> $TId,
			'LogisticsTime' => $logistics_time,
			'LogisticsInfo'	=> $transport_tracking
		));
	$db->update('transport',"TId='$TId'",array(
			'Company' 		=> $log_com
			
		));
}
if($_POST['logistics_update'] == 'logistics_update'){
	$StutasTime = $_POST['StutasTime'];
	$shipping_status = $_POST['shipping_status'];
	$TId = $_POST['TId'];
	$db->update('logistics',"TId=$TId and LogisticsTime='$StutasTime'",array(
		'LogisticsInfo'	=> $shipping_status
		));

}
$transport_row = $db->get_one('transport',"TId='$TId'");
$logistics_row = $db->get_all('logistics',"TId='$TId'");
$logistics_cou = count($logistics_row);
$logistics_cou_ros = $logistics_row[$logistics_cou-1];
include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:200px;width:95%;line-height:40px;overflow:hidden;margin-top:20px" action="" method="post" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
  	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">托运中心添加</div> 
    <div style="background:#fff;height:200px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">产品信息</div>    
		<div class="y_form"><span class="y_title">提单号：</span><input class="y_title_txt" type="text" name="orders_t" value="<?=$transport_row['TOId']?>"></div>
		<div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="product_name" value="<?=$transport_row['ProductName']?>"></div>
		<div class="y_form"><span class="y_title">数量：</span><input placeholder="件" class="y_title_txt" type="text" name="myqty" value="<?=$transport_row['Qty']?>"></div>
		<div class="y_form"><span class="y_title">重量：</span><input placeholder="kg" class="y_title_txt" type="text" name="weight" value="<?=$transport_row['Weight']?>"></div>
		<div class="y_form"><span class="y_title">运费：</span><input placeholder="USD" class="y_title_txt" type="text" name="shipping_prc" value="<?=$transport_row['TotalPrice']?>"></div>
    </div>
    <div style="background:#fff;height:150px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">发货人</div>    
		<div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="f_name" value="<?=$transport_row['FNAME']?>"></div>
		<div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="f_mobile" value="<?=$transport_row['FMoble']?>"></div>
		<div class="y_form"><span class="y_title">发货地址：</span><input class="y_title_txt" type="text" name="f_address" value="<?=$transport_row['Fdeliveryaddress']?>"></div>
	</div>
	<div style="background:#fff;height:150px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">收货人</div>    
		<div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="s_name" value="<?=$transport_row['SNAME']?>"></div>
		<div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="s_mobile" value="<?=$transport_row['SMoble']?>"></div>
		<div class="y_form"><span class="y_title">收货地址：</span><input class="y_title_txt" type="text" name="s_address" value="<?=$transport_row['Sdeliveryaddress']?>"></div>
	</div>

	<div class="y_submit">
		<input type="hidden" name="trans_time" value="<?=time();?>">
        <input type="hidden" name="act" value="basic_info">
        <input type="hidden" name="TId" value="<?=$TId?>">
        <input class="ys_input" type="submit" value="确定">
        
    </div>
</form>

<form style="background:#fff;min-height:170px;width:95%;overflow:hidden;margin-top:20px" action="mod.php" method="post" class="act_form" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">运输追踪</div>
	<div class="y_form2"><span class="y_title">物流公司：</span><input class="y_title_txt_sm" type="text" name="log_com" value="<?=$transport_row['Company'];?>"></div>
    <div class="y_form"><span class="y_title">进度追踪：</span><input class="y_title_txt" type="text" name="transport_tracking" value="<?=$logistics_cou_ros['LogisticsInfo'];?>"></div>
    <div class="y_form3"><input type="hidden" name="logistics_time" value="<?=time();?>"><input type="submit" value="确定" name="submit" class="ys_input"><input type="hidden" name="add_logistics" value="add_logistics"><input type="hidden" name="TId" value="<?=$TId?>"></div>
</form>	
<form style="background:#fff;min-height:50px;width:95%;overflow:hidden;margin-top:20px" action="" method="post" class="" enctype="multipart/form-data">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;line-height:50px">物流信息</div>
	<div class="y_form1"><span class="y_title">提单号：</span><input class="y_title_txt_sm" type="text" name="" value="<?=$transport_row['TOId']?>"><span class="y_title">物流公司：</span><input class="y_title_txt" type="text" name="" value="<?=$transport_row['Company'];?>"></div>
	<div class="y_form1">
		<div style="text-align:center;width:250px;font-size:12px;color:rgb(102, 102, 102);font-weight: bold;" class="y_form2">日期和时间</div>
		<div style="text-align:center;width:550px;font-size:12px;color:rgb(102, 102, 102);font-weight: bold;" class="y_form">地点跟追踪进度</div>
	</div>
</form>

<?php for($i=0;$i<count($logistics_row);$i++){?>
<form style="background:#fff;min-height:50px;width:95%;overflow:hidden;margin-top:20px" action="mod.php" method="post" name="" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	
	<div class="y_form1">
        <span class="services_1" style=""><input type="hidden" name="StutasTime" value="<?=$logistics_row[$i]['LogisticsTime']?>"><?=date("Y-m-d H:i:s",$logistics_row[$i]['LogisticsTime'])?></span>
        <span class="services_2" ><input style="width: 500px;height: 30px;" type="text" name="shipping_status" class="form_input" value="<?=$logistics_row[$i]['LogisticsInfo'];?>"></span>
        <input class="form_button"  type="submit" name="freight_stutas_alter" value="修改"></td><input type="hidden" name="logistics_update" value="logistics_update"><input type="hidden" name="TId" value="<?=$TId?>">
                    
  	</div>
</form>
<?php }?>
		
<?php include('../../inc/manage/footer.php');?>