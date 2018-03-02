<?php

$MemberId = $_SESSION['member_MemberId'];
$IsSupplier=$_SESSION['IsSupplier'];
if($_POST['mode'] == 'userinfo'){

	$Email = $_POST['Email'];
	$FirstName = $_POST['FirstName'];
	$Sex = $_POST['Sex'];
	$Supplier_Name = $_POST['Supplier_Name'];
	$BornTime = $_POST['BornTime'];
	$Supplier_Mobile = $_POST['Supplier_Mobile'];
	$Supplier_Phone = $_POST['Supplier_Phone'];
	$Supplier_Address_lang_1 = $_POST['Supplier_Address_lang_1'];
	$UserName = $_POST['UserName'];
	$db->update('member',"MemberId='$MemberId'",array(
		'Supplier_Name'				=>	$Supplier_Name,
		'FirstName'					=>	$FirstName,
		'Email'						=>	$Email,
		'Supplier_Phone'			=>	$Supplier_Phone,
		'Supplier_Mobile'			=>	$Supplier_Mobile,
		'Supplier_Address_lang_1'	=>	$Supplier_Address_lang_1,
		'Sex'						=>	$Sex,
		'BornTime'					=>	$BornTime,
		'UserName'					=>	$UserName,

		));
	//var_dump($_SESSION['IsSupplier']);exit;
	header("refresh:0;url=/user.php?module=index&act=1");
	exit;
}
if($_POST['mode'] == 'password'){
	$Password = password($_POST['Password']);
	$NPassword = password($_POST['NPassword']);
	$APassword = password($_POST['APassword']);
	if($NPassword !== $APassword){
		echo '<script>alert("新密码与确认密码不一致,请重新填写");history.go(-1);</script>';
		header("refresh:0;url=/user.php?module=index&act=2");
		exit;
	}
	if($Password == $NPassword || $Password == $APassword){
		echo '<script>alert("新密码不能与原密码相同,请重新填写");history.go(-1);</script>';
		header("refresh:0;url=/user.php?module=index&act=2");
		exit;
	}
	if($db->get_one("member","MemberId='$MemberId' and Password='$Password'")){
		$db->update("member","MemberId='$MemberId'",array(
				'Password'		=>	$NPassword,
			));
		echo '<script>alert("修改成功");</script>';
		header("refresh:0;url=/user.php?module=index&act=1");
		exit;
	}else{
		echo '<script>alert("输入的原密码错误，请重新输入");history.go(-1);</script>';
		exit;
	}
}
$member_row = $db->get_one('member',"MemberId='$MemberId'");
?>
<?php
	echo '<link rel="stylesheet" href="/css/user/index'.$lang.'.css">'
?>
<link href="/css/lyz.calendar.css" rel="stylesheet" type="text/css" />
<script src="http://www.jq22.com/jquery/1.4.4/jquery.min.js"></script>
<script src="/js/lyz.calendar.min.js" type="text/javascript"></script>

<div class="mask">
	<div class="box">
	<div  class="header"><img class="header_img" src="/images/index/logo.png" alt=""><?=$website_language['user_index'.$lang]['grzx']?></div>
	<ul class="y_list">
		<li class="y" data='1'><a href="/user.php?module=index&act=1" class='s2'><?=$website_language['user_index'.$lang]['wdxx']?></a></li>
		<?php if($IsSupplier != '1'){?>
			<li class="y" data='1'><a href="/user.php?module=orders&act=1" class='s1'><?=$website_language['user_index'.$lang]['wddd']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=service_info&act=1" class='s1'><?=$website_language['user_index'.$lang]['ddfw']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=coll&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdsc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=cart&act=1" class='s1'><?=$website_language['user_index'.$lang]['wdgwc']?></a></li>
			<li class="y" data='1'><a href="/user.php?module=address&act=1" class='s1'><?=$website_language['user_index'.$lang]['shdz']?></a></li>

		<?php }?>
	</ul>
	<div class="yx">
		<div class="title">
			<div class="title1"><?=$website_language['user_index'.$lang]['wdxx']?></div>
			<div class="title2"></div>
			<div class="title3"></div>
		</div>
			<div class="yhh">
			<?php if($_GET['act'] == '1'){?>			
				<div class="dianji_list">
					<a class="dianji_c" href='/user.php?module=index&act=1'><?=$website_language['user_index'.$lang]['jbxx']?></a>
					<a class="dianji" href='/user.php?module=index&act=2'><?=$website_language['user_index'.$lang]['mmxg']?></a>
				</div>
				<form method="post" action="">
					<div class="ds_list ds_list_b" data='1'>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['gryx']?>：</span><input class="y_title_txt" type="text" name="Email" value="<?=$member_row['Email']?>">
						</div>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['yhm']?>：</span><input class="y_title_txt" type="text" name="UserName" value="<?=$member_row['UserName']?>">
						</div>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['zsxm']?>：</span><input class="y_title_txt" type="text" name="FirstName" value="<?=$member_row['FirstName']?>">
						</div>
						<div class="y_form">
							<div class="y_check"><span class="y_title"><?=$website_language['user_index'.$lang]['xb']?>：</span>
								<a class="y_input"><input class="input_r" type="radio" value="1" name="Sex" <?=$member_row['Sex'] == '2' ?  : 'checked';?>><span class='input_s'><?=$website_language['user_index'.$lang]['nan']?></span></a>
								<a class="y_input"><input class="input_r" type="radio" value="2" name="Sex" id="" <?=$member_row['Sex'] == '2' ?  checked: '';?>><span class='input_s'><?=$website_language['user_index'.$lang]['nv']?></span></a>
		           			</div>
						</div>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['gsmc']?>：</span><input class="y_title_txt" type="text" name="Supplier_Name" value="<?=$member_row['Supplier_Name']?>">
						</div>
						<div class="y_form">	
							<span class="y_title"><?=$website_language['user_index'.$lang]['csrq']?>：</span><input id="txtEndDate" type="text" class="y_title_txt"  name="BornTime" value="<?=$member_row['BornTime'] != '' ? date('Y-m-d',$member_row['BornTime']) : '';?>">	
							<input id="txtBeginDate" style="opacity:0">				
						</div>				
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['sjhm']?>：</span><input class="y_title_txt" type="text" name="Supplier_Mobile" value="<?=$member_row['Supplier_Mobile']?>">
						</div>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['gddh']?>：</span><input class="y_title_txt" type="text" name="Supplier_Phone" value="<?=$member_row['Supplier_Phone']?>">
						</div>
						<div class="y_form">
							<span class="y_title"><?=$website_language['user_index'.$lang]['shdz']?>：</span><input class="y_title_txt" type="text" name="Supplier_Company_Address" value="<?=$member_row['Supplier_Company_Address']?>">
						</div>
						<div class="y_submit">
							<input type="hidden" name="mode" value="userinfo">	      
					        <input class="ys_input" type="submit" value="<?=$website_language['user_index'.$lang]['bc']?>">
					    </div>
						
					</div>
				</form>
				<script>

    $(function () {

        $("#txtEndDate").calendar({

            controlId: "divDate",                                 // 弹出的日期控件ID，默认: $(this).attr("id") + "Calendar"

            speed: 200,                                           // 三种预定速度之一的字符串("slow", "normal", or "fast")或表示动画时长的毫秒数值(如：1000),默认：200

            complement: true,                                     // 是否显示日期或年空白处的前后月的补充,默认：true

            readonly: true,                                       // 目标对象是否设为只读，默认：true

            upperLimit: new Date(),                               // 日期上限，默认：NaN(不限制)

            lowerLimit: new Date("1900/01/01"),                   // 日期下限，默认：NaN(不限制)

            callback: function () {                               // 点击选择日期后的回调函数

                console.log("您选择的日期是：" + $("#txtEndDate").val());
                $('#txtBeginDate').focus();
            }

        });


    });

</script>
			<?php }elseif($_GET['act'] == '2'){?>
				<div class="dianji_list">
					<a class="dianji" href='/user.php?module=index&act=1'><?=$website_language['user_index'.$lang]['jbxx']?></a>
					<a class="dianji_c" href='/user.php?module=index&act=2'><?=$website_language['user_index'.$lang]['mmxg']?></a>
				</div>
				<form method="post" action="">
					<div class="ds_list ds_list_n" data='2'>
						<div class="y_form1">
							<span class="y_title"><?=$website_language['user_index'.$lang]['ymm']?>：</span><input class="ac y_title_txt" type="password" name="Password" value="">
						</div>
						<div class="y_form1">
							<span class="y_title"><?=$website_language['user_index'.$lang]['xmm']?>：</span><input class="ac y_title_txt yhe2" type="password" name="NPassword" value=""><i style="margin-left:30px"></i><span class='yhe2t'></span>
						</div>
						<div class="y_form1">
							<span class="y_title"><?=$website_language['user_index'.$lang]['qrmm']?>：</span><input class="ac y_title_txt yhe3" type="password" name="APassword" value=""><i style="margin-left:30px"></i><span class='yhe3t'></span>
						</div>
						<div class="y_submit"> 
							<input type="hidden" name="mode" value="password">     
					        <input class="ys_input psa" type="submit" value="<?=$website_language['user_index'.$lang]['bc']?>">
					    </div>
					</div>
				</form>
				<script>
					function bjl(c1,c2,txt1,txt2,txt3){
    	$(c1).blur(function(){
    		if($(this).val()==''){
	    		$(c2).text(txt1);
	    		$(c1).css('border','1px solid red');
	    		window.sessionStorage.setItem('none','1');
		    	return false;	    	
		    }else if($(c1).val().length<8){
	    		$(c2).text(txt2);
	    		$(c1).css('border','1px solid red');
	    		window.sessionStorage.setItem('none','1');
	    		return false;
		    }else if($(c1).val().length>23){
		    	$(c2).text(txt3);
		    	$(c1).css('border','1px solid red');
		    	window.sessionStorage.setItem('none','1');
		    	return false;
		    }else{	    
	   			$(c2).text('');
	   			$(c1).css('border','1px solid #ccc');
	   		}
    	})    	
	}
	function bjl2(c1,c2,txt1,txt2,txt3){
    	$(c1).each(function(){
    		if($(this).val()==''){
	    		$(c2).text(txt1);
	    		$(c1).css('border','1px solid red');
	    		window.sessionStorage.setItem('none','1');
		    	return false;	    	
		    }else if($(c1).val().length<8){
	    		$(c2).text(txt2);
	    		$(c1).css('border','1px solid red');
	    		window.sessionStorage.setItem('none','1');
	    		return false;
		    }else if($(c1).val().length>23){
		    	$(c2).text(txt3);
		    	$(c1).css('border','1px solid red');
		    	window.sessionStorage.setItem('none','1');
		    	return false;
		    }else{	    
	   			$(c2).text('');
	   			$(c1).css('border','1px solid #ccc');
	   		}
    	})    	
	}
	$('.yhe3').blur(function(){
		if($(this).val()!=$('.yhe2').val()){
			// $('.yhe3t').text('两次输入密码不一致');
			$(this).css('border','1px solid red');
			window.sessionStorage.setItem('none','1');	
			return false;
		}else{
			$('.yhe3t').text('');
			$(this).css('border','1px solid #ccc');
			window.sessionStorage.setItem('none','2');
		}
	})
	bjl('.yhe2','.yhe2t',"<?=$website_language['ylfy'.$lang]['mmbbwk']; ?>","<?=$website_language['ylfy'.$lang]['mmcdx16']; ?>","<?=$website_language['ylfy'.$lang]['mmcdd23']; ?>");
		$('.psa').click(function(){
			bjl2('.yhe2','.yhe2t',"<?=$website_language['ylfy'.$lang]['mmbbwk']; ?>","<?=$website_language['ylfy'.$lang]['mmcdx16']; ?>","<?=$website_language['ylfy'.$lang]['mmcdd23']; ?>");
			var noneget=window.sessionStorage.getItem('none');
			if(noneget=='1'){
				return false;
			}			
		})

				</script>
				<?php }?>
			</div>
		
	</div>
	</div>
</div> 

<script>
	$(function(){
		$('.input_r').click(function(){
			$('.y_input').css('color','#666');
			$(this).parent('.y_input').css('color','#006ac3');
		})	
		})	
		// $('.dianji_list').find('input').click(function(){
		// 	var ds=$(this).attr('data');
		// 	$('.yhh').find('.ds_list').removeClass('ds_list_b');
		// 	$('.yhh').find('.ds_list').each(function(){
		// 		var dsa=$(this).attr('data');
		// 		if(dsa==ds){
		// 			$(this).addClass('ds_list_b');
		// 		}else{
		// 			$(this).addClass('ds_list_n');
		// 		}
		// 	})
		// 	$('.dianji_list').find('input').removeClass('dianji_c');
		// 	$(this).addClass('dianji_c');

		// })
	
	 
</script>

<script>
	$('.y').click(function(){
			$('.title1').text(''+$(this).find('.s1').text()+'');
			$('.title2').text('');
			$('.title3').text('');
		})
</script>
