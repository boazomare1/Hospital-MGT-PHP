<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d',  strtotime('-1 month')); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; if($code == '0'){ $code = "";} } else { $code = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = " "; }
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["ageinp"])) { $ageinp = $_REQUEST["ageinp"]; } else { $ageinp = ""; }
if (isset($_REQUEST["gender"])) { $gender = $_REQUEST["gender"]; } else { $gender = " "; }
if (isset($_REQUEST["dmy"])) { $dmy = $_REQUEST["dmy"]; } else { $dmy = ""; }

?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.number1

{

text-align:right;

padding-left:700px;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

/*

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}

*/



function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}




</script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }

-->

</style>

</head>



<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

	    <tr>

	 <td width="860">

              <form name="cbform1" method="post" action="patientvisitlist.php">

                <table width="697" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

					<tr>

                      <td class="bodytext31" valign="center"  align="left"  bgcolor="#FFFFFF"> Date From </td>

                      <td width="15%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="9%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                 </tr>				
				<tr>
					<td width=""  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Range </td>
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
						<select name="range">
							<option value="" selected>Select</option>
							<option value="=" <?php if($range == '='){echo ' selected';} ?>>= </option>
							<option value=">" <?php if($range == '>'){echo ' selected';} ?>>> </option>
							<option value="<" <?php if($range == '<'){echo ' selected';} ?>>< </option>
							<option value=">=" <?php if($range == '>='){echo ' selected';} ?>>>= </option>
							<option value="<=" <?php if($range == '<='){echo ' selected';} ?>><= </option>
						</select>						
					</td>
					
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Age </td>
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31"><input name="ageinp" id="ageinp" size="4"  value="<?php echo $ageinp ?>" onKeyPress="return isNumber(event)"/></span>
					<select id="dmy" name="dmy">
						<option value="years" selected>Years</option>
						<option value="months" <?php if($dmy == 'months'){ echo ' selected'; } ?>>Months</option>
						<option value="days" <?php if($dmy == 'days'){ echo ' selected'; } ?>>Days</option>
					</select>

					&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="bodytext31">Gender </span>&nbsp;&nbsp;
					<select id="gender" name="gender">
						<option value="" selected>Select</option>
						<option value="Male" <?php if($gender == 'Male'){echo ' selected';} ?>>Male</option>
						<option value="Female" <?php if($gender == 'Female'){ echo ' selected'; } ?>>Female</option>
					</select>
					</td>
				</tr>
			 		<tr>

					  <td width="9%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>

					  <td width="18%" colspan="1" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

						<select id="code" name="code"><option value="0">Select</option><option value="1">New</option><option value="2">Revisit</option></select>

					  </span></td>

					  <td bgcolor="#FFFFFF" class="bodytext3">Department</td>

					  <td bgcolor="#FFFFFF" class="bodytext3"><strong><select id="department" name="department"><option value="">Select</option>

					          <?php

				$query6 = "select * from master_department where recordstatus = '' and auto_number <> '7' order by department ";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res6 = mysqli_fetch_array($exec6))
				{
				$res6anum = $res6["auto_number"];
				$res6department = $res6["department"];
				?>
                <option value="<?php echo $res6department; ?>" ><?php echo $res6department; ?></option>
                 <?php
				}

				?>

                      </select>

				  </strong></td>

					</tr>	
                    
                     <tr>

              <td bgcolor="#FFFFFF" class="bodytext3">Location</td>

               <td width="18%" colspan="1" align="left" valign="top"  bgcolor="#FFFFFF"><select name="location" id="location">

                  <?php

						

						$query = "select * from master_location  order by auto_number asc";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$locationname = $res["locationname"];

						$locationcode = $res["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>

						<?php

						}

						?>

                  </select></td>
    <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"></td>

              </tr>
              
                 


				<tr>


                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />
						  &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="excel_patientvisitlist.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&code=<?php echo $code; ?>&&department=<?php echo $department; ?>&&range=<?php echo $range; ?>&&ageinp=<?php echo $ageinp; ?>&&gender=<?php echo $gender; ?>&&dmy=<?php echo $dmy; ?>&&locationcode=<?php echo $location; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>						  
						  
						  
						  </td>

                    </tr>

                  </tbody>

                </table>

              </form>		</td>

	 </tr>  

	  <tr><td>&nbsp;</td></tr>		        

      <tr>

	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if($cbfrmflag1 == 'cbfrmflag1'){ ?>



	  <tr><form action="patientvisitlist.php" name="checklist" method="post">

        <td><table width="80%" height="80" border="0" 

            align="left" cellpadding="2" cellspacing="0" 

            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >

          <tbody>

            <tr>

              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">

                <div align="left"><strong>Patient List </strong></div></td>

			    </tr>

	

            <tr>

			  <td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>

              <td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

				 <td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registration No</strong></div></td>

				<td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>

				<td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>

				<td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Gender</td>

				<td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Date</strong></div></td>

              <td width="  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
                
                 <td width="19%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Refferal</strong></div></td>

				<td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Type</strong></div></td>

			  <td width=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>

           </tr>

			<?php

			

			$colorloopcount = '';
			$sno = 1;

			if($gender != ''){
				
				$gendercondition = " AND gender = '$gender'";
			}
			else{
				$gendercondition = '';
				
			}

			

           if($department != ''){
				
				$depcondition = " AND departmentname like '$department'";
			}
			else{
				$depcondition = '';
				
			}

			 if($code ==0){		
			$query1 = "select * from master_visitentry where locationcode='$location' and consultationdate between '$ADate1' and '$ADate2' $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			elseif($code == 1){		
			$query1 = "select * from master_visitentry where locationcode='$location' and consultationdate between '$ADate1' and '$ADate2' and visitcount = '1' $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
			$query1 = "select * from master_visitentry where locationcode='$location' and consultationdate between '$ADate1' and '$ADate2' and visitcount NOT IN (1)  $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

			while ($res1 = mysqli_fetch_array($exec1))

			{

			$patientname = $res1['patientfullname'];

			$registrationno = $res1['patientcode'];

			$visitno = $res1['visitcode'];

			$visitdate =$res1['consultationdate']." ".$res1['consultationtime'];

			$department = $res1['departmentname'];

			$visitcount = $res1['visitcount'];

			$gender = $res1['gender'];
			
			$refferal = $res1['refferal'];
			
			$billtype = $res1['billtype'];

			if($billtype=='PAY NOW'){
				$visittype='Cash';
			}else{
				$visittype='Credit';
			}


			$query751 = "select * from master_customer where customercode = '$registrationno'";
			$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res751 = mysqli_fetch_array($exec751);
			$dob = $res751['dateofbirth'];

			

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
					$age= $diff->y . ' Years';
					$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
					$age =$diff->m . ' Months';
					$monthsdayscondition = 'monthsordays';
				}
				else
				{
					$age =$diff->d . ' Days';
					$monthsdayscondition = 'monthsordays';

				}
					

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";

			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

			//$res2 = mysql_fetch_array($exec2);

			//$consultingdoctorname  = $res2['doctorname'];

			

			if($visitcount <= 1){$visitcount = 'New';}else{$visitcount = 'Revisit';}

			



			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}
		if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
				if($execution == 'true'){

					
				?>
				<tr <?php echo $colorcode; ?>>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>
                 
              
				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>   
				<?php } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
				?>
				  <tr <?php echo $colorcode; ?>>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>
				<?php } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				?>
				  <tr <?php echo $colorcode; ?>>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>

				  

				<?php
				}
				}
			}
			else{
				?>
				  <tr <?php echo $colorcode; ?>>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>
				<?php				
			}
			}
			
			

			 

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
                
                 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
				
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

   	       </tr>

          </tbody>

		  

        </table>

      </td> </form>

  </tr><?php } ?>

	</table>

	  

	

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



