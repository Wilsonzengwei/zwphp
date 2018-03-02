<?php 

if($_POST['act'] == 'set_username'){
	//var_dump("aaa");exit;
	$Email = $_POST['Email'];
	$Country = $_POST['Country'];
	$IsSupplier_on = $_POST['IsSupplier_on'];
	if($db->get_all('member',"Email='$Email'")){
		echo '<script>alert("邮箱号码已存在");history.go(-1);</script>';
		//header("Refresh:0;url=account.php?module=create&act=1");
		exit;
	}
	
	
	$MemberId=$db->get_insert_id();
	/*if($MemberId){
		echo '<script>alert("注册成功")</script>';
		header("Refresh:0;url=account.php?module=create&act=1");
		exit;
	}else{
		echo '<script>alert("注册失败")</script>';
		header("Refresh:0;url=account.php?module=create&act=1");
		exit;
	}*/
	$_SESSION['Nmember_Email']=$Email;
	$_SESSION['Nmember_MemberId']=$MemberId;
	$_SESSION['Nmember_IsSupplier_on']=$IsSupplier_on;
	$_SESSION['Nmember_Country']=$Country;
	header("Location: account.php?module=create&act=2");
	exit;
}
if($_POST['act'] == "userinfo"){
	$Email = $_POST['Email'];
	$MemberId = $_POST['MemberId'];
	$UserName = $_POST['UserName'];
	$Password = password($_POST['Password']);
	$VPassword = password($_POST['VPassword']);
	$FirstName = $_POST['FirstName'];
	$Supplier_Name = $_POST['Supplier_Name'];
	$Supplier_Company_Address = $_POST['Supplier_Company_Address'];
	$Supplier_Mobile = $_POST['Supplier_Mobile'];
	$Country = $_SESSION['Nmember_Country'];
	$IsSupplier_on = $_SESSION['Nmember_IsSupplier_on'];
	if(!$Email){
		echo '<script>alert("'.$website_language["ylfy".$lang]["zcsb"].'!!!!!");</script>';
		header("Refresh:0;url=account.php?module=create&act=1");
		//history.go(-1)禁止提交
		exit;
	}
	if($db->get_all('member',"UserName='$UserName'")){
		echo '<script>alert("'.$website_language["ylfy".$lang]["yhmycz"].'");history.go(-1);</script>';
		//header("Refresh:0;url=account.php?module=create&act=2");
		exit;
	}
	if($Password != $VPassword){
		echo '<script>alert("登入密码与确认密码不一致");history.go(-1);</script>';
		//header("Refresh:0;url=account.php?module=create&act=2");
		exit;
	}
	if($db->get_all('member',"Supplier_Name='$Supplier_Name'")){
		echo '<script>alert("'.$website_language["ylfy".$lang]["gsmcycz"].'");history.go(-1);</script>';
		//header("Refresh:0;url=account.php?module=create&act=2");
		exit;
	}
	if($db->get_all('member',"Supplier_Mobile='$Supplier_Mobile'")){
		echo '<script>alert("'.$website_language["ylfy".$lang]["sjhmycz"].'");history.go(-1);</script>';
		//header("Refresh:0;url=account.php?module=create&act=2");
		exit;
	}
	if($IsSupplier_on == '0'){
		$IsSupplier = '0';
		$Is_Business_License = '0';
	}elseif($IsSupplier_on == '1'){
		$IsSupplier = '1';
		$Is_Business_License = '1';
	}elseif($IsSupplier_on == '2'){
		$IsSupplier = '1';
		$Is_Business_License = '0';
	}
	$db->insert('member',array(
		'IsSupplier'				=>	$IsSupplier,
		'Is_Business_License'		=>	$Is_Business_License,
		'Supplier_Name'				=>	$Supplier_Name,
		'FirstName'					=>	$FirstName,
		'Email'						=>	$Email,
		'Password'					=>	$Password,
		'RegTime'					=>	$service_time,
		'RegIp'						=>	get_ip(),
		'LastLoginTime'				=>	$service_time,
		'LastLoginIp'				=>	get_ip(),
		'LoginTimes'				=>	1,
		'Supplier_Mobile'			=>	$Supplier_Mobile,
		'Supplier_Company_Address'	=>	$Supplier_Company_Address,
		'Level'						=>	1,
		'Country'					=>	$Country,
		'UserName'					=>	$UserName,
		));

	$db->insert('member_login_log', array(
			'MemberId'	=>	(int)$_SESSION['member_MemberId'],
			'LoginTime'	=>	$service_time,
			'LoginIp'	=>	get_ip()
		)
	);
	$_SESSION['Supplier_Name'] = $Supplier_Name;
	$mail_contents = '<a href="'.get_domain().'/account.php?method=Email&module=create&act=4&Email='.$Email.'">'.$website_language['member'.$lang]['create']['tips10'].'</a>';
	include($site_root_path.'/inc/lib/mail/template.php');
	//smtp_mail($Email,'Welcome to '.get_domain(), $mail_contents,"", "",$Supplier_Name2);
	sendmail($Email, $Supplier_Name, 'Welcome to '.get_domain(), $mail_contents);

	header("Location: account.php?module=create&act=3");
	exit;
}
if($_GET['method'] == 'Resend'){
	$Email = $_SESSION['Nmember_Email'];
	//var_dump($Email);exit;
	$Supplier_Name = $_SESSION['Supplier_Name'];
	$mail_contents = '<a href="'.get_domain().'/account.php?method=Email&module=create&act=4&Email='.$Email.'">'.$website_language['member'.$lang]['create']['tips10'].'</a>';
	include($site_root_path.'/inc/lib/mail/template.php');
	smtp_mail($Email,'Welcome to '.get_domain(), $mail_contents,"", "",$Supplier_Name);
	//sendmail($Email, $Supplier_Name2, 'Welcome to '.get_domain(), $mail_contents);
}

if($_GET['method'] == 'Email'){
	$Email = addslashes($_GET['Email']);
	if($member_row = $db->get_one('member',"Email='$Email' and IsConfirm=0")){
		$Confir_Email = 1;
		$db->update('member',"Email='$Email' and IsConfirm=0",array('IsConfirm'=>1));
		include($site_root_path.'/inc/lib/mail/create_account.php');
		include($site_root_path.'/inc/lib/mail/template.php');
		sendmail($member_row['Email'], $member_row['Supplier_Name'], 'Welcome to '.get_domain(), $mail_contents);
	}
}
if($_POST['login'] == 'login_form'){
	header("Location: account.php?module=login");
	exit;
}
?>
<?php
	echo '<link rel="stylesheet" href="/css/member/create'.$lang.'.css">'
?>

<?php 
if($_GET['act']== '1'){
?>
<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['ylfy'.$lang]['yhzc']?></div>	
	<form action="account.php?module=create&act=1" method="post">
		<div class="action_box">
			<div class="box_mask">
				<div class="waiwei">
					<div class="neiwei">
						<div class="radius">1</div>
					</div>
					<div class="name"><?=$website_language['create'.$lang]['szyhm']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">2</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['txzhxx']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">3</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['jhzh']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">4</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['zccg']?></div>
				</div>
			</div>				
		</div>	
		
		<div class="content">			
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['dzyx']?></span>：
					<input class="input_txt txt" class="email" type="text" placeholder='<?=$website_language['ylfy'.$lang]['qsryx']?>'  value="" name="Email" id="email1">
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['ylfy'.$lang]['ssgj']?></span>：
						<select class="select_txt" name="Country" >
							<?php 
								$country_area = $db->get_all("country_area","1");
								for ($i=0; $i <count($country_area) ; $i++) { 
									
							?>
									<option value="<?=$country_area[$i]['Id']?>"><?=$country_area[$i]['Country'.$lang]?></option>
							<?php }?>
						</select>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['zhlx']?></span>：
						<select class="select_txt2" name="IsSupplier_on" >
							<option value="0"><?=$website_language['create'.$lang]['pthy']?></option>
							<option value="1"><?=$website_language['create'.$lang]['ptsh']?></option>							
						</select>
				</div>
				<div class="row">
					<div class='inp'>
						<input id='hh' data="1" type="checkbox">
					</div>
					<div class="hie" style="height:40px;float:left;font-size:12px;color:#666;line-height:40px;overflow:hidden;border:1px solid #fff"><?=$website_language['create'.$lang]['cjjs']?><a target="_blank" href="/help.php?AId=15" class="xieyi" style="color:#2962ff">《<?=$website_language['create'.$lang]['xy']?>》</a></div>			
				</div>
				<div class="row">
					<div class='xybleft'>
						<input type="hidden" name="act" value="set_username">
						<input id="submit1" class="submit_txt hover" type="submit" value='<?=$website_language['create'.$lang]['xyb']?>'>
					</div>
								
				</div>
		</div>	
	</form>
		
	</div>	
<script>
$(function(){
	$('#hh').click(function(){
		if($(this).attr('data')=='1'){
			$(this).attr('data','2');
			$('.hie').css('border','1px solid #fff');
		}else if($(this).attr('data')=='2'){
			$(this).attr('data','1');
			$('.hie').css('border','1px solid #f00');
		}
	})

	$(".select_txt").change(function(){
		if($(this).val()==1){
			$('.select_txt2').html("<option value='0'>普通会员</option>"+""+"<option value='1'>普通商户</option>");
		}
		else if($(this).val()!=1){	
			$('.select_txt2').html("<option value='2'>EAGLE HOME</option>"+""+"<option value='0'>普通会员</option>");
			$('.xieyi').attr('href','/help.php?AId=17');
			window.sessionStorage.setItem('vals','17');
		}
	})
	window.sessionStorage.setItem('vals','15');
	$(".select_txt2").change(function(){
		if($(this).val()==0){	
			$('.xieyi').attr('href','/help.php?AId=15');
			window.sessionStorage.setItem('vals','15');
		}else if($(this).val()==1){				
			$('.xieyi').attr('href','/help.php?AId=16');
			window.sessionStorage.setItem('vals','16');
		}
		else if($(this).val()==2){					
			$('.xieyi').attr('href','/help.php?AId=17');
			window.sessionStorage.setItem('vals','17');
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
	 $('#submit1').click(function(){	 	
	 	var email=$("#email1").val();
	 	if(email==''){
	 		alert("邮箱号码不能为空");	
		   return false;
	 	}else if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
		{
		   alert("<?=$website_language['ylfy'.$lang]['gsbzq']; ?>");	
		   return false;
		}
		if($('#hh').attr('data')=='1'){
			$('.hie').css('border','1px solid red');
	 		return false;
	 	}
    	var get=window.localStorage.getItem('error');    	
    	if(get==1){    
    		alert(1);		
    		return false;
    	}else if(get==3){
    		return false;
    	}
    })	
})
</script>
<?php }elseif($_GET['act']=='2'){?>
<?php 
	$Email_s = $_SESSION['Nmember_Email'];
	$MemberId = $_SESSION['Nmember_MemberId'];
?>
<div class="box">
	<div class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['ylfy'.$lang]['yhzc']?></div>		
	<form action="account.php?module=create&act=2" method="post">
		<div class="action_box">
			<div class="box_mask">
				<div class="waiwei1">
					<div class="neiwei">
						<div class="radius1">1</div>
					</div>
					<div class="name"><?=$website_language['create'.$lang]['szyhm']?></div>
				</div>
				<div class="waiwei" >
					<div class="neiwei">
						<div class="radius" style="">2</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['txzhxx']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">3</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['jhzh']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">4</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['zccg']?></div>
				</div>
			</div>				
		</div>			
		<div class="content">			
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['dlm']?></span>：
					<input class="input_txt txt yhe1" type="text" placeholder='<?=$website_language['create'.$lang]['qsrnddlm']?>'  value="" name="UserName">
					<div class="redtext yhe1t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['dlmm']?></span>：
					<input class="input_txt txt yhe2" type="password" placeholder='<?=$website_language['create'.$lang]['qsrnddlmm']?>' value="" name="Password">
					<div class="redtext yhe2t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['qrmm']?></span>：
					<input class="input_txt txt yhe3" type="password" placeholder='<?=$website_language['create'.$lang]['qzcsrndmm']?>'  value="" name="VPassword">
					<div class="redtext yhe3t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['zsxm']?></span>：
					<input class="input_txt txt yhe4" type="text" placeholder='<?=$website_language['create'.$lang]['qsrndzsxm']?>'  value="" name="FirstName" >
					<div class="redtext yhe4t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['gsmc']?></span>：
					<input class="input_txt txt yhe5" type="text" placeholder='<?=$website_language['create'.$lang]['qsrndgsmc']?>'  value="" name="Supplier_Name" >
					<div class="redtext yhe5t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['lxdz']?></span>：
					<input class="input_txt txt yhe6" type="text" placeholder='<?=$website_language['create'.$lang]['qsrndlxdz']?>'  value="" name="Supplier_Company_Address" >
					<div class="redtext yhe6t"></div>
				</div>
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['gjqh']?></span>：
						<select class="select_txt" name="" id="districtNumber">
						<?php 
							$country_area = $db->get_all("country_area","1");
							for ($j=0; $j <count($country_area) ; $j++) { 
								
						?>
							<option value="<?='00'.$country_area[$j]['MobilePrefix']?>"><?='00'.$country_area[$j]['MobilePrefix']?> <?=$country_area[$j]['Country'.$lang]?></option>
						<?php }?>
						</select>
				</div>
				<div class="row_cn">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['sjhm']?></span>：
					<input class="input_txt2" type="text" placeholder='<?=$website_language['create'.$lang]['qsrndsjhm']?>'  value="" name="Supplier_Mobile" id="mobile">
					<input type="button" id='btn' value="<?=$website_language['create'.$lang]['fsyzm']?>">
				</div>				
				<div class="row">
					<span class="title"><span class="yhh">*</span><?=$website_language['create'.$lang]['yzm']?></span>：
					<input class="input_txt" type="text" placeholder='<?=$website_language['create'.$lang]['qsryzm']?>'  value="" name="" id="identifyingCode">
				</div>				
				<div class="row">
					<div class='xybleft'>
						<input type="hidden" name="act" value="userinfo">
						<input type="hidden" name="MemberId" value="<?=$MemberId?>">
						<input type="hidden" name="Email" value="<?=$Email_s?>">
						<input id='submit2' class="submit_txt hover" type="submit" value="<?=$website_language['create'.$lang]['xyb']?>">
					</div>								
				</div>
		</div>	
	</form>		
	</div>	
	<script>
		$(function(){
			$("input").css("outline","none");
	   document.getElementById("districtNumber").onkeyup=function(){
	   			if(!/^\d+$/.test(this.value)) {
	   				this.value=this.value.replace(/[^\d]+/g,'')
	   			}
	   }
		document.getElementById("mobile").onkeyup=function(){
	   			if(!/^\d+$/.test(this.value)) {
	   			 this.value=this.value.replace(/[^\d]+/g,'')
	   			}
	   }

    var a=120;
    var timer="";
    var districtNumber=$("#districtNumber").val();
        var mobile=$("#mobile").val();
        var creLit1 = "<?=$website_language['member'.$lang]['create']['cre_lit1']; ?>";
    var creLit2 = "<?=$website_language['member'.$lang]['create']['cre_lit2']; ?>";
    var PleCode = "<?=$website_language['member'.$lang]['create']['Ple_code']; ?>";
 	var pleas = "<?=$website_language['member'.$lang]['create']['pleas']; ?>";
 	var Afterwards = "<?=$website_language['member'.$lang]['create']['Afterwards']; ?>";
 	var Reacquire = "<?=$website_language['member'.$lang]['create']['Reacquire']; ?>";
 	var Phone_veri_1 = "<?=$website_language['member'.$lang]['create']['Phone_veri_1']; ?>";
 	var Get_code = "<?=$website_language['member'.$lang]['create']['Get_code']; ?>";
 	var Enter_code_1 = "<?=$website_language['member'.$lang]['create']['Enter_code_1']; ?>";
 	var Enter_code_2 = "<?=$website_language['member'.$lang]['create']['Enter_code_2']; ?>";
 	var Enter_code_3 = "<?=$website_language['member'.$lang]['create']['Enter_code_3']; ?>";
      $("#btn").click(function(){
          var districtNumber=$("#districtNumber").val();
          var mobile=$("#mobile").val();
          var Area_code = "<?=$website_language['member'.$lang]['create']['Area_code']; ?>";
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
          var c=Math.ceil(Math.random()*1000000);          
          if(c.length<6){
            return c+"[0-9]";
          }
          $(this).attr("disabled","true");      
        timer=setInterval(function(){
          for(var i=0;i<1;i++){
            a--;
            $("#btn").val(pleas+a+"s"+Afterwards+Reacquire);
          if(a==0){
            a=120;
            window.localStorage.setItem("yzm",''); 
            clearInterval(timer);
            $('#btn').removeAttr('disabled');
            $("#btn").val('<?=$website_language["create".$lang]["qsryzm"]?>');           	
            }          
          } 
        },1000)
        window.localStorage.setItem("yzm",c);         
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
	$('.yhe3').blur(function(){
		if($(this).val()!=$('.yhe2').val()){
			$('.yhe3t').text("<?=$website_language['ylfy'.$lang]['lcmmbyz']; ?>");
		}else{
			$('.yhe3t').text('');
		}
	})
    function bjl(c1,c2,txt1,txt2,txt3){
    	$(c1).blur(function(){
    		if($(this).val()==''){
	    		$(c2).text(txt1);
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
	function bjl2(c1,c2,txt1,txt2){
    	$(c1).blur(function(){
    		if($(this).val()==''){
	    		$(c2).text(txt1);
		    	return false;	    	
		    }else if($(c1).val().length>16){
	    		$(c2).text(txt2);
	    		return false;
		    }else{	    
	   			$(c2).text('');
	   		}
    	})    	
	}
	function bjl3(c1,c2,txt1){
    	$(c1).blur(function(){
    		if($(this).val()==''){
	    		$(c2).text(txt1);
		    	return false;	    	
		    }else{	    
	   			$(c2).text('');
	   		}
    	})    	
	}
	bjl2('.yhe1','.yhe1t',"<?=$website_language['ylfy'.$lang]['yhmbnwk'];?>","<?=$website_language['ylfy'.$lang]['yhmcd16']; ?>");
	bjl('.yhe2','.yhe2t',"<?=$website_language['ylfy'.$lang]['mmbbwk']; ?>","<?=$website_language['ylfy'.$lang]['mmcdx16']; ?>","<?=$website_language['ylfy'.$lang]['mmcdd23']; ?>");	
	bjl2('.yhe4','.yhe4t',"<?=$website_language['ylfy'.$lang]['zsxmbnwk'];?>","<?=$website_language['ylfy'.$lang]['zsxmcdd16']; ?>");
	bjl2('.yhe5','.yhe5t',"<?=$website_language['ylfy'.$lang]['gsmcbk']; ?>","<?=$website_language['ylfy'.$lang]['gsmcd16']; ?>");
	bjl3('.yhe6','.yhe6t',"<?=$website_language['ylfy'.$lang]['lxdzbk']; ?>");
    $('#submit2').click(function(){    
    	// var ps=$(".yhe2").val();
    	// var re=/^(?=.)(?=.*[a-z])(?=.*[0-9])[0-9a-z]*$/;
  //   	alert(re.test(ps));
		// if(re.test(ps))
		// {
		// 	$('.yhe2').text('密码必须是字母和数字');
		// }else{
		// 	$('.yhe2').text('密码必须是字母和数字');
		// }
    	if($('.redtext').text()!=''){
    		return false;
    	}
    	$('.input_txt').each(function(){
    		if($(this).val()==''){    		
    			$(this).focus();
    		}
    	})
    	var b=window.localStorage.getItem("yzm");
	   	if($("#identifyingCode").val()==b){
	   			$("#identifyingCodeTxt").html("<?=$website_language['member'.$lang]['create']['Enter_code_1']; ?>");
	      		$("#identifyingCodeTxt").addClass("success");	      		
	   	}else if($("#identifyingCode").val()!=b){
	      		$("#identifyingCodeTxt").html("<?=$website_language['member'.$lang]['create']['Enter_code_2']; ?>");
	      		$("#identifyingCodeTxt").addClass("error");
	      		alert("<?=$website_language['member'.$lang]['create']['Enter_code_3']; ?>");
	      		return false;	      	
	    }
	   
	    
	   
    	var get=window.localStorage.getItem('error');    	
    	if(get==1){    				
    		return false;
    	}else if(get==3){
    		return false;
    	}
    })
})
	</script>
<?php }elseif($_GET['act']=='3'){?>
<?php 
	$Email_s = $_SESSION['Nmember_Email'];
	$MemberId = $_SESSION['Nmember_MemberId'];

?>
	<div class="box">
	<div class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['ylfy'.$lang]['yhzc']?></div>	
	<form action="account.php?module=create&act=2" method="post">
		<div class="action_box">
			<div class="box_mask">
				<div class="waiwei1">
					<div class="neiwei">
						<div class="radius1">1</div>
					</div>
					<div class="name"><?=$website_language['create'.$lang]['szyhm']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">2</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['txzhxx']?></div>
				</div>
				<div class="waiwei" >
					<div class="neiwei">
						<div class="radius" style="">3</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['jhzh']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">4</div>
					</div>
					<div  class="name1" style=""><?=$website_language['create'.$lang]['zccg']?></div>
				</div>
			</div>				
		</div>		
		<div class="content2">
			<div class="row_copy">
				<div class="row_title"><?=$website_language['create'.$lang]['yxbz']?></div>
			</div>
			<div class="row2"><?=$website_language['create'.$lang]['bz1']?><d>"<?=$website_language['create'.$lang]['zhjhyj']?>"</d><?=$website_language['create'.$lang]['dndyx']?>，<?=$website_language['create'.$lang]['qdlnd']?><d><?=$Email_s?></d><?=$website_language['ylfy'.$lang]['yxck']?></div>
			<div class="row2"><?=$website_language['create'.$lang]['bz2']?><d>“<?=$website_language['ylfy'.$lang]['djjh']?>”</d><?=$website_language['ylfy'.$lang]['jhzh']?></div>
		</div>
		<div class="content3" style="">
			<div class="row_copy">
				<div class="row_title2"><?=$website_language['create'.$lang]['msdyj']?></div>
			</div>
			<div class="row3"><?=$website_language['create'.$lang]['sdpk']?></div>
			<div class="row3"><?=$website_language['create'.$lang]['zzk']?></div>
			<div class="row3"><?=$website_language['create'.$lang]['zh']?><a href='/account.php?module=create&act=3&method=Resend&Email=<?=$Email_s?>' class="yx"><?=$website_language['ylfy'.$lang]['cxfsyj']?></a></div>
			<div class="row3"><?=$website_language['create'.$lang]['qjc']?><a class="yx" href='/account.php?module=create&act=2'><?=$website_language['ylfy'.$lang]['cxtx']?></a></div>
		</div>
		</form>
	</div>
<?php }elseif($_GET['act']=='4'){?>
<div  class="header"><img class="header_img" src="images/index/logo.png" alt=""><?=$website_language['ylfy'.$lang]['yhzc']?></div>	
<form method="post" action="account.php?module=create&act=4">
	<div class="action_box">
			<div class="box_mask">
				<div class="waiwei1">
					<div class="neiwei">
						<div class="radius1">1</div>
					</div>
					<div class="name"><?=$website_language['create'.$lang]['szyhm']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">2</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['txzhxx']?></div>
				</div>
				<div class="waiwei1" >
					<div class="neiwei">
						<div class="radius1" style="">2</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['jhzh']?></div>
				</div>
				<div class="waiwei" >
					<div class="neiwei">
						<div class="radius" style="">2</div>
					</div>
					<div  class="name" style=""><?=$website_language['create'.$lang]['zccg']?></div>
				</div>
			</div>				
		</div>
		<div class="content">
			<div style="width:60px;height:60px;float:left;background:url(/images/create/Exactly.png);margin-top:40px"></div>
			<div style="width:350px;float:left;margin-top:20px;margin-left:50px">
				<div class="row_copy1">
					<div class="row_title2"><?=$website_language['create'.$lang]['gx']?></div>
				</div>
				<div class="row_yx" style="color:#666;font-size:12px"><?=$website_language['create'.$lang]['nddlm']?><d><?=$_GET['Email']?></d> ，<?=$website_language['create'.$lang]['qlj']?></div>
				<div class="row">
					<div style="width:20px;height:20px;float:left">
						<input type="hidden" name="login" value="login_form">
						<input id='submit2' class="submit_txt2 hover" type="submit" value="<?=$website_language['create'.$lang]['ljdl']?>">
					</div>								
				</div>
			</div>				
		</div>

</form>
<?php }?>