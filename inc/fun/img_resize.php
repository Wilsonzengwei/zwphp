<?php
/*
Powered by ly200.com		http://www.ly200.com
广州联雅网络科技有限公司		020-83226791
*/

function img_resize($source_img, $dest_img='', $dest_width=200, $dest_height=150){	//源图片必须相对于网站根目录
	global $site_root_path;
	
    if(!is_file($site_root_path.$source_img)){
		return '';
	}
	
	$dest_img=='' && $dest_img=dirname($source_img).'/s_'.basename($source_img);
	$ext_name=get_ext_name($source_img);
	
	if($ext_name=='jpg' || $ext_name=='jpeg'){
		$im=imagecreatefromjpeg($site_root_path.$source_img);
	}elseif($ext_name=='png'){
		$im=imagecreatefrompng($site_root_path.$source_img);
	}elseif($ext_name=='gif'){
		$im=imagecreatefromgif($site_root_path.$source_img);
	}else{
		@copy($site_root_path.$source_img, $site_root_path.$dest_img);
		@chmod($site_root_path.$dest_img, 0777);
		return $return_img;	//返回调整后的文件
	}
	
	$source_width=imagesx($im);	//源图片宽
	$source_height=imagesy($im);	//源图片高
	
	if($source_width>$dest_width || $source_height>$dest_height){
		if($source_width>=$dest_width){
			$width_ratio=$dest_width/$source_width;
			$resize_width=true;
		}
		
		if($source_height>=$dest_height){
			$height_ratio=$dest_height/$source_height;
			$resize_height=true;
		}
		
		if($resize_width && $resize_height){
			$ratio=$width_ratio<$height_ratio?$width_ratio:$height_ratio;
		}elseif($resize_width){
			$ratio=$width_ratio;
		}elseif($resize_height){
			$ratio=$height_ratio;
		}
		
		$new_width=$source_width*$ratio;
		$new_height=$source_height*$ratio;
		
		$new_im=imagecreatetruecolor($new_width, $new_height);
		if($ext_name=='png' || $ext_name=='gif'){
			imagealphablending($new_im, false);
			imagesavealpha($new_im, true);
		}
		imagecopyresampled($new_im, $im, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);
		
		if($ext_name=='jpg' || $ext_name=='jpeg'){
			imagejpeg($new_im, $site_root_path.$dest_img, 100);
		}elseif($ext_name=='png'){
			imagepng($new_im, $site_root_path.$dest_img);
		}else{
			$bgcolor=imagecolorallocate($new_im, 0, 0, 0);
            $bgcolor=imagecolortransparent($new_im, $bgcolor);
            $bgcolor=imagecolorallocatealpha($new_im, 0, 0, 0, 127);
            imagefill($new_im, 0, 0, $bgcolor);
			imagegif($new_im, $site_root_path.$dest_img);
		}
		imagedestroy($new_im);
	}else{
		@copy($site_root_path.$source_img, $site_root_path.$dest_img);
	}
	
	imagedestroy($im);
	@chmod($site_root_path.$dest_img, 0777);
	
	return $dest_img;	//返回调整后的文件名
}
?>