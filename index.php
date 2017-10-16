<html>
	<head>
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./CSS/site.css">
	</head>
	<body>
		<div class="container mainLoginWrapper well w3-panel w3-card-4">
			<div class="row">
				<div class="col-sm-12 logo">
					<span>InterConn</span>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 credentialsWrapper">
					<h3>Sign In</h3>
					<form method="POST" action="./services/loginPage.php">
						<div class="invalidField">
						<?php
							if(isset($_GET["status"]))
							{
								if($_GET["status"]=='Unsuccessful')
								{
									echo 'Invalid username or password!';
								}
								else if($_GET["status"]=='notloggedin')
								{
									echo 'You are not signed in. Please Sign In';
								}
							}
						?>
						</div>
						<div class="input-group emailWrapper">
						    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						    <input id="email" type="text" class="form-control" name="email" placeholder="Email" >
						</div>

						<div class="input-group passwordWrapper">
						    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						    <input id="password" type="password" class="form-control" name="password" placeholder="Password" >
						</div>
						 <div class="forgotPasswordWrapper">
					    	<a href="#">Forgot password?</a>
					    </div>
					    <div class="buttonWrapper">
					    	<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					    </div>
					</form>
				</div>

				<div class="col-sm-1 lineDivider">
				</div>

				<div class="col-sm-5 otherSourcesWrapper">
					<h3>Login with</h3>

					<div class="twitterWrapper">
						<button type="submit" class="btn btn-primary btn-block disabled">
							<i class="glyphicon fa fa-twitter"></i>&nbsp;&nbsp; Twitter
						</button>
					</div>
					<div class="gitHubWrapper">
						<button type="submit" class="btn btn-primary btn-block disabled">
							<i class="glyphicon fa fa-github"></i>&nbsp;&nbsp; GitHub
						</button>
					</div>
				</div>
			</div>
			<div class="row newAccountWrapper">
				Don't have an account yet?&nbsp;<a href="#">Create your account now</a>
			</div>
		</div>
		<div class="footer row">
			<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small> 
		</div>
	</body>
</html>
