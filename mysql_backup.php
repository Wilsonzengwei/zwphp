<?php
header("Content-type: text/html; charset:utf-8");
set_time_limit(0);

if(is_file('.htaccess') && $htaccess=file_get_contents('.htaccess')){
	$fp=fopen('htaccess.backup.txt', 'w+');
	if(fwrite($fp, $htaccess)){
		echo "成功写入文件：htaccess.backup.txt<br><br>";
	}
	fclose($fp);
}

if(is_file('Connections/link.php')){
	include('Connections/link.php');
	$mysql_host=$hostname_link;
	$mysql_port='3306';
	$mysql_database=$database_link;
	$mysql_username=$username_link;
	$mysql_password=$password_link;
	$mysql_charset='gbk';
}elseif(is_file('inc/site_config.php')){
	ob_start();
	include('inc/site_config.php');
	ob_end_clean();
	$mysql_host=$db_hostname?$db_hostname:$db_host;
	$mysql_port=$db_port;
	$mysql_database=$db_name?$db_name:$db_database;
	$mysql_username=$db_username;
	$mysql_password=$db_password;
	$mysql_charset=$db_char?$db_char:'gbk';
}else{
	//unlink(basename($_SERVER['PHP_SELF']));
	exit('无法备份数据库！');
}

$sql='';
$file_part=1;
$file_size=5*1024*1024;	//5M
$file_name=date('Ymd', time());
$table_ary=array();
$db=new db($mysql_host, $mysql_port, $mysql_username, $mysql_password, $mysql_database, $mysql_charset);

$tables_rs=$db->query("show table status from `$mysql_database`");
while($db->next_record($tables_rs)){
	$table=$db->record_field('Name');
	$sql.=make_header($table);
	$table_ary[]=$table;
}
$sql=write_file($sql, $file_name.'.sql');

for($i=0; $i<count($table_ary); $i++){
	echo "正在备份{$table_ary[$i]}数据表...<br>";
	$db->query("select * from `{$table_ary[$i]}`");
	$num_fields=$db->num_fields();
	while($db->next_record()){
		$sql.=make_record($table_ary[$i], $num_fields);
		if(strlen($sql)>=$file_size){
			$sql=write_file($sql, $file_name.'_p'.sprintf('%03d', $file_part).'.sql');
			$file_part++;
		}
	}
}

$sql!='' && write_file($sql, $file_name.'_p'.sprintf('%03d', $file_part).'.sql');
//unlink(basename($_SERVER['PHP_SELF']));

function write_file($sql, $file_name){
	@mkdir('./___mysql___backup___/', 0777);
	$fp=fopen('./___mysql___backup___/'.$file_name, 'w+');
	if(fwrite($fp, $sql)){
		echo "成功写入文件：{$file_name}<br>";
	}
	fclose($fp);
	return '';
}

function make_header($table){
	global $db;
	$db->query("show create table `$table`");
	$db->next_record();
	return preg_replace("/\n/", '', $db->record_field('Create Table')).";\n";
}

function make_record($table, $num_fields){
	global $db;
	$comma='';
	$sql.="insert into `$table` values(";
	
	for($i=0; $i<$num_fields; $i++){
		$sql.=($comma."'".mysql_escape_string($db->record[$i])."'");
		$comma=',';
	}
	$sql.=");\n";
	return $sql;
}

class db{
	var $linkid;
	var $sqlid;
	var $record;
	
	function db($host='',$mysql_port='',$username='',$password='',$db='',$mysql_charset=''){
		!$this->linkid && $this->linkid = mysql_connect($host.':'.$mysql_port, $username, $password) or die('无法连接数据库');
		
		mysql_select_db($db,$this->linkid) or die('无法打开数据库');
		mysql_query("set names '$mysql_charset'");
		return $this->linkid;
	}
	
	function query($sql){
		if($this->sqlid=mysql_query($sql,$this->linkid)){
			return $this->sqlid;
		}else{
			return false;
		}
	}
	
	function num_fields($sql_id=''){
		!$sql_id && $sql_id=$this->sqlid;
		return mysql_num_fields($sql_id);
	}
	
	function next_record($sql_id=''){
		!$sql_id && $sql_id=$this->sqlid;
		
		if($this->record=mysql_fetch_array($sql_id)){
			return $this->record;
		}else{
			return false;
		}
	}
	
	function record_field($name){
		if($this->record[$name]){
			return $this->record[$name];
		}else{
			return false;
		}
	}
}
?>