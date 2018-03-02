<?php
include('../../inc/site_config.php');
include('../../inc/set/ext_var.php');
include('../../inc/fun/mysql.php');
include('../../inc/function.php');
include('../../inc/manage/config.php');
include('../../inc/manage/do_check.php');
include($site_root_path.'/inc/fun/ip_to_area.php');

$last_ip_area=ip_to_area($_SESSION['ly200_AdminLastLoginIp']);
$ip_area_now=ip_to_area(get_ip());

$db_size=0;
$rs=$db->query('show table status');
while($row=mysql_fetch_assoc($rs)){
	$db_size+=$row['Data_length']+$row['Index_length'];
}

$rs=$db->query('select version() as dbversion');
$row=mysql_fetch_assoc($rs);
$dbversion=$row['dbversion'];

include('../../inc/manage/header.php');
?>
<div id="home">
	<div class="toper"><script language="javascript" src="http://www.ly200.com/system/js/toper.php"></script></div>
	<div class="info">
		<div>
            <?php 
			$day_len=5;
			$StartTime=$service_time-86400*$day_len+1;
			$EndTime=$service_time;
			
			$date_ary=$count_ary=array();
			$date_str='"'.date('m月j日', $StartTime).'"';
			$date=$StartTime;
			for($i=0; $i<=$day_len; $i++){
				if($i>0){
					$date+=86400-1;
					$d=date('m月j日', $date);
					$date_ary[]=$d;
					$date_str.=',"'.$d.'"';
				}else{
					$date+=0;
					$d=date('m月j日', $date);
				}
				$count_ary[$d]=0;
				$view_ary[$d]=0;
			}
			
			$views_row=$db->get_all('site_view',"Time>{$StartTime} and Time<{$EndTime}",'Time,Views');
			foreach((array)$views_row as $v){
				$view_ary[date('m月j日', $v['Time'])]+=(int)$v['Views'];
			}
			$view_str=implode(',', $view_ary);
			//print_r($date_str);
			?>
				<div class="items systeminfo small_sec">
                	<div class="items_title">系统信息</div>
                    <div class="items_con">
                    	<div class="info_item">
                            <span class="fl logininfo">登录时间</span>
                            <font class="fr"><?=@date('Y-m-d H:i:s', $_SESSION['ly200_AdminLastLoginTime']);?> [<?=$_SESSION['ly200_AdminLastLoginIp'].', '.$last_ip_area['country'].$last_ip_area['area'];?>]</font>
                            <div class="clear"></div>
                        </div>
                    	<div class="info_item">
                            <span class="fl databaseinfo">数据库</span>
                            <font class="fr">
								<?=get_lang('home.mysql_version');?>:<?=$dbversion;?><br />
                                <?=get_lang('home.mysql_size');?>:<?=file_size_format($db_size);?>
                            </font>
                            <div class="clear"></div>
                        </div>
                    	<div class="info_item">
                            <span class="fl serviceinfo">服务器</span>
                            <font class="fr">
                            	<?=get_lang('home.information');?>:<?=$_SERVER['SERVER_SOFTWARE'];?><br />
                                <?=get_lang('home.service_time');?>:<?=date(get_lang('ly200.time_format_full'), $service_time);?>
                            </font>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div><!--系统信息-->
				<script type="text/javascript" src="/js/plugin/highcharts/jquery-1.8.3.min.js"></script>
                <script type="text/javascript" src="/js/plugin/highcharts/highcharts.js"></script>
                <script type="text/javascript" src="/js/plugin/highcharts/exporting.js"></script>
                <div class="items systeminfo small_sec">
                	<div class="items_title">最新统计</div>
                    <div id="container" style="width:449px;height:350px;"></div>
                </div><!--数据表统计-->
                <script type="text/javascript">
                (function($){
					index_chat();
					$(window).resize(function(){
	
						$('#container').css('width',$('#container').parent('.systeminfo').siblings('.systeminfo').css('width'));
					});
				})(jQuery)
				function index_chat(){
					$('#container').highcharts({
						chart: {
							margin: [50, 30, 50, 50]
						},
						title: {
							text: 'Monthly Average Temperature',
							style:{display:'none'},
							x: -20 //center
						},
						subtitle: {
							text: 'Source: WorldClimate.com',
							style:{display:'none'},
							x: -20
						},
						xAxis: {
							categories: [<?=$date_str?>],
							
						},
						yAxis: {
							title: {
								text: 'Temperature (°C)',
								style:{display:'none'}
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						tooltip: {
							pointFormat: '<b style="color:red">{point.y}次</b><br/>',
							valueSuffix: ''
						},
						legend: {
							layout: 'vertical',
							align: 'left',
							verticalAlign: 'middle',
							borderWidth: 0,
							enabled:false
							
						},
						series: [{
							data: [<?=$view_str?>]
						}]
					});
				}
				</script>
				<div class="countinfo">
                	
                </div><!--最新统计-->
			<div class="lefter">
				<?php /*?><div class="cr">
					<div class="txt"><?=sprintf(get_lang('home.welcome'), $_SESSION['ly200_AdminUserName']);?></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="15%" nowrap><?=get_lang('home.last_login');?>:</td>
						<td width="85%"><span><?=@date('Y-m-d H:i:s', $_SESSION['ly200_AdminLastLoginTime']);?> [<?=$_SESSION['ly200_AdminLastLoginIp'].', '.$last_ip_area['country'].$last_ip_area['area'];?>]</span></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.current_login');?>:</td>
						<td><span><?=date('Y-m-d H:i:s', $_SESSION['ly200_AdminNowLoginTime']);?> [<?=get_ip().', '.$ip_area_now['country'].$ip_area_now['area'];?>]</span></td>
					  </tr>
					</table>
					<div class="system_info"><strong><?=get_lang('home.system_info');?>:</strong></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="15%" nowrap><?=get_lang('home.php_version');?>:</td>
						<td width="85%"><?=PHP_VERSION;?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.mysql_version');?>:</td>
						<td><?=$dbversion;?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.mysql_size');?>:</td>
						<td><?=file_size_format($db_size);?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.system_os');?>:</td>
						<td><?=$_SERVER['SERVER_SOFTWARE'];?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.upload_max_size');?>:</td>
						<td><?=ini_get('file_uploads')?ini_get('upload_max_filesize'):'Disabled';?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.max_execution_time');?>:</td>
						<td><?=ini_get('max_execution_time').' seconds';?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.mail_support');?>:</td>
						<td><?=ini_get('sendmail_path')?'Unix Sendmail (Path:'.ini_get('sendmail_path').')':(ini_get('SMTP')?'SMTP(Server:'.ini_get('SMTP').')':'Disabled');?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.cookie_test');?>:</td>
						<td><?=isset($_COOKIE)?'SUCCESS':'FAIL';?></td>
					  </tr>
					  <tr>
						<td nowrap><?=get_lang('home.service_time');?>:</td>
						<td><?=date(get_lang('ly200.time_format_full'), $service_time);?></td>
					  </tr>
					</table>
				</div><?php */?>
                <div class="items baseinfo">
                	<div class="items_title">基础信息</div>
                    <div class="items_con">
                    	<span class="ciritems">
							<iframe class="circle_frame" src="/manage/images/circle_blue.svg"></iframe>
                        	<div class="cir cirblue">
                            	<span class="cirblue"><?=$db->get_row_count('product','1')?></span>
                                <font>个产品</font>
                            </div>
                            <div class="name">产品总数</div>
                        </span>
                    	<span class="ciritems">
							<iframe class="circle_frame" src="/manage/images/circle_red.svg"></iframe>
                        	<div class="cir cirred">
                                <span class="cirred"><?=$db->get_row_count('feedback','1')?></span>
                                <font>条留言</font>
                            </div>
                            <div class="name">留言总数</div>
                        </span>
                    	<span class="ciritems">
							<iframe class="circle_frame" src="/manage/images/circle_green.svg"></iframe>
                        	<div class="cir cirgreen">
                                <span class="cirgreen"><?=$db->get_row_count('site_view','1')?></span>
                                <font>访客量</font>
                            </div>
                            <div class="name">访客总数</div>
                        </span>
                    	<span class="ciritems">
							<iframe class="circle_frame" src="/manage/images/circle_orange.svg"></iframe>
                        	<div class="cir ciryellow">
                            	<span class="ciryellow"><?=$db->get_sum('site_view','1','Views')?></span>
                            	<font>浏览量</font>
                            </div>
                            <div class="name">流量统计</div>
                        </span>
						<span class="line_holder"></span>
                    </div>
                </div><!--基础信息-->
                <div class="items newfeedback">
                	<div class="items_title">
                        <a href="<?=$manage_path?>feedback/">+</a>
                    	最新留言
                        <div class="clear"></div>
                    </div>
                    <table cellpadding="0" cellspacing="1" width="100%" id="mouse_trBgcolor_table" not_mouse_trBgcolor_tr='list_form_title'>
                        <tr align="center" class="list_form_title" id="list_form_title">
                            <td width="10%" nowrap><strong><?=get_lang('ly200.full_name');?></strong></td>
                            <td width="10%" nowrap><strong><?=get_lang('feedback.mobile');?></strong></td>
                            <td width="10%" nowrap><strong><?=get_lang('ly200.email');?></strong></td>
                            <td width="15%" nowrap><strong><?=get_lang('ly200.ip');?></strong></td>
                            <td width="10%" nowrap><strong><?=get_lang('ly200.time');?></strong></td>
                            <td width="5%" nowrap><strong><?=get_lang('ly200.operation');?></strong></td>
                        </tr>
						<?php
						$feedback_row = $db->get_limit('feedback','1','*','FId desc',0,5);
                        for($i=0; $i<count($feedback_row); $i++){
                            $ip_area=ip_to_area($feedback_row[$i]['Ip']);
                        ?>
                        <tr align="center">
                            <td nowrap><?=htmlspecialchars($feedback_row[$i]['Name']);?></td>
                            <td nowrap><?=htmlspecialchars($feedback_row[$i]['Mobile']);?></td>
                            <td><?php if($menu['send_mail']){?><a href="javascript:void(0);" onclick="this.blur(); parent.openWindows('win_send_mail', '<?=get_lang('send_mail.send_mail_system');?>', 'send_mail/index.php?email=<?=urlencode($feedback_row[$i]['Email'].'/'.$feedback_row[$i]['Name']);?>');"><?=htmlspecialchars($feedback_row[$i]['Email']);?></a><?php }else{?><?=htmlspecialchars($feedback_row[$i]['Email']);?><?php }?></td>
                            <td><?=htmlspecialchars($feedback_row[$i]['Ip']);?> [<?=$ip_area['country'].$ip_area['area'];?>]</td>
                            <td nowrap><?=date(get_lang('ly200.time_format_full'), $feedback_row[$i]['PostTime']);?></td>
                            
                            <td><a href="/manage/feedback/view.php?FId=<?=$feedback_row[$i]['FId']?>" title="<?=get_lang('ly200.view');?>" class="view"></a></td>
                        </tr>
                        <?php }?>
                    </table>
                </div><!--最新留言-->
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php include('../../inc/manage/footer.php');?>