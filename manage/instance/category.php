<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
$page_cur='instance_category';
check_permit('instance_category');

if($_POST['action']=='order_category'){
	check_permit('', 'instance.category.order');
	for($i=0; $i<count($_POST['MyOrder']); $i++){
		$CateId=(int)$_POST['CateId'][$i];
		$order=abs((int)$_POST['MyOrder'][$i]);
		
		$db->update('instance_category', "CateId='$CateId'", array(
				'MyOrder'	=>	$order
			)
		);
	}
	
	save_manage_log('案例类别排序');
	
	header('Location: category.php');
	exit;
}

if($_POST['action']=='del_category'){
	check_permit('', 'instance.category.del');
	for($i=0; $i<count($_POST['select_CateId']); $i++){
		$CateId=(int)$_POST['select_CateId'][$i];
		$where=get_search_where_by_CateId($CateId, 'instance_category');
		
		$category_row=$db->get_all('instance_category', $where, 'PicPath, PageUrl');
		for($j=0; $j<count($category_row); $j++){
			del_dir($category_row[$j]['PageUrl']);
			if(get_cfg('instance.category.upload_pic')){
				del_file($category_row[$j]['PicPath']);
				del_file(str_replace('s_', '', $category_row[$j]['PicPath']));
			}
		}
		
		$db->delete('instance_category_description', $where);
		$db->delete('instance_category', $where);
	}
	
	category_subcate_statistic('instance_category');
	
	save_manage_log('删除案例类别');
	
	header('Location: category.php');
	exit;
}

include('../../inc/manage/header.php');
?>
<div class="div_con">
	<?php include('category_header.php');?>
    <form name="category_list_form" id="category_list_form" class="category_list_form" method="post" action="category.php"> 
    <table width="100%" border="0" cellspacing="1" cellpadding="0" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='category_list_form_title'>
        <tr align="center" class="category_list_form_title nosearch" id="category_list_form_title">
            <?php if(get_cfg('instance.category.del')){?><td width="5%" nowrap><strong><?=get_lang('ly200.select');?></strong></td><?php }?>
            <?php if(get_cfg('instance.category.order')){?><td width="5%" nowrap><strong><?=get_lang('ly200.order');?></strong></td><?php }?>
            <td width="85%" align="left" nowrap style="padding-left:7px;"><strong><?=get_lang('ly200.category_name');?></strong></td>
            <?php if(get_cfg('instance.category.mod')){?><td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td><?php }?>
        </tr>
        <?php
        $n=$m=0;
        $ext_category=array();
        $category_row=ouput_Category_to_Array_hill('instance_category');
        
        for($i=0; $i<count($category_row); $i++){
            if($category_row[$i]['Dept']==1){
                $ext_category[$n++]=$ext_CateId_list;
                $ext_CateId_list='';
            }else{
                $ext_CateId_list.=$m.',';
            }
			$cate_row_count = (int)$db->get_row_count('product_category',get_search_where_by_CateId($category_row[$i]['CateId'],'instance_category')." and CateId!='{$category_row[$i]['CateId']}'");
        ?>
        <tr align="center" class="category" id="category_<?=$m++;?>" style="display:<?=$category_row[$i]['Dept']==1?'':'none';?>;">
            <?php if(get_cfg('instance.category.del')){?><td><input name="select_CateId[]" type="checkbox" value="<?=$category_row[$i]['CateId'];?>" /></td><?php }?>
            <?php if(get_cfg('instance.category.order')){?><td><input name="MyOrder[]" class="form_input" type="text" size="3" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" value="<?=htmlspecialchars($category_row[$i]['MyOrder']);?>" /><input type="hidden" name="CateId[]" value="<?=$category_row[$i]['CateId'];?>" /></td><?php }?>
            <td nowrap align="left" class="category_list_form_catename">
                <div class="fz_18px category_list_form_catename_prechars"><?=str_repeat('&nbsp;&nbsp;',$category_row[$i]['Dept']==1?0:$category_row[$i]['Dept']);?></div>
                <?php if($category_row[$i]['Dept']==1 && $category_row[$i]['SubCate']){?><div>&nbsp;<img src="/manage/images/ico/category_close.png" onclick="category_sub_menu(<?=$n;?>);" id="category_img_<?=$n;?>" align="absmiddle" /></div><?php }?>
                
                <div><a href="<?=get_url('instance_category', $category_row[$i]);?>" target="_blank"><?=list_all_lang_data($category_row[$i], 'Category');?><?=$cate_row_count?" ($cate_row_count) ":''; ?></a></div>
                <?php if(get_cfg('instance.category.upload_pic')){?><div><?=creat_imgLink_by_sImg($category_row[$i]['PicPath'], 20, 20);?></div><?php }?>
            </td>
            <?php if(get_cfg('instance.category.mod')){?><td><a href="category_mod.php?CateId=<?=$category_row[$i]['CateId'];?>" title="<?=get_lang('ly200.mod');?>" class="mod"></a></td><?php }?>
        </tr>
        <?php }?>
        <?php if((get_cfg('instance.category.order') || get_cfg('instance.category.del')) && count($category_row)){?>
        <tr>
            <td colspan="4" class="bottom_act">
            	<div class="fl mgl20">
					<?php if(get_cfg('instance.category.order')){?><input name="order_category" type="button" class="list_button transition" onClick="click_button(this, 'category_list_form', 'action');" value="<?=get_lang('ly200.order');?>"><?php }?>
                    <?php if(get_cfg('instance.category.del')){?>
                        <input name="button" type="button" class="list_button transition" onClick='change_all("select_CateId[]");' value="<?=get_lang('ly200.anti_select');?>">
                        <input name="del_category" type="button" class="list_button transition" onClick="if(!confirm('<?=get_lang('ly200.confirm_del');?>')){return false;}else{click_button(this, 'category_list_form', 'action');};" value="<?=get_lang('ly200.del');?>">
                    <?php }?>
                    <input name="action" id="action" type="hidden" value="">
                </div>
            </td>
        </tr>
        <?php }?>
    </table>
    </form>
</div>
<?php
$ext_category[$n]=$ext_CateId_list;
for($i=0; $i<count($ext_category); $i++){
	echo "<input type='hidden' id='ext_category_$i' value='$ext_category[$i]'>";
}
echo "<input type='hidden' id='ext_category' value='$i'>";
?>
<script language="javascript">category_sub_menu(-1);</script>
<?php include('../../inc/manage/footer.php');?>