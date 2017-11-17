<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "./WebService.php";

    $userid=$_POST['userid'];
    $channelid=$_POST['channelid'];
    $content=$_POST['message'];
    $timestamp = date('Y-m-d H:i:s', time());
    if(trim($content)!='')
    {  
      $web_service = new WebService();
      if(checkIfWebImg( trim($content ))){
          $content = trim($content)."<br /><img src='". trim($content)."' />";
      }else{
          $content = trim($content );
      }

      $insertStr = $web_service->createChannelMessage($userid,$content,$channelid,$timestamp);
    }
    header("location: ../HomePage.php?channel=".$channelid);


    function checkIfWebImg( $msgcontent ){
        $imageExtension = ['jpg','JPG','jpeg','JPEG','png','PNG'];
        $portExtensions= ['https://www','https://www','www'];
        $msgcontent = "https://www.cs.odu.edu/~mgunnam/underconstruction.jpg";
        $urlArr = explode(".",$msgcontent);
        //print_r($urlArr[count($urlArr)-1]);
        $isImage= in_array($urlArr[count($urlArr)-1],$imageExtension);
        $isValidPort= in_array($urlArr[0],$portExtensions);
        if($isImage){
            if($isValidPort){
                //echo '<img src="'.$url.'" />';
                return true;
            }
        }
        return false;
    }
?>
