<div class="featured_product">
	<div class="fea_title"><?=$website_language['products'.$lang]['featured']; ?></div>
	<?php $featured_product_row = $db->get_limit('product','IsFeatured=1 and SupplierId='.$SupplierId.$mCfg_product_where,'*','MyOrder desc,ProId desc',0,4); ?>
	<?php foreach((array)$featured_product_row as $v){ 
		$name = $v['Name'.$lang];
		$price = $v['Price_1'];
		$img = $v['PicPath_0'];
		$url = get_url('product',$v);
		?>
		<div class="list">
			<div class="pic">
				<a href="<?=$url; ?>" title="<?=$name; ?>"><img src="<?=$img; ?>" alt="<?=$name; ?>"></a>
			</div>
			<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
			<div class="price">$<?=$price; ?></div>
		</div>
	<?php } ?>
</div>