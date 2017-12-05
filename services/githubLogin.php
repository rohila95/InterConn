<?php
include_once "./database_connect.php";
include_once "./SqlService.php";
include_once "./WebService.php";
session_start();
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
// echo curl_exec($ch);
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
// echo json_encode($output);
echo $output["login"].'<br>';
echo $output["avatar_url"].'<br>';
echo $output["name"];
echo $output["email"];

$webService = new WebService();
$sql_service = new SqlService();
$database_connection = new DatabaseConnection();
$conn = $database_connection->getConnection();

$_SESSION['githubLogin']=1;
$username=$output["login"];

$checkQuery=$sql_service->checkGitUser($username);
echo $checkQuery;
$result = $conn->query($checkQuery);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $loggedInId = $row['user_id'];
        }
    } else {
        $name=explode(' ',$output["name"]);
        if($name=='')
        {
            $first_name=$output["login"];
            // $last_name=$output["login"];
        }
        else
        {
    		$first_name=$name[0];
    		$last_name=$name[1];
        }
		$email_id=$output["email"];
		$workspaceid=2;
		$profile_pic_pref=2;
		$github_avatar=$output["avatar_url"];



		$newGitUser=$webService->registerNewGitHubUser($username,$first_name,$last_name,$email_id,$workspaceid,$timestamp,$profile_pic_pref,$github_avatar);
		$loggedInId = explode('----',$newGitUser)[1];

    }
$_SESSION['userid'] = $loggedInId;
$_SESSION['loggedIn'] = True;
        
$getUserDetails = $sql_service->getChannelGeneral($_SESSION['userid']);
$result = $conn->query($getUserDetails);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $channelid=$row['channel_id'];
    }
} else {
    echo 'fail';
}
$conn->close();

header("location: ../HomePage.php?channel=".$channelid);

?>