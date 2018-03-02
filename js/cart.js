function cart_add_cut_qty(value, obj, start_from, CId, ProId, cart_url, pro_stock){
	var qty=parseInt($_('Qty_'+obj).value);
	if(isNaN(qty)){
		$_('Qty_'+obj).value='';
		return;
	}
	qty+=value;
	!qty && (qty=1);
	qty<start_from && (qty=start_from);
	if(qty>pro_stock){qty=pro_stock;}
	$_('Qty_'+obj).value=qty;
	
	data_posting(true);
	update_cart_obj=new request_data();
	upcate_cart(obj, CId, ProId, qty, cart_url);
}

function upcate_cart(obj, CId, ProId, qty, cart_url){
	update_cart_obj.open('GET', cart_url+'?module=upcate_cart&obj='+obj+'&CId='+CId+'&ProId='+ProId+'&Qty='+qty+'&r='+Math.random(), true);
	update_cart_obj.onreadystatechange=function(){upcate_cart_result(obj)};
	update_cart_obj.send(null);
}

function upcate_cart_result(obj){
	if(update_cart_obj.readyState==4){ // 判断对象状态
		if(update_cart_obj.status==200){ // 信息已经成功返回，开始处理信息
			var txt=update_cart_obj.responseText;
			if(txt!=null && txt!=''){
				var allmsg=txt.split('|');
				$_('price_'+obj).innerHTML=allmsg[0];
				$_('sub_total_'+obj).innerHTML=allmsg[1];
				$_('total_price_0').innerHTML=$_('total_price_1').innerHTML=allmsg[2];
				$_('total_weight').innerHTML=allmsg[3];
				$_('total_item').innerHTML=allmsg[4];
				$_('discount_save').innerHTML=allmsg[5];
			}
		}
	}
	data_posting(false);
}

function cart_add_success(){
	
	cart_add_success_tips=parent.document.createElement('div');
	cart_add_success_tips.setAttribute('id', 'lib_cart_add_success');
	cart_add_success_tips.innerHTML=$_('lib_cart_add_success').innerHTML;
	parent.document.body.appendChild(cart_add_success_tips);
	scroll_cart_add_success();	//先马上执行一次，要不看起来会在左上角飞到中间来
	scroll_cart_add_success_timer=setInterval(scroll_cart_add_success, 50);
}

function scroll_cart_add_success(){	//弹出框跟随滚动
	parent.$_('lib_cart_add_success').style.left=(parent.document.documentElement.scrollLeft || parent.window.pageXOffset || parent.document.body.scrollLeft)+parent.doc.clientWidth/2-parent.$_('lib_cart_add_success').offsetWidth/2+'px';
	parent.$_('lib_cart_add_success').style.top=(parent.document.documentElement.scrollTop || parent.window.pageYOffset || parent.document.body.scrollTop)+parent.doc.clientHeight/2-parent.$_('lib_cart_add_success').offsetHeight/2+'px';
}

function cart_Saddress_also_Baddress(){
	$_('BillingFirstName').value=$_('ShippingFirstName').value;
	$_('BillingLastName').value=$_('ShippingLastName').value;
	$_('BillingAddressLine1').value=$_('ShippingAddressLine1').value;
	$_('BillingAddressLine2').value=$_('ShippingAddressLine2').value;
	$_('BillingCity').value=$_('ShippingCity').value;
	$_('BillingState').value=$_('ShippingState').value;
	$_('BillingPostalCode').value=$_('ShippingPostalCode').value;
	$_('BillingPhone').value=$_('ShippingPhone').value;
	var BillingCountry  = document.getElementsByName("BillingCountry")[0];
	var ShippingCountry = document.getElementsByName("ShippingCountry")[0];
	
	for(var i=0; i<$_('BillingTitle').options.length; i++){
		if($_('BillingTitle').options[i].value==$_('ShippingTitle').value){
			$_('BillingTitle').selectedIndex=i;
		}
	}
	
	for(var i=0; i<BillingCountry.length; i++){
		if(BillingCountry.options[i].value==ShippingCountry.value){
			BillingCountry.selectedIndex=i;
		}
	}
}

function cart_change_shipping_method(shipping_price, SId){
	$_('shipping_charges_span').innerHTML=shipping_price.toFixed(2);
	$_('grand_total_span').innerHTML=(parseFloat($_('subtotal_span').innerHTML)-($_('order_save')?parseFloat($_('order_save').innerHTML):0)-($_('order_money')?parseFloat($_('order_money').innerHTML):0)+shipping_price).toFixed(2);
	$_('shiping_method_SId').value=SId;
}

function cart_change_shipping_country(country, cart_url){
	$_('get_shipping_methods_iframe').src=cart_url+'?module=get_shipping_methods&Country='+country+'&n='+Math.random();
}

function shipping_method_init(shipping_price, SId){
	parent.$_('shipping_charges_span').innerHTML=shipping_price.toFixed(2);
	parent.$_('shipping_method_list').innerHTML=$_('shipping_method_list').innerHTML;
	parent.$_('grand_total_span').innerHTML=(parseFloat(parent.$_('subtotal_span').innerHTML)-(parent.$_('order_save')?parseFloat(parent.$_('order_save').innerHTML):0)-(parent.$_('order_money')?parseFloat(parent.$_('order_money').innerHTML):0)+shipping_price).toFixed(2);
	parent.$_('shiping_method_SId').value=SId;
}

function change_payment_method(obj, PId, payment_method_count, cart_url, OId){
	for(var i=0; i<payment_method_count; i++){
		$_('payment_method_a_'+i).className='payment_method';
		$_('payment_info_contents_'+i).style.display='none';
	}
	$_('payment_method_a_'+obj).className='payment_method payment_method_on';
	$_('payment_info_contents_'+obj).style.display='block';
	
	if(PId){
		var set_payment_method_obj=new request_data();
		set_payment_method_obj.open('GET', cart_url+'?module=set_payment_method&PId='+PId+'&OId='+OId+'&r='+Math.random(), true);
		set_payment_method_obj.send(null);
	}
}