<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
function_exists('set_magic_quotes_runtime') && set_magic_quotes_runtime(0);
function_exists('date_default_timezone_set') && date_default_timezone_set("PRC");
$InLy200MysqlDatabase!==true && filter_variable();
session_start();
header('Content-Type: text/html; charset=utf-8');

slashes_gpc($_GET);
slashes_gpc($_POST);
slashes_gpc($_COOKIE);

//********************************************************网站相关参数设置（开始）*******************************************************************
$site_root_path	=	substr(dirname(__FILE__), 0, -4);	//网站根目录
$manage_path 	=   '/manage/'; //后台目录
$supplier_manage_path 	=   '/supplier_manage/'; //后台目录
$service_time	=	time();		//服务器当前时间
$mCfg			=	load_mcfg();	//加载系统全局设置变量
$mCfg_product_where = ' and IsUse=2';
//********************************************************网站相关参数设置（结束）*******************************************************************

//********************************************************数据库相关配置（开始）*********************************************************************
$db_host		=	'localhost';	//数据库地址
$db_port		=	'';				//数据库端口
$db_username	=	'globaleagl_3nb8f';			//数据库用户名
$db_database	=	'eaglesell';		//数据库名称
$db_password	=	'5rxcihynh8acxoc';		//数据库密码
$db_char		=	'utf8';			//数据库编码
//********************************************************数据库相关配置（结束）*********************************************************************

//********************************************************此文件使用的相关函数（开始）****************************************************************
function filter_variable(){
	$allowed=array('GLOBALS'=>1, '_GET'=>1, '_POST'=>1,'_COOKIE'=>1, '_FILES'=>1, '_SERVER'=>1);
	foreach($GLOBALS as $key=>$value){
		if(!isset($allowed[$key])){
			$GLOBALS[$key]=null;
			unset($GLOBALS[$key]);
		}
	}
}

function slashes_gpc(&$array){
	foreach($array as $key=>$value){
		if(is_array($value)){
			slashes_gpc($array[$key]);
		}else{
			$array[$key]=trim($array[$key]);
			!get_magic_quotes_gpc() && $array[$key]=addslashes($array[$key]);
		}
	}
}
$lang = '';
if($_POST['set_lang']){
	$_SESSION['website_lang'] = '';
	if($_POST['set_lang']=='cn'){
		$_SESSION['website_lang'] = '_lang_1';
		echo "cn";
	}elseif($_POST['set_lang']=='es'){
		$_SESSION['website_lang'] = '';
		echo "es";
	}elseif($_POST['set_lang']=='en'){
		$_SESSION['website_lang'] = '_en';
		echo "en";
	}
	exit;
}

if($_SESSION['website_lang']){
	$lang = $_SESSION['website_lang'];
}
$mobile_url = '/mobile';
/*判断移动端 开始*/
$client_agent=$_SERVER['HTTP_USER_AGENT'];
$phone_client_agent_array=array('240x320','acer','acoon','acs-','abacho','ahong','airness','alcatel','amoi','android','anywhereyougo.com','applewebkit/525','applewebkit/532','asus','audio','au-mic','avantogo','becker','benq','bilbo','bird','blackberry','blazer','bleu','cdm-','compal','coolpad','danger','dbtel','dopod','elaine','eric','etouch','fly ','fly_','fly-','go.web','goodaccess','gradiente','grundig','haier','hedy','hitachi','htc','huawei','hutchison','inno','ipad','ipaq','ipod','jbrowser','kddi','kgt','kwc','lenovo','lg ','lg2','lg3','lg4','lg5','lg7','lg8','lg9','lg-','lge-','lge9','longcos','maemo','mercator','meridian','micromax','midp','mini','mitsu','mmm','mmp','mobi','mot-','moto','nec-','netfront','newgen','nexian','nf-browser','nintendo','nitro','nokia','nook','novarra','obigo','palm','panasonic','pantech','philips','phone','pg-','playstation','pocket','pt-','qc-','qtek','rover','sagem','sama','samu','sanyo','samsung','sch-','scooter','sec-','sendo','sgh-','sharp','siemens','sie-','softbank','sony','spice','sprint','spv','symbian','tablet','talkabout','tcl-','teleca','telit','tianyu','tim-','toshiba','tsm','up.browser','utec','utstar','verykool','virgin','vk-','voda','voxtel','vx','wap','wellco','wig browser','wii','windows ce','wireless','xda','xde','zte','mobile');
foreach($phone_client_agent_array as $agent){
	if(stripos($client_agent, $agent)){
		$phone_client_agent=1;
		break;	
	}
}
if($phone_client_agent && !strpos($_SERVER['REQUEST_URI'],'mobile')) {
	header("Location: /mobile".$_SERVER['REQUEST_URI']);
}
/*判断移动端 结束*/

function load_mcfg(){	//加载系统全局设置变量
	global $site_root_path;
	@include($site_root_path.'/inc/set/exchange_rate.php');
	@include($site_root_path.'/inc/set/global.php');
	@include($site_root_path.'/inc/set/seo.php');
	@include($site_root_path.'/inc/set/orders_print.php');
	@include($site_root_path.'/inc/set/send_mail.php');
	@include($site_root_path.'/inc/set/online.php');
	return $mCfg;
}
@include($site_root_path.'/inc/lang/language.php');
@include($site_root_path.'/inc/lang/language_lang_1.php');

$online_ary=array('Skype','邮件');

//********************************************************此文件使用的相关函数（结束）***************************************************************
?>