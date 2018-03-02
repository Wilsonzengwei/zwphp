<?php
ob_start();
$row=$db->get_all('translate', '1', '*', 'MyOrder desc, LId desc');
if(count($row)){
?>
<div id="lib_translate">
	<ul>
		<?php
		for($i=0; $i<count($row); $i++){
		?>
			<li><img src="<?=$row[$i]['LogoPath'];?>" align="absmiddle" width="16" height="11" /> <a href="<?=$row[$i]['Url'];?>" target="_blank"><?=$row[$i]['Name'];?></a></li>
		<?php }?>
	</ul>
</div>
<?php
}
$translate=ob_get_contents();
ob_clean();
?>