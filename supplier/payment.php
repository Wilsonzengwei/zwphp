<?php
	include('../inc/common/header.php');
?>
<link rel="stylesheet" href="/css/supplier/payment.css">
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='输入产品名称' style="" type="text">	
		<input class="search_submit" type="button"  value="搜索">
	</form>		
	</div>		
</div>
<div class="mask">
	<div class="bbg">
		<div class="b1">
			<div class="b2" style="5">
				<img class="b2_img" src="/images/header/zhongguo.png">
			</div>
			<div class="b3">
				<div class="he_mask"><span class='span_title'>商品名称</span><span class='he1'>：</span><div class="hhe">BREAK手表型男运动时尚潮酷个性创意军表防水夜光电子石英手表</div>
				</div>
				<div class="he_mask"><span class='span_title'>卖家名称</span><span class='he1'>：</span><div class="hhe">鹰洋国际贸易有限公司</div>
				</div>
				<div class="he_mask"><span class='span_title'>交易金额</span><span class='he1'>：</span><div class="ca_b2">111111111111</div>
				</div>
				<div class="he_mask"><span class='span_title'>购买时间</span><span class='he1'>：</span><div class="hhe">2017年12月06日  16:56</div>
				</div>				
				<div class="he_mask"><span class='span_title'>订单号</span><span class='he1'>：</span><div class="hhe">MX2017120616560070</div>
				</div>
		</div>		
		</div>
	</div>
</div>
<div class="mask">
	<div class="bbg2">
		<div class="c1">
			<div class="y_check"><span class="yc_title">支付方式：</span>
					<a class="y_input"><input class="input_r" type="radio" value="1" name="Status" checked><span class='input_s'>线上支付</span></a>
					<a class="y_input"><input class="input_r" type="radio" value="0" name="Status" id=""><span class='input_s'>线下支付</span></a>
           	</div>	
           	<div class="clear"></div>	         
           	<div class="d1">
           		<div  style="" class="pay_list">
           			<li data='1' class="li_list li_list2">本地门店支付</li>
           			<li data='2' class="li_list">国际汇款</li>
           			<li data='3' class="li_list">中国国内汇款</li>
           			<li data='4' class="li_list">西联汇款</li>
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
           				<div class="he_mask"><span>鹰洋国际贸易收款帐号</span><span class='h23'>：</span><span>6232 6320 0010 0279 008 </span>
						</div>
						<div class="he_mask"><span>收款人</span><span class='h23'>：</span><span>深圳市前海鹰洋国际贸易有限公司-50864939</span>
						</div>	
						<div class="h12">注：帐号汇款时请仔细确认汇款帐号和收款人是否正确，并备注相对应的订单号，如有疑问请及时与当地客服联系！</div>
						<div class="h13">如因个人原因导致汇款错误，鹰洋国际贸易不承担法律责任！</div>					
           			</div>
           			<div data='3' class="pay_li pay_li2">
           				<div class="he_mask"><span>中国国内汇款帐号</span><span class='h23'>：</span><span>6217 9311 0023 0483</span>
						</div>
						<div class="he_mask"><span>收款人</span><span class='h23'>：</span><span>颜国飘</span>
						</div>	
						<div class="h12">注：帐号汇款时请仔细确认汇款帐号和收款人是否正确，并备注相对应的订单号，如有疑问请及时与当地客服联系！</div>
						<div class="h13">如因个人原因导致汇款错误，鹰洋国际贸易不承担法律责任！</div>				
           			</div>
           			<div data='4' class="pay_li pay_li2">
           				<div class="he_mask"><span>西联汇款用户名</span><span class='h23'>：</span><span>YAN GUOPIAO 1984/07/02</span>
						</div>
						<div class="he_mask"><span>手机号码</span><span class='h23'>：</span><span>13922882034</span>
						</div>	
						<div class="he_mask"><span>西联汇款用户名</span><span class='h23'>：</span><span>ZHEN YUNLEI 1986/09/05</span>
						</div>
						<div class="he_mask"><span>手机号码</span><span class='h23'>：</span><span>15976408881</span>
						</div>											
           			</div>
           		</div>
           	</div>
		</div>
	</div>
</div>
<script>
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
<?php
	include('../inc/common/footer.php');
?>