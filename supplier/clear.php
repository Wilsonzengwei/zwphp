<?php
include('../inc/include.php');
$OrderId = $_GET['OrderId'];
$MemberId = $_GET['MemberId'];
$order_row = $db->get_one("orders","OrderId='$OrderId'");
$OId = $order_row['OId'];
$order_list_row = $db->get_one("orders_product_list","OrderId='$OrderId'");
if($_POST['mode'] == 'service'){
	$OrderId = $_POST['OrderId'];
	$MemberId = $_POST['MemberId'];
	$Transport = $_POST['transport'];
	$FirstName = $_POST['FirstName'];
	//$ShippingAddressLine1 = $_POST['ShippingAddressLine1'];
	//var_dump($ShippingAddressLine1);exit;
	$Clearance = $_POST['Clearance'];
	$PaymentMethod = $_POST['PaymentMethod'];
	$Weight=$order_row['Weight'];
	$Volume=$order_row['Volume'];
	$ShippingCharges=$order_row['ShippingCharges'];
	$CustomsClearance=$order_row['CustomsClearance'];
	$PaymentMethod=$PaymentMethod;
	$QPrice = $order_row['QPrice'];
	$AccTime = time();
	$PName = $order_list_row['Name'.$lang];
	
	
	if($Transport == '1'){
		$Aprice = $order_row['KPrice'];
		//var_dump($Aprice);exit;
		$TotalPrice = $_POST['KTorns'];
		$FirmName = $_POST['FirmName'];
		
	}elseif($Transport == '2'){
		$Aprice = $order_row['HPrice'];
		$TotalPrice = $_POST['HTorns'];
		$FirmName = $_POST['FirmNamex'];
	}
	if($Transport == '0'){
		$YName = $_POST['YName'];
		$YContact1 = $_POST['YContact1'];
		$YContact2 = $_POST['YContact2'];
	}else{
		$YName = '';
		$YContact1 = '';
		$YContact2 = '';
	}

	if($Transport == '0' && $Clearance == '0'){//自运自清
		$TOrderId = $OId."CLCT";
	}elseif($Transport != '0'  && $Clearance == '0'){
		$TOrderId = $OId."ELCT";
	}elseif($Transport == '0'  && $Clearance != '0'){
		$TOrderId = $OId."CLET";
	}elseif($Transport != '0'  && $Clearance != '0'){
		$TOrderId = $OId."ELET";
	}

	if($db->get_one('trans_clear',"OrderId='$OrderId'")){
		echo '<script>alert("订单已运输，请不要重复提交");history.go(-1);</script>';

		exit;
	}
	$db->insert("trans_clear",array(
		'MemberId'		=>	$MemberId,
		'OrderId'		=>	$OrderId,
		'TOrderId'		=>	$TOrderId,
		'Transport'		=>	$Transport,
		'Weight'		=>	$Weight,
		'Volume'		=>	$Volume,
		'Aprice'		=>	$Aprice,
		'YName'			=>	$YName,
		'YContact1'		=>	$YContact1,
		'YContact2'		=>	$YContact2,
		'Clearance'		=>	$Clearance,
		'AccTime'		=>	$AccTime,
		'PaymentMethod'	=>	$PaymentMethod,
		'ShippingCharges'=> $ShippingCharges,
		'CustomsClearance'=>$CustomsClearance,
		'TotalPrice'	=>	$TotalPrice,
		'PName'			=>	$PName,
		'QPrice'		=>	$QPrice,
		'PaymentStatus'	=>	'1',
		'XSId'			=>	$FirmName
		));
	$insert_id = $db->get_insert_id();

	/*$db->update("orders","OrderId='$OrderId'",array(
		'ShippingAddressLine1'	=>	$ShippingAddressLine1,
		));*/
	if($insert_id){
		echo '<script>alert("运费与清关费用支付方式确认成功");</script>';
		header("Refresh:0;url=/user.php?module=service_info&act=1");
		exit;
	}

}


$member_row = $db->get_one("member","MemberId='$MemberId'");
$trans_clear_row = $db->get_one("trans_clear","MemberId='$MemberId' and OrderId='$OrderId'");

include('../inc/common/header.php');
?>
<script src='/js/none.js'></script>
<?php
	echo '<link rel="stylesheet" href="/css/supplier/clear'.$lang.'.css">'
?>

<form action="" method="post">
<div class="mask">
	<div class="he31">
		<div class="title">
			<div class="w_500"><span class='span_title'><?=$website_language['supplier_clear'.$lang]['ddh']?>：</span><span><?=$order_row['OId']?></span></div>
			<div class="w_700"><span class='span_title'><?=$website_language['supplier_clear'.$lang]['spmc']?>：</span><span title='<?=$order_list_row['Name'.$lang];?>' class='w_590'><?=$order_list_row['Name'.$lang];?></span></div>
		</div>
		<div class="biaoti"><?=$website_language['supplier_clear'.$lang]['ysqg']?></div>
		<div class="y_form1">
	        	<span style="float:left" class="span_title"><?=$website_language['supplier_clear'.$lang]['ysfs']?>：</span>
	        	<div class="w_800">
	        		<div class="ysc"><a  class="y_input"><input data='1' class="input_r yunshur" checked type="radio" value="1" name="transport" id=""><span class='input_s'><?=$website_language['supplier_clear'.$lang]['yydlky']?></span></a></div>
	        		<div class="ysc"><a  class="y_input"><input data='2' class="input_r yunshur" type="radio" value="2" name="transport" id=""><span class='input_s'><?=$website_language['supplier_clear'.$lang]['yydlhy']?></span></a></div>
	        		<div class="ysc"><a  class="y_input"><input data='3' class="input_r yunshur" type="radio" value="0" name="transport" id=""><span class='input_s'><?=$website_language['supplier_clear'.$lang]['zxys']?></span></a></div>
	        	</div>
		</div>
		<div class="yunshu" data='1' style="display:block">
			<div class="y_form1">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['ysgsmc']?>：</span>
				<select name="FirmName" class="select_txt" id="sel1">
					<option ><?=$website_language['supplier_clear'.$lang]['qxzysgs']?></option>
					<?php 
						$shipping_row1 = $db->get_all('shipping',"Express=1");
						for ($i=0; $i < count($shipping_row1); $i++) { 
					?>
					 	<option value="<?=$shipping_row1[$i]['SId'];?>"><?=$shipping_row1[$i]['FirmName']?></option>
					<?php }?>				 	
				</select>
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zlbz']?>：</span><input class="y_title_txt ac" type="text" name="" id="KWeight_C" value="" readonly='true'>  例：USD/KG
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['tjbz']?>：</span><input class="y_title_txt ac" type="text" name="" id="KVolume_C" value="" readonly='true'>  例：USD/m³
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zzl']?>：</span><input value='待处理中......' class="y_title_txt ac" type="text" name="" id="KWeight" value="" readonly='true'>  KG
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['ztj']?>：</span><input value='待处理中......' class="y_title_txt ac" type="text" name="" id="KVolume" value="" readonly='true'>  m³
			</div>			
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zkyfy']?>：</span><input class="y_title_txt ac" type="text" name="KTorns" id="KTorns" value="" readonly='true'>  USD
			</div>
		
			
		</div>
		<div class="yunshu" data='2' style="display:none">
			<div class="y_form1">
				 <span class="y_title"><?=$website_language['supplier_clear'.$lang]['ysgsmc']?>：</span>
				 <select name="FirmNamex" class="select_txt" id="sel1_1">
				 	<option ><?=$website_language['supplier_clear'.$lang]['qxzysgs']?></option>
				<?php 
					$shipping_row1 = $db->get_all('shipping',"Express=2");
					for ($i=0; $i < count($shipping_row1); $i++) { 
				?>
				 	<option value="<?=$shipping_row1[$i]['SId'];?>"><?=$shipping_row1[$i]['FirmName']?></option>
				<?php }?>
				 </select>
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zlbz']?>：</span><input class="y_title_txt " type="text" name="" id='KWeight_C_2' value="" readonly='true'>  例：USD/KG
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['tjbz']?>：</span><input class="y_title_txt " type="text" name="" id='KVolume_C_2' value="" readonly='true'>  例：USD/m³
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zzl']?>：</span><input class="y_title_txt " type="text" name="" id='KWeight_2' value="" readonly='true'>  KG
			</div>
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['ztj']?>：</span><input class="y_title_txt " type="text" name="" id='KVolume_2' value="" readonly='true'>  m³
			</div>
			
			<div class="y_form">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['zhyfy']?>：</span><input class="y_title_txt " type="text" name="HTorns" id='KTorns_2' value="" readonly='true'>  USD
			</div>
			
		</div>
		<div class="yunshu" data='3' style="display:none">
			<div class="y_form1">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['ysgsmc']?>：</span><input class="y_title_txt " type="text" name="YName" value="<?=$order_row['YName']?>">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['gslxfs1']?>：</span><input class="y_title_txt " type="text" name="YContact1" value="<?=$order_row['YContact1']?>">
			</div>
			<div class="y_form1">
				<span class="y_title"><?=$website_language['supplier_clear'.$lang]['gslxfs2']?>：</span><input class="y_title_txt " type="text" name="YContact2" value="<?=$order_row['YContact2']?>">
			</div>			
		</div>
	<!-- 	<div class="y_form">
				<span class="y_title">运输地址：</span><input class="y_title_txt" type="text" name="ShippingAddressLine1" value="<?=$member_row['ShippingAddressLine1']?>">
			</div> -->
			<!-- <div class="y_form">
				<span class="y_title">收货人：</span><input class="y_title_txt" type="text" name="FirstName" value="<?=$member_row['FirstName']?>">
			</div> -->
		<div class="y_form1">
	        	<span style="float:left" class="span_title"><?=$website_language['supplier_clear'.$lang]['qgdlfs']?>：</span>
	        	<div class="w_800">
	        		<div class="ysc"><a  class="y_input"><input data='1' class="input_r qingguanfangshir" checked type="radio" value="1" name="Clearance" id=""><span  class='input_s'><?=$website_language['supplier_clear'.$lang]['yygjdlqg']?></span></a></div>
	        		<div class="ysc"><a  class="y_input"><input data='2' class="input_r qingguanfangshir" type="radio" value="0" name="Clearance" id=""><span class='input_s'><?=$website_language['supplier_clear'.$lang]['zxqg']?></span></a></div>
	        	</div>
	        	<div class="y_form ycw">
					<span  class="y_title"><?=$website_language['supplier_clear'.$lang]['qgfy']?>：</span><input class="y_title_txt" type="text" name="QPrice" value="<?=$order_row['QPrice']?>" readonly='true'>USD
				</div>
		</div>
		<div class="bbg2">
		<div data='1' class="c1 qingguanfanshi">
			<div class="y_check"><span class="span_title2"><?=$website_language['user_ol'.$lang]['zffs']?>：</span>
<!-- 					<div class="ysc"><a data='1' class="y_input"><input class="input_r" data='1' checked type="radio" value="<?=$order_row['HPrice']?>" name="1" id=""><span  class='input_s'><?=$website_language['user_ol'.$lang]['xszf']?></span></a></div> -->
	        		<div class="ysc"><a data='1' class="y_input"><input class="input_r" data='2' type="radio" value="1" name="PaymentMethod" checked id=""><span class='input_s'><?=$website_language['user_ol'.$lang]['xxzf']?></span></a></div>
           	</div>	
           	<div class="clear"></div>	         
           	<div class="d1">
           		<div  style="" class="pay_list">
           			<li data='1' class="li_list li_list2"><?=$website_language['user_ol'.$lang]['bmdzf']?></li>
           			<li data='2' class="li_list"><?=$website_language['user_ol'.$lang]['gjhk']?></li>
           			<li data='3' class="li_list"><?=$website_language['user_ol'.$lang]['zggnfk']?></li>
           			<li data='4' class="li_list"><?=$website_language['user_ol'.$lang]['xlhk']?></li>
           		</div>
           		<div class="clear"></div>
           		<div class="e1">
           			<div data='1' class="pay_li">
           				<div class="he_mask"><span>MATRIZ </span><span class='h23'>：</span><span>TECHNOPARK REPUBLICA DE 	URUGUAY 48-9 COLONIA CENTRO CP.06000 MEXICO CITY </span>
						</div>
						<div class="he_mask"><span>TEL</span><span class='h23'>：</span><span>0155-50864939</span>
						</div>
						<div class="he_mask"><span>SUCURSAL TERESA  </span><span class='h23'>：</span><span>AV.EJE CENTRAL LAZARO CARDENAS 109 LOC. 184 COLONIA CENTRO CP.06070 MEXICO CITY </span>
						</div>
						<div class="he_mask"><span>SUCURSAL URUGUAY</span><span class='h23'>：</span><span>REPUBLICA DE URUGUAY 12 LOCAL 5 Y 6 COLONIA CENTRO CP.06000 MEXICO CITY </span>
						</div>						
           			</div>
           			<div data='2' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_140'><?=$website_language['user_ol'.$lang]['yygjskzh']?></span><span class='h23'>：</span><span>6232 6320 0010 0279 008 </span>
						</div>
						<div class="he_mask"><span class='w_140'><?=$website_language['user_ol'.$lang]['skr']?></span><span class='h23'>：</span><span><?=$website_language['user_ol'.$lang]['zjgs']?>-50864939</span>
						</div>	
						<div class="h12"><?=$website_language['user_ol'.$lang]['zt']?></div>
						<div class="h13"><?=$website_language['user_ol'.$lang]['zf']?></div>					
           			</div>
           			<div data='3' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_270'><?=$website_language['user_ol'.$lang]['zggnfkzh']?></span><span class='h23'>：</span><span>6217 9311 0023 0483</span>
						</div>
						<div class="he_mask"><span class='w_270'><?=$website_language['user_ol'.$lang]['skr']?></span><span class='h23'>：</span><span>颜国飘</span>
						</div>	
						<div class="h12"><?=$website_language['user_ol'.$lang]['zt']?></div>
						<div class="h13"><?=$website_language['user_ol'.$lang]['zf']?></div>				
           			</div>
           			<div data='4' class="pay_li pay_li2">
           				<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['xlhkyhm']?></span><span class='h23'>：</span><span>YAN GUOPIAO 1984/07/02</span>
						</div>
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['sjhm']?></span><span class='h23'>：</span><span>13922882034</span>
						</div>	
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['xlhkyhm']?></span><span class='h23'>：</span><span>ZHEN YUNLEI 1986/09/05</span>
						</div>
						<div class="he_mask"><span class='w_170'><?=$website_language['user_ol'.$lang]['sjhm']?></span><span class='h23'>：</span><span>15976408881</span>
						</div>											
           			</div>
           		</div>
           	</div>
		</div>		
		
		<div data='2' style="display:none"  class="c1 qingguanfanshi">
			<div class="s_zixing" style=""><?=$website_language['supplier_clear'.$lang]['qnqd']?></div>
			<input type="hidden" name="OrderId" value="<?=$OrderId?>">
			<input type="hidden" name="MemberId" value="<?=$MemberId?>">
			<input type="hidden" name="mode" value="service">			
		</div>
		<div style="display:"  class="c1 qingguanfanshi">
			<div><input class="s_zixing2 psa" type="submit" value="确定"></div>
		</div>
	</div>

</div>
		
</form>
<script>
	window.sessionStorage.setItem('fangshi',1);
	window.sessionStorage.setItem('yunshu',1);
	$('.qingguanfangshir').click(function(){
		var dsas=$(this).attr('data');
		var asc=window.sessionStorage.getItem('yunshu');	
		window.sessionStorage.setItem('fangshi',dsas);
		$('.qingguanfanshi').each(function(){
			if(dsas=='1'){
				$('.bbg2').find('.qingguanfanshi:eq(0)').css('display','block');
				$('.bbg2').find('.qingguanfanshi:eq(1)').css('display','none');
				$('.ycw').css('display','block');
			}else if(dsas=='2' && asc=='3'){
				$('.bbg2').find('.qingguanfanshi:eq(1)').css('display','block');
				$('.bbg2').find('.qingguanfanshi:eq(0)').css('display','none');			
			} 
			if(dsas=='2'){
				$('.ycw').css('display','none');
			}
		})		
	})
	$('.yunshur').click(function(){
		var dsa=$(this).attr('data');
		var dacdsf=window.sessionStorage.getItem('fangshi');
		window.sessionStorage.setItem('yunshu',dsa);
		if(dsa=='3' && dacdsf=='2'){			
				$('.bbg2').find('.qingguanfanshi:eq(0)').css('display','none');
				$('.bbg2').find('.qingguanfanshi:eq(1)').css('display','block');						
			}else{
				$('.bbg2').find('.qingguanfanshi:eq(0)').css('display','block');
				$('.bbg2').find('.qingguanfanshi:eq(1)').css('display','none');

			}
		$('.yunshu').each(function(){			
			if($(this).attr('data')==dsa){
				$(this).css('display','block');
				$(this).find('.y_title_txt').addClass('ac');
			}else{
				$(this).css('display','none');
				$(this).find('.y_title_txt').removeClass('ac');
			}
		})
	})
	$('.input_r').click(function(){
			$('.y_input').css('color','#666');
			$(this).parent('.y_input').css('color','#006ac3');
		})
	$('.li_list').click(function(){
		var da=$(this).attr('data');
		$('.pay_li').each(function(){
			if($(this).attr('data')==da){
				$(this).css('display','block');
			}else{
				$(this).css('display','none');
			}
		})
		$('.pay_list').find('.li_list').css('border','1px solid #ccc');
		$('.pay_list').find('.li_list').css('background','none');
		$(this).css('border','1px solid #2962ff');
		$(this).css('background','url(/images/payment/queding.png) no-repeat bottom right');
	})

</script>
<script type="text/javascript">
$(function(){
	$("#sel1").change(function(){
		var val=$(this).val();
		var OrderId="<?=$OrderId?>";
		$.get(
			'/ajax/ajax_clear.php',{'SId':val,'key':'clear','OrderId':OrderId},function(data){
			var data=eval('(' +data+ ')');
			//console.log(data);
			if(data.Status==1){
				$("#KWeight").val(data.Weight);
				$("#KVolume").val(data.Volume);
				$("#KWeight_C").val(data.Weight_C);
				$("#KVolume_C").val(data.Volume_C);
				$("#KTorns").val(data.Weight*data.Weight_C);
			}
		});
	})
	
})
$(function(){
	
	$("#sel1_1").change(function(){

		var val=$(this).val();
		var OrderId="<?=$OrderId?>";
		$.get('/ajax/ajax_clear.php',{'SId':val,'key':'clear','OrderId':OrderId},function(data){
			var data=eval('(' +data+ ')');
			//console.log(data.Weight_C*data.Weight);
			if(data.Status==2){
				$("#KWeight_2").val(data.Weight);
				$("#KVolume_2").val(data.Volume);
				$("#KWeight_C_2").val(data.Weight_C);
				$("#KVolume_C_2").val(data.Volume_C);
				$("#KTorns_2").val(data.Volume_C*data.Volume);
			}
		});
	})
})
</script>
<?php include('../inc/common/footer.php');?>