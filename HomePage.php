<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	include_once "./services/WebService.php";
	include_once "./services/MainMessages.php";
	if($_SESSION['loggedIn'])
	{
		$web_service = new WebService();

    $userDetails = json_decode($web_service->getUserDetails($_SESSION['emailid']));
    $workspaceDetails = json_decode($web_service->getWorkspaceDetails($_SESSION['userid']));
    $workspaceName=$workspaceDetails[0]->workspace_name;
    $workspaceid=$workspaceDetails[0]->workspace_id;
    $workspaceCreatorId=$workspaceDetails[0]->created_by;
	$flag=0;
	$is_admin=0;
	if($workspaceCreatorId==$_SESSION['userid']){
        $is_admin=1;
        echo "<script>isAdmin= true; </script>";
    }

    $channelDetails = json_decode($web_service->getChannelsDetails($_SESSION['userid'],$workspaceid,$is_admin));
    $directMessagesDetails = json_decode($web_service->getDirectMessagesDetails($workspaceDetails[0]->workspace_id));
   // echo $web_service->getChannelsDetails($_SESSION['userid']);
    $_SESSION['channelid']=$_GET["channel"];
    // changing the below service call to the getSpecificChannelUserDetWithIDs to get the UserIds as well
    $groupMembers=json_decode($web_service->getSpecificChannelUserDetails($_GET["channel"]));

    $groupMembersWholeDet=json_decode($web_service->getSpecificChannelUserDetWithIDs($_GET["channel"]));
    /*print_r($groupMembersWholeDet);
    return;*/

  	$channelstr='';
   	$archiveChannelstr='';
   	$directMessagestr='';
   	$channelCount=0;
   	$archieveChannelCount=0;
		if ($channelDetails!='')
		{
           foreach($channelDetails as $channel)
           {
           		if($channel->is_archive==0)
           		{
	                if($channel->channel_id==$_GET["channel"])
					{
	                    $channelstr.='<li class="active currentChannel">';
						$flag=1;
					}
	                else
	                    $channelstr.='<li class="active">';
	                if($channel->type=='private')
	                    $channelstr.=' <a href="./HomePage.php?channel='.$channel->channel_id.'"><span class="channelPrivacyLevel"><i class="fa fa-lock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	                else
	                    $channelstr.='<a href="./HomePage.php?channel='.$channel->channel_id.'"><span class="channelPrivacyLevel"><i class="fa fa-unlock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	                $channelstr.='</li>';
	                $channelCount+=1;
	            }
	            else if($channel->is_archive==1)
	            {
	            	if($channel->channel_id==$_GET["channel"])
					{
	                    $archiveChannelstr.='<li class="active currentChannel">';
						$flag=1;
					}
	                else
	                    $archiveChannelstr.='<li class="active">';
	                if($channel->type=='private')
	                    $archiveChannelstr.=' <a href="./HomePage.php?channel='.$channel->channel_id.'"><span class="channelPrivacyLevel"><i class="fa fa-lock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	                else
	                    $archiveChannelstr.='<a href="./HomePage.php?channel='.$channel->channel_id.'"><span class="channelPrivacyLevel"><i class="fa fa-unlock"></i></span><span class="'.$channel->channel_id.'" >'.htmlspecialchars($channel->channel_name).'</span></a>';
	                $archiveChannelstr.='</li>';
	                $archieveChannelCount+=1;
	            }
           }
        }
		if ($directMessagesDetails!='')
		{
           foreach($directMessagesDetails as $directMessage)
           {
                $directMessagestr.=' <li touserid="" class="active"><a href="#"> <span class="channelPrivacyLevel"><i class="fa fa-dot-circle-o"></i></span><span class="" >'.htmlspecialchars($directMessage->first_name).' '.htmlspecialchars($directMessage->last_name).'</span></a></li>';
           }
        }
	}
	if(!$_SESSION['loggedIn'] || !isset($_GET["channel"]) || $_GET["channel"]=='' || $flag==0)
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
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                crossorigin="anonymous"></script>
		<script src="./scripts/home_sitescript.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
		<script src="./scripts/tagsinput/bootstrap-tagsinput.min.js"></script>
		<link rel="stylesheet" href="./scripts/tagsinput/bootstrap-tagsinput.css">-->
		<script src="./scripts/select2/select2.js"></script>
		<link rel="stylesheet" href="./scripts/select2/select2.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./CSS/home_site.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-2 verticle_navbar_HP">

				<div class="row menu_leftMain_HP">
					<div class="row leftMenuContentWrapper_HP" >
						<div class="row title_main_HP">
							<h3> InterConn  </h3>
						</div>
						<div class="row loginDetails">
							<span class="loggedIn_user" id='<?php  echo $userDetails[0]->user_id ?>' title='<?php
                            if($is_admin){
                                echo "Welcome Admin";
                            }else{
                                echo "Welcome ".htmlspecialchars($userDetails[0]->first_name).' '.htmlspecialchars($userDetails[0]->last_name);

                            }

                            ?>'><i class="fa fa-user"></i>&nbsp;&nbsp;<?php  echo htmlspecialchars($userDetails[0]->first_name).' '.htmlspecialchars($userDetails[0]->last_name); ?>
                                <a class="signOut" href="./index.php?status=signout" title="Sign Out">
                                    <span class="channelPrivacyLevel" title="Sign Out"><i class="fa fa-sign-out"></i></span>
                                </a></span>
                            <br>
							<span class="loggedIn_workspace" id=<?php echo '"'.$workspaceid.'"';?>><i class="fa fa-globe"></i>&nbsp;&nbsp;<?php  echo htmlspecialchars($workspaceName); ?></span> <br>



						</div>
                        <div  class="row categoryTitle_HP"><i class="fa fa-comments-o"></i> <span>All Threads</span></div>
						<div class="row channelsContainer_menu_HP">
							<div class="row categoryTitle_HP channelTitle"> <div class="col-xs-10"> Channels <span class="noOfChannels_HP numberCount_badge"><?php echo $channelCount;?></span>

                                    <i class="fa fa-plus-square-o   pull-right createNewChannelIcon"></i> </div>
                            </div>
							<ul class="row nav navbar-nav channels_UL_List">
								<?php echo $channelstr;?>

						    </ul>

						</div>
						<div class="row archieveChannelsContainer_menu_HP">
							<div class="row categoryTitle_HP channelTitle"> <div class="col-xs-12"><span> Archieved Channels</span>
                                    <span class="noOfChannels_HP numberCount_badge"><?php echo $archieveChannelCount;?></span></div> </div>
							<ul class=" row nav navbar-nav channels_UL_List">
								<?php echo $archiveChannelstr;?>

						    </ul>

						</div>

						<div class="row directMessageContainer_menu_HP">
                            <div class="row categoryTitle_HP channelTitle"> <div class="col-xs-10"> <span>Direct Messages </span> <span class="noOfDirectMessages_HP numberCount_badge"> <?php echo count($directMessagesDetails);?></span><i class="fa fa-plus-square-o pull-right "></i> </div></div>
							<ul class="nav navbar-nav directmessages_UL_List">
						        <?php echo $directMessagestr;?>
						    </ul>
						</div>



					</div>

				</div>

			</div>
			<div class="modal fade" id="successModal" role="dialog">
			    <div class="modal-dialog modal-sm">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Success</h4>
			        </div>
			        <div class="modal-body">

			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			        </div>
			      </div>
			    </div>
			</div>
			<div class="modal fade" id="errorModal" role="dialog">
			    <div class="modal-dialog modal-sm">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Error</h4>
			        </div>
			        <div class="modal-body">

			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			        </div>
			      </div>
			    </div>
			</div>
			<div class="modal fade" id="existingChannelInvites" role="dialog">
			    <div class="modal-dialog modal-md">
			      <div class="modal-content">
			        <div class="modal-header regularModal">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Channel Invitation</h4>
			        </div>
			        <div class="modal-body">
			        <div class="row">
					      	<div class="form-group inviteFromChannelPageFG">
					      		<span class='invites'><b>Invite members</b></span>
						        <div class="existingChannelInvites">
						        </div>
					      	</div>
					    </div>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          <button type="button" class="btn btn-default inviteExistingChannel" data-dismiss="modal">Invite members</button>
			        </div>
			      </div>
			    </div>
			</div>


            <div class="modal fade" id="channelMembershipEditingPUP" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header regularModal">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Channel Membership <span class="curSelChannel"> </span></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-3"> </div>
                                <div class="existingChannelMembersWrapper col-xs-6">
                                    <span class='popupSubtitle'><b>Existing members</b></span>
                                    <ul class="list-group existingChannelMemUL">
                                        <?php
                                        if ($groupMembersWholeDet!=null) {
                                            $listGroupStr="";
                                            foreach ($groupMembersWholeDet as $grpMem) {
                                                $listGroupStr.= "<li class='list-group-item' userid='$grpMem->user_id'><span class='userfullname'>". $grpMem->first_name." ".$grpMem->last_name ."</span>";

                                                if($is_admin == 1){
                                                    $listGroupStr.="<span><button type='button' class='close pull-right removeUserFromChannel' title='remove'>x</button></span>";
                                                }
                                                $listGroupStr.="</li>";

                                            }
                                            echo $listGroupStr;
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-xs-3"> </div>
                            </div>


                            <div class="row">
                                <div class="form-group inviteFromChannelPageFG">
                                    <span class='invites'><b>Invite new members</b></span>
                                    <div class="existingChannelInvites">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default cancelChanges" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default  saveChangesChannelMemShipEdit" data-dismiss="modal">Save Changes</button>
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
			          <form role="form" id="createChannelForm">
			          	<div class="row">
					      	<div class="form-group">
					      		<div class="uniqueChannel"></div>
						        <input type="text" class="form-control channelName" name="name" maxlength="40" required>
						        <label class="form-control-placeholder" for="name">Name</label>
					      	</div>
					    </div>
					    <div class="row">
					      	<div class="form-group">
						        <input type="text" class="form-control channelPurpose" name="purpose" maxlength="40" required>
						        <label class="form-control-placeholder" for="purpose">Purpose</label>
						    </div>
						</div>
						<div class="row">
							<span class="type">Type of Channel </span>
							<div class="form-group">
								<label class="radio-inline">
							      <input type="radio" name="type" value="private" checked>Private
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="type" value="public">Public
							    </label>
						    </div>
						</div>
					    <div class="row">
					      	<div class="form-group">
					      		<span class='invites'>Invite to Channel</span>
						        <div class="channelInvites">
						        </div>
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
			<?php
				if(isset($_GET["channel"])){
                    $currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
                    if($currentChannel!='' && $currentChannel[0]->is_archive==0)
                    {
                    	echo '<div class="btn-group messageHoverButtons">
							    <button emojiid="1" type="button" class="btn btn-primary thumbsbutt" title="thumbsup"><i class="fa fa-thumbs-o-up"></i></button>
							    <button emojiid="2" type="button" class="btn btn-primary thumbsbutt" title="thumbsdown"><i class="fa fa-thumbs-o-down"></i></button>
							    <button type="button" class="btn btn-primary threadbutt nonthumbbutts" title="thread"><i class="fa fa-comments-o"></i></button>';
						if($workspaceCreatorId==$_SESSION['userid'])
							{
							   echo '<button type="button" class="btn btn-primary deletebutt" title="delete message"><i class="fa fa-trash-o"></i></button>';
							}
						echo '</div>';

                    }
                }
			?>

            <div class="col-xs-10 mainContent_HP">
            	<div class="headerSpace_HP row">
	            	<div class="col-xs-7">
		            	<div class="headerMain row">
		                    <?php
		                        if(isset($_GET["channel"])){
		                            $currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
		                            if($currentChannel!='')
		                            {

		                                if($currentChannel[0]->type=='private')
		                                    echo '<div class="channelTitle currentChannelTitle col-xs-6 " id="'.$_GET["channel"].'"><i class="fa fa-lock"></i> <span>'. htmlspecialchars($currentChannel[0]->channel_name).'</span></div>';
		                                else if($currentChannel[0]->type=='public')
		                                    echo '<div class="channelTitle currentChannelTitle col-xs-6 " id="'.$_GET["channel"].'"><i class="fa fa-unlock"></i> <span>'. htmlspecialchars($currentChannel[0]->channel_name).'</span></div>';
		                                $user_count=$currentChannel[0]->usercount;
		                                $purpose=$currentChannel[0]->purpose;
		                            }
		                        }
		                    ?>

		                </div>
                        <?php
                            if($currentChannel[0]->is_archive==0)
                            {
                                echo "<div class='row headerAddon_HP activeChannel'>";
                            }else{
                                echo "<div class='row headerAddon_HP archivedChannel'>";
                            }
                        ?>
		                    <span class="starChannelIcon headerSpan"> <i class="fa fa-star-o"></i> </span> |
                            <span class="channelMemebersShortDetails headerSpan">
                                <a href="#" class="channelMemebersEditButt" data-toggle="tooltip" data-placement="bottom"  title='<?php
                                    if($is_admin){
                                        echo "Edit members";
                                    }

                                ?>'>
                                <i class="fa fa-users"></i></a> <span class="membersCount" title=<?php echo '"'.htmlspecialchars($groupMembers[0]->names).'"';?>> <?php echo $user_count;?>  </span>
                            </span>|
                            <span class="channelPurpose headerSpan" title="Channel Purpose">
                                <i>purpose: <?php echo htmlspecialchars($purpose);?></i>
                            </span>

		                    <?php
		                    	if($currentChannel[0]->is_archive==0)
		                    	{
			                    	if($currentChannel[0]->created_by==$_SESSION['userid'] && $currentChannel[0]->type=='private')
			                    	{
			                    		echo ' |<span class="invitations headerSpan"> Invite Members</span>';
			                    	}
			                    	else if($currentChannel[0]->type=='public' && $currentChannel[0]->channel_name!='general' && $currentChannel[0]->channel_name!='random')
			                    	{
			                    		echo ' |<span class="invitations headerSpan"> Invite Members</span>';
			                    	}
			                    }
		                    ?>

		                </div>
		            </div>
		            <div class="left-inner-addon col-xs-3">
				        <i  class="fa fa-search"></i>
				        <input type="text" name="userProfileSearchInput" class="form-control userProfileSearchInput" placeholder="Search Name" />
					</div>
					<div class="col-xs-2 addOnButtons">
						<?php
							if($workspaceCreatorId==$_SESSION['userid'])
							{
								if($currentChannel[0]->is_archive==0)
									echo '<i class="fa fa-archive archieveButton" title="Archieve Channel"></i>';
								else if($currentChannel[0]->is_archive==1)
										echo '<i class="fa fa-undo unarchieveButton" title="Unarchieve Channel"></i>';
							}
						?>
						<a href="./help.html" title="Help"><i class="fa fa-question-circle-o"></i></a>
					</div>

	            </div>

            <div class="row">
                <div class="col-xs-12 regularMessagesWrapper">
                    <div class="row rightContent_wrapper_HP">
                        <div class="messagesList">

                        <?php
                            if(isset($_GET["channel"])){
                                // echo $web_service->getChannelMessages($_GET["channel"]);
                                $currentChannelMessages = $web_service->getChannelMessages($_GET["channel"],-1);

                                echo constructMessagesDiv($currentChannelMessages);
                            }
                        ?>

                        </div>
                    </div>
                    <div class="messageEntrySpace_regularMsg_HP row">
                        <form method="POST" action="./services/sendMessage.php">
                            <input type="hidden" class="form-control" value=<?php echo '"'.$_SESSION['userid'].'"';?> name="userid">
                            <input type="hidden" class="form-control" value=<?php echo '"'.$_GET["channel"].'"';?> name="channelid">
                            <div class="form-group">

                                <?php
                                if(isset($_GET["channel"])){
                                    $currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
                                    if($currentChannel[0]->is_archive==0)
                                    {
	                                    if($currentChannel!='')
	                                        echo '<textarea class="form-control inputMessage" rows="2" required autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn hidden"><button class="btn btn-secondary" type="submit"><i class="fa fa-paper-plane"></i></button></span>';
	                                    else
	                                        echo '<textarea class="form-control inputMessage" rows="2" disabled autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn"><button class="btn btn-secondary disabled" type="submit"><i class="fa fa-paper-plane"></i></button></span></span>';
	                                }
                                }

                                ?>

                            </div>
                        </form>
                    </div>
                </div>
               <div class="col-xs-4 threadMessageWrapper" >
                   <div class="row threadedContent">
                       <div class="row threadHeader well" style="max-height:8%; border:1px solid #F1F1F1;">
                           <div class="row threadHeaderWrapper">
                               <div class="col-xs-2"><h2>Thread</h2></div>
                               <div class="col-xs-10">
                                   <div class="pull-right closeHover">
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                   </div>
                               </div>
                           </div>
                       </div>


                           <div class="row eleToBeCleared threadhead_parentmessage">

                           </div>
                           <div class="row eleToBeCleared threadedreplies_content">

                           </div>
                           <?php
                           		if($currentChannel!='' && $currentChannel[0]->is_archive==0)
                   				{
                   					echo '<div class="row messageentryspace_threadsection">
			                               <form>
			                                   <textarea placeholder="Reply" required name="threadreply_msgcontent" class="form-control"></textarea>
			                                   <input type="hidden" class="parentmsgidip_threadmsg" name="parent_message_id"/>
			                                   <button id="thread_MsgEntrySubmit" class="hidden" />
			                               </form>

			                           </div>';
                   				}
                           ?>



                   </div>

                   <div id="threadmsg_loader" class="busy-loader" style="display: none;">
                   </div>

               </div>
            </div>
		</div>
            </div>
		</div>
	</div>
	<div class="footer row">
		<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small>
	</div>
    <div id="wholebody_loader" class="busy-loader" style="display: none;">
    </div>
	</body>
</html>
