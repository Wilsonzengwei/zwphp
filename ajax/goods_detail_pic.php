<?php
include('../inc/include.php');
$ProId = (int)$_GET['ProId'];
$ColorId = (int)$_GET['ColorId'];
$product_row=$db->get_one('colorimg', "ProId='$ProId' and PkeyId='$ColorId' and PicPath_0!=''");
if(!$product_row || !is_file($site_root_path.$product_row['PicPath_0'])) $product_row=$db->get_one('product', "ProId='$ProId'");

?>
<div class="detail_pic">
    <div class="up pic_shell">
        <div class="big_box">
            <div class="magnify" data="{}">
                <a class="big_pic" href="<?=str_replace('s_','',$product_row['PicPath_0'])?>"><img class="normal" src="<?=str_replace('s_','460X460_',$product_row['PicPath_0'])?>"></a>
            </div>
        </div>
    </div>
    <div class="down">
        <div class="small_carousel horizontal">
            <div class="viewport" data="{"small":"82x82","normal":"460x460","large":"v"}">
                <ul class="list">
                    <?php
                        for($i=0,$len=5; $i<$len; $i++){
                        if(!is_file($site_root_path.$product_row['PicPath_'.$i])) continue;
                    ?>
                    <li class="item FontBgColor" pos="<?=$i+1?>"><a href="javascript:void(0);" class="pic_box FontBorderHoverColor" alt="" title="" hidefocus="true"><img width="100%" src="<?=str_replace('s_','',$product_row['PicPath_'.$i])?>" id="BigPic" title="" alt="" normal="<?=str_replace('s_','460X460_',$product_row['PicPath_'.$i])?>" mask="<?=str_replace('s_','',$product_row['PicPath_'.$i])?>"><span></span></a><em class="arrow FontPicArrowColor"></em></li>
                    <?php }?>
                </ul>
            </div>
            <a href="javascript:void(0);" hidefocus="true" class="btn left prev"><span class="icon_left_arraw icon_arraw"></span></a>
            <a href="javascript:void(0);" hidefocus="true" class="btn right next"><span class="icon_right_arraw icon_arraw"></span></a>
        </div>
    </div>
</div>
<div class="prod_info_share"><div class="addthis_sharing_toolbox"></div><b>Share this:</b></div>