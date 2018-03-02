<?php 
include('../../inc/include.php'); 
// $page_name = 'home';
$AId = (int)$_GET['AId'];
if($AId){
    $article_row=$db->get_one('article', "AId='$AId'");
}
$Title=$article_row['Title'.$lang];
if($_GET['select_TId'] == 'TId'){
    $TId = $_GET['MyTId'];
    $transport = $db->get_value('transport',"TOId='$TId'",'TId');
    //print_r($transport);exit;
    $logistics_row = $db->get_all('logistics',"TId='$transport'");
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php echo seo_meta($article_row['SeoTitle'.$lang],$article_row['SeoKeyword'.$lang],$article_row['SeoDescription'.$lang]);?>
    <link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
    <link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
    <link href="../../css/account.css" rel="stylesheet" type="text/css" />
<link href="../../css/global.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
    <div id="article">
        <div class="top_title">
            <a href="javascript:;" onclick="history.back();" class="return"></a>
            <?=$Title; ?>
        </div>
        <div style="margin-left:0" class="description">
         <?php if($AId == "31"){?>
            <div style="width:100%;height:45px;border:1px solid #e6e6e6">
                <div style="margin-left:0;width:90%;padding-left:3%;line-height:45px;font-size:18px;color:#333333"><?=$Title; ?></div>                
            </div>
            <form action="article.php" method="get" name="select_form">
            <div style="margin-left:5%;margin-top:5%;font-size: 0.1rem">
                    <?=$website_language['member'.$lang]['order']['order_num']; ?>：
                    <input id="txt" type="text" name="MyTId" style="padding:0 5px;width:25%;height:21px;border:1px solid #ccc;">
                    <input type="hidden" name="select_TId" value="TId">
                    <input type="hidden" name="AId" value="31">
                    <input id="btn" type="submit" style="width:20%;height:23px;background:#218fde;color:#ffffff;border:0px" value="<?=$website_language['member'.$lang]['order']['Inquire']; ?>">     
                                  
            </div>
            </form>
            <div class="titleState" style="margin-top:10%">                
                <span style="display: block;width:100%;margin-top:1%" class="titleInfo"><?=$website_language['member'.$lang]['order']['waybillNumber']; ?>：<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;<?=$transport_row['TOId']?></strong></span></span>
        
                <span style="display: block;width:100%;margin-top:1%" class="titleCompany"><?=$website_language['member'.$lang]['order']['company']; ?>：<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;<?=$transport_row['Company']?></strong></span></span>
               
                <span style="display: block;width:100%;margin-top:1%" class="titlePhone"><?=$website_language['member'.$lang]['order']['telephone']; ?>：<span style="display:inline-block;color:#ec6400;width:50%;"><strong>&nbsp;0755-33119835</strong></span></span>
               
            </div>
            <hr style="width:100%;margin:20px 0;margin-left:4%;">
               <div style="width:100%;position:relative">
                <span style="position:absolute;top:0;left:0;display:inline-block;width:20%;color:#333;margin-left:5%;word-break:break-all;font-weight:bolder;"><?=$website_language['member'.$lang]['order']['time']; ?></span>    
                <span style="position:absolute;top:0;left:20%;display:inline-block;width:20%;"></span>
                <span style="position:absolute;top:0;right:0;display:inline-block;width:50%;color:#333;margin-left:0%;word-break:break-all;font-weight:bolder;"><?=$website_language['member'.$lang]['order']['progress']; ?></span>
            </div>
            <div id="cc" style="min-height: 1%;">
            <?php 
                for($i=0;$i<count($logistics_row);$i++){
            ?>     
            <br><br><br>
            
            <div style="width:100%;position:relative;">
                <span style="position:absolute;top:0;left:0;display:inline-block;width:30%;color:#333;margin-left:5%;"><?=date('Y-m-d H:i:s',$logistics_row[$i]['ShippingTime']);?></span>    
                <span style="position:absolute;top:0;left:36%;display:inline-block;width:20%;background:url(../../images/atricle/gfd01.png) no-repeat;height: 16px;">&nbsp;</span>
                <span style="position:absolute;top:0;right:0;display:inline-block;width:50%;color:#333;margin-left:0%;word-break:break-all"><?=$logistics_row[$i]['LogisticsInfo'];?></span>
            </div>
            <?php }?>
            </div>
            <div style="margin-top:15%;color:#333" class="tips-state"><?=$website_language['member'.$lang]['order']['Cre_1']?></div>
            
              <?php }else{?>
            <?=$article_row['Contents'.$lang]; ?>
           <?php }?>
        </div>
    </div>
    <?php include($site_root_path.$mobile_url.'/inc/footer.php'); ?>
</body>
</html>
<script>
    $("#cc div:first").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd01.png) no-repeat")
    })
    $("#cc div:first").siblings("div").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd03.png) no-repeat");
    })
    $("#cc div:last").each(function(){
        $(this).children("span :eq(1)").css("background","url(/images/atricle/gfd05.png) no-repeat")
     })
</script>