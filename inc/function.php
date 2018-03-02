<?php 
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

//**********************************************类别表相关（start）****************************************************
function strCut($str,$length)//$str为要进行截取的字符串，$length为截取长度（汉字算一个字，字母算半个字）
{
	$str = trim($str);
	$string = "";
	if(strlen($str) > $length)
	{
		for($i = 0 ; $i<$length ; $i++)
		{
			if(ord($str) > 127)
			{
				$string .= $str[$i] . $str[$i+1] . $str[$i+2];
				$i = $i + 2;
			}
			else
			{
				$string .= $str[$i];
			}
		}
		$string .= "...";
		return $string;
	}
	return $str;
}
function get_UId_by_CateId($CateId, $TB='product_category'){	//根据CateId取得UId
	global $db;
	
	$UId=$db->get_value($TB, "CateId='$CateId'", 'UId');
	return $UId?$UId.$CateId.',':'-1,-1,';
}

function get_FUId_by_UId($UId){	//返回上一级的UId
	$arr_UId=explode(',', $UId);
	array_pop($arr_UId);
	array_pop($arr_UId);
	$UId=implode(',', $arr_UId).',';
	return $UId;
}

function get_CateId_by_UId($UId){	//根据UId取得CateId
	$arr_UId=explode(',', $UId);
	$CateId=$arr_UId[count($arr_UId)-2];
	return $CateId;
}

function get_top_CateId_by_UId($UId){	//根据UId取得顶级的CateId
	$arr_UId=explode(',', $UId);
	return $arr_UId[1];
}

function get_search_where_by_CateId($CateId, $TB='product_category'){	//根据CateId创建条件用于数据库查询
	$allCateId=get_AllSubCateId_by_UId(get_UId_by_CateId($CateId, $TB), $TB).','.$CateId;
	return "CateId in($allCateId)";
}

function get_station_path($str, $category='', $TB='product_category', $pchar=' &gt; '){ //获取当前位置
	global $db;
	
	if(substr($str, 0, 2)=='0,'){ //参数是一个UId
		$UId=$str;
		$where="CateId in({$str}0)";
	}else{
		$UId=get_UId_by_CateId($str, $TB);
		$where="CateId in({$UId}0)";
	}
	
	if(!is_array($category)){
		$cate_ary=$db->get_all($TB, $where);
		for($i=0; $i<count($cate_ary); $i++){
			$all_category[$cate_ary[$i]['CateId']]=$cate_ary[$i];
		}
	}
	
	$arr_UId=@explode(',', $UId);
	$station_path='';
	for($i=1; $i<count($arr_UId)-1; $i++){
		$url=get_url($TB, $all_category[$arr_UId[$i]]);
		$station_path.="$pchar<a href='$url'>{$all_category[$arr_UId[$i]]['Category']}</a>";
	}
	return $station_path;
}

function get_AllSubCateId_by_UId($UId, $TB='product_category'){
	global $db;
	
	$subCateId='';
	$cate_row=$db->get_all($TB, "UId like '{$UId}%'", 'CateId', 'MyOrder desc, CateId asc');
	if(count($cate_row)){
		for($i=0; $i<count($cate_row); $i++){
			$subCateId.=$cate_row[$i]['CateId'].',';
		}
		return substr($subCateId, 0, -1);
	}else{
		return '-1';
	}
}

function category_subcate_statistic($TB){	//类别表子类别数量统计
	global $db;
	
	$row=$db->get_all($TB, '1', 'UId, CateId', 'MyOrder desc, CateId asc');
	for($i=0; $i<count($row); $i++){
		$db->update($TB, "CateId={$row[$i]['CateId']}", array(
				'SubCate'	=>	$db->get_row_count($TB, "UId like '{$row[$i]['UId']}{$row[$i]['CateId']},%'"),
				'Dept'		=>	substr_count($row[$i]['UId'], ',')
			)
		);
	}
}
function ouput_Category_to_Select($select_name='CateId', $selected_CateId='', $TB='product_category', $where='UId="0,"', $ext_where=1, $select_value=''){	//把类别表输出成一个select表单
	global $db;
	
	ob_start();
	echo "<select name='$select_name'>";
	$selected=$selected_CateId==''?'selected':'';
	echo "<option value='' $selected>--$select_value--</option>";
	
	$cate_row=$db->get_all($TB, $where, 'UId,CateId,Category_lang_1', 'MyOrder desc, CateId asc');
	ouput_Category_to_Select_ext($cate_row, $selected_CateId, $TB, 0, '', $ext_where);
	echo '</select>';
	
	$select=ob_get_contents();
	ob_end_clean();
	return $select;
}

function ouput_Category_to_Select_ext($cate_row, $selected_CateId, $TB, $layer=0, $PreChars='', $ext_where){	//递归循环输出类别到Select
	global $db;
	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$value=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'└':'├'));
		$selected=$cate_row[$i]['CateId']==$selected_CateId?'selected':'';
		echo "<option value='{$cate_row[$i]['CateId']}' $selected>{$value}";
		echo $cate_row[$i]['Category_lang_1'];
		echo "</option>\n";
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", 'UId,CateId,Category_lang_1', 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?' ':'｜';   //前导符
			$layer++;
			ouput_Category_to_Select_ext($cate_row_ext, $selected_CateId, $TB, $layer, $PreChars, $ext_where);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
}

function ouput_Category_to_Select_1($select_name='CateId', $selected_CateId='', $TB='product_category', $where='UId="0,"', $ext_where=1, $paduan, $select_value=''){	//把类别表输出成一个select表单
	global $db;
	
	ob_start();
	if(!$paduan){
		$cate = "Category_lang_1";
	}
	if($paduan == '0'){
		$cate = "Category_lang_1";

	}else{
	
		$cate = "Category";
	}
	echo "<select name='$select_name'>";
	$selected=$selected_CateId==''?'selected':'';
	echo "<option value='' $selected>--$select_value--</option>";
	
	$cate_row=$db->get_all($TB, $where, 'UId,CateId,'.$cate, 'MyOrder desc, CateId asc');
	ouput_Category_to_Select_ext_1($cate_row, $selected_CateId, $TB, 0, '',$cate, $ext_where);
	echo '</select>';
	
	$select=ob_get_contents();
	ob_end_clean();
	return $select;
}

function ouput_Category_to_Select_ext_1($cate_row, $selected_CateId, $TB, $layer=0, $PreChars='',$cate, $ext_where){	//递归循环输出类别到Select
	global $db;
	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$value=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'└':'├'));
		$selected=$cate_row[$i]['CateId']==$selected_CateId?'selected':'';
		echo "<option value='{$cate_row[$i]['CateId']}' $selected>{$value}";
		echo $cate_row[$i][$cate];
		echo "</option>\n";
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", 'UId,CateId,'.$cate, 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?' ':'｜';   //前导符
			$layer++;
			ouput_Category_to_Select_ext_1($cate_row_ext, $selected_CateId, $TB, $layer, $PreChars,$cate, $ext_where);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
}
function ouput_Category_to_Select2($select_name='CateId', $selected_CateId='', $TB='product_category', $where='UId="0,"', $ext_where=1, $select_value=''){	//把类别表输出成一个select表单
	global $db;
	global $lang;
	ob_start();
	echo "<select name='$select_name'>";
	$selected=$selected_CateId==''?'selected':'';
	echo "<option value='' $selected>--$select_value--</option>";
	
	$cate_row=$db->get_all($TB, $where, 'UId,CateId,Category'.$lang, 'MyOrder desc, CateId asc');
	
	ouput_Category_to_Select_ext2($cate_row, $selected_CateId, $TB, 0, '', $ext_where);
	echo '</select>';
	
	$select=ob_get_contents();
	ob_end_clean();
	return $select;
}

function ouput_Category_to_Select_ext2($cate_row, $selected_CateId, $TB, $layer=0, $PreChars='', $ext_where){	//递归循环输出类别到Select
	global $db;
	global $lang;
	$catesent = $_SESSION['CateId'];
	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$value=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'└':'├'));
		$selected=$cate_row[$i]['CateId']==$selected_CateId?'selected':'';
		echo "<option value='{$cate_row[$i]['CateId']}' $selected>{$value}";
		echo $cate_row[$i]['Category'.$lang];
		echo "</option>\n";
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", 'UId,CateId,Category'.$lang, 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?' ':'｜';   //前导符
			$layer++;
			ouput_Category_to_Select_ext2($cate_row_ext, $selected_CateId, $TB, $layer, $PreChars, $ext_where);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
}
function ouput_Category_to_Select3($select_name='CateId', $selected_CateId='', $TB='product_category', $where='UId="0,"', $ext_where=1, $select_value=''){	//把类别表输出成一个select表单
	global $db;
	global $lang;
	ob_start();
	echo "<select name='$select_name'>";
	$catesent = $_SESSION['CateId'];
	$selected=$selected_CateId==''?'selected':'';
	echo "<option value='' $selected>--$select_value--</option>";
	$cate_row=$db->get_all($TB, $where, 'UId,CateId,Category'.$lang, 'MyOrder desc, CateId asc');
	
	ouput_Category_to_Select_ext3($cate_row, $selected_CateId, $TB, 0, '', $ext_where);
	echo '</select>';
	
	$select=ob_get_contents();
	ob_end_clean();
	return $select;
}

function ouput_Category_to_Select_ext3($cate_row, $selected_CateId, $TB, $layer=0, $PreChars='', $ext_where){	//递归循环输出类别到Select
	global $db;
	global $lang;
	$catesent = $_SESSION['CateId'];

	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$value=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'└':'├'));
		$selected=$cate_row[$i]['CateId']==$catesent?'selected':'';
		echo "<option value='{$cate_row[$i]['CateId']}' $selected>{$value}";
		echo $cate_row[$i]['Category'.$lang];
		echo "</option>\n";
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", 'UId,CateId,Category'.$lang, 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?' ':'｜';   //前导符
			$layer++;
			ouput_Category_to_Select_ext3($cate_row_ext, $selected_CateId, $TB, $layer, $PreChars, $ext_where);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
}

function ouput_Category_to_Array($TB='product_category', $field='*', $where='UId="0,"', $ext_where=1){	//把类别表输出到一个数组，$field中UId为必须
	global $db;
	
	$cate_ary=array();
	$cate_row=$db->get_all($TB, $where, $field, 'MyOrder desc, CateId asc');
	ouput_Category_to_Array_ext($cate_row, $TB, $field, $ext_where, 0, '', $cate_ary);
	
	return $cate_ary;
}

function ouput_Category_to_Array_ext($cate_row, $TB, $field, $ext_where, $layer, $PreChars, &$cate_ary){	//递归循环输出类别到数组
	global $db;
	
	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$cate_row[$i]['PreChars']=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'└':'├'));
		$cate_ary[]=$cate_row[$i];
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", $field, 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?'   ':'｜';   //前导符
			$layer++;
			ouput_Category_to_Array_ext($cate_row_ext, $TB, $field, $ext_where, $layer, $PreChars, $cate_ary);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
}
//**********************************************类别表相关（end）******************************************************

function ad($AId){
	global $site_root_path, $db;
	
	$ad_row=$db->get_one('ad', "AId='$AId'");
	$width=$ad_row['Width']?$ad_row['Width'].'px':'auto';
	$height=$ad_row['Height']?$ad_row['Height'].'px':'auto';
	$ad_str="<div style='width:$width; height:$height; overflow:hidden;' class='ad'>";
	
	if($ad_row['AdType']==0){	//图片
		if($ad_row['PicCount']==1){
			$ad_row['Url_0'] && $ad_str.="<a href='{$ad_row['Url_0']}' target='_blank'>";
			$ad_str.="<img src='{$ad_row['PicPath_0']}'>";
			$ad_row['Url_0'] && $ad_str.='</a>';
		}else{
			$ad_str.='<script language="javascript" src="/js/swf_obj.js"></script>';
			$xmlData='<list>';
			for($i=0; $i<5; $i++){
				$p=$ad_row['PicPath_'.$i];
				$u=$ad_row['Url_'.$i];
				is_file($site_root_path.$p) && $xmlData.="<item><img>$p</img><url>$u</url></item>";
			}
			$xmlData.='</list>';
			$ad_str.="<div id='swfContents_{$AId}'></div>
						<script type='text/javascript'>
							var xmlData='$xmlData';
							var flashvars={xmlData:xmlData};
							var params={menu:false, wmode:'transparent'};
							var attributes={};
							swfobject.embedSWF('/images/lib/swf/ad.swf', 'swfContents_{$AId}', '{$ad_row['Width']}', '{$ad_row['Height']}', '9', 'expressInstall.swf', flashvars, params, attributes);
						</script>";
		}
	}elseif($ad_row['AdType']==1){	//动画
		$ad_str.="<script language='javascript' src='/js/swf_obj.js'></script><div id='swfContents_{$AId}'></div>
					<script type='text/javascript'>
						swfobject.embedSWF('{$ad_row['FlashPath']}', 'swfContents_{$AId}', '{$ad_row['Width']}', '{$ad_row['Height']}', '9');
					</script>";
	}else{	//编辑器
		$ad_str.=$ad_row['Contents'];
	}
	
	$ad_str.='</div>';
	return $ad_str;
}

function rand_code($length=10){	//随机命名
	global $service_time;	
	$rand_str=$service_time+mt_rand(100000, 999999);
	$rand_str=substr(md5($rand_str), mt_rand(0, 32-$length), $length);	
	return $rand_str;
}

function get_ext_name($filename=''){   //返回文件后辍名（小写）
	return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

function del_file($filename){	//删除文件
	if($filename==''){
		return false;
	}
	global $site_root_path;	
	
	@chmod($site_root_path.$filename, 0777);
	@unlink($site_root_path.$filename);
}

function del_dir($dir){	//删除目录
	global $site_root_path;
	
	if(in_array($dir, array_merge(system_dir(), array('/', '.', '..', ''))) || !($mydir=@dir($site_root_path.$dir))){
		return false;
	}
	while($file=$mydir->read()){
		if(is_dir("$site_root_path$dir$file") && $file!='.' && $file!='..'){ 
			@chmod("$site_root_path$dir$file", 0777);
			del_dir("$dir$file"); 
		}elseif(is_file("$site_root_path$dir/$file")){
			@chmod("$site_root_path$dir/$file", 0777);
			@unlink("$site_root_path$dir/$file");
		}
	}
	$mydir->close();
	@chmod($site_root_path.$dir, 0777);
	@rmdir($site_root_path.$dir);
}

function format_text($text){	//格式化文本
	$text=htmlspecialchars($text);
	$text=str_replace('  ', '&nbsp;&nbsp;', $text);
	$text=nl2br($text);	
	return $text;
}

function cut_str($str, $lenth, $start=0){	//剪切字符串
	$str=str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $str);
	$len=strlen($str);
	if($len<=$length){
		return str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $str);
	}
	$substr='';
	$n=$m=0;
	for($i=0; $i<$len; $i++){
		$x=substr($str, $i, 1);
		$a=base_convert(ord($x), 10, 2);
		$a=substr('00000000'.$a, -8);
		if($n<$start){
			if(substr($a, 0, 3)==110){
				$i+=1;
			}elseif(substr($a, 0, 4)==1110){
				$i+=2;
			}
			$n++;
		}else{
			if(substr($a, 0, 1)==0){
				$substr.=substr($str, $i, 1);
			}elseif(substr($a, 0, 3)==110){
				$substr.=substr($str, $i, 2);
				$i+=1;
			}elseif(substr($a, 0, 4)==1110){
				$substr.=substr($str, $i, 3);
				$i+=2;
			}else{
				$substr.='';
			}
			
			if(++$m>=$lenth){
				break;
			}
		}
	}
	return str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $substr);
}

function img_width_height($show_img_width, $show_img_height, $picpath, $echo_width_height=1){   //按比例缩小图片
	global $site_root_path;
	
	if(is_file($site_root_path.$picpath)){
		$img_info=getimagesize($site_root_path.$picpath); 
		$width=$img_info[0];
		$height=$img_info[1];
		
		if($width>$show_img_width){
			$ratio=$width/$show_img_width;
			$width=floor($width/$ratio);
			$height=floor($height/$ratio);
		}
		if($height>$show_img_height){
			$ratio=$height/$show_img_height;
			$width=floor($width/$ratio);
			$height=floor($height/$ratio);
		}
		if($echo_width_height==1){
			return "width='$width' height='$height'";
		}else{
			return array($width, $height);
		}
	}
	return '';
}

function down_file($filepath, $save_name=''){    //下载文件
	global $site_root_path;
	$filepath=$site_root_path.$filepath;
	
	if(is_file($filepath)){
		$save_name=='' && $save_name=basename($filepath);
		$file_size=@filesize($filepath);
		$file_handle=@fopen($filepath, 'r');
		
        header("Content-type: application/octet-stream; name=\"$save_name\"\n");
        header("Accept-Ranges: bytes\n");
        header("Content-Length: $file_size\n");
        header("Content-Disposition: attachment; filename=\"$save_name\"\n\n");
		
		while(!feof($file_handle)){
			echo fread($file_handle, 1024*100);
		}
		@fclose($file_handle);
	}else{
		js_location('/404.php');
	}
}

function mk_dir($dir){	//建立目录
	global $site_root_path;
	
	if($dir=='/'){
		return $dir;
	}elseif(is_dir($site_root_path.$dir)){
		@chmod($site_root_path.$dir, 0777);
		return $dir;
	}
	$arr_dir=@explode('/', $dir);
		
	for($i=0; $i<count($arr_dir); $i++){
		$base_dir=$site_root_path;
		for($j=0; $j<=$i; $j++){
			$base_dir.=$arr_dir[$j].'/';
		}
		
		if(!is_dir($base_dir)){
			@mkdir($base_dir, 0777);
			@chmod($base_dir, 0777);
		}
	}
	return $dir;
}

function up_file($up_file_name, $save_dir, $array_key=-1){	//上传文件
	global $site_root_path;
	mk_dir($save_dir);
	
	if($array_key==-1){
		$filename=$up_file_name['name'];
		$filepath=$up_file_name['tmp_name'];
	}else{
		$filename=$up_file_name['name'][$array_key];
		$filepath=$up_file_name['tmp_name'][$array_key];
	}
	$ext_name=get_ext_name($filename);
	$arr = array('php', 'php3', 'php4', 'bat', 'com', 'exe', 'dll', 'asp', 'asa', 'cgi', 'jsp');
	if(!in_array($ext_name, $arr)){
		$save_name=$save_dir.rand_code().'.'.$ext_name;
		@move_uploaded_file($filepath, $site_root_path.$save_name);
		@chmod($site_root_path.$save_name, 0777);
		return is_file($site_root_path.$save_name)?$save_name:'';
	}else{
		del_file($filepath);
		return '';
	}
}

function save_remote_img($html, $save_dir){	//保存远程图片，并自动按需要加水印
	global $site_root_path;
	$html=stripslashes($html);
	
	$img_array=array();
	preg_match_all("/src=[\"|'| ]{0,}(http:\/\/(.*)\.(gif|jpg|jpeg|png|bmp))/isU", $html, $img_array);
	$img_array=array_unique($img_array[1]);
	@set_time_limit(600);
	
	foreach($img_array as $key=>$remote_img_path){
		if(substr_count($remote_img_path, get_cfg('ly200.up_file_base_dir'))){
			continue;
		}
		
		$file_contents=@file_get_contents($remote_img_path);
		if($file_contents){
			$save_name=write_file($save_dir, rand_code().'.'.get_ext_name($remote_img_path), $file_contents);			
			get_cfg('ly200.img_add_watermark')==1 && img_add_watermark($save_name);
			$html=str_replace($remote_img_path, $save_name, $html);
		}
	}
	
	$html=addslashes($html);
	return $html;
}

function save_manage_log($log){	//添加后台管理日志
	global $db, $service_time;
	$db->insert('manage_log', array(
			'AdminUserName'	=>	addslashes($_SESSION['ly200_AdminUserName']),
			'PageUrl'		=>	addslashes($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']),
			'Ip'			=>	get_ip(),
			'LogContents'	=>	addslashes($log),
			'OpTime'		=>	$service_time
		)
	);
}

function write_file($save_dir, $save_name, $contents, $efbbbf=0){	//写文件
	global $site_root_path;
	
	mk_dir($save_dir);
	$fp=fopen($site_root_path.$save_dir.$save_name, 'w');
	@fwrite($fp, ($efbbbf==1?pack('H*', 'EFBBBF'):'').$contents);
	@fclose($fp);
	@chmod($site_root_path.$save_dir.$save_name, 0755);
	return $save_dir.$save_name;
}

function turn_page($page, $total_pages, $query_string, $row_count, $pre_page='<<', $next_page='>>', $html=0, $base_page=3){	//翻页
	if(!$row_count){
		return '';
	}
	
	if($html==1){
		$query_string='page-';
		$html_ext='.html';	//静态链接的后辍
	} 
	
	$i_start=$page-$base_page>0?$page-$base_page:1;
	$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
	
	($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
	$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
	
	$i_start<1 && $i_start=1;
	$i_end>=$total_pages && $i_end=$total_pages;
	
	$turn_page_str='';
	
	$pre=$page-1>0?$page-1:1;
	$turn_page_str.="<a href='$query_string$pre$html_ext' class='page_button'>$pre_page</a>&nbsp;";
	
	for($i=$i_start; $i<=$i_end; $i++){
		$turn_page_str.=$page!=$i?"<a href='{$query_string}{$i}{$html_ext}' class='page_item'>$i</a>&nbsp;":"<font class='page_item_current'>$i</font>&nbsp;";
	}
	
	$i_end<$total_pages && $turn_page_str.="<font class='page_item'>...</font>&nbsp;<a href='{$query_string}{$total_pages}{$html_ext}' class='page_item'>$total_pages</a>";
	
	$next=$page+1>$total_pages?$total_pages:$page+1;
	$page>=$total_pages && $page--;
	$turn_page_str.="<a href='$query_string$next$html_ext' class='page_button'>$next_page</a>";
	
	return $turn_page_str;
}

function del_img_from_html($html){
	$img_array=array();
	preg_match_all("/(src|SRC)=[\"|'| ]{0,}(\/u_file\/(.*)\.(gif|jpg|jpeg|png))/isU", $html, $img_array);
	$img_array=array_unique($img_array[2]);
	
	foreach($img_array as $key=>$value){
		if(substr_count(trim($value), get_cfg('ly200.up_file_base_dir'))){
			del_file(trim($value));
		}
	}
}

function sendmail($to, $to_name, $subject, $contents, $attache=''){	//发送邮件，最后一个参数为附件的URL地址，多个附件之间用|分隔开，同时多用户接收每个邮箱之前用“; ”分隔
	global $site_root_path, $mCfg;
	
	$data_ary=array(
		'domain'		=>	get_domain(0),
		'to'			=>	$to,
		'to_name'		=>	$to_name,
		'subject'		=>	$subject,
		'contents'		=>	$contents,
		'from'			=>	$mCfg['SendMail']['FromEmail'],
		'from_name'		=>	$mCfg['SendMail']['FromName'],
		'attache'		=>	$attache,
		'charset'		=>	'UTF-8',
		'smtpserver'	=>	$mCfg['SendMail']['Module']==1?$mCfg['SendMail']['Smtp']:'',
		'smtpserverport'=>	$mCfg['SendMail']['Module']==1?$mCfg['SendMail']['Port']:'',
		'smtpuser'		=>	$mCfg['SendMail']['Module']==1?$mCfg['SendMail']['Email']:'',
		'smtppass'		=>	$mCfg['SendMail']['Module']==1?$mCfg['SendMail']['Password']:'',
	);
	
	$values=array();
	foreach($data_ary as $key=>$value){
		$values[]="$key=".urlencode($value);
	}
	$data_string=implode('&', $values);
	
	$url_info=parse_url('http://oa.app.ly200.net/system/email/send.php');
	$result=post_data($url_info['host'], $url_info['path'], $data_string);
	
	include_once($site_root_path.'/inc/fun/encode.php');
	$chs=new iconver();
	return $chs->Convert($result, 'GBK', 'UTF8');
}
	require($site_root_path."/inc/fun/class.phpmailer.php");
	require($site_root_path."/inc/fun/class.smtp.php");    
    function smtp_mail( $sendto_email, $subject, $body, $extra_hdrs, $user_name){    
        $mail = new PHPMailer();    
        $mail->IsSMTP();                  // send via SMTP    
        $mail->Host = "smtp.qiye.163.com";   // SMTP servers    
        $mail->SMTPAuth = true;           // turn on SMTP authentication    
        $mail->Username = "service@eaglesell.com";     // SMTP username  注意：普通邮件认证不需要加 @域名    
        $mail->Password = "Eaglesell004"; // SMTP password    
        $mail->From = "service@eaglesell.com";      // 发件人邮箱    
        $mail->FromName =  "service@eaglesell.com";  // 发件人    

        $mail->CharSet = "GB2312";   // 这里指定字符集！    
        $mail->Encoding = "base64";    
        $mail->AddAddress($sendto_email,"username");  // 收件人邮箱和姓名    
        $mail->AddReplyTo("service@eaglesell.com","www.eaglesell.com");    
        //$mail->WordWrap = 50; // set word wrap 换行字数    
        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment 附件    
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    
        $mail->IsHTML(true);  // send as HTML    
        // 邮件主题    
        $mail->Subject = $subject;    
        // 邮件内容    
        $body = mb_convert_encoding($body,"GBK");
        $mail->Body = $body;                                                                          
        $mail->AltBody ="text/html";    
        if(!$mail->Send())    
        {    
            echo "邮件发送有误 <p>";    
            echo "邮件错误信息: " . $mail->ErrorInfo;    
            exit;    
        }    
        else {    
           // echo "zengwei 邮件发送成功!<br />";    
        }    
    }    
function post_data($host, $path, $data){	//用sock提交数据
	if($fp=@fsockopen($host, 80, $errno, $errstr, 8)){
		$start_time=time();
		stream_set_blocking($fp, 1);
		stream_set_timeout($fp, 5);
		
		fputs($fp, "POST $path HTTP/1.0\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ".strlen($data)."\r\n");
		fputs($fp, "User-Agent: MSIE\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $data);
		
		$result='';
		while(!feof($fp)){
			$result.=@fgets($fp, 1024);
			
			$diff=time()-$start_time;
			if($diff > 24){
				return 'Stream Timeout!';
			}
			$status=stream_get_meta_data($fp);
			if($status['timed_out']){
				return 'Stream Timeout!';
			}
		}
		@fclose($fp);
    	return $result;
	}else{
		return 'Connect Timeout!';
	}
}

function js_contents_code($str){
	return str_replace('\'', '\\\'', str_replace(array("\r\n", "\r", "\n"), '', ereg_replace('/[\s].*/gi', '', $str)));
}

function js_location($url, $alert='', $top=''){
	if($alert=='' && $top==''){
		header("Location: $url");
		exit;
	}
	
	echo '<script language="javascript">';
	if($alert){
		echo 'alert(\''.js_contents_code($alert).'\');';
	}
	echo "window{$top}.location='$url';";
	echo '</script>';
	exit;
}

function js_back($alert=''){
	echo '<script language="javascript">';
	if($alert){
		echo 'alert(\''.js_contents_code($alert).'\');';
	}
	echo 'history.back();';
	echo '</script>';
	exit;
}

function lang_to_jsLangObj($variables){	//语言包由PHP转换成Js对象
	foreach($variables as $key=>$value){
		if(is_array($value)){
			echo '_'.$key.':{';
			lang_to_jsLangObj($variables[$key]);
			echo '\'about\':\'http://www.ly200.com/\'},';
		}else{
			echo '_'.$key.':\''.js_contents_code($value).'\',';
		}
	}
}

function lang_name($key, $v){	//返回语言版本名称或语言版本扩展字段名
	if(count(get_cfg('ly200.lang_array'))==1){
		return '';
	}
	if($v==0){	//返回语言版本名称
		return '('.get_lang('ly200.lang_array.'.get_cfg('ly200.lang_array.'.$key)).')';
	}else{	//返回语言版本扩展字段名
		return $key==0?'':'_'.get_cfg('ly200.lang_array.'.$key);
	}
}

function output_language_select($selected_lang=-1, $output_index=0, $index_value=''){	//输出语言下拉列表框
	$str='<select name="Language">';
	if($output_index==1){
		$str.="<option value=''>--$index_value--</option>";
	}
	for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){
		$selected=$selected_lang==$i?'selected':'';
		$str.="<option value='$i' $selected>".get_lang('ly200.lang_array.'.get_cfg('ly200.lang_array.'.$i)).'</option>';
	}
	$str.='</select>';
	return $str;
}

function list_all_lang_data($var, $field, $sp='/'){	//列出同一字段下所有语言版本的数据
	$str='';
	for($i=0; $i<count(get_cfg('ly200.lang_array')); $i++){
		$f=$i==0?'':'_'.get_cfg('ly200.lang_array.'.$i);
		$str.=$var[$field.$f];
		$i<count(get_cfg('ly200.lang_array'))-1 && $str.="<font class='fc_red'>$sp</font>";
	}
	return $str;
}

function query_string($un=''){	//组织url参数
	!is_array($un) && $un=array($un);
	if($_SERVER['QUERY_STRING']){
		$q=@explode('&', $_SERVER['QUERY_STRING']);
		$v='';
		for($i=0; $i<count($q); $i++){
			$t=@explode('=', $q[$i]);
			if(in_array($t[0], $un)){
				continue;
			}
			$v.=$t[0].'='.urlencode(urldecode($t[1])).'&';
		}
		$v=substr($v, 0, -1);
		$v=='=' && $v='';
		return $v;
	}else{
		return '';
	}
}

function get_lang($str){	//获取语言包变量值
	global $Ly200Lang;
	return eval('return $Ly200Lang[\''.str_replace('.', '\'][\'', $str).'\'];');
}

function get_cfg($str){	//获取配置文件变量值
	global $Ly200Cfg;
	return eval('return $Ly200Cfg[\''.str_replace('.', '\'][\'', $str).'\'];');
}

function creat_imgLink_by_sImg($img, $width=0, $height=0){	//按照小图片的路径，创建一个打开大图的链接
	global $site_root_path;
	if(!is_file($site_root_path.$img)){
		return '';
	}
	$str='<a href="'.str_replace('s_', '', $img).'" target="_blank"><img src="'.$img.'"';
	$width && $str.="width='$width'";
	$height && $str.="height='$height'";
	$str.='></a>';
	return $str;
}

function ouput_table_to_input($table, $key, $value, $input_name, $order, $exp_mode=1, $where=1, $input_type='checkbox', $checked=''){	//输出数据表的数据为多选框或单选框
	global $db;
	$checked_ary=@explode('|', $checked);
	$html='';
	$row=$db->get_all($table, $where, '*', $order);
	for($i=0; $i<count($row); $i++){
		$check=in_array($row[$i][$key], $checked_ary)?'checked':'';
		$html.="<div class='d0'><div class='d1'><input type='$input_type' name='$input_name' value='{$row[$i][$key]}' $check>".($exp_mode==1?list_all_lang_data($row[$i], $value):$row[$i][$value]).'</div></div>';
	}
	return $html;
}

function ouput_table_to_select($table, $key, $value, $select_name, $order, $exp_mode=1, $where=1, $selected='', $index_key='', $index_value='', $check=''){	//输出数据表的数据为下拉列表
	global $db;
	$check && $check="check='$check'";
	$html="<select name='$select_name' $check>";
	($index_key || $index_value) && $html.="<option value='$index_key'>--$index_value--</option>";
	$row=$db->get_all($table, $where, '*', $order);
	for($i=0; $i<count($row); $i++){
		$select=$selected==$row[$i][$key]?'selected':'';
		$html.="<option value='{$row[$i][$key]}' $select>".($exp_mode==1?str_replace('/', ' / ', strip_tags(list_all_lang_data($row[$i], $value))):$row[$i][$value]).'</option>';
	}
	$html.='</select>';
	return $html;
}

function add_lang_field($table, $columns_ary){	//添加语言版本对应的字段
	global $db;
	!is_array($columns_ary) && $columns_ary=array($columns_ary);
	$columns_name=$columns_info=array();
	$columns=$db->show_columns($table, 0);
	for($i=0; $i<count($columns); $i++){
		$columns_name[$i]=$columns[$i]['Field'];
		$columns_info[$columns_name[$i]]=$columns[$i];
	}
	for($i=0; $i<count($columns_ary); $i++){
		for($j=count(get_cfg('ly200.lang_array'))-1; $j>0; $j--){
			$field=$columns_ary[$i].'_'.get_cfg('ly200.lang_array.'.$j);
			if(!in_array($field, $columns_name)){	//字段不存在
				$pre_field=$columns_ary[$i];
				for($k=1; $k<count(get_cfg('ly200.lang_array')); $k++){
					$tmp_field=$columns_ary[$i].'_'.get_cfg('ly200.lang_array.'.$k);
					in_array($tmp_field, $columns_name) && $pre_field=$tmp_field;
				}
				$db->query("alter table $table add $field {$columns_info[$columns_ary[$i]]['Type']} after $pre_field");
			}
		}
	}
}

function creat_download_link($download_row, $value='点击下载'){	//下载中心，创建下载的链接
	global $site_root_path;
	if(is_file($site_root_path.$download_row['FilePath'])){	//文件在本地服务器
		return "<a href='/inc/lib/download/download.php?DId={$download_row['DId']}'>$value</a>";
	}else{
		return "<a href='{$download_row['FilePath']}'>$value</a>";
	}
}

function get_ip(){	//浏览者IP
	if($_SERVER['HTTP_X_FORWARDED_FOR']){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}elseif($_SERVER['HTTP_CLIENT_IP']){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return preg_match('/^[\d]([\d\.]){5,13}[\d]$/', $ip)?$ip:'';
}

function get_domain($protocol=1){	//获取网站域名
	return ($protocol==1?((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://'):'').$_SERVER['HTTP_HOST'].($_SERVER['SERVER_PORT']!=80?':'.$_SERVER['SERVER_PORT']:'');
}

function file_size_format($size){	//格式化文件大小
	$size_unit=array('B', 'KB', 'MB', 'GB', 'TB');
	for($i=0; $i<count($size_unit); $i++){
		if($size>=pow(2, 10*$i)-1){
			$size_unit_str=(ceil($size/pow(2,10*$i)*100)/100).$size_unit[$i];
		}
	}
	return $size_unit_str;
}

function format_post_value($txt, $no_rn=1){	//格式化post值，方便存入php文件中
	$txt=str_replace(array('\\', '\''), array('\\\\', '\\\''), stripslashes($txt));
	$no_rn==1 && $txt=str_replace("\r\n", ' ', $txt);
	return $txt;
}

function seo_meta($SeoTitle='', $SeoKeywords='', $SeoDescription=''){	//前台页面输出标题标签
	global $mCfg;
	$SeoTitle=htmlspecialchars($SeoTitle?$SeoTitle:$mCfg['SeoTitle']);
	$SeoKeywords=htmlspecialchars($SeoKeywords?$SeoKeywords:$mCfg['SeoKeywords']);
	$SeoDescription=htmlspecialchars($SeoDescription?$SeoDescription:$mCfg['SeoDescription']);
	return "<meta name=\"keywords\" content=\"$SeoKeywords\" />\r\n<meta name=\"description\" content=\"$SeoDescription\" />\r\n<title>$SeoTitle</title>\r\n";
}

function js_code(){	//加载Js代码
	global $mCfg;
	return $mCfg['JsCode'];
}

function password($password){	//密码加密
	$password=md5($password);
	$password=substr($password, 0, 5).substr($password, 10, 20).substr($password, -5).'www.ly200.com';
	return md5($password.$password);
}

function move_to_other_category($table, $CateId, $where){	//移动分类
	global $db, $site_root_path;
	
	$path=substr($db->get_value($table.'_category', "CateId='$CateId'", 'PageUrl'), 0, -1);
	$path=='' && $path='/info';
	mk_dir($path.'/');
	
	$row=$db->get_all($table, $where, 'PageUrl');
	for($i=0; $i<count($row); $i++){
		@rename($site_root_path.$row[$i]['PageUrl'], $site_root_path.str_replace(dirname($row[$i]['PageUrl']), $path, $row[$i]['PageUrl']));
	}
	
	$db->query("update $table set CateId='$CateId', PageUrl=replace(PageUrl, substring_index(PageUrl, '/' ,length(PageUrl)-length(replace(PageUrl, '/', ''))), '$path') where $where");
}

function set_page_url($table, $where, $field, $table_type=0, $has_category_table=1, $add_row_id=1){	//静态路径计算，$table_type=0：类别表，1：内容表，2：其他表，存文件夹名
	global $db, $site_root_path;
	
	$rs=$db->query("select * from $table where $where");
	$row=mysql_fetch_array($rs);
	$TB=$table_type==0?str_replace('_category', '', $table):$table;	//类别表对应的内容表
	
	if($table_type==0){	//类别表
		$path=str_to_url($row[$field]);
		if($row['UId']!='0,'){	//非顶级类
			$CateId=get_CateId_by_UId($row['UId']);	//上一级的CateId
			$path=$db->get_value($table, "CateId='$CateId'", 'PageUrl').($path?$path:$row[0]).'/';
		}else{
			$path=$path!=''?"/$path/":("/$TB/".($has_category_table==1?$row['CateId'].'/':''));
		}
		$page='';
	}elseif($table_type==1){
		if($has_category_table==1){	//有对应的分类表，则去分类表里读取目录路径
			$path=$db->get_value($table.'_category', "CateId='{$row['CateId']}'", 'PageUrl');
			$path=='' && $path="/$TB/";
		}else{
			$path='/';
		}
		$page=str_to_url($row[$field]);
		if($page!='' && $page!='index'){
			$page=$add_row_id==1?"{$page}-{$row[0]}.html":"$page.html";
		}else{
			$path=='/' && $path="/$TB/";
			$page="{$row[0]}.html";
		}
	}else{
		$path=str_to_url($row[$field]);
		if(substr_count($TB, '_')){
			$t=explode('_', $TB);
			$d=$t[1];
		}else{
			$d=$TB;
		}
		$path=$path!=''?"/$d/$path/":"/$d/{$row[0]}/";
		$page='';
	}
	$path=str_replace(system_dir(), "/$TB/", $path);
	
	if($path.$page!=$row['PageUrl']){
		if($table_type==0){	//类别表
			@rename($site_root_path.substr($row['PageUrl'], 0, -1), $site_root_path.substr($path, 0, -1));
			$w=get_search_where_by_CateId($row['CateId'], $table);
			$db->query("update $table set PageUrl=replace(PageUrl, '{$row['PageUrl']}', '$path') where $w");
			$db->query("update $TB set PageUrl=replace(PageUrl, '{$row['PageUrl']}', '$path') where $w");
		}elseif($table_type==1){
			if(is_file($site_root_path.$row['PageUrl'])){
				mk_dir($path);
				@rename($site_root_path.$row['PageUrl'], $site_root_path.$path.$page);	//移动旧文件到新文件夹
			}
		}else{
			@rename($site_root_path.substr($row['PageUrl'], 0, -1), $site_root_path.substr($path, 0, -1));
		}
		
		$db->update($table, $where, array(
				'PageUrl'	=>	$path.$page
			)
		);
	}
}

function str_to_url($str){	//字符串转换成合法的url路径
	$url=strtolower(trim($str));
	$url=str_replace(array(' ', '/'), '-', $url);
	$url=str_replace(array('`','~','!','@','#','$','%','^','&','*','(',')','_','=','+','[','{',']','}',';',':','\'','"','\\','|','<',',','.','>','?',"\r","\n","\t"), '', $url);
	$url=preg_replace('/[^\x00-\x7F]+/', '', $url);	//去掉中文
	$url=preg_replace('/-{2,}/', '-', $url);
	!eregi('^[a-z]', $url) && $url='';
	return $url;
}

function system_dir(){	//系统文件夹
	return array('/_export_excel/', '/_mysql_backup/', '/_paypal_log/', '/css/', '/iepng/', '/images/', '/inc/', '/js/', '/manage/', '/u_file/');
}

function exchange_rate_select($select_name='Currency', $selected=''){	//币种选择下拉框
	global $mCfg;
	$selected=='' && $selected=$mCfg['ExchangeRate']['Default'];
	
	$str="<select name='$select_name'>";
	foreach($mCfg['ExchangeRate'] as $key=>$value){
		if(is_array($value)){
			if($value['Invocation']==1){
				$s=$key==$selected?'selected':'';
				$str.="<option value='$key' $s>$key</option>";
			}
		}
	}
	$str.='</select>';
	return $str;
}

function iconv_price($price, $method=0){	//币种转换
	global $mCfg;
	
	if($method==0){
		return $mCfg['ExchangeRate'][$_SESSION['Currency']]['Symbols'].sprintf('%01.2f', $price*$mCfg['ExchangeRate'][$_SESSION['Currency']]['Rate']);
	}elseif($method==1){
		return $mCfg['ExchangeRate'][$_SESSION['Currency']]['Symbols'];
	}else{
		return sprintf('%01.2f', $price*$mCfg['ExchangeRate'][$_SESSION['Currency']]['Rate']);
	}
}

function price_list($price){	//列出所有价格，用于静态页面
	global $mCfg;
	
	foreach($mCfg['ExchangeRate'] as $key=>$value){
		if(is_array($value) && $value['Invocation']==1){
			echo "<font class='price_item_{$key}'>".$value['Symbols'].sprintf('%01.2f', $price*$value['Rate']).'</font>';
		}
	}
}

function update_orders_shipping_info($OrderId, $Express='', $UpdateShippingPrice=1){	//更新订单的运费相关资料
	global $db, $order_product_weight;
	
	$order_row=$db->get_one('orders', "OrderId='$OrderId'");
	
	$Express=='' && $Express=addslashes($order_row['Express']);
	$ShippingCountry=addslashes($order_row['ShippingCountry']);
	
	$SId=$db->get_value('shipping', "Express='$Express'", 'SId');	//获取送货方式的ID
	$CId=$db->get_value('country', "Country='$ShippingCountry'", 'CId');	//获取国家的ID
	$shipping_price_row=$db->get_one('shipping_price', "SId='$SId' and CId='$CId'");
	
	if($UpdateShippingPrice==1){	//需要更新订单的运费
		$shipping_method_row=$db->get_one('shipping', "SId='$SId'");
		if($shipping_method_row['FreeShippingInvocation']==1 && $order_row['TotalPrice']>=$shipping_method_row['FreeShippingPrice']){
			$shipping_price=0;
		}else{
			if($order_product_weight==1){	//按重量计算运费
				$total_weight=$db->get_value('orders', "OrderId='$OrderId'", 'TotalWeight');	//商品总重量
				$ExtWeight=$total_weight>$shipping_price_row['FirstWeight']?$total_weight-$shipping_price_row['FirstWeight']:0;	//超出的重量
				$shipping_price=(float)(@ceil($ExtWeight/$shipping_price_row['ExtWeight'])*$shipping_price_row['ExtPrice']+$shipping_price_row['FirstPrice']);
			}else{
				$shipping_price=$shipping_price_row['FirstPrice'];
			}
		}
	}else{	//不需要更新订单的运费
		$shipping_price=$db->get_value('orders', "OrderId='$OrderId'", 'ShippingPrice');
	}
	
	$db->update('orders', "OrderId='$OrderId'", array(
			'Express'		=>	$Express,
			'ShippingPrice'	=>	(float)$shipping_price,
			'FirstPrice'	=>	(float)$shipping_price_row['FirstPrice'],
			'FirstWeight'	=>	(float)$shipping_price_row['FirstWeight'],
			'ExtWeight'		=>	(float)$shipping_price_row['ExtWeight'],
			'ExtPrice'		=>	(float)$shipping_price_row['ExtPrice']
		)
	);
}

function pro_add_to_cart_price($pro_row, $Qty){	//加入购物车时的价格
	global $db;
	
	if($pro_row['IsSpecialOffer']==1){	//特价优先
		return $pro_row['SpecialOfferPrice'];
	}else{
		$wholesale_row=$db->get_one('product_wholesale_price', "ProId='{$pro_row['ProId']}' and Qty<=$Qty", '*', 'Qty desc');	//看看是否有批发价
		if($wholesale_row){
			return $wholesale_row['Price'];
		}else{
			return $pro_row['Price_1'];
		}
	}
}

function get_url($mode,$row){
	global $website_url_type,$website_url_ary;
	if($mode=='info' && $row['ExtUrl']!=''){
		return $row['ExtUrl'];
	}
	
	if($website_url_type==0){
		$mode=='article' && $mode.='_group_'.$row['GroupId'];
		return eval($website_url_ary[$mode]);
	}elseif($website_url_type==1){
		return $row['PageUrl'];
	}else{
		$v=explode('_', $mode);
		$row['PageUrl']=str_replace("/$v[0]/", '/', $row['PageUrl']);
		$v[0]='/'.$v[0];
		$v[0]=='/product' && $v[0].='s';
		($v[0]=='/article' || $v[0]=='/info') && $v[0]='';
		if($v[1]=='category'){
			return "{$v[0]}{$row['PageUrl']}".($mode=='info_category'?'':"c-{$row['CateId']}/");
		}else{
			return "{$v[0]}{$row['PageUrl']}";
		}
	}
}

function check_permit_act_value($cfg, $permit_act_ary){	//检查配置文件当前值是否需要重新载入权限
	for($i=0; $i<count($permit_act_ary); $i++){
		if($cfg[$permit_act_ary[$i]]==1){
			return true;
		}
	}
	return false;
}

function attr_all($CateId){
	global $db;
	$cate_row=$db->get_one('product_category',"CateId = '$CateId'");
	if($cate_row['UId']=='0,'){
		$TopCateId=	$cate_row['CateId'];
	}else{
		$TopCateId=get_top_CateId_by_UId($cate_row['UId']);
	}
	$TopCate_row=$db->get_one('product_category',"CateId='$TopCateId'");
	$param_row=$db->get_all('param',"CateId='{$TopCate_row['PIdCateId']}'");	
	return $param_row;
}

class Descartes{
	public $sourceArray;
	public $resultArray;

	public function __construct($array, $result)
	{
		$this->sourceArray = $array;
		$this->resultArray = $result;
	}

	public function calcDescartes($arrIndex, $arrResult)
	{
		if ($arrIndex >= count($this->sourceArray)) {
			array_push($this->resultArray, $arrResult);
			return ;
		}

		$currentArray = $this->sourceArray[$arrIndex];
		$currentArrayCount = count($currentArray);
		$arrResultCount = count($arrResult);

		for ($i = 0; $i < $currentArrayCount; ++$i) {
			$currentArraySlice = array_slice($arrResult, 0, $arrResultCount);
			array_push($currentArraySlice, $currentArray[$i]);
			$this->calcDescartes($arrIndex + 1, $currentArraySlice);
		}
	}

};
function json_data($data, $action='encode'){	//json数据编码
	if($action=='encode'){
		if(!function_exists('unidecode')){
			function unidecode($match){
				return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
			}
		}
		return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', json_encode($data));
	}else{
		return (array)json_decode($data, true);
	}
}
function pro_add_to_cart_price_ext($pro_row, $Qty,$PId='0',$ParamPrice='0'){	//加入购物车时的价格
	global $db;
	
	if($pro_row['IsPromotion']==1 && $pro_row['StartTime']<time() && $pro_row['EndTime']>time()){	//限时抢购
		return $pro_row['Price_1'];
	}else{
		$wholesale_row=$db->get_one('product_wholesale_price', "ProId='{$pro_row['ProId']}' and Qty<=$Qty", '*', 'Qty desc');	//看看是否有批发价
		if($wholesale_row){
			return $wholesale_row['Price'];
		}else{
			if( (int)$_SESSION['member_MemberId'] ){
				return $pro_row['Price_1'];
			}else{
				return $pro_row['Price_0'];
			}
		}
	}
}

function check_login(){
	if(!$_SESSION['member_MemberId'] || !$_SESSION['member_Email']){
		js_location("/account.php?moudle=login",'Please Login!');
	}	
}
function range_price_ext($row,$Level=0,$reprice=0,$method=0){
	global $db;
	
	$data=array();
	$is_promition=($row['IsPromotion'] && $row['StartTime']<time()&& time()<$row['EndTime'])?1:0;
	$wholesale_price=$db->get_all('product_wholesale_price',"ProId ='{$row['ProId']}'");
	
	if((int)$is_promition){//抢购价格
		$data[0]=($row['Price_1']+$reprice)*(100-$row['Discount'])/100;
		$data[1]=$row['Price_1']+$reprice;
	}elseif(count($wholesale_price)){//批发价格
		$CurPrice=$row['Price_1']+$reprice;
		$minPrice=$CurPrice;
		$maxPrice=$row['Price_0']+$reprice;
		
		foreach((array)$wholesale_price as $k=>$v){
			if($maxPrice<$v['Price']){
				$maxPrice=$v['Price']+$reprice;;
			}
			if($minPrice>(float)$v['Price']){
				$minPrice=$v['Price']+$reprice;;
			}
		};
		$CurPrice>$maxPrice && $maxPrice=$CurPrice;
		$CurPrice<$minPrice && $minPrice=$CurPrice;
		
		$data=array(
			0	=>	$minPrice,
			1	=>	$maxPrice
		);
	}elseif($Level){//会员价格
		$member_discount=0;
		$member_discount=$db->get_value('member_level',"LId = '$Level'",'Discount');
		$data[0]=($row['Price_1']+$reprice)*(100-$member_discount)/100;
		$data[1]=$row['Price_0']+$reprice;
	}else{
		$data[0]=$row['Price_1']+$reprice;
		$data[1]=$row['Price_0']+$reprice;
	}
	
	return $data;
}

function get_web_position($row, $table,$char=' &gt; '){	//面包屑地址
	global $db;
	global $lang;
	$str='';
	$UId=trim($row['UId'], ',');
	if($UId=='0'){
		$str.=$char."<a href='".get_url($table,$row)."'>{$row['Category'.$lang]}</a>";  
	}
	if($UId){
		$all_row=str::str_code($db->get_all($table, "CateId in($UId)", '*','Dept asc'));	
		$i=0;
		foreach((array)$all_row as $v){
			$str.=($i==0?$char:'')."<a href='".get_url($table,$v)."'>{$v['Category'.$lang]}</a>".$char;
			$i+=1;
		}
		$str.="<a href='".get_url($table,$row)."'>{$row['Category'.$lang]}</a>";
	}
	return $str;
}

function supplier_get_web_position($row, $table,$char=' &gt; ', $url_table='product_category',$SupplierId=''){	//面包屑地址
	global $db;
	global $lang;
	$str='';
	$UId=trim($row['UId'], ',');
	$row['SupplierId'] = $SupplierId;
	if($UId=='0'){
		$str.=$char."<a href='".get_url($url_table,$row)."'>".$row['Category'.$lang]."</a>";  
	}
	if($UId){
		$all_row=str::str_code($db->get_all($table, "CateId in($UId)", '*','Dept asc'));	
		$i=0;
		foreach((array)$all_row as $v){
			$v['SupplierId'] = $SupplierId;
			$str.=($i==0?$char:'')."<a href='".get_url($url_table,$v)."'>".$v['Category'.$lang]."</a>".$char;
			$i+=1;
		}
		$str.="<a href='".get_url($url_table,$row)."'>".$row['Category'.$lang]."</a>";
	}
	return $str;
}
function supplier_get_web_position2($row, $table,$char=' &gt; ', $url_table='product_category',$SupplierId=''){	//面包屑地址
	global $db;
	global $lang;
	$str='';
	$UId=trim($row['UId'], ',');
	$row['SupplierId'] = $SupplierId;
	if($UId=='0'){
		$str.="<span>".$row['Category'.$lang]."</span>";  
	}
	if($UId){
		$all_row=str::str_code($db->get_all($table, "CateId in($UId)", '*','Dept asc'));	
		$i=0;
		foreach((array)$all_row as $v){
			$v['SupplierId'] = $SupplierId;
			$str.="<span>".$v['Category'.$lang]."</span>".$char;
			$i+=1;
		}
		$str.="<span>".$row['Category'.$lang]."</span>";
	}
	return $str;
}
function ouput_Category_to_Array_hill($TB='product_category', $field='*', $where='UId="0,"', $ext_where=1){	//把类别表输出到一个数组，$field中UId为必须
	global $db;
	
	$cate_ary=array();
	$cate_row=$db->get_all($TB, $where, $field, 'MyOrder desc, CateId asc');
	ouput_Category_to_Array_hillchan($cate_row, $TB, $field, $ext_where, 0, '', $cate_ary);
	
	return $cate_ary;
}

function ouput_Category_to_Array_hillchan($cate_row, $TB, $field, $ext_where, $layer, $PreChars, &$cate_ary){	//递归循环输出类别到数组
	global $db;
	
	$row_count=count($cate_row);
	for($i=0; $i<$row_count; $i++){
		$cate_row[$i]['PreChars']=str_replace(' ', '&nbsp;', $PreChars.($i+1==$row_count?'':''));
		$cate_ary[]=$cate_row[$i];
		
		if($cate_row_ext=$db->get_all($TB, "UId='{$cate_row[$i]['UId']}{$cate_row[$i]['CateId']},' and $ext_where", $field, 'MyOrder desc, CateId asc')){
			$PreChars.=$i+1==$row_count?'':'';   //前导符
			$layer++;
			ouput_Category_to_Array_hillchan($cate_row_ext, $TB, $field, $ext_where, $layer, $PreChars, $cate_ary);
			$PreChars=substr($PreChars, 0, -3);
			$layer--;
		}
	}
} 
function turn_top_page($page, $total_pages, $query_string, $row_count, $pre_page='<<', $next_page='>>', $html=0, $base_page=3){ //翻页
	if(!$row_count){
		return '';
	}
	
	if($html!=0){
		$query_string='page-';
		$html_ext='.html';	//静态链接的后辍
	}
	
	$i_start=$page-$base_page>0?$page-$base_page:1;
	$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
	
	($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
	$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
	
	$i_start<1 && $i_start=1;
	$i_end>=$total_pages && $i_end=$total_pages;
	
	$turn_page_str='';
	
	$pre=$page-1>0?$page-1:1;
	$turn_page_str.="<a href='$query_string$pre$html_ext' class='page_button first'>$pre_page</a>";

	$turn_page_str.='<span class="page_item">'.$page.'/'.$total_pages.'</span>';
	
	$next=$page+1>$total_pages?$total_pages:$page+1;
	$page>=$total_pages && $page--;
	$turn_page_str.="<a href='$query_string$next$html_ext' class='page_button last'>$next_page</a>";
	
	return $turn_page_str;
}

function turn_bottom_page($page, $total_pages, $query_string, $row_count, $pre_page='<<', $next_page='>>', $html=0, $base_page=3){ //翻页
	if(!$row_count){
		return '';
	}
	
	if($html!=0){
		$query_string='page-';
		$html_ext='.html';	//静态链接的后辍
	}
	
	$i_start=$page-$base_page>0?$page-$base_page:1;
	$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
	
	($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
	$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
	
	$i_start<1 && $i_start=1;
	$i_end>=$total_pages && $i_end=$total_pages;
	
	$turn_page_str='';
	
	$pre=$page-1>0?$page-1:1;
	$turn_page_str.="<a href='$query_string$pre$html_ext' class='page_button first'>$pre_page</a>";
	
	for($i=$i_start; $i<=$i_end; $i++){
		$turn_page_str.=$page!=$i?"<a href='{$query_string}{$i}{$html_ext}' class='page_item'>$i</a>":"<font class='page_item_current'>$i</font>";
	}
	
	$i_end<$total_pages && $turn_page_str.="<font class='page_item'>...</font>&nbsp;<a href='{$query_string}{$total_pages}{$html_ext}' class='page_item'>$total_pages</a>";
	
	
	$next=$page+1>$total_pages?$total_pages:$page+1;
	$page>=$total_pages && $page--;
	$turn_page_str.="<a href='$query_string$next$html_ext' class='page_button last'>$next_page</a>";
	
	return $turn_page_str;
}
function turn_bottom_page1($page, $total_pages, $query_string, $row_count, $pre_page='<<', $next_page='>>', $html=0, $base_page=3){ //翻页
	global $db,$lang,$website_language;
	if(!$row_count){
		return '';
	}
	
	if($html!=0){
		$query_string='page-';
		$html_ext='.html';	//静态链接的后辍
	}
	
	$i_start=$page-$base_page>0?$page-$base_page:1;
	$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
	
	($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
	$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
	
	$i_start<1 && $i_start=1;
	$i_end>=$total_pages && $i_end=$total_pages;
	
	$turn_page_str='';
	
	$pre=$page-1>0?$page-1:1;
	$turn_page_str.="<a href='$query_string$pre$html_ext' class='page_button first'>$pre_page</a>";
	
	for($i=$i_start; $i<=$i_end; $i++){
		$turn_page_str.=$page!=$i?"<a href='{$query_string}{$i}{$html_ext}' class='page_item'>$i</a>":"<font class='page_item_current'>$i</font>";
	}
	
	$i_end<$total_pages && $turn_page_str.="<font class='page_item'>...</font><a href='{$query_string}{$total_pages}{$html_ext}' class='page_item'>$total_pages</a>";
	
	
	$next=$page+1>$total_pages?$total_pages:$page+1;
	$act = $website_language['ylfy'.$lang]['tzd'];
	//var_dump($act);exit;
	$page>=$total_pages && $page--;
	$turn_page_str.="<a href='$query_string$next$html_ext' class='page_button last'>$next_page</a>";
	$turn_page_str.="&nbsp;&nbsp;".$act."&nbsp;&nbsp;<input style='width:28px;height:28px;border:1px solid #ccc;text-align:center;border-radius:3px' name='page_input' value='".$start_row."' type='text'>页";
	return $turn_page_str;
}


function get_price_control($row){
	global $db, $service_time;
	$v=$row['Price_1'];
	if($row['LimitControl'] && $row['Deadline']>$service_time){
		$v=$row['Price_1']*(1-$row['Discount']/100);
	}
	
	return sprintf('%01.2f',$v);
}

function ouput_Category_to_Select_to($select_name='CateId', $selected_CateId='', $TB='product_category', $where='UId="0,"', $ext_where=1, $select_value='', $js=''){	//把类别表输出成一个select表单
	global $db;
	
	ob_start();
	echo "<select id='$select_name' name='$select_name' onchange='$js'>";
	$selected=$selected_CateId==''?'selected':'';
	echo "<option value='' $selected>--$select_value--</option>";
	
	$cate_row=$db->get_all($TB, $where, 'UId,CateId,Category', 'MyOrder desc, CateId asc');
	ouput_Category_to_Select_ext($cate_row, $selected_CateId, $TB, 0, '', $ext_where);
	echo '</select>';
	
	$select=ob_get_contents();
	ob_end_clean();
	return $select;
}


if($mCfg['ChinaIP']){
	$prov="北京/浙江/天津/安徽/上海/福建/重庆/江西/山东/河南/内蒙古/湖北/新疆维吾尔/湖南/宁夏回族/广东/西藏/海南/广西壮族/四川/河北/贵州/山西/云南/辽宁/陕西/吉林/甘肃/黑龙江/青海/江苏";
	include($site_root_path.'/inc/fun/ip_to_area_ext.php');
	$area=ip_to_area_ext(get_ip());
	((int)$_SESSION['ly200_AdminUserId']==0 && substr_count($_SERVER['PHP_SELF'], '/manage/')==0 && substr_count($prov,substr($area['country'],0,6))>0) && js_location('/404.php', '', '.top');
}

//更新网站浏览次数
function update_web_views(){
	global $service_time,$db; 
	
	$start=date('Y-m-d',$service_time);
	$start=strtotime($start);
	$end_time=$start+86400-1;
	$end=date('Y-m-d H:i:s',$end_time);

	if(!(int)$_SESSION['site_view']){
		$_SESSION['site_view']=1;
	}else{
		return false;			
	}
	$row=$db->get_one('site_view',"Time >=$start and Time<=$end_time");
	if($row){
		$db->update('site_view'," Time >=$start and Time<=$end_time".$where,array('Views'=>(int)$row['Views']+1));
	}else{
		$db->insert('site_view',array('Time'=>$start,'Views'=>1));
	}
}
//update_web_views();
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

class where{
	public static function equal($data){
		$w='';
		foreach($data as $k=>$v){
			if((!is_array($v) && $v!='') || (is_array($v) && $v[0]!='')){
				is_array($v) && $v=$v[0];
				$w.=" and $k='$v'";
			}
		}
		if($w){return $w;}
	}
	
	public static function keyword($keyword, $field){
		if(!$keyword){return;};
		$w=array();
		foreach($field as $v){
			if(is_array($v)){
				$w[]="{$v[0]} like '%,$keyword,%'";
			}else{
				$w[]="$v like '%$keyword%'";
			}
		}
		$w=str::ary_format($w, 3);
		return " and ($w)";
	}
	
	public static function time($time, $field=''){	//时间范围
		if(!$time){return;};
		$t=@explode('/', $time);
		$ts=@strtotime($t[0]);
		$te=@strtotime($t[1])+86399;
		return $field?" and $field between $ts and $te":array($ts, $te);
	}
	
	public static function price($price){
		global $c,$service_time;
		if(!$price){return;};
		$price_range=explode('-', $price);
		if(is_numeric($price_range[0]) && is_numeric($price_range[1]) && $price_range[0]<$price_range[1]){
			$w=" and ((Price_1 between {$price_range[0]} and {$price_range[1]}) or (IsPromotion=1 and StartTime<='$service_time' and EndTime>='$service_time'))";
			return array($w, $price_range);
		}
		return;
	}
	
	public static function product($PriceRange, $Narrow){
		global $c;
		$Column='';
		$price_range=array();
		$Narrow_ary=array();
		$where='1';
		//if($PriceRange) $where.=where::price($PriceRange);
		if($PriceRange){
			$priceAry=where::price($PriceRange);
			if(is_array($priceAry)){
				$where.=$priceAry[0];
				$price_range=$priceAry[1];
			}
		}
		if(!substr_count($_SERVER['REQUEST_URI'], '/products.php')){//产品搜索无筛选
			$Keyword=$_GET['Keyword'];
			$where.=where::keyword($Keyword, array("Name{$c['lang']}", 'concat(Prefix, Number)'));
			$Column='%s-%s of %s Items for "'.$Keyword.'"';
		}else{
			//echo 123;
			//exit;
			if($Narrow){
				$Narrow_ary=explode('+', $Narrow);
				$arr=array();
				$v_ary=array();
				$narrow_where=' and ';
				foreach((array)$Narrow_ary as $k=>$v){
					$v_ary=explode('.', $v);
					$arr[$v_ary[0]][]=$v_ary[1];
				}
				$i=0;
				foreach((array)$arr as $k=>$v){
					$narrow_where.=($i?' and ':'')."Attr REGEXP '\"{$k}\":\[[0-9\,\"]*\"(";
					foreach((array)$v as $k2=>$v2){
						$narrow_where.=($k2?'|':'').$v2;
					}
					$narrow_where.=")\"[0-9\,\"]*\]'";
					++$i;
				}
				$narrow_where!=' and ' && $where.=$narrow_where;
				unset($v_ary, $arr);
			}
		}
		return array($where, $Column, $price_range, $Narrow_ary);
	}
}
class str{
	public static function str_code($data, $fun='htmlspecialchars'){	//文本编码
		if(!is_array($data)){
			return $fun($data);
		}
		$new_data=array();
		foreach((array)$data as $k=>$v){
			if(is_array($v)){
				$new_data[$k]=str::str_code($v, $fun);
			}else{
				$new_data[$k]=$fun($data[$k]);
			}
		}
		return $new_data;
	}
	public static function json_data($data, $action='encode'){	//json数据编码
		if($action=='encode'){
			if(!function_exists('unidecode')){
				function unidecode($match){
					return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
				}
			}
			return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', json_encode($data));
		}else{
			return (array)json_decode($data, true);
		}
	}
}

function get_products_package($ProId, $Type=0){	//组合产品
	global $db;
	$prod_ary=array();
	$row=$db->get_one('sales_package', "ProId='$ProId' and Type=$Type");
	!$row && $row=$db->get_one('sales_package', "ReverseAssociate=1 and PackageProId like '%|$ProId|%' and Type=$Type", '*', 'PId desc');
	$row['ReverseAssociate']==1 && $row['PackageProId']=str_replace("|$ProId|", "|{$row['ProId']}|", $row['PackageProId']);
	$prod_ary=@array_filter(@explode('|', $row['PackageProId']));
	if(!$row || !count($prod_ary)){
		return;
	}
	$proid=@implode(',', $prod_ary);
	$pro_row=$db->get_all('product', "ProId in($proid) and ((SoldOut=0 and IsSoldOut=0) or (IsSoldOut=1 and SStartTime<{$service_time} and {$service_time}<SEndTime))", '*', $c['my_order'].'ProId desc');
	return array('data'=>$row, 'pro'=>$pro_row);
}

function get_FCateId_by_UId($UId){	//返回上一级的CateId
		$arr_UId=explode(',', $UId);
		array_pop($arr_UId);
		$CateId=end($arr_UId);
		return $CateId;
}
function turn_page_small_html($row_count, $page, $total_pages, $query_string, $link_ext_str='.html', $html=1){	//翻页
	if(!$row_count){return;}
	if($html==1){
		$page_string=get_url_dir($_SERVER['REQUEST_URI'], $link_ext_str);
		$page_string=str_replace('//', '/', $page_string);
		if($query_string!='' && $query_string!='?'){
			$query_string='?'.query_string($query_string);
		}
	}else{
		$page_string=$query_string;
		$link_ext_str=$query_string='';
	}
	$str="<div class='page'><div class='cur'>$page/$total_pages</div>";
	if($total_pages>1){
		$step=array(1, $total_pages>=200?2:0, $total_pages>=500?5:0, $total_pages>=1000?10:0, $total_pages>=2000?20:0, $total_pages>=5000?50:0);
		$str.='<ul>';
		for($i=max($step); $i<=$total_pages; $i+=max($step)){
			$str.="<li><a href='{$page_string}{$query_string}&page={$i}'>$i/$total_pages</a></li>";
		}
		$str.='</ul>';
	}
	$str.='</div>';
	$pre=$page>1?$page-1:1;
	$next=$page+1>$total_pages?$total_pages:$page+1;
	$str.="<a href='{$page_string}{$query_string}&page={$pre}' class='page_item pre'></a>";
	$str.="<a href='{$page_string}{$query_string}&page={$next}' class='page_item next'></a>";
	return $str;
}
function get_url_dir($REQUEST_URI, $ext_name){	//获取伪静态目录
	$url_ary=@explode('/', trim($REQUEST_URI, '/'));
	$url='/';
	foreach($url_ary as $k=>$v){
		if($k==count($url_ary)-1){
			$p=@explode('?', $v);
			$v=$p[0];
		}
		if(substr_count($v, $ext_name)){break;}
		$url.=$v;
	}
	return $url;
}
function turn_page_html($row_count, $page, $total_pages, $query_string, $pre_page='<<', $next_page='>>', $base_page=3, $link_ext_str='.html', $html=1){	//翻页
	if(!$row_count){return;}
	if($html==1){
		// $page_string=get_url_dir($_SERVER['REQUEST_URI'], $link_ext_str);
		// $page_string=str_replace('//', '/', $page_string);
		// if($query_string!='' && $query_string!='?'){
		// 	$query_string='?'.query_string($query_string);
		// }
	}else{
		$page_string=$query_string;
		$link_ext_str=$query_string='';
	}
	$i_start=$page-$base_page>0?$page-$base_page:1;
	$i_end=$page+$base_page>=$total_pages?$total_pages:$page+$base_page;
	($total_pages-$page)<$base_page && $i_start=$i_start-($base_page-($total_pages-$page));
	$page<=$base_page && $i_end=$i_end+($base_page-$page+1);
	$i_start<1 && $i_start=1;
	$i_end>=$total_pages && $i_end=$total_pages;
	$turn_page_str='';
	$pre=$page-1>0?$page-1:1;
	$turn_page_str.=($page<=1)?"<li><font class='page_noclick'><em class='icon_page_prev'></em>$pre_page</font></li>":"<li><a href='{$page_string}{$query_string}&page={$pre}' class='page_button'><em class='icon_page_prev'></em>$pre_page</a></li>";
	$i_start>1 && $turn_page_str.="<li><a href='{$page_string}{$query_string}&page=1' class='page_item'>1</a></li><li><font class='page_item'>...</font></li>";
	for($i=$i_start; $i<=$i_end; $i++){
		$turn_page_str.=$page!=$i?"<li><a href='{$page_string}{$query_string}&page={$i}' class='page_item'>$i</a></li>":"<li><font class='page_item_current'>$i</font></li>";
	}
	$i_end<$total_pages && $turn_page_str.="<li><font class='page_item'>...</font></li><li><a href='{$page_string}{$query_string}&page={$total_pages}' class='page_item'>$total_pages</a></li>";
	$next=$page+1>$total_pages?$total_pages:$page+1;
	if($page+1>$total_pages){
		$turn_page_str.="<li class='page_last'><font class='page_noclick'>$next_page<em class='icon_page_next'></em></font></li>";
	}else{
		$page>=$total_pages && $page--;
		$turn_page_str.="<li class='page_last'><a href='{$query_string}{$page_string}&page={$next}' class='page_button'>$next_page<em class='icon_page_next'></em></a></li>";
	}
	return $turn_page_str;
}
function get_narrow_url($query_string, $narrow_ary=array(), $id){	//生成高级筛选地址
	$page_string=get_url_dir($_SERVER['REQUEST_URI'], $ext_name='.html');
	//var_dump($page_string);
	$query_string='/'.trim($page_string, '/').$query_string;
	if($narrow_ary){
		$key=array_search($id, $narrow_ary);
		if($key===false){
			$narrow_ary[]=$id;
		}else{
			unset($narrow_ary[$key]);
		}
		$result=$query_string.(count($narrow_ary)?'&Narrow='.implode('+', $narrow_ary):'');
	}else{
		$result=$query_string.'&Narrow='.$id;
	}
	return $result;
}
function get_narrow_pro_count($narrow_ary=array(), $id, $CateId=0){	//计算高级筛选产品数量
	global $db;
	$narrow_where='1';
	$arr=array();
	$v_ary=array();
	$key=array_search($id, $narrow_ary);
	if($key===false){
		$narrow_ary[]=$id;
	}
	$id_ary=explode('.', $id);
	foreach($narrow_ary as $k=>$v){
		$v_ary=explode('.', $v);
		$arr[$v_ary[0]][]=$v_ary[1];
	}
	if($arr){
		$i=0;
		$narrow_where.=' and ';
		foreach($arr as $k=>$v){
			$narrow_where.=($i?' and ':'')."Attr REGEXP '\"{$k}\":\[[0-9\,\"]*\"(";
			if($k==$id_ary[0]){
				$narrow_where.=$id_ary[1];
			}else{
				foreach($v as $k2=>$v2){
					$narrow_where.=($k2?'|':'').$v2;
				}
			}
			$narrow_where.=")\"[0-9\,\"]*\]'";
			++$i;
		}
		unset($v_ary, $arr);
	}
	if($CateId){
		$UId=get_UId_by_CateId($CateId);
		$narrow_where.=" and (CateId in(select CateId from product_category where UId like '{$UId}%') or CateId='{$CateId}')";
	}
	$result=(int)$db->get_row_count('product', $narrow_where.$c['pro_where']);
	return $result;
}

function Supplier_Init($SupplierId){
	global $db;
	
	$name = mysql_real_escape_string($db->get_value('member',"MemberId='$SupplierId'",'Email'));
    $sql = "INSERT INTO `ad` (`Num`,`SupplierId`,`PageName`,`AdPosition`,`AdType`,`PicCount`, `Width`,`Height`) VALUES(1,{$SupplierId} ,'Supplier-{$name}','首页banner/bannerBanner Principal banner/Home banner',0,5,1200,500),(2,{$SupplierId} ,'Supplier-{$name}','首页广告位一/Espacio publicitario en página principal 1/Home ad #1',0,1,1200,60)";
        /*$sql = "INSERT INTO `ad` (`Num`,`SupplierId`,`PageName`,`AdPosition`,`AdType`,`PicCount`, `Width`,`Height`) VALUES(1,{$SupplierId} ,'Supplier-{$name}','首页banner/bannerBanner Principal banner',0,5,1000,410),(2,{$SupplierId} ,'Supplier-{$name}','首页广告位一/Espacio publicitario en página principal 1',0,1,325,165),(3,{$SupplierId} ,'Supplier-{$name}','首页广告位二/Espacio publicitario en página principal 2',0,1,325,165),(4,{$SupplierId} ,'Supplier-{$name}','首页广告位三/Espacio publicitario en página principal 3',0,1,325,165),(5,{$SupplierId} ,'Supplier-{$name}','首页新闻广告位/Espacio publicitario en Página principal de noticias',0,3,310,230)";*/
    $name && mysql_query($sql);
    $sql = "INSERT INTO `article` (`SupplierId`, `GroupId`, `Num`, `Title`,`Title_lang_1`) VALUES( {$SupplierId}, 0, 1, 'Acerca de nosotros','关于我们'),( {$SupplierId}, 0, 2, 'Contacto','联系我们'),( {$SupplierId}, 0, 3, 'Index Informacin de la empresa','首页公司信息'),( {$SupplierId}, 0, 4, 'Informacin de la empresa content','公司信息'),( {$SupplierId}, 0, 5, 'Tiempo de envío y coste','运输时间和成本'),( {$SupplierId}, 0, 6, 'Preguntas Frecuentes','常问问题')";
    $name && mysql_query($sql);
}

?>