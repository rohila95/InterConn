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
}
?>