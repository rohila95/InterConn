<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
		<title>InterConn</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="./Assets/jquery.min.js"></script>
		<script type="text/javascript" src="./scripts/sitescript.js"></script>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./Assets/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./CSS/site.css">
		<link rel="stylesheet" href="./CSS/colisiondetect.css">
		<script type="text/javascript" src="./scripts/d3/d3.js"></script>
	    <script type="text/javascript" src="./scripts/d3/d3.geom.js"></script>
	    <script type="text/javascript" src="./scripts/d3/d3.layout.js"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
<!--	   	<script type="text/javascript" src="./scripts/collisiondetect.js"></script>
-->	</head>
	<body>
		<div id="collisiondetect_wrapper" style="position: absolute;"> </div>

		<div class="container ">

            <div class="col-xs-1"></div>
                <div class="col-xs-8 mainLoginWrapper well w3-panel w3-card-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="logo">InterConn</h1>
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
                                        else if($_GET["status"]=='nocaptcha')
                                        {
                                            echo 'Please verify captcha. Try again.';
                                        }
                                        else if($_GET["status"]=='signout')
                                        {
                                            session_start();
                                            unset($_SESSION['loggedIn']);
                                            unset($_SESSION['emailid']);
                                            unset($_SESSION['userid']);
                                            session_unset();
                                            session_destroy();
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
                                <div class="captchaWrapper">
                                <!-- qav2 -->
                                    <!-- <div class="g-recaptcha" data-sitekey="6LfQVjoUAAAAAD_w1gSuM_bz8zLk97capHidchRN" data-callback="reCaptchad"></div> -->
                                    <!-- docker -->
                                    <div class="g-recaptcha" data-sitekey="6LfjejsUAAAAAAPDW7-tn-daogbbotzZclSiCLSD" data-callback="reCaptchad"></div>
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
                            <div class="gitHubWrapper">
                            <!-- git hub login qav2 -->
                            <!-- <a href="https://github.com/login/oauth/authorize?client_id=209a35200a7fe455f866&redirect_uri=http://qav2.cs.odu.edu/rohila/WebProgramming-CS518/services/githubLogin.php&scope=user:email/"> -->
                            <!-- git hub login docker -->
                            <a href="https://github.com/login/oauth/authorize?client_id=308de2ae4d6509d14594&redirect_uri=http://rohila95.cs518.cs.odu.edu/services/githubLogin.php&scope=user:email/">
                                <button type="submit" class="btn btn-primary btn-block">
                                     <i class="glyphicon fa fa-github"></i>&nbsp;&nbsp; GitHub
                                </button>
                            </a>
                            </div>
                            <div class="twitterWrapper">
                                <button type="submit" class="btn btn-primary btn-block disabled">
                                    <i class="glyphicon fa fa-twitter"></i>&nbsp;&nbsp; Twitter
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="row newAccountWrapper">
                        <div class="col-sm-12">
                        Don't have an account yet?&nbsp;<a href="./register.html">Create your account now</a> </div>
                    </div>
                </div>
            <div class="col-xs-1"></div>
		</div>


		<div class="footer row">
			<small >&copy; Mahesh Kukunooru, Rohila Gudipati, Maheedhar Gunnam</small>
		</div>
	</body>
</html>
