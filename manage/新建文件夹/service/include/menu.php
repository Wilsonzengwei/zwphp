<div class="member_con">
    <div class="act_menu">
        <div class="card_list">
            <div class="<?=$module=='base'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=base">基本信息</a></div>
            <?php /*<div class="<?=$module=='address'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=address"><?=get_lang('orders.address_info');?></a></div>*/ ?>
            <div class="<?=$module=='status'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=status">订单状态</a></div>
            <div class="<?=$module=='product_list'?'cur':'';?>"><a href="view.php?OrderId=<?=$OrderId;?>&module=product_list">订单追踪</a></div>
            
        </div>
    </div>
</div>