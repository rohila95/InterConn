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
	public function getAllWorkspaceDetails()
	{
		$sql="SELECT * FROM `workspace`";
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
		$sql="SELECT channel.channel_id,channel_name,type,purpose,created_by,created_at,count(user_channel.user_id) as usercount FROM `channel`,`user_channel` WHERE channel.channel_id=user_channel.channel_id and channel.channel_id=".$channelid;
		return $sql;
	}

	public function getChannelMessages($channelid)
	{
		$sql="SELECT message.message_id,user.user_id,user.first_name,user.last_name,message.created_at,message.content,message.is_threaded,user.profile_pic FROM `message`,`message_channel`,`user` where message.message_id=message_channel.message_id and message.created_by=user.user_id and is_active=0 and message_channel.channel_id=".$channelid." order by message.created_at";
		return $sql;
	}
	public function getMessageReactions($messageid)
	{
		$sql="SELECT count(*) as count,message_reaction.emoji_id,message_id,emoji.emoji_code,emoji.emoji_pic FROM `message_reaction`,`emoji` where message_reaction.emoji_id=emoji.emoji_id and message_id=".$messageid." group by message_id, message_reaction.emoji_id";
		return $sql;
	}
	public function getThreadMessages($parent_message_id)
	{
		$sql="SELECT threaded_message.id,threaded_message.content,threaded_message.created_at,user.first_name,user.last_name,user.profile_pic FROM `threaded_message`,`user` where threaded_message.created_by=user.user_id and parent_message_id=".$parent_message_id." order by threaded_message.created_at";
		return $sql;
	}
	public function getThreadMessageReactions($threadmessage_id)
	{
		$sql="SELECT count(*) as count,threadmessage_reaction.emoji_id,threadmessage_id,emoji.emoji_code,emoji.emoji_pic FROM `threadmessage_reaction`,`emoji` where threadmessage_reaction.emoji_id=emoji.emoji_id and threadmessage_id=".$threadmessage_id." group by threadmessage_id, threadmessage_reaction.emoji_id";
		return $sql;
	}
	public function insertReplyThread($parentmessageid,$content,$created_by,$timestamp)
	{
		$sql="INSERT INTO `InterConn`.`threaded_message` (`id`, `parent_message_id`, `content`, `created_by`, `created_at`) VALUES (NULL, '".$parentmessageid."', '".$content."', '".$created_by."', '".$timestamp."')";
		return $sql;
	}
	public function updateUserProfile($userid,$first_name,$last_name,$emailid,$profile_pic,$password,$phone_number,$whatido,$status,$skype)
	{
		$sql="UPDATE `InterConn`.`user` SET `first_name` = '$first_name', `last_name` = '$last_name', `email_id` = '$emailid', `profile_pic` = '$profile_pic', `password` = '$password', `phone_number` = '$phone_number', `what_i_do` = '$whatido', `status` = '$status', `skype` = '$skype' WHERE `user`.`user_id` = ".$userid;
		return $sql;
	}
	public function updateParentThread($parentmessageid)
	{
		$sql="UPDATE `InterConn`.`message` SET `is_threaded` = '1' WHERE `message`.`message_id` = ".$parentmessageid;
		return $sql;
	}

	public function getThreadReplyCount($messageid)
	{
		$sql="SELECT count(*) as threadCount FROM `threaded_message` where parent_message_id=".$messageid;
		return $sql;
	}
	public function getLastThreadReply($messageid)
	{
		$sql="SELECT content,created_at,first_name,last_name,profile_pic FROM `threaded_message`,user where threaded_message.created_by=user.user_id and parent_message_id=".$messageid." order by created_at desc limit 1";
		return $sql;
	}
	public function getDirectMessages($userid,$messagerUserid)
	{
		$sql="SELECT message.created_by,message.created_at,message.content,message_direct.receiver_id,message.message_id FROM `message`,`message_direct` where message.message_id=message_direct.message_id and ((message.created_by=".$userid." and message_direct.receiver_id=".$messagerUserid.") or (message.created_by=".$messagerUserid." and message_direct.receiver_id=".$userid.")) order by message.created_at";
		return $sql;
	}

	public function createMessage($userid,$content,$timestamp)
	{
		$sql="INSERT INTO `InterConn`.`message` (`message_id`, `created_by`, `created_at`, `message_place`, `content`, `is_threaded`, `is_active`, `edited_at`, `has_shared_content`) VALUES (NULL, '".$userid."', '".$timestamp."', '', '".$content."', '0', '0', '0000-00-00 00:00:00.000000', '0')";
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

	public function createChannel($channelName,$type,$purpose,$created_by,$timestamp)
	{
		$sql="INSERT INTO `InterConn`.`channel` (`channel_id`, `channel_name`, `type`, `purpose`, `created_by`, `created_at`) VALUES (NULL, '".$channelName."', '".$type."', '".$purpose."', '".$created_by."', '".$timestamp."')";
		return $sql;
	}

	public function createChannelUserMap($userid,$channelid,$timestamp)
	{
		$sql="INSERT INTO `InterConn`.`user_channel` (`user_id`, `channel_id`, `joined_at`, `left_at`, `starred`) VALUES ( '".$userid."',  '".$channelid."',  '".$timestamp."', '0000-00-00 00:00:00', '0')";
		return $sql;
	}

	public function registerNewUser($username,$first_name,$last_name,$email_id,$profile_pic,$password,$phone_number,$what_i_do,$status,$status_emoji,$skype)
	{
		$sql="INSERT INTO `user` (`user_id`, `user_name`, `first_name`, `last_name`, `email_id`, `profile_pic`, `password`, `phone_number`, `what_i_do`, `status`, `status_emoji`, `skype`) VALUES (NULL, '".$username."', '".$first_name."', '".$last_name."', '".$email_id."', '".$profile_pic."', '".$password."', '".$phone_number."', '".$what_i_do."', '".$status."', ".$status_emoji.", '".$skype."')";
		return $sql;
	}

	public function userWorkspaceMap($userid,$workspaceid)
	{
		$sql="INSERT INTO `InterConn`.`user_workspace` (`user_id`, `workspace_id`) VALUES ('".$userid."', '".$workspaceid."')";
		return $sql;
	}

	public function getDefaultWorkspaceChannels($workspaceid)
	{
		$sql="SELECT channel.channel_id FROM `workspace_channel`,`channel` where workspace_channel.channel_id=channel.channel_id and (channel.channel_name='general' or channel.channel_name='random') and workspace_id=$workspaceid";
		return $sql;
	}

	// here a check of whether the user had done the same reaction has to be done, avoiding duplication
	public function insertMessageReaction($userid, $messageid,$emojid,$timestamp){

        $sql="INSERT INTO `InterConn`.`message_reaction` (`message_id`,`emoji_id`,`created_by`,`created_at`, `message_reaction_id`) VALUES ('".$messageid."', '".$emojid."', '".$userid."','".$timestamp."',NULL )";
        return $sql;
	}

	public function deleteIfMessageReactionExist($userid, $messageid,$emojid){

        $sql= "DELETE FROM `InterConn`.`message_reaction` WHERE `message_reaction`.`message_id` = ".$messageid." and emoji_id=".$emojid." and created_by=".$userid;
        return $sql;
	}

    public function getSpecificMessageReaction($userid, $messageid,$emojid){

        $sql= "SELECT * FROM `InterConn`.`message_reaction` WHERE `message_reaction`.`message_id` = ".$messageid." and emoji_id=".$emojid." and created_by=".$userid;
        return $sql;
    }

	public function getSpecificMessageReactionEmojiCount( $messageid,$emojid){
        $sql= "SELECT COUNT (*) FROM `InterConn`.`message_reaction` WHERE `message_reaction`.`message_id` = ".$messageid." and `message_reaction`.`emoji_id`=".$emojid;
        return $sql;
	}


	public function getProfileDetails($user_id){
		$sql = "SELECT * FROM `InterConn`.`user` WHERE `user`.`user_id` = ". $user_id;
		return $sql;
	}

	public function getPublicChannels($user_id){
		// echo $user
		$sql="SELECT * FROM `channel`,`user_channel` WHERE channel.channel_id=user_channel.channel_id and user_channel.user_id=".$user_id." and channel.type='public'";
		return $sql;
	}


}
?>
