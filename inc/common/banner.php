<?php $index_ad=$db->get_one('ad','AId =1');?>


<link rel="stylesheet" href="/css/common/banner.css">
<div style="overflow:hidden;">
<script type="text/javascript" src="/js/ad/jQuery.blockUI.js"></script>
<script type="text/javascript" src="/js/ad/jquery.SuperSlide.js"></script>
    <div id="slideBox" class="slideBox">
        <div class="hd">
            <ul>
                 <?php for($i=0;$i<5;$i++){
                    if(!is_file($site_root_path.$index_ad['PicPath_'.$i]))continue;
                ?>
                <li class="<?=$i==0?'on':''?>"></li>
                <?php }?>
            </ul>
        </div>
        <div class="bd">
            <div class="tempWrap">
                <ul>
                <?php for($i=0;$i<5;$i++){
                    if(!is_file($site_root_path.$index_ad['PicPath_'.$i]))continue;
                ?>
                <li><a href="javascript:;" target="_blank"><img src="<?=$index_ad['PicPath_'.$i]?>"></a></li>
                <?php }?>
                </ul>
            </div>
        </div>
    </div>
<script type="text/javascript">jQuery(document).ready(function(){jQuery(".slideBox").slide({mainCell:".bd ul",effect:"left",autoPlay:true,interTime:3000});});</script>
</div>