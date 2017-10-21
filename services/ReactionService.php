<?php
include("database_connect.php");
include("SqlService.php");

class ReactionService{

// Method to take post a reaction to a particular message
  public function postReaction()
  {

    $ $_POST['email'],$_POST['password']

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


  /**
  * Helper methods follows below
  */

  public 




}

?>