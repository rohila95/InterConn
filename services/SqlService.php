<?php
class SqlService
{
	public $sql = "";

	public function getUserDetails($emailid,$password)
	{
		$sql="select * from user where email_id='".$emailid. "'and password='".$password. "';";
		return $sql;
	}

	public function getWorkspace($userid)
	{
		$sql="SELECT workspace.workspace_id,workspace.workspace_name,workspace.workspace_domain,workspace.created_by,workspace.created_at FROM `workspace`,`user_workspace` where user_workspace.workspace_id=workspace.workspace_id and user_workspace.user_id=".$userid;
		return $sql;
	}

	public function getChannels($userid)
	{
		$sql="SELECT channel.channel_id,channel.channel_name,channel.type,channel.purpose,channel.created_by,channel.created_at,user_channel.joined_at FROM `channel`,`user_channel` WHERE channel.channel_id=user_channel.channel_id and user_channel.left_at='0000-00-00 00:00:00' and user_channel.user_id=".$userid;
		return $sql;
	}

	public function getUsersWorkspace($workspaceid)
	{
		$sql="SELECT user.user_name,user.first_name,user.last_name,user.profile_pic,user.status,user.status_emoji FROM `user`,`user_workspace` where user.user_id=user_workspace.user_id and user_workspace.workspace_id=".$workspaceid;
		return $sql;
	}

}


?>
