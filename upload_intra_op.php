<?php
// session_start();
include ("db/db_connect.php");
$auto_number=$_REQUEST['auto'];
$uploadtype=$_REQUEST['uploadtype'];
if($uploadtype=='intra'){

    $visit=$_REQUEST['visit'];
    echo $fileName = $_FILES['file']['name'];
    $tmpName  = $_FILES['file']['tmp_name'];
    echo $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
exit;
    if(!empty($fileName) && ($fileSize>0)){ 


            $info = pathinfo($_FILES['file']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $visit."_".$auto_number."_intra.".$ext; 
            $target = 'op_uploads/'.$newname;
            move_uploaded_file( $_FILES['file']['tmp_name'], $target);
            $content=$newname;

            $query9912="update master_theatre_booking set intra_op='".$content."', orginal_file_name='$fileName'  where auto_number='$auto_number'";
            $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);
                 echo 'File uploaded successfully.';
	}else
		{
            echo 'Something went wrong. Please try again.';
           }
}
?>