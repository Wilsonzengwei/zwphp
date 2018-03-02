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
<script>
    $(function(){
       $("[input=submit]").css("cursor","pointer");
        $("[input=button]").css("cursor","pointer");
        $("[input=radio]").css("cursor","pointer");
        $("img").css("cursor","pointer");

        $("input").css("outline","none");
    })
</script>
<div id="platform_header">
    <div class="head_top">
        <div class="global">
            <?php /*
            <select name="" id="" class="entrance">
                <option value="">卖家入口</option>
                <option value="">卖家入口</option>
            </select>*/ ?>
            <div class="loginbar fr">
                <?=$website_language['head'.$lang]['welcome']; ?> 
                <?php if($_SESSION['member_MemberId']){ ?>
                    <a href="/account.php" class="h_link blue"><?=$_SESSION['member_Email']; ?></a>
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
                    <a href="/account.php?module=create&&cre_act=0" class="h_link blue"><?=$website_language['head'.$lang]['registered']; ?></a> <?=$website_language['head'.$lang]['or']; ?> 
                    <a href="/account.php" class="h_link blue"><?=$website_language['head'.$lang]['logn_in']; ?></a>
                <?php } ?>
                <em class="bor"></em>   
                <a href="/article.php?AId=31" class="h_link"><?=$website_language['head'.$lang]['shipping']; ?></a><em class="bor"></em>     
                <a href="/article.php?AId=32" class="h_link"><?=$website_language['head'.$lang]['type']; ?></a><em class="bor"></em>   
                <a href="/account.php?module=wishlists" class="h_link"><?=$website_language['head'.$lang]['favorites']; ?></a><em class="bor"></em>
                <?php if($_SESSION['member_MemberId']){$cart_sum = $db->get_row_count('shopping_cart',"MemberId='$MemberId' ");}?>
                <a href="/cart.php" class="h_link"><?=$website_language['head'.$lang]['cart']; ?>&nbsp;&nbsp;<font style="color: red;"><?php if($_SESSION['member_MemberId']){?><?=$cart_sum;?><?php }else{?>0<?php }?></font></a>
                
                <em class="bor"></em> 
                <span id="language" style="height: 16px; ">
                    <!-- <span class="down" style="top: 13px;border-top-color:#333;"></span> -->
                    <span class="item" style="width: 90px;">
                    <div style="width: 102px;">
                        <div style="width: 20px;height: 20px;float: left;line-height: 30px;"><img src="/images/chinese.png"></div>
                         <div style="width: 20px;height: 20px;float: left;line-height: 30px;margin-left: 2px;"><img src="/images/spanish.png"></div>
                        <div style="float: left;width: 60px;height: 30px; line-height: 30px;">
                            <div style="float: left;width: 50px;"><?=$website_language['head'.$lang]['language']; ?></div>
                            <div class="down" style="border-top-color:#333;margin-top: 13px;float: left;"></div>
                        </div>
                    </div>
                   
                    </span>
                    <span class="lang_list trans3" style="top: 30px;width: 90px;">
                        <a href="javascript:;" class="list trans3 set_lang" lang="cn">
                            <div style="width: 100%;">
                                <div style="width: 20px;height: 20px;float: left;line-height: 30px;margin-left: 10px;"><img src="/images/chinese.png"></div>
                                <div style="float: right;margin-right: 10px;width: 50px;"><?=$website_language['head'.$lang]['chinese']; ?></div>
                            </div></a>
                            
                        <a href="javascript:;" class="list trans3 set_lang" lang="sp">
                            <div style="width: 100%;">
                                <div style="width: 20px;height: 20px;float: left;line-height: 30px;margin-left: 10px;"><img src="/images/spanish.png"></div>
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
    <div class="head_mid">
        <div class="global">
            <div class="logo">
                <div class="pic">
                    <a href="/" title="home"><img src="/images/logo2.png" alt="home"></a>
                </div>
            </div>
            <div class="search">
                <form action="/products.php">
                    <input type="text" name="Keyword" placeholder="<?=$website_language['head'.$lang]['placeholder']; ?>" class="input">
                    <select name="IsSupplier" id="" class="select">
                        <option value="0"><?=$website_language['head'.$lang]['all_category']; ?></option>
                        <option value="1"><?=$website_language['head'.$lang]['supplier']; ?></option>
                    </select>
                    <button class="button"></button>
                    <div class="clear"></div>
                </form>
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
    <div class="head_bot">
        <div class="nav global">
            <div class="category_nav">
                <div class="top_title"><?=$website_language['head'.$lang]['category']; ?></div>
                <div class="cate_list <?=$page_name=='index' ? '' : 'hide'; ?>">
                    <?php
                     foreach((array)$All_Category_row['0,'] as $k => $v){ 
                        $name = $v['Category'.$lang];
                        $vCateId = $v['CateId'];
                        $url = get_url('product_category',$v);
                        $count_where="(CateId in(select CateId from product_category where UId like '%{$v[UId]}{$vCateId},%') or CateId='{$vCateId}')";
                        ?>
                        <div class="top_list">
                    
                      
                                
                     
                          
                            <?php 

                            if($name == "EAGLE HOME"){?>
                                <a id="aaa" href="<?=$url; ?>" class="top_item <?=$All_Category_row['0,'.$vCateId.','] ? 'top_on' : ''; ?> <?=$k==0 ? 'not_bort' : ''; ?>" title="<?=$name; ?>"><?=$name; ?> <span>(<?=$db->get_row_count('product',$count_where." and IsUse=2"); ?>)</span></a>
                                    
                                <script>
                                    var  email = "<?=$_SESSION['member_MemberId']?>";

                                     $("#aaa").click(function(){
                                        if(email==""){
                                            var til_1 = "<?=$website_language['member'.$lang]['login']['til_1'];?>";
                                            alert(til_1);
                                            return false;
                                        }
                                       
                                    })
                                </script>

                            <?php }else{?>

                                <a href="<?=$url; ?>" class="top_item <?=$All_Category_row['0,'.$vCateId.','] ? 'top_on' : ''; ?> <?=$k==0 ? 'not_bort' : ''; ?>" title="<?=$name; ?>"><?=$name; ?> <span>(<?=$db->get_row_count('product',$count_where); ?>)</span></a>
                            <?php }?>


                            <?php if($All_Category_row['0,'.$vCateId.',']){ ?>
                                <div class="sec_list hide">
                                    <?php
                                        $num=0; 
                                        foreach((array)$All_Category_row['0,'.$vCateId.','] as $k1 => $v1){ 
                                        $name1 = $v1['Category'.$lang];
                                        $v1CateId = $v1['CateId'];
                                        $url1 = get_url('product_category',$v1);
                                        if($num > 8) continue;
                                        if((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.',']){
                                        $num++;
                                        ?>
                                            <div class="sec_list_2 <?=$k1<6 ?'' : 'not_borb'; ?>">
                                                <a href="<?=$url1; ?>" class="sec_item" title="<?=$name1; ?>"><?=$name1; ?></a>
                                                <?php foreach((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.','] as $k2 => $v2){ 
                                                    if($k2>3) continue;
                                                    $name2 = $v2['Category'.$lang];
                                                    $v2CateId = $v2['CateId'];
                                                    $url2 = get_url('product_category',$v2);
                                                    ?>
                                                    <a href="<?=$url2; ?>" class="thi_item" title="<?=$name2; ?>"><?=$name2; ?></a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="nav_list">
                <a href="/products.php?pro_type=1" class="list not_borl" title="Ofertas diarias"><?=$website_language['nav'.$lang]['type_1']; ?></a>
                <a href="/products.php?pro_type=2" class="list" title="Nueva llegada"><?=$website_language['nav'.$lang]['type_2']; ?></a>
                <a href="/products.php?pro_type=3" class="list" title="Mejor venta"><?=$website_language['nav'.$lang]['type_3']; ?></a>
                <a href="/products.php?pro_type=4" class="list" title="Zona de marca"><?=$website_language['nav'.$lang]['type_4']; ?></a>
                <a href="/products.php?CateId=110" class="list" title="Venta al por mayor de B2B"><?=$website_language['manage'.$lang]['eag_prod']; ?></a>                                               
            </div>
            <div class="clear"></div>
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