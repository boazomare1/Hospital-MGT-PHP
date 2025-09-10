<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];



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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function loadprintpage1()
{
	var varPaperSize = document.getElementById("papersize").value;
	if (varPaperSize == "40 Column Paper")
	{
		alert ("To Print In 40 Column Paper, Please Go To Sales Page & Use Bottom Right Corner Print Options");
	}

	var varSupplierBillNumber = document.getElementById("supplierbillnumber").value;
	if (varSupplierBillNumber == "")
	{
		alert ("Please Enter Bill Number.");
		return false;
	}
	
	var varPrintHeader = document.getElementById("printheader").value;
	var varTitleHeader = document.getElementById("titleheader").value;
	if (varPrintHeader == "")
	{
		alert ("Please Select Print Header.");
		return false;
	}
	if (varTitleHeader == "")
	{
		alert ("Please Select Copy Header.");
		return false;
	}
	if (varTitleHeader != 'ALL')
	{
		//alert (varBillNumber);
		//alert (varPrintHeader);
		//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
		if (varPaperSize == "A4 Sheet Paper")
		{
			window.open("print_bill1_purchase1.php?printsource=printselectionpage&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow<?php echo rand(); //$banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		}
		if (varPaperSize == "A5 Sheet Paper")
		{
			window.open("print_bill1_purchase1_a5.php?printsource=printselectionpage&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow<?php echo rand(); //$banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		}
	}
	else
	{
		alert ('Printing All Copies');
		<?php
		$query11 = "select * from master_billtitleheader where status <> 'deleted' order by billtitleheader ";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res11 = mysqli_fetch_array($exec11))
		{
		$billtitleheader11 = $res11['billtitleheader'];
		$masanum11 = $res11['auto_number'];
		?>
		if (varPaperSize == "A4 Sheet Paper")
		{
			window.open("print_bill1_purchase1.php?printsource=printselectionpage&&title1=<?php echo $billtitleheader11; ?>&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow<?php echo $masanum11; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		}
		if (varPaperSize == "A5 Sheet Paper")
		{
			window.open("print_bill1_purchase1_a5.php?printsource=printselectionpage&&title1=<?php echo $billtitleheader11; ?>&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow<?php echo $masanum11; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		}
		<?php
		}
		?>
		return false;
	}
}


function loadmultiprintpage1()
{
	
	var varPaperSize = document.getElementById("papersize").value;
	if (varPaperSize == "40 Column Paper")
	{
		alert ("To Print In 40 Column Paper, Please Go To Sales Page & Use Bottom Right Corner Print Options");
	}
	
	var varSupplierBillNumber = document.getElementById("supplierbillnumber").value;
	if (varSupplierBillNumber == "")
	{
		alert ("Please Enter Bill Number.");
		return false;
	}
	if (isNaN(varSupplierBillNumber))
	{
		alert ("Bill Number Can Only Be Numbers. Please Enter Bill Number Properly.");
		return false;
	}
	
	var varPrintHeader = document.getElementById("printheader").value;
	var varTitleHeader = document.getElementById("titleheader").value;
	if (varPrintHeader == "")
	{
		alert ("Please Select Print Header.");
		return false;
	}
	if (varTitleHeader == "")
	{
		alert ("Please Select Copy Header.");
		return false;
	}
	
	//alert ("Multi Print");
	
	var varSupplierBillNumber = document.getElementById("supplierbillnumber").value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			var varOutPut1 = xmlhttp.responseText;
			//alert (varOutPut1);
			funcPrintPage1(varOutPut1)
		}
	}
	xmlhttp.open("POST","purchaseprintselection1ajax1.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("supplierbillnumber=" + varSupplierBillNumber + "&&randnum1=" + Math.random() + "");
	
	
	
}

function funcPrintPage1(varPageCount)
{
	//alert (varPageCount);
	var varPrintHeader = document.getElementById("printheader").value;
	var varTitleHeader = document.getElementById("titleheader").value;
	var varSupplierBillNumber = document.getElementById("supplierbillnumber").value;

	if (varPageCount == 1 || varPageCount == 0)
	{
		//alert ("Single Print");
		window.open("print_bill1_purchase1.php?printsource=printselectionpage&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow<?php echo rand(); //$banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	else
	{
		//alert ("Multi Print");
		for(i=1;i<=varPageCount;i++)
		{
			var varPageNumber = i;
			//alert (varPageNumber);
			if (i < varPageCount)
			{
				//alert ("Intermediat Page");
				window.open("print_bill1_purchase1_multi1part1.php?pagenumber="+varPageNumber+"&&printsource=printselectionpage&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow"+varPageNumber+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
			}
			else if (i == varPageCount)
			{
				//alert ("Final Page");
				window.open("print_bill1_purchase1_multi1part2.php?pagenumber="+varPageNumber+"&&printsource=printselectionpage&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&supplierbillnumber="+varSupplierBillNumber,"OriginalWindow"+varPageNumber+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
			}
		}
	}
}

</script>
<body>
<table width="1901" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		<table width="898" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Bill Print - Enter Bill Number </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              </tr>
            <tr>
              <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
            </tr>
            <tr>
                <td width="16%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Purchase Invoice Number </td>
                <td width="84%" colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">
				<input value="<?php //echo $billnumber; ?>" name="supplierbillnumber" type="text" id="supplierbillnumber" size="10" style="border: 1px solid #001E6A; text-align:right">
				<select name="printheader" id="printheader">
				<option value="">Print Header</option>
				<?php
				//$query1 = "select * from master_purchaseprintheader where status <> 'deleted' order by billprintheader ";
				$query1 = "select * from master_titlename where modulename = 'purchase' and status <> 'deleted' order by titlename ";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
				$billprintheader = $res1['titlename'];
				$masanum1 = $res1['auto_number'];
				?>
				<option value="<?php echo $billprintheader; ?>"><?php echo $billprintheader; ?></option>
				<?php
				}
				?>
				</select>
				<select name="titleheader" id="titleheader">
				<option value="">Copy Header</option>
				<option value="ALL">ALL</option>
				<?php
				$query1 = "select * from master_billtitleheader where status <> 'deleted' order by billtitleheader ";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
				$billtitleheader = $res1['billtitleheader'];
				$masanum1 = $res1['auto_number'];
				?>
				<option value="<?php echo $billtitleheader; ?>"><?php echo $billtitleheader; ?></option>
				<?php
				}
				?>
				</select>
				<select name="papersize" id="papersize">
				<?php
				$selected = "";
				$query1 = "select * from master_printer where status <> 'deleted' order by papersize ";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
				$papersize = $res1['papersize'];
				$masanum1 = $res1['auto_number'];
				$defaultstatus = $res1['defaultstatus'];
				if ($defaultstatus == 'default') $selected = 'selected="selected"';
				?>
				<option value="<?php echo $papersize; ?>" <?php echo $selected; ?>><?php echo $papersize; ?></option>
				<?php
				$defaultstatus = '';
				$selected = '';
				}
				?>
				</select>
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                <input onClick="return loadprintpage1()" style="border: 1px solid #001E6A" type="button" value="Print Bill Now" name="billprintbutton" /></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">To Print A4 Multi Page</td>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input onClick="return loadmultiprintpage1()" style="border: 1px solid #001E6A" type="button" value="Print A4 Multi Page" name="billprintmulti" />
			  </td>
              </tr>
          </tbody>
        </table>

		
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

