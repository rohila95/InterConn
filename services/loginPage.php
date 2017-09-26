<?php
session_start();
include_once "connection.php";

if($_POST && check_login($_POST['emailid'],$_POST['password'])){
    $_SESSION['emailid'] = $_POST['emailid'];
    $_SESSION['loggedIn'] = True;

    header("location: index.php");
    exit();
    session_write_close();
}elseif($_POST) {
    echo "Unsuccessful login<br><br>";
    echo "the session variable contents:<br>";
    print_r($_SESSION);
}else {
    echo "You're not logged in";
    echo "<br><br>the session variable contents:<br>";
    print_r($_SESSION);
}

function check_login($emailid,$password){
    echo $emailid."-- details--".$password;
    $database_connection = new DatabaseConnection();
    $conn = $database_connection->getConnection();

    $web_service = new WebService();
    $getUserDetails = $web_service->getUserDetails(); 

   

    echo $getUserDetails;

    $result = $conn->query($getUserDetails);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "success";
            return true;
        }
    } else {
        echo "0 results";
        return false;
    }
    $conn->close();




}

?>