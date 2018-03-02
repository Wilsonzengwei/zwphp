<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_binding';
check_permit('product_binding', 'product.binding.mod');

if($_POST['do_action']=='products_binding_mod'){
	$BId=(int)$_POST['BId'];	
	$ProId=(int)$_POST['ProId'];
	$AssociateProId=$_POST['AssociateProId'];
	
	$db->update('product_binding', "BId='$BId'", array(
			'ProId'				=>	$ProId,
			'AssociateProId'	=>	$AssociateProId,
			'AccTime'			=>	$service_time
		)
	);
	
	save_manage_log('更新产品捆绑');
	
	header('Location: binding.php');
	exit;
}

$BId=(int)$_GET['BId'];
$binding_row=$db->get_one('product_binding', "BId='$BId'");

$primary_products='';
$ProId=$binding_row['ProId'];
$AssociateProId=$binding_row['AssociateProId'];
$where = substr($ProId.str_replace('|',',',$AssociateProId),0,-1);
$pro_list=$db->get_limit('product',"ProId in($where)",'*','MyOrder desc, ProId asc');
for($i=0,$len=count($pro_list); $i<$len; $i++){
	if($pro_list[$i]['ProId']==$ProId) $primary_products=$pro_list[$i];
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <?php include('binding_header.php');?>
    <table id="bing_form" class="bing_form" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="45%" valign="top">
            <form method="post" name="act_form" id="act_form" class="act_form" action="binding_mod.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
            <div>
                <input class="form_button" type="submit" name="submit" value="<?=get_lang('ly200.mod');?>">
                <a class="return" href="binding.php"><?=get_lang('ly200.return');?></a>
            </div>
            <div class="blank"></div>
            <div class="binding_t"><strong><?=get_lang('product.binding.primary_products');?></strong></div>
            <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="img"><div id="binding_item_primary_img" class="c"><a class="img_a" href="<?=str_replace('s_','',$primary_products['PicPath_0']);?>" target="_blank"><img src="<?=str_replace('s_','90X90_',$primary_products['PicPath_0']);?>" /></a><div class="del"><a onclick="products_binding_products_del(this, <?=$ProId;?>, 0);" href="javascript:void(0);"><?=get_lang('ly200.del');?></a></div></div></td>
                    <td id="binding_item_primary_info" valign="top">
                        <ul>
                            <li><?=get_lang('ly200.name').':'.$primary_products['Name'];?></li>
                            <li>
                                <?php
                                $p_ary=get_cfg('product.price_list');
                                for($i=0,$len=count($p_ary); $i<$len; $i++){
                                    echo get_lang('product.price_list.'.$p_ary[$i]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $primary_products['Price_'.$i]).'&nbsp;&nbsp;&nbsp;&nbsp;';
                                }
                                if(get_cfg('product.special_offer')){
                                    echo get_lang('product.special_offer').':'.($primary_products['IsSpecialOffer']?('<font class="fc_red">'.get_lang('ly200.price_symbols').sprintf('%01.2f', $primary_products['SpecialOfferPrice']).'</font>'):get_lang('ly200.n_y_array.0'));
                                }
                                ?>
                            </li>
                            <li><?=get_lang('product.item_number').':'.$primary_products['ItemNumber'];?></li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <div class="binding_t"><strong><?=get_lang('product.binding.associate_products');?></strong></div>
            <?php
            $count=count($pro_list);
            $as_ProId='|';
            $xx=0;
            for($i=0; $i<$count; $i++){
                if($pro_list[$i]['ProId']==$ProId) continue;
                $as_ProId.=$pro_list[$i]['ProId'].'|';
            ?>
            <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="img"><div id="binding_item_associate_img_<?=$xx;?>" class="c"><a class="img_a" href="<?=str_replace('s_','',$pro_list[$i]['PicPath_0']);?>" target="_blank"><img src="<?=str_replace('s_','90X90_',$pro_list[$i]['PicPath_0']);?>" /></a><div class="del"><a onclick="products_binding_products_del(this, <?=$pro_list[$i]['ProId'];?>, 1);" href="javascript:void(0);"><?=get_lang('ly200.del');?></a></div></div></td>
                    <td id="binding_item_associate_info_<?=$xx;?>" valign="top">
                        <ul>
                            <li><?=get_lang('ly200.name').':'.$pro_list[$i]['Name'];?></li>
                            <li>
                                <?php
                                $p_ary=get_cfg('product.price_list');
                                for($j=0,$len=count($p_ary); $j<$len; $j++){
                                    echo get_lang('product.price_list.'.$p_ary[$j]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $pro_list[$i]['Price_'.$j]).'&nbsp;&nbsp;&nbsp;&nbsp;';
                                }
                                if(get_cfg('product.special_offer')){
                                    echo get_lang('product.special_offer').':'.($pro_list[$i]['IsSpecialOffer']?('<font class="fc_red">'.get_lang('ly200.price_symbols').sprintf('%01.2f', $pro_list[$i]['SpecialOfferPrice']).'</font>'):get_lang('ly200.n_y_array.0'));
                                }
                                ?>
                            </li>
                            <li><?=get_lang('product.item_number').':'.$pro_list[$i]['ItemNumber'];?></li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <?php
                $xx+=1;
            }
            $bind_count=get_cfg('product.binding.bind_count')+1;
            if($count<$bind_count) $pp=$bind_count-$count;
            if($pp>0){
            for($i=0; $i<$pp; $i++){
                $k=$i+($count-1);
            ?>
            <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="img"><div id="binding_item_associate_img_<?=$k;?>" class="c"><div class="t"><?=get_lang('product.binding.select_products');?></div></div></td>
                    <td id="binding_item_associate_info_<?=$k;?>" valign="top">
                        <ul>
                            <li><?=get_lang('ly200.name');?>:</li>
                            <li><?=get_lang('product.price');?>:</li>
                            <li><?=get_lang('product.item_number');?>:</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <br />
            <?php } }?>
            <input type="hidden" name="BId" value="<?=$BId;?>" />
            <input id="ProId" type="hidden" check="<?=get_lang('ly200.filled_out').get_lang('product.binding.primary_products');?>!~*" value="<?=$ProId;?>" name="ProId">
            <input id="AssociateProId" type="hidden" check="<?=get_lang('ly200.filled_out').get_lang('product.binding.associate_products');?>!~*" value="<?=$as_ProId;?>" name="AssociateProId">
            <input id="all_ProId" type="hidden" value="" name="all_ProId">
            <input type="hidden" value="products_binding_mod" name="do_action">
            <input id="binding_item_count" type="hidden" value="<?=get_cfg('product.binding.bind_count');?>" name="binding_item_count">
            </form>
        </td>
        <td width="55%" valign="top">
            <div id="pro_list"></div>
            <iframe src="pro_list.php?module=mod&BId=<?=$BId;?>" name="pro_list_iframe" style="display:none;"></iframe>
        </td>
      </tr>
    </table>
</div>
<?php include('../../inc/manage/footer.php');?>