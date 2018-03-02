<?php 
	if($_POST['enter'] == 'username'){
		if($_POST['choice'] == '1'){
			$Email = $_POST['Email'];
			$_SESSION['Nmember_Email']=$Email;
			if($db->get_one("member","Email='$Email'")){
				$mail_contents = '<a href="'.get_domain().'/account.php?method=Email&module=forgot&act=2&Email='.$Email.'">重置密码</a>';
				include($site_root_path.'/inc/lib/mail/template.php');
				//smtp_mail($Email,'Welcome to '.get_domain(), $mail_contents,"", "",$Supplier_Name2);
				sendmail($Email, '1', 'Welcome to '.get_domain(), $mail_contents);
				header("Location: account.php?module=forgot&act=4&method=Email");
				exit;
			}else{
				echo '<script>alert("邮箱未在本网站注册请确认邮箱号码是否正确");history.go(-1);</script>';
				exit;
			}
		}elseif($_POST['choice'] == '2'){

			$Supplier_Mobile = $_POST['Supplier_Mobile'];
			//var_dump($Supplier_Mobile);exit;
			if($db->get_one("member","Supplier_Mobile='$Supplier_Mobile'")){
				/*$mail_contents = '<a href="'.get_domain().'/account.php?method=Email&module=forgot&act=2&Email='.$Email.'">重置密码</a>';
				include($site_root_path.'/inc/lib/mail/template.php');
				//smtp_mail($Email,'Welcome to '.get_domain(), $mail_contents,"", "",$Supplier_Name2);
				sendmail('2350371871@qq.com', '1', 'Welcome to '.get_domain(), $mail_contents);*/
				header("Location: account.php?module=forgot&act=2&method=Mobile&Mobile=".$Supplier_Mobile);
				exit;
			}else{
				echo '<script>alert("手机未在本网站注册请确认手机号码是否正确");history.go(-1);</script>';
				exit;
			}
		}

	}
	if($_POST['enter'] == 'uppassword'){
		if($_POST['Xmethod'] == 'Email'){
			$Email = $_POST['Xmethod_c'];
			$_SESSION['Xmethod_c'] = $Email;
			$password = password($_POST['password']);
			$vpassword = password($_POST['vpassword']);
			if($vpassword !== $password){
				echo '<script>alert("新密码与确认密码不一致");history.go(-1);</script>';
				exit;
			}
			$db->update("member","Email='$Email'",array(
					"Password"	=> $password,
				));
			header("Location: account.php?module=forgot&act=3&Xmethod_c=".$Email);
				exit;
		}elseif($_POST['Xmethod'] == 'Mobile'){
			$Mobile = $_POST['Xmethod_c'];
			$_SESSION['Xmethod_c'] = $Mobile;
			$password = password($_POST['password']);
			$db->update("member","Supplier_Mobile='$Mobile'",array(
					"Password"	=> $password,
				));
			header("Location: account.php?module=forgot&act=3&Xmethod_c=".$Mobile);
				exit;
		}else{
			echo '<script>alert("请不要进行非法操作");</script>';
			header("Location: account.php?module=forgot&act=1");
			exit;
		}
	}
	if($_GET['mode'] == 'new_Email'){
		$Email = $_GET['Email'];
		$mail_contents = '<a href="'.get_domain().'/account.php?method=Email&module=forgot&act=2&Email='.$Email.'">重置密码</a>';
				include($site_root_path.'/inc/lib/mail/template.php');
		smtp_mail($Email,'Welcome to '.get_domain(), $mail_contents,"", "",$Supplier_Name2);
		//sendmail($Email, '1', 'Welcome to '.get_domain(), $mail_contents);
		header("Location: account.php?module=forgot&act=4&method=Email");
		exit;
	}
if($_POST['login'] == 'login_form'){

	header("Location: account.php?module=login");
	exit;
}
?>
<?php
	echo '<link rel="stylesheet" href="/css/member/forgot'.$lang.'.css">'
?>
<?php 
if($_GET['act']== '1'){
?>
<div class="box">
	<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['forgot'.$lang]['czmm']?></div>	
	<form action="account.php?module=forgot&act=1" method="post">
		<div class="action_box1">
			<div class="box_mask1"></div>				
		</div>			
		<div class="content">					
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['yzfs']?></span>：
						<select class="select_txt" name="choice" id="Choice">
							<option value="1"><?=$website_language['forgot'.$lang]['yzcyx']?></option>
							<option value="2"><?=$website_language['forgot'.$lang]['ybdsj']?></option>							
						</select>
				</div>
				<div style="display:none" class="b">
					<div class="row">
						<span class="title"><span class="yhh">*</span>区号</span>：
							<select class="select_txt" id='districtNumber' name="">
								<option value="0086">0086 中国</option>
								<option value="0052">0052 墨西哥</option>
							</select>
					</div>
					<div class="row_cn">
						<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['sjhm']?></span>：
						<input class="input_txt2 txt" type="text" placeholder='<?=$website_language['forgot'.$lang]['qsrndsjhm']?>'  value="" name="Supplier_Mobile" id="mobile">
						<input type="button" id='btn' value="<?=$website_language['forgot'.$lang]['fsyzm']?>">
					</div>
					<div class="row">
						<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['yzm']?></span>：
						<input class="input_txt txt" type="text" placeholder='<?=$website_language['forgot'.$lang]['qsryzm']?>'  value="" name="" id="identifyingCode">
					</div>
				</div>
				<div class="a">
					<div class="row">
						<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['dzyx']?></span>：
						<input class="input_txt txt" class="email" type="text" placeholder='<?=$website_language['forgot'.$lang]['qsryx']?>'  value="" name="Email" id="email1">
					</div>					
				</div>					
				<div class="row">
					<div class='xybleft'>
						<input type="hidden" name="enter" value="username">
						<input id="submit1" class="submit_txt hover" type="submit" value="下一步">
					</div>								
				</div>
		</div>	
	</form>		
</div>
<script>
	$(function(){
		$('#Choice').change(function(){
			if($(this).val()=='1'){
				$('.a').css('display','block');
				$('.b').css('display','none');
			}else if($(this).val()=='2'){
				$('.a').css('display','none');
				$('.b').css('display','block');
			}
		})
		window.localStorage.setItem('error','3');

	$('.txt').each(function(){
    	$(this).blur(function(){
    		if($(this).val()==''){
    			$(this).css('border','1px solid red');
    			window.localStorage.setItem('error','1');
    		}else{
    			$(this).css('border','1px solid #ccc');
    			window.localStorage.removeItem('error','2');
    		}
    	})
    }) 
	  
		document.getElementById("mobile").onkeyup=function(){
	   			if(!/^\d+$/.test(this.value)) {
	   			 this.value=this.value.replace(/[^\d]+/g,'')
	   			}
	  		 }

    var a=120;
    var timer="";
    var districtNumber=$("#districtNumber").val();
        var mobile=$("#mobile").val();
        var creLit1 = "<?=$website_language['member_lang_1']['create']['cre_lit1']; ?>";
    var creLit2 = "<?=$website_language['member_lang_1']['create']['cre_lit2']; ?>";
    var PleCode = "<?=$website_language['member_lang_1']['create']['Ple_code']; ?>";
 	var pleas = "<?=$website_language['member_lang_1']['create']['pleas']; ?>";
 	var Afterwards = "<?=$website_language['member_lang_1']['create']['Afterwards']; ?>";
 	var Reacquire = "<?=$website_language['member_lang_1']['create']['Reacquire']; ?>";
 	var Phone_veri_1 = "<?=$website_language['member_lang_1']['create']['Phone_veri_1']; ?>";
 	var Get_code = "<?=$website_language['member_lang_1']['create']['Get_code']; ?>";
 	var Enter_code_1 = "<?=$website_language['member_lang_1']['create']['Enter_code_1']; ?>";
 	var Enter_code_2 = "<?=$website_language['member_lang_1']['create']['Enter_code_2']; ?>";
 	var Enter_code_3 = "<?=$website_language['member_lang_1']['create']['Enter_code_3']; ?>";
      $("#btn").click(function(){
          var districtNumber=$("#districtNumber").val();
          var mobile=$("#mobile").val();
          var Area_code = "<?=$website_language['member_lang_1']['create']['Area_code']; ?>";
          if(districtNumber==''){
          	alert(PleCode);
          	$("#districtNumberTxt").html(PleCode);
          	$("#districtNumberTxt").addClass("error");
          	return false;
          }else{
          	$("#districtNumberTxt").removeClass("error");
          	$("#districtNumberTxt").css("color","green");
          	$("#districtNumberTxt").html("");
          	
          }
         
          if(mobile.length<10){
          	alert(Phone_veri_1);
          	return false;
          }
          var c=Math.floor(Math.random()*10000000).toString(16);
          if(c.length<6){
            return c+"[0-9]" || c+"[a-z]" || c+"[A-Z]";
          }
          $(this).attr("disabled","true");      
        timer=setInterval(function(){
          for(var i=0;i<1;i++){
            a--;
            $("#btn").val(pleas+a+"s"+Afterwards+Reacquire);
          if(a==0){
            a=120;
            window.localStorage.setItem("验证码",''); 
            clearInterval(timer);
            $('#btn').removeAttr('disabled');
            $("#btn").val('发送验证码');           	
            }          
          } 
        },1000)
        window.localStorage.setItem("验证码",c);         
      $.ajax({
          type:"POST",
          url:"/inc/lib/member/module/regajax.php",
          data:{
              districtNumber:districtNumber,           
              mobile:mobile,
              identifyingcode:c,
              content:creLit1+c+creLit2,
          },             
          success:function(data){          	
              console.log(data);
          },
          error:function(data){
             // console.log("调用失败");
          }
      })      
    })
      $("#btn2").click(function(){     
          var email1=$("#email1").val();
          var Area_code = "<?=$website_language['member_lang_1']['create']['Area_code']; ?>";        
         
          if(email1.length>16){
          	alert(Phone_veri_1);
          	return false;
          }
          var c=Math.floor(Math.random()*10000000).toString(16);
          if(c.length<6){
            return c+"[0-9]" || c+"[a-z]" || c+"[A-Z]";
          }
          $(this).attr("disabled","true");      
        timer=setInterval(function(){
          for(var i=0;i<1;i++){
            a--;
            $("#btn").val(pleas+a+"s"+Afterwards+Reacquire);
          if(a==0){
            a=120;
            window.localStorage.setItem("验证码",''); 
            clearInterval(timer);
            $('#btn').removeAttr('disabled');
            $("#btn").val('发送验证码');           	
            }          
          } 
        },1000)
        window.localStorage.setItem("验证码",c);         
      $.ajax({
          type:"POST",
          url:"/inc/lib/member/module/regajax.php",
          data:{
              districtNumber:districtNumber,           
              mobile:mobile,
              identifyingcode:c,
              content:creLit1+c+creLit2,
          },             
          success:function(data){          	
              console.log(data);
          },
          error:function(data){
             // console.log("调用失败");
          }
      })      
    })
       $('#submit1').click(function(){
       	if($('#Choice').val()=='1'){
       		var email=$("#email1").val();
			 if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
		  	{
		   		alert("<?=$website_language['ylfy'.$lang]['gsbzq']; ?>");
		   		return false;
		  	}
       	}
	 	else if($('#Choice').val()=='2'){
	 		var b=window.localStorage.getItem("验证码");
	   		if($("#identifyingCode").val()!=b){
   			alert("请输入正确验证码");
      		return false;      		
	   		}
	 	}
		
    	var get=window.localStorage.getItem('error');    	
    	if(get==1 | get==3){      		
    		return false;
    	}
    })
})
</script>
<?php }elseif($_GET['act']=='2'){?>
<?php
	if($_GET['method'] == "Email"){
		$Xmethod = "Email";
		$Xmethod_c = $_GET['Email'];
	}elseif($_GET['method'] == "Mobile"){
		$Xmethod = "Mobile";
		$Xmethod_c = $_GET['Mobile'];
	}else{
		echo '<script>alert("请不要进行非法操作");</script>';
			header("Refresh:0;url=account.php?module=forgot&act=1");
			exit;
	}
?>
<div class="box">
	<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['forgot'.$lang]['czmm']?></div>	
	<form action="account.php?module=forgot&act=2" method="post">
		<div class="action_box1">
			<div class="box_mask2"></div>				
		</div>
		<div class="content">
			<div class="row">
				<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['srmm']?></span>：
				<input class="input_txt txt yhe2" type="password" placeholder='<?=$website_language['forgot'.$lang]['qsrxmm']?>'  value="" name="password">
				<div class="redtext yhe2t"></div>
			</div>
			<div class="row">
				<span class="title"><span class="yhh">*</span><?=$website_language['forgot'.$lang]['qrmm']?></span>：
				<input class="input_txt txt yhe3" type="password" placeholder='<?=$website_language['forgot'.$lang]['qqrxmm']?>'  value="" name="vpassword">
				<div class="redtext yhe3t"></div>
			</div>
			<div class="row">
				<div  class='xybleft'>
					<input type="hidden" name="enter" value="uppassword">
					<input type="hidden" name="Xmethod" value="<?=$Xmethod?>">
					<input type="hidden" name="Xmethod_c" value="<?=$Xmethod_c?>">
					<input id="submit2" class="submit_txt hover" type="submit" value="<?=$website_language['forgot'.$lang]['xyb']?>">
				</div>								
			</div>
		</div>
		>
	</form>
</div>
<script>
	window.localStorage.setItem('error','3');
	$('.yhe3').blur(function(){
		if($(this).val()!=$('.yhe2').val()){
			$('.yhe3t').text('两次输入密码不一致');
		}else{
			$('.yhe3t').text('');
		}
	})
	$('.txt').each(function(){
    	$(this).blur(function(){
    		if($(this).val()==''){
    			$(this).css('border','1px solid red');
    			window.localStorage.setItem('error','1');
    		}else{
    			$(this).css('border','1px solid #ccc');
    			window.localStorage.removeItem('error','2');
    		}
    	})
    }) 
    function bjl(c1,c2,txt1,txt2,txt3){
    	$(c1).blur(function(){
    		if($(this).val()==''){
	    		$(c1).text(txt1);
		    	return false;	    	
		    }else if($(c1).val().length<8){
	    		$(c2).text(txt2);
	    		return false;
		    }else if($(c1).val().length>23){
		    	$(c2).text(txt3);
		    }else{	    
	   			$(c2).text('');
	   		}
    	})    	
	}
	bjl('.yhe2','.yhe2t',"<?=$website_language['ylfy'.$lang]['mmbbwk']; ?>","<?=$website_language['ylfy'.$lang]['mmcdx16']; ?>","<?=$website_language['ylfy'.$lang]['mmcdd23']; ?>");	
	$('#submit2').click(function(){
		if($('.redtext').text()!=''){
			$('.redtext').focus();
			return false;
		}
		if($('.yhe3').val()==''){
			$('.yhe3').focus();
			return false;
		}
		var get=window.localStorage.getItem('error');    	
    	if(get==1 | get==3){ 
    		$('.txt').css('border','1px solid red');     		
    		return false;
    	}
	})
</script>
<?php }elseif($_GET['act']=='3'){?>
<?php 
if(!$_GET['Xmethod_c'] || !$_SESSION['Xmethod_c']){
if($_GET['Xmethod_c'] !== $_SESSION['Xmethod_c']){

	echo '<script>alert("请不要进行非法操作");</script>';
	header("Refresh:0;url=account.php?module=forgot&act=1");
	exit;
}
echo '<script>alert("请不要进行非法操作");</script>';
	header("Refresh:0;url=account.php?module=forgot&act=1");
	exit;
}
?>
<div class="box">
	<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['forgot'.$lang]['czmm']?></div>	
	<form action="account.php?module=forgot&act=3" method="post">
		<div class="action_box1">
			<div class="box_mask3"></div>				
		</div>
		<div class="content">
			<div style="width:60px;height:60px;float:left;background:url(/images/create/Exactly.png)"></div>
			<div style="width:350px;float:left;margin-top:20px;margin-left:50px">
				<div class="row_copy1">
					<div class="row_title2"><?=$website_language['forgot'.$lang]['ycxsz']?></div>
				</div>
				
				<div class="row2">
					<div style="width:20px;height:20px;float:left">
						<input type="hidden" name="login" value="login_form">
						<input id='submit2' class="submit_txt2 hover" type="submit" value="<?=$website_language['forgot'.$lang]['ljdl']?>">
					</div>								
				</div>
			</div>				
		</div>
	</form>
</div>
<?php }elseif($_GET['act']=='4'){?>
<?PHP 
$email = $_SESSION['Nmember_Email'];
?>
<div class="box">
	<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['forgot'.$lang]['czmm']?></div>	
	<form action="account.php?module=forgot&act=1" method="post">
		<div class="action_box1">
			<div class="box_mask4"></div>				
		</div>
	<div class="content2" style="width:700px;margin:auto;overflow:hidden;height:200px;border-bottom:1px solid #ccc">
			<div class="row_copy">
				<div class="row_title"><?=$website_language['forgot'.$lang]['zhmmbz']?></div>
			</div>
			<div class="row3">1. <?=$website_language['create'.$lang]['qdlnd']?><d><?=$email?></d><?=$website_language['ylfy'.$lang]['yxck']?></div>
			<div class="row3">2. <?=$website_language['create'.$lang]['bz2']?><d>“<?=$website_language['forgot'.$lang]['czmm']?>”</d><?=$website_language['ylfy'.$lang]['jhzh']?></div>
			<div class="row3">3. <?=$website_language['ylfy'.$lang]['rrwsdyj']?><d><a href="/account.php?module=forgot&act=4&mode=new_Email&Email=<?=$email?>">“<?=$website_language['forgot'.$lang]['cxfs']?>”</a></d>。</div>
		</div>
	</form>
</div>
<?php }?>