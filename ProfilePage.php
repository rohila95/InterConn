<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	include_once "./services/WebService.php";
	if($_SESSION['loggedIn'] && $_SESSION['userid']==$_GET['userid'])
	{
		$web_service = new WebService();

    	$userDetails = json_decode($web_service->getProfileDetails($_SESSION['userid']));
		$channelDetails = json_decode($web_service->getPublicChannelsDetails($_SESSION['userid']));

		$channelstr='';
		if ($channelDetails!='')
		{
           foreach($channelDetails as $channel)
           {
                $channelstr.='<li >';
								$channelstr.='<a class="channelsProfilePage" href="./HomePage.php?channel='.$channel->channel_id.'#">';
                $channelstr.=$channel->channel_name;
            		$channelstr.='</a></li>';
           }
        }
	}
	else
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
		<script src="./scripts/profile_pagescript.js"></script>


		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./CSS/profilepage_site.css">
	</head>
	<body>
		<div class="container mainLoginWrapper well w3-panel w3-card-4">
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
			          <button type="button" class="btn btn-default" data-dismiss="modal">Sign In</button>
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
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			    </div>
			</div>
			<div class="row">
				<div class="col-sm-12 logo">
					<span>Edit your Profile</span>
				</div>
			</div>
			
			<div class="row">
				<form role="form" id="updateForm" enctype='multipart/form-data'>
					<div class="col-xs-8">
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <input type="text" class="form-control firstName" name="firstName" value="<?php echo $userDetails[0]->first_name ?>" required>
                                <label class="form-control-placeholder" for="name">First Name</label>
                            </div>
                            <div class="form-group col-xs-1">
                            </div>
                            <div class="form-group col-xs-6">
                                <input type="text" class="form-control lastName" name="lastName" value="<?php echo $userDetails[0]->last_name ?>" required>
                                <label class="form-control-placeholder" for="name">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="email" class="form-control email" name="email" value ="<?php echo $userDetails[0]->email_id ?>" required>
                                <label class="form-control-placeholder" for="name">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="password" class="form-control password" name="password" required>
                                <label class="form-control-placeholder" for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control whatIDo not_reallyrequired" name="whatIDo" value ="<?php echo $userDetails[0]->what_i_do ?>" required>
                                <label class="form-control-placeholder" for="name">What I do</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control status not_reallyrequired" name="status" value ="<?php echo $userDetails[0]->status ?>" required>
                                <label class="form-control-placeholder" for="name">Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="number" class="form-control phoneNumber not_reallyrequired " size="12"  name="phoneNumber" value ="<?php echo $userDetails[0]->phone_number ?>" required>
                                <label class="form-control-placeholder"  for="name">Phone Number</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control skype not_reallyrequired" name="skype" value ="<?php echo $userDetails[0]->skype ?>" required>
                                <label class="form-control-placeholder" for="name">Skype</label>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-1"></div>
                    <div class="col-xs-3">
                        <div class="row">

                            <div class="profile-pic" style="background-image: url('<?php echo $userDetails[0]->profile_pic ?>')" >

                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Image</span>
                            </div>
                            <input class="file-upload" name="imgToUpload" type="file" accept="image/*" />

                        </div>
                        <div class="row">
                            <h4> Public Channels</h4>
                            <?php echo $channelstr?>
                        </div>
                    </div>

					<div class="row">
						<div class="col-xs-6">
							<button type="reset" class="btn btn-block" value="reset">Reset</button>

                        </div>
						<div class="col-xs-6">
                            <button type="submit" id="dummysubmit" class="btn hidden" value="DummySubmit">Dummy</button>
                            <button type="submit" class="btn btn-primary btn-block updateUser">Save Changes</button>
						</div>
					</div>


				</form>
			</div>
		</div>
		<div class="footer row">
			<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small>
		</div>
	</body>
</html>
