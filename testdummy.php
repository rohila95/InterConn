<?php
/**
 * Created by PhpStorm.
 * User: Mainsoft-HR
 * Date: 11/12/2017
 * Time: 9:06 PM
 */

    $imageExtension = ['jpg','JPG','jpeg','JPEG','png','PNG'];
    $protExtensions= ['https://www','https://www','www'];
    $url = "https://www.cs.odu.edu/~mgunnam/underconstruction.jpg";
    $urlArr = explode(".",$url);
    //print_r($urlArr[count($urlArr)-1]);
    $val= in_array($urlArr[count($urlArr)-1],$imageExtension);
    $val1= in_array($urlArr[0],$protExtensions);
    $extension = $urlArr[count($urlArr)-1];

    file_get_contents("http://www.cs.odu.edu/~mgunnam/underconstruction.jpg");
    var_dump($http_response_header);
    echo "<br />";
    echo $http_response_header[0];

    echo "<br />";
    echo "stringpos->".strpos($http_response_header[0],"301");

echo "<br />";

    if($val){
        $prot = $urlArr[0];
        if($val1){
            echo $url;
            echo '<img src="'.$url.'" />';

        }
    }else{
        echo $url."Hello";
    }



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