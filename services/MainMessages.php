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
// echo'in 1 if';

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
              $msgStr.= messageContentHelper ($message); // this method construct the message content in the format need
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
            // echo'in 2 if';
              $dynamicClassNameWithId = "messagewithid_".$message->message_id;

              $msgStr.='<div class="message_body addOnMessages '.$dynamicClassNameWithId.'" id="'.$message->message_id.'">';
              $msgStr.= messageContentHelper ($message); // this method construct the message content in the format need
                $msgStr.='<div class="msg_reactionsec">';
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
          else if($prevUser!=$message->first_name || $prevTime!=$currentTime)
          {
            // echo'in 3 if';
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
              $msgStr.= messageContentHelper ($message); // this method construct the message content in the format need
              $msgStr.='<div class="msg_reactionsec">';
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


function messageContentHelper($message){
    $codeSnippLanguagesArr=["html","javascript","python","php"];
    $msgContent ="";
    if($message->is_specialmessage == 2){

        $msgContent= '<div class="msg_content"><div class="well"><pre><code class="'.$codeSnippLanguagesArr[ $message->code_type].'">'.htmlspecialchars($message->content).'</code></pre></div></div>';

    }else if( $message->is_specialmessage == 1){
        if($message->code_type == 1){ // in case of web image
            $msgContent= '<div class="msg_content"><a href="'.htmlspecialchars($message->content).'">'.htmlspecialchars($message->content).'</a><br /> <div class="well"> <img src="'. $message->content.'" /></div></div>';
        }else{
              // this is the place to handle images in the regular msg stream, got to load the images from the image folder reserved for regular msgs, for not sending the normal path
            $msgContent= '<div class="msg_content"><div class="well"> <img src="./Assets/msgimages/'.trim($message->message_id).'.'.htmlspecialchars($message->content) .'" /></div></div>';
        }

    }else{
        $msgContent= '<div class="msg_content">'.htmlspecialchars($message->content).'</div>';
    }

    return $msgContent;
}


?>
