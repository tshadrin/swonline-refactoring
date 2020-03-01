<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$mrh_login = "s12sham";
$mrh_pass1 = "893rnp19";
$inv_id = 0;
$crc = md5( "{$mrh_login}:{$out_summ}:{$inv_id}:{$mrh_pass1}:shp_item={$shp_item}:shp_param1={$shp_param1}:shp_param2={$shp_param2}:shp_param3={$shp_param3}:shp_typ={$shp_typ}" );
print "<form id=pay name=pay method='POST' action='https://merchant.webmoney.ru/lmi/payment.asp'>\r\n\r\n\t\t<p>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='{$out_summ}'>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_DESC' value='{$inv_desc} {$pack_name}'>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_NO' value='1'>\r\n\t\t\t<input type='hidden' name='LMI_PAYEE_PURSE' value='Z762169330222'>\r\n\t\t\t<input type='hidden' name='LMI_SIM_MODE' value='0'>\r\n\t\t\t\r\n\t\t\t<input type='hidden' name='shp_typ' value='{$shp_typ}'>\r\n\t\t\t<input type='hidden' name='shp_param1' value='{$shp_param1}'>\r\n\t\t\t<input type='hidden' name='shp_item' value='{$shp_item}'>\t\r\n\t\t</p>\r\n\t\t<p>\t\r\n\t\t\t<input type='submit' value='Заплатить {$out_summ} WMZ'>\r\n\t\t</p>\r\n\t\t</form>\r\n\t\t";
print ( ( "<form id=pay name=pay method='POST' action='https://merchant.webmoney.ru/lmi/payment.asp'>\r\n\r\n\t\t<p>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='".$out_summ * 30 )."'>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_DESC' value='{$inv_desc} {$pack_name}'>\r\n\t\t\t<input type='hidden' name='LMI_PAYMENT_NO' value='1'>\r\n\t\t\t<input type='hidden' name='LMI_PAYEE_PURSE' value='R599601246937'>\r\n\t\t\t<input type='hidden' name='LMI_SIM_MODE' value='0'>\r\n\t\t\t\r\n\t\t\t<input type='hidden' name='shp_typ' value='{$shp_typ}'>\r\n\t\t\t<input type='hidden' name='shp_param1' value='{$shp_param1}'>\r\n\t\t\t<input type='hidden' name='shp_item' value='{$shp_item}'>\t\r\n\t\t</p>\r\n\t\t<p>\t\r\n\t\t\t<input type='submit' value='Заплатить ".$out_summ * 30 )." WMR'>\r\n\t\t</p>\r\n\t\t</form>\r\n\t\t";
?>
