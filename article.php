<?php
include('inc/include.php');

$group_name = array(
    1 => $website_language['foot'.$lang]['title1'],
    2 => $website_language['foot'.$lang]['title2'],
    3 => $website_language['foot'.$lang]['title3'],
    4 => $website_language['foot'.$lang]['title4'],
);

$AId=(int)$_GET['AId'];
if($AId){

    $article_row=$db->get_one('article', "AId='$AId'");
    $GroupId = (int)$article_row['GroupId'];
    $Title=$article_row['Title'.$lang];
}
if($_GET['select_TId'] == 'TId'){
    $TId = $_GET['MyTId'];
    $transport = $db->get_value('transport',"TOId='$TId'",'TId');
    $transport_row = $db->get_one('transport',"TOId='$TId'");
    //print_r($transport);exit;
    $logistics_row = $db->get_all('logistics',"TId='$transport'");
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php echo seo_meta($article_row['SeoTitle'],$article_row['SeoKeyword'],$article_row['SeoDescription']);?>
<?php include("$site_root_path/inc/common/static.php"); ?>
<link href="/css/account.css" rel="stylesheet" type="text/css" />
<link href="/css/global.css" rel="stylesheet" type="text/css" />
</head>
<style>
    success{
        color:#ec6400;
    }
</style>
<body>
<?php include("$site_root_path/inc/common/platform_header.php"); ?>
<div class="clear"></div>
<div id="location">
    <div class="global">
        <a href="/" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a> - <?=$Title; ?>
    </div>
</div>
<div id="page_content">
    <div class="global">
        <div class="content_left">
            <div class="title"><?=$group_name[$GroupId]; ?></div>
            <?php $article_list_row = $db->get_all('article','GroupId='.$GroupId,'*','MyOrder desc,AId asc'); ?>
            <?php foreach((array)$article_list_row as $v){ 
                $name = $v['Title'.$lang];
                $url = get_url('article',$v);
                ?>
                <div class="top_list <?=$AId==$v['AId'] ? 'art_top_on' : ''; ?>">
                    <a href="<?=$url; ?>" class="top_item" title="<?=$name; ?>"><?=$name; ?></a>
                </div>
            <?php } ?>
        </div>
        <div class="content_right" style="min-height: 400px;">
            <?php if($AId == "31"){?>
            <div style="width:190px;height:45px;border:1px solid #e6e6e6;background:#f2f2f2">
                <div style="width:190px;height:45px;text-align:center;line-height:45px;font-size:18px;color:#333333;font-family: 'Segoe UI Symbol'"><?=$Title; ?></div>                
            </div>
            <form action="article.php" method="get" name="select_form">
            <div style="margin-left:20px;margin-top:45px;font-size:14px;color:#333">
                    <?=$website_language['member'.$lang]['order']['order_num']; ?>:
                    <input value="<?=$website_language['member'.$lang]['order']['Ball_num']; ?>" id="txt" type="text" name="MyTId" style="width:221px;height:21px;font-size: 12px;color:#aaa">
                    <input type="hidden" name="select_TId" value="TId">
                    <input type="hidden" name="AId" value="31">
                    <input id="btn" type="submit" style="width:90px;height:25px;background:#218fde;color:#ffffff;cursor:pointer;border:0px;" value="<?=$website_language['member'.$lang]['order']['Inquire']; ?>">
                                  
            </div>
            </form>
            <div class="titleState">
                <span  class="titleInfo" style="font-size: 14px;color: #333"><?=$website_language['member'.$lang]['order']['waybillNumber']; ?>:<span style="display:inline-block;color:#ec6400;font-size:14px;"><strong><?=$transport_row['TOId']?></strong></span></span>
                <span class="titleCompany" style="font-size: 14px;color: #333"><?=$website_language['member'.$lang]['order']['company']; ?>:<span style="display:inline-block;color:#ec6400;font-size:14px;"><strong><?=$transport_row['Company']?></strong></span></span>
                <span class="titlePhone" style="font-size: 14px;color: #333;margin-left: -10px;"><?=$website_language['member'.$lang]['order']['telephone']; ?>:<span style="display:inline-block;color:#ec6400;font-size:14px;width: 100px;"><strong>0755-33119835</strong></span></span>
            </div>
            <hr style="width:709px;margin-left:20px">
            <span id="time-state"><?=$website_language['member'.$lang]['order']['time']; ?></span>    
            <span id="content-state"><?=$website_language['member'.$lang]['order']['progress']; ?></span>
            <div style="min-height: 275px;">   
            <table  class="table-state">     
                <?php 
                    for($i=0;$i<count($logistics_row);$i++){
                ?>                   
                <tr style="display:inline-block;width:500px;height:50px;">      
                    <td style="display: inline-block;height: 30px;width: 70px;text-align: center;margin-left: 10px;color:#999999;font-size: 12px" class="timeInfo">
                    <?=date('Y-m-d H:i:s',$logistics_row[$i]['ShippingTime']);?>
                    </td>
                    <td style="display: inline-block;width:16px;height: 16px;margin-left:20px;margin-top:10px;background: url(/images/atricle/gfd01.png) no-repeat;" class="signImg"></td>
                    <td style=" display: inline-block;margin-left:30px;color:#999999" class="LocationAndTrackingProgress"><?=$logistics_row[$i]['LogisticsInfo'];?></td>
                </tr>

                <?php }?>
               
                
            </table>
            </div>
            <div class="tips-state"><?=$website_language['member'.$lang]['order']['Cre_1']; ?></div>
        </div>
            <?php }else{?>
                <div class="top_title"><?=$Title; ?></div>
                <div class="content">
                    <?=$article_row['Contents'.$lang]; ?>
                </div>
            <?php } ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include("$site_root_path/inc/common/platform_foot.php"); ?>
<?php include("$site_root_path/inc/common/footer.php"); ?>
</body>
<script>
    // var a=window.localStorage.getItem("name",a);
    // $("#btn").click(function(){  
    //     a++;
    //     var ts=$(".table-state");     
    //     ts.css('display','block');   
    //     window.localStorage.setItem("name",a);       
    // })
    // $(":button").hover(function(){
    //     $(this).css("cursor","pointer");
    // })

    // var b=window.localStorage.getItem("pwd",);;
    // $("#btn2").click(function(){    
    //     b++;
    // window.localStorage.setItem("pwd",b);
    // })
    
    // $("table tr:not(:first):not(:last)").sublings("tr td:eq(1)").each(function(){
    //     $(this).css('background',"url(/images/atricle/gfd03.png) no-repeat")
    // })
     $(".table-state tr:eq(0)").siblings("tr").each(function(){
           $(this).children("td:eq(1)").each(function(){
               $(this).css("background","url(images/atricle/gfd03.png) no-repeat");
           })
        })
        $(".table-state tr:last td:eq(1)").each(function(){
            $(this).css("background","url(images/atricle/gfd04.png) no-repeat");
        })   
        $(".table-state tr:last td:eq(1)").siblings("td").each(function(){
            $(this).css("color","#ec6400");
        })

    $("#txt").click(function(){
        $(this).val("");
    })

    
    
</script>
</html>