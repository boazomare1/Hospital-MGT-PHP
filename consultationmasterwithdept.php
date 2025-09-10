<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$docno = $_SESSION['docno'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";  

$subtype = "";

$paymenttype = "";

$recorddate = "";

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }





if (isset($_REQUEST["searchdepartmentname"])) { $searchdepartmentname = $_REQUEST["searchdepartmentname"]; } else { $searchdepartmentname = ""; }

if (isset($_REQUEST["searchdepartmentcode"])) { $searchdepartmentcode = $_REQUEST["searchdepartmentcode"]; } else { $searchdepartmentcode = ""; }

if (isset($_REQUEST["searchdepartmentanum"])) { $searchdepartmentanum = $_REQUEST["searchdepartmentanum"]; } else { $searchdepartmentanum = ""; }

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

 	

	$consultationtype = $_REQUEST["consultationtype"];

	$doctorcode = $_REQUEST["consultationdoctorcode"];

	$doctorname = $_REQUEST["consultationdoctorname"];

	

	$locationcode = $_REQUEST["location"];

	$department = $_REQUEST["department"];

	$consultationfees = $_REQUEST["consultationfees"];

	$default = isset($_REQUEST['default'])?$_REQUEST['default']:'';

	$paymenttype = $_REQUEST['paymenttype'];

	$subtype = $_REQUEST['subtype'];

	$consultationtype = strtoupper($consultationtype);

	$consultationtype = trim($consultationtype);

	$length=strlen($consultationtype);

	$loccode= explode('-',$locationcode);

	

	$location = $loccode[1];

	//$que="select * from master_location where auto_number='$location'";

//	$exe=mysql_query($que) or die ("Error in Query1".mysql_error());

//	while ($res = mysql_fetch_array($exe))

//	{

//		$locationcode=$res['locationcode'];

//	}

	

	if ($length<=100)

	{

	

		$query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$location','$locationcode','".$default."','$paymenttype','$subtype')"; 



		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		$bgcolorcode = 'failed';

	}



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





?>

<!-- Modern CSS -->
<link href="css/consultationmasterwithdept-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />



<link href="js/jquery-ui.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/consultationmasterwithdept-modern.js?v=<?php echo time(); ?>"></script>

<!-- Payment type and location functions moved to external JS -->

<!-- Additional styles moved to external CSS -->

</head>

<script language="javascript">



// Moved to external JS



// Moved to external JS





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





function addward1process1()

{

	//alert ("Inside Funtion");

	if (document.form1.location.value == "")

	{

		alert ("Pleae Select Location.");

		document.form1.location.focus();

		return false;

	}



	

	if (document.form1.department.value == "")

	{

		alert ("Pleae Select Department.");

		document.form1.department.focus();

		return false;

	}





	if (document.form1.consultationtype.value == "")

	{

		alert ("Pleae Enter Consultation Type Name.");

		document.form1.consultationtype.focus();

		return false;

	}

	

	if (document.form1.consultationfees.value == "")

	{

		alert ("Pleae Enter Consultation Fees.");

		document.form1.consultationfees.focus();

		return false;

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

</script>

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	source:"ajaxaccountsub_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#searchsuppliercode").val(accountid);

			$("#searchsupplieranum").val(accountanum);

			$('#searchsuppliername').val(accountname);

			

			},

    

	});

	

	

	$('#searchdepartmentname').autocomplete({

		

	source:"ajaxdepartment_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#searchdepartmentcode").val(accountid);

			$("#searchdepartmentanum").val(accountanum);

			$('#searchdepartmentname').val(accountname);

			

			},

    

	});

		

});


$(window).scroll(function() {

	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {

		

		   var hiddenplansearch = "";

		   var scrollfunc = $("#scrollfunc").val();

			$("#scrollfunc").val('');

			 var sortfiled = '';

			 var sortfunc = '';

			if(sortfunc=='asc')

			{

				sortfunc='desc'

			}

			else

			{

				sortfunc='asc'

			}

			if(hiddenplansearch=='')

			{

			   if(scrollfunc=='getdata')

			   {

					var serialno = $("#serialno").val();

					
					var search_dept_anum = $("#searchdepartmentanum").val();

					var search_supplr_anum = $("#searchsupplieranum").val();

					var dataString = 'serialno='+serialno+'&&action=scrollplanfunction&&textid='+sortfiled+'&&sortfunc='+sortfunc+'&&searchdepartmentanum='+search_dept_anum+'&&searchsupplieranum='+search_supplr_anum;

					

					$.ajax({

						type: "POST",

						url: "ajax/consultationtypedata.php",

						data: dataString,

						cache: true,

						//delay:100,

						success: function(html){

						//alert(html);

							serialno = parseFloat(serialno)+50;

							$("#insertplan").append(html);

							$("#serialno").val(serialno);

							$("#scrollfunc").val('getdata');

							

						}

					});

			   }

			}

		   

	   }

});

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

              <td><form name="form1" id="form1" method="post" action="addconsultationtype1.php" onSubmit="return addward1process1()">

                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <th colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Type Master - Add New </strong></th>

                        <th width="10%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						

						

						?>

						

						

                  

                  </th>

                      </tr>

					  <tr>

                        <th colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></th>

                      </tr>

                      <tr>

                      	<th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location

                        </div></th>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                        <option value="" selected="selected">Select location</option>';

                        <?php

						

                            $query6 = "select * from master_location where status = '' order by locationname";

							$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

							while ($res6 = mysqli_fetch_array($exec6))

							{

								$res6anum = $res6["auto_number"];

								$res6location = $res6["locationname"];

								$locationcode = $res6["locationcode"];

						?>

                          <option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>

                          <?php

				}

				?>

                

						

						</select></td></tr>

                        <tr>

                        <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department</div></th>

                        <th align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="department" id="department" style="border: 1px solid #001E6A;">

                          

		

					<option value="" selected="selected">Select department</option>';

					

				

				

				<?php

				$query5 = "select * from master_department where recordstatus = '' order by department";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["auto_number"];

				$res5department = $res5["department"];

				?>

                          <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>

                          <?php

				}

				?>

                        </select></th>

                      </tr>

					  

					    

				<tr>

				 <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Main Type</div></th>

				  <th align="left" valign="middle"  bgcolor="#FFFFFF"> 

				  

				  <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();"  style="border: 1px solid #001E6A;">

                  <option value="" selected="selected">Select Type</option>  

				  <?php

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

				  </th>

				  </tr>   

				    <tr>

				 <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Sub Type</div></th>

				  <th align="left" valign="middle"  bgcolor="#FFFFFF">

				  <select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" style="border: 1px solid #001E6A;">

                    				

					<?php

				if ($subtype == '')

				{

					echo '<option value="" selected="selected">Select Subtype</option>';

				}

				else

				{

					$query51 = "select * from master_subtype where recordstatus = ''";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res51 = mysqli_fetch_array($exec51);

					$res51subtype = $res51["subtype"];

					echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';

				}

				

				$query5 = "select * from master_subtype where recordstatus = '' order by subtype";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["auto_number"];

				$res5paymenttype = $res5["subtype"];

				?>

                    <option value="<?php echo $res5paymenttype; ?>"><?php echo $res5paymenttype; ?></option>

                    <?php

				}

				?>			  

                  </select>				  </th>

				  </tr>   

                     <tr>
 
                        <th align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">

                          <div align="right">Add New Consultation Type </div>

                        </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="consultationtype" id="consultationtype" style="border: 1px solid #001E6A;text-transform: uppercase;" size="40" />                                      </td>

                      </tr>

					  

					<tr>

						<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Doctor </div></td>

						<td align="left" valign="top"  bgcolor="#FFFFFF">

							<input type="text" name="consultationdoctorname" id="consultationdoctorname" style="border: 1px solid #001E6A;" size="40" autocomplete="off" >

							<input type="hidden" name="consultationdoctorcode" id="consultationdoctorcode" style="border: 1px solid #001E6A;" size="10">

						</td>

					</tr>

					

                      <tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Fees </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

                          <input name="consultationfees" type="text" id="consultationfees" style="border: 1px solid #001E6A;" size="10">                     </td>

                      </tr>

					  

                      <tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Default </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

                          <input name="default" type="checkbox" id="default" >  </td>

                      </tr>

                      <tr>

                        <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="54%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                            <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">

                            <input type="hidden" name="serialno" id="serialno" value="50">

                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

				  </form>

				  <form name="form12" id="form12" method="post" action="addconsultationtype1.php" >

                <table width="1150" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                           <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Subtype</td>

              <td width="40%" colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off"  onKeyUP="clearsubtypecode()">

				<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" size="20" />

				<input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="20" />

              </span></td>

			  

			     <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Department</td>

              <td width="40%" colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchdepartmentname" type="text" id="searchdepartmentname" value="<?php echo $searchdepartmentname; ?>" onKeyUP="cleardepartmentcode()" size="50" autocomplete="off">

				<input type="hidden" name="searchdepartmentcode" id="searchdepartmentcode" value="<?php echo $searchdepartmentcode; ?>" size="20" />

				<input type="hidden" name="searchdepartmentanum" id="searchdepartmentanum" value="<?php echo $searchdepartmentanum; ?>" size="20" />

              </span></td>

			   <td width="54%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag2" value="search" />

                            <input type="hidden" name="frmflag12" value="frmflag12" />

                          <input type="submit" name="search" value="search" style="border: 1px solid #001E6A" /></td>

              </tr>

                      <tr bgcolor="#011E6A">

                      <th colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Type Master</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Department</strong>             </th>           

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Main <strong>Type</strong></strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong>         </th>               

                        <th bgcolor="#ecf0f5" class="bodytext3"> <strong>Dcotor Type</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Code</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Fees</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Edit</strong></th>

                        </tr>
                        <tbody id='insertplan'>

        <?php

		if($searchsupplieranum=='' && $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%' order by paymenttype limit 50";

		}

		else{

			

		if( $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype = '$searchsupplieranum' order by paymenttype limit 50";

		}	

		

		else{

			

			if($searchsupplieranum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype Like '%$searchsupplieranum%' order by paymenttype limit 50";

		}

		else{

			 $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype = '$searchsupplieranum' order by paymenttype limit 50";

		}

		

		}

		

		}

	

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$auto_number = $res1["auto_number"];  

		$consultationtype = $res1["consultationtype"];

		$departmentanum = $res1["department"];

		$consultationfees = $res1["consultationfees"];

		$res1paymenttype = $res1["paymenttype"];

		$res1subtype = $res1['subtype'];

		$res1location = $res1['locationname']; 

		$res1doctorcode = $res1['doctorcode'];

		$res1doctor = $res1['doctorname'];

		

		$query = "select * from master_location where auto_number='$res1location'";

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_array($exec);

		$loc=$res['locationname'];

		

		$query2 = "select * from master_department where auto_number = '$departmentanum'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$department = $res2['department'];

		

		$query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res3 = mysqli_fetch_array($exec3);

		$res3paymenttype = $res3['paymenttype'];

		

		$query4 = "select * from master_subtype where auto_number = '$res1subtype'";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res4 = mysqli_fetch_array($exec4);

		$res4subtype = $res4['subtype'];

	

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		  

		?>

                      

                      <tr <?php echo $colorcode; ?>>

                        <td width="15" align="left" valign="top"  class="bodytext3"><div align="center">

					<a href="addconsultationtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteconsultationtype1('<?php echo $consultationtype;?>')">

					<img src="images/b_drop.png" width="8" height="11" border="0" /></a></div></td>

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $loc; ?></td>          

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>

          <td width="110" align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>

          <td width="80" align="left" valign="top"  class="bodytext3"><?php echo $res3paymenttype; ?></td>

		  <td width="180" align="left" valign="top"  class="bodytext3"><?php echo $res4subtype; ?></td>

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $res1doctor; ?></td>

		  <td width="70" align="left" valign="top"  class="bodytext3"><?php echo $res1doctorcode; ?></td>

		  <td width="50" align="left" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td>

          <td width="30" align="left" valign="top"  class="bodytext3">

		  <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>		  </td> 

                        </tr>

                      <?php

		}

		?>
</tbody>
                      <tr>

                        <td align="middle" colspan="5" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <?php

		

	    $query1 = "select * from master_consultationtype where recordstatus = 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%'  order by consultationtype ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$auto_number = $res1["auto_number"];

		$consultationtype = $res1["consultationtype"];

		$departmentanum = $res1["department"];

		$consultationfees = $res1["consultationfees"];

		

		$query2 = "select * from master_department where auto_number = '$departmentanum'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$department = $res2['department'];

		

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		?>

                      <tr <?php echo $colorcode; ?>>

                        <td colspan="4" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Consultation Type Master - Deleted </strong></td>

                        </tr>

                      <tr <?php echo $colorcode; ?>>

          <td width="11%" align="left" valign="top"  class="bodytext3">

						<a href="addconsultationtype1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">

                          <div align="center" class="bodytext3">Activate</div>

                        </a></td>

                        <td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>

						<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>

                        <td width="24%" align="left" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td> 

                        </tr>

                      <?php

		}

		?>

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