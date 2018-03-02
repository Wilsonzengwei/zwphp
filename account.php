<?php
include('inc/include.php');
include($site_root_path.'/inc/fun/verification_code.php');
include($site_root_path.'/inc/lib/member/index.php');
?>


<?php include($site_root_path.'/inc/common/header.php');?>
<div class="blank15"></div>
<div id="main" class="main_contents">
	<div class="w">
        <div class="blank6"></div>
        <?=$member_page_contents;?>
    </div>
</div>
<div class="blank28"></div>
<div id="footer">
	<?php include($site_root_path.'/inc/common/footer.php');?>
</div>
