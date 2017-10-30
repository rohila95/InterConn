<?php
include_once("database_connect.php");
include_once("SqlService.php");

class WebService{

  public function getWorkspaceDetails($userid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $sql_service = new SqlService();
    $workspaceDetailsQuery = $sql_service->getWorkspace($userid);
    $result = $conn->query($workspaceDetailsQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getAllWorkspaceDetails()
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $sql_service = new SqlService();
    $workspaceDetailsQuery = $sql_service->getAllWorkspaceDetails();
    $result = $conn->query($workspaceDetailsQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getChannelsDetails($userid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $sql_service = new SqlService();
    $channelsDetailsQuery = $sql_service->getChannels($userid);
    $result = $conn->query($channelsDetailsQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getDirectMessagesDetails($workspaceid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $workspaceid=mysqli_real_escape_string($conn,$workspaceid);
    $sql_service = new SqlService();
    $workspaceUserDetailsQuery = $sql_service->getUsersWorkspace($workspaceid);
    $result = $conn->query($workspaceUserDetailsQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getSpecificChannelDetails($channelid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $channelid=mysqli_real_escape_string($conn,$channelid);
    $sql_service = new SqlService();
    $channelDetailsQuery = $sql_service->getSpecificChannelDetails($channelid);
    $result = $conn->query($channelDetailsQuery);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getUserDetails($emailid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $emailid=mysqli_real_escape_string($conn,$emailid);
    $sql_service = new SqlService();
    $userDetailQuery = $sql_service->getUserDetail($emailid);
    //echo $userDetailQuery;
    $result = $conn->query($userDetailQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getChannelMessages($channelid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $channelid=mysqli_real_escape_string($conn,$channelid);
    $sql_service = new SqlService();
    $channelMessages = $sql_service->getChannelMessages($channelid);
    $result = $conn->query($channelMessages);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
          //get emojis
          $messageid=$row['message_id'];
          $emojiArray=[];
          $messageReactions = $sql_service->getMessageReactions($messageid);
          $innerresult = $conn->query($messageReactions);
          if ($innerresult->num_rows > 0) {
            while($innerrow = $innerresult->fetch_assoc()) {
              $emojiArray[]=$innerrow;
            }
            $row['emojis']=$emojiArray;
          }
          else {
            $row['emojis']=0;
          }
          //get threads
          if($row['is_threaded']==1)
          {
            $messageThreads = $sql_service->getThreadReplyCount($messageid);
            $innerresult = $conn->query($messageThreads);
            if ($innerresult->num_rows > 0) {
              while($innerrow = $innerresult->fetch_assoc()) {

                $lastMessageThreads = $sql_service->getLastThreadReply($messageid);
                $lastThreadresult = $conn->query($lastMessageThreads);
                if ($lastThreadresult->num_rows > 0) {
                  while($lastThreadrow = $lastThreadresult->fetch_assoc()) {
                    $innerrow['content']=$lastThreadrow['content'];
                    $innerrow['created_at']=$lastThreadrow['created_at'];
                    $innerrow['first_name']=$lastThreadrow['first_name'];
                    $innerrow['last_name']=$lastThreadrow['last_name'];
                    $innerrow['profile_pic']=$lastThreadrow['profile_pic'];
                  }
                }

                $row['threads']=$innerrow;
              }
            }


          }

          $array[]= $row;
      }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getThreadMessages($parent_message_id)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $parent_message_id=mysqli_real_escape_string($conn,$parent_message_id);
    $sql_service = new SqlService();
    $threadMessages = $sql_service->getThreadMessages($parent_message_id);
    $result = $conn->query($threadMessages);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
          //get emojis
          $messageid=$row['id'];
          $emojiArray=[];
          $messageReactions = $sql_service->getThreadMessageReactions($messageid);
          $innerresult = $conn->query($messageReactions);
          if ($innerresult->num_rows > 0) {
            while($innerrow = $innerresult->fetch_assoc()) {
              $emojiArray[]=$innerrow;
            }
            $row['emojis']=$emojiArray;
          }
          else {
            $row['emojis']=0;
          }
          $array[]= $row;
      }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function getDirectMessages($userid,$messagerUserid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $messagerUserid=mysqli_real_escape_string($conn,$messagerUserid);
    $sql_service = new SqlService();
    $directMessages = $sql_service->getDirectMessages($userid,$messagerUserid);
    $result = $conn->query($directMessages);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }
  public function getUsersInWorkspaceInvites($workspaceid,$userid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $workspaceid=mysqli_real_escape_string($conn,$workspaceid);
    $sql_service = new SqlService();
    $users = $sql_service->getUserInWorkspace($workspaceid,$userid);
    $result = $conn->query($users);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }
  public function getUsersInWorkspaceChannelInvites($workspaceid,$channelid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $channelid=mysqli_real_escape_string($conn,$channelid);
    $workspaceid=mysqli_real_escape_string($conn,$workspaceid);
    $sql_service = new SqlService();
    $users = $sql_service->getUserInWorkspaceNotInChannel($workspaceid,$channelid);
    // echo $users;
    $result = $conn->query($users);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
              $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }

  public function createChannelMessage($userid,$content,$channelid,$timestamp)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $content=mysqli_real_escape_string($conn,$content);
    $channelid=mysqli_real_escape_string($conn,$channelid);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);
    $sql_service = new SqlService();
    $message = $sql_service->createMessage($userid,$content,$timestamp);
    $result = $conn->query($message);
    if ($result === TRUE) {
        $messageid = $conn->insert_id;
        // echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $message . "<br>" . $conn->error;
    }
    $messageChannelMap = $sql_service->createChannelMessageMap($channelid,$messageid);
    $result = $conn->query($messageChannelMap);
    if ($result === TRUE) {
        echo "New record created successfully. Last inserted ID is: " ;
    } else {
        echo "Error: " . $messageChannelMap . "<br>" . $conn->error;
    }


    $conn->close();
  }
  public function createThreadReply($userid,$content,$parent_message_id,$timestamp)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $content=mysqli_real_escape_string($conn,$content);
    $parent_message_id=mysqli_real_escape_string($conn,$parent_message_id);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);
    $sql_service = new SqlService();
    $message = $sql_service->insertReplyThread($parent_message_id,$content,$userid,$timestamp);
    $result = $conn->query($message);
    if ($result === TRUE) {
        $messageid = $conn->insert_id;
        $updateParentMessage = $sql_service->updateParentThread($parent_message_id);
        $innerresult = $conn->query($updateParentMessage);
        if ($innerresult === TRUE) {
            echo "success-inserted-".$messageid;

           // echo "Updated parent message " ;
        } else {
            echo "fail- " . $updateParentMessage . "<br>" . $conn->error;
        }
    } else {
        echo "fail- " . $message . "<br>" . $conn->error;
    }
    $conn->close();
  }

  public function createDirectMessage($userid,$content,$receiverid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $content=mysqli_real_escape_string($conn,$content);
    $receiverid=mysqli_real_escape_string($conn,$receiverid);
    $sql_service = new SqlService();
    $message = $sql_service->createMessage($userid,$content);
    $result = $conn->query($message);
    if ($result === TRUE) {
        $messageid = $conn->insert_id;
        // echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $message . "<br>" . $conn->error;
    }
    $messageChannelMap = $sql_service->createDirectMessageMap($receiverid,$messageid);
    $result = $conn->query($messageChannelMap);
    if ($result === TRUE) {
        echo "New record created successfully. Last inserted ID is: " ;
    } else {
        echo "Error: " . $messageChannelMap . "<br>" . $conn->error;
    }
    $conn->close();
  }

  public function getFormatDate($timestamp)
  {
    $time = strtotime($timestamp);
    $formattedDate = date("l, F jS, o", $time);
    return $formattedDate;
  }

  public function getFormatTime($timestamp)
  {
    $time = strtotime($timestamp);
    $formattedDate = date("g:i A", $time);
    return $formattedDate;
  }

  public function createChannel($userid,$channelName,$type,$purpose,$timestamp,$invites,$workspaceid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $channelName=mysqli_real_escape_string($conn,$channelName);
    $type=mysqli_real_escape_string($conn,$type);
    $purpose=mysqli_real_escape_string($conn,$purpose);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);
    $workspaceid=mysqli_real_escape_string($conn,$workspaceid);

    $sql_service = new SqlService();

    $channelExist=$sql_service->channelInWorkspace($channelName,$workspaceid);
    $channelExistResult= $conn->query($channelExist);
    if ($channelExistResult->num_rows > 0) {
      echo 'fail-Channel name already exists';
    }
    else
    {
      $channel = $sql_service->createChannel($channelName,$type,$purpose,$userid,$timestamp);
      $result = $conn->query($channel);
      if ($result === TRUE) {
        $channelid = $conn->insert_id;
        echo "id-" . $channelid.".";   
        $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
        $result1 = $conn->query($userChannelMap);
        if ($result1 === TRUE) {
            // echo "New record created successfully. Last inserted ID is: " ;
        } else {
            echo "Error: " . $userChannelMap . "<br>" . $conn->error;
        }
        $channelWorkspaceMap=$sql_service->channelWorkspaceMap($channelid,$workspaceid);
        $result1 = $conn->query($channelWorkspaceMap);
        if ($result1 === TRUE) {
            // echo "New record created successfully. Last inserted ID is: " ;
        } else {
            echo "Error: " . $channelWorkspaceMap . "<br>" . $conn->error;
        }
        foreach ($invites as $id) {
          $userid=mysqli_real_escape_string($conn,$id);
          $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
          $result = $conn->query($userChannelMap);
          if ($result === TRUE) {
              // echo "New record created successfully. Last inserted ID is: ";
          } else {
              echo "Error: " . $userChannelMap . "<br>" . $conn->error;
          }
        }
      } else {
          echo "Error: " . $channel . "<br>" . $conn->error;
      }
    }
    $conn->close();
  }

  public function inviteUser($userids,$channelid,$timestamp)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $channelid=mysqli_real_escape_string($conn,$channelid);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);
    $sql_service = new SqlService();

    foreach ($userids as $id) {
      $userid=mysqli_real_escape_string($conn,$id);
      $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
      $result = $conn->query($userChannelMap);
      if ($result === TRUE) {
          echo "success";
      } else {
          echo "Error: " . $userChannelMap . "<br>" . $conn->error;
      }
    }
    $conn->close();
  }

  public function registerNewUser($username,$first_name,$last_name,$email_id,$profile_pic,$password,$phone_number,$what_i_do,$status,$status_emoji,$skype,$workspaceid,$timestamp)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $username=mysqli_real_escape_string($conn,$username);
    $first_name=mysqli_real_escape_string($conn,$first_name);
    $last_name=mysqli_real_escape_string($conn,$last_name);
    $email_id=mysqli_real_escape_string($conn,$email_id);
    $profile_pic=mysqli_real_escape_string($conn,$profile_pic);
    $password=mysqli_real_escape_string($conn,$password);
    $phone_number=mysqli_real_escape_string($conn,$phone_number);
    $what_i_do=mysqli_real_escape_string($conn,$what_i_do);
    $status=mysqli_real_escape_string($conn,$status);
    $status_emoji=mysqli_real_escape_string($conn,$status_emoji);
    $skype=mysqli_real_escape_string($conn,$skype);
    $workspaceid=mysqli_real_escape_string($conn,$workspaceid);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);
    $sql_service = new SqlService();
    $user = $sql_service->registerNewUser($username,$first_name,$last_name,$email_id,$profile_pic,$password,$phone_number,$what_i_do,$status,$status_emoji,$skype);
    $result = $conn->query($user);
    if ($result === TRUE) {
        $userid = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: ";
        $userWorkspaceMap = $sql_service->userWorkspaceMap($userid,$workspaceid);
        $result = $conn->query($userWorkspaceMap);
        if ($result === TRUE) {
            echo "New record created successfully. Last inserted ID is: ";
        } else {
            echo "Error: " . $userWorkspaceMap . "<br>" . $conn->error;
        }
        //insert into default channels
        $defaultChannels = $sql_service->getDefaultWorkspaceChannels($workspaceid);
        $result = $conn->query($defaultChannels);
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                  $channelid=$row['channel_id'];
                  $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
                  $innerresult = $conn->query($userChannelMap);
                  if ($innerresult === TRUE) {
                      echo "New record created successfully. Last inserted ID is: ";
                  } else {
                      echo "Error: " . $userChannelMap . "<br>" . $conn->error;
                  }
            }
        } else {
            return 'fail';
        }
    } else {
        echo "fail-Email Id already exists. Try with different Email Id.";
    }

    $conn->close();
  }

  public function updateUserDetails($userid,$first_name,$last_name,$emailid,$profile_pic,$password,$phone_number,$whatido,$status,$skype)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $first_name=mysqli_real_escape_string($conn,$first_name);
    $last_name=mysqli_real_escape_string($conn,$last_name);
    $emailid=mysqli_real_escape_string($conn,$emailid);
    if($profile_pic == ""){

    }else{
        $profile_pic=mysqli_real_escape_string($conn,$profile_pic);

    }

    $password=mysqli_real_escape_string($conn,$password);
    $phone_number=mysqli_real_escape_string($conn,$phone_number);
    $whatido=mysqli_real_escape_string($conn,$whatido);
    $status=mysqli_real_escape_string($conn,$status);
    // $status_emoji=mysqli_real_escape_string($conn,$status_emoji);
    $skype=mysqli_real_escape_string($conn,$skype);
    $sql_service = new SqlService();

    if($profile_pic == "") {
        $updateUPQuery = $sql_service->updateUserProfileWOPP($userid, $first_name, $last_name, $emailid, $password, $phone_number, $whatido, $status, $skype);
    }else{
        $updateUPQuery = $sql_service->updateUserProfile($userid, $first_name, $last_name, $emailid, $profile_pic, $password, $phone_number, $whatido, $status, $skype);
    }
    //echo $updateUPQuery;

    $result = $conn->query($updateUPQuery);
    if ($result === TRUE) {
        echo "success-User updated.";
    } else {
        echo "Error: ".$updateUPQuery . "<br>" . $conn->error;
    }
  }

  public function getProfileDetails($userid){

    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $sql_service = new SqlService();
    $profileDetails = $sql_service->getProfileDetails($userid);
    $result = $conn->query($profileDetails);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();

  }

  public function getPublicChannelsDetails($userid)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $sql_service = new SqlService();
    $channelsDetailsQuery = $sql_service->getPublicChannels($userid);
    $result = $conn->query($channelsDetailsQuery);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $array[]= $row;
        }
    } else {
        return 'fail';
    }
    return json_encode($array);
    $conn->close();
  }


}
?>
