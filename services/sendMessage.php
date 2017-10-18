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
      $insertStr = $web_service->createChannelMessage($userid,$content,$channelid,$timestamp);
    }
    header("location: ../HomePage.php?channel=".$channelid);
?>
