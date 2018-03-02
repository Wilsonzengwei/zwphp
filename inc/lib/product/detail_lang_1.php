<?php
$product_img_width=350;	//产品图片宽度
$product_img_height=350;	//产品图片高度
$contents_width=720;	//显示内容的div的宽度

!isset($product_row) && include($site_root_path.'/inc/lib/product/get_detail_row.php');

ob_start();
?>
<div id="lib_product_detail" style="width:<?=$contents_width;?>px;">
	<div class="info">
		<div class="img" style="width:<?=$product_img_width;?>px; height:<?=$product_img_height;?>px;">
			<div><img src="<?=str_replace('s_', "{$product_img_width}X{$product_img_height}_", $product_row['PicPath_0']);?>"/></div>
		</div>
		<div class="pro_info" style="width:<?=$contents_width-$product_img_width-15;?>px;">
			<div class="proname"><?=$product_row['Name_lang_1'];?></div>
			<!---->
				<div class="item flh_180"><?=format_text($product_row['BriefDescription_lang_1']);?></div>
				<div class="item">
					<div>
						<div class="fl">RRP: <del class="fc_gory">$<?=$product_row['Price_0'];?></del></div>
						<div class="fr">Today's Deal: <font class="fc_red">$<?=$product_row['Price_1'];?></font></div>
						<div class="clear"></div>
					</div>
				</div>
			<!---->
			<div class="item"></div>
		</div>
	</div>
	<div class="description">
		<div class="desc_nav">
			<div>Description</div>
		</div>
		<div class="desc_contents"><?=$db->get_value('product_description', "ProId='{$product_row['ProId']}'", 'Description_lang_1');?></div>
	</div>
</div>
<?php
$product_detail_lang_1=ob_get_contents();
ob_end_clean();
?>