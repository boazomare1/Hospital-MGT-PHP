<?php
// session_start();
include ("db/db_connect.php");

// $ipaddress = $_SERVER['REMOTE_ADDR'];
// $updatedate = date('Y-m-d');
// $updatetime = date('H:i:s');
// $username = $_SESSION['username'];
// $docno = $_SESSION['docno'];
// $companycode = $_SESSION['companyanum'];
// $companyname = $_SESSION['companyname'];

// $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
// $exec = mysql_query($query) or die ("Error in Query1".mysql_error());
// $res = mysql_fetch_array($exec);
// $res12location = $res["locationname"];
// $res12locationcode = $res["locationcode"];
// $res12locationanum = $res["auto_number"];

$auto_number=$_REQUEST['auto'];
$uploadtype=$_REQUEST['uploadtype'];
$maintype=$_REQUEST['maintype'];

if($maintype=='OP'){

if($uploadtype=='claim'){

    $uploadfrom=$_REQUEST['uploadfrom'];
    $billno=$_REQUEST['billno'];

    /*$fileName = $_FILES['file']['name'];
    $tmpName  = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];*/
	
	echo 'fileName-->'.$fileName = $_FILES['file']['name'];
echo 'tmpName-->'.$tmpName  = $_FILES['file']['tmp_name'];
echo 'fileSize-->'.$fileSize = $_FILES['file']['size'];
echo 'fileType-->'. $fileType = $_FILES['file']['type'];

    if(!empty($fileName) && ($fileSize>0)){ 


            $info = pathinfo($_FILES['file']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $billno."_claim.".$ext; 
            $target = 'slade_uploads/'.$newname;
            move_uploaded_file( $_FILES['file']['tmp_name'], $target);
            $content=$newname;

             $query9912="update  billing_paylater set upload_claim='".$content."', uploaded_claimform_name='$fileName'  where auto_number='$auto_number'";
           // $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);
                 echo 'File uploaded successfully.';
           }else{
            echo 'Something went wrong. Please try again.';
           }
}

if($uploadtype=='invoice'){

    $uploadfrom=$_REQUEST['uploadfrom'];
    $billno=$_REQUEST['billno'];

    $fileName = $_FILES['file']['name'];
    $tmpName  = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    if(!empty($fileName) && ($fileSize>0)){ 
            $info = pathinfo($_FILES['file']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $billno."_invoice.".$ext; 
            $target = 'slade_uploads/'.$newname;
            move_uploaded_file( $_FILES['file']['tmp_name'], $target);
            $content=$newname;

             $query9912="update  billing_paylater set upload_invoice='".$content."', uploaded_invoice_name='$fileName' where auto_number='$auto_number'";
            $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);
                 echo 'File uploaded successfully.';
           }else{
            echo 'Something went wrong. Please try again.';
           }
}

if($uploadtype=='checkboxcheck'){
             $query2="SELECT * FROM billing_paylater WHERE auto_number = '$auto_number'";
            $exec2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
            while ($res2 = mysqli_fetch_array($exec2))
            {
                $slade_status = $res2['slade_status'];
                  $slade_claim_id = $res2['slade_claim_id'];
                  $claim_file = $res2['upload_claim'];
                  $invoice_file = $res2['upload_invoice'];

                if( ($slade_claim_id=='' )  ||  ($claim_file!='' && $invoice_file!='' && $slade_status=='completed') ){
                        echo 'success';
                }else{
                            echo 'error';
                    }
                    // ($slade_status=='completed' && $slade_claim_id!='') ||
             }
}
 
 // if(file_exists("slade_uploads/".$newname)) unlink("slade_uploads/".$newname);

} // lose of if cond for OP


// //////////////////////////////////////////////////////////////////////////////////
if($maintype=='IP'){
if($uploadtype=='claim'){

    $uploadfrom=$_REQUEST['uploadfrom'];
    $billno=$_REQUEST['billno'];

    $fileName = $_FILES['file']['name'];
    $tmpName  = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    if(!empty($fileName) && ($fileSize>0)){ 


            $info = pathinfo($_FILES['file']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $billno."_claim.".$ext; 
            $target = 'slade_uploads/'.$newname;
            move_uploaded_file( $_FILES['file']['tmp_name'], $target);
            $content=$newname;

             $query9912="update  billing_ip set upload_claim='".$content."', uploaded_claimform_name='$fileName'  where auto_number='$auto_number'";
            $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);
                 echo 'File uploaded successfully.';
           }else{
            echo 'Something went wrong. Please try again.';
           }
}

if($uploadtype=='invoice'){

    $uploadfrom=$_REQUEST['uploadfrom'];
    $billno=$_REQUEST['billno'];

    $fileName = $_FILES['file']['name'];
    $tmpName  = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    if(!empty($fileName) && ($fileSize>0)){ 
            $info = pathinfo($_FILES['file']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $billno."_invoice.".$ext; 
            $target = 'slade_uploads/'.$newname;
            move_uploaded_file( $_FILES['file']['tmp_name'], $target);
            $content=$newname;

             $query9912="update  billing_ip set upload_invoice='".$content."', uploaded_invoice_name='$fileName' where auto_number='$auto_number'";
            $exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);
                 echo 'File uploaded successfully.';
           }else{
            echo 'Something went wrong. Please try again.';
           }
}

if($uploadtype=='checkboxcheck'){
             $query2="SELECT * FROM billing_ip WHERE auto_number = '$auto_number'";
            $exec2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
            while ($res2 = mysqli_fetch_array($exec2))
            {
                $slade_status = $res2['slade_status'];
                  $slade_claim_id = $res2['slade_claim_id'];
                  $claim_file = $res2['upload_claim'];
                  $invoice_file = $res2['upload_invoice'];

                if( ($slade_claim_id=='' )  ||  ($claim_file!='' && $invoice_file!='' && $slade_status=='completed') ){
                        echo 'success';
                }else{
                            echo 'error';
                    }
                    // ($slade_status=='completed' && $slade_claim_id!='') ||
             }
}

}

?>