<?php
require_once('conn.php');
if(isset($_POST["submit"]) && $_POST["submit"]){

        
$name=$_POST['name'];
$description=$_POST["description"];
$date=$_POST["date"];
$hours=$_POST["hours"];
$minutes=$_POST["minutes"];
$userid=$_SESSION['userid'];
$categoryid=$_POST['cateselect'];
$duration=$hours.'h '.$minutes.'m';
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


$sql = "INSERT INTO `activities`(`userId`, `categoryId`, `name`, `description`, `date`, `duration`,`photo`) VALUES ($userid,$categoryid,'$name','$description','$date','$duration', '$fileName')";

// echo $sql;
if ($conn->query($sql) ) {
    // echo "<script>alert('Data inserted')</script>";
    header("Location:../home.php");
  } else {
    // echo "<script>alert('Problem to insert data try after some time')</script>";
    header("Location:../home.php");
  }


}