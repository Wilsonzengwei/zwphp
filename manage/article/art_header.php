	<div class="header" style="border-bottom:1px solid #fbfbfb;">
		<div class="float_left">
        	<span><?=get_lang('menu.article');?></span>
            <?php
				$openmenu=0;
				foreach((array)$manage_menu['article'] as $key => $value){//开启子菜单的个数
					if(!$menu["$key"]) continue;
					$openmenu++;	
				}
				$i=0;
				foreach((array)$manage_menu['article'] as $key => $value){ //输出子菜单
					if(!$menu["$key"]) continue;
					$i++;
					$class = $key == $page_cur ? ' class="cur"' : '';
			?> 
            		<a href="<?=$supplier_manage_path.$value[0];?>"<?=$class;?>><?=get_lang($value[1]);?></a><?=$i<$openmenu? ' <font>|</font>' : '';?> 
            <?php 
				} 
			?>
        </div>
        <div class="float_right">
            <div class="topbutton fr">
                <?php if(in_array($Group, get_cfg('article.amdo'))){?><a href="add.php?GroupId=<?=$GroupId;?>"  class="add" title="<?=get_lang('ly200.add');?>"></a><?php }?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>