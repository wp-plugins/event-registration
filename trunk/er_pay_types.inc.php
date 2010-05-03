<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

//Google Checkout

$google_id =("340766785255711");
$item_name=("");
$item_description=("");
$item_qty=("");
$item_price=("");
$currency_type=("");

?>

<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/<?php echo"$google_id";?>" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
    <input name="item_name_1" type="hidden" value="Event Registration"/>
    <input name="item_description_1" type="hidden" value="Registration for An Event"/>
    <input name="item_quantity_1" type="hidden" value="1"/>
    <input name="item_price_1" type="hidden" value="100.0"/>
    <input name="item_currency_1" type="hidden" value="USD"/>
    <input name="_charset_" type="hidden" value="utf-8"/>
    <input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=<?php echo"google_id";?>&amp;w=117&amp;h=48&amp;style=trans&amp;variant=text&amp;loc=en_US" type="image"/>
</form>


?>