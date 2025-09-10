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
$currentdate = date("M d, Y");
$colorloopcount  = 0;

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:''; 



if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; }else{ $cbfrmflag1 = ""; }
if(isset($_REQUEST["ADate1"])){ $reqdatefrom = $_REQUEST["ADate1"]; }else{ $reqdatefrom =  date('Y-m-d'); }
if(isset($_REQUEST["ADate2"])){ $reqdateto = $_REQUEST["ADate2"]; }else{ $reqdateto = date('Y-m-d'); }
if(isset($_REQUEST["maternityward"])){ $maternitywardname = $_REQUEST["maternityward"]; }else{ $maternitywardname =""; }
if(isset($_REQUEST["searchitemname"])){ $searchitemname = $_REQUEST["searchitemname"]; }else{ $searchitemname = ""; }
if(isset($_REQUEST["searchitemcode"])){ $searchitemcode = $_REQUEST["searchitemcode"]; }else{ $searchitemcode = ""; }
if(isset($_REQUEST["radconsumption"])){ $reportytype = $_REQUEST["radconsumption"]; }else{ $reportytype = ""; }

?>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/datetimepicker_css.js"></script> 

<!--db search for item name-->
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script language="javascript">
$(function() {
$('#searchitemname').autocomplete({
		
	source:'ajaxpharmacyitemserach.php', 
	//alert(source);
	minLength:0,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var itemcode = ui.item.itemcode;
			var itemname = ui.item.itemname;
			
			$('#searchitemcode').val(itemcode);
			$('#searchitemname').val(itemname);
			
			},
    });
});
</script>
<!--ends-->
<script type="text/javascript">
<!--validations on ward and select radio button-->
function validation()
{
  var wardval = document.getElementById("maternityward").value;
  if(wardval == '')
  {
	  alert("Please Select Any Wards");
	  document.getElementById("maternityward").focus();
	  return false;
  }
  
  var chkradioetailed = document.getElementById("detailed");
  var chkradiosummary = document.getElementById("summary");
  
  if(chkradioetailed.checked == false && chkradiosummary.checked == false)
  {
	  alert("Please Select any Report type");
			return false;
  }
  
 /* var radiosval = document.getElementsByName("radconsumption");

     for (var i = 0, len = radiosval.length; i < len; i++) 
	 {
        if (radiosval[i].checked) {
              return true;
          }
		else
		{
			alert("Please Select any Report type");
			return false;
		}
	 }*/
}
<!--ends-->
</script>
</head>


<body>
<table width="" border="0" cellspacing="0" cellpadding="2">
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
  
  <!--DESIGN FOR SEARCH IN DATE RANGE-->
  <tr>
      <td width="860">
              <form name="cbform1" id="cbform1" method="post" action="ipdrugconsumptionreport.php" onSubmit="return validation();">
              <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; margin-left:25px;">
                  <tbody>
                      <tr>
             			 <td colspan="2" bgcolor="#ecf0f5" align="left"  class="bodytext31">
                			<div align="left" ><strong>Search IP Drug Consumption</strong></div></td>
                 		 <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             			 <?php
                        if ($location!='')
                        {
							$query12 = "select locationcode,locationname from master_location where locationcode='$location' order by locationname";
							$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res12 = mysqli_fetch_array($exec12);
							
							echo $res1location = $res12["locationname"];
							 $locationcodecode = $res12["locationcode"];
                        }
                        else
                        {
							$query1 = "select locationcode,locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
							$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res1 = mysqli_fetch_array($exec1);
							
							echo $res1location = $res1["locationname"];
							$locationcode = $res1["locationcode"];
                        }
                        ?>
                 	 </td>
              	   </tr>
           		   <tr>
          			 <td width="100" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          	         <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">	
                     	<input name="ADate1" id="ADate1" value="<?php  echo $reqdatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
            			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          			<td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          			<td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           				 <input name="ADate2" id="ADate2" value="<?php echo $reqdateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
            			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span>
         			</td>
          		  </tr>
          		  <tr>
          			 <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Maternity Ward </strong></span></td>
         			 <td  colspan="3" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
                        <select name="maternityward" id="maternityward">
                       		 <option value="">--Select Ward--</option>
						   <?php
                           
                            $qryward = "SELECT auto_number,ward FROM  master_ward WHERE recordstatus<>'deleted'  AND locationcode='$locationcode' GROUP BY ward ORDER BY ward";
                            $execward = mysqli_query($GLOBALS["___mysqli_ston"], $qryward) or die ("Error in qryward".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($resward = mysqli_fetch_array($execward))
                            {
                                         $ward_auto_num = $resward["auto_number"];
                                         $wardname = $resward["ward"];
                ?>
                           <option value="<?php echo $wardname; ?>" <?php if($maternitywardname == $wardname) {?> selected <?php } ?>><?php echo $wardname; ?></option>
                  <?php         }?>
                       </select></span>
                     </td>
         		 </tr>
          		 <tr>
                 	<td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong>Item Name</strong></span></td> 
            		<td colspan="3"  width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">
                        <input id="searchitemname" name="searchitemname" value="<?php echo $searchitemname;?>" size="50">
                        <input type="hidden" id="searchitemcode" name="searchitemcode" value="">
            		</td>
          		</tr>
          		<tr>
                	<td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>Report Type</strong></td>
          			<td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="radio" id="detailed" name="radconsumption" value="raddetailed" <?php if($reportytype == 'raddetailed'){?> checked<?php } ?>><strong>Detail Report</strong></td>
            	   <td colspan="3" width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="radio" id="summary" name="radconsumption" value="radsummary" <?php if($reportytype == 'radsummary'){?> checked<?php } ?>><strong>Summary Report</strong></td>
            <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input  type="submit" value="Search" name="Submit" />
                    <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
              </tr>
            </tbody>
          </table>
        </form>		
      </td>
  </tr>
  <!--ENDS-->
  <tr><td colspan="9">&nbsp;</td></tr>
  <tr>
   
    <td colspan="8" width="" valign="top" >
    <!--DISPLAY REPORT AFTER SEARCH WITH DATE RANGE-->
    <?php
	if($cbfrmflag1 == "cbfrmflag1")
	{
		$reqdatefrom = $_REQUEST["ADate1"];
	    $reqdateto = $_REQUEST["ADate2"];
	
	    $searchitemname = $_REQUEST["searchitemname"];
		$searchitemcode = $_REQUEST["searchitemcode"];
		
		$maternitywardname = $_REQUEST["maternityward"];
		
		$reportytype = $_REQUEST["radconsumption"];
	
	//DETAILED CONSUMTION REPORT
	if($reportytype == "raddetailed")
	{
		
	?>
   <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-left:20px;">
      <tr>
      
        <td colspan="8">
        	<table style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">
          <tbody>
           	<tr>
            	<td colspan="6" valign="middle" align="center" class="bodytext33" style="background-color: #CCC"><strong>Detailed Drug Consumption Report</strong></td>
            </tr>
            <tr>
            	<td colspan="4" valign="middle" align="left" class="bodytext33" bgcolor="#FFFFFF">
              	 <strong>Maternity Ward : </strong><?php echo $maternitywardname;?>
               </td>
               <td colspan="2" valign="middle" align="right" class="bodytext33" bgcolor="#FFFFFF">
                 From <strong><?php echo $reqdatefrom; ?></strong> To <strong><?php echo $reqdateto; ?></strong>
                </td>
            </tr>
            <tr bgcolor="#999999">
            	<td valign="middle" align="left" class="bodytext33"><strong>S No.</strong></td>
            	<td valign="middle" align="left" class="bodytext33"><strong>Entry Date</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Patient Name</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Reg No</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Visit No</strong></td>
                <td valign="middle" align="center" class="bodytext33"><strong>Qty</strong></td>
            </tr>
            <?php
				$sno = 0;
				$totqnty  = 0;
				$grandtotalqnty = 0;
				
				$qryitemdetails  = "SELECT a.itemcode, a.itemname FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname LIKE '%$searchitemname%' AND a.itemcode LIKE '%$searchitemcode%' AND c.ward='$maternitywardname' GROUP BY a.itemcode ORDER BY a.itemname";
				
				$execitemdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryitemdetails) or die ("Error in qryitemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resitemdetails =  mysqli_fetch_array($execitemdetails))
				{
					$itemcodesearched = $resitemdetails["itemcode"];
					$itemnamesearched =  $resitemdetails["itemname"];
				?>
                <tr>
                	<td colspan="6" valign="middle" align="left" class="bodytext31" bgcolor="#FFFFFF"><strong><?php echo $itemnamesearched; ?></strong></td>
                </tr>
                <?php
					
				$qrydetailedreport = "SELECT a.entrydate,a.entrytime,a.patientcode, a.visitcode, a.patientname, a.categoryname, a.itemcode, a.itemname, a.quantity,b.visitcode,b.ward,c.ward FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname = '$itemnamesearched' AND a.itemcode = '$itemcodesearched' AND c.ward='$maternitywardname' GROUP BY b.ward,a.visitcode";
				
				$execdetailedreport  = mysqli_query($GLOBALS["___mysqli_ston"], $qrydetailedreport) or die ("Error in qrydetailedreport".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resdetailedreport =  mysqli_fetch_array($execdetailedreport))
				{
					$entrydate = $resdetailedreport["entrydate"];
					$entrytime = $resdetailedreport["entrytime"];
					$patientname = $resdetailedreport["patientname"];
					$patientcode = $resdetailedreport["patientcode"];
					$visitcode = $resdetailedreport["visitcode"];
					$itemcode = $resdetailedreport["itemcode"];
					$itemname = $resdetailedreport["itemname"];
					$quantity = $resdetailedreport["quantity"];
					$quantity = ceil($quantity);
					
					$totqnty = $totqnty + $quantity;
					
					$grandtotalqnty = $grandtotalqnty + $quantity;
					
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
             	<td valign="middle" align="center" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>
            	<td valign="middle" align="left" class="bodytext31"><?php echo $entrydate; ?></td>
                <td valign="middle" align="left" class="bodytext31"><?php echo $patientname; ?></td>
                <td valign="middle" align="left" class="bodytext31"><?php echo $patientcode; ?></td>
                <td valign="middle" align="left" class="bodytext31"><?php echo $visitcode; ?></td>
                <td valign="middle" align="center" class="bodytext31"><?php echo $quantity; ?></td>
            </tr>
          <?php
				}//Inner while close
				$sno = 0;
		?>		
			<tr bgcolor="#ecf0f5">
            	<td colspan="5" valign="middle" align="right" class="bodytext31"><strong>Total</strong></td>
                <td valign="middle" align="center" class="bodytext31"><strong><?php echo $totqnty;?></strong></td>
            </tr>	
          <?php 
		   $totqnty = 0;
			}//outer while close
				?>
        <tr style="background-color: #999">
            	<td colspan="5" valign="middle" align="right" class="bodytext31"><strong>Grand Total</strong></td>
                <td valign="middle" align="center" class="bodytext31"><strong><?php echo $grandtotalqnty; ?></strong></td>
                <td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden; border-left: #000"><a target="_blank" href="print_ipdrugcunsumption.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>&&maternityward=<?php echo $maternitywardname;?>&&searchitemname=<?php echo  $searchitemname;?>&&searchitemcode=<?php echo $searchitemcode;?>&&radconsumption=<?php echo $reportytype;?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
        		<td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden;"><a href="print_ipdrugcunsumption_xl.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>&&maternityward=<?php echo $maternitywardname;?>&&searchitemname=<?php echo  $searchitemname;?>&&searchitemcode=<?php echo $searchitemcode;?>&&radconsumption=<?php echo $reportytype;?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
            </tr>
          </tbody>
        </table>
        </td>
      </tr>
      <!--ENDS - DISPLAY REPORT-->
    </table>
    
    <?php
	}//ENDS DETAILED CONSUMTION REPORT
	?>
    <?php
	//IF REPORT TYPE SUMMARY 
	if($reportytype == "radsummary")
	{
	?>
		<table width="90%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-left:20px;">
      <tr>
      
        <td colspan="8">
        	<table style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" align="left" border="0">
          <tbody>
           	<tr>
            	<td colspan="3" valign="middle" align="center" class="bodytext33" style="background-color: #CCC"><strong>Drug Consumption Summary</strong></td>
            </tr>
            <tr>
            	<td  colspan="2" valign="middle" align="left" class="bodytext33" bgcolor="#FFFFFF">
              	 <strong>Ward : </strong><?php echo $maternitywardname;?>
               </td>
               <td valign="middle" align="right" class="bodytext33" bgcolor="#FFFFFF">
                 From <strong><?php echo $reqdatefrom; ?></strong> To <strong><?php echo $reqdateto; ?></strong>
                </td>
            </tr>
            <tr bgcolor="#999999">
            	<td width="40" valign="middle" align="left" class="bodytext33"><strong>S No.</strong></td>
            	<td width="250" valign="middle" align="left" class="bodytext33"><strong>Item Name</strong></td>
                <td width="100" valign="middle" align="center" class="bodytext33"><strong>Total Qnty</strong></td>
            </tr>
            <?php
				$sno = 0;
				$totqnty  = 0;
				$grandtotalqnty = 0;
				
				$qryitemdetails  = "SELECT a.itemcode, a.itemname FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname LIKE '%$searchitemname%' AND a.itemcode LIKE '%$searchitemcode%' AND c.ward='$maternitywardname' GROUP BY a.itemcode,a.itemname ORDER BY a.itemname";
				
				$execitemdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryitemdetails) or die ("Error in qryitemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resitemdetails =  mysqli_fetch_array($execitemdetails))
				{
					$itemcodesearched = $resitemdetails["itemcode"];
					$itemnamesearched =  $resitemdetails["itemname"];
					
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
                <tr  <?php echo $colorcode; ?>>
                    <td valign="middle" align="center" class="bodytext31"><?php echo $sno = $sno + 1;?></td>
                	<td valign="middle" align="left" class="bodytext31"><?php echo $itemnamesearched; ?></td>
               
                <?php
					
				$qrydetailedreport = "SELECT a.quantity FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname = '$itemnamesearched' AND a.itemcode = '$itemcodesearched' AND c.ward='$maternitywardname' GROUP BY b.ward,a.visitcode";
				
				
				$execdetailedreport  = mysqli_query($GLOBALS["___mysqli_ston"], $qrydetailedreport) or die ("Error in qrydetailedreport".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resdetailedreport =  mysqli_fetch_array($execdetailedreport))
				{
					//$itemcode = $resdetailedreport["itemcode"];
					//$itemname = $resdetailedreport["itemname"];
					$quantity = $resdetailedreport["quantity"];
					
					$totqnty = $totqnty + $quantity;
					
					$grandtotalqnty = $grandtotalqnty + $quantity;
					
		    	}//Inner while close
				
		?>		
          		<td valign="middle" align="center" class="bodytext31"><?php echo $totqnty; ?></td>
            </tr>
	      <?php 
		   $totqnty = 0;
			}//outer while close
				?>
        <tr style="background-color: #999">
            	<td colspan="2" valign="middle" align="center" class="bodytext31"><strong>Grand Total</strong></td>
                <td valign="middle" align="center" class="bodytext31"><strong><?php echo $grandtotalqnty; ?></strong></td>
                <td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden; border-left: #000">
                <a target="_blank" href="print_ipdrugcunsumption.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>&&maternityward=<?php echo $maternitywardname;?>&&searchitemname=<?php echo  $searchitemname;?>&&searchitemcode=<?php echo $searchitemcode;?>&&radconsumption=<?php echo $reportytype;?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
        		<td bgcolor="#ecf0f5" align="left" width="40" style="border: hidden;"><a href="print_ipdrugcunsumption_xl.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $reqdatefrom; ?>&&ADate2=<?php echo $reqdateto; ?>&&maternityward=<?php echo $maternitywardname;?>&&searchitemname=<?php echo  $searchitemname;?>&&searchitemcode=<?php echo $searchitemcode;?>&&radconsumption=<?php echo $reportytype;?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
            </tr>
          </tbody>
        </table>
        </td>
      </tr>
      <!--ENDS - DISPLAY REPORT-->
    </table>
    <?php
	}//ENDS SUMMARY REPORT
	
	?>
    <?php
	} //close -- if($cbfrmflag1 == "cbfrmflag1")
	?>
    </td>
   </tr> 
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

