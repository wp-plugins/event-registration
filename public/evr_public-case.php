<?php
function evr_registration_main(){
    
    global $wpdb;
    $company_options = get_option('evr_company_settings');
    $action = $_REQUEST['action'];
    if (is_numeric($_REQUEST['event_id'])){
        $event_id = (int)$_REQUEST['event_id'];
    }
    switch ($action) {
            
            case "register":
            if (is_numeric($event_id)){
              evr_regform_new($event_id);}
			  else {evr_show_event_list();}
            break;
            
            case "confirm":
                evr_confirm_form();
            break;
            
            case "post":
               evr_process_confirmation();
            break;
            
            case "pay":
                evr_retun_to_pay();
            break;

            case "paypal_txn":
               if ($company_options['payment_vendor']=="PAYPAL"){          
                evr_paypal_txn();
                }
                else {
                    _e('IPN is only avialble with PAYPAL with this version of Event Reigstration','evr_language');
                }
            break;
            
            default:
                evr_show_event_list();
           }
}

?>