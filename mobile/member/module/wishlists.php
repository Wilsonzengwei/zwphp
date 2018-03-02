<?php
$query_string=query_string('page');

if($_GET['act']=='remove'){
	$ProId=(int)$_GET['ProId'];
	$db->delete('wish_lists', "$where and ProId='$ProId'");
	js_location("$mobile_url$member_url?".query_string(array('act', 'ProId')));
}

if($_GET['act']=='add' || $_POST['act']=='add'){
	$ProId=(int)$_GET['ProId'];
	!$ProId && $ProId=(int)$_POST['ProId'];
	if($db->get_row_count('product', "ProId='$ProId'") && !$db->get_row_count('wish_lists', "$where and ProId='$ProId'")){
		$db->insert('wish_lists', array(
				'MemberId'	=>	(int)$_SESSION['member_MemberId'],
				'ProId'		=>	$ProId,
				'WishTime'	=>	$service_time
			)
		);
	}
	js_location("$mobile_url$member_url?module=wishlists");
}

$where="ProId in(select ProId from wish_lists where $where)";
$page_count=20;
$row_count=$db->get_row_count('product', $where);
$total_pages=ceil($row_count/$page_count);
$page=(int)$_GET['page'];
$page<1 && $page=1;
$page>$total_pages && $page=1;
$start_row=($page-1)*$page_count;
$list_row=$db->get_limit('product', $where, '*', 'ProId desc', $start_row, $page_count);
?>
<div id="lib_member_wishlists">
	<div class="lib_member_title"><?=$website_language['member'.$lang]['wishlists']['title']; ?></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="item_list">
		<tr class="tb_title">
			<td width=""><?=$website_language['member'.$lang]['wishlists']['img']; ?></td>
			<td width=""><?=$website_language['member'.$lang]['wishlists']['name']; ?></td>
			<td width="15%" class="last"><?=$website_language['member'.$lang]['wishlists']['edit']; ?></td>
		</tr>
		<?php
		for($i=0; $i<count($list_row); $i++){
			$url=$mobile_url.get_url('product', $list_row[$i]);
		?>
		<tr class="item_list item_list_out" onmouseover="this.className='item_list item_list_over';" onmouseout="this.className='item_list item_list_out';" align="center">
			<td valign="top"><table width="94" border="0" cellpadding="0" cellspacing="0" align="center"><tr><td height="94" align="center" class="item_img"><a href="<?=$url;?>" target="_blank"><img src="<?=$list_row[$i]['PicPath_0'];?>" /></a></td></tr></table></td>
			<td align="left">
				<a href="<?=$url;?>" target="_blank" class="proname"><?=$list_row[$i]['Name'.$lang];?></a><br /><br />
			</td>
			<td><a href="<?=$mobile_url.$member_url.'?'.query_string();?>&act=remove&ProId=<?=$list_row[$i]['ProId'];?>" class="proname"><?=$website_language['member'.$lang]['wishlists']['del']; ?></a></td>
		</tr>
		<?php }?>
		<?php if(!count($list_row)){?>
		<tr class="item_list">
			<td align="center" height="150" colspan="4" bgcolor="#ffffff"><?=$website_language['member'.$lang]['wishlists']['empty']; ?></td>
		</tr>
		<?php }?>
	</table>
    <div id="turn_page"><?=turn_page_html($row_count, $page, $total_pages, "?$query_string&page=", 'Previous', 'Next');?></div>
</div>