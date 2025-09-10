<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">



<script>

$(function() {

$('#searchsuppliername').autocomplete({
		
	source:'ajaxemployeenewsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var employeecode = ui.item.employeecode;
			var employeename = ui.item.employeename;
			$('#searchemployeecode').val(employeecode);
			$('#searchsuppliername').val(employeename);

			
			},
    });

});
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
		
		
              <form name="cbform1" method="post" action="doctorsactivityreport.php">
		<table width="658" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Activity Report</strong></td>
              </tr>
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	


                  <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="3">
 
                      <select name="slocation" id="slocation">
                      <option value="" selected="selected">All</option>
                   	   <?php
						$query01="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname']; ?> </option>		
						<?php 
						}
						?>
                      </select>
                      </td>
                      
                      </tr>

<tr>
  			  <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor</td>
         <td width="38%" colspan="3" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

	<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="40" autocomplete="off">
	<input name="searchdescription" id="searchdescription" type="hidden" value="">
	<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="<?php echo $searchemployeecode; ?>">
	<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
	</td>
	</tr>
  
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
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
	   <?php if($cbfrmflag2 == 'cbfrmflag1'){?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="631" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31">
             
				  </td>  
                   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				
              <td width="34%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor Name</strong></div></td>
				 
   				  <td width="24%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Count</strong></div></td>
                  <td width="64%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Location</strong></div></td>
				
            </tr>
			
			<?php
			
		$query7 = "select * from master_employee where employeecode = '$searchemployeecode'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7username = $res7['username'];
		  $query4 = "select username,locationname,count(username) as totalpatients from master_consultationlist where locationcode like '%$slocation' and date between '$ADate1' and '$ADate2' and username LIKE '%$res7username%' group by username order by auto_number ASC"; 

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num4 = mysqli_num_rows($exec4);
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$numt1=0;
			
			//echo $res4['totalpatients'];
			 $username = $res4['username'];
			 $totalpatients=$res4['totalpatients'];
		
		$query1002 = "select count(username) as totalpatients1 from master_consultationlist where locationcode like '%$slocation' and username='$username' and date between '$ADate1' and '$ADate2' group by visitcode order by auto_number ASC"; 
		
		  $exec1002 = mysqli_query($GLOBALS["___mysqli_ston"], $query1002) or die ("Error in Query002".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $numt1=mysqli_num_rows($exec1002);
				
				
				$doctorname = $res4['username'];
				$doctorusername = $res4['username'];
				$location=$res4['locationname'];
				

				$query02="select employeename from master_employee where username='$doctorname'";
				$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
				$res02=mysqli_fetch_array($exec02);
				if($res02['employeename']!='')
				{
					 $doctorname=$res02['employeename'];
				}
				
				$snocount = $snocount + 1;
				
				//echo $cashamount;
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				
				<a href="doctorsactivityreportdetaiview.php?usernamenew=<?= $doctorusername; ?>&ADate1=<?= $ADate1; ?>&ADate2=<?= $ADate2; ?>&cbfrmflag2=cbfrmflag1&slocation=<?= $slocation ?>" target="_blank" > <?php echo $doctorname; ?>  </a>
                
                </div>
                
                
                </td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $numt1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $location; ?></div></td>
				
				
				
				</tr>
			<?php
						$total1 +=$numt1;
						$numt1=0;
					
			}
			?>
			
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total Patients Consulted:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?= $total1;?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				
				 <tr>
               <?php  $url = "ADate1=$ADate1&&ADate2=$ADate2&slocation=$slocation&usernamenew=$res7username" ?>
		<td colspan="5" align="left" class="bodytext3"><a href="print_doctoractivity.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a>
		&nbsp;&nbsp;&nbsp;<a href="print_doctoractivityxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>
		</tr>
			  
			</tr>
          </tbody>
        </table></td><?php }?>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>

