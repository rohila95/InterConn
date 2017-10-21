<?php

include("ReactionService.php");

$reactionService = new ReactionService();

if(isset($_POST["setReaction"])){

		# Get JSON as a string
	$json_str = file_get_contents('php://input');
	# Get as an object
	$json_obj = json_decode($json_str);
	echo print_r($json_obj);
	//return $reactionService.postReaction();
}








?>