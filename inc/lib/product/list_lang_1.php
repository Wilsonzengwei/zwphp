<?php
$list_row_count=4;	//每行显示的产品件数
$list_line_count=5;	//显示的行数
$product_img_width=160;	//产品图片宽度
$product_img_height=160;	//产品图片高度
$query_string=query_string('page');
$turn_page_query_string=$website_url_type==0?"?$query_string&page=":'page-';

if(!isset($product_row)){
	$page_count=$list_row_count*$list_line_count;
	$where='1';	//基本搜索条件，如果后台开启了上下架功能，这里请设置为：SoldOut=0
	include($site_root_path.'/inc/lib/product/get_list_row.php');
}

ob_start();
?>
<div id="lib_product_list">
	<?php
	$j=1;
	for($i=0; $i<count($product_row); $i++){
		$url=get_url('product', $product_row[$i]);
	?>
	<div class="item" style="width:<?=sprintf('%01.2f', 100/$list_row_count);?>%;">
		<ul style="width:<?=$product_img_width+2;?>px;">
			<li class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px"><div><a href="<?=$url;?>"><img src="<?=$product_row[$i]['PicPath_0'];?>"/></a></div></li>
			<li class="name"><a href="<?=$url;?>"><?=$product_row[$i]['Name_lang_1'];?></a></li>
		</ul>
	</div>
	<?php if($j++%$list_row_count==0){echo '<div class="blank12"></div>';};?>
	<?php }?>
	<div class="clear"></div>
</div>
<div class="blank6"></div>
<div id="turn_page"><?=turn_page($page, $total_pages, $turn_page_query_string, $row_count, '<<', '>>', $website_url_type);?></div>
<?php
$product_list_lang_1=ob_get_contents();
ob_clean();
?>