<?php 
include("../inc/include.php");
if($_GET['act'] == 'help'){
	$AId = $_GET['key'];
	$where = "AId='$AId'";
	$Contents = $db->get_one("articles",$where,"Content");
	echo $Contents['Content'];
}else{
	echo "null";
}

?>