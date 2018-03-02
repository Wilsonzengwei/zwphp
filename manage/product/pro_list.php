<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('product_binding');

$module=$_GET['module'];
$BId=$_GET['BId'];

//分页查询
$where=1;
$Name=$_GET['Name'];
$ItemNumber=$_GET['ItemNumber'];
$Model=$_GET['Model'];
$CateId=(int)$_GET['CateId'];
$ext_where=$_GET['ext_where'];
$OrderBy=(int)$_GET['OrderBy'];
($OrderBy<0 || count($order_by_ary)<=$OrderBy) && $OrderBy=0;

$Name && $where.=" and Name like '%$Name%'";
$ItemNumber && $where.=" and ItemNumber='$ItemNumber'";
$Model && $where.=" and Model='$Model'";
$CateId && $where.=' and '.get_search_where_by_CateId($CateId, 'product_category');
$ext_where && $where.=" and $ext_where";

$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/get_cfg('product.binding.pro_page_count'));
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*get_cfg('product.binding.pro_page_count');
$product_row=$db->get_limit('product', $where, '*', $order_by_ary[$OrderBy].'MyOrder desc, ProId desc', $start_row, get_cfg('product.binding.pro_page_count'));

//获取类别列表
$cate_ary=$db->get_all('product_category');
for($i=0; $i<count($cate_ary); $i++){
	$category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
}
$category_count=$db->get_row_count('product_category');
$select_category=ouput_Category_to_Select('CateId', '', 'product_category', 'UId="0,"', 1, get_lang('ly200.select'));

$pro_ary=array();
$binding_row=$db->get_all('product_binding', 1, 'ProId', 'BId desc');
for($i=0,$count=count($binding_row); $i<$count; $i++){
	$pro_ary[]=$binding_row[$i]['ProId'];
}

$bind_value=$db->get_one('product_binding', "BId='$BId'", 'AssociateProId,ProId');
$AssociateProId=$bind_value['AssociateProId'];
$proid=$bind_value['ProId'];
$AssociatePro_ary=explode('|',$proid.substr($AssociateProId,0,-1));
$BI_ary=array_merge($pro_ary,$AssociatePro_ary);

$query_string=query_string('page');
$all_query_string=query_string();

include('../../inc/manage/header.php');
?>
<div id="page_contents">
	<iframe id="pro_list_iframe" style="display:none;"></iframe>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bat_form">
        <tr>
            <td height="22" class="flh_150">
                <form method="get" name="product_search_form" action="pro_list.php" onsubmit="this.submit.disabled=true;" target="pro_list_iframe">
                    <?=get_lang('ly200.name');?>:<input name="Name" class="form_input" type="text" size="25" maxlength='100'>
                    <?php if(get_cfg('product.item_number')){?><?=get_lang('product.item_number');?>:<input name="ItemNumber" class="form_input" type="text" size="15" maxlength='50'><?php }?>
                    <?php if(get_cfg('product.model')){?><?=get_lang('product.model');?>:<input name="Model" class="form_input" type="text" size="15" maxlength='50'><?php }?>
                    <?php if($category_count>1){?><?=get_lang('ly200.category');?>:<?=str_replace('<select','<select class="form_select"',$select_category);?><?php }?>
                    <input type="submit" name="submit" value="<?=get_lang('ly200.search');?>" class="sm_form_button">
                    <input type="hidden" name="module" value="<?=$module;?>" />
                </form>
            </td>
        </tr>
    </table>
    <?php /*?><form method="get" class="turn_page_form" action="pro_list.php" onsubmit="javascript:turn_page(this);">
        <?=str_replace('<a', '<a target="pro_list_iframe"', turn_page($page, $total_pages, 'pro_list.php?module='.$module.'&page=', $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page')));?>
        <?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
        <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
        <input name="query_string" type="hidden" value="<?=$query_string;?>">
    </form><?php */?>
    <div class="blank"></div>
    <table id="mouse_trBgcolor_table" class="binding_products_list" cellspacing="1" cellpadding="0" border="0" width="100%" not_mouse_trbgcolor_tr="list_title">
    	<tr id="list_title" class="list_title" align="center">
        	<td width="8%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
        	<td width="110" nowrap><strong><?=get_lang('ly200.photo');?></strong></td>
        	<td width="62%" nowrap><strong><?=get_lang('product.binding.name');?></strong></td>
        	<td width="15%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
        </tr>
        <?php
		$str='|';
		for($i=0; $i<count($product_row); $i++){
			$ProId=$product_row[$i]['ProId'];
			$str.=$ProId.'|';
		?>
        <tr id="products_list_<?=$ProId;?>" class="binding_item">
        	<td align="center"><?=$start_row+$i+1;?></td>
        	<td class="img"><a class="img_a" target="_blank" href="<?=str_replace('s_','',$product_row[$i]['PicPath_0']);?>"><img src="<?=str_replace('s_','90X90_',$product_row[$i]['PicPath_0']);?>"></a></td>
            <td>
            	<ul>
                    <li><?=get_lang('ly200.name');?>: <?=list_all_lang_data($product_row[$i], 'Name');?></li>
                    <li>
					<?php
					$p_ary=get_cfg('product.price_list');
					for($j=0; $j<count($p_ary); $j++){
						echo get_lang('product.price_list.'.$p_ary[$j]).':'.get_lang('ly200.price_symbols').sprintf('%01.2f', $product_row[$i]['Price_'.$j]).'&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					if(get_cfg('product.special_offer')){
						echo get_lang('product.special_offer').':'.($product_row[$i]['IsSpecialOffer']?('<font class="fc_red">'.get_lang('ly200.price_symbols').sprintf('%01.2f', $product_row[$i]['SpecialOfferPrice']).'</font>'):get_lang('ly200.n_y_array.0'));
					}
					?>
					</li>
                    <li class="last"><?=get_lang('product.item_number');?>: <?=$product_row[$i]['ItemNumber'];?></li>
                </ul>
            </td>
            <td class="flh_150" align="center">
            	<?php if($module=='mod' || ($module=='add' && !in_array($ProId,$BI_ary))){?><a id="add_to_primary_link_<?=$ProId;?>" onclick="products_binding_products_add(this, <?=$ProId;?>, 0);" style="display:<?=in_array($ProId,$BI_ary)?'none':'block';?>;" href="javascript:void(0);">设为主产品</a><?php }?>
            	<a id="add_to_associate_link_<?=$ProId;?>" onclick="products_binding_products_add(this, <?=$ProId;?>, 1);" style="display:<?=($module=='mod' && in_array($ProId,$AssociatePro_ary))?'none':'block';?>;" href="javascript:void(0);">添加到关联</a>
            </td>
        </tr>
        <?php }?>
    </table>
    <div class="blank"></div>
    <form method="get" class="turn_page_form" action="pro_list.php" onsubmit="javascript:turn_page(this);">
        <?=str_replace('<a', '<a target="pro_list_iframe"', turn_bottom_page($page, $total_pages, 'pro_list.php?module='.$module.'&page=', $row_count, '〈', '〉'));?>
        <?php /*?><?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>"><?php */?>
        <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
        <input name="query_string" type="hidden" value="<?=$query_string;?>">
        <input type="hidden" name="module" value="<?=$module;?>" />
    </form>
</div>
<script language="javascript">
parent.$_('pro_list').innerHTML=$_('page_contents').innerHTML;

parent.$_('all_ProId').value='<?=$str;?>';
</script>
<?php include('../../inc/manage/footer.php');?>