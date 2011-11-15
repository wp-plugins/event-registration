<?php
function evr_questions_new(){
    $record_limit = "10";
    global $wpdb;
    $event_name = $_REQUEST['event_name'];
    //$event_id = $_REQUEST['event_id'];
    (is_numeric($_REQUEST['event_id'])) ? $event_id = $_REQUEST['event_id'] : $event_id = "0";
    ?>
<div class="wrap">
<div id="dashboard-widgets-wrap">
<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:65%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('ADD NEW QUESTION','evr_language');?> for <?php echo $event_name;?></span></h3>
                 <div class="inside">
                    <div class="padding">
                            <form name="newquestion" method="post" action="admin.php?page=questions">
                            <input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
                            	<table width="100%" cellspacing="2" cellpadding="5">
                            	<tr valign="top">
                            	<th width="33%" scope="row"><?php _e('Question','evr_language');?>:</th>
                            	<td><input name="question" type="text" id="question" size="100" value="" /></td>
                            	</tr>
                            	
                            	<tr valign="top">
                            	<th width="33%" scope="row"><?php _e('Type','evr_language');?>:</th>
                            	<td><select name="question_type" id="question_type">
                            				<option value="TEXT"><?php _e('Text','evr_language');?></option>
                            				<option value="TEXTAREA"><?php _e('Text Area','evr_language');?></option>
                            				<option value="SINGLE"><?php _e('Single','evr_language');?></option>
                            				<option value="MULTIPLE"><?php _e('Multiple','evr_language');?></option>
                            				<option value="DROPDOWN"><?php _e('Drop Down','evr_language');?></option>
                            	</select></td>
                            	</tr>
                            	
                            	<tr valign="top">
                            	<th width="33%" scope="row"><?php _e('Selections','evr_language')?>:</th>
                            	<td><input name="values" type="text" id="values" size="50" value="" /></td>
                            	</tr>
                            	
                            	<tr valign="top">
                            	<th width="33%" scope="row"><?php _e('Required','evr_language');?>:</th>
                            	<td><input name="required" type="checkbox" id="required" /></td>
                            	</tr>
                            	
                            	</table>
                                <?php ?>
                            				
                            	<?php		
                            				echo "<input type='hidden' name='event_name' value='" . $event_name . "'>";
                                            echo "<input type='hidden' name='action' value='post'>";
                            				echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
                            	?>	
                            	
                            	<p><input type="submit" name="Submit" value="<?php _e('ADD QUESTION','evr_language');?>" /></p>
                            </form>
   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
<br />
<?php
}
?>