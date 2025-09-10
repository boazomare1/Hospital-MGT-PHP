<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');  
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION['username'];

if (isset($_REQUEST["grn"])) { $grn = $_REQUEST["grn"]; } else { $grn = ""; }


?>
<?php

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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
float:right;
}
-->
</style>




    
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<?php 
$query1 = "select auto_number from purchase_details where billnumber = '$grn'";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
					$resnw1=mysqli_num_rows($exec1);
?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
  <tr><td colspan="1"></td>
  <td colspan="9">
  		</td>
  </tr>
  <tr><td colspan="9">&nbsp;</td></tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td>
        	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>View GRN Details</strong>
                  <label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
              <tr>
               <td bgcolor="#ffffff"  align="center"   class="bodytext31"><div align="center"><strong>Medicine Name</strong></div></td>
        <td bgcolor="#ffffff"   align="center"   class="bodytext31"><div align="center"><strong>Batch No</strong></div></td>
        <td bgcolor="#ffffff"   align="center"   class="bodytext31"><div align="center"><strong>EXP Dt</strong></div></td>
        <td bgcolor="#ffffff"   align="center"  class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
        <td bgcolor="#ffffff"   align="center"   class="bodytext31"><div align="center"><strong>Pur.Qty</strong></div></td>
        <td bgcolor="#ffffff"   align="center"   class="bodytext31"><div align="center"><strong>Tot.Qty</strong></div></td>
        <td bgcolor="#ffffff"   align="center"   class="bodytext31"><div align="center"><strong>Bonus</strong></div></td>
        <td bgcolor="#ffffff"   align="right"   class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
      	<td bgcolor="#ffffff" width="60"   align="center"   class="bodytext31"><div align="right"><strong>Discount %</strong></div></td>
        <td bgcolor="#ffffff"   align="right" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
        
              
              	             
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			$grandtotalamount = 0;
			$totaldiscount = 0;
			$totalamount = 0;
			$temp = 0;
			
			$query77 = "select billnumber from master_purchase where mrnno = '$grn'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$billno = $res77['billnumber'];
			
			$query11 = "select * from purchase_details where billnumber = '$billno' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			 {
			$res11itemname= $res11['itemname'];
			$res11quantity = $res11['quantity'];
			//$res11itemquantity = $res11['itemquantity'];
			$res11itemfreequantity = $res11['itemfreequantity'];
			$res11batchnumber = $res11['batchnumber'];
			$res11expirydate = $res11['expirydate'];
			$res11packagename= $res11['packagename'];
			$res11itemfreequantity= $res11['itemfreequantity'];
			$res11itemtotalquantity= $res11['itemtotalquantity'];
			$res11allpackagetotalquantity= $res11['allpackagetotalquantity'];
			$res11quantityperpackage= $res11['quantityperpackage'];
			$res11rate= $res11['rate'];
			$res11totalamount= $res11['totalamount'];
			$res11discountpercentage= $res11['discountpercentage'];
			$res11itemtaxpercentage= $res11['itemtaxpercentage'];
			$res11subtotal= $res11['subtotal'];
			$res11costprice= $res11['costprice'];
			$res11salesprice= $res11['salesprice'];
			$res11ponumber= $res11['ponumber'];
			$amount = $res11costprice * $res11itemtotalquantity;
			$grandtotalamount = $grandtotalamount + $res11totalamount;
			
			$temp = $res11allpackagetotalquantity - $res11itemfreequantity;
			$temp = $temp*$res11rate;
			$totalamount += $amount;
			
			
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
        <td class="bodytext31"  align="center"><?php echo $res11itemname; ?></td>
        <td class="bodytext31" align="center"><?php echo $res11batchnumber; ?></td>
        <td class="bodytext31"  align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>
        <td class="bodytext31" align="center"><?php echo $res11packagename; ?></td>
        <td class="bodytext31" align="center"><?php echo $res11itemtotalquantity; ?></td>
        <td class="bodytext31"  align="center"><?php echo $res11allpackagetotalquantity; ?></td>
        <td class="bodytext31"  align="center"><?php echo $res11itemfreequantity; ?></td>
        <td class="bodytext31"  align="right"><?php echo number_format($res11costprice,2,'.',','); ?></td>
        <td class="bodytext31"  align="right"><?php echo $res11discountpercentage; ?></td>
        <td class="bodytext31"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
    </tr>
           
			  <?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			 
              </tr><?php ?>
          </tbody>
        </table>
        </td>
    </tr>
      <tr>
	 
            
            
            
        <td>
        
        
       

        
        
        
        </td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	  
	  
	   </td>
	  </tr>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>

</body>
</html>













