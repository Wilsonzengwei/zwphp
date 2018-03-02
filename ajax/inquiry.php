<?php
include('../inc/include.php');
if($_POST['data']=='inquire_en'){
	$un_keyword_ary=array('www', 'http');	//带有本关键词的内容不存入数据库
	$ProId=(int)$_POST['ProId'];
	$Qty=(int)$_POST['Qty'];
	$SupplierId=(int)$_POST['SupplierId'];
	$MemberId=(int)$_POST['MemberId'];
	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$Email=$_POST['Email'];
	$Address=$_POST['Address'];
	$City=$_POST['City'];
	$State=$_POST['State'];
	$Country=$_POST['Country'];
	$PostalCode=$_POST['PostalCode'];
	$Phone=$_POST['Phone'];
	$Fax=$_POST['Fax'];
	$Subject=$_POST['Subject'];
	$Message=$_POST['Message'];
	
	$str=$FirstName.$LastName.$Subject.$Message;	//过滤内容
	$in=0;
	foreach($un_keyword_ary as $value){
		if(@substr_count($str, $value)){
			$in=1;
			break;
		}
	}
	
	($in==1 || $FirstName=='' || $Message=='') && exit('["1","'.$website_language['form'.$lang]['error'].'!"]');
	$db->insert('product_inquire', array(
			'ProId'		=>	$ProId,
			'Qty'		=>	$Qty,
			'SupplierId' =>	$SupplierId,
			'MemberId' =>	$MemberId,
			'FirstName'	=>	$FirstName,
			'LastName'	=>	$LastName,
			'Email'		=>	$Email,
			'Address'	=>	$Address,
			'City'		=>	$City,
			'State'		=>	$State,
			'Country'	=>	$Country,
			'PostalCode'=>	$PostalCode,
			'Phone'		=>	$Phone,
			'Fax'		=>	$Fax,
			'Subject'	=>	$Subject,
			'Message'	=>	$Message,
			'Ip'		=>	get_ip(),
			'PostTime'	=>	$service_time
		)
	);
	exit('["2","'.$website_language['form'.$lang]['success'].'!"]');
}
?>