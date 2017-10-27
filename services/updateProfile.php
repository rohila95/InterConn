<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// if($_POST)
// {
//   $fname=$_FILES ['imgToUpload'] ['name'];
//   echo $fname;
//   echo 'in post';
//   if(pathinfo($fname,PATHINFO_EXTENSION)=="png")
//   {
//     echo 'in if';
//     if (is_uploaded_file ( $_FILES ['imgToUpload'] ['tmp_name'] )) {
//       $uploadfile_newname='images/ex.png';
//       $uploadSucess = move_uploaded_file($_FILES['imgToUpload']['tmp_name'], $uploadfile_newname);
//       if($uploadSucess){
//     		echo "success";
//     	}else{
//     		echo "fail";
//     	}
//
//   }
// }
$destination_path = getcwd().DIRECTORY_SEPARATOR;
echo $destination_path;
 $uploadfile_newname='../images/ex.png';
$uploadSucess = move_uploaded_file($_FILES['filetoUpload']['tmp_name'], $uploadfile_newname);
	if($uploadSucess){
		echo "success";
	}else{
		echo "fail";
	}

// }
?>
