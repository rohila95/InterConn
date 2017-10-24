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
                    $channelstr.=' <a href="./HomePage.php?channel='.$channel->channel_id.'#"><span class="channelPrivacyLevel"><i class="fa fa-lock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
                else
                    $channelstr.='<a href="./HomePage.php?channel='.$channel->channel_id.'"><span class="channelPrivacyLevel"><i class="fa fa-unlock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="./scripts/home_sitescript.js"></script>

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
							<span class="loggedIn_user"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php  echo $userDetails[0]->first_name.' '.$userDetails[0]->last_name; ?> </span><br>
							<span class="loggedIn_user"><i class="fa fa-globe"></i>&nbsp;&nbsp;<?php  echo $workspaceName; ?></span> <br>


						</div>
						<span class="categoryTitle_HP"><i class="fa fa-comments-o"></i> All Threads</span><br>
						<div class="row channelsContainer_menu_HP">
							<div class="categoryTitle_HP channelTitle"> Channels <span class="noOfChannels_HP numberCount_badge"><?php echo count($channelDetails);?></span><i class="fa fa-plus-square-o pull-right createNewChannelIcon"></i></div>
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
						<div class="row signOut">

							<a href="./index.php?status=signout">
								<span class="channelPrivacyLevel"><i class="fa fa-sign-out"></i></span>Sign Out
							</a>

						</div>

					</div>

				</div>

			</div>
			<div class="modal fade" id="createChannel" role="dialog">
			    <div class="modal-dialog modal-lg">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Create Channel</h4>
			          <h6>Channels are where yours members communicate.They're best when organized around a topic.</h6>
			        </div>
			        <div class="modal-body newChannelDetails">
			          <form>
			          	<div class="row">
					      	<div class="form-group">
						        <input type="text" class="form-control email" name="name" required>
						        <label class="form-control-placeholder" for="name">Name</label>
					      	</div>
					    </div>
					    <div class="row">
					      	<div class="form-group">
						        <input type="password" class="form-control password" name="purpose" required>
						        <label class="form-control-placeholder" for="purpose">Purpose</label>
						    </div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="radio-inline">
							      <input type="radio" name="optradio">Private
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="optradio">Public
							    </label>
						    </div>
						</div>
					    <div class="row">
					      	<div class="form-group">
						        <input type="text" class="form-control whatIDo" name="invites" required>
						        <label class="form-control-placeholder" for="invite">Send invites to :</label>
					      	</div>
					    </div>
			          </form>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          <button type="button" class="btn btn-default createChannelBtn" data-dismiss="modal">Create Channel</button>
			        </div>
			      </div>
			    </div>
			</div>
			<div class="btn-group messageHoverButtons">
				    <button emojiid="1" type="button" class="btn btn-primary"><i class="fa fa-thumbs-o-up"></i></button>
				    <button emojiid="2" type="button" class="btn btn-primary"><i class="fa fa-thumbs-o-down"></i></button>
				    <button type="button" class="btn btn-primary"><i class="fa fa-comments-o"></i></button>
				    <button type="button" class="btn btn-primary"><i class="fa fa-reply"></i></button>
			</div>
			<div class="col-offset-xs-1 mainContent_HP">
					<?php
						if(isset($_GET["channel"])){
							$currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
							if($currentChannel!='')
							{
								if($currentChannel[0]->type=='private')
	   								echo '<div class="headerSpace_HP row"><div class="channelTitle"><i class="fa fa-lock"></i> '. htmlspecialchars($currentChannel[0]->channel_name).'</div>';
	   							else if($currentChannel[0]->type=='public')
									echo '<div class="headerSpace_HP row"><div class="channelTitle"><i class="fa fa-unlock"></i> '. htmlspecialchars($currentChannel[0]->channel_name).'</div>';
								$user_count=$currentChannel[0]->usercount;
								$purpose=$currentChannel[0]->purpose;
							}
							else
								echo '<div class="headerSpace_HP row">Channel doesn\'t exist </div>';
						}
					?>
					<div class='headerAddon_HP'>
						<i class="fa fa-star-o"></i> | <i class="fa fa-users"></i> <?php echo $user_count;?>| Purpose: <i><?php echo $purpose;?></i>
					</div>
					</div>
				<div class="row rightContent_wrapper_HP">
					<div class="messagesList">
					<div>This is the begining of Chat....</div>
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
									$currentTime=$web_service->getFormatTime($message->created_at);
									$shortName= $message->first_name[0];
									if($message->last_name == '' || $message->last_name== null){
										$shortName.= $message->first_name[1];
									}else{
										$shortName.= $message->last_name[0];
									}
									$defUserPicBGColorArr = ['#3F51B5','#2196F3','#00BCD4','#CDDC39','#FF5722'];
									$defUserPicBGColor = $defUserPicBGColorArr[((int)$message->user_id)%5];
									if($currentDate==$today)
										$currentDate='Today';


									if($prevUser=='' && $prevTime=='')
									{
										if($prevdate!=$currentDate)
										{
											$msgStr.='<div class="row"><div class="daySeperatorLine col-xs-5 pull-left"> </div><div class="dayDividerText col-xs-2">'.$currentDate.'</div><div class="daySeperatorLine col-xs-5 pull-right"> </div></div>';
											$prevdate=$currentDate;
										}




										$msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic" style="background:'.$defUserPicBGColor .';">'. htmlspecialchars(strtoupper($shortName)) .'</div></div><div class="col-xs-11 message"><div class="message_header"><b>';
										$msgStr.=htmlspecialchars($message->first_name);
										$msgStr.=' '.htmlspecialchars($message->last_name).'</b><span class="message_time"> ';
										$msgStr.=$currentTime;
										$msgStr.='</span></div>';
										$msgStr.='<div class="message_body" id="'.$message->message_id.'"><div class="msg_content">'.htmlspecialchars($message->content).'</div><div class="msg_reactionsec"> </div></div>';
										$prevUser=$message->first_name;
										$prevTime=$currentTime;

									}
									else if($prevUser==$message->first_name && $prevTime==$currentTime )
									{
										$msgStr.='<div class="message_body addOnMessages" id="'.$message->message_id.'"><div class="msg_content">'.htmlspecialchars($message->content).'</div><div class="msg_reactionsec"> </div></div>';

									}
									else if($prevUser!=$message->first_name || $prevTime!=$currentTime)
									{
										$msgStr.='</div></div>';
										if($prevdate!=$currentDate)
										{
											$msgStr.='<div class="row"><div class="daySeperatorLine col-xs-5 pull-left"> </div><div class="dayDividerText col-xs-2">'.$currentDate.'</div><div class="daySeperatorLine col-xs-5 pull-right"> </div></div>';
											$prevdate=$currentDate;
										}
										$msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic" style="background:'.$defUserPicBGColor .';">'. strtoupper($shortName) .'</div> </div><div class="col-xs-11 message"><div class="message_header"><b>';
										$msgStr.=htmlspecialchars($message->first_name);
										$msgStr.=' '.htmlspecialchars($message->last_name).'</b><span class="message_time"> ';
										$msgStr.=$currentTime;
										$msgStr.='</span></div>';
										$msgStr.='<div class="message_body" id="'.$message->message_id.'"><div class="msg_content">'.htmlspecialchars($message->content).'</div><div class="msg_reactionsec"> </div></div>';
										$prevUser=$message->first_name;
										$prevTime=$currentTime;
									}
								}
								$msgStr.='</div></div>';
							}
							else
							{
								$msgStr="<div>No messages in this channel..</div>";
							}
							echo $msgStr;
						}
					?>

					</div>
				</div>
				<div class="footerSpace_HP row">
					<form method="POST" action="./services/sendMessage.php">
						<input type="hidden" class="form-control" value=<?php echo '"'.$_SESSION['userid'].'"';?> name="userid">
					    <input type="hidden" class="form-control" value=<?php echo '"'.$_GET["channel"].'"';?> name="channelid">
						<div class="input-group form-group">



									<?php
									if(isset($_GET["channel"])){
										$currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
										if($currentChannel!='')
											echo '<textarea class="form-control inputMessage" rows="1" required autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn"><button class="btn btn-secondary" type="submit"><i class="fa fa-paper-plane"></i></button></span>';
										else
											echo '<textarea class="form-control inputMessage" rows="1" disabled autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn"><button class="btn btn-secondary disabled" type="submit"><i class="fa fa-paper-plane"></i></button></span></span>';
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
