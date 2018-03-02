<?php 
include('../inc/include.php');
if($_POST['change_product']=='change_product'){
	$CateId = (int)$_POST['CateId'];
	$where = '1 and '.get_search_where_by_CateId($CateId);
	$index_cate_pro_row = $db->get_limit('product',"{$where} and IsInIndex=1".$mCfg_product_where,'*','MyOrder desc,ProId desc',0,4);
	foreach((array)$index_cate_pro_row as $k1 => $v1){
		$name1 = $v1['Name_lang_1'];
		$img1 = $v1['PicPath_0'];
		$url1 = get_url('product',$v1);
		$price1 = $v1['Price_1'];
		$ProId = $v1['ProId'];
	?>
			
					<div class="Selected_content_right_bg">
					<div class="Selected_content_right_bg_img"><img src="<?=$img1?>" alt=""></div>	
					<div class="Selected_content_txt"><a href=""><?=$name1?></a></div>	
					<div class="Selected_content_price"><a href="">USD$ <?=$price1?></a></div>
					</div>
<script>
	$(function(){
		$(".Selected_content_right_bg").hover(function(){
			$(this).css("border","1px solid #e60012");
			$(this).find(".Selected_content_right_bg_img img").css("opacity","0.6");
			},function(){
			$(this).css("border","1px solid #f2f2f2");
			$(this).find(".Selected_content_right_bg_img img").css("opacity","1");
		})
	})
</script>
	<?php } ?>	
<?php } ?>