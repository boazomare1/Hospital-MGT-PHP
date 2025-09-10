<?php
session_start();
include ("includes/loginverify.php"); 
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno=$_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
$locationcode=$location;
}


$query1 = "select employeecode from master_employee where  status = 'Active' AND username like '%$username%'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1employeename  = $res1["employeecode"];

if (isset($_REQUEST["ward"])) { $ward12 = $_REQUEST["ward"]; } else { $ward12 = ""; }
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
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

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
<script type="text/javascript">

function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_location";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	 $res12subtypeanum = $res12["auto_number"];
	$res12locationname = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>

	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{

		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 	
		<?php 
		$loopcount=0; 
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
		<?php
		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$ward = $res10["ward"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}
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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

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
    <td class="bodytext31">&nbsp;</td>
    <td class="bodytext31">&nbsp;</td>
   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="ippackageprocesslist.php">
		<table width="910" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
			<tr>
			<td colspan="4" align="center" style="font-size:25px; color:red;"><strong>Patient Will Clear the List Only After Invoice Finalization</strong></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Inpatient Package Processing Request</strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td>

              </tr>
          <tr>
		   <td width="15%" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Location </strong></span></td>
          <td  width="15%" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);">
           <?php
		   			$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
?>
		   <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
  <?php         }?>
		   </select></span>
		   
		   </td>
		   <td width="6%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="ward" id="ward" >
                         <option value=''>ALL</Option>
							 	  
					 <?php
						 
		  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
           $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res = mysqli_fetch_array($exec);
			
	 		$locationname  = $res["locationname"]; 
	 		$locationcode2 = $res["locationcode"];
			
						  $query78 = "select B.auto_number,B.ward,A.wardcode from nurse_ward as A join master_ward as B on (B.auto_number=A.wardcode) where  A.locationcode='$locationcode2' and B.recordstatus=''  and A.employeecode='$res1employeename'  order by A.defaultward desc";
						  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  while($res78 = mysqli_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						    ?>
                          <option value="<?php echo $wardanum; ?>"<?php if($wardanum == $ward12) { echo "selected"; }?>><?php echo $wardname; ?></option>
						  <?php
						  }
			
                          ?>
                      </select>
              </span></td>
		   </tr>
		   
		   <tr>
		   
		   
		     <td colspan='4' align="center" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
            <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">

				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
               &nbsp; <input  type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>

				</td>
          </tr>
            <tr>
            	<td width="%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="2">&nbsp;</td>
            
              
              <td width="%" align="left" valign="top"  bgcolor="#FFFFFF"></td>
              <td width="%" align="left" valign="top"  bgcolor="#FFFFFF"></td>
            </tr>
             </tbody>
        </table>
		  <iframe marginheight="1" marginwidth="50" src="inpatientlabtestscrolling.php" frameborder="0" scrolling="no" width="450" height="70"></iframe>
		</form>		</td>
      </tr>
<tr><td>&nbsp;</td></tr>
	  <form name="form1" id="form1" method="post" action="ipdischargelist.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	 
	 $locationcode = $_REQUEST['location'];
	
	
		   
		  					
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="80%" align="left" border="0">
          <tbody>
             
		<tr>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Interim</strong></div></td>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>DOA</strong></div></td>
		<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
		<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Package Name</strong></div></td>
		<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sub Type</strong></div></td>
		<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
		<td colspan="2" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
		</tr>

			<?php 
			$searchward=((isset($_POST['ward']))?$_POST['ward']:"");
			
			if($searchward=='')
			{
			$pass_ward = "auto_number !=''";
			}
			else
			{
			$pass_ward = "auto_number ='$searchward'";
			}
			 
			$query781 = "select * from master_ward where $pass_ward  and locationcode='$locationcode' and recordstatus=''";
			$exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res781 = mysqli_fetch_array($exec781);
			$wardname = $res781['ward'];
			
			
			$query821 = "select mipv.visitcode from master_ipvisitentry mipv inner join package_items pi on mipv.package = pi.package_id where mipv.locationcode='$locationcode' and mipv.paymentstatus!='completed' and mipv.bedallocation='completed' group by mipv.visitcode";
			
			$query591 = "select ward from ip_bedallocation where locationcode='$locationcode'  and recordstatus NOT IN ('discharged','transfered') and visitcode in ($query821)
			UNION ALL
			select ward from ip_bedtransfer where locationcode='$locationcode'  and recordstatus NOT IN ('discharged','transfered')  and visitcode in ($query821) ";
			
			
             $query34 = "select * from master_ward where $pass_ward and auto_number in ($query591)  and locationcode='$locationcode'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numward=mysqli_num_rows($exec34);
			if($numward>0){
			while($res34 = mysqli_fetch_array($exec34))
			{
			 $wardnum = $res34['auto_number'];
			 $wardname5 = $res34['ward'];
			?>
			<tr>
			  <td colspan="12" align="left" valign="center" 
                 class="bodytext31" ><div align="left"><strong><?php echo $wardname5; ?></strong></div></td>
			 </tr>
			
			<?php
			
			$query50 = "select * from master_bed where ward='$wardnum' and locationcode='$locationcode'"; 
			$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res50 = mysqli_fetch_array($exec50))
			{
			$bedname = $res50['bed'];
			$bedanum = $res50['auto_number'];
			$bed = '';
			$ward = '';
			$patientcode = '';
			$visitcode = ''; 
			
			$query59 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and locationcode='$locationcode'  and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 0, 1";
			$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res59 = mysqli_fetch_array($exec59);
			$num59 = mysqli_num_rows($exec59);
			if($num59 > 0)
			{
			$visitcode = $res59['visitcode'];
		 	$query82 = "select mipv.* from master_ipvisitentry mipv inner join package_items pi on mipv.package = pi.package_id where mipv.locationcode='$locationcode' and mipv.paymentstatus!='completed' and mipv.bedallocation='completed' and mipv.visitcode='$visitcode' group by mipv.visitcode";
			$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num82 = mysqli_num_rows($exec82);
			while($res82 = mysqli_fetch_array($exec82))
			{

				$patientname = $res82['patientfullname'];
				$patientcode = $res82['patientcode'];
				$visitcode = $res82['visitcode'];
				$date = $res82['consultationdate'];
				$accountid = $res82['accountname'];

				$query = mysqli_query($GLOBALS["___mysqli_ston"], "select main.accountname accountname, sub.accountssub accountssub from master_accountname main inner join master_accountssub sub on main.accountssub=sub.auto_number  where main.auto_number = '$accountid'");
				$res = mysqli_fetch_array($query);
				$accoutname = $res['accountname'];
				$accsub =      $res['accountssub'];
				
				$package = $res82['package'];

				$query401 = "select packagename from master_ippackage where   auto_number = '$package'";
				$exec401 = mysqli_query($GLOBALS["___mysqli_ston"], $query401) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res401 = mysqli_fetch_array($exec401);
				$packagename = $res401['packagename'];

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

			?>
			
			<tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="center"><a href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid="" " style="font-weight: bold;">Interim</a></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagename; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accsub; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accoutname; ?></div></td>
			<td class="bodytext31" valign="center"  align="center"><a href="ippackageprocessing.php?packageid=<?php echo $package; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>&&patientlocation=<?php echo $location;?>&&menuid=<?php echo $menu_id; ?>" style="font-weight: bold;">Process Package</a></td>
			<td class="bodytext31" valign="center"  align="center"><a href="addpkgitems.php?packageid=<?php echo $package; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>&&patientlocation=<?php echo $location;?>&&menuid=<?php echo $menu_id; ?>" style="font-weight: bold;">Add To Pkg</a></td>
			</tr>
            <?php  }  } else{ 
			
			$query592 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum'  and locationcode='$locationcode'  and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 0, 1";
			$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res592 = mysqli_fetch_array($exec592);
			$num592 = mysqli_num_rows($exec592);
			if($num592 > 0)
			{
			$visitcode = $res592['visitcode'];
		 	$query82 = "select mipv.* from master_ipvisitentry mipv inner join package_items pi on mipv.package = pi.package_id where mipv.locationcode='$locationcode' and mipv.paymentstatus!='completed' and mipv.bedallocation='completed' and mipv.visitcode='$visitcode' group by mipv.visitcode";
			$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num82 = mysqli_num_rows($exec82);
			while($res82 = mysqli_fetch_array($exec82))
			{

				$patientname = $res82['patientfullname'];
				$patientcode = $res82['patientcode'];
				$visitcode = $res82['visitcode'];
				$date = $res82['consultationdate'];
				$accountid = $res82['accountname'];

				$query = mysqli_query($GLOBALS["___mysqli_ston"], "select main.accountname accountname, sub.accountssub accountssub from master_accountname main inner join master_accountssub sub on main.accountssub=sub.auto_number  where main.auto_number = '$accountid'");
				$res = mysqli_fetch_array($query);
				$accoutname = $res['accountname'];
				$accsub =      $res['accountssub'];
				
				$package = $res82['package'];

				$query401 = "select packagename from master_ippackage where   auto_number = '$package'";
				$exec401 = mysqli_query($GLOBALS["___mysqli_ston"], $query401) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res401 = mysqli_fetch_array($exec401);
				$packagename = $res401['packagename'];

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

			?>
			
			<tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="center"><a href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid="" " style="font-weight: bold;">Interim</a></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagename; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accsub; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accoutname; ?></div></td>
			<td class="bodytext31" valign="center"  align="center"><a href="ippackageprocessing.php?packageid=<?php echo $package; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>&&patientlocation=<?php echo $location;?>&&menuid=<?php echo $menu_id; ?>" style="font-weight: bold;">Process Package</a></td>
			<td class="bodytext31" valign="center"  align="center"><a href="addpkgitems.php?packageid=<?php echo $package; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode;?>&&patientlocation=<?php echo $location;?>&&menuid=<?php echo $menu_id; ?>" style="font-weight: bold;">Add To Pkg</a></td>
			</tr>
			
			
			
			
			<?php } } } } } }?>
		   
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  
			</tr>
          </tbody>
        </table>
<?php
}


?>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

