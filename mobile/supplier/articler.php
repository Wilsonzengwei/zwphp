<?php 
include('../../inc/include.php'); 
$ProId = (int)$_GET['ProId'];
$ProId && $product_row = $db->get_one('product',"ProId='$ProId'");
$CateId = $product_row['CateId'];
$CateId && $category_row = $db->get_one('product_category',"CateId='$CateId'");
$product_description_row = $db->get_one('product_description',"ProId='$ProId'");
$goods_row=$db->get_all('product_wholesale_price', "ProId='$ProId'", '*', 'PId asc');
$shipping_row=$db->get_all('shipping_freight','SFID=1');
$shipping_row_2=$db->get_all('shipping_freight','SFID=2');
$supplier_row = $db->get_one('member',"MemberId='$SupplierId'"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php echo seo_meta($product_row['SeoTitle'],$product_row['SeoKeyword'],$product_row['SeoDescription']);?>
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/global.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/style.css">
	<link rel="stylesheet" href="<?=$mobile_url; ?>/css/lib.css">
	<link rel="stylesheet" type="text/css" href="../css/goods.css"/>
</head>
<body>
	<?php include($site_root_path.$mobile_url.'/inc/header.php'); ?>
	<style>
		.return{position: absolute;top:5%;left:0;width: 0.8rem;height: 0.8rem;background: url(../images/arr_left.png) no-repeat center center / 0.35rem 0.25rem;}
	</style>
		<div class="top_title">
			<a href="javascript:;" onclick="history.back();" class="return"></a>
			<?=$product_row['Name'.$lang]; ?>
		</div>
		<div style="width:94%;margin-top:7%;margin-left:3%;border:1px solid #ddd">
			<div style="width:100%;height:30px;text-indent:10px;border:1px solid #e6e6e6;line-height:30px"><?=$website_language['nav'.$lang]['contact_us']?></div>
			<div style="height:30px;font-weight:bold;text-indent:10px;border-bottom:2px solid #ddd;line-height:30px"><?=$ContactUs_language['Mer_Info'.$lang]['MerInfo_1']?></div>
			<div style="width:100%;height:1000px;font-size:0.2rem">
                    <div style="width:100%;margin-top:20px"> 
                        <table style="line-height:8px">
                            <tr>
                                <td style="text-align:right;color:#666666;"><?=$ContactUs_language['Mer_Info'.$lang]['Corporation']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333;line-height:15px;"><?=htmlspecialchars($supplier_row['Supplier_Name2']);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['address']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Address'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['city']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333;line-height:15px"><?=htmlspecialchars($supplier_row['Supplier_Myshi'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Country']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myguojia'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666;line-height:15px"><?=$ContactUs_language['Mer_Info'.$lang]['State_Province']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333;"><?=htmlspecialchars($supplier_row['Supplier_Myshenfen'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['PostalCode']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Myem'.$lang]);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666;line-height:15px"><?=$ContactUs_language['Mer_Info'.$lang]['PhoneNumber']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Phone']);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <!-- <tr>
                                <td style="text-align:right;color:#666666;line-height:15px"><?=$ContactUs_language['Mer_Info'.$lang]['Fax_number']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=$ContactUs_language['Mer_Info'.$lang]['Fax_numberTxt']?></td>
                            </tr> -->
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666"><?=$ContactUs_language['Mer_Info'.$lang]['Mobile_phone']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=htmlspecialchars($supplier_row['Supplier_Mobile']);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666;line-height:15px"><?=$ContactUs_language['Mer_Info'.$lang]['homepage']?></td>
                                <td>：&nbsp;</td>
                                <td onclick="window.location.href='http://<?=$supplier_row['ComWebSite'];?>/'" style="color:#0066cc;cursor:pointer;"><?=$supplier_row['ComWebSite'];?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="line-height:45px">
                                <td style="text-align:right;color:#666666;line-height:15px"><?=$ContactUs_language['Mer_Info'.$lang]['Other_home_address']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333"><?=$supplier_row['ComWebSite_1'];?></td>
                            </tr>
                        </table>
                    </div>
                    <br><br>
                    <div style="text-indent:10px;color:#333333;font-weight:bold"><?=$ContactUs_language['Mer_Info'.$lang]['primary_contact']?></div>
                    <hr style="border:1px solid #ccc">
                <div style="width:100%;height:90px;border-bottom:2px solid #ccc">
                    <div style="width:100%;height:30px;margin-top:5%;color:#666666;position:relative">                       
                        <span style="display:inline-block;margin-left:10px;color:#333;font-weight:bold;"><font style="font-weight: bolder;"><?=$website_language['form'.$lang]['first']?></font>：<?=htmlspecialchars($supplier_row['First_name']);?></span><br><br>
                        <span style="text-align:left;display:inline-block;margin-left:10px;font-weight:bold;"><font style="font-weight: bolder;"><?=$website_language['manage'.$lang]['article_3']?></font>：aaaaaaaaaaaaa<?=htmlspecialchars($supplier_row['Article_3']);?></span>                      
                    </div>
                    <div style="margin-top:30px;text-indent:10px;font-size:0.2rem;font-weight:bold"><?=$website_language['manage'.$lang]['article_4']?></div>
                </div>
                  <div style="width:100%;margin-top:20px;color:#666666"> 
                        <table style="line-height:8px">
                            <tr>
                                <td style="text-align:right;color:#666666;width:40%;line-height:12px"><?=$website_language['manage'.$lang]['article_5']?></td>
                                <td>：&nbsp;</td>
                                <td onclick="window.open('http://<?=$supplier_row['ComWebSite'];?>/','_self')" style="color:#0066cc;cursor:pointer;line-height:15px"><?=htmlspecialchars($supplier_row['Article_5']);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666;width:40%;line-height:12px"><?=$website_language['manage'.$lang]['article_6']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333;line-height:15px"><?=htmlspecialchars($supplier_row['Article_6']);?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:right;color:#666666;width:40%;line-height:12px"><?=$website_language['manage'.$lang]['article_7']?></td>
                                <td>：&nbsp;</td>
                                <td style="color:#333333;line-height:15px"><?=htmlspecialchars($supplier_row['Article_7']);?></td>
                            </tr>                                                  
                        </table>
                        <div>&nbsp;</div>
                        <div style="color:#666666;width:100%;margin-left:10px"><?=$website_language['manage'.$lang]['article_8']?></div>
                    </div> 
                </div>                
		</div>
		