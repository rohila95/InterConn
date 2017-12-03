<?php
include_once "./database_connect.php";
include_once "./SqlService.php";

define('clientID', '209a35200a7fe455f866');
define('clientSecret', 'b4a3590e45aef0c065b00e1d4c2cda7763ed5cc5');
//github login qav2
define('appName', 'InterConn_Dev');

//github login docker
// define('appName', 'InterConn_Dev');

$url = 'https://github.com/login/oauth/access_token';

$fields = array(
        'client_id' => urlencode(clientID),
        'client_secret' => urlencode(clientSecret),
        'code' => urlencode($_GET['code'])
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post

$result = json_decode(curl_exec($ch),TRUE);
echo $result["access_token"];
//close connection
curl_close($ch);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://api.github.com/user?access_token=".$result["access_token"]);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_USERAGENT,'http://developer.github.com/v3/#user-agent-required');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

$output=json_decode(curl_exec($ch),TRUE);
curl_close($ch);
echo $output["login"].'<br>';
echo $output["avatar_url"].'<br>';

?>