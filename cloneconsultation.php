<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

 $username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

 $companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');   

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }


if ($frmflag1 == 'frmflag1')

{

    $accountnameanum = $_REQUEST['accountnameanum'];

	$consultationtype = $_REQUEST["consultationtype"];

	$doctorcode = $_REQUEST["consultationdoctorcode"];

	$doctorname = $_REQUEST["consultationdoctorname"];

	

	$department = $_REQUEST["department"];

	$consultationfees = $_REQUEST["consultationfees"];

	$paymenttype = $_REQUEST['paymenttype'];

	$subtype = $_REQUEST['subtype'];
	
	$initial_subtype = $_REQUEST['initial_subtype'];
		
	if($initial_subtype==$subtype)
	{
		$errmsg = "Failed. Please Change the Sub Type.";

		header ("location:cloneconsultation.php?bgcolorcode=failed&&st=edit&&anum=$prodcuttypeanum");
		exit;
	}

	$consultationtype = strtoupper($consultationtype);

	$consultationtype = trim($consultationtype);

	$length=strlen($consultationtype);

	$recordstatus = '';

	$recorddate = date('Y-m-d');

	$location1=$_REQUEST["location"];

	$locationcode = $_REQUEST['locationcode'];

	

	$default = isset($_REQUEST['default'])?$_REQUEST['default']:'';

	//echo $length;
	

	

	if ($length<=100)

	{

	

		
		
		$depart_count=isset($_REQUEST['depart_count'])?$_REQUEST['depart_count']:'';
		
		for($i=1; $i<$depart_count; $i++)
		{
		$deptget=isset($_REQUEST['dept'.$i])?$_REQUEST['dept'.$i]:'';
		$cons_name=isset($_REQUEST['consname'.$i])?$_REQUEST['consname'.$i]:'';
				
		$query181 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
		$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while ($res181 = mysqli_fetch_array($exec181))
		{
		$loccodeget=$res181['locationcode'];
		
		$loc_review=isset($_REQUEST['locrate'.$i.$loccodeget])?$_REQUEST['locrate'.$i.$loccodeget]:'';
		$locrateget=$loc_review;
		if($deptget!='' && $loc_review!='')
		{
			
			 $query1s2 = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='0'";
		$exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s2 = mysqli_num_rows($exec1s2);
		
		if($num1s2<=0)
		{	
		  $query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$loccodeget','$loccodeget','0','$paymenttype','$subtype')"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

		$query1s = "select auto_number from master_consultationtype where  department='$deptget'and paymenttype='$paymenttype' and subtype='$subtype' and condefault='0' order by auto_number desc limit 1";
		$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s = mysqli_num_rows($exec1s);
		$res1s = mysqli_fetch_array($exec1s);
		$consultation_id=$res1s['auto_number'];
		 
		if($num1s==1)
		{	
	  $query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$loccodeget', '$locrateget','0','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		 
		}
	  }
		
		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	
		}
		
	
		
		
		for($j=1; $j<$depart_count; $j++)
		{
		$deptget=isset($_REQUEST['dept'.$j])?$_REQUEST['dept'.$j]:'';
		$cons_name1=isset($_REQUEST['consname'.$j])?$_REQUEST['consname'.$j]:'';
		$cons_name=$cons_name1.' Review';
				
		$query181 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
		$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while ($res181 = mysqli_fetch_array($exec181))
		{
		$loccodeget=$res181['locationcode'];
		
		$loc_review=isset($_REQUEST['locreview'.$j.$loccodeget])?$_REQUEST['locreview'.$j.$loccodeget]:'';
		$locrateget=$loc_review;
		if($deptget!='' && $loc_review!='')
		{
			
			 $query1s1 = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1'";
		$exec1s1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s1) or die ("Error in query1s1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s1 = mysqli_num_rows($exec1s1);
		
		if($num1s1<=0)
		{	
		 $query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$loccodeget','$loccodeget','1','$paymenttype','$subtype')"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

		$query1s = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1' order by auto_number desc limit 1";
		$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s = mysqli_num_rows($exec1s);
		$res1s = mysqli_fetch_array($exec1s);
		$consultation_id=$res1s['auto_number'];
		if($num1s>=1 && $num1s<3)
		{ 
		$query1sw = "select auto_number from master_consultationtype where  department='$deptget'  and paymenttype='$paymenttype' and subtype='$subtype' and condefault='1'";
		$exec1sw = mysqli_query($GLOBALS["___mysqli_ston"], $query1sw) or die ("Error in query1sw".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1sw = mysqli_num_rows($exec1sw);
		}
		if($num1sw==1)
			{
	  $query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$loccodeget', '$locrateget','1','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		 
		}
	  }
		
		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	
		}
		
		
		
		
		
	}


header ("location:addconsultationtype1.php");

exit;

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_consultationtype set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_consultationtype set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_consultationtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_consultationtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_consultationtype set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Consultation Type To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if (isset($_REQUEST["subtype_edit"])) { $subtype_edit = $_REQUEST["subtype_edit"]; } else { $subtype_edit = ""; }
if (isset($_REQUEST["maintype_edit"])) { $maintype_edit = $_REQUEST["maintype_edit"]; } else { $maintype_edit = ""; }
if ($st == 'edit' && $anum != '')

{

    $query1 = "select * from master_consultationtype where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	$res1autonumber = $res1['auto_number'];

	$res1department = $res1['department'];

	$res1consultationtype = $res1['consultationtype'];

	$res1consultationfees = $res1['consultationfees'];

	$doctorname = $res1['doctorname'];

	$doctorcode = $res1['doctorcode'];

	$res1recordstatus = $res1['recordstatus'];

	$res1recorddate = $res1['recorddate'];

	$paymenttype = $res1['paymenttype'];

	$subtype = $res1['subtype'];

	$res1location = $res1['locationname'];

	$res1locationcode = $res1['locationcode'];

	$condefault = $res1['condefault'];

	

}



if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

	$errmsg = "Success. New Consultation Type Updated.";

}

if ($bgcolorcode == 'failed')

{

	$errmsg = "Failed. Sub Type Already Exists.";

}





?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<link href="js/jquery-ui.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script src="js/jquery-ui.js" type="text/javascript"></script>

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script>


</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function addward1process1()

{

	//alert ("Inside Funtion");

	

	/*if (document.form1.department.value == "")

	{

		alert ("Pleae Select Department.");

		document.form1.department.focus();

		return false;

	}*/





	/*if (document.form1.consultationtype.value == "")

	{

		alert ("Pleae Enter Consultation Type Name.");

		document.form1.consultationtype.focus();

		return false;

	}*/

	
/*if (document.form1.consultationdoctorcode.value == "")

	{

		alert ("Pleae Select Consultation Doctor.");

		document.form1.consultationdoctorname.focus();

		return false;

	}*/

	
	
	var ifcount=0;
	
	var lcount=document.form1.locationcount.value;
	
	if(lcount!=0)
	{
		for(var i=1; i<=lcount; i++)
		{
			if(document.form1.elements["lcheck"+i].checked == true)
			{ ifcount=ifcount+1;}
			
		}
		if(ifcount==0)
		{
			alert('Please select and Enter Fees For atleast one Location');
			return false;
		}
	}


}



function funcDeleteconsultationtype1(varConsultationTypeAutoNumber)

{

     var varAccountNameAutoNumber = varConsultationTypeAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Consultation Type '+varAccountNameAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Consultation Type  Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Consultation Type Entry Delete Not Completed.");

		return false;

	}



}



$(function() {

	$('#consultationdoctorname').autocomplete({

	source:'ajaxdoctornamesearch.php', 

	html: true, 

		select: function(event,ui){

			var medicine = ui.item.value;

			var doctorcode = ui.item.doctorcode;

			$('#consultationdoctorcode').val(doctorcode);

			$('#consultationdoctorname').val(medicine);
			

			

			},

    });

});
function clearCode()
{
$('#consultationdoctorcode').val('');	
}


</script>

<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td><form name="form1" id="form1" method="post" action="cloneconsultation.php" onSubmit="return addward1process1()">

                  <table width="1200" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Type Master - Add New </strong></td>

                      </tr>

					  <tr>

                        <td colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                        
                          <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>

                      </tr>

                      <tr style="display:none">

                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Location

                          <div align="right"></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="locationcode" value="<?php echo $res1locationcode; ?>">

						<select name="location" id="location" style="border: 1px solid #001E6A;">

                          <?php

				if ($res1location == '')

				{

					echo '<option value="" selected="selected">Select location</option>';

				}

				else

				{

					$query41 = "select * from master_location where auto_number = '$res1location'";

					$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res41 = mysqli_fetch_array($exec41);

					$res41locationanum = $res41['auto_number'];

					$res41location = $res41['locationname'];

					

					echo '<option value="'.$res41locationanum.'" selected="selected">'.$res41location.'</option>';

				}

				

				$query51 = "select * from master_location where status = '' order by locationname";

				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res51 = mysqli_fetch_array($exec51))

				{

				echo $res51anum = $res51["auto_number"];

				echo $res51location = $res51["locationname"];

				?>

                          <option value="<?php echo $res51anum; ?>"><?php echo $res51location; ?></option>

                          <?php

				}

				?>

                        </select></td>
                        
                         <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>

                      </tr>

					  

                     <!-- <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="department" id="department" style="border: 1px solid #001E6A;">

                          <?php

				if ($res1department == '')

				{

					echo '<option value="" selected="selected">Select department</option>';

				}

				else

				{

					$query4 = "select * from master_department where auto_number = '$res1department'";

					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res4 = mysqli_fetch_array($exec4);

					$res4departmentanum = $res4['auto_number'];

					$res4departmentname = $res4['department'];

					

					echo '<option value="'.$res4departmentanum.'" selected="selected">'.$res4departmentname.'</option>';

				}

				

				$query5 = "select * from master_department where recordstatus = '' order by department";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				echo $res5anum = $res5["auto_number"];

				echo $res5department = $res5["department"];

				?>

                          <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>

                          <?php

				}

				?>

                        </select></td>
                         <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>

                      </tr>-->

					  	    

				<tr>

				 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Main Type</div></td>

				  <td align="left" valign="middle"  bgcolor="#FFFFFF"> 

				  

				  <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();"  style="border: 1px solid #001E6A;">

                    

				  <?php

				  

				  	if ($paymenttype == '')

				{

					echo '<option value="" selected="selected">Select Type</option>';

				}

				else

				{

					$query511 = "select * from master_paymenttype where auto_number = '$paymenttype' and recordstatus = ''";

					$exec511 = mysqli_query($GLOBALS["___mysqli_ston"], $query511) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res511 = mysqli_fetch_array($exec511);

					$res511paymenttype = $res511["paymenttype"];

					$panum = $res511['auto_number'];

					echo '<option value="'.$panum.'" selected="selected">'.$res511paymenttype.'</option>';

				}

				

				$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["auto_number"];

				$res5paymenttype = $res5["paymenttype"];

				?>

                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>

                    <?php

				}

				?>

                  </select>

				  </td>
                   <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>

				  </tr>   
                  <?php
                   $query51 = "select * from master_subtype where auto_number = '$subtype' and recordstatus = ''";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res51 = mysqli_fetch_array($exec51);

					 $res51subtype = $res51["subtype"];

					 $res51anum = $res51["auto_number"];
                  ?>
				<tr>

					

				 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Sub Type</div></td>

<td align="left" valign="middle"  bgcolor="#FFFFFF">
<input type="hidden" name="subtype" id="subtype" value="<?php echo $res51anum;?>" />
<input type="text" name="search_subtype" id="search_subtype" value="<?php echo $res51subtype;?>" style="border: 1px solid #001E6A;" size="40" />
</td>
                   <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>

				  </tr>  

				  

                      <!--<tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">

                          <div align="right">Add New Consultation Type </div>

                        </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="consultationtype" id="consultationtype" value="<?php echo $res1consultationtype ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="40" />                                      </td>
                         <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                              <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                        
                            

                      </tr>-->

					  

					<tr>

						<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Doctor </div></td>

						<td align="left" valign="top"  bgcolor="#FFFFFF">

							<input type="text" name="consultationdoctorname" id="consultationdoctorname" style="border: 1px solid #001E6A;" size="40" autocomplete="off" onKeyPress="clearCode();" value="<?php echo $doctorname?>" >

							<input type="hidden" name="consultationdoctorcode" id="consultationdoctorcode" style="border: 1px solid #001E6A;" size="10"  value="<?php echo $doctorcode?>" >

						</td>
                         <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                              

					</tr>
						 <tr >
							   <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
							   <b>Location</b>
							  </td>
								
                                 <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                             <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                            <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                              <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                               <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
							  </tr> 
                              
                               </span>
					  
	   <tr>				  
	<td width="100%" colspan="17">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
	 <tr>
	 <td bgcolor="#FFFFFF" width="20%"><b>Department</b></td>
 	 
 <?php 
 $main_type='';
 $review_type='';
/*$query1s38 = "select condefault from master_consultationtype where  auto_number= '$anum'";
$exec1s38 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s38) or die ("Error in query1s38".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1s38 = mysqli_fetch_array($exec1s38);
$condefault_value=$res1s38['condefault'];
 if($condefault_value==1)
 {
	 $con_value='readonly';
	$conec_value='';
 }
 else
 {
		
	$con_value='';
	$conec_value='readonly';
 }*/
 
 $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$incr=0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						 $incr=$incr+1;
						 ?>
                <td align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" width="15%"><b><?php echo $locationname;?></b></td>
                <?php } ?>
                <td colspan="10" bgcolor="#FFFFFF">&nbsp;</td>	
                </tr> 	
                
                 <?php  $query12 = "select auto_number,department from master_department where recordstatus='' order by auto_number";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$dcr=1;
						while ($res12 = mysqli_fetch_array($exec12))
						{
						$department_code = $res12["auto_number"];
						$department_name = $res12["department"];
						
						
						 $query_sub1 = "select consultationfees,review,consultation_id from locationwise_consultation_fees where department='$department_code' and maintype='$maintype_edit' and subtype='$subtype_edit' and recordstatus <> 'Deleted' order by auto_number";

$exec_sub1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub1) or die ("Error in query_sub1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_num1 = mysqli_num_rows($exec_sub1);
$ressub1 = mysqli_fetch_array($exec_sub1);
$consultation_id_get = $ressub1["consultation_id"];

if($res_num1>0)
{
$checked="checked";
$consult_get=$res1consultationtype;
}
else
{
	$checked='';
}


   $query_sub12 = "select consultationtype from master_consultationtype where auto_number='$consultation_id_get' and condefault='0'";
$exec_sub12 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub12) or die ("Error in query_sub12".mysqli_error($GLOBALS["___mysqli_ston"]));
$ressub12 = mysqli_fetch_array($exec_sub12);
$consultation_get_val = $ressub12["consultationtype"];
/*if($consultation_id_get=='1')
{
	echo $query_sub12;
}*/
						?>
                        	<tr>
						 
						<td width="40%" class="bodytext3" height="25">
						<input type="checkbox" <?php echo $checked; ?>  name="dept<?php echo $dcr;?>" id="dept<?php echo $dcr;?>" style="float:left" value="<?php echo $department_code;?>" onClick="uncheckit('<?php echo $dcr;?>')"/>
                        
                        <b> &nbsp;&nbsp;<?php echo $department_name;?></b>
  <input type="text" class="un_check_it<?php echo $dcr;?>" name="consname<?php echo $dcr;?>" id="consname<?php echo $dcr;?>" style="float:right" value="<?php echo $consultation_get_val;?>" style="width:120px;" placeholder="Consultation Type" ></td>
						<?php 
						$query1 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						while ($res1 = mysqli_fetch_array($exec1))
						{
							$locationcode = $res1["locationcode"];
							
$query_sub = "select consultationfees,review from locationwise_consultation_fees where department='$department_code' and maintype='$maintype_edit' and subtype='$subtype_edit' and locationcode = '$locationcode' and review!='1' and recordstatus <> 'Deleted' limit 1";
$exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die ("Error in query_sub".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_sub = mysqli_fetch_array($exec_sub);
$rate=$res_sub['consultationfees'];

$query_sub23 = "select consultationfees,review from locationwise_consultation_fees where department='$department_code' and maintype='$maintype_edit' and subtype='$subtype_edit' and locationcode = '$locationcode'  and review='1'  and recordstatus <> 'Deleted' limit 1";
$exec_sub23 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub23) or die ("Error in query_sub23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_sub23 = mysqli_fetch_array($exec_sub23);
$rate1=$res_sub23['consultationfees'];


					?>
						<td  class="bodytext3" height="25" align="center" width="20%">
						 <input class="un_check_it<?php echo $dcr;?>" type="text" name="locrate<?php echo $dcr;?><?php echo $locationcode;?>"  id="locrate<?php echo $dcr;?><?php echo $locationcode;?>" style="width:90px;" placeholder="Main" onKeyPress="return validatenumerics(event);" value="<?php echo $rate;?>" />
                          <input class="un_check_it<?php echo $dcr;?>" type="text" name="locreview<?php echo $dcr;?><?php echo $locationcode;?>"  id="locreview<?php echo $dcr;?><?php echo $locationcode;?>" style="width:90px;" placeholder="Review" onKeyPress="return validatenumerics(event);" value="<?php echo $rate1;?>" >
	 
						</td>
					 <?php }?>
						<td colspan="10">&nbsp;</td>
						</tr>
		
					  <?php
				$dcr++;
					  }?>
					 
      
	</table>
 </td>
     
      
	  </tr>
      
        <input type="hidden" name="locationcount" id="locationcount" value="<?php echo  $incr;?>">     
	  <input type="hidden" name="discountcount" id="discountcount" value="<?php echo  $department_code;?>">			  
	  <input type="hidden" name="depart_count" id="depart_count" value="<?php echo  $dcr;?>">
   	  

                      

                       <tr style="display:none">

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Review </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

                          <input name="default" type="checkbox" id="default" <?php if($condefault=='on'){echo "checked";}?> >  </td>

                      </tr>

                      <tr>

                       <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="54%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />
                        
                        <input type="hidden" name="initial_subtype" id="initial_subtype" value="<?php echo $subtype_edit;?>" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

							<input type="hidden" name="accountnameanum" id="accountnameanum" value="<?php echo $res1autonumber ?>">

                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                </form>

                </td>

            </tr>

            <tr>

              <td>&nbsp;</td>

            </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

<script type="text/javascript">
function uncheckit(id)
{
if(document.getElementById("dept"+id).checked == false)
{
$(".un_check_it"+id).val('');
}

}

function funcPaymentTypeChange1()
{
var res12paymenttypeanum=$("#paymenttype").val();
$('#search_subtype').autocomplete({
source:'cons_subtypes.php?res12paymenttypeanum='+res12paymenttypeanum,
minLength:0,
html: true, 
select: function(event,ui){
$("#subtype").val(ui.item.subtypeid);
},
});	


}

$(document).ready(function(){
	
	funcPaymentTypeChange1();
	
});

</script>



