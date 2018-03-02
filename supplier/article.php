<?php
include('../inc/include.php');
$supplierid = $_GET['SupplierId'];
$AId=(int)$_GET['AId'];
if($AId){
	$article_row=$db->get_one('article', "AId='$AId'");
}
$Article_Num = (int)$article_row['Num'];
$Title=$article_row['Title'.$lang];
$isbl = $db->get_one('member',"MemberId=$supplierid",'Is_Business_License');
$isbl = $isbl['Is_Business_License'];
$art_aid = $db->get_value('article','Num=1 and SupplierId='.$SupplierId,'AId');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php echo seo_meta($article_row['SeoTitle'],$article_row['SeoKeyword'],$article_row['SeoDescription']);?>
<?php include("$site_root_path/inc/common/static.php"); ?>
</head>
<body>
<?php include("$site_root_path/inc/common/header.php"); ?>
<div id="location">
    <div class="global">
        <a href="/supplier/?SupplierId=<?=$SupplierId; ?>" title="<?=$website_language['nav'.$lang]['home']; ?>"><?=$website_language['nav'.$lang]['home']; ?></a> - <?=$Title; ?>
    </div>
</div>
<div id="page_content">
    <div class="global">
        <div class="content_left">
            <div class="title"><?=$website_language['products'.$lang]['products']; ?></div>
            <?php include("$site_root_path/inc/common/pro_left.php"); ?>
            <div class="left_information" style="margin-top: 30px;">
                <div class="info">
                    <?php $supplier_row = $db->get_one('member',"MemberId='$SupplierId'"); ?>
                    <div class="info_title"><?=$website_language['information'.$lang]['title']; ?></div>
                    <div class="addr"><?=$supplier_row['Supplier_Address'.$lang]; ?></div>
                    <!-- <div class="country">China</div> -->
                    <div class="desc"></div>
                    <a href="/supplier/?SupplierId=<?=$SupplierId; ?>" class="visit"><?=$website_language['information'.$lang]['visit']; ?></a>
                    <?php /*
                        <a href="" class="favorite"><?=$website_language['information'.$lang]['favorite']; ?></a>
                    */ ?>
                </div>
                <div class="contact">
                    <div class="con_title"><?=$website_language['information'.$lang]['contact']; ?></div>
                    <a href="emailto:<?=$supplier_row['Email']; ?>" class="email" title="<?=$website_language['information'.$lang]['email']; ?>">
                        <?=$website_language['information'.$lang]['email']; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php if($art_aid == $AId){


        ?>
          <div class="content_right">
                <div class="top_title"><?=$Title; ?></div>
                <div class="content">
                    <?=$article_row['Contents'.$lang]; ?>
                    <div class="clear"></div>
                </div>
            </div>
    <?php }else{


        ?>
          


        <?php if($isbl == '0'){
        
            ?>
        <div class="content_right">
            <div class="top_title"><?=$Title; ?></div>
            <br>
            <div id="content" style="width:750px;height:650px;font-family:'宋体';">
                <div style="width:100%;height:35px;margin-top:-10px;line-height:35px;text-indent:20px;font-size:12px;color:#333333;border-bottom:2px solid #ccc;font-weight:bold"><?=$ContactUs_language['Mer_Info'.$lang]['MerInfo_1']?></div>
                <div style="width:100%;height:300px;">
                    <div style="width:90%;margin-top:20px"> 
                        <table style="line-height:20px">
                            <tr>
                                <td style="text-align:right;color:#666666;width:250px;"><?=$ContactUs_language['Mer_Info'.$lang]['Corporation']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Name2']);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['address']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Address'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['city']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myshi'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Country']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myguojia'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['State_Province']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myshenfen'.$lang]);?></td>
                            </tr>

                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['PostalCode']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myem'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['PhoneNumber']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Phone']);?></td>
                            </tr>
                            <!-- <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Fax_number']?>：</td>
                                <td style="color:#333333"><?=$ContactUs_language['Mer_Info'.$lang]['Fax_numberTxt']?></td>
                            </tr> -->
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Mobile_phone']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Mobile']);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['homepage']?>：</td>
                                <td onclick="window.location.href='http://<?=$supplier_row['ComWebSite'];?>/'" style="color:#0066cc;cursor:pointer"><?=$supplier_row['ComWebSite'];?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Other_home_address']?>：</td>
                                <td onclick="window.location.href='http://<?=$supplier_row['ComWebSite_1'];?>/'" style="color:#0066cc;cursor:pointer" ><?=$supplier_row['ComWebSite_1'];?></td>
                            </tr>
                        </table>
                    </div>
                    <br><br>
                    <div style="text-indent:20px;font-size:12px;color:#333333;font-weight:bold"><?=$website_language['manage'.$lang]['article_1']?></div>
                    <hr style="border:1px solid #ccc">
                </div>
                <br>
                <div style="width:100%;height:90px;border-bottom:2px solid #ccc">
                    <div style="width:70%;height:30px;margin-top:5%;font-size:12px;color:#666666">                       
                            <table>
                                <tr>
                                <td style="padding-right: 20px;padding-left: 20px;width:250px;font-size:14px;text-align:right;color:#333;"><?=$website_language['form'.$lang]['first']?>：<?=htmlspecialchars($supplier_row['First_name']);?></td>
                                <td style="padding-right: 20px;padding-left: 20px;"><?=$website_language['manage'.$lang]['article_2']?>：<?=htmlspecialchars($supplier_row['Article_2']);?></td>
                                <td style="padding-right: 20px;padding-left: 20px;"><?=$website_language['manage'.$lang]['article_3']?>：<?=htmlspecialchars($supplier_row['Article_3']);?></td>
                            </tr>
                            </table>                       
                    </div>
                    <div style="margin-top:30px;text-indent:20px;font-size:12px;font-weight:bold"><?=$website_language['manage'.$lang]['article_4']?></div>
                </div>
                <div style="width:90%;margin-top:20px;color:#666666"> 
                        <table style="line-height:20px">
                            <tr>
                                <td style="text-align:right;color:#666666;width:250px;"><?=$website_language['manage'.$lang]['article_5']?>：</td>
                                <td onclick="window.open('http://<?=$supplier_row['ComWebSite'];?>/','_self')" style="color:#0066cc;cursor:pointer"><?=htmlspecialchars($supplier_row['Article_5']);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$website_language['manage'.$lang]['article_6']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Article_6']);?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$website_language['manage'.$lang]['article_7']?>：</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Article_7']);?></td>
                            </tr>                                                  
                        </table>
                        <div style="color:#666666;margin-top:5px;margin-left:24%"><font style="color:red;">*</font><?=$website_language['manage'.$lang]['article_8']?></div>
                    </div>              
            </div>
        </div>
        <?php }else{?>
            <div class="content_right">
                <div class="top_title"><?=$Title; ?></div>
                <div class="content">
                    <?=$article_row['Contents'.$lang]; ?>
                    <div class="clear"></div>
                </div>
            </div>
        <?php }?>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>
<?php include("$site_root_path/inc/common/footer.php"); ?>
</body>
</html>
