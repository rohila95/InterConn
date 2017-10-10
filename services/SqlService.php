<?php
class SqlService{

	public $sql = "";

	public function getUserDetails($emailid,$password)
	{
		$sql="select * from user where email_id='".$emailid. "' and password='".$password. "'";
		return $sql;
	}

	public function getUserDetail($emailid)
	{
		$sql="select * from user where email_id='".$emailid. "'";
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
	public function getChannelGeneral($userid)
	{
		$sql="SELECT channel.channel_id,channel.channel_name,channel.type,channel.purpose,channel.created_by,channel.created_at,user_channel.joined_at FROM `channel`,`user_channel` WHERE channel.channel_id=user_channel.channel_id and user_channel.left_at='0000-00-00 00:00:00' and channel.channel_name='general' and user_channel.user_id=".$userid;
		return $sql;
	}

	public function getUsersWorkspace($workspaceid)
	{
		$sql="SELECT user.user_name,user.first_name,user.last_name,user.profile_pic,user.status,user.status_emoji FROM `user`,`user_workspace` where user.user_id=user_workspace.user_id and user_workspace.workspace_id=".$workspaceid;
		return $sql;
	}

	public function getSpecificChannelDetails($channelid)
	{
		$sql="SELECT channel_id,channel_name,type,purpose,created_by,created_at FROM `channel` WHERE channel_id=".$channelid;
		return $sql;
	}

	public function getChannelMessages($channelid)
	{
		$sql="SELECT message.message_id,user.first_name,message.created_at,message.content FROM `message`,`message_channel`,`user` where message.message_id=message_channel.message_id and message.created_by=user.user_id and is_active=0 and message_channel.channel_id=".$channelid." order by message.created_at";
		return $sql;
	}

	public function getDirectMessages($userid,$messagerUserid)
	{
		$sql="SELECT message.created_by,message.created_at,message.content,message_direct.receiver_id,message.message_id FROM `message`,`message_direct` where message.message_id=message_direct.message_id and ((message.created_by=".$userid." and message_direct.receiver_id=".$messagerUserid.") or (message.created_by=".$messagerUserid." and message_direct.receiver_id=".$userid.")) order by message.created_at";
		return $sql;
	}

	public function createMessage($userid,$content)
	{
		$sql="INSERT INTO `InterConn`.`message` (`message_id`, `created_by`, `created_at`, `message_place`, `content`, `is_threaded`, `is_active`, `edited_at`, `has_shared_content`) VALUES (NULL, '".$userid."', CURRENT_TIMESTAMP, '', '".$content."', '0', '0', '0000-00-00 00:00:00.000000', '0')";
		return $sql;
	}
	public function createChannelMessageMap($channelid,$messageid)
	{
		$sql="INSERT INTO `InterConn`.`message_channel` (`message_id`, `channel_id`) VALUES ('".$messageid."', '".$channelid."')";
		return $sql;
	}
	public function createDirectMessageMap($receiverid,$messageid)
	{
		$sql="INSERT INTO `InterConn`.`message_direct` (`message_id`, `receiver_id`) VALUES ('".$messageid."', '".$receiverid."')";
		return $sql;
	}

}
?>
