<?php
class WebService
{
	public $sql = "";

	public function getUserDetails($emailid,$password)
	{
		$sql="select * from user where email_id='".  mysqli_real_escape_string($emailid) . "'and password='".  mysqli_real_escape_string($password) . "';";
		return $sql;
	}
}


?>