<?php 
function event_categories_config(){
er_plugin_menu();    
global $wpdb;
?>
<div id="event_reg_theme" class="wrap">
<h2>Event Categories</h2>

<div style="float:left; margin-right:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"];?>">
    <input type="hidden" name="action" value="add_new_category">
    <input class="button-primary" type="submit" name="Submit" value="ADD NEW CATEGORY"/>
  </form>
</div> 
<div style="clear:both;"></div>

<?php


	$er_categories_action = $_REQUEST ['action'];
    switch ($er_categories_action) {
        
        case "add_new_category" : 
                ?>
                <div class="metabox-holder">
                <div class="postbox">
                <h3>Add a Category</h3>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
                <input type="hidden" name="action" value="add">
                <ul>
                <li><label>Category Name</label> <input name="category_name" size="25"></li>
                <li><label>Unique ID For Category</label> <input name="category_identifier"></li>
                <li>Do you want to display the event description on the events page?
                <input type='radio' name='display_desc' value='Y'>Yes
                <input type='radio' name='display_desc' checked value='N'>No</li>
                <li>Category Description<br />
                <textarea rows="5" cols="300" name="category_desc" id="category_desc_new"  class="my_ed"></textarea><br /></li>
                <li><p><input class="button-primary" type="submit" name="Submit" value="Add Category" id="add_new_category" /></p></li>
                </ul></form></div></div>
                <?php
        break;
        
        case "edit":
                global $wpdb;
                $id=$_REQUEST['id'];
                $sql = "SELECT * FROM ". get_option('events_cat_detail_tbl') ." WHERE id =".$id;
                $result = mysql_query ($sql);
                
                while ($row = mysql_fetch_assoc ($result)){
                	$category_id= $row['id'];
                	$category_name=$row['category_name'];
                	$category_identifier=$row['category_identifier'];
                	$category_desc=$row['category_desc'];
                	$display_category_desc=$row['display_desc'];
                }
                ?>
                <!--Add event display-->
                <div class="metabox-holder">
                <div class="postbox">
                <h3>Edit Category: <?php echo $category_name ?></h3>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                <input type="hidden" name="action" value="update">
                <ul>
                <li><label><strong>Category Name:</strong></label> <input name="category_name" size="25" value="<?php echo $category_name;?>"></li>
                <li><label><strong>Unique Category Identifier:</strong></label> 
                <input name="category_identifier" value="<?php echo $category_identifier;?>"> </a></li>
                <li>Do you want to display the event description on the events page?
                <?php if ($display_category_desc ==""){
                echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
                echo "<input type='radio' name='display_desc' value='N'>No";}
                if ($display_category_desc =="Y"){
                echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
                echo "<input type='radio' name='display_desc' value='N'>No";}
                if ($display_category_desc =="N"){
                echo "<input type='radio' name='display_desc' value='Y'>Yes";
                echo "<input type='radio' name='display_desc' checked value='N'>No";
                }
                ?>
                </li>
                <li><strong>Category Description:</strong><br />
                <textarea rows="5" cols="300" name="category_desc" id="category_desc_new"  class="my_ed"><?php echo $category_desc; ?></textarea>
                </li>
                <li>
                <p>
                <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Category'); ?>" id="update_category" />
                </p>
                </li>
                </ul>
                </form>
                </div>
                </div>
                <?php  
        break;
        
        case "add":
                global $wpdb;
                $category_name= htmlentities2($_REQUEST['category_name']);
                $category_identifier = htmlentities2($_REQUEST['category_identifier']);
                $category_desc= htmlentities2($_REQUEST['category_desc']); 
                $display_category_desc=$_REQUEST['display_desc'];
                $sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 'display_desc'=>$display_category_desc); 
                $sql_data = array('%s','%s','%s','%s');
                if ($wpdb->insert( get_option('events_cat_detail_tbl'), $sql, $sql_data )){?>
                	<div id="message" class="updated fade"><p><strong>The category 
                    <?php echo htmlentities2($_REQUEST['category_name']);?> has been added.</strong></p></div>
                <?php }else { ?>
                	<div id="message" class="error"><p><strong>The category 
                    <?php echo htmlentities2($_REQUEST['category_name']);?> was not saved. <?php print mysql_error() ?>.</strong></p></div>
                <?php
                }
                echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=event_categories'>";
        break;
                	 
        case "update":
                $category_id= $_REQUEST['category_id'];
                $category_name= htmlentities2($_REQUEST['category_name']);
                $category_identifier = htmlentities2($_REQUEST['category_identifier']);
                $category_desc= htmlentities2($_REQUEST['category_desc']); 
                $display_category_desc=$_REQUEST['display_desc'];
                global $wpdb;
                $sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 'display_desc'=>$display_category_desc); 
                
                $update_id = array('id'=> $category_id);
                
                $sql_data = array('%s','%s','%s','%s');
                
                if ($wpdb->update( get_option('events_cat_detail_tbl'), $sql, $update_id, $sql_data, array( '%d' ) )){?>
                <div id="message" class="updated fade"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> has been updated.</strong></p></div>
                <?php }else { ?>
                <div id="message" class="error"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> was not updated. <?php print mysql_error() ?>.</strong></p></div>
                <?php
}
                echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=event_categories'>";
        break;    
              
        case "delete":    
                $id=$_REQUEST['id'];
                global $wpdb;
                $events_cat_detail_tbl = get_option ( 'events_cat_detail_tbl' );
                $id = $_REQUEST ['id'];
                $sql = "DELETE FROM ".get_option('events_cat_detail_tbl')." WHERE id='$id'";
                $wpdb->query ( $sql );
                echo "<div id='message' class='updated fade'><p><strong>
                Categories have been successfully deleted from the event.</strong></p></div>";
                echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=event_categories'>";
        break;
        
        default:
                ?>
                <h3>Current Categories</h3>
                <form id="form1" name="form1" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                <table class="widefat">
                <thead>
                <tr><th>ID</th><th>Name </th><th>Identifier</th><th>Description</th><th>Display Description</th><th>Shortcode</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php 
                global $wpdb;
                $sql = "SELECT * FROM ". get_option('events_cat_detail_tbl') ." ORDER BY id ASC";
                $result = mysql_query ($sql);
                if (mysql_num_rows($result) > 0 ) {
                while ($row = mysql_fetch_assoc ($result)){
                					$category_id= $row['id'];
                					$category_name=$row['category_name'];
                					$category_identifier=$row['category_identifier'];
                					$category_desc=$row['category_desc'];
                					$display_category_desc=$row['display_desc'];
                ?>
                <tr><td><?php echo $category_id?></td>
                    <td><?php echo $category_name?></td>
                    <td><?php echo $category_identifier?></td>
                    <td><?php echo $category_desc?></td>
                    <td><?php echo $display_category_desc?></td>
                    <td>[EVENT_REGIS_CATEGORY event_category_id="<?php echo $category_identifier?>"]</td>
                    <td><a href="<?php echo request_uri()."&action=edit&id=".$category_id; ?>">EDIT</a>  |
                    <a href="<?php echo request_uri()."&action=delete&id=".$category_id; ?>" ONCLICK="return confirm('Are you sure you want to delete category?')">DELETE</a></td></tr>
                <?php } 
                		}else { 
                ?>
                  <tr><td>No Record Found!</td></tr>
                <?php }?>
                </tbody></table>
                <?php
        break;
     }
     
 	
}
?>