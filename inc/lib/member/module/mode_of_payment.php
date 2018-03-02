<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			.over-flow{
				overflow: hidden;
				zoom: 1;
			}
			.pay1{
				width: 700px;
				margin: 0 auto;
				border: 1px solid #D2D2D2;
				position: fixed;
				top: 50%;
			    left: 50%;
			    transform: translate(-50%,-50%);
			    background: #fff;
			}
			.payClose{
				font-size: 30px;
				position: absolute;
				right: 0;
				top: 0;
				width: 40px;
				height: 40px;
				text-align: center;
				line-height: 40px;
				color: #979797;
				cursor: pointer;
				text-decoration:none
			}
			.payClose:hover {
    			color: #979797;
   				text-decoration: none;
			}
			.payImg{
				width: 60px;
				height: 60px;
				border: 1px solid #d2d2d2;
				border-radius: 5px;
				padding: 10px;
				float: left;
			}
			.payImg img{
				width: 100%;
			}
			.payTitle{
				margin-left: 10px;
			}
			.shop{
				font-weight: bold;
			    border-bottom: 1px solid #D2D2D2;
			    margin: 0;
			    padding: 10px 20px;
			    background-color: #f7f7f7;
			}
			
			.imgDiv{
				padding: 10px 20px 0 20px;
			}
			
			.bgBlx{
				width: 100%;
			}
			
			.bgBlx img{
				width: 100%;
			}
			.modeTitle{
				float: left;
			}
			
			.modeUl{
				float: left;
				list-style: none;
				padding: 0;
			    margin-top: 8px;
			}
			
			.modeUl li{
				float: left;
				padding: 7px 5px;
				border: 1px solid #D2D2D2;
				border-radius: 5px;
				margin: 0 5px;
				cursor: pointer;
				position: relative;
				max-width: 110px;
			}
			
			.modeUl li:first-child{
				border-color: #f2761c;
			}
			
			.modeUl li:hover{
				border-color: #f2761c;
			}
			
			.payClick{
				width: 20px;
				height: 18px;
				position: absolute;
				right: 0;
				bottom: 0;
			}
			
			.payClick img{
				width: 100%;
				height: 100%;
				object-fit: cover;
			}
			.modePay{
			    width: 650px;
    			margin: 0 auto;
			}
			
			.payCon{
				padding-bottom: 20px;
			}
			
			.payUl{
				list-style: none;
				padding-bottom: 20px;
				margin: 0 auto;
				padding: 30px 0;
				width: 650px;
			}
			
			.payUl li{
				overflow: hidden;
				zoom: 1;
				margin: 5px 0;
			}
			
			.addressTitle{
				float: left;
				width: 137px;
				text-align: right;
			}
			
			.address1{
				float: left;
				width: 500px;
				margin-left: 10px;
			}
			
			.phoneTitle{
				float: left;
				width: 136px;
				text-align: right;
			}
			
			.phone{
				float: left;
				width: 500px;
				margin-left: 10px;
			}
			.nameInter{
				width: 170px;
				float: left;
				text-align: right;
			}
			.namePay{
				width: 168px;
				float: left;
				text-align: right;
			}
			.international{
				width: 430px;
				margin: 0 auto;
				display: none;
				padding: 30px 0;
			}
			.numInter{
				width: 250px;
				float: left;
			}
			.name{
				width: 200px;
				float: left;
			}
			
			.tips{
				width: 430px;
				margin: 0 auto;
				color: #ec6400;
				padding-top: 120px;
				font-size: 13px;
			}
			.wechatDiv{
				width: 140px;
				text-align: center;
				margin-left: 105px;
				padding: 30px 0;
			}
			.qrcode{
				width: 140px;
				height: 140px;
			}
			
			.qrcode img{
				width: 100%;
			}
			.wechatIcon{
				background-color: #44b047;
				width: 140px;
				height: 60px;
				overflow: hidden;
				zoom: 1;
			}
			.icon{
				float: left;
				width: 35px;
				height: 35px;
				margin: 12px 0 0 20px;
			}
			.icon img{
				width: 100%;
			}
			
			.iconFont{
				font-size: 14px;
				color: #fff;
				margin: 10px 0 0 10px;
				float: left;
			}
			
			.price{
				color: #b41919;
				font-size: 14px;
				margin: 5px 0;
			}
			
			.payIcon{
				background-color: #00a1e9;
				width: 140px;
				height: 60px;
				overflow: hidden;
				zoom: 1;
			}
			.wechat{
				display: none;
			}
			.payBao{
				display: none;
			}
		</style>
	</head>
	<body>
			<div id="pay1" class="pay1" style="display: none;">
			<a href="#" class="payClose">×</a>
			<p class="fontBlod shop">购买商品</p>
			<div class="over-flow imgDiv">
				<div class="payImg">
					<img src="/images/pay/pay.png"/>
				</div>
				<label class="payTitle">支付订单</label>
			</div>
			<div class="bgBlx">
				<img src="/images/pay/blx.png"/>
			</div>
			<div class="mode">
				<div class="over-flow modePay">
					<p class="modeTitle">支付方式：</p>
					<ul class="modeUl">
						<li id="payUl">
							本地门店支付
							<div class="payClick"><img src="/images/pay/payClick.png"/></div>
						</li>
						<li id="international">国际汇款</li>
						<li id="wechat">微信支付</li>
						<li id="payBao">支付宝支付</li>
						<li id="domestic">中国国内汇款</li>
						<li id="union">西联</li>
					</ul>
				</div>
				<div class="payCon">
					<ul class="payUl over-flow" id="payUlDiv">
						<li>
							<div>
								<div class="addressTitle">墨西哥某某店地址 :</div>
								<div class="address1">墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址</div>
							</div>
							<div>
								<div class="phoneTitle">联系电话 :</div>
								<div class="phone">0000-0000000 0000-0000000</div>
							</div>
						</li>
						<li>
							<div>
								<div class="addressTitle">墨西哥某某店地址 :</div>
								<div class="address1">墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址</div>
							</div>
							<div>
								<div class="phoneTitle">联系电话 :</div>
								<div class="phone">0000-0000000 0000-0000000</div>
							</div>
						</li>
						<li>
							<div>
								<div class="addressTitle">墨西哥某某店地址 :</div>
								<div class="address1">墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址墨西哥某某店地址</div>
							</div>
							<div>
								<div class="phoneTitle">联系电话 :</div>
								<div class="phone">0000-0000000 0000-0000000</div>
							</div>
						</li>
					</ul>
					<div class="international over-flow" id="internationalDiv">
						<div class="over-flow">
							<div class="nameInter">鹰洋国际贸易收款帐号 :</div>
							<div class="numInter">0000 0000 0000000000000</div>
						</div>
						<div>
							<div class="namePay">收款人 :</div>
							<div class="name">***</div>
						</div>
						<div class="tips">
							注：帐号汇款时请仔细确认汇款帐号和收款人是否正确，并备注相对应的订单号，如有疑问请及时与当地客服联系！如因个人原因导致汇款错误，鹰洋国际贸易不承担法律责任！
						</div>
					</div>
					<div class="wechat" id="wechatDiv">
						<div class="wechatDiv">
							<div class="qrcode">
								<img src="/images/pay/qrCode.png"/>
							</div>
							<div class="wechatIcon">
								<div class="icon">
									<img src="/images/pay/sao.png"/>
								</div>
								<span class="iconFont">
									微信扫码<br />
									完成支付
								</span>
							</div>
							<div class="price">
								US $ 000.00
							</div>
						</div>
					</div>
					<div class="payBao" id="payBaoDiv">
						<div class="wechatDiv">
							<div class="qrcode">
								<img src="/images/pay/qrCode.png"/>
							</div>
							<div class="payIcon">
								<div class="icon">
									<img src="/images/pay/sao.png"/>
								</div>
								<span class="iconFont">
									扫支付码<br />
									完成支付
								</span>
							</div>
							<div class="price">
								US $ 000.00
							</div>
						</div>
					</div>
					<div class="international over-flow" id="domesticDiv">
						<div class="over-flow">
							<div class="nameInter">鹰洋国际贸易收款帐号 :</div>
							<div class="numInter">0000 0000 0000000000000</div>
						</div>
						<div>
							<div class="namePay">收款人 :</div>
							<div class="name">***</div>
						</div>
						<div class="tips">
							注：帐号汇款时请仔细确认汇款帐号和收款人是否正确，并备注相对应的订单号，如有疑问请及时与当地客服联系！如因个人原因导致汇款错误，鹰洋国际贸易不承担法律责任！
						</div>
					</div>
					<div class="international over-flow" id="unionDiv">
						<div class="over-flow">
							<div class="nameInter">鹰洋国际贸易收款帐号 :</div>
							<div class="numInter">0000 0000 0000000000000</div>
						</div>
						<div>
							<div class="namePay">收款人 :</div>
							<div class="name">***</div>
						</div>
						<div class="tips">
							注：帐号汇款时请仔细确认汇款帐号和收款人是否正确，并备注相对应的订单号，如有疑问请及时与当地客服联系！如因个人原因导致汇款错误，鹰洋国际贸易不承担法律责任！
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".modeUl li").click(function(){
					$(".payClick").remove();
					$(".modeUl li").css("border-color","#D2D2D2");
					$(this).css("border-color","#f2761c");
					$(this).append('<div class="payClick"><img src="/images/pay/payClick.png"/></div>');
				});
				
				$("#payUl").click(function(){
					$("#payUlDiv").css("display","block");
					$("#internationalDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				
				$("#international").click(function(){
					$("#internationalDiv").css("display","block");
					$("#payUlDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				
				$("#wechat").click(function(){
					$("#wechatDiv").css("display","block");
					$("#payUlDiv").css("display","none");
					$("#internationalDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				
				$("#payBao").click(function(){
					$("#payBaoDiv").css("display","block");
					$("#internationalDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payUlDiv").css("display","none");
					$("#domesticDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				$("#domestic").click(function(){
					$("#domesticDiv").css("display","block");
					$("#payUlDiv").css("display","none");
					$("#internationalDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#unionDiv").css("display","none");
				});
				$("#union").click(function(){
					$("#unionDiv").css("display","block");
					$("#payUlDiv").css("display","none");
					$("#internationalDiv").css("display","none");
					$("#wechatDiv").css("display","none");
					$("#payBaoDiv").css("display","none");
					$("#domesticDiv").css("display","none");
				});

				$("#payCl").click(function(){
					$("#pay1").css("display","block");
				});
			});
		</script>
	</body>
</html>
