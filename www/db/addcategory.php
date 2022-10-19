<?php
require_once('conn.php');
if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    $name = $_POST['name'];
    $userid = $_SESSION['userid'];
	
	$ERROR = array(
               
                'upload' => '',
            );

  // file upload to database
                $file = $_FILES['upload'];
                $fileName = $_FILES['upload']['name'];
                $fileExt = explode(".",$fileName);
                $fileExtension = strtolower(end($fileExt));
                $valid = array('jpg','jpeg','png');
                if(in_array($fileExtension,$valid)){
                    if($_FILES['upload']['error'] == 0){
                        if($_FILES['upload']['size'] < 20000000){
                            $fileDestination = 'image/'.$fileName;
                            $fileLocation = $_FILES['upload']['tmp_name'];
                        }else{
                            $ERROR['upload'] = "File too big";        
                        }
                    }else{
                        $ERROR['upload'] = "ERROR while uploading file";    
                    }
                }else{
                    $ERROR['upload'] = "File format should be JPG, JPEG, PNG";
                }
 move_uploaded_file($fileLocation,$fileDestination);
                    require 'conn.php';

    $sql1 = "INSERT INTO `categories`(`userId`,`name`,`photo`) VALUES ($userid,'$name','$fileName')";

    if ($conn->query($sql1)) {
        // echo "<script>alert('Data inserted')</script>";
        header("Location:../catagory.php");
    } else {
        // echo "<script>alert('Problem to insert data try after some time')</script>";
        header("Location:../catagory.php");
    }
} else {
    $name = $_POST['name'];
    $userid = $_SESSION['userid'];
    // echo "error";
    // echo $userid;
    // echo $name;
}