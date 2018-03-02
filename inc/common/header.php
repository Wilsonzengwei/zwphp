<?php 
	$MemberId = $_SESSION['member_MemberId'];
	$username = $_SESSION['UserName'];
	$IsSupplier = $_SESSION['IsSupplier'];
	//var_dump($_SESSION['website_lang']);exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit"> 
<link href="/js/plugin/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
<link href="/css/iconfont.css" rel="stylesheet" type="text/css" />
<?php 
	echo '<link href="/css/yxx_style'.$lang.'.css" rel="stylesheet" type="text/css"/>'
?>

<?php
	echo '<link rel="stylesheet" href="/css/common/header'.$lang.'.css" />'
?>


<script language="javascript" src="/js/jquery-2.1.0.js"></script>
<script language="javascript" src="/js/include.js"></script>
<script language="javascript" src="/js/header.js"></script>
</head>
<body>
<div style="height:36px;">
	<div class="header-top_mask_top">
			<div class="header-top">
			<span class="top-left">
				<span class="top-welcome"><a href="/index.php"><?=$website_language['header'.$lang]['indexa']?></a>
				<?php if($MemberId != ''){?>
					<span class="top-reg"><a href="#"><?=$username?></a></span>&nbsp;&nbsp;&nbsp;
					<span class="top-login"><a href="/account.php?module=logout"><?=$website_language['header'.$lang]['zx']?></a></span>
				<?php }else{ ?>
				</span>
				<span class="top-reg"><a href="/account.php?module=create&act=1"><?=$website_language['header'.$lang]['mfzc']?></a></span>
				<span class="top-login"><a href="/account.php?module=login"><?=$website_language['header'.$lang]['qdl']?></a></span>
				<?php };?>
			</span>			
			<span class="top-right">
				<div class="span_lang"><a href="/transport.php"><?=$website_language['header'.$lang]['khfw']?></a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a class="ieidk" data='27' href="/transport.php"><?=$website_language['header'.$lang]['tycx']?></a></div><font>|</font></div>
				<div class="span_lang"><a href="/help.php"><?=$website_language['ylfy'.$lang]['yhxy']?></a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a class="ieidk" href="/help.php?AId=15" data='15'><?=$website_language['header'.$lang]['ptkhxy']?></a><a class="ieidk" href="/help.php?AId=16" data='16'><?=$website_language['header'.$lang]['ptsjxy']?></a><a class="ieidk" href="/help.php?AId=17" data='17'><?=$website_language['header'.$lang]['ehxy']?></a></div><font>|</font></div>
				<!-- <div class="span_lang"><a href="">RFQS</a><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun"><a href="">RFQS</a></div><font>|</font></div> -->
				<div class="span_lang"><a href=""><?=$website_language['header'.$lang]['grzx']?></a><i style="font-size:10px" class="icon iconfont icon-xiala"></i>
				<div class="sun">
					<a href="/user.php?module=index&act=1"><?=$website_language['header'.$lang]['wdxx']?></a>
					<?php if($IsSupplier != '1'){?>
						<a href="/user.php?module=orders&act=1"><?=$website_language['header'.$lang]['wddd']?></a>
						<a href="/user.php?module=service_info&act=1"><?=$website_language['header'.$lang]['ddfw']?></a>
						<a href="/user.php?module=coll&act=1"><?=$website_language['header'.$lang]['wdsc']?></a>
						<a href="/user.php?module=cart&act=1"><?=$website_language['header'.$lang]['wdgwc']?></a>
						<a href="/user.php?module=address&act=1"><?=$website_language['header'.$lang]['shdz']?></a>
					<?php }?>
				</div><font>|</font></div>
				<div class="span_lang"><a href=""><?=$website_language['header'.$lang]['mjzx']?></a><i style="font-size:10px" class="icon iconfont icon-xiala"></i>
					<div class="sun">
						<a class="bxdrcnfw" href="/supplier_manage.php?module=index&act=1"><?=$website_language['header'.$lang]['dpgl']?></a>
						<a class="bxdrcnfw" href="/supplier_manage.php?module=index&act=2"><?=$website_language['supplier_m_index'.$lang]['gggl']?></a>
						<a class="bxdrcnfw" href="/supplier_manage.php?module=product&act=3" class="bxdrcnfw"><?=$website_language['header'.$lang]['cpgl']?></a>
						<a href="/supplier_manage.php?module=order&act=4"><?=$website_language['header'.$lang]['ddgl']?></a>
					</div>
					<font>|</font>
				</div>
				<div class="span_lang"><div class="sun_img lang">
					<img style="margin-top:9px" src="" alt="" />
					</div><span class="sun_a langa" href=""><?=$website_language['ylfy'.$lang]['xwb']?></span><i style="font-size:10px" class="icon iconfont icon-xiala"></i><div class="sun">
					<a class="sun_aa set_lang" href="" lang="cn">
						<div class="sun_div">
						<div class="sun_img">
						<img src="/images/header/zhongguo.png" alt="" />
						</div><span class="sun_a" data='中国' href=""><?=$website_language['ylfy'.$lang]['zwb']?></span>
						</div>
					</a>
					<a class="sun_aa set_lang" href="" lang="es">
						<div class="sun_div">
							<div class="sun_img">
							<div class="clear"></div>
							<img src="/images/header/xibanya.png" alt="" />
							</div><span class="sun_a" data='es' href=""><?=$website_language['ylfy'.$lang]['xwb']?></span>
						</div>
					</a>	
					<a class="sun_aa set_lang" href="" lang="en">
						<div class="sun_div">
							<div class="sun_img">
							<div class="clear"></div>
							<img src="/images/header/eng.png" alt="" />
							</div><span class="sun_a" data='en' href=""><?=$website_language['ylfy'.$lang]['ywb']?></span>
						</div>
					</a>					
					</div><font>|</font>
				</div>		
			</span>	
			<script>
                $('.set_lang').click(function(){
                    var lang = $(this).attr('lang');                    
                    $.post('/inc/site_config.php',{'set_lang':lang},function(data){
                      if(data=='cn'){
                      	window.sessionStorage.setItem('langt','cn');    
                      	window.sessionStorage.setItem('lang','/images/header/zhongguo.png');	                	
                      }else if(data=='en'){                      
                      	window.sessionStorage.setItem('langt','en');  
                      	window.sessionStorage.setItem('lang','/images/header/eng.png');	
                      }else if(data=='es'){                      
                      	window.sessionStorage.setItem('langt','es');  
                      	window.sessionStorage.setItem('lang','/images/header/xibanya.png');	
                      }else{
                      	window.sessionStorage.setItem('langt','es');  
                      }
                    });
                });
            </script>		
		</div>
	</div>
</div>


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


