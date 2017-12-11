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

    $userDetails = json_decode($web_service->getUserDetails($_SESSION['userid']));
    $workspaceDetails = json_decode($web_service->getWorkspaceDetails($_SESSION['userid']));
    $workspaceName=$workspaceDetails[0]->workspace_name;
    $workspaceid=$workspaceDetails[0]->workspace_id;
    $workspaceCreatorId=$workspaceDetails[0]->created_by;
    $_SESSION['workspace_creator']=$workspaceCreatorId;
	$flag=0;
	$is_admin=0;
	if($workspaceCreatorId==$_SESSION['userid']){
        $is_admin=1;
        echo "<script>isAdmin= true; </script>";
    }

    $channelDetails = json_decode($web_service->getChannelsDetails($_SESSION['userid'],$workspaceid,$is_admin));
    $directMessagesDetails = json_decode($web_service->getDirectMessagesDetails($workspaceDetails[0]->workspace_id));
   	
    // the folowing block deals with the redirection to channel or direct msgs
   	$isChannelMode = true;
    if((isset($_GET["channel"]) && isset($_GET["directmsg"]) )|| (!isset($_GET["channel"]) && !isset($_GET["directmsg"])))
    {
    	header("location: ./index.php?status=notloggedin");

    }
   	else if (isset($_GET["channel"])) {
   		    $_SESSION['channelid']=$_GET["channel"];
   		    $_SESSION['directmsg_id']="";
   		    $isChannelMode = true;
   	}
   	else if (isset($_GET["directmsg"])) {
   		    $_SESSION['directmsg_id']=$_GET["directmsg"];
   		    $_SESSION['channelid']="";
   		    $isChannelMode = false;
   	}

   // $_SESSION['channelid']=$_GET["channel"];

   	if($isChannelMode)
   	{
	    // changing the below service call to the getSpecificChannelUserDetWithIDs to get the UserIds as well
	    $groupMembers=json_decode($web_service->getSpecificChannelUserDetails($_GET["channel"]));

	    $groupMembersWholeDet=json_decode($web_service->getSpecificChannelUserDetWithIDs($_GET["channel"]));
	    
    }
   // the following code deals with the side nav bar 
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
	                if($isChannelMode && $channel->channel_id==$_GET["channel"])
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
			// echo json_encode($directMessagesDetails);
           foreach($directMessagesDetails as $directMessage)
           {
           		if(isset($_GET["directmsg"]) && $directMessage->id==$_GET["directmsg"])
           		{
           			$flag=1;

           			$directMessagestr.=' <li touserid="'.$directMessage->id.'" class="active currentDirectMsg"><a href="./HomePage.php?directmsg='.$directMessage->id.'"> <span class="channelPrivacyLevel"><i class="fa fa-dot-circle-o"></i></span><span class="" >'.htmlspecialchars($directMessage->first_name).' '.htmlspecialchars($directMessage->last_name).'</span></a></li>';
           		}
           		else
	                $directMessagestr.=' <li touserid="'.$directMessage->id.'" class="active"><a href="./HomePage.php?directmsg='.$directMessage->id.'"> <span class="channelPrivacyLevel"><i class="fa fa-dot-circle-o"></i></span><span class="" >'.htmlspecialchars($directMessage->first_name).' '.htmlspecialchars($directMessage->last_name).'</span></a></li>';
           }
        }
	}
	if(!$_SESSION['loggedIn'] || $flag==0)
	{
		header("location: ./index.php?status=notloggedin");
	}
?>
<!-- <!DOCTYPE html> -->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="./Assets/jquery.min.js"></script>
		<script type="text/javascript" src="./Assets/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                crossorigin="anonymous"></script>
		<script type="text/javascript" src="./scripts/home_sitescript.js"></script>

		<script type="text/javascript" src="./scripts/select2/select2.js"></script>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="./scripts/select2/select2.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./CSS/home_site.css">
		<link rel="stylesheet" href="./Assets/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--        live colob related  -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.orange-indigo.min.css">
        <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>

        <!-- App Styling -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="CSS/main_lc.css">



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
                        <div  class="row categoryTitle_HP hidden" ><i class="fa fa-comments-o"></i> <span>All Threads</span></div>
						<div class="row channelsContainer_menu_HP">
							<div class="row categoryTitle_HP channelTitle"> <div class="col-xs-10"> Channels <span class="noOfChannels_HP numberCount_badge"><?php echo $channelCount;?></span>

                                    <i class="fa fa-plus-square-o   pull-right createNewChannelIcon" title="Add new channel"></i> </div>
                            </div>
							<ul class="row nav navbar-nav channels_UL_List">
								<?php echo $channelstr;?>

						    </ul>

						</div>
						<div class="row archieveChannelsContainer_menu_HP">
							<div class="row categoryTitle_HP channelTitle"> <div class="col-xs-12"><span> Archived Channels</span>
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

           <!-- modal for code snippet -->
            <div class="modal fade" id="sendSnippetModal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Send Code Snippet </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <select class="form-control" id="codeSnipSelBox">
                                            <option value="0">HTML</option>
                                            <option value="1">JavaScript</option>
                                            <option value="2">Python</option>
                                            <option value="3">PHP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <textarea class="form-control textAreaInCodeSnipp" rows="7" required="" autofocus="" placeholder="Copy your code snipped here"></textarea>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary sendSnippetButt">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal for local image -->
 			
            <div class="modal fade" id="sendLocalImgModal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Local Image</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="sendImagInMsgs" enctype="multipart/form-data">
                                <div class="form-group" style="margin-left: 10%;">

                                        <div class="imageBeingPutinMsg">
                                            <span class="glyphicon glyphicon-camera"></span>
                                            <span>Change Image</span>
                                        </div>

                                        <input class="fileUploadIP hidden" name="imgToUpload" type="file" accept="image/*">

                                </div>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary sendLocalImgButt" data-dismiss="modal">Send</button>
                        </div>
                    </div>
                </div>
            </div>
			<!-- modal for local file -->
            <div class="modal fade" id="sendLocalFileModal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Local File</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="sendFileInMsgs" enctype="multipart/form-data">
                                <div class="form-group" style="margin-left: 10%;">

                                        <div class="fileimageBeingPutinMsg">

                                        </div>
                                        <div class="fileName">

                                        </div>

                                        <input class="anyfileUpload hidden" name="anyfileUpload" type="file">
                                </div>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary sendLocalFileButt" data-dismiss="modal">Send</button>
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
                                    <span><a href='./register.html'>New user?</a></span>
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


            <!--  for the livecolab modal -->

            <div class="modal fade" id="livecolobmodal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-header">

                                <!-- Header section containing logo -->
                                <header class="mdl-layout__header mdl-color-text--white mdl-color--light-blue-700">
                                    <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid">
                                        <div class="mdl-layout__header-row mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-cell--12-col-desktop">
                                            <h3><i class="material-icons">chat_bubble_outline</i> Collaborate live</h3>
                                        </div>
                                        <div id="user-container">
                                            <div hidden id="user-pic"></div>
                                            <div hidden id="user-name"></div>
                                            <button hidden id="sign-out" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
                                                Sign-out
                                            </button>
                                            <button hidden id="sign-in" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
                                                <i class="material-icons">account_circle</i>Sign-in with Google
                                            </button>
                                        </div>
                                    </div>
                                </header>

                                <main class="mdl-layout__content mdl-color--grey-100">
                                    <div id="messages-card-container" class="mdl-cell mdl-cell--12-col mdl-grid">

                                        <!-- Messages container -->
                                        <div id="messages-card" class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--6-col-tablet mdl-cell--6-col-desktop">
                                            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                                                <div id="messages">
                                                    <span id="message-filler"></span>
                                                </div>
                                                <form id="message-form" action="#">
                                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                        <input class="mdl-textfield__input" type="text" id="message">
                                                        <label class="mdl-textfield__label" for="message">Message...</label>
                                                    </div>
                                                    <button id="submit" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                                        Send
                                                    </button>
                                                </form>
                                                <form id="image-form" action="#">
                                                    <input id="mediaCapture" type="file" accept="image/*,capture=camera">
                                                    <button id="submitImage" title="Add an image" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--amber-400 mdl-color-text--white">
                                                        <i class="material-icons">image</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                      <!--  <div id="must-signin-snackbar" class="mdl-js-snackbar mdl-snackbar">
                                            <div class="mdl-snackbar__text"></div>
                                            <button class="mdl-snackbar__action" type="button"></button>
                                        </div>-->

                                    </div>
                                    <div class="editablediv" contenteditable>
                                        <div class="currentline"> </div>

                                    </div>



                                </main>
                            </div>

                            <!-- Import and configure the Firebase SDK -->
                            <!-- These scripts are made available when the app is served or deployed on Firebase Hosting -->
                            <!-- If you do not want to serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup -->
                            <!-- <script src="/__/firebase/4.1.3/firebase.js"></script>
                            <script src="/__/firebase/init.js"></script> -->
                            <!-- <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-app.js"></script>
                              <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-auth.js"></script>
                              <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-database.js"></script>
                              <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-firestore.js"></script>
                              <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-messaging.js"></script>

                            <!-- Leave out Storage -->
                            <!--<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-storage.js"></script> -->

                            <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>

                            <script>
                                // Initialize Firebase
                                var config = {
                                    apiKey: "AIzaSyDJ0kOFXIaFLLzpmEVLz27OzF5nn8fi7vA",
                                    authDomain: "interconn-d0826.firebaseapp.com",
                                    databaseURL: "https://interconn-d0826.firebaseio.com",
                                    projectId: "interconn-d0826",
                                    storageBucket: "",
                                    messagingSenderId: "521078521512"
                                };
                                firebase.initializeApp(config);
                            </script>
                            <script src="scripts/main_lc.js"></script>
                            <script src="scripts/sitescript_lc.js"></script>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!--  end for livecolab modal -->

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
			// echo $web_service->getUserDetails(1);
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
                // echo 'hello';
                // echo $web_service->getUserDetails($_GET["directmsg"]);
                if(isset($_GET["directmsg"])){

                    $currentUser = json_decode($web_service->getUserDetails($_GET["directmsg"]));

                    if($currentUser!='')
                    {
                    	echo '<div class="btn-group messageHoverButtons">
							    <button emojiid="1" type="button" class="btn btn-primary thumbsbutt" title="thumbsup"><i class="fa fa-thumbs-o-up"></i></button>
							    <button emojiid="2" type="button" class="btn btn-primary thumbsbutt" title="thumbsdown"><i class="fa fa-thumbs-o-down"></i></button>
							    <button type="button" class="btn btn-primary threadbutt nonthumbbutts" title="thread"><i class="fa fa-comments-o"></i></button>';
						// if($workspaceCreatorId==$_SESSION['userid'])
						// 	{
						// 	   echo '<button type="button" class="btn btn-primary deletebutt" title="delete message"><i class="fa fa-trash-o"></i></button>';
						// 	}
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
		                        if(isset($_GET["directmsg"])){
		                            $currentUser = json_decode($web_service->getUserDetails($_GET["directmsg"]));
		                            if($currentUser!='')
		                            {

		                                echo '<div class="channelTitle currentChannelTitle col-xs-6 " id="'.$_GET["directmsg"].'"> <span>'. htmlspecialchars($currentUser[0]->first_name).' '.htmlspecialchars($currentUser[0]->last_name).'</span></div>';
		                                
		                                $status=$currentUser[0]->status;
		                            }
		                        }
		                    ?>

		                </div>
                        <?php
	                        if($isChannelMode){
	                            if($currentChannel[0]->is_archive==0)
	                            {
	                                echo "<div class='row headerAddon_HP activeChannel'>";
	                            }else{
	                                echo "<div class='row headerAddon_HP archivedChannel'>";
	                            }
	                        }else{
	                        	  echo "<div class='row headerAddon_HP'>";
	                        }
                        ?>
                        <?php
                        	if($isChannelMode){
	                        	$editTitle="";
	                        	if($is_admin){
	                                  $editTitle = "Edit members";
	                             
	                             }

	                            $channelRelatedHeaders= '<span class="channelMemebersShortDetails headerSpan">
	                                <a href="#" class="channelMemebersEditButt" data-toggle="tooltip" data-placement="bottom"  title="'.$editTitle . '" >
	        
	                            <i class="fa fa-users"></i></a> <span class="membersCount" title="'.htmlspecialchars($groupMembers[0]->names).'">'.$user_count. 
	                            '</span></span>|';
	                            $channelRelatedHeaders.='<span class="channelPurpose headerSpan" title="Channel Purpose">
                                <i>purpose: '.htmlspecialchars($purpose).'</i></span>';
	                            echo $channelRelatedHeaders;
	                          }else{

	                          	echo '<span class="channelPurpose headerSpan" title="User Status">
                                <i>Status: '.htmlspecialchars($status).'</i></span>';
	                          }

                          ?>

                            

		                    <?php
		                    	if($isChannelMode && $currentChannel[0]->is_archive==0)
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
							
							if($isChannelMode  && ($workspaceCreatorId==$_SESSION['userid']))
							{
								if($currentChannel[0]->is_archive==0)
									echo '<i class="fa fa-archive archieveButton" title="Archive Channel"></i>';
								else if($currentChannel[0]->is_archive==1)
										echo '<i class="fa fa-undo unarchieveButton" title="Unarchive Channel"></i>';
							}

						?>
						<a href="./help.html" title="Help"><i class="fa fa-question-circle-o"></i></a>
		                <?php
			                if($isChannelMode){
			                	echo  '<a href="#" class="colloborateLiveBtn" title="collaborate Live"><i class="fa fa-comments-o "></i></a>';
			                }
		                ?>

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
                            }else{
                            	// echo $web_service->getChannelMessages($_GET["channel"]);
                                $currentDirectMessages = $web_service->getDirectMessages($_SESSION['userid'],$_GET["directmsg"],-1);
                                echo constructMessagesDiv($currentDirectMessages);
                            }
                        ?>

                        </div>
                    </div>
                    <div class="messageEntrySpace_regularMsg_HP row">
						<?php
						if(isset($_GET["channel"])){
								$currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
								if($currentChannel[0]->is_archive==0)
								{
									echo '<div class="dropup dropupMenuRegularMsgs">
											<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">More Options
													<span class="caret"></span></button>
											<ul class="dropdown-menu">
													<li intent="localimage" ><a href="#" class="localimagesel_regularmsg"><i class="fa fa-picture-o" aria-hidden="true">&nbsp;Local Image</i></a></li>
													<li intent="localfile" ><a href="#" class="codesnippetsel__regularmsg"><i class="fa fa-file" aria-hidden="true">&nbsp;&nbsp;Local File</i></a></li>
													<li intent="codesnipp" ><a href="#" class="codesnippetsel__regularmsg"><i class="fa fa-code" aria-hidden="true">&nbsp;Code Snippet</i></a></li>
											</ul>
									</div>';
								}
						}
						 ?>
                        <!-- <div class="dropup dropupMenuRegularMsgs">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">More Options
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li intent="localimage" ><a href="#" class="localimagesel_regularmsg"><i class="fa fa-picture-o" aria-hidden="true">&nbsp;Local Image</i></a></li>
                                <li intent="codesnipp" ><a href="#" class="codesnippetsel__regularmsg"><i class="fa fa-code" aria-hidden="true">&nbsp;Code Snippet</i></a></li>
                            </ul>
                        </div> -->
                        <form method="POST" action="./services/sendMessage.php">
                            <input type="hidden" class="form-control" value=<?php echo '"'.$_SESSION['userid'].'"';?> name="userid">
                            <input type="hidden" class="form-control" value=<?php 	if(isset($_GET["channel"])){
                            															echo '"'.$_GET["channel"].'"';
                            														}
                            														else{
                            															echo "";
                            														}?> name="channelid">
                            <input type="hidden" class="form-control" value=<?php 	if(isset($_GET["directmsg"])){
                            															echo '"'.$_GET["directmsg"].'"';
                            														}
                            														else{
                            															echo "";
                            														}?> name="directmsgid">
                            <input type="hidden" class="isSplMsgHiddenIP" class="form-control" value="0" name="isspecialmsg">
                            <input type="hidden" class="codeSnippTypeHiddenIP" class="form-control" value="0" name="codesnipptype">
                            <div class="form-group">

                                <?php
	                                if($isChannelMode){
	                                    $currentChannel = json_decode($web_service->getSpecificChannelDetails($_GET["channel"]));
	                                    if($currentChannel[0]->is_archive==0)
	                                    {
		                                    if($currentChannel!='')
		                                        echo '<textarea class="form-control inputMessage" rows="2" required autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn hidden"><button class="btn btn-secondary" type="submit"><i class="fa fa-paper-plane"></i></button></span>';
		                                    else
		                                        echo '<textarea class="form-control inputMessage" rows="2" disabled autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn"><button class="btn btn-secondary disabled" type="submit"><i class="fa fa-paper-plane"></i></button></span></span>';
		                                }
	                                }else{
											echo '<textarea class="form-control inputMessage" rows="2" required autofocus placeholder="Type your message..." name="message"></textarea><span class="input-group-btn hidden"><button class="btn btn-secondary" type="submit"><i class="fa fa-paper-plane"></i></button></span>';
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
                               <div class="col-xs-2"><h4>Thread</h4></div>
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
                           		if($isChannelMode){
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
                           		}else{
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
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/color-brewer.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.1.0/highlightjs-line-numbers.min.js"></script>
    <style>

        /* for block of numbers */
        td.hljs-ln-numbers {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

            text-align: center;
            color: #ccc;
            border-right: 1px solid #CCC;
            vertical-align: top;
            padding-right: 5px;

            /* your custom style here */
        }

        /* for block of code */
        td.hljs-ln-code {
            padding-left: 10px;
        }
    </style>

    <script>
        hljs.initHighlightingOnLoad();
        //hljs.initLineNumbersOnLoad();
    </script>
	</body>
</html>
