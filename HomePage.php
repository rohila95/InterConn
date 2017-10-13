<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	include_once "./services/WebService.php";
	if($_SESSION['loggedIn'])
	{
		$web_service = new WebService();

    $userDetails = json_decode($web_service->getUserDetails($_SESSION['emailid']));
    $workspaceDetails = json_decode($web_service->getWorkspaceDetails($_SESSION['userid']));
    $workspaceName=$workspaceDetails[0]->workspace_name;

    $channelDetails = json_decode($web_service->getChannelsDetails($_SESSION['userid']));
    $directMessagesDetails = json_decode($web_service->getDirectMessagesDetails($workspaceDetails[0]->workspace_id));

   	$channelstr='';
   	$directMessagestr='';
		if ($channelDetails!='')
		{
	   foreach($channelDetails as $channel)
	   {
	   		if($channel->channel_id==$_GET["channel"])
		   		$channelstr.='<li class="active currentChannel">';
		   	else
		   		$channelstr.='<li class="active">';
	   		if($channel->type=='private')
	   			$channelstr.=' <a href="./HomePage.php?channel='.$channel->channel_id.'#latest"><span class="channelPrivacyLevel"><i class="fa fa-lock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	   		else
	   			$channelstr.='<a href="./HomePage.php?channel='.$channel->channel_id.'#latest"><span class="channelPrivacyLevel"><i class="fa fa-unlock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	   		$channelstr.='</li>';
	   }
			}
		if ($directMessagesDetails!='')
		{
	   foreach($directMessagesDetails as $directMessage)
	   {
	   		$directMessagestr.=' <li touserid="" class="active"><a href="#"> <span class="channelPrivacyLevel"><i class="fa fa-dot-circle-o"></i></span><span class="'.$directMessage->first_name.'" >'.htmlspecialchars($directMessage->first_name).' '.htmlspecialchars($directMessage->last_name).'</span></a></li>';
	   }
			}
	}
	if(!$_SESSION['loggedIn'] || !isset($_GET["channel"]) || $_GET["channel"]=='')
	{
		header("location: ./index.php?status=notloggedin");
	}
?>
<html>
	<head>
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./CSS/home_site.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-1 verticle_navbar_HP">

				<div class="row menu_leftMain_HP">
					<div class="leftMenuContentWrapper_HP" >
						<div class="row title_main_HP"> 
							<h3> InterConn  </h3>
						</div>
						<div class="loginDetails">
							<span class="loggedIn_user"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php  echo $userDetails[0]->first_name; ?> </span><br>
							<span class="loggedIn_user"><i class="fa fa-globe"></i>&nbsp;&nbsp;<?php  echo $workspaceName; ?></span> <br>
							
							
						</div>
						<span class="categoryTitle_HP"><i class="fa fa-comments-o"></i> All Threads</span><br>
						<div class="row channelsContainer_menu_HP">
							<div class="categoryTitle_HP channelTitle"> Channels <span class="noOfChannels_HP numberCount_badge"><?php echo count($channelDetails);?></span><i class="fa fa-plus-square-o pull-right"></i></div>
							<ul class="nav navbar-nav channels_UL_List">
								<?php echo $channelstr;?>

						    </ul>

						</div>

						<div class="row directMessageContainer_menu_HP">
							<div class="categoryTitle_HP channelTitle"> Direct Messages <span class="noOfDirectMessages_HP numberCount_badge"> <?php echo count($directMessagesDetails);?></span><i class="fa fa-plus-square-o pull-right"></i></div>
							<ul class="nav navbar-nav directmessages_UL_List">
						        <?php echo $directMessagestr;?>
						    </ul>
						</div>
						<!-- <div class="row dummyBlock">

						</div> -->

					</div>

				</div>

			</div>
			<div class="col-offset-xs-1 mainContent_HP">		
					<?php
						if(isset($_GET["channel"])){
							$currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
							if($currentChannel!='')
							{
								echo '<div class="headerSpace_HP row"><div class="channelTitle"><i class="fa fa-lock"></i> '. htmlspecialchars($currentChannel[0]->channel_name).'</div>';
								$user_count=$currentChannel[0]->usercount;
								$purpose=$currentChannel[0]->purpose;
							}
							else
								echo '<div class="headerSpace_HP row">Channel doesn\'t exist </div>';
						}
					?>
					<div class='headerAddon_HP'>
						<i class="fa fa-star-o"></i> | <i class="fa fa-users"></i> <?php echo $user_count;?>| purpose: <i><?php echo $purpose;?></i>
					</div>
					</div>
				<div class="row rightContent_wrapper_HP">
					<div class="messagesList">
					<?php
						if(isset($_GET["channel"])){
							$currentChannelMessages = json_decode($web_service->getChannelMessages($_GET["channel"]));
							// var_dump($currentChannelMessages);

							$msgStr='';
							$prevdate='';
							$prevUser='';
							$prevTime='';
							if ($currentChannelMessages!=null)
							{
								date_default_timezone_set('America/New_York');
								$time= time();
								$today = date("l, F jS, o", $time);
								foreach ($currentChannelMessages as $message)
								{
									$currentDate=$web_service->getFormatDate($message->created_at);
									if($currentDate==$today)
										$currentDate='Today';
									if($prevdate!=$currentDate)
									{
										$msgStr.='<div class="currentDate">'.$currentDate.'</div>';
										$prevdate=$currentDate;
									}
									
									$msgStr.='<div class="row messageSet"><img class="col-xs-2 userPic" src="./images/user.png" alt="User"><div class="col-offset-xs-1 message"><div class="message_header"><b>';
									$msgStr.=htmlspecialchars($message->first_name);
									$msgStr.=' '.htmlspecialchars($message->last_name).'</b><span class="message_time"> ';
									$msgStr.=$web_service->getFormatTime($message->created_at);
									$msgStr.='</span></div><div class="message_body">';
									$msgStr.=htmlspecialchars($message->content);
									$msgStr.='</div></div></div>';
								}
							}
							else
							{
								$msgStr="<div>No messages in this channel..</div>";
							}
							echo $msgStr;
						}
					?>
					<div id="latest">

					</div>
					</div>
				</div>
				<div class="footerSpace_HP row">
					<form method="POST" action="./services/sendMessage.php">
						<input type="hidden" class="form-control" value=<?php echo '"'.$_SESSION['userid'].'"';?> name="userid">
					    <input type="hidden" class="form-control" value=<?php echo '"'.$_GET["channel"].'"';?> name="channelid">
						<div class="input-group">
					      
					      
					      
									<?php
									if(isset($_GET["channel"])){
										$currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
										if($currentChannel!='')
											echo '<input type="text" class="form-control inputMessage" required autofocus placeholder="Type your message..." name="message"><span class="input-group-btn"><button class="btn btn-secondary" type="submit"><i class="fa fa-paper-plane"></i></button></span>';
										else
											echo '<input type="text" class="form-control inputMessage" disabled autofocus placeholder="Type your message..." name="message"><span class="input-group-btn"><button class="btn btn-secondary disabled" type="submit"><i class="fa fa-paper-plane"></i></button></span></span>';
									}

									?>

					      
					    </div>
				    </form>
				</div>
			</div>
		</div>
	</div>
	<div class="footer row">
		<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small>
	</div>
	</body>
</html>
