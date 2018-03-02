<?php 
$MemberId = $_SESSION['member_MemberId'];

if($_GET['mode'] == 'cancel'){
	$CId = $_GET['CId'];
	$db->delete('coll',"CId='$CId'");

}
$row_count=$db->get_row_count('coll', "SupplierId='$SupplierId'");
$total_pages=ceil($row_count/10);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*10;

$coll_row = $db->get_limit("coll","MemberId='$MemberId'",'*',"AccTime desc",$start_row,'10');
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/coll'.$lang.'.css">'
?>

	<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s2'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wdsc']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="bbg1">
				<div class="content_title">				
					<div class="a_350"><?=$website_language['user_coll'.$lang]['cpxx']?></div>
					<div class="a_80_es"><?=$website_language['user_coll'.$lang]['dj']?></div>
					<!-- <div class="a_110"><?=$website_language['user_coll'.$lang]['ys']?></div> -->
					<div class="a_80"><?=$website_language['user_coll'.$lang]['qdl']?></div>
					<div class="a_160"><?=$website_language['user_coll'.$lang]['gys']?></div>
					<div class="a_100"><?=$website_language['user_coll'.$lang]['cz']?></div>
				</div>
				
				<?php 
					for ($i=0; $i < count($coll_row); $i++) {
						$product_pid =  $coll_row[$i]['ProId'];
						if($lang == '_en'){
							$product_name1 = $db->get_one("product","ProId=".$product_pid,"Name_lang_2");
							$product_name = $product_name1['Name_lang_2'];
						}else{
							$product_name1 = $db->get_one("product","ProId=".$product_pid,"Name".$lang);
							$product_name = $product_name1['Name'.$lang];
						}
				?>
				</a>
				<div class="content_waiwei">
					<div class="content_title"></div>
					<div class="b_350">
						<div class="b_img">
							<img src="<?=$coll_row[$i]['PicPath']?>" alt="">
						</div>
						<div class="b_txt_mask">
							<div class="b_txt" title="<?=$product_name?>"><a href="/supplier/goods.php?ProId=<?=$coll_row[$i]['ProId']?>&SupplierId=<?=$coll_row[$i]['SupplierId']?>">
							<?php if($lang == 'en'){ ?>
								<?=$product_name?>
							<?php }else{ ?>
								<?=$product_name?>
							<?php }?>

							</a><i class='slh'></i></div>
						</div>
					</div>
					<div class="b_80">
						<div class="b_txt_sm_mask">
							<div class="b_txt_sm" title="">USD $<?=$coll_row[$i]['Price']?></div>
						</div>
					</div>
					<!-- <div class="b_110">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm">红色</div>
						</div>
					</div> -->
					<div class="b_80_es">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm_red"><?=$coll_row[$i]['Moq']?></div>
						</div>
					</div>
					<div class="b_160">
						<div class="b_txt_sm_mask">
							<div title="" class="b_txt_sm"><?=$coll_row[$i]['SupplierName']?></div>
						</div>
					</div>
					<div class="b_100">
						<div class="b_txt_sm_mask">
							<div class="b_txt_sm1">
								<div><a href="user.php?module=coll&mode=cancel&CId=<?=$coll_row[$i]['CId']?>"><?=$website_language['user_coll'.$lang]['qxsc']?></a></div><br>								
							</div>
						</div>
					</div>
				</div>	
				<script>
					$(function(){
						$('.b_txt').each(function(){
							var ah=$(this).find('a').css('height');
							if(ah>'64px'){
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
