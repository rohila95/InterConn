<?php
function constructMessagesDiv($messageStr)
{
    $codeSnippLanguagesArr=["html","javascript","python","php"];

    $web_service = new WebService();
  $currentChannelMessages = json_decode($messageStr);
  // var_dump($currentChannelMessages);

  $msgStr='';
  $prevdate='';
  $prevUser='';
  $prevTime='';
  if ($currentChannelMessages!=null)
  {
    $remainingMessages= $currentChannelMessages->messageCount;
    // echo $remainingMessages;

    $lastmessageid= $currentChannelMessages->lastmessageid;
    // echo $lastmessageid;
    if($remainingMessages==0)
      echo '<div>This is the begining of Chat....</div>';
    else if($remainingMessages>0)
      echo '<div class="oldMessages" id='.$lastmessageid.'><a>Loading more Messages...</a></div>';
    $currentChannelMessages=$currentChannelMessages->messages;

      date_default_timezone_set('America/New_York');
      $time= time();
      $today = date("l, F jS, o", $time);
      foreach ($currentChannelMessages as $message)
      {
// echo json_encode($message);
          $currentDate=$web_service->getFormatDate($message->created_at);
          $currentTime=$web_service->getFormatTime($message->created_at);
          $shortName= $message->first_name[0];
          if($message->last_name == '' || $message->last_name== null){
              $shortName.= $message->first_name[1];
          }else{
              $shortName.= $message->last_name[0];
          }
          $defUserPicBGColorArr = ['#3F51B5','#2196F3','#00BCD4','#CDDC39','#FF5722'];
          $defUserPicBGColor = $defUserPicBGColorArr[((int)$message->user_id)%5];
          if($currentDate==$today)
              $currentDate='Today';


          if($prevUser=='' && $prevTime=='')
          {
              if($prevdate!=$currentDate)
              {
                  $msgStr.='<div class="row dayDividerWrapper"><div class="daySeperatorLine col-xs-5 pull-left"> </div><div class="dayDividerText col-xs-2">'.$currentDate.'</div><div class="daySeperatorLine col-xs-5 pull-right"> </div></div>';
                  $prevdate=$currentDate;
              }


              if($message->profile_pic=='./images/0.jpeg')
                 $msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic" style="background:'.$defUserPicBGColor .';">'. htmlspecialchars(strtoupper($shortName)) .'</div></div><div class="col-xs-11 message"><div class="message_header" userid="'.$message->user_id .'"  ><b>';
              else
                $msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic profilePic" style="background-image:url('.$message->profile_pic .') !important;background-size: 36px 36px !important;"></div></div><div class="col-xs-11 message"><div class="message_header" userid="'.$message->user_id .'"><b>';

              $msgStr.=htmlspecialchars($message->first_name);
              $msgStr.=' '.htmlspecialchars($message->last_name).'</b><span class="message_time"> ';
              $msgStr.=$currentTime;
              $msgStr.='</span></div>';
              $dynamicClassNameWithId = "messagewithid_".$message->message_id;
              $msgStr.='<div class="message_body '.$dynamicClassNameWithId.'" id="'.$message->message_id.'">';
              //place to check for web image or not, this can even be done at entry of msg itself level self
              /*if(checkIfWebImg( htmlspecialchars($message->content ))){
                  $msgStr.='<div class="msg_content">.htmlspecialchars($message->content)."<br/>".<img src="'.htmlspecialchars($message->content).'" /></div>';

              }else{
                  $msgStr.='<div class="msg_content">'.htmlspecialchars($message->content).'</div>';
              }*/

              if($message->is_specialmessage == 2){

                  $msgStr.= '<div class="msg_content"><pre><code class="'.$codeSnippLanguagesArr[ $message->code_type].'">'.htmlspecialchars($message->content).'</code></pre></div>';

              }else{
                  $msgStr.= '<div class="msg_content">'.htmlspecialchars($message->content).'</div>';

              }
              $msgStr.='<div class="msg_reactionsec">';
              // print_r($message->emojis);
              if($message->emojis!='0')
                  foreach ($message->emojis as $emoji)
                  {
                      $msgStr.='<div class="emojireaction" emojiid="'.$emoji->emoji_id.'"><i class="'.$emoji->emoji_pic.'"></i><span class="reactionCount">'.$emoji->count.'</span></div>';
                  }
                  if($message->is_threaded==1)
                  {
                      $thread=$message->threads->threadCount;
                      $msgStr.="<div class='repliescount' title='view thread'><a href='#'><span>".$thread.'</span> replies'."</a></div>";

                  }
                  $msgStr.=' </div></div>';
              $prevUser=$message->first_name;
              $prevTime=$currentTime;

          }
          else if($prevUser==$message->first_name && $prevTime==$currentTime )
          {
              $dynamicClassNameWithId = "messagewithid_".$message->message_id;

              $msgStr.='<div class="message_body addOnMessages '.$dynamicClassNameWithId.'" id="'.$message->message_id.'">';
                 /*this is the block that decides how to  show the message content */
                 if($message->is_specialmessage == 2){

                     $msgStr.= '<div class="msg_content"><pre><code class="'.$codeSnippLanguagesArr[ $message->code_type].'">'.htmlspecialchars($message->content).'</code></pre></div>';

                 }else{
                     $msgStr.= '<div class="msg_content">'.htmlspecialchars($message->content).'</div>';

                 }

              $msgStr.='<div class="msg_reactionsec"> </div></div>';

          }
          else if($prevUser!=$message->first_name || $prevTime!=$currentTime)
          {
              $msgStr.='</div></div>';
              if($prevdate!=$currentDate)
              {
                  $msgStr.='<div class="row dayDividerWrapper"><div class="daySeperatorLine col-xs-5 pull-left"> </div><div class="dayDividerText col-xs-2">'.$currentDate.'</div><div class="daySeperatorLine col-xs-5 pull-right"> </div></div>';
                  $prevdate=$currentDate;
              }
              // $msgStr.= $message->profile_pic;
              if($message->profile_pic=='./images/0.jpeg')
                 $msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic" style="background:'.$defUserPicBGColor .';">'. htmlspecialchars(strtoupper($shortName)) .'</div></div><div class="col-xs-11 message"><div class="message_header" userid="'.$message->user_id .'"  ><b>';
              else
                $msgStr.='<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic profilePic" style="background-image:url('.$message->profile_pic .') !important;background-size: 36px 36px !important;"></div></div><div class="col-xs-11 message"><div class="message_header" userid="'. $message->user_id .'" ><b>';
              $msgStr.=htmlspecialchars($message->first_name);
              $msgStr.=' '.htmlspecialchars($message->last_name).'</b><span class="message_time"> ';
              $msgStr.=$currentTime;
              $msgStr.='</span></div>';
              $dynamicClassNameWithId = "messagewithid_".$message->message_id;
              $msgStr.='<div class="message_body '.$dynamicClassNameWithId.'" id="'.$message->message_id.'">';

              if($message->is_specialmessage == 2){

                  $msgStr.= '<div class="msg_content"><pre><code class="'.$codeSnippLanguagesArr[ $message->code_type].'">'.htmlspecialchars($message->content).'</code></pre></div>';

              }else{
                  $msgStr.= '<div class="msg_content">'.htmlspecialchars($message->content).'</div>';

              }

              $msgStr.='<div class="msg_reactionsec">';
              // print_r($message->emojis);
              if($message->emojis!='0')
                  foreach ($message->emojis as $emoji)
                  {
                      $msgStr.='<div class="emojireaction" emojiid="'.$emoji->emoji_id.'"><i class="'.$emoji->emoji_pic.'"></i><span class="reactionCount">'.$emoji->count.'</span></div>';
                  }
                  if($message->is_threaded==1)
                  {
                      $thread=$message->threads->threadCount;
                      $msgStr.="<div class='repliescount' title='view thread'><a href='#'><span>".$thread.'</span> replies'."</a></div>";

                  }
              $msgStr.=' </div></div>';
              $prevUser=$message->first_name;
              $prevTime=$currentTime;
          }
      }
      $msgStr.='</div></div>';

  }
  else
  {
      $msgStr="<div>No messages in this channel..</div>";
  }
  echo $msgStr;
}

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
            echo "true";
            return true;
        }
    }
    echo "false";
    return false;
}


?>