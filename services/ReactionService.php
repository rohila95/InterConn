<?php
session_start();
include_once("database_connect.php");
include_once("SqlService.php");


class ReactionService{

// Method to take post a reaction to a particular message
  public function postReactionIfNotExist($postInputObj)
  {
      print_r($postInputObj);

      echo "hello". $_SESSION['userid'];
      $userid = $_SESSION['userid'];
     $database_connection = new DatabaseConnection();
     $conn = $database_connection->getConnection();
     $userid = mysqli_real_escape_string($conn,$userid);
     $messageid= mysqli_real_escape_string($conn,$postInputObj['message_id']);
     $emojid= mysqli_real_escape_string($conn,$postInputObj['emoji_id']);

      $sql_service = new SqlService();

      $getSpecificMessageReactionSQLQuery = $sql_service->getSpecificMessageReaction($userid, $messageid,$emojid);

     $result = $conn->query($getSpecificMessageReactionSQLQuery);
     if ($result->num_rows > 0) { // meaning there exist the same reaction already

         $deleteMessageReactionSQLQuery =  $sql_service->deleteIfMessageReactionExist($userid, $messageid,$emojid);
         $conn->query($deleteMessageReactionSQLQuery);

         if ($conn->affected_rows() > 0) {
             return "success-deleted";
         }
     } else { // there isn't this reaction by the current user, insert one
         $timestamp = date('Y-m-d H:i:s', time());
         $insertMessageReactionSQLQuery =  $sql_service->insertMessageReaction($userid, $messageid,$emojid,$timestamp);
         $isInserted = $conn->query($insertMessageReactionSQLQuery);
         if ($isInserted === TRUE) {
             return "success-inserted";
         }
     }
      $conn->close();
      return 'fail';
  }


  /**
  * Helper methods follows below
  */
    

}

?>