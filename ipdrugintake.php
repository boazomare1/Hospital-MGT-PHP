<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


//This include updatation takes too long to load for hunge items database.


//$getcanum = $_GET['canum'];




if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];




//include ("autocompletebuild_ipcustomerdischarge.php");
include ("autocompletebuild_ipdrugintake.php");
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
<?php //include ("js/dropdownlistipbilling.php");
include ("js/dropdownlistipdrugintake.php"); ?>
<script type="text/javascript" src="js/autosuggestipdrugintake.js"></script> 
<script type="text/javascript" src="js/autocomplete_ipdrugintake.js"></script>
<!--<script type="text/javascript" src="js/autosuggestipdischargelist.js"></script> 
<script type="text/javascript" src="js/autocomplete_customeripdischarge.js"></script>
--><script language="javascript">



function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}



</script>
<script type="text/javascript">


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

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="ipdrugintake.php">
		<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Drug Intake List </strong></td>
              </tr>
          
           <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Search </strong></td>
				  <td  align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				   <input name="customervisitcode" id="customervisitcode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  </td>
				
             
              <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  <form name="form11" id="form11" method="post" action="dischargediplist.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['customer'];
	
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
             
           
           <?php
		   if($searchpatient != '')
		  {
		
           
		   $patientname = $_POST['customer'];
		   $patientcode = $_POST['customercode'];
		   $visitcode = $_POST['customervisitcode'];
		   ?>
		   <tr>		
			  <td class="bodytext31" valign="center"  align="left" colspan="2">
			    <div align="left"><strong><?php echo $patientname; ?></strong></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo $patientcode; ?></strong></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo $visitcode; ?></div></strong></td>
			</tr>
			<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Drug</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Time</strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Status</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reason</strong></div></td>
				 <td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>User</strong></div></td>
			 
			
              </tr>
	 <?php
	 	   $query35 = "select * from ip_drugadmin where patientname = '$patientname' and patientcode = '$patientcode' and visitcode='$visitcode' and drugstatus <> 'complete'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res35 = mysqli_fetch_array($exec35))
			{  
		   $date = $res35['recorddate'];
		   $time = $res35['recordtime'];
		   $status = $res35['drugstatus'];
		   $reason = $res35['remarks'];
		   $user = $res35['username'];
		   $drugname =$res35['itemname'];
		 
		  
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
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $drugname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $time; ?></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $status; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $reason; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $user; ?></div></td>
				  
				
			
			
              </tr>
		  <?php
		  }
		  
		 }
		 else
		 {
		 	 $query34 = "select * from ip_drugadmin where drugstatus <> 'complete' group by visitcode,patientname,patientcode";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   ?>
		    <tr>		
			  <td class="bodytext31" valign="center"  align="left" colspan="2">
			    <div align="left"><strong><?php echo $patientname; ?></strong></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo $patientcode; ?></strong></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo $visitcode; ?></div></strong></td>
			</tr>
			<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Drug</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Time</strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Status</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reason</strong></div></td>
				 <td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>User</strong></div></td>
			 
			
              </tr>
	 <?php
	 	   $query35 = "select * from ip_drugadmin where patientname = '$patientname' and patientcode = '$patientcode' and visitcode='$visitcode' and drugstatus <> 'complete'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res35 = mysqli_fetch_array($exec35))
			{  
		   $date = $res35['recorddate'];
		   $time = $res35['recordtime'];
		   $status = $res35['drugstatus'];
		   $reason = $res35['remarks'];
		   $user = $res35['username'];
		   $drugname =$res35['itemname'];
		 
		  
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
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $drugname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $time; ?></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $status; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $reason; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $user; ?></div></td>
				  
				
			
			
              </tr>
		  <?php
		  }
		  }
		 
		 }
           ?>
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
				  
			
			</tr>
			
          </tbody>
        </table>
<?php
}
?>	
		</td>
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