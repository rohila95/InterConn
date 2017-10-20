<?php
include("database_connect.php");
include("SqlService.php");

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
            // $row['date']= getFormatDate($row['created_at']);
            // $row['time']= getFormatTime($row['created_at']);
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
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $messageChannelMap = $sql_service->createChannelMessageMap($channelid,$messageid);
    $result = $conn->query($messageChannelMap);
    if ($result === TRUE) {
        echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $messageChannelMap = $sql_service->createDirectMessageMap($receiverid,$messageid);
    $result = $conn->query($messageChannelMap);
    if ($result === TRUE) {
        echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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

  public function createChannel($userid,$channelName,$type,$purpose,$created_by,$timestamp,$invites)
  {
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $userid=mysqli_real_escape_string($conn,$userid);
    $channelName=mysqli_real_escape_string($conn,$channelName);
    $type=mysqli_real_escape_string($conn,$type);
    $purpose=mysqli_real_escape_string($conn,$purpose);
    $created_by=mysqli_real_escape_string($conn,$created_by);
    $timestamp=mysqli_real_escape_string($conn,$timestamp);

    $sql_service = new SqlService();

    $channel = $sql_service->createChannel($channelName,$type,$purpose,$created_by,$timestamp);
    $result = $conn->query($channel);
    if ($result === TRUE) {
        $channelid = $conn->insert_id;
        // echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
    $result = $conn->query($userChannelMap);
    if ($result === TRUE) {
        echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    foreach ($invites as $id) {
      $userid=mysqli_real_escape_string($conn,$id);
      $userChannelMap = $sql_service->createChannelUserMap($userid,$channelid,$timestamp);
      $result = $conn->query($userChannelMap);
      if ($result === TRUE) {
          echo "New record created successfully. Last inserted ID is: " . $last_id;
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
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
          echo "New record created successfully. Last inserted ID is: " . $last_id;
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    $conn->close();
  }

}
?>
