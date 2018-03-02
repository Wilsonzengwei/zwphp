<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$website_url_type=0;	//链接地址类型，0：动态，1：静态，2：伪静态，当值为0时请设置$website_url_ary变量
$website_url_ary=array(
	'supplier_article'	=>	'return sprintf("/article.php?AId=%s&SupplierId=%s", $row["AId"],$row["SupplierId"]);',	//信息页分组一
	'article'			=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组一
	'article_group_0'	=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组一
	'article_group_1'	=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组二
	'article_group_2'	=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组三
	'article_group_3'	=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组四
	'article_group_4'	=>	'return sprintf("/article.php?AId=%s", $row["AId"]);',	//信息页分组五
	
	'info'				=>	'return sprintf("/info-detail.php?InfoId=%s", $row["InfoId"]);',	//文章详细页
	'info_category'		=>	'return sprintf("/info.php?CateId=%s", $row["CateId"]);',	//文章分类列表页
	
	'info_two'			=>	'return sprintf("/faq-detail.php?InfoId=%s", $row["InfoId"]);',	//文章详细页
	'info_two_category'	=>	'return sprintf("/faq.php?CateId=%s", $row["CateId"]);',	//文章分类列表页
	
	'instance'			=>	'return sprintf("/instance-detail.php?CaseId=%s", $row["CaseId"]);',	//成功案例详细页
	'instance_category'	=>	'return sprintf("/instance.php?CateId=%s", $row["CateId"]);',	//成功案例分类列表页
	
	'product'			=>	'return sprintf("/supplier/goods.php?ProId=%s&SupplierId=%s", $row["ProId"],$row["SupplierId"]);',	//产品详细页
	'product_category'	=>	'return sprintf("/products.php?CateId=%s", $row["CateId"]);',	//产品分类列表页
	'supplier_product_category'	=>	'return sprintf("/supplier/products.php?CateId=%s&SupplierId=%s", $row["CateId"],$row["SupplierId"]);',	//产品分类列表页
	'product_brand'		=>	'return sprintf("/brand.php?BId=%s", $row["BId"]);',	//产品品牌列表页
);

$LockChinaIp=0;	//是否屏蔽国内IP
($LockChinaIp==1 && (int)$_SESSION['ly200_AdminUserId']==0 && $_SERVER['PHP_SELF']!='/unavailable.php' && substr_count($_SERVER['PHP_SELF'], '/manage/')==0 && (preg_match('/zh-c/i', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4)) || preg_match('/zh/i', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4)))) && exit('<script language="javascript">window.top.location="/404.php";</script>');

//后台左菜单图标
$menu_logo_ary = array( // 0 图标 / 1 当前图标 
	'set'					=>	array('images/ico/left_bg03.png','images/ico/left_bg04.png','images/manage/top/Navigation02.png'),

	'buyers'				=>	array('images/ico/left_bg05.png','images/ico/left_bg06.png','images/manage/top/Navigation03.png'),

	'product'				=>	array('images/ico/left_bg07.png','images/ico/left_bg08.png','images/manage/top/Navigation04.png'),

	'orders_handle'			=>	array('images/ico/left_bg09.png','images/ico/left_bg10.png','images/manage/top/Navigation05.png'),

	'member_handle'			=>	array('images/ico/left_bg11.png','images/ico/left_bg12.png','images/manage/top/Navigation06.png'),

	'feedback'				=>	array('images/ico/left_bg15.png','images/ico/left_bg16.png','images/manage/top/Navigation07.png'),

	'article'				=>	array('images/ico/left_bg17.png','images/ico/left_bg18.png','images/manage/top/Navigation08.png'),

	'Pers_info'				=>	array('images/ico/left_bg19.png','images/ico/left_bg20.png','images/manage/top/Navigation09.png'),



	
);
$menu_logo_ary1 = array( // 0 图标 / 1 当前图标 
	'0'					=>	array('/images/index/yifu01.png','/images/index/yifu02.png'),

	'1'				=>	array('/images/index/xiezi01.png','/images/index/xiezi02.png'),

	'2'				=>	array('/images/index/shenghuojiaju01.png','/images/index/shenghuojiaju02.png'),

	'3'				=>	array('/images/index/dianzidianqi01.png','/images/index/dianzidianqi02.png'),

	'4'				=>	array('/images/index/wanju01.png','/images/index/wanju02.png'),

	'5'				=>	array('/images/index/shoushi01.png','/images/index/shoushi02.png'),

	'6'				=>	array('/images/index/riyong01.png','/images/index/riyong02.png'),

	'7'				=>	array('/images/index/bangong01.png','/images/index/bangong02.png'),

	'8'				=>	array('/images/index/meizhuang01.png','/images/index/meizhuang02.png'),

	'9'			=>	array('/images/index/huwai01.png','/images/index/huwai02.png'),

	'10'			=>	array('/images/index/qiche01.png','/images/index/qiche02.png'),
	
);
$menu_logo_ary2 = array( // 0 图标 / 1 当前图标 
	'0'				=>	array('/images/help/xieyi01.png','/images/help/xieyi02.png'),

	'1'				=>	array('/images/help/zhinan01.png','/images/help/zhinan02.png'),

	'2'				=>	array('/images/help/kefu01.png','/images/help/kefu02.png'),

	'3'				=>	array('/images/help/wenti01.png','/images/help/wenti02.png'),

	'4'				=>	array('/images/help/guanyu01.png','/images/help/guanyu02.png'),


	
);
$week_ary = array(
	'星期日',
	'星期一',
	'星期二',
	'星期三',
	'星期四',
	'星期五',
	'星期六',
);
$week_con_ary = array(
	'嫣然回首，你咋还没走。',
	'遇见你，靠近你，神安排的不容易。',
	'预测未来的最好办法是自己亲手创造未来。',
	'早起的鸟儿有虫吃，早起的虫儿被鸟吃。',
	'被溶解的华丽，都沉淀在繁华和现实的阴影里。',
	'幸福可以通过学习来获得，尽管，它不是我们的母语。',
	'彪悍的人生不需要解释。',
	'生，容易。活，容易。生活，不容易。'
);
//后台左菜单背景
$left_bg_ary = array( // 左边色块 
	'images/ico/left_bg0.jpg',
	'images/ico/left_bg1.jpg',
	'images/ico/left_bg2.jpg',
	'images/ico/left_bg3.jpg',
	'images/ico/left_bg4.jpg',
	'images/ico/left_bg5.jpg',
	'images/ico/left_bg6.jpg',
);
//-------------------------------------------------------------------购物网站配置，非购物网站可全部注释掉(start here)---------------------------------------------------------------
$_SESSION['Currency']=='' && $_SESSION['Currency']=$mCfg['ExchangeRate']['Default'];	//设置默认的币种
(int)$_SESSION['member_MemberId']==0 && $cart_SessionId=substr(md5(md5(session_id())), 0, 10);

$member_url='/account.php';	//会员中心的链接地址
$cart_url='/cart.php';	//购物车的链接地址

$order_product_weight=1;	//产品是否有重量参数（此参数影响购物车，会员中心订单查询，后台订单管理）
$order_product_price_field='Price_1';	//产品加入购物车使用的价格字段（有特价或是批发价还是会以这两个价格优先）
$order_product_start_from=0;	//产品是否有起订量（此参数只影响前台购物车，不影响后台订单管理）
$order_discount=0;	//订单折扣，最终价格计算方式：(1-$Discount)*原价，0为不打折，1为免费送产品了。。。
$order_checkout_mode=1;	//下订单模式，0：必须登录方可下订单，1：未登录也可以下订单
$order_default_status=1;	//订单默认状态
$order_status_ary=array(	//订单状态，加下标，为了可随时根据需要增加或删除项目

	'1' =>$website_language['supplier_m_order'.$lang]['wfk'],
	'2' =>$website_language['supplier_m_order'.$lang]['yfk'],
	'3' =>$website_language['supplier_m_order'.$lang]['kssc'],
	
	'5' =>$website_language['supplier_m_order'.$lang]['scwc'],
	'6' =>$website_language['supplier_m_order'.$lang]['ysz'],
	'7' =>$website_language['supplier_m_order'.$lang]['khyqs'],
	'8' =>$website_language['supplier_m_order'.$lang]['ywc'],
);
$order_status_ary_2=array(	//订单状态，加下标，为了可随时根据需要增加或删除项目

	
	'2' => $website_language['manage'.$lang]['order_10'],
	'3' => $website_language['manage'.$lang]['order_2'],
	
	'5' => $website_language['manage'.$lang]['order_3'],
	'6' => $website_language['manage'.$lang]['order_4'],
	'7' => $website_language['manage'.$lang]['order_5'],
	'8' => $website_language['member'.$lang]['order']['completed'],
);
$order_status_ary3=array(
	'1' =>'未付款',
	'2' =>'已付款',
	'3' =>'开始生产',
	
	'5' =>'生产完成',
	'6' =>'运输中',
	'7' =>'客户已签收',
	'8' =>'已完成'
	);
//默认产品列表排序 1:Name 2:Price 3:New 4:Best Sellers
$lyc['products_sort']=array(
	'1d'	=>	'MyOrder desc,',
	'2d'	=>	'IsPromotion desc,',
	'3d'	=>	'FavoriteCount desc,',
	'4d'	=>	'IsNew desc,',
	'5a'	=>	'Price_1 asc,',
	'5d'	=>	'Price_1 desc,'
)


//-------------------------------------------------------------------购物网站配置，非购物网站可全部注释掉(end here)-----------------------------------------------------------------
?>