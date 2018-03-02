<?php
	$ip=$_GET['ip'];
	$url="http://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query=".$ip."&co=&resource_id=6006&t=1502094624196&ie=utf8&oe=gbk&cb=op_aladdin_callback&format=json&tn=baidu&cb=jQuery110207229737169069499_1502094618999&_=1502094619001"
	$data=file_get_contents($url);
	echo $url;
?>