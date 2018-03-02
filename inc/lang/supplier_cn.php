<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

$Ly200Lang=array(
	'ly200'			=>	array(
							'system_title'			=>	'网站后台管理系统',
							'n_y_array'				=>	array('否', '<font class="fc_red">是</font>'),
							'lang_array'			=>	array('lang_0'=>'西文版', 'lang_1'=>'中文版','lang_2'=>'英文版'),
							'time_format_ymd'		=>	'Y-m-d',
							'time_format_full'		=>	'Y-m-d H:i:s',
							'price_symbols'			=>	get_cfg('ly200.price_symbols'),
							
							'ip'					=>	'IP',
							'alt'					=>	'Alt',
							'logo'					=>	'Logo',
							'add'					=>	$website_language['manage'.$lang]['add'],
							'del'					=>	$website_language['manage'.$lang]['tra_slat37'],
							'copy'					=>	'复制',
							'mod'					=>	$website_language['manage'.$lang]['tra_slat115'],
							'submit'				=>	'提交',
							'move'					=>	'移动',
							'order'					=>	$website_language['manage'.$lang]['tra_slat25'],
							'turn'					=>	'跳转',
							'search'				=>	'搜索',
							'category'				=>	$website_language['manage'.$lang]['tra_slat31'],
							'list'					=>	$website_language['manage'.$lang]['tra_slat71'],
							'select'				=>	$website_language['manage'.$lang]['tra_slat24'],
							'anti_select'			=>	$website_language['manage'.$lang]['tra_slat36'],
							'number'				=>	$website_language['manage'.$lang]['tra_slat16'],
							'photo'					=>	$website_language['manage'.$lang]['tra_slat35'],
							'time'					=>	$website_language['manage'.$lang]['tra_slat67'],
							'operation'				=>	$website_language['manage'.$lang]['tra_slat28'],
							'return'				=>	'返回',
							'preview'				=>	$website_language['manage'.$lang]['ad_7'],
							'title'					=>	$website_language['manage'.$lang]['tra_slat109'],
							'name'					=>	$website_language['manage'.$lang]['tra_slat29'],

							'qty'					=>	$website_language['manage'.$lang]['tra_slat65'],
							'under_the'				=>	'隶属',
							'under_the_oth'			=>	'属性分类',
							'reset'					=>	'重置',
							'download'				=>	'下载',
							'view'					=>	'查看',
							'set'					=>	'设置',
							'invocation'			=>	'启用',
							'explanation'			=>	'说明',
							'default'				=>	'默认',
							'symbols'				=>	'符号',
							'email'					=>	$website_language['manage'.$lang]['tra_slat55'],
							'full_name'				=>	$website_language['manage'.$lang]['tra_slat64'],
							'cancel'				=>	'取消',
							'remark'				=>	'备注',
							'refer'					=>	'刷新',
							'not_invocation'		=>	'未启用',
							'pre_page'				=>	'上一页',
							'next_page'				=>	'下一页',
							'del_success'			=>	'删除成功',
							'display'				=>	'前台显示',
							'category_name'			=>	'类别名称',
							'language'				=>	'语言版本',
							'other_property'		=>	$website_language['manage'.$lang]['tra_slat30'],
							'brief_description'		=>	$website_language['manage'.$lang]['tra_slat113'],
							'contents'				=>	$website_language['manage'.$lang]['tra_slat112'],
							'description'			=>	$website_language['manage'.$lang]['tra_slat114'],
							'current_location'		=>	'当前位置',
							'is_in_index'			=>	'首页显示',
							'add_item'				=>	$website_language['manage'.$lang]['tra_slat104'],
							'filled_out'			=>	'请正确填写',
							'correct_upload'		=>	'请正确上传',
							'move_selected_to'		=>	'把选中的移动到',
							'no_permit'				=>	'对不起，您没有权限进行本次操作！',
							'confirm_del'			=>	'确定要删除吗？删除后不可还原，继续吗？',
							'confirm_reset'			=>	'确定要重置吗？重置后将删除所有的数据并且不可还原，继续吗？',
							'seo'					=>	array('seo'=>$website_language['manage'.$lang]['tra_slat108'], 'title'=> $website_language['manage'.$lang]['tra_slat109'], 'keywords'=>$website_language['manage'.$lang]['tra_slat110'], 'description'=>$website_language['manage'.$lang]['tra_slat111']),
							'upload_pic'			=>  $website_language['manage'.$lang]['tra_slat105'],
							'other'					=>  '其他',
							'briefinfo'				=>  $website_language['manage'.$lang]['tra_slat112'],
						),
	
	//ckeditor
	'ckeditor'		=>	array(
							'file_type_error'		=>	'上传失败，文件类型错误！',
							'file_upload_succ'		=>	'文件上传成功！',
						),
	
	//登录页
	'login'			=>	array(
							'tips'					=>	'* 请输入用户名与密码，登录网站后台管理中心！',
							'tips_v_code_error'		=>	'* 错误的验证码，请重新登录！',
							'tips_locked'			=>	'* 您的帐号被管理员锁定，无法登录！',
							'tips_failed'			=>	'* 错误的用户名或密码，请重新登录！',
							'success'				=>	'成功登录后台',
							'username'				=>	'用户名',
							'password'				=>	'密&nbsp;&nbsp;码',
							'v_code'				=>	'验证码',
							'reload_v_code'			=>	'看不清验证码？刷新',
						),
	
	//后台首页
	'home'			=>	array(
							'noscript'				=>	'您的浏览器还未启用Javascript，请先启用！',
							'service_tel'			=>	'售后服务热线:020-83226791',
							'welcome'				=>	'您好，<span>%s</span>！欢迎您使用鹰洋后台管理系统！',
							'website_home'			=>	'网站首页',
							'copyright'				=>	'<a href="http://www.eaglesell.com/" target="_blank">深圳市（前海）鹰洋国际贸易有限公司 &copy; 版权所有</a>',
							'system_home'			=>	'后台首页',
							'last_login'			=>	'上次登录时间',
							'current_login'			=>	'本次登录时间',
							'system_info'			=>	'系统信息',
							'php_version'			=>	'PHP程式版本',
							'mysql_version'			=>	'版本',
							'mysql_size'			=>	'占用',
							'system_os'				=>	'服务器端信息',
							'upload_max_size'		=>	'最大上传限制',
							'max_execution_time'	=>	'最大执行时间',
							'mail_support'			=>	'邮件支持模式',
							'cookie_test'			=>	'Cookie测试',
							'service_time'			=>	'服务器时间',
							'information'			=>	'信息'
						),
	
	//左菜单大项目
	'menu'			=>	array(
							'menu_index'			=>	'后台管理中心',
							'set'					=>	'全局设置',
							'info'					=>	'文章管理',
							'info_two'				=>	'FAQ管理',
							'instance'				=>	'案例管理',
							'download'				=>	'下载管理',
							'article'				=>	$website_language['manage'.$lang]['tra_slat22'],
							'product'				=>	$website_language['manage'.$lang]['tra_slat23'],
							'gift'  				=>	'礼品管理',
							'sale'					=>	$website_language['manage'.$lang]['tra_slat52'],
							'count'					=>	'数据统计',
							'feedback'				=>	'反馈管理',
							'admin'					=>	'用户管理',
							'other'					=>	$website_language['manage'.$lang]['tra_slat69'],
							'ext'					=>	'辅助管理',
						),
						
	
	//系统设置
	'set'			=>	array(
							'global'				=>	array(
															'set'			=>	'系统设置',
															'baseinfo'		=>	'基本信息',
															'web_name'		=>	'网站名称',
															'web_logo'		=>	'网站Logo',
															'contactinfo'	=>	'联系方式',
															'phone'			=>	'电话',
															'email'			=>	'邮箱',
															'address'		=>	'地址',
															'copyright'		=>	'版权',
															'chinaip'		=>	'屏蔽国内',
														),
							'seo'				=>	array(
															'set'			=>	'优化管理',
															'js_code'		=>	'JS代码',
														),
							'orders_print'			=>	array(
															'set'			=>	'打印设置',
															'company'		=>	'公司名称',
															'address'		=>	'地址',
															'phone'			=>	'电话',
															'fax'			=>	'传真',
														),
							'send_mail'				=>	array(
															'set'			=>	'邮件设置',
															'module'		=>	'发送模块',
															'default'		=>	'默认设置',
															'custom_set'	=>	'自定义设置',
															'from_email'	=>	'发件人邮箱',
															'from_name'		=>	'发件人名称',
															'smtp'			=>	'SMTP地址',
															'port'			=>	'SMTP端口',
															'email'			=>	'邮箱帐号',
															'password'		=>	'邮箱密码',
														),
							'exchange_rate'			=>	array(
															'set'			=>	'汇率管理',
															'rate'			=>	'汇率',
														),
							'online'				=>	array(
															'set'=>'客服管理'
														),
							'supplier'				=>	array(
															'set'=>$website_language['manage'.$lang]['Bas_Info'],
														),
							'supplier_log'				=>	array(
															'set'=>$website_language['manage'.$lang]['log_info'],
														),
							'supplier_password'				=>	array(
															'set'=>$website_language['manage'.$lang]['cha_Pass'],
														),
							
						),
	
	//文章管理系统
	'info'			=>	array(
							'category_manage'		=>	'类别管理',
							'info_manage'			=>	'文章管理',
							'author'				=>	'作者',
							'provenance'			=>	'来源',
							'burden'				=>	'责任编辑',
							'ext_url'				=>	'外部链接',
							'is_hot'				=>	'热点文章',
							'picsizetips'			=>  '500*500像素',
							'modelname'				=>  '文章',
						),
	//文章管理系统
	'info_two'			=>	array(
							'category_manage'		=>	'类别管理',
							'info_two_manage'		=>	'FAQ管理',
							'author'				=>	'作者',
							'provenance'			=>	'来源',
							'burden'				=>	'责任编辑',
							'ext_url'				=>	'外部链接',
							'is_hot'				=>	'热点文章',
							'picsizetips'			=>  '500*500像素',
							'modelname'				=>  '文章',
						),
	
	//成功案例管理系统
	'instance'		=>	array(
							'category_manage'		=>	'类别管理',
							'instance_manage'		=>	'案例管理',
							'is_classic'			=>	'经典案例',
							'modelname'				=>  '案例'
						),
	
	//下载中心管理系统
	'download'		=>	array(
							'category_manage'		=>	'类别管理',
							'download_manage'		=>	'下载管理',
							'file'					=>	'文件',
							'upload_file'			=>	'上传小文件',
							'file_path'				=>	'或文件路径',
							'modelname'				=>  '文件'
						),
	
	//信息管理系统
	'article'		=>	array(
							'group_0'				=>	$website_language['manage'.$lang]['tra_slat22'],
							'group_1'				=>	'信息管理2',
							'group_2'				=>	'信息管理3',
							'group_3'				=>	'信息管理4',
							'group_4'				=>	'信息管理5',
							'modelname'				=>  '信息',
						),
	//产品管理系统
	'param'		=>	array(
							'param_manage'			=>  '产品属性管理',
							'param_cateogry_manage'	=>	'属性分类管理',
							'category'				=>	'属性分类',
							'type'					=>	'属性类型',
							'default_value'			=>	'属性值',
							'select_item_mark'		=>	'每行请填写一个',
						),
	//产品管理系统
	'product'		=>	array(
							'stock_manage'			=>  '补货管理',
							'color_manage'			=>	$website_language['manage'.$lang]['tra_slat26'],
							'size_manage'			=>	'尺寸管理',
							'brand_manage'			=>	'品牌管理',
							'category_manage'		=>	'类别管理',
							'product_manage'		=>	$website_language['manage'.$lang]['tra_slat23'],
							'parameter_manage'		=>	'产品属性管理',
							'color'					=>	$website_language['manage'.$lang]['tra_slat27'],
							'size'					=>	'尺寸',
							'brand'					=>	'品牌',
							'item_number'			=>	'编号',
							'model'					=>	'型号',
							'sold_out'				=>	'下架',
							'is_featured'			=>	$website_language['manage'.$lang]['tra_slat45'],
							'is_best'				=>	$website_language['manage'.$lang]['tra_slat44'],
							'stock'					=>	$website_language['manage'.$lang]['tra_slat33'],
							'start_from'			=>	$website_language['manage'.$lang]['tra_slat34'],
							'weight'				=>	$website_language['manage'.$lang]['tra_slat98'],
							'weight_unit'			=>	'KG',
							'price'					=>	$website_language['manage'.$lang]['tra_slat100'],
							'is_hot'				=>	$website_language['manage'.$lang]['tra_slat41'],
							'is_recommend'			=>	$website_language['manage'.$lang]['tra_slat42'],
							'is_new'				=>	$website_language['manage'.$lang]['tra_slat43'],
							'copy_success'			=>	'产品复制成功，请进入编辑页面！',
							'price_list'			=>	array('price_0'=>'市场价', 'price_1'=>'会员价'),
							'special_offer'			=>	'特价',
							'is_promotion'			=>	'限时抢购',
							'wholesale_price'		=>	$website_language['manage'.$lang]['tra_slat103'],
                            'integral'              =>  '积分',
							'stock_asc'				=>	'库存低到高',
							'stock_desc'			=>	'库存高到低',
							'time_asc'				=>	'时间低到高',
							'time_desc'				=>	'时间高到低',
							'parameter'				=>	array(
															'color'				=>	'颜色',
															'size'				=>	'尺寸',
															'brand'				=>	'品牌',
															'default_value'		=>	'默认值',
															'select_item'		=>	'选项列表',
															'select_item_mark'	=>	'每行请填写一个',
															'default_select'	=>	'默认选项',
															'in_system'			=>	'系统内置',
															'out_of_system'		=>	'自定义添加',
															'field_type_ary'	=>	array(
																						'type'		=>	'字段类型',
																						'text'		=>	'单行文本框',
																						'radio'		=>	'单选框',
																						'checkbox'	=>	'多选框',
																						'file'		=>	'上传文件',
																						'select'	=>	'下拉框',
																						'textarea'	=>	'多行文本框',
																						'ckeditor'	=>	'编辑器',
																					),
														),
							'ext'					=>	array(
															// 'Volume' =>'Volume',
															// 'Applicable' =>'Applicable',
															// 'SalesArea' =>'SalesArea',
															// 'Manual' =>'Manual',
															// 'Materials' =>'Materials',
															// 'Feature' =>'Feature',
															// 'text' => 'text',
														),
							'modelname'				=>  $website_language['manage'.$lang]['producto'],
							'upload_manage'			=>	'产品批量上传',
							'binding_manage'		=>	'产品捆绑管理',
							'binding'				=>	array(
															'primary_products'	=>	'主产品',
															'associate_products'=>	'关联产品',
															'select_products'	=>	'请选择产品',
															'products_info'		=>	'产品信息',
															'reverse_associate'	=>	'反向关联',
															'r_a_tips'			=>	'即被关联的产品未设置套餐时，被关联产品中将同时显示此套餐',
														)
						),

	//礼品管理系统
	'gift'		=>	array(
							'stock_manage'			=>  '补货管理',
							'color_manage'			=>	'颜色管理',
							'size_manage'			=>	'尺寸管理',
							'brand_manage'			=>	'品牌管理',
							'category_manage'		=>	'类别管理',
							'gift_manage'		    =>	'礼品管理',
							'color'					=>	'颜色',
							'size'					=>	'尺寸',
							'brand'					=>	'品牌',
							'item_number'			=>	'编号',
							'model'					=>	'型号',
							'sold_out'				=>	'下架',
							'stock'					=>	'库存',
							'start_from'			=>	'起订量',
							'weight'				=>	'重量',
							'weight_unit'			=>	'KG',
							'price'					=>	'价格',
							'is_hot'				=>	'热门礼品',
							'is_recommend'			=>	'推荐礼品',
							'is_new'				=>	'新品上市',
							'copy_success'			=>	'礼品复制成功，请进入编辑页面！',
							'price_list'			=>	array('price_0'=>'市场价', 'price_1'=>'会员价'),
							'special_offer'			=>	'特价',
							'wholesale_price'		=>	'批发价',
                            'integral'              =>  '积分',
							'stock_asc'				=>	'库存低到高',
							'stock_desc'			=>	'库存高到低',
							'time_asc'				=>	'时间低到高',
							'time_desc'				=>	'时间高到低',
							'ext'					=>	array(

														),
							'modelname'				=>  '礼品',
							'upload_manage'			=>	'礼品批量上传',
							'binding_manage'		=>	'礼品捆绑管理',
							'binding'				=>	array(
															'primary_products'	=>	'主礼品',
															'associate_products'=>	'关联礼品',
															'select_products'	=>	'请选择礼品',
															'products_info'		=>	'礼品信息',
															'reverse_associate'	=>	'反向关联',
															'r_a_tips'			=>	'即被关联的礼品未设置套餐时，被关联礼品中将同时显示此套餐',
														)
						),
	
	//会员管理系统
	'member'		=>	array(
							'member_manage'			=>	'会员管理',
							'supplier_manage'		=>	'商户管理',
							'product_inquire_manage' =>	$website_language['manage'.$lang]['tra_slat53'],
							'title'					=>	'性别',
							'reg_time'				=>	'注册时间',
							'reg_ip'				=>	'注册IP',
							'login_time'			=>	'登录时间',
							'login_ip'				=>	'登录IP',
							'last_login_time'		=>	'最后登录时间',
							'last_login_ip'			=>	'最后登录IP',
							'consumption_price'		=>	'消费金额',
							'login_times'			=>	'登录次数',
							'base_info'				=>	'基本信息',
							'address_info'			=>	'地址信息',
							'wish_lists'			=>	'收藏夹',
							'shopping_cart'			=>	'购物车',
							'order_info'			=>	'订单信息',
							'login_info'			=>	'登录信息',
							'shipping_address'		=>	'收货地址',
							'billing_address'		=>	'账单地址',
							'mod_password'			=>	'修改密码',
							'member_level_manage'	=>	'级别管理',
							'level'					=>	array(
															'level'			=>  '等级',
															'level_name'	=>	'级别名称',
															'price'			=>	'升级消费金额',
															'discount'		=>	'购物享受折扣',
															'level_default' =>  '默认等级'
														),
						),
						
	//优惠券管理系统				
	'coupon'		=>	array(
							'coupon_system'			=>	'优惠劵管理',
							'coupon_manage'			=>	'优惠劵管理',
							'coupon'				=>	'优惠劵',
							'code'					=>	'优惠券代码',
							'type'					=>	'优惠券类型',
							'conditions'			=>	'使用条件',
							'valid'					=>	'有效期',
							'number_of_times'		=>	'能使用次数',
							'use_of_time'			=>	'最新使用时间',
							'generation_time'		=>	'生成时间',
							'less_cash'				=>	'减现金',
							'discount'				=>	'打折',
							'without_limiting_the'	=>	'不限制',
							'length'				=>	'优惠券长度',
							'number'				=>	'用小数表示，例如9折=0.9',
							'quantity'				=>	'生成数量',
							'conditions_info'		=>	'当购物金额达到此设定值时才可使用本优惠券，设置为0则不限制使用条件',
							'number_of_times_info'	=>	'本优惠券能使用的次数，设置为0则不限制使用次数',
						),
	
	//订单管理系统
	'orders'		=>	array(
							'orders_manage'			=>	$website_language['manage'.$lang]['tra_slat53'],
							'order_number'			=>	$website_language['manage'.$lang]['tra_slat54'],
							'item_costs'			=>	'产品总价',
							'shipping_charges'		=>	'运费',
							'shipping_method'		=>	'送货方式',
							'tracking_number'		=>	'邮包号',
							'grand_total'			=>	$website_language['manage'.$lang]['tra_slat66'],
							'discount'				=>	'折扣',
							'discount_remark'		=>	'填写范围：0至1，1为不打折，0.8即为8折',
							'view_member_info'		=>	'查看用户信息',
							'order_status'			=>	$website_language['manage'.$lang]['tra_slat56'],
							'payment_method'		=>	'付款方式',
							'base_info'				=>	'基本信息',
							'address_info'			=>	'地址信息',
							'products_list'			=>	'产品列表',
							'print_order'			=>	'打印订单',
							'export_order'			=>	'导出订单',
							'shipping_address'		=>	'收货地址',
							'billing_address'		=>	'账单地址',
							'orders_comments'		=>	'订单留言',
							'cancel_reason'			=>	'取消原因',
							'weight'				=>	'订单重量',
							'shipping_time'			=>	'发货时间',
							'payment_info'			=>	'付款信息',
							'auto_upd_price'		=>	'自动重新计算订单价格',
							'auto_upd_ship_price'	=>	'修改时自动重新计算运费',
							'auto_upd_ship_price_1'	=>	'修改时且同步到收货地址时自动重新计算运费',
							'product'				=>	'产品',
							'sub_total'				=>	'小计',
							'product_add'			=>	'添加产品',
							'discount_remark'		=>	'填写范围：0至1，1为不打折，0.8即为8折'
						),
	//邮件发送系统
	'payment_apply'		=>	array(
							'payment_apply_system'	=>	'支付记录',
							'to'					=>	'收件人',
							'send_to_all_member'	=>	'同时发送到网站所有注册用户',
							'send_to_all_newsletter'=>	'同时发送到邮件列表里的邮箱',
							'tips'					=>	'备注: 多个收件人请每行填写一个，并且每个收件人的<font class="fc_red">邮箱地址</font>与<font class="fc_red">姓名</font>用<font class="fc_yellow">/</font>分隔开，如: webmaster@ly200.com<font class="fc_yellow">/</font>cai yuzhuan<br><br>邮件主题或邮件内容可用变量（红色内容）:<br><font class="fc_red">{Email}</font>: 邮箱地址<br><font class="fc_red">{FullName}</font>: 姓名',
							'subject'				=>	'邮件主题',
							'send'					=>	'发送邮件',
							'send_success'			=>	'发送邮件成功',
							'member_list'			=>	'注册用户列表',
						),
	
	//邮件发送系统
	'send_mail'		=>	array(
							'send_mail_system'		=>	'邮件发送',
							'to'					=>	'收件人',
							'send_to_all_member'	=>	'同时发送到网站所有注册用户',
							'send_to_all_newsletter'=>	'同时发送到邮件列表里的邮箱',
							'tips'					=>	'备注: 多个收件人请每行填写一个，并且每个收件人的<font class="fc_red">邮箱地址</font>与<font class="fc_red">姓名</font>用<font class="fc_yellow">/</font>分隔开，如: webmaster@ly200.com<font class="fc_yellow">/</font>cai yuzhuan<br><br>邮件主题或邮件内容可用变量（红色内容）:<br><font class="fc_red">{Email}</font>: 邮箱地址<br><font class="fc_red">{FullName}</font>: 姓名',
							'subject'				=>	'邮件主题',
							'send'					=>	'发送邮件',
							'send_success'			=>	'发送邮件成功',
							'member_list'			=>	'注册用户列表',
						),
	
	//订单数据统计
	'count'		=>	array(
							'order_price_count'		=>	'金额统计',
							'order_price_trend'		=>	'金额走势',
							'order_count'			=>	'订单统计',
							'order_count_trend'		=>	'订单走势',
							'order_status_count'	=>	'状态统计',
							'product_top_sale'		=>	'销售排行',
							'order_row_count'		=>	'张订单',
							'count_type'			=>	'统计方式',
							'count_type_0'			=>	'按天',
							'count_type_1'			=>	'按月',
							'count_type_2'			=>	'按年',
							'qty'					=>	'销量',
							'price'					=>	'金额',
						),
	
	//地址簿
	'address_book'	=>	array(
							'first_name'			=>	'姓',
							'last_name'				=>	'名',
							'address_line_1'		=>	'地址1',
							'address_line_2'		=>	'地址2',
							'city'					=>	'市',
							'state'					=>	'州',
							'country'				=>	'国家',
							'postal_code'			=>	'邮编',
							'phone'					=>	'电话',
							'also_billing_address'	=>	'同步到账单地址',
							'also_shipping_address'	=>	'同步到收货地址',
						),
	
	//运费管理系统
	'shipping'		=>	array(
							'shipping_manage'		=>	'运费管理',
							'express'				=>	'快递公司名称',
							'set_shipping_price'	=>	'运费设置',
							'first_price'			=>	'起价',
							'first_weight'			=>	'首重',
							'ext_weight'			=>	'续重',
							'free_shipping_price'	=>	'免运费额度',
							'modelname'				=>  '运费'
						),
	
	//付款方式管理
	'payment_method'=>	array(
							'payment_method_manage'	=>	'付费方式',
							'additional_fee'		=>	'手续费',
							'account'				=>	'帐号',
						),
	
	//在线留言管理系统
	'feedback'		=>	array(
							'feedback_manage'		=>	'留言管理',
							'company'				=>	'公司',
							'phone'					=>	'电话',
							'mobile'				=>	'手机',
							'qq'					=>	'QQ',
							'subject'				=>	'主题',
							'message'				=>	'内容',
							'reply'					=>	'回复',
							'reply_status'			=>	array('<font class="fc_red">未回复</font>', '已回复'),
							'modelname'				=>  '留言'
						),
	
	//在线询盘管理系统
	'product_inquire'=>	array(
							'product_inquire_manage'=>	'询盘管理',
							'full_name'				=>	'姓名',
							's_c_a'					=>	'省份城市',
							'address'				=>	'地址',
							'city'					=>	'市',
							'state'					=>	'州',
							'country'				=>	'国家',
							'postal_code'			=>	'邮编',
							'phone'					=>	'电话',
							'fax'					=>	'传真',
							'subject'				=>	'主题',
							'message'				=>	'内容',
							'inquire_product'		=>	'询盘产品',
							'modelname'				=>  '询盘'
						),
	
	//邮件列表管理系统
	'newsletter'	=>	array(
							'newsletter_manage'		=>	'邮件管理',
						),
	
	//产品评论管理系统
	'product_review'=>	array(
							'product_review_manage'	=>	'产品评论管理',
							'product'				=>	'产品',
							'full_name'				=>	'姓名',
							'rating'				=>	'星级',
							'reply'					=>	'回复',
							'reply_status'			=>	array('<font class="fc_red">未回复</font>', '已回复'),
							'modelname'				=>  '评论'
						),

	//产品评论管理系统
	'gift_review'=>	array(
							'gift_review_manage'	=>	'礼品评论管理',
							'gift'				    =>	'礼品',
							'full_name'				=>	'姓名',
							'rating'				=>	'星级',
							'reply'					=>	'回复',
							'reply_status'			=>	array('<font class="fc_red">未回复</font>', '已回复'),
							'modelname'				=>  '评论'
						),
	
	//后台用户管理系统
	'admin'			=>	array(
							'admin_manage'			=>	'用户管理',
							'username'				=>	'用户名',
							'username_left_len'		=>	'用户名的长度必须为6位以上！',
							'user_exist'			=>	'对不起，添加失败，此用户名已经存在！',
							'password'				=>	'登录密码',
							'password_left_len'		=>	'登录密码的长度必须为8位以上！',
							're_password'			=>	'确认密码',
							'repwd_dif_pwd'			=>	'确认密码与登录密码不一致，请重新填写！',
							'locked'				=>	'锁定',
							'keep_null_unmodpwd'	=>	'留空则不修改密码！',
							'last_login_time'		=>	'上次登录时间',
							'last_login_ip'			=>	'上次登录IP',
							'update_password'		=>	'修改密码',
							'old_password'			=>	'旧密码',
							'new_password'			=>	'新密码',
							'new_pwd_left_len'		=>	'新密码的长度必须为8位以上！',
							'old_password_err'		=>	'旧密码不正确，请重新输入！',
							'update_pwd_success'	=>	'密码修改成功，请牢记新密码！',
							'welcome'				=>	'您好，<span>%s</span>！欢迎您使用本系统！上次登录IP：<span>%s</span>，时间：<span>%s</span>，本次登录IP：<span>%s</span>',
							'logout'				=>	'安全退出',
							'group_1'				=>	'超级管理员',
							'group_2'				=>	'一般管理员',
							'permit'				=>	'权限',
							'modelname'				=>  '用户',
						),
	
	//国家地区管理系统
	'country'		=>	array(
							'country_manage'		=>	'国家管理',
							'country'				=>	'国家地区',
							'country_exist'			=>	'对不起，此国家地区已经存在！',
						),
	
	//广告图片管理
	'ad'			=>	array(
							'ad_manage'				=>	$website_language['manage'.$lang]['tra_slat70'],
							'pagename'				=>	$website_language['manage'.$lang]['tra_slat72'],
							'ad_position'			=>	$website_language['manage'.$lang]['ad_1'],
							'ad_type'				=>	'广告类型',
							'ad_type_ary'			=>	array('图片', '动画', '编辑器'),
							'pic_qty'				=>	'图片数量',
							'width'					=>	$website_language['manage'.$lang]['ad_2'],
							'height'				=>	$website_language['manage'.$lang]['ad_3'],
							'contents'				=>	'广告内容',
							'photo'					=>	$website_language['manage'.$lang]['ad_4'],
							'flash'					=>	'上传动画',
							'name'					=>	$website_language['manage'.$lang]['ad_5'],
							'url'					=>	$website_language['manage'.$lang]['ad_6'],
							'modelname'				=>  $website_language['manage'.$lang]['ad'],
						),
	
	//在线调查管理
	'survey'		=>	array(
							'survey_manage'			=>	'调查管理',
							'subject'				=>	'调查主题',
							'item'					=>	'调查选项',
							'votes_count'			=>	'票数',
						),
	
	//友情链接管理系统
	'links'			=>	array(
							'links_manage'			=>	'友情链接',
							'url'					=>	'链接地址',
							'modelname'				=>  '友情链接'
						),
	
	//翻译链接管理系统
	'translate'		=>	array(
							'translate_manage'		=>	'翻译链接管理',
							'url'					=>	'链接地址',
						),
	
	//热门搜索管理系统
	'search_keyword'=>	array(
							'search_keyword_manage'	=>	'热门搜索管理',
							'keyword'				=>	'关键词',
						),
	
	//静态化管理系统
	'html'			=>	array(
							'html_manage'			=>	'静态化管理',
							'page_name'				=>	'页面名称',
							'option'				=>	'选项',
							'processing'			=>	'正在处理中...',
							'write_success'			=>	'成功生成文件',
							'process_success'		=>	'处理完成',
							'step_info'				=>	'共要处理%s个文件，已成功处理%s个！<br>正在准备进入下一轮操作，如果浏览器不会自动跳转，请点击<a href="%s" class="red">这里</a>',
							'all_list'				=>	'总列表页',
							'page'					=>	array(
															'index'				=>	'首页',
															'article'			=>	'信息页',
															'info_category'		=>	'文章分类页',
															'info_detail'		=>	'文章详细页',
															'instance_list'		=>	'案例列表页',
															'instance_category'	=>	'案例分类页',
															'instance_detail'	=>	'案例详细页',
															'download_list'		=>	'下载列表页',
															'download_category'	=>	'下载分类页',
															'product_list'		=>	'产品列表页',
															'product_category'	=>	'产品分类页',
															'product_detail'	=>	'产品详细页',
														),
						),
	
	//网站日志管理系统
	'manage_log'	=>	array(
							'log_manage'			=>	'日志管理',
							'admin_user_name'		=>	'管理员名称',
							'page_url'				=>	'请求URL',
							'ip'					=>	'IP地址',
							'ip_to_address'			=>	'IP地址来源',
							'log_contents'			=>	'日志内容',
						),
	
	//数据库备份还原
	'database'		=>	array(
							'database_manage'		=>	'数据库管理',
							'database_backup'		=>	'数据库备份',
							'database_restore'		=>	'数据库还原',
							'backup'				=>	'备份',
							'backup_s'				=>	'开始备份数据库>>',
							'backup_ing'			=>	'正在备份数据库，这个过程可能长达数分钟，请耐心等待...',
							'backup_ok'				=>	'数据库备份完成！',
							'restore'				=>	'还原',
							'restore_ing'			=>	'正在还原数据库，这个过程可能长达数分钟，请耐心等待...',
							'restore_ing_limit'		=>	'成功还原第 <font class="fc_red">%s</font> 卷数据，共 <font class="fc_red">%s</font> 卷！',
							'restore_ok'			=>	'数据库还原完成！',
							'confirm_restore'		=>	'确定要还原数据吗？还原前强烈建议备份现有数据，继续吗？',
							'file_size'				=>	'备份文件大小',
							'file_count'			=>	'文件卷数',
							'backup_time'			=>	'备份时间',
						),
	
	//phpMyAdmin
	'phpmyadmin'	=>	array(
							'phpmyadmin'			=>	'phpMyAdmin',
						),
	
	//扩展预留，如果有新的语言需要加入，放在这里就可以了，读取方法：get_lang('ext.数组下标')
	'ext'			=>	array(
							
						),
);

$Ly200JsLang=array(
	'ly200'			=>	array(
							'price_symbols'			=>	get_cfg('ly200.price_symbols'),
							'qty'					=>	$website_language['manage'.$lang]['tra_slat65'],
							'votes_count'			=>	'票数',
							'update_fail'			=>	'对不起，更新失败！',
							'update_no_permit'		=>	'对不起，您没有权限进行此操作！',
						),
	
	//日期
	'date'			=>	array(
							'months'				=>	array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'),
							'weeks'					=>	array('日', '一', '二', '三', '四', '五', '六'),
							'clear'					=>	'清空',
							'today'					=>	'今天',
							'close'					=>	'关闭',
						),
	
	//窗口
	'windows'		=>	array(
							'min'					=>	'最小化',
							'max'					=>	'最大化',
							'zoom'					=>	'还原',
							'tips'					=>	'提示',
							'close'					=>	'关闭',
							'close_all'				=>	'关闭全部',
						),
);
?>