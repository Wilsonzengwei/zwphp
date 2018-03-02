<?php
include('inc/include.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php echo seo_meta();?>
<?php include("$site_root_path/inc/common/static.php"); ?>
</head>
<body>
<?php include("$site_root_path/inc/common/account_header.php"); ?>
<div id="customer">
	<?php /*
	<div class="global">
		<div class="cus_left">
			<h1 class="top_title">Create Account</h1>
			<div class="cus_form">
				<div class="row">
					<div class="laber">E-mail Address :</div>
					<div class="cus_input">
						<input type="text" class="input" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber">Password :</div>
					<div class="cus_input">
						<input type="text" class="input" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber">Enter the code shown :</div>
					<div class="cus_input">
						<input type="text" class="input" />
						<div class="code"></div>
					</div>
					<div class="clear"></div>
				</div>
				<input type="submit" class="submit" value="SIGN IN" />
			</div>
		</div>
		<div class="cus_right">
			<div class="content">
				<div class="title">Why buy on GLOBAL EAGLE ?</div>
				<a href="" class="list">Wholesale products from certified sellers ?</a>
				<a href="" class="list">Worldwide shipping</a>
				<a href="" class="list">Low prices from US $0.1</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>*/ ?>
	<div class="global">
		<div class="cus_left">
			<h1 class="top_title">Create Account</h1>
			<div class="cus_form">
				<div class="row">
					<div class="laber"><span class="red">*</span> E-mail Address :</div>
					<div class="cus_input">
						<input type="text" class="input" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber"><span class="red">*</span> Password :</div>
					<div class="cus_input">
						<input type="text" class="input" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber"><span class="red">*</span> Confirm Password :</div>
					<div class="cus_input">
						<input type="text" class="input" />
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber"><span class="red">*</span> Bussiness Type :</div>
					<div class="cus_input is_supplier">
						<input type="radio" name="IsSupplier" value="1" class="radio" />
						Supplier &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="IsSupplier" value="0" checked="checked" class="radio" />
						Personal							
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="laber"></div>
					<div class="cus_input protocol">
						<div class="not_checkboxed" onclick="cus_checkbox.checkbox(this);">
							<input type="checkbox" name="" class="checkbox" value="1" />
						</div>
						<div class="check_con">Upon creating my account, I agree to the GLOBAL EAGLE Agreement </div>
						<div class="clear"></div>
						<div class="check_tips"> * Upon creating my account, I agree to the GLOBAL EAGLE Agreement </div>
					</div>
					<div class="clear"></div>
				</div>
				<input type="submit" class="submit" value="CREATE MY ACCOUNT" />
			</div>
		</div>
		<div class="cus_right">
			<div class="content">
				<div class="title">Already have an account?</div>
				<a href="" class="sign_in trans5" title="Sign In">Sign In</a>
			</div>
			<div class="content">
				<div class="title">Why buy on GLOBAL EAGLE ?</div>
				<a href="" class="list">Wholesale products from certified sellers ?</a>
				<a href="" class="list">Worldwide shipping</a>
				<a href="" class="list">Low prices from US $0.1</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div id="footer">
	<?php include("$site_root_path/inc/common/copyright.php"); ?>
</div>
<script>
	var cus_checkbox = {
		checkbox:function(e){
			if($(e).find('[type=checkbox]').is(':checked')){
				$(e).removeClass('checkboxed').find('[type=checkbox]').removeAttr('checked');
			}else{
				$(e).addClass('checkboxed').find('[type=checkbox]').attr('checked','checked');
			}
		},
	}
</script>
</body>
</html>
