<?php
	include('../inc/common/header.php');
?>
<link rel="stylesheet" href="/css/supplier/purchase.css">
<div class="index_box">
	<div class="index_logo"></div>
	<div class="index_search">
	<form action="">
		<input class="search_input" placeholder='输入产品名称' style="" type="text">	
		<input class="search_submit" type="button"  value="搜索">
	</form>		
	</div>		
</div>
<form action="">
<div class="mask">

	<div class="bbg">
		<div class="bg_title1" style="">收货人信息</div>
		<div class="he_mask"><span class='span_title' style="">收货人姓名</span>：<input class="hhe" type="text"></div>
		<div class="he_mask"><span class='span_title' style="">收货人邮箱</span>：<input class="hhe" type="text"></div>
		<div class="he_mask"><span class='span_title' style="">联系电话</span>：<input class="hhe" type="text"></div>
		<div class="he_mask"><span class='span_title' style="">邮政编码</span>：<input class="hhe" type="text"></div>
		<div class="he_mask"><span class='span_title' style="">收货地址</span>：<input class="hhe" type="text"><a href=""><input class="input_he" type="button" value="管理"></a></div>
		<div class="he_mask">
            <span class="span_title1">角色名称</span><span class='fuhao'>：</span><textarea class="tx" type="text"></textarea>
        </div>
	</div>
</div>
<div class="mask">
	<div class="Prompt">* 运输和清关的费用将会在5个工作日后得到，到时请您登录确认</div>
</div>
<div class="mask">
	<div class="bbg1">

		<div class="bg_title1">产品订单</div>
		<div class="title_a">
			<div class="a_150">产品图片</div>
			<div class="a_250">产品名称</div>
			<div class="a_150">单价</div>
			<div class="a_150">数量</div>
			<div class="a_150">总计</div>
		</div>
		<div class="content_a">
			<div class="content_t">
				<div class="content_a_150"><img class="content_a_img" src="/images/header/zhongguo.png" alt=""></div>
				<div class="content_a_250"><div class="p_name">BREAK手表型男运动时尚潮酷个性创意军表防 水夜光电子石英手表</div></div>
				<div class="content_b_150"><div class="b_a">US $42.00</div></div>
				<div class="content_b_150"><div class="b_b">100</div></div>
				<div class="content_b_150"><div class="b_c">US $42.00</div></div>
			</div>			
		</div>	
		<div class="ca_a">
			<div class="ca_b">
				<span class="ca_b1">实际付款</span>：<span class="ca_b2">US $4200.00</span>
				<div><input class="ca_b3" value="提交订单" type="submit"></div>
				<div class="ca_b4">*本次结算为产品价格，不包括运输费及清关税费</div>
			</div>
		</div>
	</div>
</div>
</form>
<?php
	include('../inc/common/footer.php');
?>