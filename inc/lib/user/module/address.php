<?php 
$MemberId = $_SESSION['member_MemberId'];
$mode_tz = $_GET['mode_tz'];
$ProId = $_GET['ProId'];
$mysubmit = $_GET['mysubmit'];

if($_GET['mode'] == 'del_add'){
	$AId = $_GET['AId'];
	//var_dump($AId);EXIT;
	$db->delete('address',"AId='$AId'");
	//echo '<script>alert("删除成功")</script>';
	header("refresh:0;url=/user.php?module=address");
	exit;
}

if($_GET['mode'] == 'on_code'){
	$AId = $_GET['AId'];
	//var_dump($AId);EXIT;
	$db->update("address","AId=$AId",array(
		'Model'	=>	0,
	));
	//echo '<script>alert("取消成功")</script>';
	header("refresh:0;url=/user.php?module=address");
	exit;
}

if($_GET['mode'] == 'code'){
	$AId = $_GET['AId'];
	//var_dump($AId);EXIT;
	$db->update("address","AId=$AId",array(
		'Model'	=>	1,
	));
	$db->update("address","AId!=$AId",array(
		'Model'	=>	0,
	));
	//echo '<script>alert("设置成功")</script>';
	header("refresh:0;url=/user.php?module=address");
	exit;
}
if($_POST['mode'] == 'mode_address'){
	$count = $db->get_row_count('address',"SMemberId='$MemberId'");
	//var_dump($count);exit;
	$mode_tz = $_POST['mode_tz'];
	$ProId	=$_POST['ProId'];
	$mysubmit	=$_POST['mysubmit'];
	$SMemberId = $MemberId;
	$SName = $_POST['SName'];
	$SEmail = $_POST['SEmail'];
	$SArea = $_POST['SArea'];
	$SCode = $_POST['SCode'];
	$SAddress = $_POST['SAddress'];
	$SMobile = $_POST['SMobile'];
	$AccTime = time();
	$act = $_POST['act'];
	$data = $_POST['data'];
	$Model = $_POST['Model'];
	if($count == '0'){
		$Model = 1;
	}
	//var_dump($_POST['mode_x']);exit;
	if($_POST['mode_x'] == 'mode_x'){
		$AId = $_POST['AId'];
		$db->update("address","AId='$AId'",array(
			'SMemberId'	=>	$SMemberId,
			'SName'		=>	$SName,
			'SEmail'	=>	$SEmail,
			'SArea'		=>	$SArea,
			'SCode'		=>	$SCode,
			'SAddress'	=>	$SAddress,
			'SMobile'	=>	$SMobile,
			'AccTime'	=>	$AccTime,
			));
	}else{
		if($count > 4){
			echo '<script>alert("最多存在5条收货地址")</script>';
			header("refresh:0;url=/user.php?module=address");
			exit;
		}
		$db->insert("address",array(
			'SMemberId'	=>	$SMemberId,
			'SName'		=>	$SName,
			'SEmail'	=>	$SEmail,
			'SArea'		=>	$SArea,
			'SCode'		=>	$SCode,
			'SAddress'	=>	$SAddress,
			'SMobile'	=>	$SMobile,
			'AccTime'	=>	$AccTime,
			'Model'	=>	$Model,
			));
	}
	if($Model == '1'){
	$SArea_a = $db->get_insert_id();
		$db->update("address","AId!=$SArea_a",array(
			'Model'	=>	0,
			));
	}

	if($mode_tz == 'return'){
		header("refresh:0;url=/cart.php?module=checkout&mysubmit=".$mysubmit."&ProId=".$ProId."&act=".$act."&data=".$data);
	}else{
		//echo '<script>alert("添加成功")</script>';
		header("refresh:0;url=/user.php?module=address");
	}
	exit;
}


$address_row = $db->get_limit('address',"SMemberId='$MemberId'",'*',"AccTime asc",'0','5');
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/address'.$lang.'.css">'
?>
	<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s2'><?=$website_language['user_index'.$lang]['shdz']?></a></li>
		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['shdz']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
		<div class="yhh">
			<div class="bbg1">
				<div class="product_yhh_t">
					<div class="product_yhh_t_120"><?=$website_language['user_address'.$lang]['shr']?></div>
					<div class="product_yhh_t_150"><?=$website_language['user_address'.$lang]['shryx']?></div>
					<div class="product_yhh_t_80"><?=$website_language['user_address'.$lang]['szdq']?></div>
					<div class="product_yhh_t_70"><?=$website_language['user_address'.$lang]['yb']?></div>
					<div class="product_yhh_t_210"><?=$website_language['user_address'.$lang]['shdz']?></div>
					<div class="product_yhh_t_130"><?=$website_language['user_address'.$lang]['sjhm']?></div>
					<div class="product_yhh_t_160"><?=$website_language['user_address'.$lang]['cz']?></div>					
				</div>
				<?php 
					for ($i=0; $i < count($address_row); $i++) { 
						if($address_row[$i]['SCode'] == '1'){
							//var_dump($address_row['SCode']);exit;
							$SCode_r = "墨西哥";
						}elseif($address_row[$i]['SCode'] == '2'){
							$SCode_r = "中国";
						}
						
				?>
				<div data='2' class="product_yhh_t1">
					<div class="product_yhh_t1_120">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$address_row[$i]['SName']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_150">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$address_row[$i]['SEmail']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_80">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$SCode_r?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_70">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$address_row[$i]['SArea']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_210">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$address_row[$i]['SAddress']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_130">
						<div class="something-semantic">
						   <div class="something-else-semantic">
						       <?=$address_row[$i]['SMobile']?>
						   </div>
						</div>
					</div>
					<div class="product_yhh_t1_160">
						<div class="cz">
							<a href="user.php?module=address&mode_t=mode_t&AId=<?=$address_row[$i]['AId']?>"><?=$website_language['user_address'.$lang]['xg']?></a>
							<a href="/user.php?module=address&mode=del_add&AId=<?=$address_row[$i]['AId']?>"><?=$website_language['user_address'.$lang]['sc']?></a>
						</div>
							
						<?php 
							if($address_row[$i]['Model']){
								/*user.php?module=address&mode=on_code&AId=<?=$address_row[$i]['AId']?>*/
						?>					
							<a class="morendizhi" href=""><?=$website_language['user_address'.$lang]['mrdz']?></a>
						<?php }else{?>
							<a class="morendizhi2" href="/user.php?module=address&mode=code&AId=<?=$address_row[$i]['AId']?>"><?=$website_language['user_address'.$lang]['swmr']?></a>
						<?php }?>
					</div>
				</div>	
				<?php }?>

		<?php 
			if($_GET['mode_t'] == 'mode_t'){
				$AId = $_GET['AId'];
				$address_rowx = $db->get_one('address',"AId='$AId'");
		?>		
			<form method="post" action="/user.php?module=address">
				<div class="hei3"><?=$website_language['user_address'.$lang]['xzshdz']?></div>

				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['sjryx']?></span>：<input class="y_title_txt email1" type="text" name="SEmail" value="<?=$address_rowx['SEmail']?>">
					<span class="yhe3t" style="display:inline-block;color:red"></span>
				</div>
				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['shrxm']?></span>：<input class="y_title_txt ac" type="text" name="SName" value="<?=$address_rowx['SName']?>">
				</div>
				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['szdq']?></span>：<select class="select_txt"  name="SCode" id="">
						<option value="1" <?=$address_rowx['SCode'] == '2' ? '' :selected ;?>>墨西哥</option>
						<option value="2" <?=$address_rowx['SCode'] == '2' ? selected :'' ;?>>中国</option>
					</select>
				</div>
				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['shdz']?></span>：<input class="y_title_txt ac" type="text" name="SAddress" value="<?=$address_rowx['SAddress']?>">
				</div>
				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['ybhm']?></span>：<input class="y_title_txt ac" type="text" name="SArea" value="<?=$address_rowx['SArea']?>">
				</div>
				<div class="y_form1">
					<span class="y_title"><?=$website_language['user_address'.$lang]['sjhm']?></span>：<input class="y_title_txt ac" type="text" name="SMobile" value="<?=$address_rowx['SMobile']?>">
				</div>			
			<script>
				$(function(){
					$('.email1').blur(function(){
					var email=$(".email1").val();
				 	if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
					{					   	
					   	$('.yhe3t').html("<?=$website_language['ylfy'.$lang]['gsbzq']; ?>");
					   	$(this).focus();
					}else{
						$('.yhe3t').html('');
					}
					})
				})			
		</script>
				<!-- <div class="y_form1">
						<div class="hei4">
							<input id='hh' data="1" type="checkbox" name="Model" <?=$address_rowx['Model'] == '1' ? checked : '';?>  value="1">
						</div>
						<div class="hei5">设为默认收货地址</div>			
				</div> -->

				<br>
				<div class="y_form1">
					<input type="hidden" name="mode" value="mode_address">
					<input type="hidden" name="AId" value="<?=$AId?>">
					<input type="hidden" name="mode_x" value="mode_x">
					<input class="add_submit" type="submit" value="保存">
				</div>	
				</div>	
			</form>	
		<?php }else{?>	
			<form method="post" action="">
			<div class="hei3"><?=$website_language['user_address'.$lang]['xzshdz']?></div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['sjryx']?></span>：<input class="y_title_txt ac email1" type="text" name="SEmail">
				<span class="yhe3t" style="display:inline-block;color:red"></span>
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['shrxm']?></span>：<input class="y_title_txt ac" type="text" name="SName">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['szdq']?></span>：<select class="select_txt"  name="SCode" id="">
					<option value="1">墨西哥</option>
					<option value="2">中国</option>
				</select>
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['shdz']?></span>：<input class="y_title_txt ac" type="text" name="SAddress">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['ybhm']?></span>：<input class="y_title_txt ac" type="text" name="SArea">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['user_address'.$lang]['sjhm']?></span>：<input class="y_title_txt ac" type="text" name="SMobile">
			</div>
			<br>
		<script>
				$(function(){
					$('.email1').blur(function(){
					var email=$(".email1").val();
				 	if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
					{					   	
					   	$('.yhe3t').html("<?=$website_language['ylfy'.$lang]['gsbzq']; ?>");
					   	$(".email1").css('border','1px solid red');
					   	$(this).focus();
					}else{
						$(".email1").css('border','1px solid #ccc');
						$('.yhe3t').html('');
					}
					})
					$('.psa').click(function(){
						var email=$(".email1").val();
					 	if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
						{											   	
						   	$('.yhe3t').html("<?=$website_language['ylfy'.$lang]['gsbzq']; ?>");
						   	$(".email1").css('border','1px solid red');
						   	$(".email1").focus();
						   	return false;
						}else{
							$(".email1").css('border','1px solid #ccc');
							$('.yhe3t').html('');
						}
						})					
				})			
		</script>
		<!-- 	<div class="y_form1">
					<div class="hei4">
						<input id='hh' data="1" type="checkbox" name="Model" value="1">
					</div>
					<div class="hei5">设为默认收货地址</div>			
			</div> -->
			<div class="y_form1">
				<?php if($mode_tz == 'return'){ ?>
					<input type="hidden" name="mode_tz" value="<?=$mode_tz?>">
					<input type="hidden" name="ProId" value="<?=$ProId?>">
					<input type="hidden" name="mysubmit" value="<?=$mysubmit?>">
					<input type="hidden" name="act" value="<?=$_GET['act']?>">
					<input type="hidden" name="data" value="<?=$_GET['data']?>">
				<?php }?>
				<input type="hidden" name="mode" value="mode_address">
				<input class="add_submit psa" type="submit" value="<?=$website_language['user_address'.$lang]['bc']?>">
			</div>	
			</div>	
		</form>		
		<?php }?>
		</div>
	</div>
	</div>
</div>
<script src='/js/none.js'></script>
<script>
	$(function(){
		$('.product_yhh_t1').hover(function(){
			var ds=$(this).attr('data');
			if(ds=='1'){
				$(this).css('background','#f2f2f2');
			}else if(ds=='2'){
				$(this).css('background','#f2f2f2');
				$(this).find('.morendizhi2').css('opacity','1');
				$(this).find('.morendizhi2').css('color','#fff');
				$(this).find('.morendizhi2').css('text-decoration','none');
			}
		},function(){
			$(this).css('background','#fff');
			$(this).find('.morendizhi2').css('opacity','0');
		})
	})
</script>
