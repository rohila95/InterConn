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

    if($val){
        $prot = $urlArr[0];
        echo "bjsadjas";
        if($val1){
            echo $url;

            echo '<img src="'.$url.'" />';
        }
    }else{
        echo $url."Hello";
    }


?>