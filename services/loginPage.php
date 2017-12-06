<?php
session_start();
include_once "./database_connect.php";
include_once "./SqlService.php";
require_once "./recaptchalib.php";
//qav2 captcha
// $secret = "6LfQVjoUAAAAADM4-r7g6y42SZXW-8qtdTVIa5_6";
//docker captcha
$secret = "6LfjejsUAAAAACmfQ4aNiB2QUbfzChTy5YgkFmzg";

// empty response
$response = null;

// check secret key
$reCaptcha = new ReCaptcha($secret);
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

if ($response != null && $response->success)

{
    $loggedInId="";

    if($_POST && check_login($_POST['email'],$_POST['password'])){
        $_SESSION['emailid'] = $_POST['email'];
        $_SESSION['loggedIn'] = True;
        $_SESSION['githubLogin']=0;
        $database_connection = new DatabaseConnection();
        $conn = $database_connection->getConnection();

        $sql_service = new SqlService();
        $getUserDetails = $sql_service->getChannelGeneral($_SESSION['userid']);
        $result = $conn->query($getUserDetails);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $channelid=$row['channel_id'];
            }
        } else {
            echo 'fail';
        }
        $conn->close();

       header("location: ../HomePage.php?channel=".$channelid);
        // exit();
        // session_write_close();
    }elseif($_POST) {
        echo "Unsuccessful login<br><br>";
        echo "the session variable contents:<br>";
        header("location: ../index.php?status=Unsuccessful");
        // print_r($_SESSION);
    }else {
        echo "You're not logged in";
        echo "<br><br>the session variable contents:<br>";
        // print_r($_SESSION);
        header("location: ../index.php?status=notloggedin");
    }
}
else {
        echo "Please verify captcha";
        echo "<br><br>the session variable contents:<br>";
        // print_r($_SESSION);
        header("location: ../index.php?status=nocaptcha");
    }

function check_login($emailid,$password){

    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();
    $password=mysqli_real_escape_string($conn,$password);
    $emailid=mysqli_real_escape_string($conn,$emailid);
    $sql_service = new SqlService();
    $getUserDetails = $sql_service->getUserDetails($emailid,$password);
    $result = $conn->query($getUserDetails);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $loggedInId = $row['user_id'];
            $_SESSION['userid'] = $loggedInId;
            // echo $row['github_avatar'];
            if(!$row['github_avatar']==0)
                return false;
            return true;
        }
    } else {
        return false;
    }
    $conn->close();

}

?>
