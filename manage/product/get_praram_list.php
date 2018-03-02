<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');

$CateId = $_POST['CateId'];
$ProId=(int)$_POST['ProId'];
$product_row=$db->get_one('product',"ProId = '$ProId'");
$cate_row=$db->get_one('product_category',"CateId = '$CateId'");

if($cate_row['UId']=='0,'){
	$TopCateId=	$cate_row['CateId'];
}else{
	$TopCateId=get_top_CateId_by_UId($cate_row['UId']);
}

//修改产品时，产品分类在同一级父类下
if($ProId){
	if($TopCateId!=get_top_CateId_by_UId(get_UId_by_CateId($product_row['CateId']))){
		echo 1;
		exit;
	}
}

$TopCate_row=$db->get_one('product_category',"CateId='$TopCateId'");
$param_row=$db->get_all('param',"CateId='{$TopCate_row['PIdCateId']}'");
$len=count($param_row);
if($len){
?>

<tr>
	<td>
    	<?php
		for($i=0;$i<$len;$i++){
			$select_row=array();
			$select_row=str::json_data(htmlspecialchars_decode($param_row[$i]['Value']), 'decode');
		?>
         <select name="AttrId_<?=$i?>[]" class="form_select">
            <option value="0">请选择<?=$param_row[$i]['Name']?></option>
            <?php for($t=0;$t<=count($select_row);$t++){
                    if(!$select_row[$t]) continue;
                ?>
                <option value="<?=$t+1?>"><?=$select_row[$t]?></option>
            <?php }?>
         </select>
         <?php }?>
        &nbsp;&nbsp; 加价格：&nbsp;&nbsp;$<input name="Param_Price[]" type="text" value="" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 1);" onpaste="set_number(this, 1);" check="属性格价!~*">
       &nbsp;&nbsp; 库存：&nbsp;&nbsp;<input name="Param_Stock[]" type="text" value="" class="form_input" size="8" maxlength="10" onkeyup="set_number(this, 0);" onpaste="set_number(this, 0);" check="属性库存!~*">
         &nbsp;&nbsp;<a href="javascript:void(0)" onClick="$_('param_price_list').deleteRow(this.parentNode.parentNode.rowIndex);"><img src="../images/del.gif" hspace="5" /></a>
	</td>
</tr>
<?php }?>
