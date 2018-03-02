<div id="online" style="width:87px; position:fixed;_position:absolute; right:15px; z-index:1000; top:210px;">
<div style="height: 30px;"><img src="/images/online/qq_top.gif" /></div>
<div style=" background:url(/images/online/qq_bg.gif) center top repeat-y;">
	<?php
		for($i=0;$i<count($mCfg['online']);$i++)
		{
		
			
			switch($mCfg['online'][$i]['AccountType'])
			{
				// case 0:
				// $account='<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=####&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:####:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>';
				// break;
				// case 1:
				// $account='<a target="_blank" href="msnim:chat?contact=####"><img src="/images/online/msn.png" /></a>';
				// break;
				case 0:
				$account='skype:####?chat';
				$account='<a target="_blank" href="skype:####?chat"><img src="/images/online/skype.png" /></a>';
				break;
				// case 3:
				// $account='<a href="http://web.im.alisoft.com/msg.aw?v=2&amp;uid=####&amp;site=cnalichn&amp;s=1" target="_blank"><img alt="发送旺旺即时消息" src="http://web.im.alisoft.com/online.aw?v=2&amp;uid=####&amp;site=cnalichn&amp;s=1" border="0" /></a>';
				// break;
				// case 4:
				// $account='<a target="_blank" href="http://amos.us.alitalk.alibaba.com/msg.aw?v=2&uid=####&site=enaliint&s=5"><img src="/images/online/myt.png" /></a>';
				// break;
				// case 5:
				// $account='<a target="_blank" href="http://edit.yahoo.com/config/send_webmesg?.target=####&.src=pg"><img src="/images/online/yahoo.png" /></a>';
				// break;
				case 1:
				$account='<a target="_blank" href="mailto:####"><img src="/images/online/email.png" /></a>';
				break;
			}
			$account=str_replace('####',$mCfg['online'][$i]['Account'],$account).'<br/>'.$mCfg['online'][$i]['Name'];
	?>
	
		<div style="text-align:center"><?=$account?></div>
	<?php }?>
</div>
<div><img src="/images/online/qq_bot.gif" /></div>
</div>

<script language="javascript" type="text/javascript"> 
function linebox()
{
	var obj=document.getElementById('online');
	if (window.ActiveXObject) {
		var ua = navigator.userAgent.toLowerCase();
		var ie=ua.match(/msie ([\d.]+)/)[1];
		if(ie==6.0){
			 var scrollTop = Math.max(document.documentElement.scrollTop,document.body.scrollTop)+210;
			  var ol=Math.max(document.documentElement.clientWidth,document.body.clientWidth)-100;
			  	obj.style.position='absolute'; 
			 	obj.style.top = scrollTop+ 'px';
		}
	}
	
}
window.onscroll=function()
{
	linebox();
}
</script>