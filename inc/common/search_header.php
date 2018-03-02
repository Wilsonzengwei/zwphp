<?php
	echo '<link rel="stylesheet" href="/css/common/header'.$lang.'.css">'
?>

<div class="mask2">
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="/products.php" method="get">
		<input class="search_input" name="center_s" placeholder='<?=$website_language['header'.$lang]['qsrspmc']?>' style="" type="text" value="<?=$center_s ? $center_s :''; ?>">
		<select class="search_select" name="mode_s" id="">
			<option value="1" <?=$mode_s == '1' ? selected : '';?>><?=$website_language['header'.$lang]['sp']?></option>
			<option value="2" <?=$mode_s == '2' ? selected : '';?>><?=$website_language['header'.$lang]['sj']?></option>
			<input type="hidden" name="SupplierId" value="<?=$SupplierId?>">
			<input type="hidden" name="min" value="<?=$min_price?>">
			<input type="hidden" name="max" value="<?=$max_price?>">
			<input type="hidden" name="act" value="<?=$act?>">
			<input type="hidden" name="CateId" value="<?=$CateId?>">
		</select>
		<input class="search_submit" type="submit"  value="">
	</form>		
	</div>
	<?php if($IsSupplier !=1){ ?>
	<div class="index_collection">
		<?php 
			$coll_count_row = $db->get_row_count("coll","MemberId='$MemberId'");
		?>
		<div class="l1"><a href="/user.php?module=coll"><?=$website_language['header'.$lang]['wdsc']?><sapn id='Collection_Cart' class='yangshi'>
		<?php 
			if($MemberId != ''){
				$coll_count_row = $db->get_row_count("coll","MemberId='$MemberId'");
			}else{
				$coll_count_row = '0';
			}

			if($coll_count_row < 100){
		?>
			<?=$coll_count_row?>
		<?php }else{?>
			99+
		<?php }?>
		</sapn><?=$website_language['header'.$lang]['jian']?></a></div>
		<div class="l2"><a href="/user.php?module=cart"><?=$website_language['header'.$lang]['gwc']?><sapn  id='Shopping_Cart' class='yangshi'>
		<?php 
			$cart_count_row = $db->get_row_count("shopping_cart","MemberId='$MemberId' and mysubmit=0");
			if($cart_count_row < 100){


		?>	
			<?=$cart_count_row?>
		<?php }else{?>
			99+
		<?php }?>
		</sapn><?=$website_language['header'.$lang]['jian']?></a></div>
	</div>	
	<?php }?>	
</div>
</div>
<script>
	var a="<?=$website_language['header'.$lang]['qsrspmc']?>";
	var b="<?=$website_language['header'.$lang]['qsrsjmc']?>";
	$('.search_select').change(function(){
		if($(this).val()==1){
			$('.search_input').attr('placeholder',''+a+'');
		}else if($(this).val()==2){
			$('.search_input').attr('placeholder',''+b+'');
		}
	})
</script>