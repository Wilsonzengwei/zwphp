<?php
	include('../inc/include.php');
	if($_POST['act']=='search'){
		$a=$_POST['txt'];
		$proSelect = $db->get_limit('product',"Name_lang_1 like '%$a%'",'*','Stock desc','1','10');
		
		
			
		//var_dump($proSelect);exit;

?>
<?php 
	foreach($proSelect as $k=>$v){
		//var_dump($v);
		$name = $v['Name_lang_1'];
		$stock = $v['stock'];
		if(!$stock){
			$stock = '0';
		}

?>

<a class="Dropdown_content"><div class="Dropdown_content_txt" style=""><?=$name?></div><div class="Dropdown_content_2" style=""><span>约</span><span class="search_number"><?=$stock?></span><span>个产品</span></div></a>
<?php }?>
<script>

	$(".Dropdown_content .Dropdown_content_txt").click(function(){
		$(".drop_down_box").css("display",'none');
		var aa=$(this).html();
		$(".right-input").val(aa);
	})
</script>
<?php }?>