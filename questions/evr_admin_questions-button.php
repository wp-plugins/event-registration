<?php

function evr_return_question_button(){
    ?>
    <div class="wrap">
<div id="icon-plugins" class="icon32"></div><h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Event Question Management','evr_language');?></h2>
    <div id="dashboard-widgets-wrap">
        <button  onclick="location.href='admin.php?page=questions';"><?php _e('SELECT ANOTHER EVENT','evr_language');?></button>
        </div></div><br />
        
    <?php
}
?>