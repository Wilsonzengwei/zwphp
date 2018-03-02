<?php
	
?>
<?php
	echo '<link rel="stylesheet" href="/css/member/login'.$lang.'.css">'
?>
	<div class="box">
		<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""></div>
		<div class="content">
			<div class="jd">
				<img src="images/login/login_tupian.jpg" alt="">
				<div class="login_mask">
					<form action="account.php?module=login" method="">
						<div class="login_box">
							<div class="login_title"><?=$website_language['ylfy'.$lang]['dl']; ?></div>
							<div class="in"><label><i  style="background:url(/images/login/username_bg.png);" class="username"></i></label><input class="loinput usernamet"  placeholder='<?=$website_language['user_index'.$lang]['yhm']; ?>' type="text"><div class="clear"></div></div>
							<div class="in"><label><i  style="background:url(/images/login/password_bg.png);" class="username"></i></label><input class="loinput passwordt"  placeholder='<?=$website_language['ylfy'.$lang]['mm']; ?>' type="password"><div class="clear"></div></div>
							<div class="error hiai"><label><i style="background:url(/images/login/error_bg.jpg);" class="username1"></i></label><input class="loinput2" disabled="disabled" value="登入名和密码不能为空" type="text"><a href="/account.php?module=forgot&act=1&select=0" class="username2"><?=$website_language['ylfy'.$lang]['wjmm']; ?></a><div class="clear"></div></div>
							<input class="login" value="<?=$website_language['ylfy'.$lang]['dl']; ?>" type="button">						
							<div>
								<a href="/account.php?module=forgot&act=1&select=0" class="username_left"><?=$website_language['ylfy'.$lang]['wjmm']; ?></a>
								<a href="/account.php?module=create&act=1&select=0" class="username_right"><?=$website_language['ylfy'.$lang]['zczh']; ?></a>
								<div class="clear"></div>
							</div>
							<div class="fot">Version: 1.0</div>
						</div>
					</form>
				</div>		
			</div>			
		</div>
	</div>	
<script>
	$(function(){
	$(document).keydown(function() {
             if (event.keyCode == "13") {//keyCode=13是回车键
               $('.login').click();
             }
        });

	$('.login').click(function(){		
		var ac=$('.loinput2');
		var username=$('.usernamet').val();
		var password=$('.passwordt').val();		
		if(username=='' && password==''){
			$('.hiai').css('display','block');
			$('.login').css('margin-top','16px');
			$('.usernamet').focus();	
			ac.val("<?=$website_language['ylfy'.$lang]['dlmmmbk'];?>");
		}else if(password==''){
			$('.hiai').css('display','block');
			$('.login').css('margin-top','16px');
			$('.passwordt').focus();	
			ac.val("<?=$website_language['ylfy'.$lang]['mmbbwk']; ?>");
			return false;
		}else if(username==''){
			$('.hiai').css('display','block');
			$('.login').css('margin-top','16px');
			$('.usernamet').focus();	
			ac.val("<?=$website_language['ylfy'.$lang]['dlmbk']; ?>");
			return false;
		}else{
			$.get('/ajax/ajax_Login.php',{'act':'login','name':username,'password':password},function(data){
				if(data==0){					
					window.location.href="index.php"; 
				}else if(data==1){
					ac.val("<?=$website_language['ylfy'.$lang]['dlmmmcw']; ?>");
					$('.hiai').css('display','block');
					$('.login').css('margin-top','16px');
				}/*else if(data==2){
					ac.val('商户未审核,请耐心等待客服审核');
				}else if(data==3){
					ac.val('商户未通过审核,请联系客服了解更多信息');
				}	*/		
			});
		}
		
	})	
})	
</script>
