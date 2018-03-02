<?php
$query_string=query_string('login_fail');

if($_POST['data']=='member_login'){
	$_SESSION['login_post']=$_POST;
	// $VCode = strtoupper($_POST['VCode']);
	// if($VCode!=$_SESSION[md5('login')] || $_SESSION[md5('login')]==''){	//验证码错误
	// 	$_SESSION[md5('login')]='';
	// 	unset($_SESSION[md5('login')]);
	// 	js_location("$mobile_url$member_url?login_fail=2&$query_string");
	// }
	$Email=$_POST['Email'];
	$Password=password($_POST['Password']);
	$jump_url=$_GET['jump_url'];
	$jump_url=(substr($jump_url, 0, 1)!='/' || substr_count($jump_url, 'logout'))?"$mobile_url$member_url?module=index":$jump_url;
	
	if($Email=='' || $_POST['Password']==''){
		js_location("$mobile_url$member_url?fail=1&$query_string");
	}else{
		$user_row=$db->get_one('member', "Email='$Email' and Password='$Password'");
		if($user_row){
			if(!$user_row['IsUse']){
				js_location("$mobile_url$member_url?fail=3&$query_string");
			}
			if(!$user_row['IsConfirm']){
				js_location("$member_url?fail=4&$query_string");
			}
			$_SESSION['member_MemberId']=$user_row['MemberId'];
			$_SESSION['member_Email']=$user_row['Email'];
			$_SESSION['member_Title']=$user_row['Title'];
			$_SESSION['member_FirstName']=$user_row['FirstName'];
			$_SESSION['member_LastName']=$user_row['LastName'];
			$_SESSION['member_Password']=$user_row['Password'];
			$_SESSION['member_Level']=$user_row['MemberLevel'];
			$_SESSION['member_IsSupplier']=$user_row['IsSupplier'];
			
			$db->update('member', "MemberId='{$user_row['MemberId']}'", array(
					'LastLoginIp'	=>	get_ip(),
					'LastLoginTime'	=>	$service_time,
					'LoginTimes'	=>	$user_row['LoginTimes']+1
				)
			);
			
			$db->insert('member_login_log', array(
					'MemberId'	=>	(int)$_SESSION['member_MemberId'],
					'LoginTime'	=>	$service_time,
					'LoginIp'	=>	get_ip()
				)
			);
			
			include($site_root_path.'/inc/lib/cart/init.php');
			
			$_SESSION['login_post']='';
			unset($_SESSION['login_post']);
			
			if($user_row['IsSupplier']){
				js_location("$mobile_url$member_url?login_fail=2&$query_string");
				exit;
			}
			js_location($jump_url);
		}else{
			$_SESSION['login_post']=$_POST;
			js_location("$mobile_url$member_url?login_fail=1&$query_string");
		}
	}
}
?>
<div id="customer">
	<div class="global">
		<div class="top_title">
			<a href="javascript:;" onclick="history.back();" class="close"></a>
		</div>
		<div class="account_list">
			<a href="<?=$mobile_url; ?>/account.php" class="list cur"><?=$website_language['head'.$lang]['logn_in']; ?></a>
			<a href="<?=$mobile_url; ?>/account.php?&module=create" class="list"><?=$website_language['head'.$lang]['registered']; ?></a>
			<div class="clear"></div>
		</div>
		<?php if($_GET['login_fail']==1){?>
			<div class="lib_member_msgerror"><img style="width:0.32rem;height:0.32rem;" src="/images/lib/member/msg_error.png" align="absmiddle" />&nbsp;&nbsp;<?=$website_language['member'.$lang]['login']['tips1']; ?></div>
		<?php } elseif($_GET['login_fail']==2){ ?>
			<div class="lib_member_msgerror"><img src="/images/lib/member/msg_error.png" align="absmiddle" />&nbsp;&nbsp;<?=$website_language['member'.$lang]['login']['tips2']; ?></div>
		<?php } ?>
		<?php if($_GET['fail']==3){?>
			<div class="content">
				<div class="supplier_tips">
					<?=$website_language['member'.$lang]['login']['tips3']; ?><br />
					<a href="<?=$mobile_url; ?>" class="return trans5"><?=$website_language['member'.$lang]['login']['return']; ?></a>
				</div>
			</div>
		<?php }else if($_GET['fail']==4){ ?>
			<div class="content">
				<div class="supplier_tips">
					<?=$website_language['member'.$lang]['login']['tips5']; ?><br />
					<a href="<?=$mobile_url; ?>" class="return trans5"><?=$website_language['member'.$lang]['login']['tips6']; ?></a>
				</div>
			</div>
		<?php }else{ ?>
			<form class="content" action="<?=$mobile_url.$member_url.'?'.$query_string;?>" method="post" name="member_login_form" OnSubmit="return checkForm(this);">
				<div class="cus_form">
					<div class="row">
						<div class="cus_input">
							<input type="text" name="Email" placeholder="<?=$website_language['member'.$lang]['login']['email']; ?>" class="input" value="<?=htmlspecialchars($_SESSION['login_post']['Email']);?>" check="<?=$website_language['member'.$lang]['login']['email_tips1']; ?>!~email|<?=$website_language['member'.$lang]['login']['email_tips2']; ?>!*" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="cus_input">
							<input type="password" class="input" name="Password" placeholder="<?=$website_language['member'.$lang]['login']['pwd']; ?>" value="<?=htmlspecialchars($_SESSION['login_post']['Password']);?>" check="<?=$website_language['member'.$lang]['login']['pwd_tips1']; ?>!~*" />
						</div>
						<div class="clear"></div>
					</div>
					<?php /*
					<div class="row">
						<div class="laber"><?=$website_language['member'.$lang]['login']['vcode']; ?> :</div>
						<div class="cus_input">
							<input type="text" class="input" name="VCode" check="<?=$website_language['member'.$lang]['login']['vcode_tips2']; ?>!~*"  />
							<div class="code"><?=verification_code('login');?></div>
						</div>
						<div class="clear"></div>
					</div>*/ ?>
					<input type="submit" name="Submit" class="submit" value="<?=$website_language['member'.$lang]['login']['sign']; ?>" />
					<div class="cus_input">
						<div class="forgot"><a href="<?=$mobile_url.$member_url;?>?module=forgot&act=1"><?=$website_language['member'.$lang]['login']['forget']; ?>?</a></div>
					</div>
				</div>
				<input type="hidden" name="data" value="member_login" />
			</form>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>
<?php
$_SESSION['login_post']='';
unset($_SESSION['login_post']);
?>