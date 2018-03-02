<?php
$query_string=query_string(array('forgot_success', 'forgot_fail'));

/*if($_POST['data']=='member_forgot'){
	$Email=$_POST['Email'];
	$user_row=$db->get_one('member', "Email='$Email'");
	
	if($user_row){
		$EmailEncode=base64_encode($user_row['Email']);
		$Expiry=base64_encode(rand_code(15));
		$fullname=$user_row['FirstName'].' '.$user_row['LastName'];
		
		if(!$db->get_row_count('member_forgot', "MemberId='{$user_row['MemberId']}' and IsReset=0")){
			$db->insert('member_forgot', array(
					'MemberId'		=>	$user_row['MemberId'],
					'EmailEncode'	=>	$EmailEncode,
					'Expiry'		=>	$Expiry,
					'ResetTime'		=>	$service_time
				)
			);
		}else{
			$db->update('member_forgot', "MemberId='{$user_row['MemberId']}' and IsReset=0", array(
					'EmailEncode'	=>	$EmailEncode,
					'Expiry'		=>	$Expiry,
					'ResetTime'		=>	$service_time
				)
			);
		}
		
		include($site_root_path.'/inc/lib/mail/forgot_password.php');
		include($site_root_path.'/inc/lib/mail/template.php');
		sendmail($user_row['Email'], $fullname, get_domain(0).' Password Recovery', $mail_contents);
		
		$_SESSION['forgot_post']='';
		unset($_SESSION['forgot_post']);
		
		js_location("$member_url?forgot_success=1&$query_string");
	}else{
		$_SESSION['forgot_post']=$_POST;
		js_location("$member_url?forgot_fail=1&$query_string");
	}
}

if($_POST['data']=='member_reset_password'){
	$Password=password($_POST['Password']);
	$email=$_POST['email'];
	$expiry=$_POST['expiry'];
	
	$user_row=$db->get_one('member_forgot', "EmailEncode='$email' and Expiry='$expiry' and IsReset=0");
	!$user_row && js_location('/');
	
	$db->update('member', "MemberId='{$user_row['MemberId']}'", array(
			'Password'	=>	$Password
		)
	);
	$db->update('member_forgot', "FId='{$user_row['FId']}'", array(
			'IsReset'	=>	1
		)
	);
	
	js_location("$member_url?reset_success=1&$query_string");
}*/
if($_POST['act'] == 'mobile_ver'){
	
	if($_POST['myselect'] == '0'){
		$email = $_POST['myEmail'];
		$myname = $_POST['myname'];
		$user_row=$db->get_one('member', "Email='$email'");
		$fullname=$user_row['FirstName'].' '.$user_row['LastName'];
		//var_dump($email);exit;
		if(!$db->get_one('member',"Email='$email'")){
			echo "<script>alert('".$website_language['manage'.$lang]['forget_1']."')</script>";
			header("refresh:0;url=account.php?module=forgot&act=1&select=0");
			exit;		
		}
		if(!$db->get_one('member',"Email='$email' and Supplier_Name2='$myname'")){
			echo "<script>alert('".$website_language['manage'.$lang]['forget_2']."')</script>";
			header("refresh:0;url=account.php?module=forgot&act=1&select=0");
			exit;
		}
		$EmailEncode=base64_encode($user_row['Email']);
		$Expiry=base64_encode(rand_code(15));
		include($site_root_path.'/inc/lib/mail/forgot_password.php');
		include($site_root_path.'/inc/lib/mail/template.php');
		sendmail($user_row['Email'], $fullname, get_domain(0).' Password Recovery', $mail_contents);
		//var_dump($fullname);exit;
		header("refresh:0;url=account.php?module=forgot&act=4");
		//header("refresh:0;url=account.php?module=forgot&act=2&email=$email&myname=$myname&method=email");
	}
	if($_POST['myselect'] == '1'){
		$mymobile = $_POST['mymobile'];
		$myname = $_POST['myname'];
		if(!$db->get_one('member',"Supplier_Mobile='$mymobile'")){
			echo "<script>alert('".$website_language['manage'.$lang]['forget_3']."')</script>";
			header("refresh:0;url=account.php?module=forgot&act=1&select=1");
			exit;		
		}
		if(!$db->get_one('member',"Supplier_Mobile='$mymobile' and Supplier_Name2='$myname'")){
			echo "<script>alert('".$website_language['manage'.$lang]['forget_4']."')</script>";
			header("refresh:0;url=account.php?module=forgot&act=1&select=1");
			exit;
		}
		header("refresh:0;url=account.php?module=forgot&act=2&mymobile=$mymobile&myname=$myname&method=mobile");
	}
}
$method = $_GET['method'];
if($method == 'mobile'){
	$mymobile = $_GET['mymobile'];
	$myname = $_GET['myname'];
}elseif($method == 'email'){
	$mymobile = $_GET['email'];
	$myname = $_GET['myname'];
}
if($_POST['method'] == 'mobile'){
	$mypass = $_POST['mypass'];
	$mypass_2 = $_POST['mypass_2'];
	$mymobile = $_POST['mymobile'];
	$myname = $_POST['myname'];
	//var_dump($mypass_2.'   2     '.$mypass);exit;
	if($mypass == $mypass_2){
		$Password=password($mypass);
		$db->update('member',"Supplier_Mobile='$mymobile' and Supplier_Name2='$myname'",array(
				'Password' => $Password
			));
	}

	//echo "<script>alert('修改成功')</script>";
	header("refresh:0;url=account.php?module=forgot&act=3");
}elseif($_POST['method'] == 'email'){
	$mypass = $_POST['mypass'];
	$mypass_2 = $_POST['mypass_2'];
	$mymobile = base64_decode($_POST['mymobile']);
	$myname = $_POST['myname'];
	//var_dump($mymobile);exit;
	if($mypass == $mypass_2){
		$Password=password($mypass);
		$db->update('member',"Email='$mymobile' and Supplier_Name2='$myname'",array(
				'Password' => $Password
			));
	}

	//echo "<script>alert('修改成功')</script>";
	header("refresh:0;url=account.php?module=forgot&act=3");
}
$email=$_GET['email'];
$expiry=$_GET['expiry'];
?>
<link rel="stylesheet" href="/css/bootstrap.css">
<script src="/js/alertMobile.js"></script>
<style>
	#radius>span{
		display:inline-block;
		width:30%;height:7px;
		background:#ccc;
		margin-top:15px
	}
	
	#formtest span{
		display:inline-block;
		width:30%;
		height:20px;
		text-align:right;
		font-size:10px;
		color:#999;
	}
	#formFillIn span{
		display:inline-block;
		width:30%;
		height:20px;
		text-align:right;
		font-size:10px;
		color:#999;
	}
	#formReset span{
		display:inline-block;
		width:30%;
		height:20px;
		margin-left:8%;
		text-align:right;
		font-size:10px;
		color:#999;
	}
	input{
		font-size: 5px;
		border:1px solid #ccc;
	}
	div,span,select{
		font-size: 10px;
	}
</style>
<?php if($_GET['act'] == '1'){?>
<div style="width:100%;height:400px;background:#fff" class="container">
<div class="row" style="font-size:15px;margin-left:10px"><?=$website_language['member'.$lang]['forgot']['title']; ?></div>
<div class="row">&nbsp;</div>
<div id="radius" style="width:100%;margin-left:10px;" class="row">
	<span id="s1" style="margin-left:1%"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">1</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_name1']; ?></p></span>
	<span id="s2"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight:bold;">2</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_pass']; ?></p></span>	
	<span id="s3"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">3</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Carry_out']; ?></p></span>
</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">	
	</div>
	<div style="width: 100%;margin-left: 10px;">
	<form style="width:100%;height:50%;" action="" name="user_form" id="formtest" method="post">

	<p><div class="row" style="width:100%;margin-left:3%">		
			<select id="Verification" style="height:25px;width:90%;border:1px solid #0090ff" name="myselect" id="">
				<option  class="aaaa" value="0" <?php //if($_GET['select'] == '0'){ echo "selected data='0'"; } ?>>&nbsp;<?=$website_language['member'.$lang]['forgot']['Ver_mai']; ?></option>
				<option  class="aaaa" value="1" <?php //if($_GET['select'] == '1'){ echo "selected data='1'"; } ?>>&nbsp;<?=$website_language['member'.$lang]['forgot']['Binded_phone']; ?></option>
			</select>			
		</div></p>
	<p><div id="VerificationMobile" class="row" style="width:100%;margin-left:3%">
			<input id="verificationTxt" placeholder="<?=$website_language['member'.$lang]['forgot']['Ver_mai']; ?>" style="height:25px;width:90%;" type="text" name="myEmail" >
		</div></p>	
	<p><div class="row" style="width:100%;margin-left:3%">
			<input style="height:25px;width:90%;" placeholder="<?=$website_language['member'.$lang]['other']['name']; ?>" type="text" name="myname" id="userName">
		</div></p>
	<p><div id="mobiletxt" class="row" style="width:100%;display:none;margin-left:3%">
			<input id="districtNumber" placeholder="<?=$website_language['member'.$lang]['create']['Area_code']; ?>" style="height:25px;width:90%;" type="text" name="" id="">
			<p><div style="width:100%;margin-left:0%" class="row">			
				<input style="width:90%;height:25px" id="mobile" placeholder="<?=$website_language['manage'.$lang]['tra_slat6']; ?>" style="height:25px;margin-top:-1%" type="text"  name="mymobile">				
			</div></p>	
			<div style="width:100%;margin-left:0%" class="row">
				<input id="btn" style="min-width:90%;background:#0090ff;color:#fff;height:25px;text-align:center;line-height:25px;border:1px solid #ccc;font-size:10px" type="button" value="<?=$website_language['member'.$lang]['create']['Get_code']; ?>">
			</div>		
		</div></p>	
	<p><div id="identifyingCodeT" class="row" style="width:100%;display:none;margin-left:3%">
		<input style="height:25px;width:90%;" id="identifyingCode" type="text" placeholder="<?=$website_language['member'.$lang]['create']['Enter_code']; ?>">
			
		</div></p>
	<p><div class="row" style="width:100%;margin-left:20%"><span><input type="hidden" name="act" value="mobile_ver"><input id="submit" style="height:25px;width:50%;text-align:center;line-height:25px;color:#fff;background:#0090ff;border:0px;" name="user_val" type="submit" value="<?=$website_language['manage'.$lang]['tra_slat86']; ?>"></span></div></p>	
	</form>	
	</div>
</div>
<script>
$(function(){    
   	var a=60;
    var timer="";
    var creLit1 = "<?=$website_language['member'.$lang]['create']['cre_lit1']; ?>";
    var creLit2 = "<?=$website_language['member'.$lang]['create']['cre_lit2']; ?>";
    var Ple_code = "<?=$website_language['member'.$lang]['create']['Ple_code']; ?>";
    var Phone_veri_1 = "<?=$website_language['member'.$lang]['create']['Phone_veri_1']; ?>";

 	var pleas = "<?=$website_language['member'.$lang]['create']['pleas']; ?>";
 	var Afterwards = "<?=$website_language['member'.$lang]['create']['Afterwards']; ?>";
 	var Reacquire = "<?=$website_language['member'.$lang]['create']['Reacquire']; ?>";
 	var Get_code = "<?=$website_language['member'.$lang]['create']['Get_code']; ?>";
 	var Ver_mai = "<?=$website_language['member'.$lang]['create']['Ver_mai']; ?>";
 	var Binded_phone = "<?=$website_language['member'.$lang]['forgot']['Binded_phone']; ?>";
 	var vcode = "<?=$website_language['member'.$lang]['login']['vcode']; ?>";
	var Enter_code_1 = "<?=$website_language['member'.$lang]['create']['Enter_code_1']; ?>";
	var name_tips = "<?=$website_language['member'.$lang]['other']['name_tips']; ?>";
	var Enter_code_2 = "<?=$website_language['member'.$lang]['create']['Enter_code_2']; ?>";
	var Enter_code_3 = "<?=$website_language['member'.$lang]['create']['Enter_code_3']; ?>";
	var placeholder = "<?=$website_language['foot'.$lang]['placeholder']; ?>";






      $("#btn").click(function(){
          var districtNumber=$("#districtNumber").val();
          var mobile=$("#mobile").val();
          var Area_code = "<?=$website_language['member'.$lang]['create']['Area_code']; ?>";
          if(districtNumber==''){
          	
          	alert(Ple_code);
          	
          	return false;
          }
         
          if(mobile.length<10){
          	alert(Phone_veri_1);
          	return false;
          }
          var c=Math.floor(Math.random()*1000000);
          if(c.length<6){
            return c+"[0-9]" ;
          }
          $(this).attr("disabled","true");      
        timer=setInterval(function(){
          for(var i=0;i<1;i++){
            a--;
            $("#btn").val(pleas+a+"s"+Afterwards+Reacquire);
          if(a==0){
            a=60;
            clearInterval(timer);
            $('#btn').removeAttr('disabled')
            $("#btn").val(Get_code);           	
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
		$("#Verification").change(function(){
			window.sessionStorage.removeItem("flash");
				if($(this).val()==0){
				$("#VerificationMobile span:eq(0)").html(Ver_mai+":");
				$("#mobiletxt,#identifyingCodeT").css("display","none");
				$("#VerificationMobile").css("display","block");
				$("#s1").each(function(){
				$(this).css("background","#ec6400");
				$(this).children("div").css("background","#ec6400");
				})
				$("#radius span:eq(0)").siblings("span").each(function(){
					$(this).css("background","#ccc");
					$(this).children("div").css("background","#ccc");
				})	
							
			}
				else if($(this).val()==1){
				$("#VerificationMobile").css("display","none");
				$("#VerificationMobile span:eq(0)").html(Binded_phone);
				$("#mobiletxt,#identifyingCodeT").css("display","block");
				$("#s1").each(function(){
				$(this).css("background","#ec6400");
				$(this).children("div").css("background","#ec6400");
				})
				$("#radius span:eq(0)").siblings("span").each(function(){
					$(this).css("background","#ccc");
					$(this).children("div").css("background","#ccc");
				})
				
				// $("#mobile").blur(function(){
				// 	$.ajax({
				// 		type:"get",
				// 		url:"",
				// 		data:{
				// 			act:"userName"
				// 		},
				// 		success:function(data){
				// 			alert(data);
				// 		},
				// 		error:function(){
				// 			alert("错误");
				// 		}
				// 	})
					
				// })			
			}
		})
		$("#s1").each(function(){
			$(this).css("background","#ec6400");
			$(this).children("div").css("background","#ec6400");
		})
		$("#submit").click(function(){
		if($("#Verification").val()==1){
			var b=window.localStorage.getItem(vcode);
	   	if($("#identifyingCode").val()==b){
	   		$("#identifyingCodeTxt").html(Enter_code_1);
	   		$("#identifyingCodeTxt").css("display","inline-block");
	      	$("#identifyingCodeTxt").css("color","green");	      		
	   }else{
	   		if($("#userName").val()==""){
				alert(name_tips);
				return false;
			}		
	      	$("#identifyingCodeTxt").html(Enter_code_2);
	      	$("#identifyingCodeTxt").css("display","inline-block");
	      	$("#identifyingCodeTxt").css("color","red");
	      	alert(Enter_code_3);
	      	$("#identifyingCode").val("");
	      	return false;	      	
	   }
	   if($("#userName").val()==""){
				alert(name_tips);
				return false;
			}	
	}else if($("#Verification").val()==0){
			if($("#verificationTxt").val()==""){
			alert(placeholder);
			return false;
			}
			if($("#userName").val()==""){
				alert(name_tips);
				return false;
			}		
	}	
		})	
		$("#AreaCode").click(function(){
			$(this).val("");
		})
		$("#phonetext").click(function(){
			$(this).val("");
		})
		// $("#verificationTxt").blur(function(){
		// 	$.ajax({
		// 		type:"get",
		// 		url:"",
		// 		data:{
		// 			act:"userName"
		// 		},
		// 		success:function(data){
		// 			alert(data);
		// 		},
		// 		error:function(){
		// 			alert("错误");
		// 		}
		// 	})
		// 	alert(1);
		// })
	})
</script>
<?php }elseif($_GET['act'] == '2'){?>
<div style="width:100%;height:400px;background:#fff" class="container">
<div class="row" style="font-size:15px;margin-left:10px"><?=$website_language['member'.$lang]['forgot']['title']; ?></div>
<div class="row">&nbsp;</div>
<div id="radius" style="width:100%;margin-left:10px;" class="row">
	<span id="s1" style="margin-left:1%"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">1</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_name1']; ?></p></span>
	<span id="s2"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight:bold;">2</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_pass']; ?></p></span>	
	<span id="s3"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">3</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Carry_out']; ?></p></span>
</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">	
</div>

	<form action="" name="pas_form" id="formReset" method="post">	
		<div id="ResetVerificationMobile" class="row" style="width:100%;margin-left:10%">
			<input id="ResetverificationTxt" placeholder="<?=$website_language['member'.$lang]['forgot']['Plea_pass']; ?>" style="height:25px;width:80%;" type="password" name="mypass" >
			<div style="margin-left:1%" id="ResetverificationTxtDiv">&nbsp;</div>
		</div>	
		<div class="row" style="width:100%;margin-top: 10px;margin-left:10%">
			<input id="ResetverificationTxtConfirm" placeholder="<?=$website_language['member'.$lang]['create']['pwd_tips']; ?>" style="height:25px;width:80%;" type="password" name="mypass_2">
			<div style="margin-left:1%" id="ResetverificationTxtConfirmDiv">&nbsp;</div>
		</div>	
		<div class="row" style="width:100%;margin-left:20%"><span><input type="hidden" name="act" value="password_val"><input type="hidden" name="myname" value="<?=$myname?>"><input type="hidden" name="method" value="<?=$method?>"><input type="hidden" name="mymobile" value="<?=$mymobile?>"><input id="Reset" style="height:25px;width:50%;text-align:center;line-height:25px;color:#fff;background:#0090ff;border:0px;margin-top: 10px;" type="submit" name="pas_val" value="<?=$website_language['manage'.$lang]['tra_slat86']?>"></span></div>
	</form>
</div>
<script>
		$(function(){	
		window.sessionStorage.setItem("flash","1");
		var bbb=window.sessionStorage.getItem("flash");
		if(bbb==1){
			$("#s1").each(function(){
				$(this).css("background","#ccc");
				$(this).children("div").css("background","#ccc");
			})
			$("#s2").each(function(){
				$(this).css("background","#ec6400");
				$(this).children("div").css("background","#ec6400");
			})
			$("#s3").each(function(){
				$(this).css("background","#ccc");
				$(this).children("div").css("background","#ccc");
			})
	}

		
		$("#ResetverificationTxt").blur(function(){	
			var aaaaa=$(this).val();
			if(aaaaa.length<7){
				$("#ResetverificationTxtDiv").html("<?=$website_language['manage'.$lang]['forget_5']?>");
				$("#ResetverificationTxtDiv").css("color","red");
				return false;
			}else{
				$("#ResetverificationTxtDiv").html("&nbsp;");
			}
		})
		$("#ResetverificationTxtConfirm").blur(function(){
			if($(this).val() != $("#ResetverificationTxt").val()){
				$("#ResetverificationTxtConfirmDiv").css("color","red");				
				$("#ResetverificationTxtConfirmDiv").html("<?=$website_language['member'.$lang]['forgot']['Password_is_consistent']; ?>");
				return false;
			}else if($(this).val() == $("#ResetverificationTxt").val()){
				$("#ResetverificationTxtConfirmDiv").html("&nbsp;");
			}
		})
		$("#Reset").click(function(){
			window.sessionStorage.setItem("flash","2");
			if($("#ResetverificationTxt").val()==""){
				alert("<?=$website_language['member'.$lang]['forgot']['password_blank']; ?>");
				return false;
			}
			if($("#ResetverificationTxt").val()!=$("#ResetverificationTxtConfirm").val()){
				alert("<?=$website_language['member'.$lang]['forgot']['Password_is_consistent']; ?>");
				return false;
			}
			var aaaaaa=$("#ResetverificationTxt").val();
			var bbbbbb=$("#ResetverificationTxtConfirm").val();
			if(aaaaaa.length<7){
				alert("<?=$website_language['manage'.$lang]['forget_5']?>");
				return false;
			}	
			if(bbbbbb.length<7){
				alert("<?=$website_language['manage'.$lang]['forget_5']?>");
				return false;
			}	
		})

	})
</script>
<?php }elseif($_GET['act'] == '3'){?>
<div style="width:100%;height:400px;background:#fff" class="container">
<div class="row" style="font-size:15px;margin-left:10px"><?=$website_language['member'.$lang]['forgot']['title']; ?></div>
<div class="row">&nbsp;</div>
<div id="radius" style="width:100%;margin-left:10px;" class="row">
	<span id="s1" style="margin-left:1%"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">1</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_name1']; ?></p></span>
	<span id="s2"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight:bold;">2</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Reset_pass']; ?></p></span>	
	<span id="s3"><div style="width:15px;height:15px;border-radius:15px;background:#ccc;margin-left:45%;margin-top:-4%;color:#fff;text-align: center;font-weight: bold;">3</div><p style="width:100%;height:50px;text-align:center;"><?=$website_language['member'.$lang]['forgot']['Carry_out']; ?></p></span>
</div>
<div class="row" style="width:83%;height:90%;margin-left:6%;margin-top:5%;text-align:center;font-size:14px">
	<div style="height:30%"></div>
		<?=$website_language['member'.$lang]['forgot']['con_pass']; ?>
	<div style="height:40%"></div>

</div>

</div>
<div style="width: 100%;height: 10%;position:absolute;bottom:0px;">
	<input id="Login" style="font-size:15px;height:100%;width:50%;text-align:center;color:#fff;background:#ec6400;border:1px solid #dd5f02;float: left;" type="button"  value="<?=$website_language['member'.$lang]['forgot']['Sign_in_now']; ?>">
	<input id="Index" style="font-size:15px;height:100%;width:50%;text-align:center;color:#fff;background:#ec6400;border:1px solid #dd5f02;float: right;" type="button"  value="<?=$website_language['member'.$lang]['login']['return']; ?>">
</div>
<script>
	$(function(){
		window.sessionStorage.setItem("flash","2");
		var ccc=window.sessionStorage.getItem("flash");
			if(ccc==2){
			$("#s1").each(function(){
				$(this).css("background","#fbe0cc");
				$(this).children("div").css("background","#fbe0cc");
			})
			$("#s2").each(function(){
				$(this).css("background","#fbe0cc");
				$(this).children("div").css("background","#fbe0cc");
			})
			$("#s3").each(function(){
				$(this).css("background","#ec6400");
				$(this).children("div").css("background","#ec6400");
			})
		}
		$("#Login").click(function(){
			window.location.href="account.php";
		})
		$("#Index").click(function(){
			window.location.href="index.php";
		})
	})
</script>
<?php }elseif($_GET['act'] == '4'){?>
	<div style="height:24px;border-bottom:1px solid #ddd;margin-left:1%;font-size:10px;font-weight:bold"><?=$website_language['member'.$lang]['forgot']['title']; ?></div>
	<div style="height:15px"></div>
	<div style="width:99%;height:40%;margin-left:1%;border:1px solid #ccc" class="container">
		<div style="padding:20px" class="row"><?=$website_language['member'.$lang]['forgot']['tips2']; ?>
		<div style="height:10%;"></div>
		<div style="font-size:10px;font-weight:bold;margin-top:10%"><?=$website_language['member'.$lang]['forgot']['tips3']; ?></div>
		<div style="margin-top:5%"><?=$website_language['member'.$lang]['forgot']['tips4']; ?></div>
		<div style="margin-top:5%;"><input id="Zindex" style="background:#505050;color:#fff;border:none;width:37.5%px;height:22px;margin-left:70%" type="button" value="Continue Shopping"></div>
		</div>		
	</div>
	<script>
	$(function(){
		$("#Zindex").click(function(){
			window.location.href="index.php";
		})
	})
	</script>
<?php }?>
<?php
$_SESSION['forgot_post']='';
unset($_SESSION['forgot_post']);
?>
<script>
	$(function(){
		$("input").css("outline","none");
	})
</script>
