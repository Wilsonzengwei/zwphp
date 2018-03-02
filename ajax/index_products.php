<?php 
include('../inc/include.php');
if($_POST['change_product']=='change_product'){
	$CateId = (int)$_POST['CateId'];
	$where = '1 and '.get_search_where_by_CateId($CateId);
	$CateId = $_POST['CateId'];

	$index_cate_pro_row = $db->get_limit('product',"{$where} and IsInIndex=1".$mCfg_product_where,'*','MyOrder desc,ProId desc',0,4);
	$sec_CateId = $All_Category_row["0,{$v['CateId']},"][0]['CateId'];
	foreach((array)$index_cate_pro_row as $k => $v){
		$name = $v['Name'.$lang];
		$img = $v['PicPath_0'];
		$url = get_url('product',$v);
		$price = $v['Price_1'];
		?>

		<div class="list <?=$k<2 ? 'not_bl' : ''; ?> <?=$k==0 ? 'bor_b not_pt' : ''; ?>">
			<div class="pic">
				<a href="<?=$url; ?>" title="<?=$name; ?>"><img src="<?=$img; ?>" alt="<?=$name; ?>"></a>
			</div>
			<a href="" class="name" title="<?=$name; ?>"><?=$name; ?></a>
			<div class="price">
				$<?=$price; ?>
				<a href="<?=$url; ?>" class="more trans7" title="<?=$name; ?>"><?=$website_language['index'.$lang]['more']; ?></a>
				<div class="clear"></div>
			</div>
		</div>
		<?php if($k==0){ ?>
			<div class="cate_pic bor_b">
				<a href="<?=get_url('product_category',$One_Category[$CateId ]); ?>" title="<?=$One_Category[$sec_CateId]['Category'.$lang]; ?>"><img src="<?=$One_Category[$CateId]['PicPath']; ?>" alt=""></a>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="clear"></div>
<?php } ?>