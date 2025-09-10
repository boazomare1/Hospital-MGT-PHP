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

$colorloopcount=0;
$sno=0;
$description = '';

if(isset($_REQUEST['description']))
{
 $description = $_REQUEST['description'];
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1134">
		
              <form name="cbform1" method="post" action="usersreportlist.php">
                <table width="666" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr>
			 <td width="36%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search By Description</td>
				  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
				    <select name="description" id="description" onChange="this.form.submit()">
                      <option value="">Select Description</option>
                      <?php
				     $query51 = "select * from master_employee where jobdescription <> '' and username <> 'admin' and status <> 'deleted' group by jobdescription";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					 $num51=mysqli_num_rows($exec51);
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       //$res51anum = $res51["auto_number"];
					   //$res51accessname =$res51['username'];
					   $res51jobdescription= $res51["jobdescription"];
				       ?>
                      <option value="<?php echo $res51jobdescription; ?>"><?php echo strtoupper($res51jobdescription); ?></option>
                      <?php
				      } 
				  ?>
                    </select>
				  </strong></td>
			  <td colspan="2">&nbsp;</td>	  
			</tr>
			
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
					  <td width="3%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>	  
                      <td width="11%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_usersreportlist.php?description=<?php echo $description; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>
			</tr>
					<tr>
					  <td colspan="3" align="left" valign="middle"  class="bodytext3">&nbsp;</td>
					</tr>
                  </tbody>
                </table>
            </form>		</td>
      </tr>
	  
      
      <tr>
	  <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1103" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="7" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>Users List </strong></td>
			 </tr>
			  <tr>
				  <td width="67" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
				  				  <td width="262"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>User Full Name </strong></td>	
                                  <td width="127"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Access Name </td>
                                  <td width="203"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Description</td>
                                  <td width="54"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Shift</td>
                                  <td width="172"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Store </td>
                                  <td width="143"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">Location</td>
			  </tr>					
           <?php
	    $description=trim($description);
		
		if($description == '')
			{
		$query1 = "select * from master_employee where status <> 'deleted' group by employeename ORDER BY employeename "; 
		    }
			else
			{
		$query1 = "select * from master_employee where jobdescription = '$description' and status <> 'deleted' group by employeename ORDER BY employeename"; 
         	}
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$res1employeename =$res1['employeename'];
		$res1accessname =$res1['username'];
		$res1store =$res1['store'];
		 $res1location =$res1['locationname'];
		$res1shift=$res1['shift'];
		$res1description=$res1['jobdescription'];
		$query2 = "select * from master_employeelocation where username='$res1accessname'  AND  defaultstore='default'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2= mysqli_fetch_array($exec2);
		$res2store =$res2['storecode'];		$query11 = "select * from master_store where auto_number = '$res2store'";		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("error in query11".mysqli_error($GLOBALS["___mysqli_ston"]));		$res11 = mysqli_fetch_array($exec11);		$res10store = $res11["store"];		$res10anum = $res11["storecode"];
		
		$query3 = "select * from master_location where auto_number = '$res1location' and status <> 'deleted' ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3= mysqli_fetch_array($exec3);
		$res3location=$res3['locationname'];
		
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
		    <?php if($res1accessname != 'admin') { ?>
		 	<tr <?php echo $colorcode; ?>>
				<td width="67" align="center" valign="center" class="bodytext31"><?php echo $sno=$sno + 1; ?></td>
				<td width="262"  align="left" valign="center" class="bodytext31"><?php echo $res1employeename;  ?></td>
			    <td width="127"  align="left" valign="center" class="bodytext31"><?php echo $res1accessname; ?></td>
			    <td width="203"  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res1description); ?></td>
			    <td width="54"  align="left" valign="center" class="bodytext31"><?php echo $res1shift; ?></td>
			    <td width="172"  align="left" valign="center" class="bodytext31"><?php echo $res10store; ?></td>
			    <td width="143"  align="left" valign="center" class="bodytext31"><?php echo $res1location; ?></td>
			</tr>	
			<?php } ?>
		<?php
		}	  
		?>	
            </tbody>
        </table>

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

