	<div class="header">
		<div class="float_left">
        	<span><?=get_lang('menu.sale');?></span>
            <?php
				$openmenu=0;
				foreach((array)$manage_menu['sale'] as $key => $value){//开启子菜单的个数
					if(!$menu["$key"]) continue;
					$openmenu++;	
				}
				$i=0;
				foreach((array)$manage_menu['sale'] as $key => $value){ //输出子菜单
					if(!$menu["$key"]) continue;
					$i++;
					$class = $key == $page_cur ? ' class="cur"' : '';
			?> 
            		<a href="<?=$manage_path.$value[0];?>"<?=$class;?>><?=get_lang($value[1]);?></a><?=$i<$openmenu? ' <font>|</font>' : '';?> 
            <?php 
				} 
			?>
        </div>
        <div class="float_right">
            <div class="toppage fr"><?=turn_top_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
            <?php if($_SERVER['PHP_SELF']=='/manage/shipping/index.php'){ ?>
                <?php /*?><div class="topbutton fr">
                    <?php if(get_cfg('info.del')){?><a href="javascript:void(0);"  class="del" title="<?=get_lang('ly200.del');?>"></a><?php }?>
                </div><?php */?>
                <div class="topbutton fr">
                    <?php if(get_cfg('shipping.add')){?><a href="add.php"  class="add" title="<?=get_lang('ly200.add');?>"></a><?php }?>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>