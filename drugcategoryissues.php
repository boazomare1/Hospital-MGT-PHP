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

$colorloopcount = '';

//To populate the autocompetelist_services1.js


$transactiondatefrom = date('2014-01-01');
$transactiondateto = date('Y-m-d');


if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }


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

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>


<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcCustomerDropDownSearch1();">
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
		
		
			<form name="drugs" action="drugcategoryissues.php" method="post" onKeyDown="return disableEnterKey()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Drug Category Issues</strong></td>
          </tr>
        <tr>
          
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

function clrcode()
{
	document.getElementById('searchitemcode').value='';
}

</script>
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
            <option value="">Show All Category</option>
            <?php
			}
			else
			{
			?>
            <option selected="selected" value="">Show All Category</option>
            <?php
			}
			?>
            <?php
			$query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res42 = mysqli_fetch_array($exec42))
			{
			$categoryname = $res42['categoryname'];
			?>
            <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
            <?php
			}
			?>
          </select></td>
        </tr>
       
        
        <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="186" align="center" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong></strong> </td>
          <td width="186" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">  
		  </td>
        </tr>
        <tr>
          <input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; 
          text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly />
           <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"> <strong>Type</strong></td>
                        <td align="left" valign="top"  bgcolor="#ffffff">
                        <select name="type" id="type" >
                          <option value="">Select</option>
                          <option value="TABLETS">TABLETS AND CAPSULES</option>
                          <option value="INJECTIONS">INJECTABLES</option>
                          <option value="SYRUPS & SUSP">SYRUPS AND SUSPENSIONS</option>
                          <option value="VACCINES">VACCINES</option>
                          <option value="EXTERNAL PREP">EXTERNAL PREPARATIONS</option>
                          <option value="EXTERNAL PREP">SUNDRIES</option>
                           </select>                    </td>
                           <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><!--Item Code :--> <?php //echo $medicinecode; ?></strong></td>
                           </tr>
                           <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Medicine</strong></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="itemname" type="text" id="itemname" value="<?php echo $searchitemname; ?>" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">
		  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
		  <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?php //echo $searchitemcode; ?>">
           </td>
        </tr>
                           <tr>
                           <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800"
            align="left" border="0">
          <tbody>
		  
		 
		  
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["type"])) {  $type = $_REQUEST["type"]; } else { $type = ""; }

?>

	<tr>
		<td align="right" valign="center" class="bodytext31" colspan="6">
			<?php  $url = "ADate1=$ADate1&&ADate2=$ADate2&&frmflag1=frmflag1&&categoryname=$categoryname&&type=$type&&searchitemcode=$searchitemcode" ?>
			<a href="print_drugcategoryissues.php?<?php echo $url; ?>" target='_blank'><img src="images/pdfdownload.jpg" height="40" width="40"></a>
		</td>
	</tr>
		
<?php
if(true)
{
$query9 = "select categoryname, itemcode from master_medicine where status <> 'deleted' and categoryname LIKE '%$categoryname%' and itemcode LIKE '%$searchitemcode%' order by itemname";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res9 = mysqli_fetch_array($exec9))
{
$sno=0;
$total=0;
 $categoryname = $res9['categoryname']; 
 $catitemcode = $res9['itemcode']; 

$query7 = "select * from pharmacysales_details where itemcode = '$catitemcode'  and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num7 = mysqli_num_rows($exec7);
if($num7!=0){
?>
			<tr> <td align="left" valign="center"  
                class="bodytext31" colspan="6"><strong><?php echo $categoryname; ?></strong></td></tr>
			<tr>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
				<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" ><strong>Dept/Ward</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Drug Name</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date of Issue</strong></div></td>
             </tr>
<?php							
while($res7 = mysqli_fetch_array($exec7))
{

$billdate6 = $res7['entrydate'];
$quantity6 = $res7['quantity'];
$patientname6 = $res7['patientname'];
$itemname = $res7['itemname'];
$itemcode = $res7['itemcode'];
				$issuedfrom = $res7['issuedfrom']; 
				$visitcode = $res7['visitcode'];

				if($issuedfrom ==''){
					$sqlq = "SELECT departmentname FROM `master_visitentry` WHERE `visitcode` = '$visitcode'";
					$sqlexc = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq);
					$sqlnum = mysqli_num_rows($sqlexc);
					$sqlres = mysqli_fetch_array($sqlexc);
					if($sqlnum > 0){
						$dept_ward = $sqlres['departmentname'];
					}else{
						$dept_ward = '';
					}

				}else{
					$sqlq1 = "SELECT ward FROM `ip_bedallocation` WHERE `visitcode` = '$visitcode'";
					$sqlexc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq1);
					$sqlnum1 = mysqli_num_rows($sqlexc1);
					$sqlres1 = mysqli_fetch_array($sqlexc1);

					if($sqlnum1 > 0){
						$dept_wardautono = $sqlres1['ward'];
						$sqlq2 = "SELECT ward FROM `master_ward` WHERE `auto_number` = '$dept_wardautono' ";
						$sqlexc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq2);
						$sqlnum2 = mysqli_num_rows($sqlexc2);
						$sqlres2 = mysqli_fetch_array($sqlexc2);
						if($sqlnum2 > 0){
							$dept_ward = $sqlres2['ward'];
						}else{
							$dept_ward = '';
						}
					}else{
						$dept_ward = '';
					}

				}


	
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
				if($type=='')
				{
					$num='1';
				}
				else
				{
					$query9 = "select * from master_medicine where  incomeledger like '%$type%' and itemcode='$itemcode'  and status = '' group by itemcode	 order by categoryname";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec9);	
				}
				if($num!=0)
				{
				$total=$total+$quantity6;
				?>
				 <tr <?php echo $colorcode; ?>>
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname6; ?></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $dept_ward; ?></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $itemname; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo intval($quantity6); ?></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $billdate6; ?></div></td>
              
				</tr>
				<?php
				}
}?>
				<td align="left" valign="center"  
                class="bodytext31"><strong></strong></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong></strong></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong></strong></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Total</strong></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong><?php echo intval($total); ?></strong></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong></strong></div></td>
              
				</tr>
				<?php }
}
}
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