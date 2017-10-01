<?php
class WebService
{
	public $sql = "";

	public function getUserDetails($emailid,$password)
	{
		$sql="select * from user where email_id='".$emailid. "'and password='".$password. "';";
		return $sql;
	}
}


?>