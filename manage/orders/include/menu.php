<div class="member_con">
    <div class="act_menu">
        <div class="card_list">
            <div class="<?=$module=='base'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=base"><?=get_lang('orders.base_info');?></a></div>
            <?php /*<div class="<?=$module=='address'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=address"><?=get_lang('orders.address_info');?></a></div>*/ ?>
            <div class="<?=$module=='status'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=status"><?=get_lang('orders.status');?></a></div>
            <div class="<?=$module=='product_list'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=product_list"><?=get_lang('orders.products_list');?></a></div>
            
        </div>
    </div>
</div>