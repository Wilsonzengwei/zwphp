<?php 
	$member_supplierid = $_GET['member_supplierid'];

?>
<div id="lib_cart_add_success">
	<!-- <div class="close"><img src="/images/lib/cart/close_button.jpg" /><a href="javascript:void(0);" onclick="close_cart_add_success();">Close</a></div> -->
	<div class="tips"><img src="/images/lib/cart/add_success.png" align="absmiddle" /> <?=$website_language['cart'.$lang]['lang_10']; ?></div>
	<div class="cart_info"><span><?=(int)$db->get_sum('shopping_cart', $where, 'Qty');?></span> <?=$website_language['cart'.$lang]['lang_13']; ?>: <span><?=iconv_price($db->get_sum('shopping_cart', $where, 'Qty*Price'));?></span></div>
	<div class="checkout">
	<a href="javascript:void(0);" onclick="close_cart_add_success();"><?=$website_language['cart'.$lang]['lang_11']; ?> </a>
	<a href="<?=$cart_url;?>?module=checkout&member_supplierid=<?=$member_supplierid?>"><?=$website_language['cart'.$lang]['lang_12']; ?> </a>
	</div>
</div>
<script language="javascript">
(function(){
	parent.div_mask();
	cart_add_success();
	<?php if($phone_client_agent){ ?>
		clearInterval(scroll_cart_add_success_timer);
	<?php } ?>
	parent.close_cart_add_success=function(){	//关闭弹出窗口
		window.top.document.body.removeChild(parent.$_('div_mask'));
		window.top.document.body.removeChild(parent.$_('lib_cart_add_success'));
		clearInterval(scroll_cart_add_success_timer);
	}
})()
</script>