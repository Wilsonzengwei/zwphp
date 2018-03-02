<?php 
include('../../inc/include.php'); 
$ProId = (int)$_GET['ProId'];

$ProId && $product_row = $db->get_one('product',"ProId='$ProId'");
$CateId = $product_row['CateId'];
$CateId && $category_row = $db->get_one('product_category',"CateId='$CateId'");
$product_description_row = $db->get_one('product_description',"ProId='$ProId'");
$goods_row=$db->get_all('product_wholesale_price', "ProId='$ProId'", '*', 'PId asc');
$shipping_row=$db->get_all('shipping_freight','SFID=1');
$shipping_row_2=$db->get_all('shipping_freight','SFID=2');
$supplierid = $_GET['SupplierId'];
$isbl = $db->get_one('member',"MemberId=$supplierid",'Is_Business_License');
$isbl = $isbl['Is_Business_License'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php echo seo_meta($product_row['SeoTitle'],$product_row['SeoKeyword'],$product_row['SeoDescription']);?>
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/lib.css">
	<link rel="stylesheet" type="text/css" href="../css/goods.css"/>
</head>
<body>
	<?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
	<div id="goods">
		<div class="top_title">
			<a href="javascript:;" onclick="history.back();" class="return"></a>
			<?=$product_row['Name'.$lang]; ?>
		</div>
		<script src="<?=$mobile_url; ?>/js/TouchSlide.1.1.js"></script>
		<!-- banner主要代码 Start ================================ -->
		<div id="tabBox1" class="banner">
			<div class="hd" style="display: none;">
				<ul></ul>
			</div>
			<div class="bd" id="tabBox1-bd">
					<?php for($i=0;$i<5;$i++){
	                    if(!is_file($site_root_path.$product_row['PicPath_'.$i]))continue;
	                ?>
	                <div class="con">
						<ul>
							<li style="text-align:center;"><img src="<?=str_replace('s_', '', $product_row['PicPath_'.$i]); ?>" /></li>
						</ul>
					</div>
					<?php } ?>
			</div>
		</div>
		<script type="text/javascript">
			TouchSlide( { slideCell:"#tabBox1",

				endFun:function(i){ //高度自适应
					var bd = document.getElementById("tabBox1-bd");
					bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
					if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
				}

			} );
		</script>
		<div class="products_description">
		<form action="/cart.php?module=add&SupplierId=<?=$SupplierId?>&ProId=<?=$ProId?>&Qty=<?=$product_row['StartFrom']; ?>" class="post_cart_list" method="post" >
			<div class="name"><?=$product_row['Name'.$lang]; ?></div>
			<div class="desc"><?=$product_row['BriefDescription'.$lang]; ?></div>
			<!--<div class="price">
				<del class="price_0">$<?=$product_row['Price_0']; ?></del>
				<div class="price_1">USD$ <?=$product_row['Price_1']; ?></div>
			</div>-->
			<?php 

				if($isbl == '0'){
					$isbl_price = 'pesos';
				}else{
					$isbl_price = 'USD$';
				}

			?>
			<div class="mt over-flow">
				<span class="desc_th topb" style="line-height: 16px;">
					<?=$website_language['goods'.$lang]['price']; ?><?=$website_language['products'.$lang]['de_word']; ?><?=$website_language['goods'.$lang]['wholesale_1']; ?> :&nbsp; <?=$isbl_price?> <?=$product_row['Price_1']; ?>
				</span>
				<br />
				<?php 
					if($goods_row[$i]['Qty']){?>
						<div class="divSale_1">
							<span><?=$product_row['StartFrom']; ?></span>+<br />
							<span class="colorPrice">USD$ <?=$product_row['Price_1']; ?></span>
						</div>
					<?php }else{
					for($i=0; $i<count($goods_row); $i++){?>
						<?php if(count($goods_row)!== 1){?>
						<div class="divSale">
							<span><?=$goods_row[$i]['Qty']; ?></span>+<br />
							<span class="colorPrice">$<?=$goods_row[$i]['Price']; ?></span>
						</div>
					<?php }else{?>
						<div class="divSale_1">
							<span><?=$goods_row[$i]['Qty']; ?></span>+<br />
							<span class="colorPrice">$<?=$goods_row[$i]['Price']; ?></span>
						</div>
					<?php }}}?>
			</div>
			<div class="moq">
				<span class="tit"><?=$website_language['goods'.$lang]['moq']; ?> :</span>
				<span class="con"><?=$product_row['StartFrom']; ?>&nbsp;&nbsp;<?=$ContactUs_language['Mer_Info'.$lang]['piece']; ?></span>
			</div>

		<?php if($isbl == '0'){?>
			<div>
				<span><?=$website_language['manage'.$lang]['order_17']; ?> :</span>
				<span style="color:#ff0036" class="con"><?=$product_row['MinTime']?>&nbsp;<?=$website_language['manage'.$lang]['time']; ?></span>
			</div>
			<div style="margin-top:3%">
				<span><?=$ContactUs_language['Mer_Info'.$lang]['Small_order']; ?>  :</span>
				<span style="color:#ff0036" class="con">

				<?php 
						if($product_row['MinOrder'] == '0'){
							$min_order = $website_language['manage'.$lang]['order_16'];
						}else{
							$min_order = $website_language['manage'.$lang]['order_15'];
						}
					?>
					<?=$min_order?>

				</span>
			</div>
			<div style="margin-top:3%">
				<span><?=$website_language['manage'.$lang]['order_18']; ?> :</span>
				<span style="color:#ff0036" class="con">pesos:&nbsp;<?=$product_row['MinPace']?></span>
			</div>
			<br>

		<?php }else{?>
			<div class="qty">
				<span class="tit"><?=$website_language['goods'.$lang]['qty']; ?> :</span>
				<div class="con">
					<div class="qty_from">
						<span class="del" onclick="Qty.del();">-</span>
						<input type="text" id="Qty" name="Qty"  onchange="Qty.chang(this);" maq="<?=$product_row['StartFrom']; ?>" value="<?=$product_row['StartFrom']; ?>"   />
						<span class="add" onclick="Qty.add();">+</span>
					</div>
				</div>
			</div>
			
			<div class="mt topb over-flow">
				<span class="desc_th labColor" style="line-height: 16px;">
					<?=$website_language['goods'.$lang]['transport']; ?> <br /> <?=$website_language['goods'.$lang]['mode']; ?> :
				</span>
				<div minday="8" maxday="10" class="transport transportClick"><?=$website_language['goods'.$lang]['air_transport']; ?></div>
				<div minday="42" maxday="45" class="transport"><?=$website_language['goods'.$lang]['shipping']; ?></div>
			</div>
			<div class="mt topb over-flow">
				<span class="desc_th labColor"><?=$website_language['goods'.$lang]['transport']; ?> :</span>
				<div class="delivery">
					<label class="deliveryClick" id="deliveryClick">
						<?=$website_language['goods'.$lang]['delivery']; ?> 
						<label class="fine"><?=$website_language['goods'.$lang]['arrive']; ?></label>
						<?=$website_language['goods'.$lang]['mexico']; ?>
					</label>
				</div>
				<div class="day">
					<?=$website_language['goods'.$lang]['edd']; ?>:
					<label id="minday">8</label>
					-
					<label id="maxday">10</label>
					<?=$website_language['goods'.$lang]['day']; ?>
					<div class="question" id="question">?</div>
				</div>
				<div class="deliveryTips" id="deliveryTips">
					<?=$website_language['goods'.$lang]['tips']; ?>
				</div>
			</div>

		<?php }?>

			<?php if($isbl == '0'){?>

				<div class="buy">
					<input id="inputSubmit" style="border:0px;background:#2271dc;color:#fff;border-radius:5px;padding:5px" type="button" value="<?=$ContactUs_language['Mer_Info'.$lang]['Contact_merchant']; ?>">
				</div>
			<?php }else{?>
				<div class="buy" style="position:relative;width:100%;margin-top: 30px;">
					<input id="a" style="position:absolute;left:0;top:0;width:1rem;height: 0.73rem;border-radius: 6px;" type="submit" name="mysubmit" value="1">
					<span id="b" style="width:113px;float:left;border-radius: 4px;display:inline-block;padding-left:10px;padding-right:15px;height: 0.73rem;position:absolute;left:0;top:0;border:1px solid red;text-align:center;z-index:10;background:red;text-align: center;line-height: 0.73rem;color:#fff;font-size: 0.3rem;"><?=$website_language['goods'.$lang]['buy_now_1']?></span>

					<button id="e" class="addtocart AddToCart" style="border:0px;width:140px;float:left;margin-top:0%;margin-left:42%;height: 40px;border-radius: 6px;" type="button" name="mysubmit" value="0"><?=$website_language['cart'.$lang]['lang_14']?></button>
				</div>
				<div style="clear: both;"></div>
				<input type="hidden" name="ProId" value="<?=$ProId; ?>">
				
				<input type="hidden" name="SupplierId" value="<?=$SupplierId; ?>">
			<?php }?>
		</form>
			<iframe id="addcartiframe" name="addcartiframe" src="" style="display:none;"></iframe>
		</div>
		<div class="goods_title">
			<div class="top"></div>
			<div class="bottom"><?=$website_language['goods'.$lang]['description']; ?></div>
		</div>
		<div class="goods_description">
			<?=$product_description_row['Description'.$lang]; ?>
		</div>
		<div class="goods_view hide"><?=$website_language['goods'.$lang]['view_all']; ?></div>
		<div class="goods_title">
			<div class="top"></div>
			<div class="bottom"><?=$website_language['goods'.$lang]['shopping_cost']; ?></div>
		</div>
		<div class="goods_description">
			<?=$db->get_value('article','Num=5 and SupplierId='.$SupplierId,'Contents'.$lang); ?>
		</div>
		<div class="goods_view hide"><?=$website_language['goods'.$lang]['view_all']; ?></div>
		<div class="goods_title">
			<div class="top"></div>
			<div class="bottom"><?=$website_language['goods'.$lang]['faqs']; ?></div>
		</div>
		<div class="goods_description">
			<?=$db->get_value('article','Num=6 and SupplierId='.$SupplierId,'Contents'.$lang); ?>
		</div>
		<div class="goods_view hide"><?=$website_language['goods'.$lang]['view_all']; ?></div>
		<div class="goods_title">
			<div class="top"></div>
			<div class="bottom"><?=$website_language['products'.$lang]['related']; ?></div>
		</div>
		<div class="relation_products">
			<?php 
			$related_product_row = $db->get_limit('product','IsHot=1 and SupplierId='.$SupplierId.$mCfg_product_where,'*','MyOrder desc,ProId desc',0,6);
			foreach((array)$related_product_row as $k=>$v){ 
				$name = $v['Name'.$lang];
				$img = $v['PicPath_0'];
				$url = $mobile_url.get_url('product',$v);
				$price = $v['Price_1'];
				?>
				<div class="list">
					<a href="<?=$url; ?>" class="pic" title="<?=$name; ?>"><img src="<?=$img; ?>" alt=""></a>
					<a href="<?=$url; ?>" class="name" title="<?=$name; ?>"><?=$name; ?></a>
					<div class="price">USD$ <?=$price; ?></div>
				</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
	
<?php if($isbl == '0'){?>
		<div id="inputSubmit1" class="float_addtocart"  style="background:#2271dc;color:#fff;border-radius:5px;padding:5px">
		<?=$ContactUs_language['Mer_Info'.$lang]['Contact_merchant']; ?>
			
		</div>
<?php }else{?>
		
		<div id="c" class="float_addtocart" style="width: 50%;z-index: 99;">
		<?=$website_language['goods'.$lang]['buy_now_1']; ?>
		</div>

		<div id="d" class="float_addtocart" style="width: 50%;float: left;margin-left: 50%;z-index: 99;">
		<?=$website_language['cart'.$lang]['lang_14']?>
			
		</div>
			
		
<?php }?>
	</div>
	<div style="height: 0.9rem;"></div>
	<div id="goods_inquiry" class="hide">
	<div class="background" onclick="$(this).parent().hide();"></div>
	<?php 
		include("$site_root_path/inc/lib/product/inquire_form_en.php"); 
	?>
</div>
	<?php //include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
</body>
</html>
<script>
$("#b").click(function(){
		$("#a").click();
	})
$("#c").click(function(){
		$("#a").click();
	})
$("#d").click(function(){
		$("#e").click();
	})

	$('.goods_description').each(function(index){
		if(($('.goods_description').eq(index).width()/$('.goods_description').eq(index).height())<2){
			$('.goods_description').eq(index).css('height',$('.goods_description').eq(index).width()/2);
			$('.goods_description').eq(index).next('.goods_view').show();
		}
	});
	$('.goods_view').click(function(){
		$(this).prev('.goods_description').css('height','auto');
		$(this).hide();
	});
	$('.goods_description *').attr('width','').attr('height','').css({'width':'auto','height':'auto'});

	//产品询盘
	$("#inputSubmit").click(function(){
		window.location.href="articler.php?SupplierId=<?=$SupplierId; ?>&AId=<?=$db->get_value('article','Num=2 and SupplierId='.$SupplierId,'AId'); ?>";
	});
	$('#inputSubmit1').click(function(){
		window.location.href="articler.php?SupplierId=<?=$SupplierId; ?>&AId=<?=$db->get_value('article','Num=2 and SupplierId='.$SupplierId,'AId'); ?>";
	})
	$('.AddToCart').click(function(){
		$('.post_cart_list').submit();
	});
    var Qty = {
    	'maq':$('#Qty').attr('maq'),
    	add:function(){
    		var qty = parseInt($('#Qty').val());
    		qty++;
    		if(qty<this.maq){
    			qty=this.maq;
    		}
    		$('#Qty').val(qty);
    	},
    	del:function(){
    		var qty = parseInt($('#Qty').val());
    		qty--;
    		if(qty<this.maq){
    			qty=this.maq;
    		}
    		$('#Qty').val(qty);
    	},
    	chang:function(item){
    		var qty = parseInt($(item).val());
    		qty = parseInt(qty);
    		if(qty<this.maq || !qty){
    			qty=this.maq;
    		}
    		$(item).val(qty);
    	}
    }
    
    $(document).ready(function(){
    	$(".divSale").click(function(){
	    	$(".divSale").attr("class","divSale")
	    	$(this).attr("class","divSale saleClick");
	    	$("#Qty").val($(this).children()[0].innerHTML);
	    });
	    
	    $(".transport").click(function(){
	    	$(".transport").attr("class","transport");
	    	$(this).attr("class","transport transportClick");
	    	$("#minday").html($(this).attr("minday"));
	    	$("#maxday").html($(this).attr("maxday"));
	    });
	    
	    $("#question").click(function(){
	    	$("#deliveryTips").toggle();
	    });
	    
    })
</script>
<!-- Live800在线客服图标:默认图标[浮动图标]开始-->
<div style='display:none;'>< a href=' '>网页聊天</ a></div><script language="javascript" src="http://chat.live800.com/live800/chatClient/floatButton.js?jid=5513164191&companyID=846315&configID=126818&codeType=custom"></script><div style='display:none;'>< a href='http://en.live800.com'>live chat</ a></div>
<!-- 在线客服图标:默认图标结束-->
<div style='display:none;'><a href='http://www.live800.com'>客服系统</a></div>