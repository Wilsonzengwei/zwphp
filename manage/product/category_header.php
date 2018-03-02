	<div class="header">
		<div class="float_left">
        	<span><?=get_lang('menu.product');?></span>
            <?php
				$openmenu=0;
				foreach((array)$manage_menu['product'] as $key => $value){//开启子菜单的个数
					if(!$menu["$key"]) continue;
					$openmenu++;	
				}
				$i=0;
				foreach((array)$manage_menu['product'] as $key => $value){ //输出子菜单
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
			<?php if($_SERVER['PHP_SELF']=='/manage/product/category.php'){ ?>
                <div class="topbutton fr">
                    <?php if(get_cfg('product.category.add')){?><a href="category_add.php"  class="add" title="<?=get_lang('ly200.add');?>"></a><?php }?>
                </div>
			<?php } ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>