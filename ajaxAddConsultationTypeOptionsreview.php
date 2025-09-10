<?php

session_start();

//error_reporting(0);

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";



	 

if(isset($_POST['department']) && isset($_POST['subtype']) && isset($_POST['doctorcode']))

{

	$opt='';

	$optfees = '';
	$optfees1 = '';

	$department  = $_POST["department"];

	$subtype = $_POST["subtype"];

	$doctorcode  = $_POST["doctorcode"];

	$locationcode = $_POST["location"];

	 $sno=0;

	//$query10 ="select auto_number,consultationtype,condefault,consultationfees from master_consultationtype where department = '$department' and subtype = '$subtype' and locationcode = '$locationcode' and recordstatus <>'deleted' order by consultationtype";

	

	echo $query10 ="select auto_number,consultationtype,condefault,consultationfees from master_consultationtype where department = '$department' and subtype = '$subtype' and doctorcode = '$doctorcode' and locationcode = '$locationcode' and recordstatus <>'deleted' and condefault='on' order by consultationtype";

	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

	$execnumrow = mysqli_num_rows($exec10);

	if($execnumrow > 0){

	

	while ($res10 = mysqli_fetch_array($exec10))

	{

		$sno+=1;

		$res10consultationtypeanum = $res10['auto_number'];

$query1 = "select consultationfees from locationwise_consultation_fees where consultation_id='$res10consultationtypeanum' and doctorcode = '$doctorcode' and locationcode = '$locationcode' and department='$department' ";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

		$res10consultationtype = $res10["consultationtype"];

		$res10consultationdefault = $res10["condefault"];

		$res10consultationfee = $res1["consultationfees"];

		

		if($res10consultationdefault=='on'){

			$selected ="selected";

		}else{

			$selected ="";
			// $optfees1=$optfees;

		}

		

		$opt = $opt.'<option value="'.$res10consultationtypeanum.'" '.$selected.'>'.$res10consultationtype.'</option>';

		// $optfees = $optfees.",".$res10consultationfee;

		if($selected =="selected"){
			$optfees = $optfees1.",".$res10consultationfee;
		}else{
				if($sno==1){
					$optfees = $optfees1.",".$res10consultationfee;	
				}
		}


	}

		

	}else{

		$opt = '<option value="" selected="selected">Select Consultation Type</option>';

		$optfees = '';

	}

	echo $opt."^".$optfees;

}

?>

