<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_binding';
check_permit('product_binding');

if($_POST['action']=='del_binding'){
	check_permit('', 'product.binding.del');
	if(count($_POST['select_BId'])){
		$BId=implode(',', $_POST['select_BId']);
		$db->delete('product_binding', "BId in($BId)");
	}
	save_manage_log('删除产品捆绑');
	
	header('Location: binding.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('binding_header.php');?>
    <form name="list_form" id="list_form" class="list_form" method="post" action="binding.php">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgbinding_tr='list_form_title'>
        <tr align="center" class="list_form_title nosearch" id="list_form_title">
            <td width="5%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
            <?php if(get_cfg('product.binding.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <td width="40%" nowrap><strong><?=get_lang('product.binding.products_info');?></strong></td>
            <td width="8%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
            <?php if(get_cfg('product.binding.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        $binding_row=$db->get_all('product_binding', 1, '*', 'BId desc');
        for($i=0,$count=count($binding_row); $i<$count; $i++){
            $primary_products='';
            $ProId=$binding_row[$i]['ProId'];
            $AssociateProId=$binding_row[$i]['AssociateProId'];
            $where = substr($ProId.str_replace('|',',',$AssociateProId),0,-1);
            $pro_list=$db->get_limit('product',"ProId in($where)",'*','MyOrder desc, ProId asc');
            for($j=0,$len=count($pro_list); $j<$len; $j++){
                if($pro_list[$j]['ProId']==$ProId) $primary_products=$pro_list[$j];
            }
        ?>
        <tr align="center">
            <td nowrap><?=($i+1)?></td>
            <?php if(get_cfg('product.binding.del')){?><td><input name="select_BId[]" type="checkbox" value="<?=$binding_row[$i]['BId'];?>" /></td><?php }?>
            <td align="left">
                <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td class="img"><a href="<?=str_replace('s_','',$primary_products['PicPath_0']);?>" target="_blank"><img src="<?=str_replace('s_','90X90_',$primary_products['PicPath_0']);?>" /></a></td>
                        <td valign="top">
                            <ul>
                                <li><?=get_lang('ly200.name').':'.$primary_products['Name'];?></li>
                                <li>
                                    <?php
                                    $p_ary=get_cfg('product.price_list');
                                    for($j=0,$len=count($p_ary); $j<$len; $j++){
                                        echo get_lang('product.price_list.'.$p_ary[$j]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $primary_products['Price_'.$j]).'&nbsp;&nbsp;&nbsp;&nbsp;';
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
                <div class="binding_prolist">
                    <?php
                    for($j=0,$len=count($pro_list); $j<$len; $j++){
                        if($pro_list[$j]['ProId']==$ProId) continue;
                    ?>
                    <table class="binding_item" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="img"><a href="<?=str_replace('s_','',$pro_list[$j]['PicPath_0']);?>" target="_blank"><img src="<?=str_replace('s_','90X90_',$pro_list[$j]['PicPath_0']);?>" /></a></td>
                            <td valign="top">
                                <ul>
                                    <li><?=get_lang('ly200.name').':'.$pro_list[$j]['Name'];?></li>
                                    <li>
                                        <?php
                                        $p_ary=get_cfg('product.price_list');
                                        for($k=0,$length=count($p_ary); $k<$length; $k++){
                                            echo get_lang('product.price_list.'.$p_ary[$k]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $pro_list[$j]['Price_'.$k]).'&nbsp;&nbsp;&nbsp;&nbsp;';
                                        }
                                        if(get_cfg('product.special_offer')){
                                            echo get_lang('product.special_offer').':'.($pro_list[$j]['IsSpecialOffer']?('<font class="fc_red">'.get_lang('ly200.price_symbols').sprintf('%01.2f', $pro_list[$j]['SpecialOfferPrice']).'</font>'):get_lang('ly200.n_y_array.0'));
                                        }
                                        ?>
                                    </li>
                                    <li><?=get_lang('product.item_number').':'.$pro_list[$j]['ItemNumber'];?></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <?php }?>
                </div>
            </td>
            <td nowrap><?=date(get_lang('ly200.time_format_ymd'),$binding_row[$i]['AccTime']);?></td>
            <?php if(get_cfg('product.binding.mod')){?><td nowrap><a href="binding_mod.php?BId=<?=$binding_row[$i]['BId'];?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
        <?php if(get_cfg('product.binding.del') && count($binding_row)){?>
        <tr>
            <td colspan="5" class="bottom_act">
            	<div class="fl mgl20">
					<?php if(get_cfg('product.binding.del')){?>
                        <input name="button" type="button" class="list_button transition" onClick='change_all("select_BId[]");' value="<?=get_lang('ly200.anti_select');?>">
                        <input name="del_binding" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'list_form', 'action');};" value="<?=get_lang('ly200.del');?>">
                    <?php }?>
                    <input name="action" id="action" type="hidden" value="">
                </div>
            </td>
        </tr>
        <?php }?>
    </table>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>