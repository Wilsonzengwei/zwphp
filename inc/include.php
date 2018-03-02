<?php 
include('site_config.php');
include('fun/mysql.php');
include('set/ext_var.php');
include('function.php');
include('lang/cn.php');

$One_Category=array();
$All_Category_row=array();
$nav_all=$db->get_all('product_category',"1","*","MyOrder desc");
foreach((array)$nav_all as $item){
	//单个分类,不用继续查数据库
	$One_Category[$item['CateId']]=$item;	
	//全部分类
	$All_Category_row[$item['UId']][] = $item; 
}
$SupplierId = (int)$_GET['SupplierId'];
$SupplierId && $Supplier_Row = $db -> get_one('member',"MemberId='$SupplierId'");
?>
