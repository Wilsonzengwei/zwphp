<?php
include('../../../site_config.php');
include('../../../set/ext_var.php');
include('../../../fun/mysql.php');
include('../../../function.php');

$data_string='';
foreach($_POST as $key => $value){
	$data_string.="{$key}=".urlencode($value).'&';
}
$data_string.='cmd=_notify-validate';
$contents=post_data('www.paypal.com', '/cgi-bin/webscr', $data_string);
$OId=$_GET['OId'];
if($contents){
	if(substr_count($contents, 'VERIFIED')){
		$order_row=$db->get_one('orders', "OId='$OId' and OrderStatus in(1, 3)");
		!$order_row && exit();
		
		if($_POST['payment_status']!='Completed' && $_POST['payment_status']!='Pending'){	//检查状态
			$payment_result='payment status not in Completed or Pending';
		}elseif(strtolower($_POST['business'])!= strtolower($db->get_value('payment_method', 'PId=1', 'Account'))){	//检查收款帐号
			$payment_result='business account error';
		}elseif($_POST['mc_gross']!=(iconv_price(((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*(1+$order_row['PayAdditionalFee']/100), 2))){	//检查金额
			$payment_result='grand total error';
		}elseif($_POST['mc_currency']!=$order_row['PaymentOnlineCurrency']){	//检查币种
			$payment_result='payment currency error';
		}else{
            $order_row=$db->get_one('orders',"OId='$OId'");
            $product_list=$db->get_all('orders_product_list',"OrderId='{$order_row['OrderId']}'");
            $Integral=0;
            foreach((array)$product_list as $row){
                $Integral+=$db->get_value('product',"ProId='{$row['ProId']}'",'Integral');
            }

            $Integral && $db->query("update member set Integral=Integral+$Integral where MemberId='{$order_row['MemberId']}'");

			$db->update('orders', "OId='$OId'", array(
					'OrderStatus'	=>	4
				)
			);
			
			$order_row['OrderStatus']=4;	//改订单状态，发邮件用，不需要再次查询数据库
			include($site_root_path.'/inc/lib/mail/order_payment.php');
			include($site_root_path.'/inc/lib/mail/template.php');
			sendmail($order_row['Email'], $order_row['FirstName'].' '.$order_row['LastName'], 'We have received from your payment', $mail_contents);
			
			$payment_result='payment success';
			echo 'success';
		}
	}else{
		$payment_result='paypal not return VERIFIED';
		echo 'fail';
	}
}else{
	$payment_result='can not get paypal return info';
	echo 'fail';
}

ob_start();
print_r($_GET);
print_r($_POST);
echo "\r\n\r\n$contents";
echo "\r\n\r\n$payment_result";
$log=ob_get_contents();
ob_end_clean();
write_file('/_paypal_log/'.date('Y_m/d/', $service_time), "$OId.txt", $log);	//把返回数据写入文件
?>