<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "./WebService.php";

    $userid=$_POST['userid'];
    $isChannelMode = true;
    $channelid=$_POST['channelid'];
    $directmsgid = $_POST['directmsgid'];
    if($channelid==""){
      $isChannelMode = false;
    }


    $content=$_POST['message'];
    $codetype=0;
    $splmessage=$_POST['isspecialmsg'];
    if($splmessage == 2){
        $codetype=$_POST['codesnipptype'];
    }

    $timestamp = date('Y-m-d H:i:s', time());
    if(trim($content)!='')
    {
      $web_service = new WebService();

      if(checkIfWebImg( trim($content ))){
          $content = trim($content);
          $splmessage = 1;
          $codetype= 1 ; // codetype-> 1 for webmessaged other wise it be be left to 0 itself

          // $content = trim($content)."<br /><img src='". trim($content)."' />";
         // $content = "<img src='". trim($content)."' />";
      }else{
          $content = trim($content );
      }
      //splmessage= 0--normal,  1--image,2--code6
      //codetype---int  ,0-html,1-js,2-python,3-php....
      if($isChannelMode){
          $insertStr = $web_service->createChannelMessage($userid,$content,$channelid,$timestamp,$splmessage,$codetype);

      }else{
          $insertStr = $web_service->createDirectMessage($userid,$content,$directmsgid ,$timestamp,$splmessage,$codetype);

      }
    }
    if($isChannelMode){
          header("location: ../HomePage.php?channel=".$channelid);

    }else{
          header("location: ../HomePage.php?directmsg=".$directmsgid);
    }

    function checkIfWebImg( $msgcontent ){
        $imageExtension = ['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF'];
        // $urlArr = explode(".",$msgcontent);
        //print_r($urlArr[count($urlArr)-1]);
        $type = get_headers($msgcontent, 1)["Content-Type"];
        // echo $type;
        $imgType=explode("/",$type);
        // $isImage= in_array($urlArr[count($urlArr)-1],$imageExtension);
        $isImage= in_array($imgType[1],$imageExtension);
        if($isImage){

                //echo '<img src="'.$url.'" />';
                file_get_contents($msgcontent);
                $statusContent = $http_response_header[0];
                $isNotValidURL = strpos($statusContent,"404");
                if($isNotValidURL == false){
                    return true;
                }
        }
        return false;
    }
?>
