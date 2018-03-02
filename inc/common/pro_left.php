<?php foreach((array)$All_Category_row['0,'] as $k => $v){
	$vCateId = $v['CateId'];
	$vUId=$v['UId'].$vCateId.',';
	if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$vUId}%') or CateId='{$vCateId}')".$mCfg_product_where)) continue;
	if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$vUId}%'))".$mCfg_product_where)){
		$not_pro = 1;
	}
	$name = $v['Category'.$lang];
	$v['SupplierId'] = $SupplierId;
	$url = get_url('supplier_product_category',$v);
	?>
	<div class="top_list">
		<a href="<?=$url; ?>" class="top_item" title="<?=$name; ?>"><?=$name; ?></a>
		<?php if(!$not_pro){ ?>
			<em class="trans3 plus <?=$TopCateId==$vCateId ? 'less' : ''; ?>"></em>
		<?php } ?>
	</div>
	<?php if(!$not_pro){ ?>
		<div class="sec_list <?=$TopCateId==$vCateId ? '' : 'hide'; ?>">
			<?php foreach((array)$All_Category_row['0,'.$vCateId.','] as $k1 => $v1){ 
				$v1CateId = $v1['CateId'];
				$v1UId=$v1['UId'].$v1CateId.',';
				if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$v1UId}%') or CateId='{$v1CateId}')".$mCfg_product_where)) continue; 
				$name1 = $v1['Category'.$lang];
				$v1['SupplierId'] = $SupplierId;
				$url1 = get_url('supplier_product_category',$v1);
				?>
				<a href="<?=$url1; ?>" class="sec_item <?=$SecCateId==$v1CateId ? 'sec_on' : '' ?>" title="<?=$name1; ?>"><?=$name1; ?></a>
				<?php if($All_Category_row['0,'.$vCateId.','.$v1CateId.',']){ ?>
					<div class="thi_list">
						<?php foreach((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.','] as $k2 => $v2){ 
							$v2CateId = $v2['CateId'];
							$v2UId=$v2['UId'].$v2CateId.',';
							if(!$db->get_row_count('product',"SupplierId='$SupplierId' and (CateId in(select CateId from product_category where UId like '%{$v2UId}%') or CateId='{$v2CateId}')".$mCfg_product_where)) continue; 
							$name2 = $v2['Category'.$lang];
							$v2['SupplierId'] = $SupplierId;
							$url2 = get_url('supplier_product_category',$v2);
							?>
							<a href="<?=$url2; ?>" class="thi_item <?=$CateId==$v2CateId ? 'thi_on' : '' ?>" title="<?=$name2; ?>"><?=$name2; ?></a>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>
<script>
	$('.content_left .plus').click(function(){
		if($(this).hasClass('less')){
			$(this).removeClass('less').parent().removeClass('top_on').next('.sec_list').slideUp();
		}else{
			$(this).addClass('less').parent().addClass('top_on').next('.sec_list').slideDown();
		}
	});
</script>