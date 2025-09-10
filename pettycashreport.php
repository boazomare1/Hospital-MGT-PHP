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

$nettotal='';
$dcreditamount = '';
$ddebitamount ='';
$ccreditamount = '';
$cdebitamount = '';
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  

include ("autocompletebuild_users.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

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


function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers.js"></script>
<script type="text/javascript">
window.onload = function () 
{
//alert ('hai');
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        
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
		
		
              <form name="cbform1" method="post" action="pettycashreport.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Petty Cash Report </strong></td>
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
						
						}
						?>
						
						
                  
                  </td> 
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">
               </td>
              </tr>
           
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
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
        
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="792" 
            align="left" border="0">
          <tbody>
          
              
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbcustomername = $_REQUEST['cbcustomername'];
					//$patientfirstname =  $cbcustomername;
					
					$customername = $_REQUEST['cbcustomername'];
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}
				?> 			             
				<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				 $cbcustomername=trim($cbcustomername);
		  
			
			 
			
			
			?>
            
			<td><?php echo ucwords($username); ?></td>	
				
<tr>
              <td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
               <td width="8%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Docno.</strong></td>
				
				<td width="16%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Transaction Date</strong></td>
              <td width="14%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ledger Name </strong></td>
              <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Ledger Code </strong></td>
              <td width="14%"  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Credit Amount  </strong></td>
				<td  width="17%"  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Debit Amount</strong></td>
				
 </tr>
			  
			  
			
			  
			  <?php 
			    $query32 = "select docno from master_journalentries where docno like 'PCR-%' and entrydate between '$transactiondatefrom' and '$transactiondateto' group by docno  ORDER BY `master_journalentries`.`docno` DESC  ";
			$exe32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sno=0;
			while($res32 = mysqli_fetch_array($exe32))
			{
		
			 $docno1=$res32['docno']; 
			  
			  $query31 = "select username,ledgername,entrydate,ledgerid,creditamount,debitamount,docno from master_journalentries where docno='$docno1' and selecttype='Cr' and entrydate between '$transactiondatefrom' and '$transactiondateto' ORDER BY `master_journalentries`.`docno` DESC ";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($res31 = mysqli_fetch_array($exe31))
			{
					$sno=$sno+1;
				$username = $res31["username"];
			    $res21username = $res31["ledgername"];
			    $entrydate = $res31["entrydate"];
			   $ledgerid = $res31["ledgerid"];
			   $ccreditamount = $res31["creditamount"];
			   $cdebitamount = $res31["debitamount"];
			   ?>
               
			    <tr>
             <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="right"><?php  echo $docno1; ?></td>
            
             <td class="bodytext31" valign="center"  align="right"><?php echo $entrydate; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo $res21username; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo $ledgerid; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ccreditamount,2,'.',','); ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($cdebitamount,2,'.',','); ?></td>
             </tr>
             <?php
			}
			$query33 = "select username,ledgername,entrydate,ledgerid,creditamount,debitamount,docno from master_journalentries where docno='$docno1' and selecttype='Dr' and entrydate between '$transactiondatefrom' and '$transactiondateto' ORDER BY `master_journalentries`.`docno` DESC";
			$exe33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($res33 = mysqli_fetch_array($exe33))
			{
					$sno=$sno+1;
				  $docno = $res31["docno"];
				 $username = $res33["username"];
			     $res21username = $res33["ledgername"];
			    $entrydate = $res33["entrydate"];
			   $ledgerid = $res33["ledgerid"];
			   $dcreditamount = $res33["creditamount"];
			   $ddebitamount = $res33["debitamount"];
			    ?>
                
			<tr>
               <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo $docno1; ?></td>
            
             <td class="bodytext31" valign="center"  align="right"><?php echo $entrydate; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo ucwords($res21username); ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo $ledgerid; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($dcreditamount,2,'.',','); ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ddebitamount,2,'.',','); ?></td>
             
              </tr>
			  <?php  }
			   }?>
			
			
			
			 
            <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
            </tr>
            
             
			  <tr>
              <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td colspan="" class="bodytext31" valign="center"  align="right">&nbsp;</td>
	    <td colspan="2" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong> </td>
        <?php $total=$ccreditamount - $ddebitamount; ?>
		<td class="bodytext31" valign="center"  align="right"><?php echo number_format($total,2,'.',','); ?></td>
        <td class="bodytext31" valign="center"  align="right"><a href="print_pettycash.php?transactiondatefrom=<?php echo $transactiondatefrom; ?>&&transactiondateto=<?php echo $transactiondateto ?>"target="_blank"  ><img height="25" width="25" src="images25\pdfdownload.jpg"></a></td>
		
	  </tr>	
      <?php } ?> 
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

