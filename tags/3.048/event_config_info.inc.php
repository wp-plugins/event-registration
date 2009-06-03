<?php

/**
 * Event Config Info
 * @author Edge Technology Consulting
 * @copyright 2009
 */

function events_admin_page_footer() {
echo '<div style="margin-top:45px; font-size:0.87em;">';
echo '<div style="float:right;">';

?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<h1>Donate</h1>
	<p>Do you find <em>Event Registration</em> plugin useful?<br>How about giving back a little?</p>
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="buckfleming@comcast.net">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
	<div class="input">Amount: $<input type="text" name="amount" value="25.00" size="5"></div>
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	<br />
</form>
 
<?
echo '</div>';
echo '<div><a href="'. get_bloginfo('wpurl') .'/wp-content/plugins/event-registration/guide.htm" target="_blank">Documentation</a> | <a href="http://www.edgetechweb.com/">'.__('Event Registration Homepage', 'Event Registration').'</a></div>';
echo '</div>';
}

function event_config_info(){
	$current_event = get_option ( 'current_event' );
	
	$events_detail_tbl = get_option ( 'events_detail_tbl' );
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );
	$events_organization_tbl = get_option ('events_organization_tbl');
	$events_question_tbl = get_option ('events_question_tbl');
	$events_answer_tbl = get_option( 'events_answer_tbl' );
	
	
	$installed_attendee_ver = get_option( 'events_attendee_tbl_version' );
    $installed_events_detail_ver = get_option( 'events_detail_tbl_version' );
    $installed_organization_ver = get_option( 'events_organization_tbl_version' );
    $installed_question_ver = get_option ('events_question_tbl_version');
    $installed_answer_ver = get_option( 'events_answer_tbl_version' );
    
    
	
	echo "<br>";	echo "<br>";	echo "<br>";	echo "<br>";
	
	echo "Events Table Name: ".$events_detail_tbl;
	echo "<br>";
		echo "<br>";
	echo "Events Table Version: ".$installed_events_detail_ver;
	echo "<br>";
		echo "<br>";
	echo "Attendee Table Name: ".$events_attendee_tbl;
	echo "<br>";
		echo "<br>";
	echo "Attendee Table Version: ".$installed_attendee_ver;
	echo "<br>";
		echo "<br>";	
	echo "Organization Table Name: ".$events_organization_tbl;
	echo "<br>";
		echo "<br>";
	echo "Organization Table Version: ".$installed_organization_ver;
	echo "<br>";
		echo "<br>";
	echo "Question Table Name: ".$events_question_tbl;
	echo "<br>";
		echo "<br>";
	echo "Question Table Version: ".$installed_question_ver;
	echo "<br>";
		echo "<br>";
	echo "Answer Table Name: ".$events_answer_tbl;
	echo "<br>";
		echo "<br>";
	echo "Answer Table Version: ".$installed_answer_ver;	
	echo "<br>";
		echo "<br>";
			echo "<br>";
				echo "<hr>";
	
	
events_admin_page_footer();	
}

?>