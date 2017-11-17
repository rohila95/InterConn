<?php
session_start();
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
include_once "./services/ReactionService.php";
include_once "./services/WebService.php";
include_once "./services/MainMessages.php";

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

    if(isset($_POST["isToThreadReply"])){ //
        $isToThreadReply = true;
        echo  $reactionService -> postReactionToThreadIfNotExist($postInputObj, $_SESSION['userid']);

    }else{
        echo  $reactionService -> postReactionIfNotExist($postInputObj, $_SESSION['userid']);

    }

   //echo "inside controller";
  //print_r(json_encode($postInputObj));


}
if(isset($_POST["retrieveOldMessages"]))
{
  $data=json_decode($_POST["retrieveOldMessages"]);
  $channelid=$data->channelid;
  $lastmessageid=$data->lastmessageid;
  constructMessagesDiv($webService->getChannelMessages($channelid,$lastmessageid));
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
    if($firstName=="" || $firstName==" " || strlen($firstName)>20)
    {
      echo 'fail-First Name cannot be empty. First Name can\'t be more than 20 characters.';
    }
    else if($lastName=="" || $lastName==" " || strlen($lastName)>20)
      {
        echo 'fail-Last Name cannot be empty. Last Name can\'t be more than 20 characters.';
      }
    else if($email=="" || $email==" " || strlen($email)>50)
      {
        echo 'fail-Email cannot be empty. Email can\'t be more than 50 characters.';
      }
    else if($password=="" || $password==" " || strlen($password)>20)
      {
        echo 'fail-Password cannot be empty. Password can\'t be more than 20 characters.';
      }

    else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
      {
        echo 'fail-Enter a vaild Email id.';
      }
      else if(strlen($whatIDo)>200)
      {
        echo 'fail-What I Do can\'t be more than 200 characters.';
      }
      else if(strlen($status)>200)
      {
        echo 'fail-Status can\'t be more than 200 characters.';
      }
      else if(strlen($skype)>50)
      {
        echo 'fail-Skype can\'t be more than 50 characters.';
      }
      else if(strlen($phoneNumber)!='' && (strlen($phoneNumber)<10 || strlen($phoneNumber)>12 || !(is_numeric($phoneNumber)== 1)))
          {
              echo 'fail-Phone number should be 10 digits.';
          }
    else
      {
        $username='@'.strtolower($firstName);
        $timestamp=date('Y-m-d H:i:s', time());
        $workspaceid=$data->workspace;
        $webService->registerNewUser($username,$firstName,$lastName,$email,' ',$password,$phoneNumber,$whatIDo,$status,1,$skype,$workspaceid,$timestamp);

      }
}
if(isset($_POST["getworkspaces"]))
{
  echo  $webService->getAllWorkspaceDetails();
}
if(isset($_POST["archieveChannel"]))
{
  $channelid=$_POST["archieveChannel"];
  echo  $webService->archieveChannel($channelid);
}
if(isset($_POST["unArchieveChannel"]))
{
  $channelid=$_POST["unArchieveChannel"];
  echo  $webService->unArchieveChannel($channelid);
}


if(isset($_POST["deleteMessage"]))
{
  $messageid=$_POST["deleteMessage"];
  echo  $webService->deleteMessage($messageid);
}
if(isset($_POST["deleteThreadedMessage"]))
{
  $messageid=$_POST["deleteThreadedMessage"];
  $parentmsgid= $_POST["parentMessageID"];
  //echo $messageid." ".$parentmsgid;
  echo  $webService->deleteThreadedMessage($messageid, $parentmsgid);
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
  // echo $type;
  if($channelName=="" || $channelName==" " || strlen($channelName)>40)
    {
      echo 'fail-Channel Name cannot be empty. Channel Name can\'t be more than 40 characters.';
    }
    else if(strlen($purpose)>40)
    {
      echo 'fail-Purpose can\'t be more than 40 characters.';
    }
  else if($type=="")
    {
      echo 'fail-Please select type of channel.';
    }
  else
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
   // print_r(json_encode($postInputObj));

    $file_name=$_POST["file_name"];
    $uploadfile_newname ='';
      $firstName = $_POST["firstName"];
      $lastName = $_POST["lastName"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $whatIDo = $_POST["whatIDo"];
      $status = $_POST["status"];
      $phoneNumber = $_POST["phoneNumber"];
      $skype = $_POST["skype"];
      $userid=$_SESSION['userid'];
      $valid_file_extensions = array("jpg", "jpeg", "png", "PNG", "JPG","JPEG");
   // echo "strlen phoneNumber :".strlen($phoneNumber).is_numeric($phoneNumber);

    if($firstName=="" || $firstName==" " || strlen($firstName)>20)
    {
      echo 'fail-First Name cannot be empty. First Name can\'t be more than 20 characters.';
    }
    else if($lastName=="" || $lastName==" " || strlen($lastName)>20)
      {
        echo 'fail-Last Name cannot be empty. Last Name can\'t be more than 20 characters.';
      }
    else if($email=="" || $email==" " || strlen($email)>50)
      {
        echo 'fail-Email cannot be empty.  Email can\'t be more than 50 characters.';
      }
    else if($password=="" || $password==" " || strlen($password)>20)
      {
        echo 'fail-Password cannot be empty. Password can\'t be more than 20 characters.';
      }
//    else if(strlen($phoneNumber)!="" || ){
//        echo "is_numeric(phoneNumber):".is_numeric($phoneNumber);
//        if(strlen($phoneNumber)<10 || strlen($phoneNumber)>12 || !(is_numeric($phoneNumber)== 1))
//        {
//            echo 'fail-Phone number should not 10 to 12 digits long.';
//        }else{
//            echo "in esle of phone check ";
//        }
//    }
    else if(strlen($phoneNumber)!='' && (strlen($phoneNumber)<10 || strlen($phoneNumber)>12 || !(is_numeric($phoneNumber)== 1)))
    {
            echo 'fail-Phone number should be of  10 to 12 digits long.';
    }
    else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
      {
        echo 'fail-Enter a vaild Email id.';
      }
    else if(strlen($whatIDo)>200)
      {
        echo 'fail-What I Do can\'t be more than 200 characters.';
      }
      else if(strlen($status)>200)
      {
        echo 'fail-Status can\'t be more than 200 characters.';
      }
      else if(strlen($skype)>50)
      {
        echo 'fail-Skype can\'t be more than 50 characters.';
      }

    else
    {
      if($file_name==""){

          echo $webService->updateUserDetails($userid,$firstName,$lastName,$email,$uploadfile_newname,$password,$phoneNumber,$whatIDo,$status,$skype);
      }else{
          $fname=$_FILES['filetoUpload']['tmp_name'];
          $file_name=explode('\\', $file_name);
          $file_ext=explode('.', $file_name[2]);
          if($file_ext[1] == "png"){
              $file_ext[1] == "PNG";
          }
          $uploadfile_newname='./images/'.$_SESSION['userid'].'.'.$file_ext[1];
          // echo $file_ext[1];
          if (!in_array($file_ext[1], $valid_file_extensions)) {
              echo 'fail-Invalid Image. Try another image.';
          }else{

              $uploadSucess = move_uploaded_file($fname, $uploadfile_newname);
              if(!$uploadSucess)
              {
                  echo 'fail-Image too large. Try small image.';
              }else{
                  echo $webService->updateUserDetails($userid,$firstName,$lastName,$email,$uploadfile_newname,$password,$phoneNumber,$whatIDo,$status,$skype);
              }
          }

      }
    }
}


if(isset($_POST["getWorkspaceUsers"]))
{
  // echo 'in cont';
  $data=json_decode($_POST["getWorkspaceUsers"]);
  $userid=$data->userid;
  $workspaceid=$data->workspaceid;
  // following line commented thinking that even the user being logged in has to be in the suggestion list to add
  //echo  $webService->getUsersInWorkspaceInvites($workspaceid,$userid);
    echo  $webService->getAllUsersInWorkspace($workspaceid);
}
if(isset($_POST["getWorkspaceUsersByInput"]))
{
  $data=json_decode($_POST["getWorkspaceUsersByInput"]);
  $inputString=$data->inputString;
  $workspaceid=$data->workspaceid;
  echo  $webService->getUsersInWorkspaceByInput($workspaceid,$inputString);
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
    $useridArr=$data->ids;
  $channelid=$data->channelid;
  $timestamp=date('Y-m-d H:i:s', time());
  if($useridArr!=[])
    echo  $webService->inviteUser($useridArr,$channelid,$timestamp);
  else
    echo 'fail-Please select atleast one member to invite.';
}
if(isset($_POST["removeFromChannel"]))
{
  // echo 'in cont';
  $data=json_decode($_POST["removeFromChannel"]);
  $useridArr=$data->ids;
  $channelid=$data->channelid;
  $timestamp=date('Y-m-d H:i:s', time());
  if($useridArr!=[])
    echo  $webService->leaveChannel($useridArr,$channelid,$timestamp);
  else
    echo 'fail-Please select a member to remove from channel.';
}
if(isset($_POST["getProfileDetails"]))
{
  echo $webService->getProfileDetails($_SESSION['userid']);
}

?>
