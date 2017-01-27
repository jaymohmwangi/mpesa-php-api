<?php



$URL_WSDL = "https://safaricom.co.ke/mpesa_online/lnmo_checkout_server.php?wsdl";


$CALLBACK_URL = "http://noratasinasi.com/mpesaTest/MPESA/processcheckout.php";
$CALL_BACK_METHOD = "POST";
 
$PAYBILL_NO = "898998";
$PASSKEY = "ada798a925b5ec20cc331c1b0048c88186735405ab8d59f968ed4dab89da5515";
$PRODUCT_ID = "1717171717171";
$MERCHENTS_ID = $PAYBILL_NO;

$MERCHANT_TRANSACTION_ID = generateRandomString();

$PASSWORD_ENCRYPT = base64_encode(hash("sha256", $MERCHANTS_ID.$PASSKEY.$TIMESTAMP));
$PASSWORD = strtoupper($PASSWORD_ENCRYPT);
$TIMESTAMP = date("Y-m-d H:i:s",time());
$AMOUNT = $_POST['amount'];
$NUMBER = $_POST['number']; 

$body = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:tns="tns:ns" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"><soapenv:Header><tns:CheckOutHeader><MERCHANT_ID>'.$PAYBILL_NO.'</MERCHANT_ID><PASSWORD>ZTcxY2M3M2U1ZDM1ZGEyZTRiN2UyNGUyNDk0NGQwOTVkMzgzOTNmN2UzOTEzN2RlNDE1N2M0ZjViNDIzMWU0Yw==</PASSWORD><TIMESTAMP>20160426121448</TIMESTAMP></tns:CheckOutHeader></soapenv:Header><soapenv:Body><tns:processCheckOutRequest><MERCHANT_TRANSACTION_ID>'.$MERCHANT_TRANSACTION_ID.'</MERCHANT_TRANSACTION_ID><REFERENCE_ID>'.$PRODUCT_ID.'</REFERENCE_ID><AMOUNT>'.$AMOUNT.'</AMOUNT><MSISDN>'.$NUMBER.'</MSISDN><ENC_PARAMS></ENC_PARAMS><CALL_BACK_URL>'.$CALLBACK_URL.'</CALL_BACK_URL><CALL_BACK_METHOD>'.$CALL_BACK_METHOD.'</CALL_BACK_METHOD><TIMESTAMP>20160426121448</TIMESTAMP></tns:processCheckOutRequest></soapenv:Body></soapenv:Envelope>'; /// Your SOAP XML needs to be in this variable

try{

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $URL_WSDL); 
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_VERBOSE, '0');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
$output = curl_exec($ch);


if(curl_errno($ch))
{
    echo 'Error:'.curl_errno($ch).' Curl error: ' . curl_error($ch);
}
print_r($output);
}
catch(Exception $ex){
echo $ex;
}
curl_close($ch);
function generateRandomString() {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>