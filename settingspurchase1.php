<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$errmsg = '';
$bgcolorcode = '';
$sno = '';
$discounttext = '';
$description = '';
$quantity = '';
$unit = '';
$totaldiscountpercent = '';
$rate = '';
$total = '';
$subtotal = '';
$totaldiscountamount = '';
$totalafterdiscount = '';
$taxname = '';
$taxpercent = '';
$taxamount = '';
$transportation = '';
$totalamount = '';
$packaging = '';
$delivery = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_POST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

	$f1 = $_REQUEST['f1'];
	$f2 = $_REQUEST['f2'];
	$f3 = $_REQUEST['f3'];
	$f4 = $_REQUEST['f4'];
	$f5 = $_REQUEST['f5'];
	$f6 = $_REQUEST['f6'];
	$f7 = $_REQUEST['f7'];
	$f8 = $_REQUEST['f8'];
	$f9 = $_REQUEST['f9'];
	$f10 = $_REQUEST['f10'];
	$f11 = $_REQUEST['f11'];
	$f12 = $_REQUEST['f12'];
	$f13 = $_REQUEST['f13'];
	$f14 = $_REQUEST['f14'];
	$f15 = $_REQUEST['f15'];
	$f16 = $_REQUEST['f16'];
	$f17 = $_REQUEST['f17'];
	$f18 = $_REQUEST['f18'];
	$f19 = $_REQUEST['f19'];
	$f20 = $_REQUEST['f20'];
	$f21 = $_REQUEST['f21'];
	$f22 = $_REQUEST['f22'];
	$f23 = $_REQUEST['f23'];
	$f24 = $_REQUEST['f24'];
	$f25 = $_REQUEST['f25'];
	$f26 = $_REQUEST['f26'];
	$f27 = $_REQUEST['f27'];
	$f28 = $_REQUEST['f28'];
	$f29 = $_REQUEST['f29'];
	$f30 = $_REQUEST['f30'];
	$f31 = $_REQUEST['f31'];
	$f32 = $_REQUEST['f32'];
	$f9size = $_REQUEST['f9size'];
	$f27size = $_REQUEST['f27size'];
	$f28size = $_REQUEST['f28size'];
	$f9color = '';
	$f10color = '';
	$f25color = '';
	$showlogo = '';
	$letterheadprinting = $_REQUEST['letterheadprinting'];
	$billnumberprefix = $_REQUEST['billnumberprefix'];
	$billnumberpostfix = $_REQUEST['billnumberpostfix'];
	
	
	$dateposted = $updatedatetime;
	$query3 = "select auto_number from settings_purchase where companyanum = '$companyanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount3 = mysqli_num_rows($exec3);
	if ($rowcount3 != 0)
	{
		$query1 = "update settings_purchase set f1 = '$f1', f2 = '$f2', f3 = '$f3', f4 = '$f4', f5 = '$f5', 
		f6 = '$f6', f7 = '$f7', f8 = '$f8', f9 = '$f9', f10 = '$f10', f11 = '$f11', f12 = '$f12', f13 = '$f13', 
		f14 = '$f14', f15 = '$f15', f16 = '$f16', f17 = '$f17', f18 = '$f18', f19 = '$f19', f20 = '$f20', f21 = '$f21', 
		f22 = '$f22', f23 = '$f23', f24 = '$f24', f25 = '$f25', f26 = '$f26', f27 = '$f27', f28 = '$f28', f29 = '$f29', f30 = '$f30', f31 = '$f31', f32 = '$f32',  
		f9size = '$f9size', f27size = '$f27size', f28size = '$f28size', 
		f9color = '$f9color', f10color = '$f10color', f25color = '$f25color', 
		updatedby = '$username', ipaddress = '$ipaddress', updatedate = '$dateposted', showlogo = '$showlogo', 
		letterheadprinting = '$letterheadprinting', billnumberprefix = '$billnumberprefix', billnumberpostfix = '$billnumberpostfix' 
		where companyanum = '$companyanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$query4 = "insert into settings_purchase (f1, f2, f3, f4, f5, f6, f7, f8, f9, f10, 
		f11, f12, f13, f14, f15, f16, f17, f18, f19, f20, f21, f22, f23, f24, f25, f26, 
		f27, f28, f29, f30, f31, f32, f9size, f27size, f28size, f9color, f10color, f25color, 
		updatedby, ipaddress, updatedate, companyanum, companyname, showlogo, letterheadprinting, 
		billnumberprefix,billnumberpostfix) 
		values ('$f1','$f2','$f3','$f4','$f5', '$f6','$f7','$f8','$f9','$f10',
		'$f11','$f12','$f13', '$f14','$f15','$f16','$f17','$f18','$f19','$f20','$f21', 
		'$f22','$f23','$f24','$f25','$f26','$f27','$f28', '$f29', '$f30', '$f31', '$f32', 
		'$f9size','$f27size','$f28size', '$f9color','$f10color','$f25color', 
		'$username','$ipaddress','$dateposted', '$companyanum', '$companyname', '$showlogo', '$letterheadprinting', 
		'$billnumberprefix','$billnumberpostfix')";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
	$errmsg = "Success. Purchase Bill Settings Update Completed.";
	$bgcolorcode = 'failed';

}

	$query2 = "select * from settings_purchase where companyanum = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$f1 = $res2['f1'];
	$f2 = $res2['f2'];
	$f3 = $res2['f3'];
	$f4 = $res2['f4'];
	$f5 = $res2['f5'];
	$f6 = $res2['f6'];
	$f7 = $res2['f7'];
	$f8 = $res2['f8'];
	$f9 = $res2['f9'];
	$f10 = $res2['f10'];
	$f11 = $res2['f11'];
	$f12 = $res2['f12'];
	$f13 = $res2['f13'];
	$f14 = $res2['f14'];
	$f15 = $res2['f15'];
	$f16 = $res2['f16'];
	$f17 = $res2['f17'];
	$f18 = $res2['f18'];
	$f19 = $res2['f19'];
	$f20 = $res2['f20'];
	$f21 = $res2['f21'];
	$f22 = $res2['f22'];
	$f23 = $res2['f23'];
	$f24 = $res2['f24'];
	$f25 = $res2['f25'];
	$f26 = $res2['f26'];
	$f27 = $res2['f27'];
	$f28 = $res2['f28'];
	$f29 = $res2['f29'];
	$f30 = $res2['f30'];
	$f31 = $res2['f31'];
	$f32 = $res2['f32'];
	$f9size = $res2['f9size'];
	$f27size = $res2['f27size'];
	$f28size = $res2['f28size'];
	$showlogo = $res2['showlogo'];
	$companylogo = $res2['companylogo'];
	$letterheadprinting = $res2['letterheadprinting'];
	$dateposted = $res2['updatedate'];
	$billnumberprefix = $res2['billnumberprefix'];
	$billnumberpostfix = $res2['billnumberpostfix'];
	
	// to avoid header inforation, need to create file in run time. image is saved in db for backup purpose.
	
if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($billstatus == 'firstbill' || $dateposted == '')
{

	$f1 = 'Original Copy';
	$f2 = 'SSI NO:';
	$f3 = 'I.E.CODE:';
	$f4 = 'TIN NO:';
	$f5 = 'CST NO:';
	$f6 = 'Tele Fax No:';
	$f7 = 'Phone No:';
	$f8 = 'Email:';
	$f9 = 'Company Name Here';
	$f10 = 'Address Line 1';
	$f11 = 'Address Line 2';
	$f12 = 'Address Line 3';
	$f13 = 'Supplier,';
	$f14 = 'M/s.';
	$f15 = 'INV NO.:';
	$f16 = 'DATE:';
	$f17 = 'Party TIN NO:';
	$f18 = 'Your Order No:';
	$f19 = 'Despatched To:';
	$f20 = 'Party CST NO:';
	$f21 = 'Sent Through :';
	$f22 = 'L R / R R No.:';
	$f23 = '';
	$f24 = '1. Interest will be charged at 30% PA. if the Bill is not paid withing 30 days. 
2. All claims for shortage, loss, delay or damage should be preferred against carriers only. 
3. Every care is taken in Packing the goods and our responsibility ceases as soon as the goods leave our godown. 
4. Goods once sold will not be taken back. ';
	$f25 = 'For Company Name';
	$f26 = 'Authorised Sign';
	$f27 = 'OM NAMAHA';
	$f28 = 'PURCHASE RECEIPT';
	$f30 = 'Delivery Charges';
	$f29 = 'Packaging Charges';
	$f9size = '5';
	$f27size = '2';
	$f28size = '2';
	$f31 = 'Your TIN No.';
	$f32 = 'Your CST No.';
	$showlogo = 'NO';
	$billnumberprefix = "";
	$billnumberpostfix = "";
	
	$errmsg = "Note: This is the bill printout settings. Please complete this before proceeding for first bill.";
	$bgcolorcode = 'failed';
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

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

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style12 {font-size: 18px; font-weight: bold; }
.style26 {font-size: 16px; font-weight: bold; }
.style27 {font-size: 14px; }
.style6 {<?php echo 'font-size: '.$fontsize4.'px'; ?>;}
.style9 {	font-size: 14px;
	font-weight: bold;
}
table.sample {	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
.style28 {font-weight: bold; font-family: "Times New Roman", Times, serif; }
.style29 {font-family: "Times New Roman", Times, serif}
.style30 {font-size: 14px; font-weight: bold; font-family: "Times New Roman", Times, serif; }
.style32 {font-size: 12px; font-weight: bold; font-family: "Times New Roman", Times, serif; }
-->
</style>
</head>
<script language="javascript">


</script>
<script language="javascript">
function loadprintpage1()
{
	window.open("print_bill1_field1.php","WindowLayoutView",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="settingspurchase1.php" enctype="multipart/form-data">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860">
		  <table width="900" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Settings - Purchase Bill </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  
				bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <tr>
                <td align="middle" colspan="4" ><table width="682" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="3"><div align="right">
                      <input type="hidden" name="f1" id="f1" value="<?php echo $f1; ?>" style="border: 1px solid #001E6A"  size="20"   />
                    </div></td>
                  </tr>
                  <tr>
                    <td width="205"><input name="f2" type="hidden" id="f2" value="<?php echo $f2; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
                    <td width="289" rowspan="4"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><div align="center" class="style9">
                            <input type="hidden" name="f27" id="f27" value="<?php echo $f27; ?>" style="border: 1px solid #001E6A"  size="20"   />
                          </div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><div align="center" class="style26"></div></td>
                        </tr>
                    </table></td>
                    <td width="188"><div align="right" class="style9">
                      <input type="hidden" name="f6" id="f6" value="<?php echo $f6; ?>" style="border: 1px solid #001E6A"  size="20"   />
                    </div></td>
                  </tr>
                  <tr>
                    <td><input type="hidden" name="f3" id="f3" value="<?php echo $f3; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
                    <td><div align="right" class="style9">
                      <input type="hidden" name="f7" id="f7" value="<?php echo $f7; ?>" style="border: 1px solid #001E6A"  size="20"   />
                    </div></td>
                  </tr>
                  <tr>
                    <td><input type="hidden" name="f4" id="f4" value="<?php echo $f4; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
                    <td><div align="right" class="style9">
                      <input type="hidden" name="f8" id="f8" value="<?php echo $f8; ?>" style="border: 1px solid #001E6A"  size="20"   />
                    </div></td>
                  </tr>
                  <tr>
                    <td><input type="hidden" name="f5" id="f5" value="<?php echo $f5; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><div align="center">
                        <table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><span class="style26">
                              <input name="f28" id="f28" value="<?php echo $f28; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            </span></td>
                          </tr>
                          <tr>
                          <!--  <td><div align="center" class="style12"><img src="logofiles/svss.jpg" width="85" height="121"></div>                                </td>-->
                            <td><div align="center" class="style12">
                              <div align="left">
                                <input name="f9" id="f9" value="<?php echo $f9; ?>" style="border: 1px solid #001E6A"  size="50"   />
                                </div>
                            </div>
                              <div align="center" class="style27">
                                <div align="left"><span class="style12">
                                  <input name="f10" id="f10" value="<?php echo $f10; ?>" style="border: 1px solid #001E6A"  size="50"   />
                                  </span></div>
                              </div>
                              <div align="center" class="style27">
                                <div align="left"><span class="style12">
                                  <input name="f11" id="f11" value="<?php echo $f11; ?>" style="border: 1px solid #001E6A"  size="50"   />
                                  </span></div>
                              </div>
                              <div align="center" class="style27">
                                <div align="left"><span class="style12">
                                  <input name="f12" id="f12" value="<?php echo $f12; ?>" style="border: 1px solid #001E6A"  size="50"   />
                                  </span></div>
                              </div></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                    </div></td>
                  </tr>
                  <tr>
                    <td colspan="3"><div align="center">&nbsp;</div></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0" class="sample">
                        <tr>
                          <td><div align="left" class="style27">
                            <input name="f13" id="f13" value="<?php echo $f13; ?>" style="border: 1px solid #001E6A"  size="20"   />
                          </div>
                              <div align="left" class="style27">
                                <input name="f14" id="f14" value="<?php echo $f14; ?>" style="border: 1px solid #001E6A"  size="20"   />
                              </div>
                            <div align="left" class="style27"></div>
                            <div align="left" class="style27"></div>
                            <div align="left"><span class="style27">&nbsp;</span></div></td>
                        </tr>
                    </table></td>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="f15" id="f15" value="<?php echo $f15; ?>" style="border: 1px solid #001E6A"  size="15"   /></td>
                        </tr>
                        <tr>
                          <td><input name="f16" id="f16" value="<?php echo $f16; ?>" style="border: 1px solid #001E6A"  size="15"   /></td>
                        </tr>
                        <tr>
                          <td><input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" style="border: 1px solid #001E6A"  size="10"   />
                            <span class="style30">Bill PreFix </span></td>
                        </tr>
                        <tr>
                          <td><input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="10"   />
                            <span class="style30">Bill PostFix </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="sample">
                        <tr>
                          <td width="53%"><input name="f17" id="f17" value="<?php echo $f17; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            <span class="style27"><br />
                              <input name="f18" id="f18" value="<?php echo $f18; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            </span><span class="style27"><br />
                            <input name="f19" id="f19" value="<?php echo $f19; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            </span></td>
                          <td width="47%">
						  <input name="f20" id="f20" value="<?php echo $f20; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            <span class="style27"><br />
                              <input name="f21" id="f21" value="<?php echo $f21; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            </span><span class="style27"><br />
                            <input name="f22" id="f22" value="<?php echo $f22; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            </span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="sample">
                        <tr>
                          <td width="5%"><div align="right" class="style28 style29">
                              <div align="left">SNo.</div>
                          </div></td>
                          <td width="57%"><div align="left" class="style28">&nbsp;Description</div></td>
                          <td width="6%"><div align="left" class="style28">&nbsp;Qty</div></td>
                          <td width="6%"><div align="left" class="style28">&nbsp;Unit</div></td>
                          <td width="7%"><div align="right" class="style28">Tax%&nbsp;</div></td>
                          <td width="7%"><div align="right"><span class="style28">Rate</span></div></td>
                          <td width="12%"><div align="left" class="style28">
                              <div align="right">Total&nbsp;</div>
                          </div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td>&nbsp;</td>
                          <td><span class="style29"></span></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td>&nbsp;</td>
                          <td><span class="style29"></span></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td><span class="style29"></span></td>
                          <td>&nbsp;</td>
                          <td><span class="style29"></span></td>
                        </tr>
                        <tr>
                          <td><span class="style29">&nbsp;<?php echo $sno; ?></span></td>
                          <td><span class="style29">&nbsp;<?php echo $description.$discounttext; ?></span></td>
                          <td><span class="style29">&nbsp;<?php echo $quantity; ?></span></td>
                          <td><span class="style29">&nbsp;<?php echo $unit; ?></span></td>
                          <td><div align="right" class="style29">&nbsp;</div></td>
                          <td><div align="right"><span class="style29"><?php echo $rate; ?></span></div></td>
                          <td><div align="right" class="style29"><?php echo $total; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong>Sub Total&nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"><?php echo $subtotal; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong> <?php echo 'Discount @ '.$totaldiscountpercent.'%'; ?>&nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"> <?php echo $totaldiscountamount; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong> <?php echo 'Total After Discount'; ?>&nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"> <?php echo $totalafterdiscount; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong> <?php echo $taxname.'Total Tax @ '.$taxpercent.'%'; ?>&nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"> <?php echo $taxamount; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong>
                            <input type="text" name="f29" id="f29" value="<?php echo $f29; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            &nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"><?php echo $packaging; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="3"><div align="right"><strong>
                            <input name="f30" id="f30" value="<?php echo $f30; ?>" style="border: 1px solid #001E6A"  size="20"   />
                            &nbsp;</strong></div></td>
                          <td colspan="3"><div align="right" class="style29"><?php echo $delivery; ?>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td><span class="style29"></span></td>
                          <td colspan="3"><div align="right" class="style29"><strong>Total</strong>&nbsp;</div></td>
                          <td colspan="3"><div align="right" class="style29"><?php echo $totalamount; ?>&nbsp;</div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3"><span class="style29">
                      <?php
					  //$totalamount = 1000;
	//include ('convert_currency_to_words.php');
	//echo $convertedwords = covert_currency_to_words($totalamount); //function call
	?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0" class="sample">
                        <tr>
                          <td><input name="f31" id="f31" value="<?php echo $f31; ?>" style="border: 1px solid #001E6A"  size="50"   /></td>
                        </tr>
                        <tr>
                          <td><input name="f32" id="f32" value="<?php echo $f32; ?>" style="border: 1px solid #001E6A"  size="50"   /></td>
                        </tr>
                        <tr>
                          <td><input name="f23" id="f23" value="<?php echo $f23; ?>" style="border: 1px solid #001E6A"  size="50"   /></td>
                        </tr>
                        <tr>
                          <td><textarea name="f24" cols="50" rows="5" id="f24" style="border: 1px solid #001E6A"><?php echo $f24; ?></textarea></td>
                        </tr>
                    </table></td>
                    <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="f25" id="f25" value="<?php echo $f25; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
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
                        <tr>
                          <td><input name="f26" id="f26" value="<?php echo $f26; ?>" style="border: 1px solid #001E6A"  size="20"   /></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><span class="style6">
                      <?php 
	$query7 = "select * from master_edition where status = 'ACTIVE'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$res7edition = $res7['edition'];
	if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
	{
		echo "Software by: www.simpleindia.com"; 
	}
	?>
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" align="middle" >&nbsp;</td>
                <td width="16%" align="middle" >&nbsp;</td>
                <td width="35%" align="middle" >&nbsp;</td>
              </tr>
<!--              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Upload Logo </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				<input type="file" name="imageupload1" id="imageupload1" style="border: 1px solid #001E6A"  size="20"   />
				Only JPG or JPEG image files allowed. Size Height 50 X Width 50 Pixels. </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Show Logo In Printout </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">
                    <select name="showlogo" id="showlogo" >
                      <?php
					if ($showlogo != '')
					{
					?>
                      <option value="<?php echo $showlogo; ?>" selected="selected"><?php echo $showlogo; ?></option>
                      <?php
					}
					else
					{
					?>
                      <option value="NO" selected="selected">-- Select --</option>
                      <?php
					}
					?>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>
                </div></td>
              </tr>
-->              <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Font Size F9</td>
                <td width="30%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">
				<select name="f9size" id="f9size" >
				<?php
				echo '<option value="'.$f9size.'" selected="selected">'.$f9size.'</option>';
				for ($f9size=1;$f9size<=12;$f9size++)
				{
				?>
				<option value="<?php echo $f9size; ?>"><?php echo $f9size; ?></option>
				<?php
				}
				?>
				</select>
                  (Company Title) (Standard Size -5) </div></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Letter Head Printing </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                    <select name="letterheadprinting" id="letterheadprinting" >
                      <?php
					if ($letterheadprinting != '')
					{
					?>
                      <option value="YES<?php //echo $letterheadprinting; ?>" selected="selected">YES - Print On Letter Head</option>
                      <?php
					}
					else
					{
					?>
                      <option value="" selected="selected">NO - Print On Blank Paper</option>
                      <?php
					}
					?>
                      <option value="YES">YES - Print On Letter Head</option>
                      <option value="">NO - Print On Blank Paper</option>
                    </select>
				</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Font Size F10, F11, F12 </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">
                  <select name="f27size" id="f27size" >
                    <?php
 			 		 echo '<option value="'.$f27size.'" selected="selected">'.$f27size.'</option>';
				  for ($f27size=1;$f27size<=12;$f27size++)
				  {
				   ?>
                    <option value="<?php echo $f27size; ?>"><?php echo $f27size; ?></option>
                    <?php
					}
					?>
                  </select>
                  (Header Line 1)  (Standard Size - 2)</div></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">.</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				<?php
				if ($companylogo != '')
				{
					//echo '<img src="'.$companylogo.'" height="35" width="35" border="0">';
				}
				?>
				&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Font Size F25, F26 </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="left">
                    <select name="f28size" id="f28size" >
                      <?php
 			 		 echo '<option value="'.$f28size.'" selected="selected">'.$f28size.'</option>';
				  for ($f28size=1;$f28size<=12;$f28size++)
				  {
				   ?>
                      <option value="<?php echo $f28size; ?>"><?php echo $f28size; ?></option>
                      <?php
					}
					?>
                    </select>
                  (Header Line 2)   (Standard Size - 3)</div></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Last Updated </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="dateposted" id="dateposted" value="<?php echo $dateposted; ?>" onKeyDown="return process1backkeypress1()" style="background:#999999"  size="20"  readonly="readonly" /></td>
              </tr>
              <tr>
                <td colspan="4" align="middle" >&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 
            align="left" border="1">
            <tbody>
              <tr>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="41%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input name="Submit222" type="submit"  value="Save Bill Settings" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
                </tr>
            </tbody>
          </table></td>
        </tr>
    </table>
	</form>
<script language="javascript">


</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

