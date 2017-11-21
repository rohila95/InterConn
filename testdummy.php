<?php
/**
 * Created by PhpStorm.
 * User: Mainsoft-HR
 * Date: 11/12/2017
 * Time: 9:06 PM
 */
$msgcontent = "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Icons8_flat_businessman.svg/1024px-Icons8_flat_businessman.svg.png";
    $imageExtension = ['jpg','JPG','jpeg','JPEG','png','PNG'];
        $urlArr = explode(".",$msgcontent);
        //print_r($urlArr[count($urlArr)-1]);
        $isImage= in_array($urlArr[count($urlArr)-1],$imageExtension);
        $isValidPort= in_array($urlArr[0],$portExtensions);
        if($isImage != false){
            if($isValidPort != false){
              
                //echo '<img src="'.$url.'" />';
                file_get_contents($msgcontent);
                $statusContent = $http_response_header[0];
                $isNotValidURL = strpos($statusContent,"404");
                if($isNotValidURL == false){
                    echo "true";
                }
            }
        }
        echo "false";


   echo '<div class="container">
    <pre><code class="javascript">
    $(document).ready(function() {
        $"pre code").each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
    </code></pre>
    <pre><code class="python">
        
          if val==1:
            print "val2"
          else:
            print "notval1"
    </code></pre>
    </div>
    		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>
    <script> $(document).ready(function() { hljs.initHighlightingOnLoad(); }); </script>';


?>