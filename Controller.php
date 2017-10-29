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
  $workspaceid=$data->workspaceid;
  $timestamp=date('Y-m-d H:i:s', time());
  $invites=$data->invites;
  echo $webService->createChannel($userid,$channelName,$type,$purpose,$timestamp,$invites,$workspaceid);
}

if(isset($_POST["createThreadReply"]))
{
  $data=json_decode($_POST["createThreadReply"]);
  $userid=$_SESSION['userid'];
  $content=$data->threadreply_msgcontent;
  $parent_message_id=$data->parent_message_id;
  $timestamp=date('Y-m-d H:i:s', time());
  echo $webService->createThreadReply($userid,$content,$parent_message_id,$timestamp);
}
if(isset($_POST["getThreadMessages"]))
{
  $data=json_decode($_POST["getThreadMessages"]);
  $parent_message_id=$data->parentmessageid;
  echo  $webService->getThreadMessages($parent_message_id);
}

if(isset($_POST["updateProfile"]))
{

  $fname=$_FILES['filetoUpload']['tmp_name'];

  $file_name=$_POST["file_name"];
  $file_name=explode('\\', $file_name);
  $file_ext=explode('.', $file_name[2]);
  $uploadfile_newname='./images/'.$_SESSION['userid'].'.'.$file_ext[1];
  $uploadSucess = move_uploaded_file($fname, $uploadfile_newname);
  if($uploadSucess){
    echo "success";
  }else{
    echo "fail";
  }
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $whatIDo = $_POST["whatIDo"];
  $status = $_POST["status"];
  $phoneNumber = $_POST["phoneNumber"];
  $skype = $_POST["skype"];
  $userid=$_SESSION['userid'];
  echo $webService->updateUserDetails($userid,$firstName,$lastName,$email,$uploadfile_newname,$password,$phoneNumber,$whatIDo,$status,$skype);

}


if(isset($_POST["getWorkspaceUsers"]))
{
  // echo 'in cont';
  $data=json_decode($_POST["getWorkspaceUsers"]);
  $userid=$data->userid;
  $workspaceid=$data->workspaceid;
  echo  $webService->getUsersInWorkspaceInvites($workspaceid,$userid);
}

if(isset($_POST["getChannelUsers"]))
{
  // echo 'in cont';
  $data=json_decode($_POST["getChannelUsers"]);
  $channelid=$data->channelid;
  $workspaceid=$data->workspaceid;
  echo  $webService->getUsersInWorkspaceChannelInvites($workspaceid,$channelid);
}
if(isset($_POST["inviteToChannel"]))
{
  // echo 'in cont';
  $data=json_decode($_POST["inviteToChannel"]);
  $ids=$data->ids;
  $channelid=$data->channelid;
  $timestamp=date('Y-m-d H:i:s', time());
  echo  $webService->inviteUser($ids,$channelid,$timestamp);
}
?>
