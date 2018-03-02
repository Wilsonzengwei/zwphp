<?php
$query_string=query_string(array('forgot_success', 'forgot_fail'));
$member_row = $db->get_one('member',$where);
if($_POST['data']=='member_profile'){
	$Title=$_POST['Title'];
	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$Supplier_Name2=$_POST['Supplier_Name2'];
	$Supplier_Phone=$_POST['Supplier_Phone'];
	$Supplier_Mobile=$_POST['Supplier_Mobile'];
	$Supplier_Address=$_POST['Supplier_Address'.$lang];
	
	$db->update('member', $where, array(
			'Title'		=>	$Title,
			'FirstName'	=>	$FirstName,
			'LastName'	=>	$LastName,
			'Supplier_Name2'	=>	$Supplier_Name2,
			'Supplier_Phone'	=>	$Supplier_Phone,
			'Supplier_Address'.$lang	=>	$Supplier_Address,
			'Supplier_Mobile' => $Supplier_Mobile,
		)
	);
	
	$_SESSION['member_Title']=stripslashes($Title);
	$_SESSION['member_FirstName']=stripslashes($FirstName);
	$_SESSION['member_LastName']=stripslashes($LastName);
	
	js_location("$member_url?profile_success=1&$query_string");
}
?>
<div id="lib_member_profile">
	<div class="lib_member_title"><?=$website_language['member'.$lang]['profile']['title1']; ?></div>
	<?php if($_GET['profile_success']==1){?>
		<div class="blank15"></div>
		<div class="change_success lib_member_item_card">
			<br /><?=$website_language['member'.$lang]['profile']['success']; ?><br /><br /><br />
			<a href="<?=$member_url;?>?module=index"><strong><?=$website_language['member'.$lang]['profile']['return']; ?></strong></a><br /><br />
		</div>
	<?php }else{?>
		<div class="lib_member_info"><?=$website_language['member'.$lang]['profile']['title2']; ?></div>
		<div class="form lib_member_item_card">
			<form action="<?=$member_url.'?'.$query_string;?>" method="post" name="member_profile_form" OnSubmit="return checkForm(this);">
				<div class="lib_member_sub_title"><?=$website_language['member'.$lang]['profile']['title3']; ?></div>
				<?php /*<div class="rows">
					<label><?=$website_language['member'.$lang]['profile']['title']; ?>: <font class="fc_red">*</font></label>
					<span><select name="Title">
						<option value="Miss" <?=$_SESSION['member_Title']=='Miss'?'selected':'';?>><?=$website_language['member'.$lang]['profile']['title_type1']; ?></option>
						<option value="Mrs" <?=$_SESSION['member_Title']=='Mrs'?'selected':'';?>><?=$website_language['member'.$lang]['profile']['title_type2']; ?></option>
						<option value="Ms" <?=$_SESSION['member_Title']=='Ms'?'selected':'';?>><?=$website_language['member'.$lang]['profile']['title_type3']; ?></option>
						<option value="Mr" <?=$_SESSION['member_Title']=='Mr'?'selected':'';?>><?=$website_language['member'.$lang]['profile']['title_type4']; ?></option>
					</select></span>
					<div class="clear"></div>
				</div>*/ ?>
				<div class="clear"></div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['profile']['first_name']; ?>: <font class="fc_red">*</font></label>
					<span><input name="FirstName" value="<?=htmlspecialchars($_SESSION['member_FirstName']);?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['profile']['first_name_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['profile']['last_name']; ?>: <font class="fc_red">*</font></label>
					<span><input name="LastName" value="<?=htmlspecialchars($_SESSION['member_LastName']);?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['profile']['last_name_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['other']['name']; ?>: <font class="fc_red">*</font></label>
					<span><input name="Supplier_Name2" value="<?=$member_row['Supplier_Name2']; ?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['other']['name_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="rows">
					<label><?=$website_language['member'.$lang]['other']['phone']; ?>: <font class="fc_red">*</font></label>
					<span><input name="Supplier_Phone" value="<?=$member_row['Supplier_Phone']; ?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['other']['phone_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>

				<div class="rows">
					<label><?=$website_language['member'.$lang]['other']['mobile']; ?>: <font class="fc_red">*</font></label>
					<span><input name="Supplier_Mobile" value="<?=$member_row['Supplier_Mobile']; ?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['other']['mobile_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>


				<div class="rows">
					<label><?=$website_language['member'.$lang]['other']['addr']; ?>: <font class="fc_red">*</font></label>
					<span><input name="Supplier_Address<?=$lang; ?>" value="<?=$member_row['Supplier_Address'.$lang]; ?>" type="text" class="form_input" check="<?=$website_language['member'.$lang]['other']['addr_tips']; ?>!~*" size="40" maxlength="20"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="rows">
					<label></label>
					<span><input name="Submit" type="submit" class="form_button form_button_130" value="<?=$website_language['member'.$lang]['profile']['keep']; ?>"></span>
					<div class="clear"></div>
				</div>
				<input type="hidden" name="data" value="member_profile" />
			</form>
		</div>
	<?php }?>
</div>