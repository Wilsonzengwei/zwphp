<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
include('../../inc/fun/ip_to_area.php');
$page_cur='member';
check_permit('member');

if($_POST['data']=='mod_password'){
	check_permit('', 'member.mod');
	$MemberId=(int)$_POST['MemberId'];
	
	$db->update('member', "MemberId='$MemberId'", array(
			'Password '	=>	password($_POST['NewPassword'])
		)
	);
	
	save_manage_log('修改注册用户密码');
	js_location("view.php?MemberId=$MemberId");
}


if($_POST['data']=='mod_info'){ //修改会员
	check_permit('', 'member.mod');
	$MemberId=(int)$_POST['MemberId'];
	$db->update('member', "MemberId='$MemberId'", array(
			'MemberLevel'	=>	$_POST['MemberLevel'],
            'Integral'      =>  (int)$_POST['Integral'],
			'MemberMoney'	=>	(int)$_POST['MemberMoney'],
		)
	);
	
	save_manage_log('修改注册用户');
	js_location("view.php?MemberId=$MemberId");
}




$MemberId=(int)$_GET['MemberId'];
$detail_card=(int)$_GET['detail_card'];
$where="MemberId='$MemberId'";
$query_string=query_string(array('detail_card', 'page'));

$member_row=$db->get_one('member', $where);

if($detail_card==0){
	$reg_ip_area=ip_to_area($member_row['RegIp']);
	$last_login_ip_area=ip_to_area($member_row['LastLoginIp']);
}elseif($detail_card==1){
	$shipping_address=$db->get_all('member_address_book', "$where and AddressType=0", '*', 'IsDefault desc, AId desc');
	$billing_address=$db->get_one('member_address_book', "$where and AddressType=1");
}elseif($detail_card==2){
	$row_count=$db->get_row_count('product', "ProId in(select ProId from wish_lists where $where)");
}elseif($detail_card==3){
	$row_count=$db->get_row_count('shopping_cart', $where);
}elseif($detail_card==4){
	check_permit('orders');
	$row_count=$db->get_row_count('orders', $where);
}elseif($detail_card==5){
	$row_count=$db->get_row_count('member_login_log', $where);
}

if($detail_card==2 || $detail_card==3 || $detail_card==4 || $detail_card==5){
	$page_count=20;
	$total_pages=ceil($row_count/$page_count);
	$page=(int)$_GET['page'];
	$page<1 && $page=1;
	$page>$total_pages && $page=1;
	$start_row=($page-1)*$page_count;
}

if($detail_card==2){
	$list_row=$db->get_limit('product', "ProId in(select ProId from wish_lists where $where)", '*', 'ProId desc', $start_row, $page_count);
}elseif($detail_card==3){
	$list_row=$db->get_limit('shopping_cart', $where, '*', 'CId desc', $start_row, $page_count);
}elseif($detail_card==4){
	$list_row=$db->get_limit('orders', $where, '*', 'OrderId desc', $start_row, $page_count);
}elseif($detail_card==5){
	$list_row=$db->get_limit('member_login_log', $where, '*', 'LId desc', $start_row, $page_count);
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
    <?php include('member_header.php');?>
    <div class="member_con">
        <div class="act_menu">
            <div class="card_list">
                <div class="<?=$detail_card==0?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=0" class="transition"><?=get_lang('member.base_info');?></a></div>
                <?php /*<div class="<?=$detail_card==1?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=1" class="transition"><?=get_lang('member.address_info');?></a></div>*/ ?>
                <div class="<?=$detail_card==2?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=2" class="transition"><?=get_lang('member.wish_lists');?></a></div>
                <?php /*<div class="<?=$detail_card==3?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=3" class="transition"><?=get_lang('member.shopping_cart');?></a></div>*/ ?>
                <?php if($menu['orders']){?><div class="<?=$detail_card==4?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=4" class="transition"><?=get_lang('member.order_info');?></a></div><?php }?>
                <div class="<?=$detail_card==5?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=5" class="transition"><?=get_lang('member.login_info');?></a></div>
                <?php if(get_cfg('member.mod')){?><div class="<?=$detail_card==6?'cur':'';?>"><a href="view.php?<?=$query_string;?>&detail_card=6" class="transition"><?=get_lang('member.mod_password');?></a></div><?php }?>
            </div>
        </div>
		<?php if($detail_card==0){?>
            <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<?php /*?>                <div class="table">
                    <div class="tr">
                        <div class="tr_title"><?=get_lang('ly200.view').get_lang('member.base_info');?></div>
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.title');?>:</font>
                            <span class="fl"><?=htmlspecialchars($member_row['Title']);?></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.full_name');?>:</font>
                            <span class="fl"><?=htmlspecialchars($member_row['FirstName'].' '.$member_row['LastName']);?></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('ly200.email');?>:</font>
                            <span class="fl">
                                <?=htmlspecialchars($member_row['Email']);?><?php if($menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($member_row['Email'].'/'.$member_row['FirstName'].' '.$member_row['LastName']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.reg_time');?>:</font>
                            <span class="fl">
                                <?=date(get_lang('ly200.time_format_full'), $member_row['RegTime']);?>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.reg_ip');?>:</font>
                            <span class="fl">
                                <?=htmlspecialchars($member_row['RegIp']);?> [<?=$reg_ip_area['country'].$reg_ip_area['area'];?>]
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.last_login_time');?>:</font>
                            <span class="fl">
                                <?=htmlspecialchars($member_row['RegIp']);?> [<?=$reg_ip_area['country'].$reg_ip_area['area'];?>]
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.reg_time');?>:</font>
                            <span class="fl">
                                <?=date(get_lang('ly200.time_format_full'), $member_row['RegTime']);?>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.reg_ip');?>:</font>
                            <span class="fl">
                                <?=htmlspecialchars($member_row['RegIp']);?> [<?=$reg_ip_area['country'].$reg_ip_area['area'];?>]
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.last_login_time');?>:</font>
                            <span class="fl">
                                <?=date(get_lang('ly200.time_format_full'), $member_row['LastLoginTime']);?>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.last_login_ip');?>:</font>
                            <span class="fl">
                               <?=htmlspecialchars($member_row['LastLoginIp']);?> [<?=$last_login_ip_area['country'].$last_login_ip_area['area'];?>]
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.consumption_price');?>:</font>
                            <span class="fl">
                               <?=get_lang('ly200.price_symbols').sprintf('%01.2f', $db->get_sum('orders', "OrderStatus in(5, 6) and MemberId='$MemberId'", 'TotalPrice'));?><?php if($menu['orders']){?>&nbsp;&nbsp;&nbsp;<a href="view.php?<?=$query_string;?>&detail_card=4" class="red"><?=get_lang('member.order_info');?></a><?php }?>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="tr last">
                        <div class="form_row">
                            <font class="fl"><?=get_lang('member.login_times');?>:</font>
                            <span class="fl">
                               <?=$member_row['LoginTimes'];?>&nbsp;&nbsp;&nbsp;<a href="view.php?<?=$query_string;?>&detail_card=5" class="red"><?=get_lang('member.login_info');?></a>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div><?php */?>
                <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
                    <tr> 
                        <td width="5%" nowrap><?=get_lang('member.title');?>:</td>
                        <td width="95%"><?=htmlspecialchars($member_row['Title']);?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('ly200.full_name');?>:</td>
                        <td><?=htmlspecialchars($member_row['FirstName'].' '.$member_row['LastName']);?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('ly200.email');?>:</td>
                        <td><?=htmlspecialchars($member_row['Email']);?><?php if($menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($member_row['Email'].'/'.$member_row['FirstName'].' '.$member_row['LastName']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.reg_time');?>:</td>
                        <td><?=date(get_lang('ly200.time_format_full'), $member_row['RegTime']);?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.reg_ip');?>:</td>
                        <td><?=htmlspecialchars($member_row['RegIp']);?> [<?=$reg_ip_area['country'].$reg_ip_area['area'];?>]</td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.last_login_time');?>:</td>
                        <td><?=date(get_lang('ly200.time_format_full'), $member_row['LastLoginTime']);?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.last_login_ip');?>:</td>
                        <td><?=htmlspecialchars($member_row['LastLoginIp']);?> [<?=$last_login_ip_area['country'].$last_login_ip_area['area'];?>]</td>
                    </tr>
                    <tr>
                        <td nowrap>等级:</td>
                        <td>
                            <select name="MemberLevel" class="form_select">
								<?php
                                $level_row=$db->get_all('member_level', 1, '*', 'UpgradePrice asc');
                                for($i=0,$count=count($level_row); $i<$count; $i++){
                                ?>
                                <option value="<?=$level_row[$i]['LId'];?>" <?=$member_row['MemberLevel']==$level_row[$i]['LId']?'selected':'';?>><?=$level_row[$i]['Level'];?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>积分:</td>
                        <td><input name="Integral" type="text" value="<?=htmlspecialchars($member_row['Integral']);?>" class="form_input" size="10" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td nowrap>货币:</td>
                        <td><input name="MemberMoney" type="text" value="<?=htmlspecialchars($member_row['MemberMoney']);?>" class="form_input" size="10" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.consumption_price');?>:</td>
                        <td><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $db->get_sum('orders', "OrderStatus in(5, 6) and MemberId='$MemberId'", 'TotalPrice'));?><?php if($menu['orders']){?>&nbsp;&nbsp;&nbsp;<a href="view.php?<?=$query_string;?>&detail_card=4" class="red"><?=get_lang('member.order_info');?></a><?php }?></td>
                    </tr>
                    <tr>
                        <td nowrap><?=get_lang('member.login_times');?>:</td>
                        <td><?=$member_row['LoginTimes'];?>&nbsp;&nbsp;&nbsp;<a href="view.php?<?=$query_string;?>&detail_card=5" class="red"><?=get_lang('member.login_info');?></a></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="Submit" name="submit" value="<?=get_lang('ly200.mod');?>" class="form_button"><input type="hidden" name="MemberId" value="<?=$MemberId;?>" /><input type="hidden" name="data" value="mod_info" /></td>
                    </tr>
                </table>
            </form>
        <?php }elseif($detail_card==1){?>
            <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                <table width="100%" border="0" cellpadding="0" cellspacing="1">
                    <tr align="center" class="act_form_title">
                        <td width="50%" nowrap><strong><?=get_lang('member.shipping_address');?></strong></td>
                        <td width="50%" nowrap><strong><?=get_lang('member.billing_address');?></strong></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:0;">
                            <?php for($i=0; $i<count($shipping_address); $i++){?>
                                <div class="address_info">
                                    <strong><?=htmlspecialchars($shipping_address[$i]['Title'].' '.$shipping_address[$i]['FirstName'].' '.$shipping_address[$i]['LastName']);?></strong><br />
                                    <?=htmlspecialchars($shipping_address[$i]['AddressLine1']);?><br />
                                    <?=htmlspecialchars($shipping_address[$i]['City']);?><br />
                                    <?=htmlspecialchars($shipping_address[$i]['State']);?> (Postal Code: <strong><?=htmlspecialchars($shipping_address[$i]['PostalCode']);?></strong>)<br />
                                    <?=htmlspecialchars($shipping_address[$i]['Country']);?><br />
                                    <strong>Phone: </strong><?=htmlspecialchars($shipping_address[$i]['Phone']);?>
                                </div>
                            <?php }?>
                        </td>
                        <td valign="top" style="padding:0;">
                            <div class="address_info">
                                <strong><?=htmlspecialchars($billing_address['Title'].' '.$billing_address['FirstName'].' '.$billing_address['LastName']);?></strong><br />
                                <?=htmlspecialchars($billing_address['AddressLine1']);?><br />
                                <?=htmlspecialchars($billing_address['City']);?><br />
                                <?=htmlspecialchars($billing_address['State']);?> (Postal Code: <strong><?=htmlspecialchars($billing_address['PostalCode']);?></strong>)<br />
                                <?=htmlspecialchars($billing_address['Country']);?><br />
                                <strong>Phone: </strong><?=htmlspecialchars($billing_address['Phone']);?>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        <?php }elseif($detail_card==2){?>
            <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
                    <tr align="center" class="list_form_title">
                        <td width="10%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
                        <td width="16%" nowrap><strong><?=get_lang('ly200.photo');?></strong></td>
                        <td width="16%" nowrap><strong><?=get_lang('product.item_number');?></strong></td>
                        <td width="43%" nowrap><strong><?=get_lang('ly200.name');?></strong></td>
                        <td width="15%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
                    </tr>
                    <?php
                    for($i=0; $i<count($list_row); $i++){
                        $url=sprintf($product_url_ary[$product_url_type], $list_row[$i][$product_url_var_ary[$product_url_type]]);
                    ?>
                    <tr align="center">
                        <td nowrap><?=$start_row+$i+1;?></td>
                        <td nowrap><a href="<?=$url;?>" target="_blank"><img src="<?=str_replace('s_', '90X90_', $list_row[$i]['PicPath_0']);?>" /></a></td>
                        <td nowrap><a href="<?=$url;?>" target="_blank"><?=$list_row[$i]['ItemNumber'];?></a></td>
                        <td nowrap><a href="<?=$url;?>" target="_blank"><?=$list_row[$i]['Name'];?></a></td>
                        <td nowrap><?=date(get_lang('ly200.time_format_full'), $db->get_value('wish_lists', $where, 'WishTime'));?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="5" class="bottom_act">
                            <div class="fl mgl20">
                                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
                            </div>
                            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "view.php?total_pages=$total_pages&detail_card=$detail_card&MemberId=$MemberId&page=", $row_count, '〈', '〉');?></div>
                            <div class="clear"></div>  
                        </td>
                    </tr>
                </table>
            </form>
            <?php /*?><form method="get" class="turn_page_form" action="view.php" onsubmit="javascript:turn_page(this);">
                <?=turn_page($page, $total_pages, "view.php?$query_string&detail_card=$detail_card&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
                <?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
            </form><?php */?>
        <?php }elseif($detail_card==3){?>
            <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table">
                    <tr align="center" class="list_form_title">
                        <td width="8%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
                        <td width="10%" nowrap><strong><?=get_lang('ly200.photo');?></strong></td>
                        <td width="12%" nowrap><strong><?=get_lang('product.item_number');?></strong></td>
                        <td width="42%" nowrap><strong><?=get_lang('ly200.name');?></strong></td>
                        <td width="8%" nowrap><strong><?=get_lang('product.price');?></strong></td>
                        <td width="8%" nowrap><strong><?=get_lang('ly200.qty');?></strong></td>
                        <td width="12%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
                    </tr>
                    <?php for($i=0; $i<count($list_row); $i++){?>
                    <tr align="center">
                        <td nowrap><?=$start_row+$i+1;?></td>
                        <td nowrap><a href="<?=$list_row[$i]['Url'];?>" target="_blank"><img src="<?=$list_row[$i]['PicPath'];?>" /></a></td>
                        <td nowrap><a href="<?=$list_row[$i]['Url'];?>" target="_blank"><?=$list_row[$i]['ItemNumber'];?></a></td>
                        <td nowrap align="left" class="flh_150">
                            <a href="<?=$list_row[$i]['Url'];?>" target="_blank"><?=$list_row[$i]['Name'];?></a><br />
                            <?php if($order_product_weight==1){?><?=get_lang('product.weight');?>: <?=$list_row[$i]['Weight'];?> KG<br /><?php }?>
                            <?php if($list_row[$i]['Color']){?><?=get_lang('product.color');?>: <?=$list_row[$i]['Color'];?><br /><?php }?>
                            <?php if($list_row[$i]['Size']){?><?=get_lang('product.size');?>: <?=$list_row[$i]['Size'];?><br /><?php }?>
                        </td>
                        <td nowrap><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $list_row[$i]['Price']);?></td>
                        <td nowrap><?=$list_row[$i]['Qty'];?></td>
                        <td nowrap><?=date(get_lang('ly200.time_format_full'), $list_row[$i]['AddTime']);?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="7" class="bottom_act">
                            <div class="fl mgl20">
                                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
                            </div>
                            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "view.php?total_pages=$total_pages&detail_card=$detail_card&MemberId=$MemberId&page=", $row_count, '〈', '〉');?></div>
                            <div class="clear"></div>  
                        </td>
                    </tr>
                </table>
            </form>
            <?php /*?><form method="get" class="turn_page_form" action="view.php" onsubmit="javascript:turn_page(this);">
                <?=turn_page($page, $total_pages, "view.php?$query_string&detail_card=$detail_card&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
                <?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
            </form><?php */?>
        <?php }elseif($detail_card==4){?>
            <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
                    <tr align="center" class="list_form_title">
                        <td width="6%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
                        <td width="14%" nowrap><strong><?=get_lang('orders.order_number');?></strong></td>
                        <td width="10%" nowrap><strong><?=get_lang('orders.item_costs');?></strong></td>
                        <td width="12%" nowrap><strong><?=get_lang('orders.shipping_charges');?></strong></td>
                        <td width="7%" nowrap><strong><?=get_lang('payment_method.additional_fee');?></strong></td>
                        <td width="10%" nowrap><strong><?=get_lang('orders.grand_total');?></strong></td>
                        <td width="13%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
                        <td width="18%" nowrap><strong><?=get_lang('orders.order_status');?></strong></td>
                        <td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
                    </tr>
                    <?php for($i=0; $i<count($list_row); $i++){?>
                    <tr align="center">
                        <td nowrap><?=$start_row+$i+1;?></td>
                        <td nowrap><?=$list_row[$i]['OId'];?></td>
                        <td nowrap><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $list_row[$i]['TotalPrice']);?></td>
                        <td nowrap><?=get_lang('ly200.price_symbols').sprintf('%01.2f', $list_row[$i]['ShippingPrice']);?></td>
                        <td nowrap><?=$list_row[$i]['PayAdditionalFee'];?>%</td>
                        <td nowrap><?=get_lang('ly200.price_symbols').sprintf('%01.2f', ($list_row[$i]['TotalPrice']+$list_row[$i]['ShippingPrice'])*($list_row[$i]['PayAdditionalFee']/100+1));?></td>
                        <td nowrap><?=date(get_lang('ly200.time_format_full'), $list_row[$i]['OrderTime']);?></td>
                        <td nowrap><?=$order_status_ary[$list_row[$i]['OrderStatus']];?></td>
                        <td><a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_orders', '<?=get_lang('orders.orders_manage');?>', 'orders/view.php?OrderId=<?=$list_row[$i]['OrderId'];?>');"><img src="../images/view.gif" alt="<?=get_lang('ly200.view');?>" /></a></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="9" class="bottom_act">
                            <div class="fl mgl20">
                                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
                            </div>
                            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "view.php?total_pages=$total_pages&detail_card=$detail_card&MemberId=$MemberId&page=", $row_count, '〈', '〉');?></div>
                            <div class="clear"></div>  
                        </td>
                    </tr>
                </table>
            </form>
            <?php /*?><form method="get" class="turn_page_form" action="view.php" onsubmit="javascript:turn_page(this);">
                <?=turn_page($page, $total_pages, "view.php?$query_string&detail_card=$detail_card&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
                <?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
            </form><?php */?>
        <?php }elseif($detail_card==5){?>
            <form name="list_form" id="list_form" class="list_form" method="post" action="index.php"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="1" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
                    <tr align="center" class="list_form_title">
                        <td width="20%" nowrap><strong><?=get_lang('ly200.number');?></strong></td>
                        <td width="30%" nowrap><strong><?=get_lang('member.login_time');?></strong></td>
                        <td width="50%" nowrap><strong><?=get_lang('member.login_ip');?></strong></td>
                    </tr>
                    <?php
                    for($i=0; $i<count($list_row); $i++){
                        $list_row_area=ip_to_area($list_row[$i]['LoginIp']);
                    ?>
                    <tr align="center">
                        <td nowrap><?=$start_row+$i+1;?></td>
                        <td nowrap><?=date(get_lang('ly200.time_format_full'), $list_row[$i]['LoginTime']);?></td>
                        <td nowrap><?=htmlspecialchars($list_row[$i]['LoginIp']);?> [<?=$list_row_area['country'].$list_row_area['area'];?>]</td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="3" class="bottom_act">
                            <div class="fl mgl20">
                                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
                            </div>
                            <div class="turn_page_form fr"><?=turn_bottom_page($page, $total_pages, "view.php?total_pages=$total_pages&detail_card=$detail_card&MemberId=$MemberId&page=", $row_count, '〈', '〉');?></div>
                            <div class="clear"></div>  
                        </td>
                    </tr>
                </table>
            </form>
            <?php /*?><form method="get" class="turn_page_form" action="view.php" onsubmit="javascript:turn_page(this);">
                <?=turn_page($page, $total_pages, "view.php?$query_string&detail_card=$detail_card&page=", $row_count, get_lang('ly200.pre_page'), get_lang('ly200.next_page'));?>
                <?=get_lang('ly200.turn');?>:<input name="page" id="page" type="text" size="2" maxlength="5" class="form_input">&nbsp;<input name="submit" type="submit" class="form_button" value="<?=get_lang('ly200.turn');?>">
                <input name="total_pages" id="total_pages" type="hidden" value="<?=$total_pages;?>">
                <input name="detail_card" type="hidden" value="<?=$detail_card;?>">
                <input name="MemberId" type="hidden" value="<?=$MemberId;?>">
            </form><?php */?>
        <?php }elseif($detail_card==6 && get_cfg('member.mod')){?>
            <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" onsubmit="return checkForm(this);">
            	<div class="table">
                	<div class="tr">
                    	<div class="tr_title"><?=get_lang('ly200.mod').get_lang('member.mod_password');?></div>
                        <div class="form_row">
                        	<font class="fl"><?=get_lang('admin.new_password');?>:</font>
                            <span class="fl">
                            	<input name="NewPassword" type="password" value="" class="form_input" check="<?=get_lang('ly200.filled_out').get_lang('admin.new_password');?>!~*" size="50" maxlength="16">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                	<div class="tr last">
                        <div class="form_row">
                        	<font class="fl"><?=get_lang('admin.re_password');?>:</font>
                            <span class="fl">
                            	<input name="ReNewPassword" type="password" value="" class="form_input" check="<?=get_lang('ly200.filled_out').get_lang('admin.re_password');?>!~=NewPassword|<?=get_lang('admin.repwd_dif_pwd');?>*" size="50" maxlength="16">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="button fr">
                        <input type="submit" value="<?=get_lang('ly200.mod');?>" name="submit" class="form_button">
						<input type="hidden" name="MemberId" value="<?=$MemberId;?>" />
                        <input type="hidden" name="data" value="mod_password" />
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        <?php
        }else{
            js_location('index.php');
        }
        ?>
    </div>
</div>
<?php include('../../inc/manage/footer.php');?>