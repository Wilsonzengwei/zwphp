<div id="footer">
	<div class="link_list">
		<?php /*
		<a href="http://www.17track.net/<?=$lang ? 'zh-cn' : 'es'; ?>/track?nums=" class="list" title="<?=$mobile_language['foot']['track']; ?>"><?=$mobile_language['foot']['track']; ?></a>*/ ?>
		<a href="<?=$mobile_url; ?>/account.php?module=create" class="list" title="<?=$website_language['head'.$lang]['registered']; ?>"><?=$website_language['head'.$lang]['registered']; ?></a>
		<a href="<?=$mobile_url; ?>/supplier/article.php?AId=31" class="list" title="<?=$website_language['head'.$lang]['shipping']; ?>"><?=$website_language['head'.$lang]['shipping']; ?></a>
		<a href="<?=$mobile_url; ?>/supplier/article.php?AId=32" class="list" title="<?=$website_language['head'.$lang]['type']; ?>"><?=$website_language['head'.$lang]['type']; ?></a>
		<a href="<?=$mobile_url; ?>/account.php?module=wishlists" class="list" title="<?=$website_language['head'.$lang]['favorites']; ?>"><?=$website_language['head'.$lang]['favorites']; ?></a>
	</div>
	<div class="copyright">
		<?=$mCfg['CopyRight']; ?>
		<a href="http://www.ueeshop.com" class="list" target="_blank" style="display: none;font-size: 12px;">Powered by UEESHOP</a>
        <?=$mCfg['JsCode']; ?> 
	</div>
</div>
