<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	include_once "./services/WebService.php";
	if($_SESSION['loggedIn'])
	{
        // echo $_SESSION['githubLogin'];
		$web_service = new WebService();
		$userDetails=$web_service->getProfileDetails($_GET['userid']);
		if(strpos($userDetails, 'fail') !== false)
		{
			header("location: ./index.php?status=notloggedin");
		}
		else
		{
	    	$userDetails = json_decode($userDetails);
			$channelDetails = json_decode($web_service->getPublicChannelsDetails($_GET['userid']));

			$channelstr='';
			$displayChannelList='';
			if ($channelDetails!='')
			{
	           foreach($channelDetails as $channel)
	           {
	                $channelstr.='<li >';
									$channelstr.='<a class="channelsProfilePage" href="./HomePage.php?channel='.$channel->channel_id.'#">';
	                $channelstr.=$channel->channel_name;
	            	$channelstr.='</a></li>';
	            	$displayChannelList.=$channel->channel_name.'<br>';
	           }
	        }

            $userScore=$web_service->getUserScore($_GET['userid']);
            // echo $userScore;

        }
    }
    else
    {
    	header("location: ./index.php?status=notloggedin");
    }


?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="./Assets/jquery.min.js"></script>
		<script src="./Assets/bootstrap.min.js"></script>
		<script src="./scripts/profile_pagescript.js"></script>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">


		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./Assets/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./CSS/profilepage_site.css">
        <script src="./Assets/ratingscript.js"></script>
        <link rel="stylesheet" href="./CSS/rating.css">
        <style>
            html{
                overflow: hidden !important;
            }
        </style>
        <script> 
           var userScore=<?php echo $userScore;?>;
            var loggedInThroughGit = <?php  

               if($userDetails[0]->github_avatar == "0"){
                    echo "false";
               }else{
                    echo "true";
               }

            ?>;

        </script>
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
			          <a href='./HomePage.php?channel=<?php echo $_SESSION['channelid']?>'><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></a>
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
				<div class="col-sm-1 goBack">
					<a href='./HomePage.php?channel=<?php echo $_SESSION['channelid']?>'><i class="fa fa-arrow-left"></i></a>
				</div>

				<div class="col-sm-10 logo">
					<span>Profile</span>
				</div>

				<?php
					if($_SESSION['loggedIn'] && $_SESSION['userid']==$_GET['userid'])
					{
						echo '<div class="col-sm-1 editProfile"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
						</div>';

					}
				?>

			</div>
			<!-- <a href="./help.html"><i class="fa fa-question-circle-o"></i></a> -->
			<div class="row updateProfile">
				<form role="form" id="updateForm" enctype='multipart/form-data'>
					<div class="col-xs-8" style="margin-top: 2%;">
                        <div class="row">
                            <div class="form-group col-xs-5">
                                <input type="text" class="form-control firstName" name="firstName" value="<?php echo $userDetails[0]->first_name ?>" maxlength="20" required>
                                <label class="form-control-placeholder" for="name">First Name</label>
                            </div>
                            <div class="form-group col-xs-1">
                            </div>
                            <div class="form-group col-xs-6">
                                <input type="text" class="form-control lastName" name="lastName" value="<?php echo $userDetails[0]->last_name ?>" maxlength="20" required>
                                <label class="form-control-placeholder" for="name">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input disabled type="email" class="form-control email" name="email" value ="<?php echo $userDetails[0]->email_id ?>" maxlength="50" required>
                                <label class="form-control-placeholder" for="name">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="password" class="form-control password" name="password" maxlength="20" required>
                                <label class="form-control-placeholder" for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control whatIDo not_reallyrequired" name="whatIDo" value ="<?php echo $userDetails[0]->what_i_do ?>" maxlength="200" required>
                                <label class="form-control-placeholder" for="name">What I do</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control status not_reallyrequired" name="status" value ="<?php echo $userDetails[0]->status ?>" maxlength="200" required>
                                <label class="form-control-placeholder" for="name">Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="number" class="form-control phoneNumber not_reallyrequired " size="12"  name="phoneNumber" value ="<?php echo $userDetails[0]->phone_number ?>" maxlength="13" required>
                                <label class="form-control-placeholder"  for="name">Phone Number</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control skype not_reallyrequired" name="skype" value ="<?php echo $userDetails[0]->skype ?>" maxlength="50" required>
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
                            <?php
                                if($_SESSION['githubLogin']==1)
                                {
                                    echo '<div class="radio">
                                            <label><input type="radio" name="radiogroup" value="2" ';
                                    if($userDetails[0]->profile_pic_pref==2)
                                        echo 'checked';
                                    echo '>GitHub Avatar</label>
                                          </div>';
                                }
                            ?>
                            <div class="radio">
                              <label><input type="radio" name="radiogroup" value="1" <?php if($userDetails[0]->profile_pic_pref==1)
                                        echo ' checked'; ?>>Gravatar</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="radiogroup" value="0" <?php if($userDetails[0]->profile_pic_pref==0)
                                        echo ' checked'; ?>>Local Picture</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="radiogroup" value="-1" <?php if($userDetails[0]->profile_pic_pref==-1)
                                        echo ' checked'; ?>>Default Picture</label>
                            </div>


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


			<div class="row displayProfile">
				<div class="col-md-3 col-lg-3 " align="center">
						<img alt="User Pic" src="<?php echo $userDetails[0]->profile_pic ?>" class="profilePicDisplay">
				</div>
				<div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Email id:</td>
                        <td><?php echo $userDetails[0]->email_id ?></td>
                      </tr>
                      <tr>
                        <td>First Name:</td>
                        <td><?php echo $userDetails[0]->first_name ?></td>
                      </tr>
                      <tr>
                        <td>Last Name:</td>
                        <td><?php echo $userDetails[0]->last_name ?></td>
                      </tr>

                      <tr>
                        <td>What I Do:</td>
                        <td><?php echo $userDetails[0]->what_i_do ?></td>
                      </tr>
                      <tr>
                        <td>Status:</td>
                        <td><?php echo $userDetails[0]->status ?></td>
                      </tr>
                      <tr>
                        <td>Channels: </td>
                        <td><?php
                        if($_SESSION['loggedIn'] && $_SESSION['userid']==$_GET['userid'])
							{

                        		echo $channelstr;
                        	}
                        else
                        	echo $displayChannelList;
                        ?></td>
                      </tr>


                    </tbody>
                  </table>
				 </div>
                <div class="row userratingwrapper">
                    <div class="rating " data-vote="0" >

                        <div class="star hidden">
                            <span class="full" data-value="0"></span>
                            <span class="half" data-value="0"></span>
                        </div>

                        <div class="star">

                            <span class="full" data-value="1"></span>
                            <span class="half" data-value="0.5"></span>
                            <span class="selected"></span>

                        </div>

                        <div class="star">

                            <span class="full" data-value="2"></span>
                            <span class="half" data-value="1.5"></span>
                            <span class="selected"></span>

                        </div>

                        <div class="star">

                            <span class="full" data-value="3"></span>
                            <span class="half" data-value="2.5"></span>
                            <span class="selected"></span>

                        </div>

                        <div class="star">

                            <span class="full" data-value="4"></span>
                            <span class="half" data-value="3.5"></span>
                            <span class="selected"></span>

                        </div>

                        <div class="star">

                            <span class="full" data-value="5"></span>
                            <span class="half" data-value="4.5"></span>
                            <span class="selected"></span>

                        </div>

                        <div class="score">
                            <span class="score-rating js-score">0</span>
                            <span>/</span>
                            <span class="total">5</span>
                        </div>
                    </div>
                </div>
			</div>

		</div>
		<div class="footer row">
			<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small>
		</div>
	</body>
</html>
