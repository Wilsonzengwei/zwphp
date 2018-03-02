<?php
include('../../inc/fun/img_to_bmp.php');

save_manage_log('导出订单');
@set_time_limit(60);
$excel_dir=mk_dir('/_export_excel/'.date('Y_m/d/'), $service_time);

require_once('../../inc/fun/excel/class.writeexcel_workbook.inc.php');
require_once('../../inc/fun/excel/class.writeexcel_worksheet.inc.php');

//--------------------------------------------------------------------------------------------------------------------------------------------------------

mk_dir('/tmp/');
$fname=tempnam($site_root_path.'/tmp/', rand_code().'.xls');
$workbook=&new writeexcel_workbook($fname);
$worksheet=&$workbook->addworksheet($order_row['OId']);

$worksheet->set_column(0, 0, 18);	//图片列宽
$worksheet->set_column(1, 1, 50);	//商品名称列宽
$worksheet->set_column(2, 2, 18);	//商品编号列宽
$worksheet->set_column(3, 3, 14);	//价格列宽
$worksheet->set_column(4, 4, 14);	//数量列宽
$worksheet->set_column(5, 5, 14);	//小计列宽

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$header_format=&$workbook->addformat(array(bold=>1, color=>'blue', align=>'left', size=>20));
$header_format->set_align('vcenter');
$worksheet->set_row(0, 40);
$worksheet->write('A1', "Order Number: {$order_row['OId']}", $header_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'blue'));
$text_format->set_align('vcenter');
$worksheet->set_row(1, 20);

$worksheet->write('A2', 'Photo', $text_format);
$worksheet->write('B2', 'Product', $text_format);
$worksheet->write('C2', 'Item No.', $text_format);
$worksheet->write('D2', 'Price', $text_format);
$worksheet->write('E2', 'Quantity', $text_format);
$worksheet->write('F2', 'Total', $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$str_format=&$workbook->addformat(array(align=>'center', text_wrap=>1));
$str_format->set_align('vcenter');
$str_format_1=&$workbook->addformat(array(align=>'left', text_wrap=>1));
$str_format_1->set_align('vcenter');
$line=3;	//当前的行数
$bmp_path='/_export_excel/tmp.bmp';

$item_row=$db->get_all('orders_product_list', $where, '*', 'ProId desc, LId desc');
for($i=0; $i<count($item_row); $i++){
	$worksheet->set_row($line-1, 80);
	
	if(is_file($site_root_path.$item_row[$i]['PicPath'])){
		img_to_bmp($item_row[$i]['PicPath'], $site_root_path.$bmp_path);
		//echo $bmp_path;exit;
		$worksheet->insert_bitmap('A'.$line, $site_root_path.$bmp_path, 20, 8);
		del_file($bmp_path);
	}
	
	$pro_str=$item_row[$i]['Name']."\r\n";
	$item_row[$i]['Color'] && $pro_str.="Color: {$item_row[$i]['Color']}\r\n";
	$item_row[$i]['Size'] && $pro_str.="Size: {$item_row[$i]['Size']}\r\n";
	$order_product_weight==1 && $pro_str.="Weight: {$item_row[$i]['Weight']} KG";
	
	$worksheet->write('B'.$line, $pro_str, $str_format_1);
	$worksheet->write('C'.$line, $item_row[$i]['ItemNumber'], $str_format);
	$worksheet->write('D'.$line, $item_row[$i]['Price'], $str_format);
	$worksheet->write('E'.$line, $item_row[$i]['Qty'], $str_format);
	$worksheet->write('F'.$line, "=D{$line}*E{$line}", $str_format);
	
	$line++;
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'blue'));
$text_format->set_align('vcenter');
$worksheet->set_row($line-1, 20);

$l=$line-1;

$worksheet->write('A'.$line, '', $text_format);
$worksheet->write('B'.$line, '', $text_format);
$worksheet->write('C'.$line, '', $text_format);
$worksheet->write('D'.$line, '', $text_format);
$worksheet->write('E'.$line, "=SUM(E3:E{$l})", $text_format);
$worksheet->write('F'.$line, "=SUM(F3:F{$l})", $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

if($order_row['Discount']>0){
	$line++;
	
	$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'grey'));
	$text_format->set_align('vcenter');
	$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'right', fg_color=>'grey'));
	$text_format_1->set_align('vcenter');
	$worksheet->set_row($line-1, 20);
	
	$worksheet->write('A'.$line, '', $text_format);
	$worksheet->write('B'.$line, '', $text_format);
	$worksheet->write('C'.$line, '', $text_format);
	$worksheet->write('D'.$line, '', $text_format);
	$worksheet->write('E'.$line, 'Discount:', $text_format_1);
	$worksheet->write('F'.$line, $order_row['Discount'], $text_format);
	
	//---------------------------------------------------------------------------------------------------------------------------------------------------
	
	$line++;
	
	$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'grey'));
	$text_format->set_align('vcenter');
	$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'right', fg_color=>'grey'));
	$text_format_1->set_align('vcenter');
	$worksheet->set_row($line-1, 20);
	
	$worksheet->write('A'.$line, '', $text_format);
	$worksheet->write('B'.$line, '', $text_format);
	$worksheet->write('C'.$line, '', $text_format);
	$worksheet->write('D'.$line, '', $text_format);
	$worksheet->write('E'.$line, 'Save:', $text_format_1);
	$worksheet->write('F'.$line, '=F'.($line-2).'*F'.($line-1), $text_format);
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$line++;

$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'grey'));
$text_format->set_align('vcenter');
$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'right', fg_color=>'grey'));
$text_format_1->set_align('vcenter');
$worksheet->set_row($line-1, 20);

$worksheet->write('A'.$line, '', $text_format);
$worksheet->write('B'.$line, '', $text_format);
$worksheet->write('C'.$line, '', $text_format);
$worksheet->write('D'.$line, '', $text_format);
$worksheet->write('E'.$line, 'Shipping Charges:', $text_format_1);
$worksheet->write('F'.$line, sprintf('%01.2f', $order_row['ShippingPrice']), $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$line++;

$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'grey'));
$text_format->set_align('vcenter');
$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'right', fg_color=>'grey'));
$text_format_1->set_align('vcenter');
$worksheet->set_row($line-1, 20);

$worksheet->write('A'.$line, '', $text_format);
$worksheet->write('B'.$line, '', $text_format);
$worksheet->write('C'.$line, '', $text_format);
$worksheet->write('D'.$line, '', $text_format);
$worksheet->write('E'.$line, 'Pay Additional Fee:', $text_format_1);
$worksheet->write('F'.$line, sprintf('%01.2f', ((1-$order_row['Discount'])*$order_row['TotalPrice']+$order_row['ShippingPrice'])*($order_row['PayAdditionalFee']/100)), $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$line++;
if($order_row['Discount']>0){
	$p='F'.($line-5).'-F'.($line-3).'+F'.($line-2).'+F'.($line-1);
}else{
	$p='F'.($line-3).'+F'.($line-2).'+F'.($line-1);
}

$text_format=&$workbook->addformat(array(bold=>1, color=>'white', align=>'center', fg_color=>'blue'));
$text_format->set_align('vcenter');
$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'right', fg_color=>'blue'));
$text_format_1->set_align('vcenter');
$worksheet->set_row($line-1, 20);

$worksheet->write('A'.$line, '', $text_format);
$worksheet->write('B'.$line, '', $text_format);
$worksheet->write('C'.$line, '', $text_format);
$worksheet->write('D'.$line, '', $text_format);
$worksheet->write('E'.$line, 'Grand Total:', $text_format_1);
$worksheet->write('F'.$line, "=$p", $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$order_data=array(
	$order_row['OId'].' ',
	$order_row['Email'],
	$order_row['PaymentMethod'],
	date('m/d/Y H:i:s', $order_row['OrderTime']),
	$order_status_ary[$order_row['OrderStatus']],
	$order_row['Express'].($order_product_weight==1?(" (Parcel Weight: {$order_row['TotalWeight']} KG)"):''),
	$order_row['TrackingNumber'],
	($order_row['ShippingTime'] && ($order_row['OrderStatus']==5 || $order_row['OrderStatus']==6)?date('m/d/Y', $order_row['ShippingTime']):'')
);
$order_data_name=array(
	'Order Number:',
	'Clinet Email:',
	'Payment Method:',
	'Order Time:',
	'Order Status:',
	'Shipping Method:',
	'Tracking Number:',
	'Shipping Time:'
);

for($i=0; $i<count($order_data); $i+=2){
	$line++;
	$text_format=&$workbook->addformat(array(color=>'white', align=>'left', fg_color=>'green'));
	$text_format->set_align('vcenter');
	$text_format_1=&$workbook->addformat(array(bold=>1, color=>'white', align=>'left', fg_color=>'green'));
	$text_format_1->set_align('vcenter');
	$worksheet->set_row($line-1, 20);
	
	$worksheet->write('A'.$line, $order_data_name[$i], $text_format_1);
	$worksheet->write('B'.$line, $order_data[$i], $text_format);
	$worksheet->write('C'.$line, $order_data_name[$i+1], $text_format_1);
	$worksheet->write('D'.$line, $order_data[$i+1], $text_format);
	$worksheet->write('E'.$line, '', $text_format);
	$worksheet->write('F'.$line, '', $text_format);
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$line++;

$text_format=&$workbook->addformat(array(color=>'white', text_wrap=>1, align=>'center', fg_color=>'black', merge=>1));
$text_format->set_align('vcenter');
$worksheet->set_row($line-1, 100);

$ship_to="Ship to:\r\n".$order_row['ShippingFirstName'].' '.$order_row['ShippingLastName']."\r\n".$order_row['ShippingAddressLine1']."\r\n";
$order_row['ShippingAddressLine2']!='' && $ship_to.=$order_row['ShippingAddressLine2']."\r\n";
$ship_to.=$order_row['ShippingCity']."\r\n".$order_row['ShippingState'].'(Postal Code: '.$order_row['ShippingPostalCode'].")\r\n".$order_row['ShippingCountry'];
$ship_to=htmlspecialchars($ship_to);

$bill_to="Bill to:\r\n".$order_row['BillingFirstName'].' '.$order_row['BillingLastName']."\r\n".$order_row['BillingAddressLine1']."\r\n";
$order_row['BillingAddressLine2']!='' && $bill_to.=$order_row['BillingAddressLine2']."\r\n";
$bill_to.=$order_row['BillingCity']."\r\n".$order_row['BillingState'].'(Postal Code: '.$order_row['BillingPostalCode'].")\r\n".$order_row['BillingCountry'];
$bill_to=htmlspecialchars($bill_to);

$worksheet->write('A'.$line, $ship_to, $text_format);
$worksheet->write('B'.$line, '', $text_format);
$worksheet->write('C'.$line, $bill_to, $text_format);
$worksheet->write('D'.$line, '', $text_format);
$worksheet->write('E'.$line, '', $text_format);
$worksheet->write('F'.$line, '', $text_format);

//--------------------------------------------------------------------------------------------------------------------------------------------------------

$workbook->close();
$filename="{$order_row['OId']}.xls";
del_file($excel_dir.$filename);
@copy($fname, $site_root_path.$excel_dir.$filename);
down_file($excel_dir.$filename);
exit;

//--------------------------------------------------------------------------------------------------------------------------------------------------------
?>