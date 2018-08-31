<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2018/8/23
 * Time: 12:40
 */
header("content-Type: text/html; charset=UTF-8");
$remark = $_POST['notice'] ? $_POST['notice'] : "default";
$amount = $_POST['faceValue'];
$bankCode = $_POST['payType'];
$apiUrl = "http://pay.txpays.com"; //api地址
$merchantCode = "100018"; //商户号
$tokenKey = "b910eab1aca238bdb4c9d8b5ec65da4a"; //秘钥
$orderId = "AGS".date('YmdHis'.rand(100,999),time());
$submitUrl = "http://".$_SERVER['SERVER_NAME'];

$data = [
    "MerchantCode" => $merchantCode,
    "BankCode"     => $bankCode,
    "Amount"       => number_format($amount,2,'.',''),
    "OrderId"      => $orderId,
    "NotifyUrl"    => $submitUrl,
    "ReturnUrl"    => $submitUrl,
    "OrderDate"    => time(),
    "Remark"       => $remark
];
$signText = 'MerchantCode=['.$data['MerchantCode'].']OrderId=['.$data['OrderId'].']Amount=['.$data['Amount'].']NotifyUrl=['.
    $data['NotifyUrl'].']OrderDate=['.$data['OrderDate'].']BankCode=['.$data['BankCode'].']TokenKey=['.$tokenKey.']';
$data["Sign"] = strtoupper(md5($signText));

$sHtml = "<form name='paySubmit' action='".$apiUrl."' method='post'>";
foreach ($data as $key => $val) {
    $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
}
$sHtml.= "</form>";
$sHtml.= "<script>document.forms['paySubmit'].submit();</script>";
echo $sHtml;