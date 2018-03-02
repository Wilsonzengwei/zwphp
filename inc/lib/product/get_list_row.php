<?php
/*
url可带参数：
CateId:类别ID
Keyword:搜索关键词（搜索产品名称、产品编号）
P0:价格范围起始值（默认搜索Price_1值，请根据需要修改）
P1:价格范围结束值
ItemNumber:按产品编号精确搜索出对应产品
ext:后台勾选框筛选，值对应搜索条件如ext_ary数组：
//二级这个就可以了
//查看顶级分类
$CateId && $TopCateId=get_top_CateId_by_UId(get_UId_by_CateId($CateId, 'product_category'));
*/

//-------------------------------------------------------------------------------------------------------------------------------------------------

/*$UId='0,10,12,20,';*/
/*分割UID*/
function get_top_CateId_by_UId1($UId, $i=1){
	$cateid_ary=explode(',', $UId);
	//$cateid_ary=array(0=>0,1=>10,2=>12,3=>20);
	return $cateid_ary[$i];
}

$ext_ary=array(1=>'IsInIndex=1', 2=>'IsHot=1', 3=>'IsRecommend=1', 4=>'IsNew=1', 5=>'IsSpecialOffer=1');
$CateId=(int)$_GET['CateId'];
$Keyword=$_GET['Keyword'];
$P0=(float)$_GET['P0'];
$P1=(float)$_GET['P1'];
$ItemNumber=$_GET['ItemNumber'];
$ext=(int)$_GET['ext'];

//-------------------------------------------------------------------------------------------------------------------------------------------------

$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'product_category');
//三级分类
//查看顶级分类
if($CateId){
	$UId=get_UId_by_CateId($CateId, 'product_category');
	$TopCateId=(int)get_top_CateId_by_UId1($UId);
	$SecCateId=(int)get_top_CateId_by_UId1($UId, 2);
	$ThdCateId=(int)get_top_CateId_by_UId1($UId, 3);
}
$Keyword && $where.=" and (Name like '%$Keyword%' or ItemNumber like '%$Keyword%')";
(($P0 || $P1) && $P1>$P0) && $where.=" and Price_1 between $P0 and $P1";
$ItemNumber && $where.=" and ItemNumber='$ItemNumber'";
($ext && $ext_ary[$ext]) && $where.=" and {$ext_ary[$ext]}";

//-------------------------------------------------------------------------------------------------------------------------------------------------

$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/$page_count);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*$page_count;
$product_row=$db->get_limit('product', $where, '*', $products_order_by.'MyOrder desc, ProId desc', $start_row, $page_count);

//-------------------------------------------------------------------------------------------------------------------------------------------------
?>