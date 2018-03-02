<?php
$MemberId = $_SESSION['member_MemberId'];
$query_string=query_string('act');

if($_POST['data']=='cart_list'){
	for($i=0; $i<count($_POST['CId']); $i++){
		$_CId=(int)$_POST['CId'][$i];
		$_ProId=(int)$_POST['ProId'][$i];
		$_Qty=abs((int)$_POST['Qty'][$i]);
		$_Qty<=0 && $_Qty=1;
		$_S_Qty=abs((int)$_POST['S_Qty'][$i]);
		$_Remark=$_POST['Remark'][$i];
		$_S_Remark=$_POST['S_Remark'][$i];
		
		if($_Qty!=$_S_Qty || $_Remark!=$_S_Remark){
			$product_row=$db->get_one('product', "ProId='$_ProId'");
			$db->update('shopping_cart', "$where and CId='$_CId'", array(
					'Qty'	=>	$_Qty,
					'Remark'=>	$_Remark,
					'Price'	=>	pro_add_to_cart_price($product_row, $_Qty, $order_product_price_field)
				)
			);
		}
	}
	js_location("$cart_url?module=checkout");
}
if($_GET['mode']=='del'){

	$ProId = $_GET['ProId'];
	$act = $_GET['act'];
	$db->delete("shopping_cart","ProId='$ProId'");
	header("Location: /user.php?module=cart&act=".$act);
	exit;
}
if($_GET['act']=='remove' || $_GET['act']=='later'){
	$query_string=query_string(array('act', 'CId'));
	$CId=(int)$_GET['CId'];
	$db->delete('shopping_cart', "$where and CId='$CId'");
	
	if($_GET['act']=='later' && (int)$_SESSION['member_MemberId']){
		$ProId=(int)$_GET['ProId'];
		if(!$db->get_row_count('wish_lists', "$where and ProId='$ProId'")){
			$db->insert('wish_lists', array(
					'MemberId'	=>	(int)$_SESSION['member_MemberId'],
					'ProId'		=>	$ProId
				)
			);
		}
	}
	js_location("$cart_url?$query_string");
}
$where = "MemberId='$MemberId' and Mysubmit=0";
$cart_row=$db->get_all('shopping_cart', $where, '*', 'ProId desc, CId desc');
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/cart'.$lang.'.css">'
?>

	<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s2'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wdgwc']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="bbg1">
				<div class="content_title">				
					<div class="a_350"><?=$website_language['user_cart'.$lang]['cpxx']?></div>
					<div class="a_80"><?=$website_language['user_cart'.$lang]['dj']?></div>
					<div class="a_110"><?=$website_language['user_cart'.$lang]['ys']?></div>
					<div class="a_80"><?=$website_language['user_cart'.$lang]['sl']?></div>
					<div class="a_160"><?=$website_language['user_cart'.$lang]['gys']?></div>
					<div class="a_100"><?=$website_language['user_cart'.$lang]['cz']?></div>
				</div>
				<?php 
					for ($i=0; $i < count($cart_row); $i++) { 
						$MemberId=$cart_row[$i]['SupplierId'];
						$Supplier_Name = $db->get_one('member',"MemberId='$MemberId'");
				?>
				<div class="content_waiwei">
					<div class="content_title"></div>
					<div class="b_350">
						<div class="b_img">
							<img src="<?=$cart_row[$i]['PicPath']?>" alt="">
						</div>
						<div class="b_txt_mask">
							<div class="b_txt" title="<?=$cart_row[$i]['Name'.$lang.'']?>"><a><?=$cart_row[$i]['Name'.$lang.'']?></a><i class='slh'></i></div>
						</div>
					</div>
					<div class="b_80">
						<div class="b_txt_sm_mask">
							<div class="b_txt_sm" title="">USD $<?=$cart_row[$i]['Price']?></div>
						</div>
					</div>
					<div class="b_110">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm">红色</div>
						</div>
					</div>
					<div class="b_80">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm_red"><?=$cart_row[$i]['Qty']?></div>
						</div>
					</div>
					<div class="b_160">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm"><?=$Supplier_Name['Supplier_Name']?></div>
						</div>
					</div>
					<div class="b_100">
						<div class="b_txt_sm_mask">
							<div class="b_txt_sm1" style="height: 80px">
							<input type="hidden" name="data" value="cart_list" />								
								<div><a href="/supplier/goods.php?ProId=<?=$cart_row[$i]['ProId']?>&SupplierId=<?=$cart_row[$i]['SupplierId']?>"><?=$website_language['user_cart'.$lang]['ck']?></a></div><br>
								<div><a href="/cart.php?module=checkout&mysubmit=0&ProId=<?=$cart_row[$i]['ProId']?>&data=cart_list"><?=$website_language['user_cart'.$lang]['ljgm']?></a></div><br>	
								<div><a href="/user.php?module=cart&act=1&ProId=<?=$cart_row[$i]['ProId']?>&mode=del"><?=$website_language['user_cart'.$lang]['sc']?></a></div>	 						
							</div>
						</div>
					</div>
				</div>	
				<script>
					$(function(){
						$('.b_txt').each(function(){
							var ah=$(this).find('a').css('height');
							if(ah>'32px'){
								$(this).find('.slh').css('display','block');
							}else{
								$(this).find('.slh').css('display','none');
							}
						})
					})
				</script>
				<?php }?>
			</div>
		</div>
	</div>
	</div>
</div>