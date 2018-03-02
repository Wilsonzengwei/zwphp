<?php
	include("inc/include.php");

	$clicks = $db->get_row_count('index_time','1');
	
	$time=$_GET['HomeTimes'];
	
	$ip=$_GET['ip'];
	$url=$_GET['url'];
	$ProductClicks=$_GET['ProductClicks'];
	$db->insert('index_time',array(
		'ProductClicks' => $ProductClicks,
		'Time'	=> $time,
		'Ip' => $ip,
		'Url' =>$url
		));

	$a=$time_1.",".$ProductClicks;
	$index_time = $db->get_all('index_time');
	$index_time_row = $index_time[$clicks];
	print_r($index_time_row);

?>