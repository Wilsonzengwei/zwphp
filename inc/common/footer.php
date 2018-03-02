<?php
	echo '<link rel="stylesheet" href="/css/common/footer'.$lang.'.css">'
?>
<div class="clear"></div>
<div class="footer">
	<div class="Bot">
		<div class="Bot_Subscribestyle">
			<div class="Subscribestyle_txt">订阅</div>
			<div class="Btn_mask"><input class="Btn_mask_text" type="text" placeholder="请输入您的电子邮箱"><input class="Btn_mask_submit" type="submit" value="订阅"></div>
			<div class="Btn_mask_down">立即订阅，更多优惠等着您！</div>
		</div>
		<div class="Btn_txtnm">
			<a class="Btn_txt1"><?=$website_language['footer'.$lang]['xszn']?></a>
			<a class="Btn_txt2 ieidk" data='18' href="/help.php?AId=18"><?=$website_language['footer'.$lang]['khzclc']?></a>
			<a class="Btn_txt2 ieidk" data='19' href="/help.php?AId=19"><?=$website_language['footer'.$lang]['sjzclc']?></a>
			<a class="Btn_txt2 ieidk" data='20' href="/help.php?AId=20"><?=$website_language['footer'.$lang]['ehzclc']?></a>		
			<a class="Btn_txt2 ieidk" data='30' href="/help.php?AId=30"><?=$website_language['footer'.$lang]['gmlc']?></a>	
		</div>
		<div class="Btn_txt">
			<a class="Btn_txt1"><?=$website_language['footer'.$lang]['gywm']?></a>
			<a class="Btn_txt2 ieidk" data='28' href="/help.php?AId=28"><?=$website_language['footer'.$lang]['gywm']?></a>
			<a class="Btn_txt2 ieidk" data='29' href="/help.php?AId=29"><?=$website_language['footer'.$lang]['lxwm']?></a>		
		</div>
		<div class="Btn_txt">
			<a class="Btn_txt1"><?=$website_language['footer'.$lang]['cjwt']?></a>
			<a class="Btn_txt2 ieidk" data='22' href="/help.php?AId=22"><?=$website_language['footer'.$lang]['khwt']?></a>
			<a class="Btn_txt2 ieidk" data='23' href="/help.php?AId=23"><?=$website_language['footer'.$lang]['sjwt']?></a>			
		</div>
		<div class="QR_code">
			<div class="QR_code_txt"><?=$website_language['footer'.$lang]['wxgzh']?></div>
			<div class="QR_code_img">
				<img src="/images/header/QRCode.png" alt="">
			</div>		
		</div>
	</div>
	<div class="footer_y"><?=$website_language['index'.$lang]['wb']?></div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$('.ieidk').click(function(){
		var val=$(this).attr('data'); 	
 		window.sessionStorage.setItem('vals',val);
	})
</script>
</body>
</html>