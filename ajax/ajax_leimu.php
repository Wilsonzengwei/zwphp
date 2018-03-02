<?php 
include('../inc/include.php');
if($_GET['mode'] == '1'){
	$CateId = $_GET['act'];
	$num=0; 
	echo "<option value='0'>选择</option>";
    foreach((array)$All_Category_row['0,'.$CateId.','] as $k1 => $v1){ 
    if($lang == '_en'){
    	$name1 = $v1['Category_lang_2'];
    }else{
		$name1 = $v1['Category'.$lang];
    }
    
    $v1CateId = $v1['CateId'];
    $url1 = get_url('product_category',$v1);
    if((array)$All_Category_row['0,'.$vCateId.','.$v1CateId.',']){
    $num++;
}?>

<option value="<?=$v1CateId?>"><?=$name1?></option>
<?php 

}}elseif($_GET['mode'] == '2'){
	$CateId = $_GET['act'];
	$CateId2 = $_GET['act2'];
	echo "<option value='0'>选择</option>";

	foreach((array)$All_Category_row['0,'.$CateId.','.$CateId2.','] as $k2 => $v2){ 
	if($lang == '_en'){
		$name2 = $v2['Category_lang_2'];
	}else{
		$name2 = $v2['Category'.$lang];
	}
	$v2CateId = $v2['CateId'];
	$url2 = get_url('product_category',$v2);

	?>

	<option value="<?=$v2CateId?>"><?=$name2?></option>
<?php }}else{ echo "0"; }?>