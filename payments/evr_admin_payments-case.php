<?php
function evr_admin_payments(){
    
    $action = $_REQUEST['action'];
    switch ($action) {
      
      case "view_payments":
        evr_admin_view_payments();
        //evr_check_form_submission();
     break;
     
     case "add_payment":
     evr_admin_payments_add();
     break;
     
     case "post_payment":
     //evr_check_form_submission();
    evr_admin_payment_post();
     break;
     
          case "edit_payment":
     evr_admin_payments_edit();
     break;
     
     case "update_payment":
     //evr_check_form_submission();
    evr_admin_payment_update();
     break;
     
      case "delete_payment":
     //evr_check_form_submission();
    evr_delete_payment();
     break;
     
    default:
    evr_payment_event_listing();
}
}
?>