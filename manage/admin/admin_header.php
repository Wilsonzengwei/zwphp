	<div class="header">
		<div class="float_left">
        	<span><?=get_lang('menu.admin');?></span>
            <?php
				$openmenu=0;
				foreach((array)$manage_menu['admin'] as $key => $value){//开启子菜单的个数
					if(!$menu["$key"]) continue;
					$openmenu++;	
				}
				$i=0;
				foreach((array)$manage_menu['admin'] as $key => $value){ //输出子菜单
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
        <?php if($_SERVER['PHP_SELF']=='/manage/admin/index.php'){ ?>
            <div class="toppage fr"><?=turn_top_page($page, $total_pages, "index.php?$query_string&page=", $row_count, '〈', '〉');?></div>
            <div class="topbutton fr">
                <a href="add.php"  class="add" title="<?=get_lang('ly200.add');?>"></a>
            </div>
            <div class="clear"></div>
        <?php } ?>
        </div>
        <div class="clear"></div>
    </div>