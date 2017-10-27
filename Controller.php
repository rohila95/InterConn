<?php
session_start();
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
include_once "./services/ReactionService.php";
include_once "./services/WebService.php";
$postInputObj= [];

// echo "hello";
// to read the $_Post incoming values in to an object
if($_POST){
    foreach($_POST as $key => $value){
        $postInputObj[$key] = $value;
    }
}
$reactionService = new ReactionService();
$webService = new WebService();
if(isset($_POST["setReaction"])){ // to post a react by a

   //echo "inside controller";
  //print_r(json_encode($postInputObj));
  echo  $reactionService -> postReactionIfNotExist($postInputObj, $_SESSION['userid']);
}

if(isset($_POST["register"])){ // to post a react by a
	$data=json_decode($_POST["register"]);
	// var_dump($data);
    $firstName = $data->firstName;
    $lastName = $data->lastName;
    $email = $data->email;
    $password = $data->password;  
    $whatIDo = $data->whatIDo;
    $status = $data->status;
    $phoneNumber = $data->phoneNumber;
    $skype = $data->skype;
    $username='@'.strtolower($firstName);
    $timestamp=date('Y-m-d H:i:s', time());
    $workspaceid=$data->workspace;
    $webService->registerNewUser($username,$firstName,$lastName,$email,' ',$password,$phoneNumber,$whatIDo,$status,1,$skype,$workspaceid,$timestamp);
  
    // echo 'register';
}
if(isset($_POST["getworkspaces"]))
{
  echo  $webService->getAllWorkspaceDetails();
}
if(isset($_POST["createChannel"]))
{
  $data=json_decode($_POST["createChannel"]);
  $userid=$_SESSION['userid'];
  $channelName=$data->name;
  $type=$data->type;
  $purpose=$data->purpose;
  $timestamp=date('Y-m-d H:i:s', time());
  $invites=$data->invites;
  echo $webService->createChannel($userid,$channelName,$type,$purpose,$timestamp,$invites);
}
?>