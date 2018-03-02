<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit"> 
<link href="/js/plugin/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
<link href="/css/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/css/yxx_style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../js/jquery-2.1.0.js"></script>
</head>
<style>
*{
	padding:0px;margin:0px;
	outline:none;
	font-family:'Microsoft YaHei';
}
body{
	background:#e0e0e0;
	position:relative;
}
/*div{
	overflow:hidden;
}*/
a{
	cursor:pointer;
	text-decoration: none;
	font-size:12px;
	color:#666666;
}
.clear{
	clear:both;
}
a:hover{
	color:#2962ff;
}
.header-top_mask_top{
	width:100%;background:#f2f2f2;border-bottom:1px solid #eee;
}
.header-top{
	width:1230px;height:36px;line-height:36px;font-size:12px;color:#999999;position:relative;margin:auto;
}
.header-top>span{
	padding-left: 5px;padding-right: 5px;
}
.header-top .top-left>span{
	cursor:pointer;
	padding:0 5px;
}
.header-top .top-left>span>a:hover{
	color:#2962ff;
}
.header-top  .top-reg>a{
	color:#999;
}
.header-top  .top-welcome>a{
	color:#999;
}

.top-login>a{
	color:#999;
}
.top-right{
	display: inline-block;position:absolute;right:0px;
}
.top-right>.span_lang{
	min-width:10px;padding:0 5px;cursor:pointer;position:relative;float: left;
}
.span_lang>font{
	margin-left:5px;
}
.top-right .sun{
	width:100%;position:absolute;top:30px;
	z-index: 999;
}
.top-right .sun>a{
	display:inline-block;
	width:100%;
	line-height:20px;
	color:#999;
}
.top-right .sun .sun_aa{
	display: inline-block;
	height:20px;
	line-height:20px;
}
.top-right .sun_lang{
	width:100%;position:absolute;top:30px;
}
.top-right .sun_lang>a{
	display:inline-block;
	width:100%;
	color:#999;
}
.sun_a{
	margin-left:5px;
}
.sun_a:hover{
	color:#2962ff;;
}
.sun{
	background-color: #fff;
	display: none;
}
.sun_div{
	width:100%;
}
.sun_img{
	width:20px;height:14px;float:left;margin-top:3px;
}
.sun_div>.sun_img>img{
	width:100%;height:100%;
}
.top-right .sun>a:hover{	
	color:#2962ff;
}

</style>
<div style="height:36px;">
	<div class="header-top_mask_top">
			<div class="header-top">
			<span class="top-left">
				<span class="top-welcome"><a href="">欢迎来到鹰洋国际</a></span>
				<span class="top-reg"><a href="">免费注册</a></span>
				<span class="top-login"><a href="">请登录</a></span>				
			</span>			
			<span class="top-right">
				<div class="span_lang"><a target="_blank" href="http://localhost/new2/index.php">客户服务</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">订单查询</a><a href="">订单查询</a><a href="">订单查询</a><a href="">订单查询</a></div><font>|</font></div>
				<div class="span_lang"><a href="">帮助中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">注册流程</a><a href="">注册协议</a><a href="">常见问题</a></div><font>|</font></div>
				<div class="span_lang"><a href="">RFQS</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">RFQS</a></div><font>|</font></div>
				<div class="span_lang"><a href="">个人中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">我的信息</a></div><font>|</font></div>
				<div class="span_lang"><a href="">卖家中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">店铺管理</a><a href="">产品管理</a><a href="">订单管理</a></div><font>|</font></div>
				<div class="span_lang"><div class="sun_img">
					<img style="margin-top:9px" src="images/header/xibanya.png" alt="" />
					</div><span class="sun_a" href="">语言</span><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun">
					<a class="sun_aa" href="#1">
						<div class="sun_div">
						<div class="sun_img">
						<div class="clear"></div>
						<img src="images/header/zhongguo.png" alt="" />
						</div><span class="sun_a" href="">中国</span>
						</div>
					</a>
					<a class="sun_aa" href="#2">
						<div class="sun_div">
							<div class="sun_img">
							<div class="clear"></div>
							<img src="images/header/xibanya.png" alt="" />
							</div><span class="sun_a" href="">墨西哥</span>
						</div>
					</a>
					</div><font>|</font>
				</div>		
			</span>			
		</div>
	</div>
</div>
<script>
	$(".span_lang").hover(function(){	
		$(this).find('.sun').css('display','block');
	},function(){
		$('.span_lang').find('.sun').css('display','none');
		
	})	
</script>