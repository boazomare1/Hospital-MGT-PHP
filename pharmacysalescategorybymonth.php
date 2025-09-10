<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$total = "";
$colorloopcount = '';

//To populate the autocompetelist_services1.js


$transactiondatefrom = date('2014-01-01');
$transactiondateto = date('Y-m-d');




if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	
	
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

  
        <script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}
</script>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="drugs" action="pharmacysalescategorybymonth.php" method="post" onKeyDown="return disableEnterKey()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong>Pharmacy Sales Category By Month</strong></td>
          </tr>
        <tr>
        
               
        
        <tr>
          <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>From Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="frommonth" id="frommonth">
            <?php
				if ($frommonth != '')
				{
				?>
            <option value="<?php echo $frommonth; ?>" selected="selected"><?php echo $frommonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo (01); ?>"><?php echo (01); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="fromyear" id="fromyear">
              <?php
				if ($fromyear != '')
				{
				?>
              <option value="<?php echo $fromyear; ?>" selected="selected"><?php echo $fromyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
		  <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>To Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="tomonth" id="tomonth">
            <?php
				if ($tomonth != '')
				{
				?>
            <option value="<?php echo $tomonth; ?>" selected="selected"><?php echo $tomonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo date('m'); ?>"><?php echo date('m'); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="toyear" id="toyear">
              <?php
				if ($toyear != '')
				{
				?>
              <option value="<?php echo $toyear; ?>" selected="selected"><?php echo $toyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
            
		  
        </tr>
        <tr>
          <td colspan="3" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"></td>
          
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left">
            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  type="submit" value="Search" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </div></td>
        </tr>
        
      </tbody>
    </table>
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400"
            align="left" border="0">
          <tbody>
		  
		 
		  
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$frmflag1 = $_REQUEST['frmflag1'];
				if ($frmflag1 == 'frmflag1')
					{
					if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
					if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
					if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
					if (isset($_REQUEST["frommonth"])) { $frommonth = $_REQUEST["frommonth"]; $monthName = date("F", mktime(null, null, null, $frommonth)); } else { $frommonth = ""; }
					if (isset($_REQUEST["tomonth"])) { $tomonth = $_REQUEST["tomonth"]; $tomonthName = date("F", mktime(null, null, null, $tomonth)); } else { $tomonth = ""; }
					?>
					
					
					<tr> <td align="left" valign="center"  
					class="bodytext31" colspan="3" bgcolor="#ecf0f5"><strong><?php echo $categoryname; ?></strong></td></tr>
					<tr>
					<td align="left" valign="center"  
					bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
					
					<td align="left" valign="center"  
					bgcolor="#ffffff" class="bodytext31"><strong>Drug Name</strong></td>
					<?php 
					$query18 = "SELECT MONTHNAME(entrydate) as mon, YEAR(`entrydate`) as year from pharmacysales_details where MONTH(`entrydate`) between '$frommonth' and '$tomonth'  and YEAR(`entrydate`) between '$fromyear' and '$toyear' group by mon";
					$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res18 = mysqli_fetch_array($exec18))
					{${"total".$res18['mon'].$res18['year']} = '';
					?>
					<td align="left" valign="center"  
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $res18['mon']; ?></strong></div></td>
					<?php } ?>
					</tr>
					<?php
					/*$sno = 0;				
					$query9 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
					$exec9 = mysql_query($query9) or die(mysql_error());
					while($res9 = mysql_fetch_array($exec9))
						{
						
						
						$categoryname = $res9['categoryname'];*/
						$sno = 0;
						$query7 = "select * from pharmacysales_details where MONTH(`entrydate`) between '$frommonth' and '$tomonth'  and YEAR(`entrydate`) between '$fromyear' and '$toyear' group by categoryname order by entrydate desc";
						
						$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$num7 = mysqli_num_rows($exec7);
						if($num7!=0){
							
						while($res7 = mysqli_fetch_array($exec7))
							{
							
							$billdate6 = $res7['entrydate'];
							$quantity6 = $res7['quantity'];
							$patientname6 = $res7['patientname'];
							$categoryname = $res7['categoryname'];
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
							
							<td align="left" valign="center"  
							class="bodytext31"><?php echo $sno=$sno+1; ?></td>
							
							<td align="left" valign="center"  
							class="bodytext31"><div align="left"><?php echo $categoryname; ?></div></td>
							<?php							
							$query19 = "SELECT MONTHNAME(entrydate) as mon, YEAR(entrydate) as year, sum(quantity) as quantity from pharmacysales_details where categoryname like '%$categoryname%' and MONTH(`entrydate`) between '$frommonth' and '$tomonth'  and YEAR(`entrydate`) between '$fromyear' and '$toyear' group by mon";
							$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res19 = mysqli_fetch_array($exec19)){
							${"total".$res19['mon']} = $res19['quantity'];
							${"total".$res19['mon'].$res19['year']} = ${"total".$res19['mon'].$res19['year']} + ${"total".$res19['mon']};							
							}
							$query19 = "SELECT MONTHNAME(entrydate) as mon, YEAR(entrydate) as year, sum(quantity) as quantity from pharmacysales_details where MONTH(`entrydate`) between '$frommonth' and '$tomonth'  and YEAR(`entrydate`) between '$fromyear' and '$toyear' group by mon";
							$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res19 = mysqli_fetch_array($exec19)){?>
							<td align="left" valign="center"  
							class="bodytext31"><div align="right"><?php echo intval(${"total".$res19['mon']}); ${"total".$res19['mon']} =''; ?></div></td>
							<?php } ?>
							
							</tr>
							<?php
							} 
						}
						//}
					?>
					<tr>
					<td align="left" valign="center"  
					class="bodytext31"><div align="left"><strong></strong></div></td>
					<td align="left" valign="center"  
					class="bodytext31"><div align="left"><strong>Total</strong></div></td>
					<?php 
					$query19 = "SELECT MONTHNAME(entrydate) as mon, YEAR(entrydate) as year, sum(quantity) as quantity from pharmacysales_details where MONTH(`entrydate`) between '$frommonth' and '$tomonth'  and YEAR(`entrydate`) between '$fromyear' and '$toyear' group by mon";
					$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res19 = mysqli_fetch_array($exec19)){?>
					<td align="left" valign="center"  
					class="bodytext31"><div align="right"><strong><?php echo intval(${"total".$res19['mon'].$res19['year']}); ?></strong></div></td>
					<?php }?>
					
					
					</tr><?php 
					
					}
				?>
		  </tbody>
		  </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>