<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
//include ("includes/check_user_access.php");
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

	

	//$location = $loccode[1];
	$location = $locationcode;

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
		
	
		
		
		/*for($i=1; $i<$depart_count; $i++)
		{
		$deptget=isset($_REQUEST['dept'.$i])?$_REQUEST['dept'.$i]:'';
		$cons_name=isset($_REQUEST['consname'.$i])?$_REQUEST['consname'.$i]:'';
		
			
		$query1 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$loccodeget=$res1['locationcode'];
		$locrateget=isset($_REQUEST['locrate'.$i.$loccodeget])?$_REQUEST['locrate'.$i.$loccodeget]:'';
		 $locrateget=trim($locrateget);
		 if($deptget!='' && $locrateget!='')
		 {
				
		 $query1s2 = "select auto_number from master_consultationtype where  department='$deptget' and paymenttype='$paymenttype' and subtype='$subtype'";
		$exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1s2 = mysqli_num_rows($exec1s2);
		
		if($num1s2<=0)
		{	
		 $query190 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$location','$locationcode','".$default."','$paymenttype','$subtype')"; 

		$exec190 = mysqli_query($GLOBALS["___mysqli_ston"], $query190) or die ("Error in Query190".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		$query1s = "select auto_number from master_consultationtype where  department='$deptget' and doctorcode='$doctorcode' and consultationtype='$cons_name' order by auto_number desc limit 1";
		$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1s = mysqli_fetch_array($exec1s);
		$consultation_id=$res1s['auto_number'];
		
		
		
	$query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$loccodeget', '$locrateget','$default')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		 }
		}
	  
		
		$errmsg = "Success. New Consultation Type Updated.";

		$bgcolorcode = 'success';

		

	
		}*/
		
		
		
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Consultation Type - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/addconsultationtype1-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


<link href="js/jquery-ui.css" rel="stylesheet">

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

    <!-- External JavaScript -->
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
</head>

<script>

function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">



function cleardepartmentcode(){

	

	

	document.getElementById("searchdepartmentanum").value ='';

	//alert();

}



function clearsubtypecode(){

	

	

	document.getElementById("searchsupplieranum").value ='';

	

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





function addward1process1()

{

	//alert ("Inside Funtion");
/* 
	if (document.form1.location.value == "")

	{

		alert ("Pleae Select Location 123.");

		document.form1.location.focus();

		return false;

	}

 */

	

	if (document.form1.paymenttype.value == "")

	{

		alert ("Pleae Select Main Type.");

		document.form1.paymenttype.focus();

		return false;

	}
	if (document.form1.subtype.value == "")

	{

		alert ("Pleae Select Sub Type.");

		document.form1.subtype.focus();

		return false;

	}





/*	if (document.form1.consultationtype.value == "")

	{

		alert ("Pleae Enter Consultation Type Name.");

		document.form1.consultationtype.focus();

		return false;

	}*/
/* if (document.form1.consultationdoctorcode.value == "")

	{

		alert ("Pleae Select Consultation Doctor.");

		document.form1.consultationdoctorname.focus();

		return false;

	} */

	

	/* if (document.form1.consultationfees.value == "")

	{

		alert ("Pleae Enter Consultation Fees.");

		document.form1.consultationfees.focus();

		return false;

	}	 */	
	
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

			   /*if(scrollfunc=='getdata')

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

			   } */

			}

		   

	   }

});

</script>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Add Consultation Type</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Consultations</span>
        <span>→</span>
        <span>Add Consultation Type</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">

<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>


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

                  <table width="1200" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <th colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Type Master - Add New </strong></th>

                        <th width="6%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong>From Location </strong>

             

            

                  <?php

						

						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];
						
						$res1llocationcode = $res1["locationcode"];

						?>


                  </th>
                  
<th width="10%" align="right" bgcolor="#ecf0f5" class="bodytext3">To Location <br/>
<select name="location_main" id="location_main"  style="border: 1px solid #001E6A;">
<?php
$query6 = "select * from master_location where status = '' and locationcode!='$res1llocationcode' order by auto_number asc";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res6 = mysqli_fetch_array($exec6))
{
$res6anum = $res6["auto_number"];
$res6location = $res6["locationname"];
$locationcode = $res6["locationcode"];

$query1s2 = "select auto_number from master_consultationtype where  locationcode='$locationcode'";
$exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1s2 = mysqli_num_rows($exec1s2);
if($num1s2<=0)
{
?>
<option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>
<?php
}
}
?>
</select></th>

<th width="10" align="left" bgcolor="#ecf0f5" class="bodytext3"><input type="button" id="update_it" name="update_it" value="Update" onClick="update_value('<?php echo $res1llocationcode;?>')"/></th>

                      </tr>

					  <tr>

                        <th colspan="2" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></th>
                        
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

                      	<th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location

                        </div></th>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">

                        <?php

						

                            $query6 = "select * from master_location where status = '' order by auto_number asc";

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

				    <tr>

				 <th align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Sub Type</div></th>

				  <th align="left" valign="middle"  bgcolor="#FFFFFF">
                  
                    <input type="hidden" name="subtype" id="subtype" value="" />
                    <input type="text" name="search_subtype" id="search_subtype" value="" style="border: 1px solid #001E6A;" size="40" />
                   </th>
                  
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

                        <th align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">

                          <div align="right">Add New Consultation Type </div>

                        </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="consultationtype" id="consultationtype" style="border: 1px solid #001E6A;text-transform: uppercase;" size="40" />                                      </td>
                        
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

					  

					<tr>

						<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Doctor </div></td>

						<td align="left" valign="top"  bgcolor="#FFFFFF">

							<input type="text" name="consultationdoctorname" id="consultationdoctorname" style="border: 1px solid #001E6A;" size="40" autocomplete="off" >

							<input type="hidden" name="consultationdoctorcode" id="consultationdoctorcode" style="border: 1px solid #001E6A;" size="10">

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

					
<span >
                      <tr style="display:none">

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Fees </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

                          <input name="consultationfees" type="text" id="consultationfees" style="border: 1px solid #001E6A;" size="10">                     </td>
                          
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
	 
 <?php $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by auto_number asc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$incr=0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						 $incr=$incr+1;  ?>
						
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
						$cons_type=$department_name.' Consultation';
						?>
						<tr>
						 
						<td width="40%" class="bodytext3" height="25">
						<input type="checkbox"  name="dept<?php echo $dcr;?>" id="dept<?php echo $dcr;?>" style="float:left" value="<?php echo $department_code;?>"/>
                        
                        <b> &nbsp;&nbsp;<?php echo $department_name;?></b>
  <input type="text"  name="consname<?php echo $dcr;?>" id="consname<?php echo $dcr;?>" style="float:right"  style="width:120px;" placeholder="Consultation Type" value="<?php echo $cons_type; ?>"></td>
						<?php 
						$query1 = "select locationcode from master_location where status <> 'deleted' order by auto_number asc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						while ($res1 = mysqli_fetch_array($exec1))
						{
							$locationcode = $res1["locationcode"];
						?>
						<td  class="bodytext3" height="25" align="center" width="20%">
						 <input  type="text" name="locrate<?php echo $dcr;?><?php echo $locationcode;?>"  id="locrate<?php echo $dcr;?><?php echo $locationcode;?>" style="width:90px;" placeholder="Main" onKeyPress="return validatenumerics(event);">
                          <input  type="text" name="locreview<?php echo $dcr;?><?php echo $locationcode;?>"  id="locreview<?php echo $dcr;?><?php echo $locationcode;?>" style="width:90px;" placeholder="Review" onKeyPress="return validatenumerics(event);">
	 
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

                          <input name="default" type="checkbox" id="default" >  </td>

                      </tr>

                      <tr>

                        <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td width="54%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                            <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">

                            <input type="hidden" name="serialno" id="serialno" value="50">
                            
                             <input type="hidden" name="department" id="department" value="">
                            
                   
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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" width="10%">Subtype</td>

              <td width="40%" colspan="2" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off"  onKeyUP="clearsubtypecode()">

				<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" size="20" />

				<input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="20" />

              </span></td>

			  

			     <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" style="display:none">Department</td>

              <td width="40%" colspan="4" align="left" valign="top"  bgcolor="#FFFFFF" style="display:none"><span class="bodytext3">

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

                     <!-- <th colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3" width="40%"><strong>Consultation Type Master</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3" width="40%"><strong>Department</strong>             </th>-->           

                        <th bgcolor="#ecf0f5" class="bodytext3" width="140%"><strong>Main <strong>Type</strong></strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3" width="100%"><strong>Sub Type</strong>         </th>               

                        <!--<th bgcolor="#ecf0f5" class="bodytext3"> <strong>Dcotor Type</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Code</strong></th>

                        <th bgcolor="#ecf0f5" class="bodytext3" width="40%"><strong>Consultation Fees</strong></th>-->

                        <th bgcolor="#ecf0f5" class="bodytext3" width="100%"><strong>Edit</strong></th>
                        
                         <th bgcolor="#ecf0f5" class="bodytext3" width="100%"><strong>Copy</strong></th>

                        </tr>
                        <tbody id='insertplan'>

        <?php

		if($searchsupplieranum=='' && $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%' group by subtype order by auto_number limit 50";

		}

		else{

			

		if( $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype = '$searchsupplieranum' group by subtype order by auto_number limit 50";

		}	

		

		else{

			

			if($searchsupplieranum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype Like '%$searchsupplieranum%' group by subtype order by auto_number  limit 50";

		}

		else{

			 $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype = '$searchsupplieranum' group by subtype order by auto_number  limit 50";

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

                       <!-- <td width="15" align="left" valign="top"  class="bodytext3"><div align="center">

					<a href="addconsultationtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteconsultationtype1('<?php echo $consultationtype;?>')">

					<img src="images/b_drop.png" width="8" height="11" border="0" /></a></div></td>

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $loc; ?></td>   

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>    

          <td width="110" align="center" valign="top"  class="bodytext3"><?php echo $department; ?></td>-->   

          <td width="80" align="center" valign="top"  class="bodytext3"><?php echo $res3paymenttype; ?></td>

		  <td width="180" align="center" valign="top"  class="bodytext3" width="100%"><?php echo $res4subtype; ?></td>

       <!--   <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $res1doctor; ?></td>

		  <td width="70" align="left" valign="top"  class="bodytext3"><?php echo $res1doctorcode; ?></td>

		  <td width="50" align="right" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td>-->

          <td width="30" align="center" valign="top"  class="bodytext3">

		  <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>&&subtype_edit=<?php echo $res1subtype; ?>&&maintype_edit=<?php echo $res1paymenttype; ?>" style="text-decoration:none">Edit</a>		  </td> 
          
           <td width="30" align="center" valign="top"  class="bodytext3">

		  <a href="cloneconsultation.php?st=edit&&anum=<?php echo $auto_number; ?>&&subtype_edit=<?php echo $res1subtype; ?>&&maintype_edit=<?php echo $res1paymenttype; ?>" style="text-decoration:none">Copy</a>		  </td>

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

    </div>

    <!-- Modern JavaScript -->
    <script src="js/addconsultationtype1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

<script type="text/javascript">
function validatenumerics(key) 
{
	   //getting key code of pressed key
	   var keycode = (key.which) ? key.which : key.keyCode;
	   //comparing pressed keycodes

	   if (keycode > 31 && (keycode < 48 || keycode > 57)) {
		   //alert(" You can enter only characters 0 to 9 ");
		   return false;
	   }
	   else return true;
 
}


function uncheckit(locid,id)
{
var get_val='';	
var get_val=$("#locrate"+locid+id).val();

if(document.getElementById("dept"+locid+id).checked == true)
{
	if(get_val>0 && locid==1)
	{
	$(".clearrate"+id).val(get_val);	
	}
 $(".cleardept"+id).prop('checked', true);
}
else
{
$(".clearrate"+id).val('');
$(".cleardept"+id).prop('checked', false);
}
}


function funcPaymentTypeChange1()
{
$("#subtype").val('');
$("#search_subtype").val('');
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

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}


function update_value(mainlocation)
{
var now_loc=$("#location_main").val();

 var fRet;

	fRet = confirm('Are you sure want to Update ?');

	if (fRet == false)
	{
		alert ("Update Not Completed.");

		return false;

	}
	
if (fRet == true)
{
FuncPopup();
$.ajax({
type: "POST",
url: 'cloneconsultation_insertion.php?main_location='+mainlocation+'&&update_location='+now_loc,
cache: true,
success: function(html){
	document.getElementById("imgloader").style.display = "none";
	location.reload();
}

});
}
}

</script>
