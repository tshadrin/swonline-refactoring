<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

echo "<html>\r\n<head>\r\n<title>Pay</title>\r\n</head>\r\n<body>\r\n\r\n<form id=pay name=pay method=\"POST\" action=\"https://merchant.webmoney.ru/lmi/payment.asp\">\r\n\r\n<p>пример платежа через сервис Web Merchant Interface</p>\r\n<p>заплатить 0.1 WMZ...</p>\r\n\r\n<p>\r\n\t<input type=\"hidden\" name=\"LMI_PAYMENT_AMOUNT\" value=\"1.2\">\r\n\t<input type=\"hidden\" name=\"LMI_PAYMENT_DESC\" value=\"Название пакета\">\r\n\t<input type=\"hidden\" name=\"LMI_PAYME";
echo "NT_NO\" value=\"1\">\r\n\t<input type=\"hidden\" name=\"LMI_PAYEE_PURSE\" value=\"Z762169330222\">\r\n\t<input type=\"hidden\" name=\"LMI_SIM_MODE\" value=\"0\">\r\n\t\r\n\t<input type=\"hidden\" name=\"shp_typ\" value=\"4\">\r\n\t<input type=\"hidden\" name=\"shp_param1\" value=\"2\">\r\n\t<input type=\"hidden\" name=\"shp_item\" value=\"1\">\t\r\n</p>\r\n<p>\t\r\n\t<input type=\"submit\" value=\"submit\">\r\n</p>\r\n</form>\r\n\r\n</body>\r\n</html>\r\n";
?>
