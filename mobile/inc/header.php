<script src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/lang/en.js"></script>
<script type="text/javascript" src="/js/global.js"></script>
<script type="text/javascript" src="/js/checkform.js"></script>
<script>
	var _w=$(window).width()>750?750:$(window).width();
	var font_size=_w/7.5;
	$('html').css('font-size',font_size+"px");
	$(window).resize(function(){
		_w=$(window).width()>750?750:$(window).width();
		font_size=_w/7.5;
		$('html').css('font-size',font_size+"px");
	});
</script> 
<div id="header">
	<div class="menu"></div>
	<div class="logo">
		<a href="<?=$mobile_url; ?>" class="img" title="home"><img src="/mobile/images/logo2.png" alt="home"></a>
	</div>
	<div class="h_right">
		<a href="javascript:void(0)" data="cn" id="cn" class="list set_lang" lang="cn">CN</a>
        <a href="javascript:void(0)" data="es" id="es" class="list set_lang" lang="sp">ES</a>
	</div>
	<div class="clear"></div>
	<?php if($page_name=='home'){ ?>
		<div class="search">
			<form action="<?=$mobile_url; ?>/products.php">
				<input type="text" class="input" name="Keyword" placeholder="<?=$website_language['head'.$lang]['placeholder']; ?>">
				<button class="button"></button>
				<div class="clear"></div>
			</form>
		</div>
	<?php } ?>
</div>
<div id="bg"></div>
<div id="float_menu">
	<div class="float_con">
		<div class="head">
			<a href="<?=$mobile_url; ?>/account.php" class="account"></a>
			<div class="acc_link">	
				<?php if($_SESSION['member_MemberId']){ ?>
					<a href="<?=$mobile_url; ?>/account.php" class="link"><?=$_SESSION['member_Email']; ?></a>
					&nbsp;&nbsp;&nbsp;
					<a href="<?=$mobile_url; ?>/account.php?module=logout" class="link trans3"><?=$website_language['head'.$lang]['sign_out']; ?></a>
				<?php }else{ ?>
					<a href="<?=$mobile_url; ?>/account.php?module=create" class="link"><?=$website_language['head'.$lang]['registered']; ?></a>
					<?=$website_language['head'.$lang]['or']; ?>
					<a href="<?=$mobile_url; ?>/account.php" class="link"><?=$website_language['head'.$lang]['logn_in']; ?></a>
				<?php } ?>
			</div>
		</div>
		<div class="nav_list">
			<a href="<?=$mobile_url; ?>" class="list" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php" class="list" title="<?=$website_language['head'.$lang]['all_category']; ?>"><?=$website_language['head'.$lang]['all_category']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php?pro_type=1" class="list" title="<?=$website_language['nav'.$lang]['type_1']; ?>"><?=$website_language['nav'.$lang]['type_1']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php?pro_type=2" class="list" title="<?=$website_language['nav'.$lang]['type_2']; ?>"><?=$website_language['nav'.$lang]['type_2']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php?pro_type=3" class="list" title="<?=$website_language['nav'.$lang]['type_3']; ?>"><?=$website_language['nav'.$lang]['type_3']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php?pro_type=4" class="list" title="<?=$website_language['nav'.$lang]['type_4']; ?>"><?=$website_language['nav'.$lang]['type_4']; ?></a>
			<a href="<?=$mobile_url; ?>/products.php?pro_type=5" class="list" title="<?=$website_language['nav'.$lang]['type_5']; ?>"><?=$website_language['nav'.$lang]['type_5']; ?></a>
            <a href="/account.php?module=orders" class="list">我的订单</a>
            <a href="<?=$mobile_url; ?>/cart.php" class="list"><?=$website_language['head'.$lang]['cart']; ?></a>			
		</div>
		<script>
            $('.set_lang').click(function(){            	            	
                var lang = $(this).attr('lang');
                var data = $(this).attr('data');
                window.sessionStorage.setItem("data",data);
                $.post('/',{'set_lang':lang},function(){
                    location=location;                    
                });
            });
            $(function(){
            	var data_1=window.sessionStorage.getItem("data");
                    if(data_1=='cn'){
                    	$("#cn").css("border","1px solid #ec6400").css("color","#ec6400");
                    }else{
                    	$("#es").css("border","1px solid #ec6400").css("color","#ec6400");
                    }
            })
        </script>
	</div>
</div>
<script>
	$('#header .menu').click(function(){
		$('#bg,#float_menu').show();
	});
	$('#bg').click(function(){
		$('#bg,#float_menu').hide();
	});
</script>
