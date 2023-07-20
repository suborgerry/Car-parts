<?php
function send($url, $data = null, $checkCert = true) {
 $curl = curl_init();
 curl_setopt($curl, CURLINFO_HEADER_OUT, true);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
 //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $checkCert);
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $checkCert);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
 curl_setopt($curl, CURLOPT_POSTREDIR, true);
 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_POST, true);
 if (is_string($data)) {
 $data = json_decode($data, true);
 }
if (empty($data) || !is_array($data)) {
 return false;
 }
 // Content-Type: application/x-www-form-urlencoded
 $data = http_build_query($data);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
 $response = curl_exec($curl);
 $errCode = curl_errno($curl);
 $errText = curl_error($curl);
 curl_close($curl);
 if (!empty($errCode)) {
 $response = array(
 'code' => $errCode,
 'text' => $errText
 );
 }
return $response;
}
$url = 'https://express.pasts.lv/...';
$data = '{...}';
$response = send($url, $data);
if (!is_array($response)) {
 // JSON data
$data = json_decode($response, true)
 // PDF data
$f = fopen('output.pdf', 'w');
 fwrite($f, $response);
 fclose($f);
} else {
 die("ERROR ({$response['code']}): {$response['text']}");
}