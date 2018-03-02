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
            <div class="toppage fr"><?=turn_top_page($page, $total_pages, "level.php?$query_string&page=", $row_count, '〈', '〉');?></div>
            <?php if($page){ ?>
                <?php /*?><div class="topbutton fr">
                    <?php if(get_cfg('info.del')){?><a href="javascript:void(0);"  class="del" title="<?=get_lang('ly200.del');?>"></a><?php }?>
                </div><?php */?>
                <div class="topbutton fr">
                    <?php if(get_cfg('member.level.add')){?><a href="level_add.php"  class="add" title="<?=get_lang('ly200.add');?>"></a><?php }?>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>