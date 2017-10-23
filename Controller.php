<?php
session_start();
include_once "./services/ReactionService.php";

$postInputObj= [];
// to read the $_Post incoming values in to an object
if($_POST){
    foreach($_POST as $key => $value){
        $postInput[$key] = $value;
    }
}

if(isset($_POST["setReaction"])){ // to post a react by a

    $reactionService = new ReactionService();
    print_r(json_encode($postInputObj));
    $reactionService -> postReaction($postInputObj);
}


?>