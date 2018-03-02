<?php 
	$MemberId = $_SESSION['member_MemberId'];
	$username = $_SESSION['UserName'];
	$IsSupplier = $_SESSION['IsSupplier'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit"> 
<link href="/js/plugin/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
<link href="/css/iconfont.css" rel="stylesheet" type="text/css" />

<link href="/css/yxx_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/header.css" />
<script language="javascript" src="/js/jquery-2.1.0.js"></script>
<script language="javascript" src="/js/include.js"></script>
</head>
<body>
<div style="height:36px;">
	<div class="header-top_mask_top">
			<div class="header-top">
			<span class="top-left">
				<span class="top-welcome"><a href="/index.php">欢迎来到鹰洋国际</a>
				<?php if($MemberId != ''){?>
					<span class="top-reg"><a href="#"><?=$username?></a></span>&nbsp;&nbsp;&nbsp;
					<span class="top-login"><a href="/account.php?module=logout">注销</a></span>
				<?php }else{ ?>
				</span>
				<span class="top-reg"><a href="/account.php?module=create&act=1">免费注册</a></span>
				<span class="top-login"><a href="/account.php?module=login">请登录</a></span>
				<?php };?>
			</span>			
			<span class="top-right">
				<div class="span_lang"><a target="_blank" href="http://localhost/new2/index.php">客户服务</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="<?=$IsSupplier == '1' ? '/supplier_manage/product.php?act=3&SupplierId='.$MemberId : '/user.php?module=orders&act=1' ;?>">订单查询</a><a href="">托运查询</a></div><font>|</font></div>
				<div class="span_lang"><a href="/help.php">帮助中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="/help.php?data=1">普通客户协议</a><a href="/help.php?data=2">普通商家协议
</a><a href="/help.php?data=3">eaglehome协议</a></div><font>|</font></div>
				<!-- <div class="span_lang"><a href="">RFQS</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">RFQS</a></div><font>|</font></div> -->
				<div class="span_lang"><a href="">个人中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i>
				<div class="sun">

					<a href="/user.php?module=index">我的信息</a>

					<?php if($IsSupplier != '1'){?>
						<a href="/user.php?module=orders&act=1">我的订单</a>
						<a href="/user.php?module=coll&act=1">我的收藏</a>
						<a href="/user.php?module=cart&act=1">我的购物车</a>
						<a href="/user.php?module=address&act=1">收货地址</a>
					<?php }?>
				</div><font>|</font></div>
				<div class="span_lang"><a href="">卖家中心</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a class="bxdrcnfw" href="/supplier_manage/index.php?act=1&SupplierId=<?=$MemberId?>">店铺管理</a><a class="bxdrcnfw" href="/supplier_manage/product.php?act=3&SupplierId=<?=$MemberId?>" class="bxdrcnfw">产品管理</a><a href="/supplier_manage/order.php?act=4&SupplierId=<?=$MemberId?>" class="bxdrcnfw">订单管理</a></div><font>|</font></div>
				<div class="span_lang"><div class="sun_img">
					<img style="margin-top:9px" src="/images/header/xibanya.png" alt="" />
					</div><span class="sun_a" href="">语言</span><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun">
					<a class="sun_aa" target='_blank' href="#1">
						<div class="sun_div">
						<div class="sun_img">
						<div class="clear"></div>
						<img src="/images/header/zhongguo.png" alt="" />
						</div><span class="sun_a" href="">中国</span>
						</div>
					</a>
					<a class="sun_aa" target='_blank' href="#2">
						<div class="sun_div">
							<div class="sun_img">
							<div class="clear"></div>
							<img src="/images/header/xibanya.png" alt="" />
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
	$('.sun_aa').click(function(){
		location=location;
	})
	$('.sun').find('a:last').css('padding-bottom','10px');

</script>

 <script>
    var  email = "<?=$_SESSION['member_MemberId']?>";
    var  IsSupplier = "<?=$_SESSION['IsSupplier']?>";
     $(".bxdrcnfw").click(function(){
        if(email==""){
            var til_1 = "需要登入才能访问";
            alert(til_1);
            window.location.href="/account.php?module=login";
            return false;
        }else if(IsSupplier == '0'){
        	var til_2 = "只有卖家才能能访问";
            alert(til_2);
            window.location.href="/";
            return false;
        }
       
    })
</script>


