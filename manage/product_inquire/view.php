<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='product_inquire';
check_permit('product_inquire');

$IId=(int)$_GET['IId'];
$query_string=query_string('IId');

$product_inquire_row=$db->get_one('product_inquire', "IId='$IId'");
!$product_inquire_row['IsRead'] && $db->update('product_inquire', "IId='$IId'", array('IsRead'=>1));

include('../../inc/fun/ip_to_area.php');
$ip_area=ip_to_area($product_inquire_row['Ip']);

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('inquire_header.php');?>
    <form method="post" name="act_form" id="act_form" class="act_form" action="view.php" enctype="multipart/form-data" onsubmit="return checkForm(this);">
    	<div class="table">
        	<div class="table_bg"></div>
        	<div class="tr">
            	<div class="tr_title"><?=get_lang('ly200.view').get_lang('product_inquire.modelname');?></div>
                <div class="form_row">
               		<font class="fl"><?=get_lang('ly200.full_name');?>:</font>
                    <span class="fl"><?=htmlspecialchars($product_inquire_row['FirstName'].' '.$product_inquire_row['LastName']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
        	<div class="tr">
                <div class="form_row">
               		<font class="fl"><?=get_lang('ly200.email');?>:</font>
                    <span class="fl">
						<?=htmlspecialchars($product_inquire_row['Email']);?><?php if($menu['send_mail']){?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($product_inquire_row['Email'].'/'.$product_inquire_row['FirstName'].' '.$product_inquire_row['LastName']);?>');" class="red"><?=get_lang('send_mail.send');?></a><?php }?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            
            <?php if($product_inquire_row['Country']=='中国'){?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.s_c_a');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['State'].$product_inquire_row['City'].$product_inquire_row['Area']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.address');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['Address']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php }else{?>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.address');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['Address']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.city');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['City']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.state');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['State']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="tr">
                    <div class="form_row">
                        <font class="fl"><?=get_lang('product_inquire.country');?>:</font>
                        <span class="fl">
                            <?=htmlspecialchars($product_inquire_row['Country']);?>
                        </span>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php } ?>
            
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.postal_code');?>:</font>
                    <span class="fl"><?=htmlspecialchars($product_inquire_row['PostalCode']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.phone');?>:</font>
                    <span class="fl"><?=htmlspecialchars($product_inquire_row['Phone']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.fax');?>:</font>
                    <span class="fl"><?=format_text($product_inquire_row['Fax']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.inquire_product');?>:</font>
                    <span class="fl">
					<?php
						$product_row=$db->get_all('product', "ProId in({$product_inquire_row['ProId']})", '*', 'MyOrder desc, ProId desc');
						for($i=0; $i<count($product_row); $i++){
							$url=get_url('product', $product_row[$i]);
							echo "<a href='$url' target='_blank' class='blue'>{$product_row[$i]['Name']}</a><br>";
						}
                    ?>
                    </span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.subject');?>:</font>
                    <span class="fl"><?=htmlspecialchars($product_inquire_row['Subject']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('product_inquire.message');?>:</font>
                    <span class="fl"><?=format_text($product_inquire_row['Message']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('ly200.ip');?>:</font>
                    <span class="fl"><?=$product_inquire_row['Ip'];?> [<?=$ip_area['country'].$ip_area['area'];?>]</span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="tr last">
            	<div class="form_row">
                	<font class="fl"><?=get_lang('ly200.time');?>:</font>
                    <span class="fl"><?=date(get_lang('ly200.time_format_full'), $product_inquire_row['PostTime']);?></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="button fr">
            	<a href="index.php?<?=$query_string;?>" class="form_button return"><?=get_lang('ly200.return');?></a>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php include('../../inc/manage/footer.php');?>