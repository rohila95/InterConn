<?php
	session_start();
	include_once "../models/database_connect.php";
	include_once "./WebService.php";
	echo $_SESSION['userid'];
?>
<html>
	<head>
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="./scripts/home_sitescript.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./CSS/home_site.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-1 verticle_navbar_HP">

				<div class="row menu_leftMain_HP">
					<div class="leftMenuContentWrapper_HP" >
						<div class="row title_main_HP"> <h3> InterConn  </h3>
							<span class="loggedIn_user"> Workspace</span> <br>
							<span class="loggedIn_user"> LoggedIn User</span><br>
							<span class="loggedIn_user"> All Threads</span><br>
						</div>

						<div class="row channelsContainer_menu_HP">
							<div class="categoryTitle_HP channelTitle"> Channels <span class="noOfChannels_HP numberCount_badge"> 3</span></div>
							<ul class="nav navbar-nav channels_UL_List">
						        <li channelid="" class="active"><a href="#"> <span class="channelPrivacyLevel"> </span><span class="channelName" >General</span></a></li>
						        <li channelid="" ><a href="#"><span class="channelPrivacyLevel"> </span><span class="channelName" > Random </span></a></li>
						        <li channelid="" ><a href="#"><span class="channelPrivacyLevel"> </span><span class="channelName" > Testing </span></a></li>
						    </ul>

						</div>

						<div class="row directMessageContainer_menu_HP">
							<div class="categoryTitle_HP channelTitle"> Direct Messages <span class="noOfDirectMessages_HP numberCount_badge"> 3</span></div>
							<ul class="nav navbar-nav directmessages_UL_List">
						        <li touserid="" class="active"><a href="#"> <span class="channelPrivacyLevel"> </span><span class="channelName" >Dummy 1</span></a></li>
						        <li touserid="" ><a href="#"><span class="channelPrivacyLevel"> </span><span class="channelName" > Dummy 2 </span></a></li>
						        <li touserid="" ><a href="#"><span class="channelPrivacyLevel"> </span><span class="channelName" > Dummy 3 </span></a></li>
						    </ul>
						</div>
						<div class="row dummyBlock">

						</div>

					</div>

				</div>

			</div>
			<div class="col-lg-11 mainContent_HP">
				<div class="headerSpace_HP row"> </div>
				<form>
					<div class=" "></div>
				</form>				
			</div>
		</div>
	</div>
	</body>
</html>