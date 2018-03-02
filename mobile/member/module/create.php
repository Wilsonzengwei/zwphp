<?php
$query_string=query_string('create_fail');
include($site_root_path.'/inc/manage/config/1.php');
if($_POST['data']=='file_img'){
	//iframe 上传营业执照
	$save_dir = '/tmp/';
	$tmp_path = up_file($_FILES['Business_License'],$save_dir);
	echo '<script>window.parent.document.getElementById("Business_License").value="'.$tmp_path.'";window.parent.document.getElementById("Business_License_Img").innerHTML="<img src=\''.$tmp_path.'\' />";</script>';
	exit;
}
if($_POST['data']=='member_create'){
	//上传营业执照开始
	$Business_License=ltrim($_POST['Business_License'],'/tmp/');
		if($_POST['member_type'] == '2'){
		if($Business_License ==''){
			echo "<script>alert('".$website_language['member'.$lang]['other']['business_license_tips']."')</script>";

			header("refresh:0;url=/account.php?module=create&cre_act=2");
			exit;
		}
	}
	if($_POST['member_type'] == '2'){
		if($Business_License ==''){
			echo "<script>alert('".$website_language['member'.$lang]['other']['business_license_tips']."')</script>";

			header("refresh:0;url=/account.php?module=create&cre_act=3");
			exit;
		}
	}
	$save_dir = '/u_file/'.date('ym',time()).'/user/';
	mk_dir($save_dir);
	@rename($site_root_path.$_POST['Business_License'],$site_root_path.$save_dir.$Business_License);
	//上传营业执照结束
	$Business_License = $save_dir.$Business_License;

	$Title=$_POST['Title'];
	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$Email=$_POST['Email'];
	$Password=password($_POST['Password']);
	$AddressLine1=$_POST['AddressLine1'];
	$AddressLine2=$_POST['AddressLine2'];
	$City=$_POST['City'];
	$State=$_POST['State'];
	$Country=$_POST['Country'];
	$PostalCode=$_POST['PostalCode'];
	$Phone=$_POST['Phone'];
	$Supplier_Name2=$_POST['Supplier_Name2'];
	$Supplier_Phone=$_POST['Supplier_Phone'];
	$Supplier_Address=$_POST['Supplier_Address'.$lang];
	$Supplier_Mobile=$_POST['Supplier_Mobile'];
	$Supplier_Company_Address=$_POST['Supplier_Company_Address'];
	$Supplier_Pay_Number=$_POST['Supplier_Pay_Number'];
	$Supplier_Main_Products=$_POST['Supplier_Main_Products'];
	$IsSupplier=(int)$_POST['IsSupplier'];
	if($IsSupplier == '1'){
		$Is_Business_License='1';
	}elseif($IsSupplier == '2'){
		$Is_Business_License='0';
	}
	
	$jump_url=substr($_GET['jump_url'], 0, 1)!='/'?"$mobile_url$member_url?module=index":$_GET['jump_url'];
	
	// var_dump($_POST);exit;
	($Email=='' || $Password=='' || preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $Email)==false) && js_location($jump_url);	//关键信息空的话不允许提交
	if(!$db->get_row_count('member', "Email='$Email'")){
		$data = array(
			'Title'			=>	$Title,
			'Is_Business_License'	=>	$Is_Business_License,
			'FirstName'		=>	$FirstName,
			'LastName'		=>	$LastName,
			'Supplier_Name2'		=>	$Supplier_Name2,
			'Supplier_Phone'		=>	$Supplier_Phone,
			'Supplier_Address'.$lang	=>	$Supplier_Address,
			'Supplier_Mobile'		=>	$Supplier_Mobile,
			'Business_License'		=>	$Business_License,
			'Supplier_Company_Address'		=>	$Supplier_Company_Address,
			'Supplier_Pay_Number'		=>	$Supplier_Pay_Number,
			'Supplier_Main_Products'		=>	$Supplier_Main_Products,
			'Email'			=>	$Email,
			'Password'		=>	$Password,
			'RegTime'		=>	$service_time,
			'RegIp'			=>	get_ip(),
			'LastLoginTime'	=>	$service_time,
			'LastLoginIp'	=>	get_ip(),
			'LoginTimes'	=>	1,
		);
		if($IsSupplier){
			$data['IsSupplier'] = 1;
			$data['IsUse'] = 0;
		}else{
			$data['IsSupplier'] = 0;
			$data['IsUse'] = 1;
		}

		$db->insert('member',$data);

		$MemberId=$db->get_insert_id();
		$mail_contents = '<a href="'.get_domain().'/account.php?module=confirm_email&Email='.$Email.'">'.$website_language['member'.$lang]['login']['tips10'].'</a>';
		include($site_root_path.'/inc/lib/mail/template.php');
		sendmail($Email, $Supplier_Name2, 'Welcome to '.get_domain(), $mail_contents);
		if($IsSupplier){
			js_location("$mobile_url$member_url?create_fail=2&$query_string");
		}
		
		js_location("$member_url?fail=4");
		exit;
		//AddressType: 0(shipping address) 1(billing address)
		// $db->insert('member_address_book', array(
		// 		'MemberId'		=>	$MemberId,
		// 		'Title'			=>	$Title,
		// 		'FirstName'		=>	$FirstName,
		// 		'LastName'		=>	$LastName,
		// 		'AddressLine1'	=>	$AddressLine1,
		// 		'AddressLine2'	=>	$AddressLine2,
		// 		'City'			=>	$City,
		// 		'State'			=>	$State,
		// 		'Country'		=>	$Country,
		// 		'PostalCode'	=>	$PostalCode,
		// 		'Phone'			=>	$Phone,
		// 		'AddressType'	=>	0,
		// 		'IsDefault'		=>	1
		// 	)
		// );
		
		// $db->insert('member_address_book', array(
		// 		'MemberId'		=>	$MemberId,
		// 		'Title'			=>	$Title,
		// 		'FirstName'		=>	$FirstName,
		// 		'LastName'		=>	$LastName,
		// 		'AddressLine1'	=>	$AddressLine1,
		// 		'AddressLine2'	=>	$AddressLine2,
		// 		'City'			=>	$City,
		// 		'State'			=>	$State,
		// 		'Country'		=>	$Country,
		// 		'PostalCode'	=>	$PostalCode,
		// 		'Phone'			=>	$Phone,
		// 		'AddressType'	=>	1
		// 	)
		// );
		
		$_SESSION['member_MemberId']=$MemberId;
		$_SESSION['member_Email']=$Email;
		$_SESSION['member_Title']=$Title;
		$_SESSION['member_FirstName']=$FirstName;
		$_SESSION['member_LastName']=$LastName;
		$_SESSION['member_Password']=$Password;
		
		$db->insert('member_login_log', array(
				'MemberId'	=>	(int)$_SESSION['member_MemberId'],
				'LoginTime'	=>	$service_time,
				'LoginIp'	=>	get_ip()
			)
		);
		
		include($site_root_path.'/inc/lib/cart/init.php');
		
		$_SESSION['create_post']='';
		unset($_SESSION['create_post']);
		
		include($site_root_path.'/inc/lib/mail/create_account.php');
		include($site_root_path.'/inc/lib/mail/template.php');
		sendmail($_SESSION['member_Email'], $_SESSION['member_FirstName'].' '.$_SESSION['member_LastName'], 'Welcome to '.get_domain(0), $mail_contents);
		
		js_location($jump_url);
	}else{
		$_SESSION['create_post']=$_POST;
		js_location("$mobile_url$member_url?create_fail=1&$query_string");
	}
}
?>
<link rel="stylesheet" type="text/css" href="/mobile/css/iconfont.css">
<div id="customer">
	<div class="global">
		<div class="top_title">
			<a href="javascript:;" onclick="history.back();" class="close"></a>
		</div>
		<div class="account_list">
			<a href="<?=$mobile_url; ?>/account.php" class="list"><?=$website_language['head'.$lang]['logn_in']; ?></a>
			<a href="<?=$mobile_url; ?>/account.php?&module=create" class="list cur"><?=$website_language['head'.$lang]['registered']; ?></a>
			<div class="clear"></div>
		</div>
		<?php if($_GET['create_fail']==1){?>
			<div class="lib_member_msgerror"><img src="/images/lib/member/msg_error.png" align="absmiddle" />&nbsp;&nbsp;<?=$website_language['member'.$lang]['create']['tips1']; ?></div>
		<?php } ?>
		<?php if($_GET['create_fail']==2){ ?>
			<div class="content">
				<div class="supplier_tips">
					<?=$website_language['member'.$lang]['login']['tips3']; ?> <br />
					<a href="<?=$mobile_url; ?>/" class="return trans5"><?=$website_language['member'.$lang]['login']['return']; ?></a>
				</div>
			</div>
		<?php }else{ ?>
			<div class="content">
				<form  class="cus_form" action="<?=$mobile_url.$member_url.'?'.$query_string;?>" method="post" name="member_create_form" OnSubmit="return cus_checkbox.check(this);" >
					<div class="row">
						<div class="cus_input">
							<input type="text" name="Email" placeholder="<?=$website_language['member'.$lang]['create']['email']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Email']);?>"  class="input" check="<?=$website_language['member'.$lang]['create']['email_tips1']; ?>!~email|<?=$website_language['member'.$lang]['create']['email_tips2']; ?>!*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="password" class="input" placeholder="<?=$website_language['member'.$lang]['create']['pwd']; ?>" name="Password" value="<?=htmlspecialchars($_SESSION['create_post']['Password']);?>" check="<?=$website_language['member'.$lang]['create']['pwd_tips']; ?>!~*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="password" name="ConfirmPassword" placeholder="<?=$website_language['member'.$lang]['create']['pwd_again']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['ConfirmPassword']);?>"  class="input" check="<?=$website_language['member'.$lang]['create']['pwd_tips2']; ?>!~=Password|<?=$website_language['member'.$lang]['create']['pwd_tips3']; ?>!*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="text" name="Supplier_Name2" placeholder="<?=$website_language['member'.$lang]['other']['name']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Name2']);?>"  class="input" check="<?=$website_language['member'.$lang]['other']['name_tips']; ?>!~*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="text" name="Supplier_Phone" placeholder="<?=$website_language['member'.$lang]['other']['phone']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Phone']);?>"  class="input" check="<?=$website_language['member'.$lang]['other']['phone_tips']; ?>!~*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="text" name="Supplier_Address<?=$lang; ?>" placeholder="<?=$website_language['member'.$lang]['other']['addr']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Address'.$lang]);?>"  class="input" check="<?=$website_language['member'.$lang]['other']['addr_tips']; ?>!~*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="laber"><?=$website_language['member'.$lang]['create']['type']; ?></div>
						<div class="cus_input is_supplier">
							<select name="IsSupplier" id="" class="select">
								<option value="0"><?=$website_language['member'.$lang]['create']['type2']; ?>	</option>
								<option value="1"><?=$website_language['member'.$lang]['create']['type1']; ?></option>
								<option value="2">EAGLE HOME</option>
							</select>
						</div>
						<div class="clear"></div>
					</div>
					<div class="supplier_parameter hide">
						<div class="row hide">
							<div class="laber"><?=$website_language['member'.$lang]['other']['is_business_license']; ?></div>
							<div class="cus_input is_business_license">
								<select name="Is_Business_License" id="" class="select fr">
									<option value="0"><?=$website_language['member'.$lang]['other']['no']; ?>	</option>
									<option value="1" selected><?=$website_language['member'.$lang]['other']['yes']; ?></option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="business_license_parameter ">
							<div class="row">
								<div class="laber"><?=$website_language['member'.$lang]['other']['business_license']; ?></div>
								<div class="clear"></div>
							</div>
							<div class="row">
								<div class="cus_input">
									<div class="upload_img input"><?=$website_language['member'.$lang]['other']['business_license_tips2']; ?></div>
									<input type="hidden" name="Business_License" id="Business_License" placeholder="<?=$website_language['member'.$lang]['other']['business_license']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Business_License']);?>"  class="input" check2="<?=$website_language['member'.$lang]['other']['business_license_tips']; ?>!~*" />
								</div>
								<div class="clear"></div>
							</div>
							<div class="row">
								<div id="Business_License_Img"></div>
							</div>
						</div>
						
						<div class="row">
							<div class="cus_input">
								<input type="text" name="Supplier_Company_Address" placeholder="<?=$website_language['member'.$lang]['other']['company_addr']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Company_Address']);?>"  class="input" check2="<?=$website_language['member'.$lang]['other']['company_addr_tips']; ?>!~*" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="cus_input">
								<input type="text" name="Supplier_Pay_Number" placeholder="<?=$website_language['member'.$lang]['other']['pay_number']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Pay_Number']);?>"  class="input" check2="<?=$website_language['member'.$lang]['other']['pay_number_tips']; ?>!~*" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="cus_input">
								<input type="text" name="Supplier_Main_Products" placeholder="<?=$website_language['member'.$lang]['other']['main_products']; ?>" value="<?=htmlspecialchars($_SESSION['create_post']['Supplier_Main_Products']);?>"  class="input" check2="<?=$website_language['member'.$lang]['other']['main_products_tips']; ?>!~*" />
							</div>
							<div class="clear"></div>
						</div>						
					</div>
					
						<div class="row">
							<div id="ccc" class="cus_input" style="float: left;width: 35%;position: relative;">
							<i class="icon iconfont icon-xialajiantou" style="position: absolute;right: 10%;top: 30%;" id="icon11"></i>
								<select class="input" name="" id="districtNumber" style="border-right: 1px solid #ccc;padding: 5px;color:#999999;">
									<option value="0086" ><?=$ContactUs_language['Mer_Info'.$lang]['CountryTxt']?> 0086 </option>
									<option value="0052"><?=$website_language['goods'.$lang]['mexico']?> 0052</option>
									<option value="00521"><?=$website_language['goods'.$lang]['mexico']?> 00521</option>
								</select>
							</div>
							<div class="cus_input" style="float: left;">
								<input id="mobile" type="text" name="Supplier_Mobile" placeholder="<?=$website_language['member'.$lang]['other']['mobile']; ?>"  class="input">
							</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="cur_input">
								<input id="identifyingCode" placeholder="<?=$website_language['member'.$lang]['create']['Enter_code']; ?>"  type="text" value="" class="input">
							</div>
						</div>
						<div class="row">
							<div class="cus_input">
								<input type="button" style="color:#fff;background:#0090ff;border:0px;padding:5px;margin-left:10px;width:90%" id="btn" value="<?=$website_language['member'.$lang]['create']['Get_code']; ?>">
							</div>
							<div class="clear"></div>
						</div>
						
					<div class="row" style="border:none;">
						<div class="cus_input protocol">
							<div class="not_checkboxed" onclick="cus_checkbox.checkbox(this);">
								<input type="checkbox" name="Agreement" class="checkbox" value="1" />
							</div>
							<div class="check_con"><?=$website_language['member'.$lang]['create']['global']; ?>	 </div>
							<div class="clear"></div>
							<div class="check_tips"> * <?=$website_language['member'.$lang]['create']['global_tips']; ?>	 </div>
						</div>
						<div class="clear"></div>
					</div>
					<input type="submit" id="submit" class="submit" value="<?=$website_language['member'.$lang]['create']['create_member']; ?>" />
					<input type="hidden" name="data" value="member_create" />
				</form>
				<iframe frameborder="0" name="post_file_img" class="hide"></iframe>
				<form class="hide" action="<?=$mobile_url.$member_url.'?'.$query_string;?>" target="post_file_img" method="post" name="file_img" enctype="multipart/form-data">
					<input type="file" name="Business_License" id="" />
					<input type="hidden" name="data" value="file_img" />
				</form>
				<script>
				$('.upload_img').click(function(){
					$('form[name=file_img] input[type=file]').click();
				});
				$('form[name=file_img] input[type=file]').change(function(){
					$('form[name=file_img]').submit();
				});
				</script>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>
<script>
$(function(){
	var a=60;
  	var timer="";
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
          var c=Math.floor(Math.random()*1000000);
          if(c.length<6){
            return c+"[0-9]";
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
	$("#submit").click(function(){
			var b=window.localStorage.getItem("验证码");
	   	if($("#identifyingCode").val()==b){
	   			$("#identifyingCodeTxt").html("验证码正确");
	      		$("#identifyingCodeTxt").addClass("success");
	      		
	   }else{
	      		$("#identifyingCodeTxt").html("验证码错误");
	      		$("#identifyingCodeTxt").addClass("error");
	      		alert("请输入正确验证码");
	      		return false;	      	
	      }
	})
})
	
</script>
<script>
	$('[type=checkbox]').removeAttr('checked');
	var cus_checkbox = {
		checkbox:function(e){
			if($(e).find('[type=checkbox]').is(':checked')){
				$(e).removeClass('checkboxed').find('[type=checkbox]').removeAttr('checked');
				$('.check_tips').show(100);
			}else{
				$(e).addClass('checkboxed').find('[type=checkbox]').attr('checked','checked');
				$('.check_tips').hide(100);
			}
		},
		check:function(e){
			if(!$(e).find('[type=checkbox]').is(':checked')){
				$('.check_tips').show(100);
				return false;
			}else{
				return checkForm(e);
				return false;
			}
		}
	}
	$('.is_supplier .select').change(function(){
		if($(this).val()==1){
			$('.supplier_parameter').show();
			$('.supplier_parameter input[type=text]').each(function(index){
				var _check = $('.supplier_parameter input[type=text]').eq(index).attr('check2');
				$('.supplier_parameter [type=text]').eq(index).attr('check',_check);
			});
		}else if($(this).val()==2){
			$('.supplier_parameter').show();
			$('.supplier_parameter input[type=text]').each(function(index){
				var _check = $('.supplier_parameter input[type=text]').eq(index).attr('check2');
				$('.supplier_parameter [type=text]').eq(index).attr('check',_check);
			});
		}else{
			$('.supplier_parameter').hide();
			$('.supplier_parameter input[type=text]').removeAttr('check');
		}
	});
	$('.is_business_license .select').change(function(){
		if($(this).val()==1){
			$('.business_license_parameter').show();
			$('.business_license_parameter input[type=hidden]').each(function(index){
				var _check = $('.business_license_parameter input[type=hidden]').eq(index).attr('check2');
				$('.business_license_parameter [type=hidden]').eq(index).attr('check',_check);
			});
		}else{
			$('.business_license_parameter').hide();
			$('.business_license_parameter input[type=hidden]').removeAttr('check');
		}
	});	
</script>
<?php
$_SESSION['create_post']='';
unset($_SESSION['create_post']);
?>