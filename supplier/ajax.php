<?php 
$act = $_GET['act'];
if($act == 'get'){
	$cb=$_GET['callback'];	
		$BRLU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=BRL";	
	 	$EURU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=EUR";
	 	$RUBU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=RUB";	
	 	$PHPU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=PHP";	
	 	$INRU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=INR";
	 	$CADU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=CAD";	 	
		$AUDU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=AUD";	
		$TRYU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=TRY";	
		$GBPU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=GBP";	
		$SEKU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=SEK";
		$MYRU = "http://op.juhe.cn/onebox/exchange/currency?key=43cd1ff31d3924caa6e1b622b6034677&from=USD&to=MYR"; 	
		$BRLD= file_get_contents($BRLU);
		$EURD= file_get_contents($EURU);
		$RUBD= file_get_contents($RUBU);
		$PHPD= file_get_contents($PHPU);
		$INRD= file_get_contents($INRU);
		$CADD= file_get_contents($CADU);
		$AUDD= file_get_contents($AUDU);
		$GBPD= file_get_contents($GBPU);
		$SEKD= file_get_contents($SEKU);
		$MYRD= file_get_contents($MYRU);
		$BRLR= json_encode($BRLD.";".$EURD.";".$RUBD.";".$PHPD.";".$INRD.";".$CADD.";".$AUDD.";".$GBPD.";".$SEKD.";".$MYRD);			
		echo "{$cb}(".$BRLR.")";

}

?>