<?php
$product_img_width=160;	//产品图片宽度
$product_img_height=160;	//产品图片高度
$contents_width=720;	//显示内容的div的宽度
$query_string=query_string('page');
$turn_page_query_string=$website_url_type==0?"?$query_string&page=":'page-';

if(!isset($product_row)){
	$page_count=10;
	$where='1';	//基本搜索条件，如果后台开启了上下架功能，这里请设置为：SoldOut=0
	include($site_root_path.'/inc/lib/product/get_list_row.php');
}

ob_start();
?>
<div id="lib_product_list_1">
	<?php
	for($i=0; $i<count($product_row); $i++){
		$url=get_url('product', $product_row[$i]);
	?>
	<div class="item" style="width:<?=$contents_width;?>px;">
		<div class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px"><div><a href="<?=$url;?>" target="_blank"><img src="<?=$product_row[$i]['PicPath_0'];?>"/></a></div></div>
		<div class="info" style="width:<?=$contents_width-$product_img_width-15;?>px;">
			<div class="proname"><a href="<?=$url;?>" target="_blank"><?=$product_row[$i]['Name'];?></a></div>
			<div class="flh_180"><?=format_text($product_row[$i]['BriefDescription']);?></div>
		</div>
		<div class="cline"><div class="line"></div></div>
	</div>
	<?php }?>
</div>
<div class="blank6"></div>
<div id="turn_page"><?=turn_page($page, $total_pages, $turn_page_query_string, $row_count, '<<', '>>', $website_url_type);?></div>
<?php
$product_list_1_lang_0=ob_get_contents();
ob_clean();
?>