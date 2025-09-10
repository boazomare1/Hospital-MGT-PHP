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

$colorloopcount = '';
$sno = '';
$snocount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["billtype"])) { $billtype = $_REQUEST["billtype"]; } else { $billtype = ""; }
if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d');
	$transactiondateto = date('Y-m-d');
}



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


<script>
<?php 
if (isset($_REQUEST["billno"])) { $billno = $_REQUEST["billno"]; } else { $billno = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }
?>
	var billno;
	var billno = "<?php echo $billno; ?>";
	var visitcode;
	var visitcode = "<?php echo $visitcode; ?>";
	var patientcode;
	var patientcode = "<?php echo $patientcode; ?>";
	var locationcode;
	var locationcode = "<?php echo $locationcode; ?>";
	var source;
	var source = "<?php echo $source; ?>";

	if(billno!= "" && source=='debit') 
	{
		window.open("print_adhoc_debitnote.php?billno="+billno+"&&visitcode="+visitcode+"&&patientcode="+patientcode+"&&locationcode="+locationcode,"OriginalWindowA25",'width=800,height=1000,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
	if(billno!= "" && source=='credit') 
	{
		window.open("print_adhoc_creditnote.php?billno="+billno+"&&visitcode="+visitcode+"&&patientcode="+patientcode+"&&locationcode="+locationcode,"OriginalWindowA25",'width=800,height=1000,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>

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



function funcBill()
{
if((document.getElementById("billtype").value == "")||(document.getElementById("billtype").value == " "))
{
alert('Please Select Bill');
return false;
}
}

function print_it_val(sno,locationcode,billautonumber)
{
	
	
	if(document.getElementById("no_icd"+sno).checked == true)
	{
		var hideicd=1;
	}
	else
	{
		var hideicd=0;
	}
	window.open("print_paylater_detailed.php?locationcode=" + locationcode+ "&&billautonumber=" + billautonumber+ "&&hideicd=" + hideicd, "Window2", 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
}
</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->

.bal
{
border-style:none;
background:none;
text-align:right;
font-weight:bold;
}
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bali
{
text-align:right;
}
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>
<script>
function myFunction()
{
	if(document.getElementById("billtype").value == '')
	{
	alert("Please Select Deposit Type");
	document.getElementById("billtype").focus();
	return false;
	}
}
function redirect_popup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
</script>

<script src="js/datetimepicker_css.js"></script>

<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
<table width="1320" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="1350" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
              <form name="cbform1" method="post" action="slade_dr_cr_notes.php">
                <table width="815" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Reprints </strong></td>
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
                    <tr style="display:none">
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>
                        <select name="billtype" id="billtype" >
                         
                          <option value="161" <?php if($billtype==161) echo 'selected'; ?>>Cr/Dr Notes</option>
						
                        </select>
                      </strong></td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Name </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatient" id="searchpatient" value="<?php echo $searchpatient; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Code </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatientcode" id="searchpatientcode" value="<?php echo $searchpatientcode; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Visit Code </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" size="50" /></td>
                    </tr>
					
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Bill Number </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="billnumber" id="billnumber" value="<?php echo $billnumber; ?>" size="50" /></td>
                    </tr>
					
					
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
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
                          <input  type="submit" onClick= "return funcBill();" value="Search" name="Submit" />
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1052" 
            align="left" border="0">
          <tbody>
		<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 161)
				 {
				 $query7 = " SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_creditnote where locationcode='$locationcode1' and docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				UNION ALL SELECT auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_debitnote where locationcode='$locationcode1' and docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by docno 
				order by auto_number desc";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#ecf0f5" class="style3">Cr/Dr Notes<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "SELECT ref_no,'credit' as source,auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_creditnote where locationcode='$locationcode1' and docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and posting_status='' group by docno 
				UNION ALL SELECT ref_no,'debit' as source,auto_number as auto_number, patientcode as patientcode, docno as billno, patientvisitcode as visitcode, consultationdate as billdate, patientname as patientname from adhoc_debitnote where locationcode='$locationcode1' and docno like '%$billnumber%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and posting_status='' group by docno 
				order by auto_number desc";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$source= $res7['source'];
			$res7ref_no= $res7['ref_no'];
		//	$res7username= $res7['username'];
			
		    $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               <?php //Cr.N-37-19	 
               $aa=explode("-",$res7billno);
               $a=$aa[0];
			   $bb=explode("-",$res7visitcode);
               $b=$bb[0];
               
           		if($a=='CRN'){ ?>
               <!--<td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_adhoc_creditnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>&&source=<?php echo $source; ?>"><strong>Post Cr Note</strong></a></td>-->
               <td class="bodytext31" valign="center"  align="left"><a href="slade-balance-Dr_Cr.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>&&source=<?php echo $source; ?>&&mainsource=<?php echo $b; ?>&&billno=<?php echo $res7ref_no; ?>&&docno=<?php echo $res7billno; ?>" onClick="redirect_popup()"><strong>Post Cr Note</strong></a></td>
               	<?php }
           		if($a=='DBN'){ ?>
               <!--<td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_adhoc_debitnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>&&source=<?php echo $source; ?>"><strong>Post Dr Note</strong></a></td>-->
                <td class="bodytext31" valign="center"  align="left"><a  href="slade-balance-Dr_Cr.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>&&source=<?php echo $source; ?>&&mainsource=<?php echo $b; ?>&&billno=<?php echo $res7ref_no; ?>&&docno=<?php echo $res7billno; ?>" onClick="redirect_popup()"><strong>Post Dr Note</strong></a></td>
               
           
           <?php } ?>
               </tr>
		   <?php } }  ?>
		

            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="1%" rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			   </tr>          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

