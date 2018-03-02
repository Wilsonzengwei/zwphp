<?php

//$freight_stutas_row = $db->get_all('freight_stutas',)
?>

	<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			.titleState {
				position: relative;
				border-bottom: 2px solid #ddd;
				margin-top: 15px;
			}
			
			.titleInfo {
				height: 24px;
				line-height: 24px;
				font-weight: bold;
			}
			
			.mid {
				width: 100%;
				text-align: center;
				position: absolute;
				top: 0;
				left: 0;
				z-index: -1;
			}
			
			.right {
				float: right;
				margin-right: 13px;
			}
			
			.table-state tr td {
				padding: 5px;
			}
			
			.time-state {
				width: 70px;
				text-align: center;
			}
			
			.textCenter {
				text-align: center;
			}
			
			.sign-state {
				width: 40px;
			}
			.form_button{
				width: 50px;
			}
			
			
			.timeInfo {
				height: 50px;
				width: 70px;
				text-align: center;
			}
			
			.tips-state {
				width: 100%;
				text-align: center;
				color: #313131;
				padding: 10px 0;
				border-bottom: 2px solid #ddd;
			}
			
			.cost {
				width: 100%;
				border-collapse: separate;
				border-spacing: 0px 10px;
			}
			
			.cost td {
				height: 30px;
			}
			
			.cost tr {
				background-color: #ffd4d4;
				margin: 10px 0;
			}
			
			.tips-cost {
				width: 60%;
				padding-left: 100px;
			}
			
			.num-cost {
				width: 40%;
				text-align: right;
			}
			
			.lab-cost {
				margin: 0 10px 0 35px;
				color: #B50C08;
			}
			.all{
				width: 1000px;
				margin: 0 auto;
			}
			.conBtn{
				margin-right: 10px;
				background-color: #62A8EA;
				border: 0;
				outline: none;
				color: #fff;
				padding: 5px 10px;
				cursor: pointer;
			}
			.inp-width-500{
				min-width: 550px;
			}
			.orders_table td{
				height: 30px;
				padding: 10px;

			}
			.orders_table_1 {
				
				border: 1px solid #cdcdcd;
			}
			.orders_table_1 td{
				height: 30px;
				padding: 10px;
				border: 1px solid #cdcdcd;
			}
		</style>
	<div style="width:1000px;margin: auto;">
		<table width="1000px"  class="orders_table_1" cellpadding="0" cellspacing="0" >

			<form method="post" name="act_form_8" class="act_form"  action="view.php" onsubmit="return checkForm(this);">
			<input type="hidden" name="shippingcharges_r" class="form_input" value="shippingcharges_r">
			<tr>
				<td width="100px" height="60px" nowrap rowspan="3" style="text-align:center;font-size:12px;" >清关及运输费用</td>
				<td width="5%" nowrap>跟进人:</td>
				<td width="95%" colspan="2"><input type="text" name="FollowUp" class="form_input" value="<?=$order_row['FollowUp'];?>"></td>
			</tr>
			
			
			
			<tr>
				<td nowrap><?=get_lang('shipping.modelname');?>:</td>
				<td><input name="shippingcharges" type="text" size="20" value="<?=$order_row['ShippingCharges'];?>" class="form_input" style="width: 100px;" /></td>
			</tr>
			<tr>
				<td nowrap><?=get_lang('shipping.CustomsClearance');?>:</td>
				<td><input name="CustomsClearance" type="text" size="20" value="<?=$order_row['CustomsClearance'];?>" class="form_input" style="width: 100px;" /></td>
			</tr>
			


			<tr>
			<td colspan="3" style="text-align:center; ">
				<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
			</td>
			</tr>
			
			
			</form>
			<form method="post" name="act_form_5"  action="view.php" onsubmit="return checkForm(this);">
				<tr>
					<td width="5%" nowrap>鹰洋仓库位置:</td>
					<td width="95%" colspan="2" ><input style="width: 500px;" type="text" name="LTX" class="form_input" value="<?=$order_row['Stowage'];?>">&nbsp;&nbsp;<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /></td>
				</tr>

			</form>
			
			<form method="post" name="act_form_4" class="act_form"  action="view.php" onsubmit="return checkForm(this);">
			<tr>
				<td width="100px" height="60px" nowrap rowspan="2" style="text-align:center;font-size:12px;"><?=get_lang('orders.transport_tracking');?></td>
				<td nowrap height="60px"><?=get_lang('orders.track_progress');?>:</td>
				<td height="60px"><input type="hidden" name="product_status_time" value="<?=time()?>"><input name="product_tutas" type="text" size="20" value="<?=$stutas_ros['ProductStutas'];?>" class="form_input" style="width: 500px;" /></td>
			</tr>
			<tr>
				<td nowrap><?=get_lang('orders.tracking_number_1');?>:</td>
				<td><input name="tracking_number_1" type="text" size="20" value="<?=$stutas_ros['TrackingNumber'];?>" class="form_input" /></td>
			</tr>
			
			<tr>
			<td colspan="3" style="text-align:center; ">
				<input type="submit" name="factory_order_row" class="form_button" value="提交"><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" />
			</td>
			</tr>
			
			
			</form>
		</table>
	</div>
		<div class="all">
			<div class="titleState">
				<span class="titleInfo"><?=$website_language['member'.$lang]['order']['waybillNumber']; ?>:<?=$stutas_ros['TrackingNumber']?></span>
				<span class="titleInfo mid"><?=$website_language['member'.$lang]['order']['company']; ?>:<?=$order_row['ExpressCompany']?></span>
				<span class="titleInfo right">客服电话:13722211000</span>
			</div>
			<table class="table-state">
				<tr>
					<td class="time-state">
						时间
					</td>
					<td class="sign-state"></td>
					<td class="content-state">
						进度追踪
					</td>
					<td></td>
				</tr>

			
				<?php for($i=0;$i<count($freight_stutas_row);$i++){?>
					<form name="orders_race<?=$i?>" method="post" class="mod_form" action="view.php" onsubmit="return checkForm(this);">
					<tr>
						<td class="timeInfo"><input type="hidden" name="StutasTime" value="<?=$freight_stutas_row[$i]['StutasTime']?>"><?=date("Y-m-d H:i:s",$freight_stutas_row[$i]['StutasTime'])?></td>
						<td class="signImg"></td>
						<td><input style="width: 500px;height: 30px;" type="text" name="shipping_status" class="form_input" value="<?=$freight_stutas_row[$i]['ProductStutas'];?>"></td>
						<td colspan="4"><input class="form_button"  type="submit" name="freight_stutas_alter" value="修改"></td><input type="hidden" name="OrderId" value="<?=$OrderId;?>" /><input type="hidden" name="module" value="<?=$module;?>" /><input type="hidden" name="shipping_val" value="shipping_status">
						
					</tr>
					
						
					
					</form>
				<?php }?>
			</table>
		</div>
		

