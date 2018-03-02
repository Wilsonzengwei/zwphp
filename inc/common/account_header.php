<?php 
	$Language_row=$db->get_limit('translate','1','*','MyOrder desc,LId ASC');
	if((int)$_SESSION['member_MemberId']){	//已登录的，架构会员中心页面内容排版
		$where="MemberId='{$_SESSION['member_MemberId']}'";
	}else{
		$where="SessionId='{$cart_SessionId}'";	
	}
    if(!$_SESSION['member_IsSupplier']){
        $MemberId = $_SESSION['member_MemberId'];
        $order_row = $db->get_row_count('orders',"MemberId='$MemberId' and PaymentStatus='1'");
    }elseif($_SESSION['member_IsSupplier']){
        $MemberId = $_SESSION['member_MemberId'];
        $order_row = $db->get_row_count('orders',"SupplierId='$MemberId' and SMApply='1' ");
    }
?>

<div id="platform_header">
    <div class="head_top">
        <div class="global">
            <?php /*
            <select name="" id="" class="entrance">
                <option value="">卖家入口</option>
                <option value="">卖家入口</option>
            </select>*/ ?>
            <div class="loginbar fr">
                <span style="color:#E70012;cursor:pointer;" onclick="window.open('http://www.eaglesell.com/','_self')"><?=$website_language['head'.$lang]['index_yxx']; ?></span>
                <?php if($_SESSION['member_MemberId']){ ?>
                    <a style="margin-right: 30px;" href="/account.php" class="h_link blue"><?=$_SESSION['member_Email']; ?></a>
                    <a style="margin-right: 20px;" href="/index.php" class="h_link blue"><font style="color:#000;"><?=$website_language['member'.$lang]['login']['eaglesell_return']; ?></font></a>
                    <em class="bor"></em>         
                    <span id="account">
                        <span class="down" style="top: 13px;border-top-color:#333;"></span>
                        <span class="item"><a href="/account.php" class="trans3"><?=$website_language['head'.$lang]['my_account']; ?></a></span>
                        <span class="lang_list trans3" style="top: 30px;">
                            <?php if(!$_SESSION['member_IsSupplier']){ ?>
                                <a href="/account.php?module=orders&act=list" class="list trans3"><?=$website_language['head'.$lang]['my_order']; ?>&nbsp;<font style="color: red;"><?=$order_row;?></font></a>
                                <a href="/account.php?module=wishlists" class="list trans3"><?=$website_language['head'.$lang]['wish_lists']; ?></a>
                            <?php } ?>
                            <?php if($_SESSION['member_IsSupplier']){ ?>
                            <a href="<?=$_SESSION['member_IsSupplier'] ? '/supplier_manage/orders/index.php': '/account.php?module=logout'; ?>" class="list trans3"><?=$website_language['head'.$lang]['my_order']; ?>&nbsp;<font style="color: red;"><?=$order_row;?></font></a>
                            <?php }?>
                            <a href="<?=$_SESSION['member_IsSupplier'] ? '/supplier_manage/admin/logout.php': '/account.php?module=logout'; ?>" class="list trans3"><?=$website_language['head'.$lang]['sign_out']; ?></a>
                        </span>
                    </span>
                <?php }else{ ?>
                    <a href="/account.php?module=create&cre_act=0" class="h_link blue"><?=$website_language['head'.$lang]['registered']; ?></a> <?=$website_language['head'.$lang]['or']; ?> 
                    <a href="/account.php" class="h_link blue"><?=$website_language['head'.$lang]['logn_in']; ?></a>
                <?php } ?>
                <em class="bor"></em>   
                <span id="language" style="height: 16px; ">
                    <!-- <span class="down" style="top: 13px;border-top-color:#333;"></span> -->
                    <span class="item" style="width: 90px;">
                    <div style="width: 102px;margin-top: 5px;">
                        <div style="width: 20px;height: 16px;float: left;line-height: 30px;"><img src="/images/chinese.png"></div>
                         <div style="width: 20px;height: 16px;float: left;line-height: 30px;margin-left: 2px;"><img src="/images/spanish.png"></div>
                        <div style="float: left;width: 60px;height: 30px; line-height: 15px;">
                            <div style="float: left;width: 45px;"><?=$website_language['head'.$lang]['language']; ?></div>
                            <div class="down" style="border-top-color:#333;margin-top: 5px;float: left;"></div>
                        </div>
                    </div>
                   
                    </span>
                    <span class="lang_list trans3" style="top: 30px;width: 90px;">
                        <a href="javascript:;" class="list trans3 set_lang" lang="cn">
                            <div style="width: 100%;height: 30px;">
                                <div style="width: 20px;height: 20px;float: left;margin-left: 10px;margin-top: 5px;"><img src="/images/chinese.png"></div>
                                <div style="float: right;margin-right: 10px;width: 50px;"><?=$website_language['head'.$lang]['chinese']; ?></div>
                            </div></a>
                            
                        <a href="javascript:;" class="list trans3 set_lang" lang="sp">
                            <div style="width: 100%;">
                                <div style="width: 20px;height: 20px;float: left;line-height: 30px;margin-left: 10px;margin-top: 5px;"><img src="/images/spanish.png"></div>
                                <div style="float: right;margin-right: 10px;width: 50px; "><?=$website_language['head'.$lang]['spanish']; ?></div>
                            </div></a>
                    </span>
                </span>
                <script>
                    $('.set_lang').click(function(){
                        var lang = $(this).attr('lang');
                        $.post('/',{'set_lang':lang},function(){
                            location=location;
                        });
                    });
                </script>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="global" style="margin: 10px auto;">
        <div class="logo">
            <a href="/" title="home"><img src="/images/logo2.png" alt="home"></a>
        </div>
    </div>
</div> 
<script>
    $('.category_nav .top_list').hover(function(){
        $(this).find('.sec_list').show();
    },function(){
        $(this).find('.sec_list').hide();
    });
    $('.category_nav .top_title').click(function(){
        if($(this).next('.cate_list').hasClass('hide')){
            $(this).next('.cate_list').removeClass('hide');
        }else{
            $(this).next('.cate_list').addClass('hide'); 
        }
    });
           
     
</script>