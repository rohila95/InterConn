<?php
include_once("database_connect.php");
include_once("SqlService.php");


class ReactionService{

// Method to take post a reaction to a particular message
  public function postReactionIfNotExist($postInputObj,$useridFromSession)
  {
      //print_r($postInputObj);

       //echo "hello".$useridFromSession;
     $userid = $useridFromSession;
     $database_connection = new DatabaseConnection();
     $conn = $database_connection->getConnection();
     $userid = mysqli_real_escape_string($conn,$userid);
     $messageid= mysqli_real_escape_string($conn,$postInputObj['message_id']);
     $emojid= mysqli_real_escape_string($conn,$postInputObj['emoji_id']);

      $sql_service = new SqlService();

      $getSpecificMessageReactionSQLQuery = $sql_service->getSpecificMessageReaction($userid, $messageid,$emojid);
      //echo $getSpecificMessageReactionSQLQuery;
     $result = $conn->query($getSpecificMessageReactionSQLQuery);
     if ($result->num_rows > 0) { // meaning there exist the same reaction already

         // delete the existing Reaction
         $deleteMessageReactionSQLQuery =  $sql_service->deleteIfMessageReactionExist($userid, $messageid,$emojid);
         //echo $deleteMessageReactionSQLQuery;
         $conn->query($deleteMessageReactionSQLQuery);

         if ($conn->affected_rows > 0) {
            
             return "success-deleted";
         }
     } else { // there isn't this reaction by the current user, insert one
         $timestamp = date('Y-m-d H:i:s', time());
         $insertMessageReactionSQLQuery =  $sql_service->insertMessageReaction($userid, $messageid,$emojid,$timestamp);
        //echo $insertMessageReactionSQLQuery;
         $isInserted = $conn->query($insertMessageReactionSQLQuery);
         if ($isInserted === TRUE) {
        
             return "success-inserted";
         }
     }
      $conn->close();
      return 'fail';
  }


    // Method to take post a reaction to a particular message
    public function postReactionToThreadIfNotExist($postInputObj,$useridFromSession)
    {
        //print_r($postInputObj);

        //echo "hello".$useridFromSession;
        $userid = $useridFromSession;
        $database_connection = new DatabaseConnection();
        $conn = $database_connection->getConnection();
        $userid = mysqli_real_escape_string($conn,$userid);
        $messageid= mysqli_real_escape_string($conn,$postInputObj['message_id']);
        $emojid= mysqli_real_escape_string($conn,$postInputObj['emoji_id']);

        $sql_service = new SqlService();

        $getSpecificThreadMessageReactionSQLQuery = $sql_service->getSpecificThreadMessageReaction($userid, $messageid,$emojid);
//        echo $getSpecificThreadMessageReactionSQLQuery;
        $result = $conn->query($getSpecificThreadMessageReactionSQLQuery);
        if ($result->num_rows > 0) { // meaning there exist the same reaction already

            // delete the existing Reaction
            $deleteThreadMessageReactionSQLQuery =  $sql_service->deleteIfThreadMessageReactionExist($userid, $messageid,$emojid);
//            echo $deleteThreadMessageReactionSQLQuery;
            $conn->query($deleteThreadMessageReactionSQLQuery);

            if ($conn->affected_rows > 0) {

                return "success-deleted";
            }
        } else { // there isn't this reaction by the current user, insert one
            $timestamp = date('Y-m-d H:i:s', time());
            $insertThreadMessageReactionSQLQuery =  $sql_service->insertThreadMessageReaction($userid, $messageid,$emojid,$timestamp);
//            echo $insertThreadMessageReactionSQLQuery;
            $isInserted = $conn->query($insertThreadMessageReactionSQLQuery);
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