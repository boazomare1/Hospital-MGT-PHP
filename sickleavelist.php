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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$sno = '';
$searchsuppliername = "";



if(isset($_POST['searchsuppliername'])){  $searchsuppliername = $_POST['searchsuppliername'];}else{$searchsuppliername="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
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
<script type="text/javascript" src="js/autocomplete_sick.js"></script>
<script type="text/javascript" src="js/autosuggestsick.js"></script>


<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script>
function funcPopupOnLoader()
 {
 <?php
   if(isset($_REQUEST['patientcodes'])) {$patientcodes=$_REQUEST['patientcodes']; } else{$patientcodes="";}
 ?>
		var patientcodes;
		var patientcodes = "<?php echo $patientcodes; ?>";
		//alert(visitcodes);
		if(patientcodes != "") 
		{
			window.open("print_sickleave.php?patientcode="+patientcodes,"OriginalWindowA5",'width=700,height=700,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
        }
    
 }				
</script>

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




</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<body onLoad="funcPopupOnLoader()">

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
              <form name="cbform1" method="post" action="sickleavelist.php">
                <table width="659" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
              <td width="15%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
					  </span></td>
             		 </tr>
					
			 			
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit"/>
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
		        
      <tr>
        <td><table width="92%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Leave  List </strong></div></td>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31" align="right"><label><strong> <a href="consultationlist1.php"></a></strong></label></td>
            </tr>
            <tr>
              <td width="56"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="72" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
              <td width="181" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Patient Name </td>
              <td width="89" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
              <td width="158" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type </strong></div></td>
              <td width="60"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Type </strong></td>
              <td width="207"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Account </td>
              <td width="59"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Age</td>
              <td width="91"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Gender</td>
              <td width="133"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">National ID </td>
              <td width="92"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Action</td>
            </tr>
            <?php
			
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			 if($searchsuppliername != '' || $searchpatientcode != '' || $searchvisitcode != '')
			   {
		$query1 = "select * from master_customer where customerfullname like '%$searchsuppliername%' and customercode like '%$searchpatientcode%'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1patientcode = $res1['customercode'];
			$res1customerfullname = $res1['customerfullname'];
			$res1paymenttype = $res1['paymenttype'];
    		$res1user = $res1['username'];
			$res1age = $res1['age'];
			$res1gender = $res1['gender'];
			$res1accountname = $res1['accountname'];
		    $res1consultingdoctor = $res1['consultingdoctor'];
		    $res1nationalidnumber = $res1['nationalidnumber'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  $subtypeanum = $res3['auto_number'];
			  
			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];

	          $query5 = "select * from master_accountname where auto_number = '$res1accountname'";
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			  
			  $query201 = "select * from master_doctor where doctorcode = '$res1consultingdoctor'";
			  $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res201 = mysqli_fetch_array($exec201);
			  $res201consultingdoctor = $res201['doctorname'];
		
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
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno=$sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res1patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1customerfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $res3paymenttype;?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res4subtype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res3paymenttype; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res5accountname ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1nationalidnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="sickleave.php?patientcode=<?php echo $res1patientcode; ?>"><strong>Process</strong></a></td>
            </tr>
            <?php
			}
		}
			?>
            <tr>
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	  <td>	   </tr>
	</table>
	  <div align="right"></div>
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

