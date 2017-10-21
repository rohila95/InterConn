<?php


include_once "./services/ReactionService.php";

$reactionService = new ReactionService();

if(isset($_POST["setReaction"])){


	$reactionService -> postReaction();

	$postInput={};
	foreach($_POST as $key => $value){

	}

	
}


?>