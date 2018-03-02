<?php
/*
url可带参数：
ProId:产品ID
*/

$ProId=(int)$_GET['ProId'];
$product_row=$db->get_one('product', "ProId='$ProId'");
?>