<?php 
$act = $_GET['act'];
if($act == 'get'){	;	
		$RMBU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=RMB";		
		$RMBD= file_get_contents($RMBU);
		$RMBR= json_encode($RMBD);			
		echo $RMBR;
}

?>