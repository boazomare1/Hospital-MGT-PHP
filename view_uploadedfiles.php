<?php
include ("db/db_connect.php");
 

$auto_number=$_REQUEST['id'];
$type=$_REQUEST['type'];
$maintype=$_REQUEST['maintype'];

if($maintype=="OP"){
if($type=='claim'){
		$query2 = "SELECT upload_claim,billno FROM billing_paylater WHERE auto_number = '$auto_number'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2num = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			$claim_file = $res2['upload_claim'];

			$fullPath = $res2['upload_claim'];
			$billno = $res2['billno'];
 
			    $file = "slade_uploads/".$fullPath;  
			    if (file_exists($file)) 
			    {
			        header('Content-type: application/pdf');
			        header('Content-Disposition: inline; filename='.basename($file));
			        header('Content-Transfer-Encoding: binary');
			        header('Expires: 0');
			        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			        header('Pragma: public');
			        header('Content-Length: ' . filesize($file));
			        readfile($file);
			        exit;
			    }           
		}
}

if($type=='invoice'){
		$query2 = "SELECT upload_invoice,billno FROM billing_paylater WHERE auto_number = '$auto_number'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2num = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			$fullPath = $res2['upload_invoice'];
			$billno = $res2['billno'];

				$file = "slade_uploads/".$fullPath;
			    if (file_exists($file)) 
			    {
			        header('Content-type: application/pdf');
			        header('Content-Disposition: inline; filename='.basename($file));
			        header('Content-Transfer-Encoding: binary');
			        header('Expires: 0');
			        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			        header('Pragma: public');
			        header('Content-Length: ' . filesize($file));
			        readfile($file);
			        exit;
			    }      
		}
}

}


//////////////////////////////////////////////////////////////////////
if($maintype=="IP"){
if($type=='claim'){
		$query2 = "SELECT upload_claim,billno FROM billing_ip WHERE auto_number = '$auto_number'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2num = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			$claim_file = $res2['upload_claim'];

			$fullPath = $res2['upload_claim'];
			$billno = $res2['billno'];
 
			    $file = "slade_uploads/".$fullPath;  
			    if (file_exists($file)) 
			    {
			        header('Content-type: application/pdf');
			        header('Content-Disposition: inline; filename='.basename($file));
			        header('Content-Transfer-Encoding: binary');
			        header('Expires: 0');
			        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			        header('Pragma: public');
			        header('Content-Length: ' . filesize($file));
			        readfile($file);
			        exit;
			    }           
		}
}

if($type=='invoice'){
		$query2 = "SELECT upload_invoice,billno FROM billing_ip WHERE auto_number = '$auto_number'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2num = mysqli_num_rows($exec2);
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			$fullPath = $res2['upload_invoice'];
			$billno = $res2['billno'];

				$file = "slade_uploads/".$fullPath;
			    if (file_exists($file)) 
			    {
			        header('Content-type: application/pdf');
			        header('Content-Disposition: inline; filename='.basename($file));
			        header('Content-Transfer-Encoding: binary');
			        header('Expires: 0');
			        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			        header('Pragma: public');
			        header('Content-Length: ' . filesize($file));
			        readfile($file);
			        exit;
			    }      
		}
}

}

?>