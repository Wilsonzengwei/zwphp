<!-- <div class="copyright">
    <div class="global">
        <div class="pay">
            <img src="/images/pay.png" alt="pay">
        </div>
        <?php
        $link_where = 'Language=0'; 
        $lang && $link_where = 'Language=1';
        $foot_links_row = $db->get_limit('links',$link_where,'*','MyOrder desc,LId asc',0,5); 
        foreach((array)$foot_links_row as $k => $v){ ?>
            <a href="<?=$v['Url']; ?>" rel="nofollow" class="list" target="_blank" title="<?=$v['Name']; ?>"><?=$v['Name']; ?></a> 
            <?php if($k<count($foot_links_row)-1){ ?>
                <em class="bor"></em>
            <?php } ?>
        <?php } ?>
        <br />
        <?=$mCfg['CopyRight']; ?> &nbsp;&nbsp;&nbsp;&nbsp; 
        <a href="http://www.ueeshop.com" class="list" target="_blank" style="font-size: 12px;">Powered by UEESHOP</a>
        <?=$mCfg['JsCode']; ?> 
    </div>
</div>
<?php //include("{$site_root_path}/inc/lib/online.php"); ?> -->