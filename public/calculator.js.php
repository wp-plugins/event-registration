<?php
header("content-type: application/x-javascript");
    
        //$tax_rate = .0875;
        $tax_rate = $_GET['tax'];
?> 

 /* This script is Copyright (c) Paul McFedries and 
 Logophilia Limited (http://www.mcfedries.com/).
 Permission is granted to use this script as long as 
 this Copyright notice remains in place.*/
/* */ 
/* calculate total and tax rate together */                            
function CalculateTotalTax(frm) {
    var order_total = 0;
    var item_one = 0 /*Added by GT to Hide Submit button unless item selected*/
    var tax_rate = <?php echo $tax_rate;?>;
    for (var i=0; i < frm.elements.length; ++i) {
        form_field = frm.elements[i];
        form_name = form_field.name;
        if (form_name.substring(0,4) == "PROD") {
            item_price = parseFloat(form_name.substring(form_name.lastIndexOf("_") + 1));
            item_quantity = parseInt(form_field.value);
            /*Added by GT conditional statement to display button or not */
            item_one = item_one + item_quantity;
            if (item_one  > 0 ){frm.mySubmit.disabled = false;}
				else if (item_one <=0){frm.mySubmit.disabled = true;}  
            if (item_quantity >= 0) {
                order_total += item_quantity * item_price;
                /*Added by GT if total is less than 0, disable the continue button in case they pick a discount and no fee */
                if (order_total < 0){frm.mySubmit.disabled = true;}
                }
        }
    }
    frm.fees.value = round_decimals(order_total, 2);
        tax_total = order_total * tax_rate;
    frm.tax.value = round_decimals(tax_total, 2);
        grand_total = order_total + tax_total;
    frm.total.value = round_decimals(grand_total, 2);
}
/* */
/* calculate total without tax */                            
function CalculateTotal(frm) {
    var order_total = 0;
    var item_one = 0 /*Added by GT to Hide Submit button unless item selected*/
    for (var i=0; i < frm.elements.length; ++i) {
        form_field = frm.elements[i];
        form_name = form_field.name;
        if (form_name.substring(0,4) == "PROD") {
            item_price = parseFloat(form_name.substring(form_name.lastIndexOf("_") + 1));
            item_quantity = parseInt(form_field.value);
            /*Added by GT conditional statement to display button or not */
            item_one = item_one + item_quantity;
            if (item_one  > 0 ){frm.mySubmit.disabled = false;}
				else if (item_one <=0){frm.mySubmit.disabled = true;}  
            if (item_quantity >= 0) {
                order_total += item_quantity * item_price;
                /*Added by GT if total is less than 0, disable the continue button in case they pick a discount and no fee */
                if (order_total < 0){frm.mySubmit.disabled = true;}
                }
        }
    }

    frm.total.value = round_decimals(order_total, 2);       
}
/* */
/*Rounding Function*/
function round_decimals(original_number, decimals) {
    var result1 = original_number * Math.pow(10, decimals)
    var result2 = Math.round(result1)
    var result3 = result2 / Math.pow(10, decimals)
    return pad_with_zeros(result3, decimals)
}
/*Padd Zeros*/                            
function pad_with_zeros(rounded_value, decimal_places) {
    /* Convert the number to a string */
    var value_string = rounded_value.toString()
    /* Locate the decimal point */
    var decimal_location = value_string.indexOf(".")
    /* Is there a decimal point? */
    if (decimal_location == -1) {
        /* If no, then all decimal places will be padded with 0s */
        decimal_part_length = 0
        /* If decimal_places is greater than zero, tack on a decimal point */
        value_string += decimal_places > 0 ? "." : ""
    }
    else {
    /* If yes, then only the extra decimal places will be padded with 0s*/
    decimal_part_length = value_string.length - decimal_location - 1
    }
    /* Calculate the number of decimal places that need to be padded with 0s */
    var pad_total = decimal_places - decimal_part_length
    if (pad_total > 0) {
    /* Pad the string with 0s */
        for (var counter = 1; counter <= pad_total; counter++) 
        value_string += "0"
    }
    return value_string
}
function a_message() 
{ 
alert('I came from an external script! Ha, Ha, Ha!!!!'); 
} 