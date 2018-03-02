<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

check_permit('shipping', 'shipping.mod');

$SId=(int)$_GET['SId'];
$shipping_row=$db->get_one('shipping', "SId='$SId'");

include('../../inc/manage/header.php');
?>
<div class="header"><?=get_lang('ly200.current_location');?>:<a href="index.php"><?=get_lang('shipping.shipping_manage');?></a>&nbsp;-&gt;&nbsp;<a href="shipping_price.php?SId=<?=$SId;?>"><?=list_all_lang_data($shipping_row, 'Express');?></a>&nbsp;-&gt;&nbsp;<?=get_lang('shipping.set_shipping_price');?></div>
<div id="act_form" class="act_form">
	<table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='act_form_title'>
		<tr align="center" class="act_form_title" id="act_form_title">
			<td nowrap width="10%"><strong><?=get_lang('ly200.number');?></strong></td>
			<td nowrap width="25%"><strong><?=get_lang('country.country');?></strong></td>
			<td nowrap width="20%"><strong><?=get_lang('shipping.first_price');?></strong></td>
			<?php if(get_cfg('shipping.s_price_by_weight')){?>
				<td nowrap width="20%"><strong><?=get_lang('shipping.first_weight');?></strong></td>
				<td nowrap width="25%"><strong><?=get_lang('shipping.ext_weight');?></strong></td>
			<?php }?>
		</tr>
		<?php
		$i=1;
		$country_rs=$db->query("select country.*,PId,FirstPrice,FirstWeight,ExtWeight,ExtPrice from country left join shipping_price on shipping_price.CId=country.CId and shipping_price.SId='$SId' order by country.Country asc, country.CId asc");
		while($country_row=mysql_fetch_assoc($country_rs)){
		?>
		<tr align="center">
			<td height="24"><?=$i++;?></td>
			<td nowrap><?=list_all_lang_data($country_row, 'Country');?></td>
			<td><?=get_lang('ly200.price_symbols');?><span class="quick_update" rel="group_0"><span class="id"><?=$country_row['PId'];?></span><span class="value"><?=$country_row['FirstPrice'];?></span></span></td>
			<?php if(get_cfg('shipping.s_price_by_weight')){?>
				<td><span class="quick_update" rel="group_1"><span class="id"><?=$country_row['PId'];?></span><span class="value"><?=$country_row['FirstWeight'];?></span></span> KG</td>
				<td nowrap><span class="quick_update" rel="group_2"><span class="id"><?=$country_row['PId'];?></span><span class="value"><?=$country_row['ExtWeight'];?></span></span> KG<font class="fc_red"> / </font><?=get_lang('ly200.price_symbols');?><span class="quick_update" rel="group_3"><span class="id"><?=$country_row['PId'];?></span><span class="value"><?=$country_row['ExtPrice'];?></span></span></td>
			<?php }?>
		</tr>
		<?php }?>
	</table>
</div>
<script language="javascript">
//input or textarea, 字段名称（字段类型[float或int或text]），size，maxlength，数据表名，数据表自动递增字段名，权限检查模块
quick_update_data_init('input|FirstPrice,float|5|10|shipping_price|PId|shipping', 'group_0');
quick_update_data_init('input|FirstWeight,float|5|10|shipping_price|PId|shipping', 'group_1');
quick_update_data_init('input|ExtWeight,float|5|10|shipping_price|PId|shipping', 'group_2');
quick_update_data_init('input|ExtPrice,float|5|10|shipping_price|PId|shipping', 'group_3');
</script>
<?php include('../../inc/manage/footer.php');?>