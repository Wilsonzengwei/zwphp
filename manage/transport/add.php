<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='transport';
check_permit('transport', 'transport.add');
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
	$transport_tracking = $_POST['transport_tracking'];
	$trans_time = $_POST['trans_time'];
	$shipping_prc = $_POST['shipping_prc'];
	$product_name = $_POST['product_name'];
	$db->insert('transport',array(
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
	$TId =$db->get_insert_id();
		$db->insert('logistics',array(
		'TId'				=> $TId,
		'LogisticsTime'		=> $trans_time,
		'LogisticsInfo'		=> $transport_tracking,
		
		));
	header('Location: index.php');
	exit;
}
$transport_row = $db->get_all('transport',"TOId='$orders_t'");
include('../../inc/manage/header.php');
?>
<form style="background:#fff;min-height:200px;width:95%;line-height:40px;overflow:hidden;margin-top:20px" action="" method="post" class="act_form" enctype="multipart/form-data">
  	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">托运中心添加</div> 
    <div style="background:#fff;height:200px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">产品信息</div>    
		<div class="y_form"><span class="y_title">提单号：</span><input class="y_title_txt" type="text" name="orders_t"></div>
		<div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" name="product_name"></div>
		<div class="y_form"><span class="y_title">数量：</span><input placeholder="件" class="y_title_txt" type="text" name="myqty"></div>
		<div class="y_form"><span class="y_title">重量：</span><input placeholder="kg" class="y_title_txt" type="text" name="weight"></div>
		<div class="y_form"><span class="y_title">运费：</span><input placeholder="USD" class="y_title_txt" type="text" name="shipping_prc"></div>
    </div>
    <div style="background:#fff;height:150px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">发货人</div>    
		<div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="f_name"></div>
		<div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="f_mobile"></div>
		<div class="y_form"><span class="y_title">发货地址：</span><input class="y_title_txt" type="text" name="f_address"></div>
	</div>
	<div style="background:#fff;height:150px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">收货人</div>    
		<div class="y_form"><span class="y_title">姓名：</span><input class="y_title_txt" type="text" name="s_name"></div>
		<div class="y_form"><span class="y_title">手机号码：</span><input class="y_title_txt" type="text" name="s_mobile"></div>
		<div class="y_form"><span class="y_title">收货地址：</span><input class="y_title_txt" type="text" name="s_address"></div>
	</div>
	<div style="background:#fff;height:100px;width:95%;line-height:40px;overflow:hidden;margin-top:20px;border:1px solid #ccc;">
	    <div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:20px">收货人</div>    
		<div class="y_form"><span class="y_title">物流公司：</span><input class="y_title_txt" type="text" name="log_com"></div>
		<div class="y_form"><span class="y_title">运输追踪：</span><input class="y_title_txt" type="text" name="transport_tracking"></div>
	</div>
	<div class="y_submit">
		<input type="hidden" name="trans_time" value="<?=time();?>">
        <input type="hidden" name="act" value="basic_info">
        <input class="ys_input" type="submit" value="确定">
        
    </div>
</form>


		
<?php include('../../inc/manage/footer.php');?>