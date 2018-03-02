<?php
//*********************************网站后台综合相关参数设置（start here）************************************************************
$Ly200Cfg=array(
	'ly200'			=>	array(
							'up_file_dir'	=>	'/u_file/',   //网站所有上传的文件保存的基本目录
							'up_file_base_dir'	=>	'/u_file/'.date('ym').'/',   //网站所有上传的文件保存的基本目录
							'price_symbols'		=>	$mCfg['ExchangeRate'][$mCfg['ExchangeRate']['Default']]['Symbols'],	//后台所有用到价格的符号
							'img_add_watermark'	=>	0,	//后台对上传的图片是否加水印
							'un_allow_up_ext'	=>	array('php', 'php3', 'php4', 'bat', 'com', 'exe', 'dll', 'asp', 'asa', 'cgi', 'jsp'),	//不允许上传的文件格式
							'lang_array'		=>	array('lang_0','lang_1','lang_2'),	//网站语言版本，第一项值为默认语言版本，语言版本名称于：$Ly200Lang['ly200']['array_lang']
						),
	
	
	/*全局管理*/					
	'global_set'	=> array(
							'upload_logo'		=>	1,	//上传图片
							'logo_width'		=>	223,//缩略图宽度
							'logo_height'		=>	80,//缩略图高度
							'chinaip'			=>  1   //屏蔽国内IP
						),
	'Character_admin' => array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	10,	//列表页每页显示数量
					),
	'admin' => array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	10,	//列表页每页显示数量
					),
	//文章管理系统
	'info'			=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'move'				=>	1,	//移动
							'is_in_index'		=>	0,	//首页显示
							'is_hot'			=>	0,	//热点文章
							'ext_url'			=>	0,	//外部链接
							'author'			=>	0,	//作者
							'provenance'		=>	0,	//来源
							'burden'			=>	0,	//责任编辑
							'brief_description'	=>	0,	//简短介绍
							'acc_time'			=>	1,	//时间
							'upload_pic'		=>	0,	//上传图片
							'pic_width'			=>	160,//缩略图宽度
							'pic_height'		=>	160,//缩略图高度
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'page_url'			=>	'Title',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'category'			=>	array(
														'dept'			=>	1,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	0,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	160,//缩略图宽度
														'pic_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
													),
						),
						
	//文章管理系统2
	'info_two'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'move'				=>	1,	//移动
							'is_in_index'		=>	0,	//首页显示
							'is_video'			=>	1,	//首页显示
							'is_img'			=>	1,	//首页显示
							'is_hot'			=>	0,	//热点文章
							'ext_url'			=>	0,	//外部链接
							'author'			=>	0,	//作者
							'provenance'		=>	0,	//来源
							'burden'			=>	0,	//责任编辑
							'brief_description'	=>	1,	//简短介绍
							'acc_time'			=>	1,	//时间
							'upload_pic'		=>	0,	//上传图片
							'pic_width'			=>	160,//缩略图宽度
							'pic_height'		=>	160,//缩略图高度
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'page_url'			=>	'Title',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'category'			=>	array(
														'dept'			=>	2,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	0,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	160,//缩略图宽度
														'pic_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
													),
						),
	
	//成功案例管理系统
	'instance'		=>	array(
							'add'				=>	1,	//添加
							'add_mode'			=>	0,	//添加模式，0：按语言版本分别发布，1：同时发布多语言
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'move'				=>	1,	//移动
							'is_in_index'		=>	0,	//首页显示
							'is_classic'		=>	0,	//经典案例
							'pic_count'			=>	1,	//图片数量，0-5张，设置为0则不需上传图片
							'pic_alt'			=>	0,	//图片Alt
							'pic_size'			=>	array('350X350', 'default'=>'160X160'),	//缩略图尺寸
							'brief_description'	=>	0,	//简短介绍
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'description'		=>	1,	//详细介绍
							'page_url'			=>	'Name',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'category'			=>	array(
														'dept'			=>	1,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	160,//缩略图宽度
														'pic_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
													),
						),
	
	//下载管理系统
	'download'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'move'				=>	1,	//移动
							'upload_pic'		=>	0,	//上传图片
							'pic_width'			=>	160,//缩略图宽度
							'pic_height'		=>	160,//缩略图高度
							'brief_description'	=>	0,	//简短介绍
							'seo_tkd'			=>	0,	//SEO Title,Keywords,Description
							'description'		=>	0,	//详细介绍
							'page_url'			=>	'Name',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'category'			=>	array(
														'dept'			=>	1,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	160,//缩略图宽度
														'pic_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
													),
						),
	
	//文章管理系统
	'article'		=>	array(
							'amdo'				=>	array('group_1','group_2','group_3','group_4'),	//允许添加，修改标题，删除，排序的分组
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'page_url'			=>	'Title',	//PageUrl值计算字段
						),
	
	//产品管理系统
	'product'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'copy'				=>	0,	//复制
							'order'				=>	1,	//排序
							'move'				=>	0,	//移动
							'item_number'		=>	0,	//编号
							'model'				=>	0,	//型号
							'is_in_index'		=>	1,	//首页显示
							'is_hot'			=>	1,	//热卖
							'is_featured'		=>	1,
							'is_best'			=>	1,	//最好受欢迎
							'is_recommend'		=>	1,	//推荐
							'is_new'			=>	1,	//新品
							'sold_out'			=>	0,	//下架
							'color_ele'			=>	1,	//颜色，从product_color表选择
							'color_ele_mode'	=>	1,	//颜色选择模式，0：单选，1：多选
							'size_ele'			=>	0,	//尺寸，从product_size表选择
							'size_ele_mode'		=>	0,	//尺寸选择模式，0：单选，1：多选
							'brand_ele'			=>	0,	//品牌，从product_brand表单选
							'stock'				=>	1,	//库存
							'start_from'		=>	1,	//起订量
							'weight'			=>	1,	//重量
							'review'			=>	0,	//评论
							'love'				=>	0,	//收藏
							'pic_count'			=>	5,	//图片数量，0-8张，设置为0则不需上传图片
							'pic_alt'			=>	0,	//图片Alt
							'pic_size'			=>	array('400X440', 'default'=>'210X240','90X90'),	//缩略图尺寸（购物网站必须开启90*90的缩略图，根据需要开启70*70的缩略图）
							'price'				=>	1,	//价格，以下3项为本项的扩展，关闭本项，即以下3项设置均失效
							'price_list'		=>	array('price_0', 'price_1'),	//价格名称下标列表，对应Price_0、Price_1、Price_2、Price_3字段，最多4个，价格名称由语言文件设置

							//设置产品优惠价格
							'price_discount'	=>	array('discount_0','discount_1','discount_2','discount_3','discount_4'),
							'special_offer'		=>	0,	//特价
							'is_promotion'		=>	0,	//限时抢购
							'wholesale_price'	=>	1,	//批发价，即多件优惠
							'wholesale_price_n'	=>	0,	//批发价默认选项数量
                            'integral'          =>  0,  //积分
							'brief_description'	=>	1,	//简短介绍
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'description'		=>	1,	//详细介绍
							'page_url'			=>	'Name',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'color'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	43,//缩略图宽度
														'pic_height'	=>	43,//缩略图高度
													),
							'size'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
													),
							'brand'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_logo'	=>	0,	//上传图片
														'logo_width'	=>	160,//缩略图宽度
														'logo_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Brand',	//PageUrl值计算字段
													),
							'category'			=>	array(
														'dept'			=>	3,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	1,	//上传图片
														'pic_width'		=>	420,//缩略图宽度
														'pic_height'	=>	240,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
														'is_in_index'	=> 	1,
													),
							'binding'			=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'bind_count'	=>	4,	//最大捆绑产品数量
														'page_count'	=>	10,	//列表页每页显示数量
														'pro_page_count'=>	5,	//产品列表页每页显示数量
													),
							'ext'				=>	array(
														/*
														产品资料扩展参数定义，二维数组下标对应数据库的字段名称和表单名称，字段长度：input=char 100，select=char 100，textarea=char 255，ckeditor=text
														如项示例：
														文本框：		'Volume'	=>	array(0, 25, 50, array('')),
														单选框：		'Applicable'=>	array('电脑硬件|路由设备|打印机', '电脑硬件'),
														多选框：		'SalesArea'	=>	array('广东|广西|海南', '广东|海南'),
														文件框：		'Manual',
														下拉框：		'Materials'	=>	array('钢|铁|塑料|皮革', '塑料'),
														文本段：		'Feature'	=>	array(1, 5, 50, array('')),
														编辑器：		'Warranty'	=>	array(1, array('')),
														*/
														'input_text'	=>	array(	//input[type='text']，参数：是否多语言，表单长度，允许最多输入字符数，默认值
																			// 'Volume'	=>	array(0, 25, 50, array('')),
																			),
														'input_radio'	=>	array(	//input[type='radio']，参数：选项列表，默认值
																			// 'Applicable'=>	array('电脑硬件|路由设备|打印机', '电脑硬件'),
																			),
														'input_checkbox'=>	array(	//input[type='checkbox']，参数：选项列表，默认值；表单名称将自动加上[]，所以如果只有一个选项的不要使用此功能
																			// 'SalesArea'	=>	array('广东|广西|海南', '广东|海南'),
																			),
														'input_file'	=>	array(	//input[type='file']
																			// 'Manual',
																			),
														'select'		=>	array(	//下拉表单，参数：选项列表，默认值；本功能用单选功能同样可以实现，区别在于本项可以不选任何值，单选则不一定
																			// 'Materials'	=>	array('钢|铁|塑料|皮革', '塑料'),
																			),
														'textarea'		=>	array(	//textarea，参数：是否多语言，行数，列数，默认值
																			// 'Feature'	=>	array(1, 5, 50, array('')),
																			),
														'ckeditor'		=>	array(	//编辑器，参数：是否多语言，默认值
																			// 'text' => array(1, array('')),
																			),
													),
						),
						
	//产品属性管理系统
	'param'		=>	array(
					'add'				=>	1,	//添加
					'mod'				=>	1,	//修改
					'del'				=>	1,	//删除
					'order'				=>	1,	//排序
					'type'				=>	1,	//类型
					'category'			=>	array(
													'dept'			=>	1,	//级数
													'list_display'	=>	1,	//展开分类
													'add'			=>	1,	//添加
													'mod'			=>	1,	//修改
													'mod_name'		=>	1,	//是否允许修改类别名称
													'del'			=>	1,	//删除
													'order'			=>	1,	//排序
													'description'	=>	0,	//类别说明
													'upload_pic'	=>	1,	//上传图片
													'pic_width'		=>	160,//缩略图宽度
													'pic_height'	=>	160,//缩略图高度
													'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
													'page_url'		=>	'Category',	//PageUrl值计算字段
												),
	
	),
	//产品管理系统
	'gift'		    =>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'copy'				=>	1,	//复制
							'order'				=>	1,	//排序
							'move'				=>	1,	//移动
							'item_number'		=>	1,	//编号
							'model'				=>	0,	//型号
							'is_in_index'		=>	1,	//首页显示
							'is_hot'			=>	1,	//热卖
							'is_recommend'		=>	0,	//推荐
							'is_new'			=>	1,	//新品
							'sold_out'			=>	1,	//下架
							'color_ele'			=>	0,	//颜色，从gift_color表选择
							'color_ele_mode'	=>	1,	//颜色选择模式，0：单选，1：多选
							'size_ele'			=>	0,	//尺寸，从gift_size表选择
							'size_ele_mode'		=>	1,	//尺寸选择模式，0：单选，1：多选
							'brand_ele'			=>	0,	//品牌，从gift_brand表单选
							'stock'				=>	1,	//库存
							'start_from'		=>	1,	//起订量
							'weight'			=>	1,	//重量
							'pic_count'			=>	5,	//图片数量，0-8张，设置为0则不需上传图片
							'pic_alt'			=>	0,	//图片Alt
							'pic_size'			=>	array('350X350', '230X230', 'default'=>'160X160', '90X90', '70X70'),	//缩略图尺寸（购物网站必须开启90*90的缩略图，根据需要开启70*70的缩略图）
							'price'				=>	0,	//价格，以下3项为本项的扩展，关闭本项，即以下3项设置均失效
							'price_list'		=>	array(),	//价格名称下标列表，对应Price_0、Price_1、Price_2、Price_3字段，最多4个，价格名称由语言文件设置
							'special_offer'		=>	0,	//特价
							'wholesale_price'	=>	0,	//批发价，即多件优惠
							'wholesale_price_n'	=>	3,	//批发价默认选项数量
                            'integral'          =>  1,  //积分
							'brief_description'	=>	1,	//简短介绍
							'seo_tkd'			=>	1,	//SEO Title,Keywords,Description
							'description'		=>	1,	//详细介绍
							'page_url'			=>	'Name',	//PageUrl值计算字段
							'page_count'		=>	20,	//列表页每页显示数量
							'color'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	30,//缩略图宽度
														'pic_height'	=>	30,//缩略图高度
													),
							'size'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
													),
							'brand'				=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_logo'	=>	0,	//上传图片
														'logo_width'	=>	160,//缩略图宽度
														'logo_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Brand',	//PageUrl值计算字段
													),
							'category'			=>	array(
														'dept'			=>	2,	//级数
														'list_display'	=>	1,	//展开分类
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'mod_name'		=>	1,	//是否允许修改类别名称
														'del'			=>	1,	//删除
														'order'			=>	1,	//排序
														'description'	=>	0,	//类别说明
														'upload_pic'	=>	0,	//上传图片
														'pic_width'		=>	160,//缩略图宽度
														'pic_height'	=>	160,//缩略图高度
														'seo_tkd'		=>	1,	//SEO Title,Keywords,Description
														'page_url'		=>	'Category',	//PageUrl值计算字段
													),
							'binding'			=>	array(
														'add'			=>	1,	//添加
														'mod'			=>	1,	//修改
														'del'			=>	1,	//删除
														'bind_count'	=>	4,	//最大捆绑产品数量
														'page_count'	=>	10,	//列表页每页显示数量
														'pro_page_count'=>	5,	//产品列表页每页显示数量
													),
							'ext'				=>	array(
														/*
														产品资料扩展参数定义，二维数组下标对应数据库的字段名称和表单名称，字段长度：input=char 100，select=char 100，textarea=char 255，ckeditor=text
														如项示例：
														文本框：		'Volume'	=>	array(0, 25, 50, array('')),
														单选框：		'Applicable'=>	array('电脑硬件|路由设备|打印机', '电脑硬件'),
														多选框：		'SalesArea'	=>	array('广东|广西|海南', '广东|海南'),
														文件框：		'Manual',
														下拉框：		'Materials'	=>	array('钢|铁|塑料|皮革', '塑料'),
														文本段：		'Feature'	=>	array(1, 5, 50, array('')),
														编辑器：		'Warranty'	=>	array(1, array('')),
														*/
														'input_text'	=>	array(	//input[type='text']，参数：是否多语言，表单长度，允许最多输入字符数，默认值
																			),
														'input_radio'	=>	array(	//input[type='radio']，参数：选项列表，默认值
																			),
														'input_checkbox'=>	array(	//input[type='checkbox']，参数：选项列表，默认值；表单名称将自动加上[]，所以如果只有一个选项的不要使用此功能
																			),
														'input_file'	=>	array(	//input[type='file']
																			),
														'select'		=>	array(	//下拉表单，参数：选项列表，默认值；本功能用单选功能同样可以实现，区别在于本项可以不选任何值，单选则不一定
																			),
														'textarea'		=>	array(	//textarea，参数：是否多语言，行数，列数，默认值
																			),
														'ckeditor'		=>	array(	//编辑器，参数：是否多语言，默认值
																			),
													),
						),
	
	//会员管理系统
	'member'		=>	array(
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
							'level'				=>	array(
														'open'				=>  1,  //开启
														'add'				=>	1,	//添加
														'mod'				=>	1,	//修改
														'del'				=>	1,	//删除
														'page_count'		=>	20,	//列表页每页显示数量
													),
						),
						
	//优惠卷管理系统				
	'coupon'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	0,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//运费管理系统
	'shipping'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							's_price_by_weight'	=>	0,	//是否按重量计运费
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//付款方式管理系统
	'payment_method'=>	array(
							'mod'				=>	1,	//修改
							'order'				=>	1,	//排序
							'logo_width'		=>	135,//Logo宽度
							'logo_height'		=>	35,	//Logo高度
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//订单管理系统
	'orders'		=>	array(
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
							'order_payment'		=>	0, //付款方式
						),
	'orders_manage'=>	array(
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
							'order_payment'		=>	0, //付款方式
						),
	
	'transport'=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
							'order_payment'		=>	0, //付款方式
						),
	//在线留言管理系统
	'feedback'		=>	array(
							'del'				=>	1,	//删除
							'reply'				=>	1,	//是否需要回复
							'display'			=>	0,	//前台显示控制
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//在线询盘管理系统
	'product_inquire'=>	array(
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//邮件列表管理系统
	'newsletter'	=>	array(
							'del'				=>	1,	//删除
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//产品评论管理系统
	'product_review'=>	array(
							'del'				=>	1,	//删除
							'reply'				=>	1,	//是否需要回复
							'display'			=>	1,	//前台显示控制
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//国家地区管理系统
	'country'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'reset'				=>	1,	//重置
						),
	
	//广告图片管理系统
	'ad'			=>	array(
							'add'				=>	0,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	0,	//删除
						),
	
	//在线调查管理系统
	'survey'		=>	array(
							'add'				=>	0,	//添加，通常添加、删除、排序都不需要用到，因为只有一个调查主题
							'mod'				=>	1,	//修改
							'del'				=>	0,	//删除
							'order'				=>	0,	//排序
							'survey_item_n'		=>	5,	//添加时的默认选项数量
						),
	
	//友情链接管理系统
	'links'			=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'upload_logo'		=>	0,	//上传图片
							'logo_width'		=>	120,//缩略图宽度
							'logo_height'		=>	60,//缩略图高度
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//翻译链接管理系统
	'translate'		=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'upload_logo'		=>	1,	//上传图片
							'logo_width'		=>	16,//缩略图宽度
							'logo_height'		=>	11,//缩略图高度
							'page_count'		=>	20,	//列表页每页显示数量
						),
	//提单号
	'service_status'=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	//热门搜索管理系统
	'search_keyword'=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//日志管理系统
	'manage_log'	=>	array(
							'del'				=>	1,	//删除
							'page_count'		=>	40,	//列表页每页显示数量
						),
	'supplier_manage'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'article_group_0'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'member_handle'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'member_level_manage'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'buyers_level_manage'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'buyers_member_manage'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'ad_member'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'admin_manage'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	'transclear'	=>	array(
							'add'				=>	1,	//添加
							'mod'				=>	1,	//修改
							'del'				=>	1,	//删除
							'order'				=>	1,	//排序
							'page_count'		=>	20,	//列表页每页显示数量
						),
	
	//数据库管理系统
	'database'		=>	array(
							'del'				=>	1,	//删除备份文件
							'file_size'			=>	5*1024*1024,	//备份文件每卷的大小
							'save_dir'			=>	'/_mysql_backup/',	//文件保存基本目录
						),

);
//*********************************网站后台综合相关参数设置（end here）**************************************************************

//*********************************后台左菜单显示相关参数（start here）**************************************************************
$menu=array(
	'manage_status'		=>	0,	//全局监控
	'transport'			=>  1,  //空运追踪
	'global_set'		=>	1,	//系统管理
	'Character_admin'	=>  1,	//角色管理
	'buyers'			=>	1,	//客户管理
	'member'			=>	1,	//商户管理
	'seo_set'			=>  1,  //优化管理
	'orders_print_set'	=>	0,	//订单打印设置
	'send_mail_set'		=>	1,	//发送邮件设置
	'exchange_rate_set'	=>	0,	//汇率设置
	'online_set'		=>	1,	//客服管理
	'supplier_set'		=>	1,	//商户管理
	'orders_manage'		=>	1,	//客服专页
	'info_category'		=>	0,	//文章类别
	'info'				=>	0,	//文章管理
	
	'info_two_category'	=>	0,	//文章类别
	'info_two'			=>	0,	//文章管理
	
	'instance_category'	=>	0,	//成功案例类别
	'instance'			=>	0,	//成功案例管理
	
	'download_category'	=>	0,	//下载中心类别
	'download'			=>	0,	//下载中心管理
	
	'article_group_0'	=>	1,	//信息页
	'article_group_1'	=>	0,	//信息页
	'article_group_2'	=>	0,	//信息页
	'article_group_3'	=>	0,	//信息页
	'article_group_4'	=>	1,	//信息页
	
	'param_category'	=>	0,	//产品属性分类
	'param'				=>	0,	//产品属性
		
	'product_color'		=>	1,	//产品颜色
	'product_size'		=>	0,	//产品尺寸
	'product_brand'		=>	0,	//产品品牌
	'product_category'	=>	1,	//产品类别
	'product'			=>	1,	//产品管理
	'product_stock'		=>	0,	//待补货
	'product_binding'	=>	0,	//产品捆绑
	'product_upload'	=>	0,	//批量上传

	'gift_color'		=>	0,	//礼品颜色
	'gift_size'		    =>	0,	//礼品尺寸
	'gift_brand'		=>	0,	//礼品品牌
	'gift_category'	    =>	0,	//礼品类别
	'gift'			    =>	0,	//礼品管理
	
	'member'			=>	1,	//会员管理
	'supplier'			=>	1,	//商户管理
	'member_level'		=>	1,	//会员级别管理
	'coupon'			=>	0,	//优惠券
	'shipping'			=>	1,	//运费管理
	'payment_method'	=>	1,	//付款方式管理
	'orders'			=>	1,	//订单管理
	'send_mail'			=>	1,	//发送邮件
	'payment_apply'		=>	0,	//线下支付记录
	
	'order_price_count'	=>	0,	//订单金额统计
	'order_price_trend'	=>	0,	//订单金额走势图
	'order_count'		=>	0,	//订单量统计
	'order_count_trend'	=>	0,	//订单量走势图
	'order_status_count'=>	0,	//订单状态统计
	'product_top_sale'	=>	0,	//产品销售排行
	
	'feedback'			=>	0,	//在线留言管理
	'product_inquire'	=>	0,	//在线询盘管理
	'newsletter'		=>	1,	//邮件列表管理
	'product_review'	=>	0,	//产品评论管理
	
	'admin'				=>	1,	//后台用户管理
	'admin_update_pwd'	=>	1,	//修改密码
	
	'country'			=>	0,	//国家地区管理
	'ad'				=>	1,	//广告管理
	'survey'			=>	0,	//在线调查管理
	'links'				=>	1,	//友情链接管理
	'translate'			=>	0,	//翻译链接管理
	'search_keyword'	=>	0,	//热门搜索管理
	'html'				=>	0,	//静态化
	
	'manage_log'		=>	1,	//日志管理
	'database'			=>	0,	//数据库管理
	'phpmyadmin'		=>	1,	//phpmyadmin
	'member_level'		=>	1,	//商户等级
	'member_handle'		=>	1,	//会员管理
	'system_feedback'	=>	1,	//系统反馈
	'Pers_info'			=>	1,	//个人信息
	'Pers_infos'		=>	1,	//基础信息
	'buyers_level_manage' => 1, //客户等级管理
	'buyers_member_manage' => 1, //客户管理
	'supplier_manage' 	=> 	1,
	'ad_member' 		=> 	1,
	'member_level_manage'=>	1,
	'admin_manage'		=>	1,
	'transclear'		=>	1,

	
);

$manage_menu=array(
	'manage_status' =>array(
		'manage_status'		=>	array('system/manage_status.php', 'set.global.set'),
		),
	'set'		=>	array(
						'global_set'		=>	array('set/global.php', 'set.global.set'),
						'admin_manage'		=>	array('admin/index.php', 'set.global.admin_manage'),
						'Character_admin'	=>	array('character/index.php', 'set.global.Character_admin'),
						'ad'				=>	array('ad/index.php', 'set.global.ad_manage'),
						'manage_log'		=>	array('manage_log/index.php', 'set.global.log_manage'),
						'send_mail_set'		=>	array('set/send_mail.php', 'set.global.email_set'),
						'phpmyadmin'		=>	array('phpmyadmin/index.php', 'set.global.phpmyadmin'),
						
					),
	'buyers'	=>	array(

						'buyers_member_manage'		=>	array('member/index.php', 'buyers.buyers_member_manage'),
						'buyers_level_manage'		=>	array('member/level.php', 'buyers.buyers_level_manage'),


					),

	'product'	=>	array(
						'param_category'	=>	array('product/param_category.php', 'param.param_cateogry_manage'),
						'param'				=>	array('product/param.php', 'param.param_manage'),
						'product_color'		=>	array('product/color.php', 'product.color_manage'),
						'product_size'		=>	array('product/size.php', 'product.size_manage'),
						'product_brand'		=>	array('product/brand.php', 'product.brand_manage'),
						'product_category'	=>	array('product/category.php', 'product.category_manage'),
						'product'			=>	array('product/index.php', 'product.product_manage'),
						'product_stock'		=>	array('product/stock.php', 'product.stock_manage'),
						'product_binding'	=>	array('product/binding.php', 'product.binding_manage'),
						'product_upload'	=>	array('product/upload.php', 'product.upload_manage'),
                        'gift'			    =>	array('gift/index.php', 'gift.gift_manage'),
					),
	'orders_handle'	=>	array(
					'orders'			=>	array('orders/index.php', 'orders_handle.orders_manage'),
					'orders_manage'		=> array('service/index.php','orders_handle.orders_handle'),
					'transclear'				=>array('trans_clear/index.php','orders_handle.trans_clear'),
					'shipping'			=>	array('shipping/index.php', 'orders_handle.shipping_manage'),
					'payment_method'	=>	array('payment_method/index.php', 'orders_handle.payment_method_manage'),
					'transport'			=> array('transport/index.php','orders_handle.transport'),


					),

	'member_handle'	=>	array(

						'supplier_manage'		=>	array('member/supplier.php', 'member_handle.supplier_manage'),
						'ad_member'			=>	array('member/ad.php', 'member_handle.ad_member'),
						'article_group_0'	=>	array('member/articles.php', 'member_handle.article_group_0'),
						'member_level_manage'  =>	array('member/supplier_level.php', 'member_handle.member_level_manage'),


					),

	'feedback'	=>	array(
						'feedback'			=>	array('feedback/index.php', 'feedback.feedback_manage'),
						'newsletter'		=>	array('newsletter/index.php', 'newsletter.newsletter_manage'),
						'product_review'	=>	array('product_review/index.php', 'product_review.product_review_manage'),
					),
	'article'	=>	array(
						'article_group_4'	=>	array('article/index.php?GroupId=4', 'article.group_4'),
						'links'				=>	array('links/index.php', 'links.links_manage'),
					),
	'Pers_info'	=>	array(
						'Pers_infos' 		=>	array('info_personal/index.php','Pers_info.Pers_infos'),
						'admin_update_pwd'	=>	array('admin/password.php', 'Pers_info.update_password'),

					),
	
);
//*********************************后台左菜单显示相关参数（start here）**************************************************************
?>