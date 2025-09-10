<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  
include ("autocompletebuild_users.php");
 
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchbillnumber"])) { $searchbillnumber = $_REQUEST["searchbillnumber"]; } else { $searchbillnumber = ""; }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Transaction Edit - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/claimtxnidedit-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <!-- External JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="js/autocomplete_users.js"></script>
    <script type="text/javascript" src="js/autosuggestusers.js"></script>
</head>
		});
		return false;
	})	
	
})
function valid()
{
	if(document.getElementById('searchbillnumber').value =='')
	{
		alert("Please Enter Bill No.");
		return false;
	}
	
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Claim Transaction Edit</p>
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
        <span>Claims Management</span>
        <span>→</span>
        <span>Transaction Edit</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
<table width="1901" border="0" cellspacing="0" cellpadding="2">
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
        <td width="1134">
		
		
              <form name="cbform1" method="post" action="claimtxnidedit.php" onSubmit="return valid();">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Transaction No. Edit </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Bill No </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input type="hidden" name="cbcustomername" id="cbcustomername" value="" size="50" autocomplete="off">
				<input  name="searchbillnumber" type="text" value="<?php echo $searchbillnumber; ?>" id="searchbillnumber"  size="50" autocomplete="off">
               </td>
              </tr>
			<tr>
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];					
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="45%" align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
               </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#9999FF">
				<td colspan="10"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong></strong></td>
            </tr>
				
				
			<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
			<td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Bill Date </strong></td>
			<td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>
			<td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> Patient Name </strong></td>
			<td width="" align="right" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td><!-- Card -->
			<td  width=""  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
			<td  width=""  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>PreAuthCode</strong></td>
			<td  width=""  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
			<td  width=""  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"></td>
			<td bgcolor="#ffffff" >&nbsp;</td>
			</tr>
			<?php 
			$colorloopcount ='';
			$sno  ='';
			$query40 = "select * from billing_paylater where billno like '%$searchbillnumber%' AND locationcode='$location'   ";
			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res40 = mysqli_fetch_array($exec40))
			{
			$res40billnumber = $res40['billno'];
			$res40auto_number = $res40['auto_number'];
			$res40transactiondate = $res40['billdate'];
			$res40patientname = $res40['patientname'];
			$res40patientcode = $res40['patientcode'];
			$res40visitcode = $res40['visitcode'];
			$res40preauthcode = $res40['preauthcode'];
			
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
			$sno = $sno + 1;
			?>
			<tr <?php echo $colorcode; ?> id="<?php echo $sno; ?>">
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
			<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $res40transactiondate; ?></div></td>
			<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $res40billnumber; ?></div></td>
			<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $res40patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $res40patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $res40visitcode; ?></div></td>
			<td class="bodytext31 expirydatetdstatic" valign="center"  align="center"><div class="mptxnno" id="caredittxno_<?php echo $sno;?>"><?php echo $res40preauthcode; ?></div></td>
			<td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext31">
			<div bgcolor="#ffffff"><input class="mptxnno1" id="mptxnno_<?php  echo $sno;?>" name="mptxnno[]" style="border: 1px solid #001E6A" value=""  size="10"   onKeyDown="return disableEnterKey()" /> </div>
			</td>
			<td align="left" valign="center"  class="bodytext31 expirydatetdstatic"><div class="bodytext31">
			<div align="center" ><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit</a> </div>   </div></td>
			<td align="left" valign="center"   class="bodytext31"><div class="bodytext31"> <div align="center">
			<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>
			</div>  </div></td>
			<td></td>
			<input type="hidden" name="autono[]" id="autono_<?php echo $sno;?>" value="<?php echo $res40auto_number ?>" />
			<input type="hidden" name="billno[]" id="billno_<?php echo $sno;?>" value="<?php echo $res40billnumber ?>" />
			<input type="hidden" name="tablename[]" id="tablename_<?php echo $sno;?>" value="<?php echo 'billing_paylater' ?>" /
			</tr>
			<?php
			 }
			 }
			 
			
			?>
            
			
			  <tr>
			    <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>
			    </tr>
			  
			  <tr>
	    <td colspan="3" class="bodytext31" valign="center"  align="right"></td>
		<td class="bodytext31" valign="center"  align="right"></td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td colspan="4" class="bodytext31" valign="center"  align="right">&nbsp;</td>
 		
	  </tr>	 
		
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/claimtxnidedit-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>