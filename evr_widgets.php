<?PHP

/************************************************************
 * Custom Widget Class for Event Registration for Wordpress *
 * Contribution to Event Registration Plugin By Crystal McNair *
 *   ( www.crystalfyredesign.com )       *
 ************************************************************/

class EVR_Widget_List_Events extends WP_Widget 
{

	function EVR_Widget_List_Events () 
	{		
		$widget_opts = array(
			'classname' => 'evr-widget-list-events',
			'description' => 'Creates a list of most recent events from the Event Registration Plugin to display in the sidebar.  List can use default template or you can create custom display templates.'
		);
		
		$this->WP_Widget('evr-widget-list-events', 'Event Registration Upcoming Events', $widget_opts);
	}

	// Widget output to the User
	function widget( $args, $instance ) 
	{  
		extract($args, EXTR_SKIP);
		$title = apply_filters('widget_title', $instance['title']);
		$record_limit = isset($instance['event_limit']) ? strip_tags($instance['event_limit']) : '5';	// Defaults to 5 
		$record_category = isset($instance['event_category_id']) ? strip_tags($instance['event_category_id']) : '0';	// Defaults to 0 (All) 
		$event_template = isset($instance['event_template']) ? stripslashes( $instance['event_template'] ) : '';
		
		echo $before_widget;
		
		if ($title)
			echo $before_title . $title . $after_title;
		
		?><div class="evr-widget-list-events"><?php 
			echo evr_widget_make_list($record_limit, $record_category, $event_template); 
		?></div><?php
		
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) 
	{	// Save widget options
		$instance = $old_instance;		
		$instance['event_template'] = addslashes ( $new_instance['event_template'] );
		$instance['event_limit'] = strip_tags($new_instance['event_limit']);
		$instance['event_category_id'] = strip_tags($new_instance['event_category_id']);
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	// Forms
	function form( $instance ) 
	{	// Output admin widget options form
		$instance = wp_parse_args( (array)$instance, array('event_limit' => ''));
		
		$title = isset($instance['title']) ? strip_tags($instance['title']) : '';
		$event_limit = isset($instance['event_limit']) ? strip_tags($instance['event_limit']) : '';
		$event_category_id = isset($instance['event_category_id']) ? strip_tags($instance['event_category_id']) : '';
		$event_template = isset($instance['event_template']) ? stripslashes( $instance['event_template'] ) : '';
		
		if (intval( $event_limit ) > 20) $event_limit = '20';
		
		// Load Categories from DB
		global $wpdb;
		$table_name = $wpdb->prefix . 'evr_category';
		$events = $wpdb->get_results("SELECT id, category_name FROM $table_name", ARRAY_A);
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">Title: </label>';
		echo '<input type="text" value="' . $title . '" name="' . $this->get_field_name('title') . '" id="' . $this->get_field_id('title') . '" class="widefat">';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('event_limit') . '" title="Max 20">Number of events to show: </label>';
		echo '<input type="text" value="' . $event_limit . '" name="' . $this->get_field_name('event_limit') . '" id="' . $this->get_field_id('event_limit') . '" size="3">';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('event_category_id') . '">Select a Category to display: </label>';
		echo '<select name="' . $this->get_field_name('event_category_id') . '" id="' . $this->get_field_id('event_category_id') . '">';
			echo '<option value="0">All Events </option>';
			foreach ($events as $event) {
				$selected = $event_category_id == $event['id'] ? 'selected="selected"' : "";
				echo "<option value=". $event['id'] ." $selected>" . $event['category_name'] . ' (' . $event['id'] . ')' . "</option>";
			}
		echo '</select>';
		echo '</p>';		
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('event_template') . '">(Optional) Enter a custom template: </label>';
		echo '<textarea class="widefat" rows="20" cols="20" id="' . $this->get_field_id('event_template') . '" name="' . $this->get_field_name('event_template') . '">'.$event_template.'</textarea>';
		echo '</p>';
	}
}

// Formatting for the Event List Widget
function evr_widget_make_list($record_limit = '5', $record_category = '0', $record_template = '')
{
    global $wpdb;    
    $curdate = date("Y-m-d");
    $company_options = get_option('evr_company_settings');
	$category_query = '';
	if (intval( $record_limit ) > 20) $record_limit = '20';

	if ($record_category != '0') $category_query = " AND category_id LIKE '%:\"$record_category\"%' ";
	
        $sql = "SELECT * FROM " . get_option('evr_event')." WHERE str_to_date(end_date, '%Y-%m-%e') >= curdate() $category_query ORDER BY str_to_date(start_date, '%Y-%m-%e') LIMIT 0,".$record_limit;    
        $rows = $wpdb->get_results( $sql );
        if ($rows){
            foreach ($rows as $event){
	
				if ($record_template == '')
				{
					$codeToReturn .= '
							<div id="evr_eventitem">
							<div id="datebg"><div id="topdate">{EVENT_MONTH_START_NAME_3}</div><div id="bottomdate">{EVENT_DAY_START_NUMBER}</div></div>
							<div id="evr_eventitem_title"><a href="{EVENT_URL}">{EVENT_NAME}</a></div>
							</div><hr/>
							';
				}
				else
				{
					$codeToReturn .= $record_template;
				}
	
				$event_name = stripslashes($event->event_name);
				$event_desc = stripslashes($event->event_desc);
				
				$codeToReturn = str_replace("\r\n", '
											', $codeToReturn);
				$codeToReturn = str_replace("{EVENT_URL}", evr_permalink_prefix().'page_id='.$company_options['evr_page_id'].'&action=evregister&event_id='.$event->id, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_ID}", $event->id, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_NAME}", evr_truncateWords(stripslashes($event->event_name), 8, "..."), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DESC}", stripslashes($event->event_desc), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_LOC}", stripslashes($event->event_location), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_ADDRESS}", stripslashes($event->event_address), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_CITY}", stripslashes($event->event_city), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_STATE}", stripslashes($event->event_state), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_POSTAL}", stripslashes($event->event_postal), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_START_NUMBER}", $event->start_month, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_START_NAME}", date("F",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_START_NAME_3}", date("M",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_START_NUMBER}", $event->start_day, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_START_NAME}",date("l",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_START_NAME_3}",date("D",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_YEAR_START}", $event->start_year, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_TIME_START}", $event->start_time, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DATE_START}", $event->start_date, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_END_NUMBER}", $event->end_month, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_START_NAME}", date("F",strtotime($event->end_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_MONTH_END_NAME_3}", date("M",strtotime($event->end_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_END_NUMBER}", $event->end_day, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_END_NAME}",date("l",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DAY_END_NAME_3}",date("D",strtotime($event->start_date)), $codeToReturn);
				$codeToReturn = str_replace("{EVENT_YEAR_END}", $event->end_year, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_DATE_END}", $event->end_date, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_TIME_END}", $event->end_time, $codeToReturn);
				$codeToReturn = str_replace("{EVENT_AVAIL_SPOTS}", $event->reg_limit, $codeToReturn);
				
				
                /* $codeToReturn .= '<div id="evr_eventitem">
				<div id="datebg"><div id="topdate">'.$month_3_letter.'</div><div id="bottomdate">'.$day_number.'</div></div>
				<div id="evr_eventitem_title">
				<a href="'.evr_permalink_prefix()."page_id=".$company_options['evr_page_id'].'&action=evregister&event_id='.$event->id.'">'.$event_name.'</a></div>
				</div><hr/>'; */
			}        
        }
	
	return $codeToReturn;
}

?>