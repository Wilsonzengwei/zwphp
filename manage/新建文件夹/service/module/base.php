<form style="background:#fff;min-height:600px;width:95%;overflow:hidden" action="" method="post" class="act_form" enctype="multipart/form-data">
	<div style="color:#3894e1;font-size:14px;font-weight:bold;text-indent:10px;margin-top:20px;line-height:50px">基本信息</div>
	<div class="y_form"><span class="y_title">订单号：</span><input class="y_title_txt" type="text" value="<?=$order_row['OrderId']?>"></div>
	<div class="y_form"><span class="y_title">订单时间：</span><input class="y_title_txt" type="text" value="<?=$order_row['OrderTime']?>"></div>
	<div class="y_form"><span class="y_title">客户名称：</span><input class="y_title_txt" type="text" value="<?=$order_row['ShippingFirstName'].$order_row['ShippingLastName']?>"></div>
	<div class="y_form"><span class="y_title">客户邮箱：</span><input class="y_title_txt" type="text" value="<?=$order_row['Email']?>"></div>
	<div class="y_form"><span class="y_title">产品名称：</span><input class="y_title_txt" type="text" value="<?=$order_product_name?>"></div>
	<div class="y_form"><span class="y_title">产品单价：</span><input class="y_title_txt" type="text" value="<?=$order_product_row['Price']?>"></div>
	<div class="y_form"><span class="y_title">订单数量：</span><input class="y_title_txt" type="text" value="<?=$order_product_row['Qty']?>"></div>
	<div class="y_form"><span class="y_title">订单总价：</span><input class="y_title_txt" type="text" value="<?=$order_row['TotalPrice']?>"></div>
	<div class="y_form"><span class="y_title">清关方式：</span><input class="y_title_txt" type="text" value="<?=$order_row['AgentMode']?>"></div>
	<div class="y_form"><span class="y_title">运输方式：</span><input class="y_title_txt" type="text" value="<?=$order_row['ExpressCompany']?>"></div>
	<div class="y_form"><span class="y_title">仓库地址：</span><input class="y_title_txt" type="text" value="<?=$order_row['Stowage']?>"></div>
	<div class="y_form"><span class="y_title">起订量：</span><input class="y_title_txt" type="text" value="<?=$StartFromorder['StartFrom']?>"></div>
	<div class="y_form"><span class="y_title">收货地址：</span><input class="y_title_txt" type="text" value="<?=$order_row['ShippingAddressLine1']?>"></div>
	<div class="y_form"><span class="y_title">付款状态：</span><input class="y_title_txt" type="text" value="<?=$order_status_ary[$order_row['OrderStatus']];?>"></div>
	<div class="y_form"><span class="y_title">付款方式：</span><input class="y_title_txt" type="text" value=""></div>
	<div class="y_form"><span class="y_title">邮政编码：</span><input class="y_title_txt" type="text" value="<?=$order_row['ShippingPostalCode']?>"></div>
	<div class="y_form"><span class="y_title">联系电话：</span><input class="y_title_txt" type="text" value="<?=$moblie['Supplier_Mobile']?>"></div>
	<div style="width:100%;margin-top:20px;float:left;position:relative">
        <span style="position:absolute;top:0px" class="y_title">订单留言：</span><textarea style="width:750px;height:120px;border:1px solid #ccc;border-radius:3px;margin-left:105px" type="text"></textarea>
    </div>
    <div class="y_submit">
        <a class="ys_input_a" href="index.php">返回</a>
    </div>
</form>
<?php include('../../inc/manage/footer.php');?>