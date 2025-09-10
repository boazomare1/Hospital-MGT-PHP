<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$docno = $_SESSION['docno'];

$username = $_SESSION['username'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;

  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if($location!='')

{

	$locationcode=$location;

	}

$data = '';

$status = '';

$searchsupplier = '';



$employee=isset($_REQUEST['employee'])?$_REQUEST['employee']:"";

$searchusername=isset($_REQUEST['searchusername'])?$_REQUEST['searchusername']:"";



if($searchusername==''){

	$searchusername = $_SESSION['username'];

}



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST[frmflag1];

/*if ($frmflag1 == 'frmflag1')

{

	$searchsupplier = $_REQUEST['searchsupplier'];

	$status = $_REQUEST['status'];

}*/



$indiatimecheck = date('d-M-Y-H-i-s');

$foldername = "dbexcelfiles";

//$checkfile = $foldername.'/SupplierList.xls';

//if(!is_file($checkfile))

//{

$tab = "\t";

$cr = "\n";



//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;



$data .= "Supplier".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;



$i=0;





$query2 = "select * from master_supplier where status like '%$status%'  order by suppliername";// desc limit 0, 100";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

$res2supplieranum = $res2['auto_number'];

$res2suppliername = $res2['suppliername'];

//$res2contactperson1 = $res2['contactperson1'];

$res2location = $res2['area'];

$res2phonenumber1 = $res2['phonenumber1'];

$res2phonenumber2 = $res2['phonenumber2'];

$res2emailid1 = $res2['emailid1'];

$res2emailid2 = $res2['emailid2'];

$res2faxnumber1 = $res2['faxnumber'];

$res2faxnumber2 = '';

$res2anum = $res2['auto_number'];

$res2address1 = $res2['address1'];

$res2address2 = $res2['address2'];

$res2city1 = $res2['city'];

$res2suppliercode = $res2['suppliercode'];



$data .= $res2suppliername. $tab . $res2location . $tab . $res2city1 . $tab . $res2phonenumber1 . $tab . $res2phonenumber2 . $tab . $res2emailid1 . $tab . $res2emailid2 . $tab . $res2faxnumber1 . $tab . $res2faxnumber2 . $tab . $res2address1 . $tab . $res2address2 . $tab. $cr;		



}			



$data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.



$fp = fopen($foldername.'/SupplierList.xls', 'w+');

fwrite($fp, $data);

fclose($fp);

if(isset($_REQUEST['fromstore'])){  $fromstore=$_REQUEST['fromstore']; }else{ $fromstore=''; }
if(isset($_REQUEST['fromstore'])){  $fromstore_post=$_REQUEST['fromstore']; }else{ $fromstore_post=''; }
if(isset($_REQUEST['tostore'])){  $tostore=$_REQUEST['tostore']; }else{ $tostore=''; }
if(isset($_REQUEST['tostore'])){  $tostore_post=$_REQUEST['tostore']; }else{ $tostore_post=''; }


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



<script src="js/datetimepicker_css.js"></script>





<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link href="css/autocomplete.css" rel="stylesheet">

<script>

$(function() {

	

$('#employee').autocomplete({

		

	source:'ajaxemployee_stock.php', 

		select: function(event,ui){

			var searchusername = ui.item.username;				

			$('#searchusername').val(searchusername);

			

			}

    });

});

	
function check_store(){
	var fromstore=$('#fromstore').val();
	var tostore=$('#tostore').val();
	if(fromstore!="" and tostore!=""){
	if(fromstore==tostore){
			alert("From and To store cannot be same");
			$('#tostore').val('');
			return false;
		}
	}
}

</script>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

</head>



<body>

<table width="1500" border="0" cellspacing="0" cellpadding="2">

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

        <td width="860">

		

		<form name="form1" id="form1" method="post" action="stockrequestsreport.php" onSubmit="return process1()">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="5" width="566" align="left" 

            border="0">

            <tbody>

              <tr bgcolor="#011e6a">

                <td class="bodytext31" bgcolor="#ecf0f5" 

                  colspan="5"><strong>Stock Requests Report </strong></td>

              </tr>

              <tr>

              <td width="92" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               

               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">

                  <?php

						$docno = $_SESSION['docno'];

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

              </tr>

			  <!-- <tr>

          <td width="92"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> By User</strong></td>

          <td  width="194" colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		  <input type="text" name="employee" id="employee" size="40">

		  <input type="hidden" id="searchusername" name="searchusername">

		  </td>

          

          </tr> -->
           
			<tr>

					<td width="92" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> From Store</strong></td>
					<td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
					<select name="fromstore" id="fromstore" onChange="return check_store();">
						<option value="">--Select Store--</option>
						<?php
								$query10 = "select * from master_store where locationcode='$res1locationanum' and recordstatus = ''";
								$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($res10 = mysqli_fetch_array($exec10))
								{
								$storecode = $res10["storecode"];
								$store = $res10["store"];
								?>
								<option value="<?php echo $storecode; ?>" <?php if(($fromstore!="") && ($fromstore==$storecode)){ echo 'selected'; } ?> ><?php echo $store; ?></option>
						                    <?php
						              }
						              ?>
					</select></td>
					<td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> To Store</strong></span></td>
					<td width="143" align="left" valign="center"  bgcolor="#ffffff">
					<select name="tostore" id="tostore" onChange="return check_store();">
						<option value="">--Select Store--</option>
						<?php
								$query102 = "select * from master_store where locationcode='$res1locationanum' and recordstatus = ''";
								$exec102 = mysqli_query($GLOBALS["___mysqli_ston"], $query102) or die ("error in query102".mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($res102 = mysqli_fetch_array($exec102))
								{
								$storecode2 = $res102["storecode"];
								$store2 = $res102["store"];
								?>
								<option value="<?php echo $storecode2; ?>" <?php if(($tostore!="") && ($tostore==$storecode2)){ echo 'selected'; } ?>><?php echo $store2; ?></option>
						                    <?php
						              }
						              ?>
					</select></td>
			</tr>

              <tr>

          <td width="92" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
          	<!-- value="<?php //echo $transactiondatefrom; ?>" -->
          	<input name="ADate1" id="ADate1"   size="10"  readonly="readonly" onKeyDown="return disableEnterKey()"
          	value="<?php if($ADate1!=''){ echo $ADate1; }else{ echo $transactiondatefrom; } ?>" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="143" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
			<!-- value="<?php //echo $transactiondateto; ?>"  -->
            <input name="ADate2" id="ADate2"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" 
            value="<?php if($ADate2!=''){ echo $ADate2; }else{ echo $transactiondateto; } ?>"/>

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                width="92" bgcolor="#FFFFFF">&nbsp;</td>

                <td valign="center"  align="left" bgcolor="#FFFFFF" colspan="4"><div align="left">

                    <input type="hidden" name="frmflag1" value="frmflag1">

					<input type="submit" value="Search" name="Submit" class="button" />

                   

                </div></td>

              </tr>

            </tbody>

        </table>

		</form>		</td>

      </tr>

      

			  <?php

			  $colorloopcount = '';

			  $loopcount = '';

			  $tranferqty = '';

			  $reqtotamount = 0;

			  $transfertotamount = 0;

			  $totamount = 0;

			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;

			if(isset($_POST['Submit']))

			{

				// $qry62 = "select username from master_internalstockrequest where date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."' and username <> '' group by username order by username";


				// $exec62 = mysql_query($qry62) or die ("Error in Qry62".mysql_error());

			 // while($res62 = mysql_fetch_array($exec62))

			 // {

			 // 	$user = $res62['username'];

				?>

				<tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1311" 

            align="left" border="0">

            <tbody>

              <tr>

                <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td class="bodytext31" bgcolor="#ecf0f5" colspan="3" ></td>

                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>

                <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>

                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

				<td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                

                </tr>

              <!-- <tr>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td align="left" valign="center" colspan="4" 

                bgcolor="#ffffff" class="bodytext31"><strong><?php echo "Requests By: ".$user."";?></strong>

				</td>

                

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

				

              </tr>
 -->
              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

                <td width="3%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Type</strong></div></td>

                <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>

               <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong> From Store </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>To Store</strong></div></td>

                <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ffffff"><strong>Date</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<strong>Time</strong>
				
				</td>
				
				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Itemcode</strong></div></td>
				

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Itemname</strong></div></td>
				
				
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Request By </strong></div></td>
				

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Request Qty </strong></div></td>


				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Transfer By </strong></div></td>
				
				
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Transfer Qty </strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Status</strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Cost </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Total Transfer Value </strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Total Request Amt</strong></div></td>

				

              </tr>

				<?php
				
				

			 // $query66 = "select *,date(updatedatetime) as entrydate from master_internalstockrequest where  username like '$user' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			 if($tostore!="" && $fromstore!='' ){  

			  $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  fromstore = '".$fromstore."' and tostore = '".$tostore."' and   date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";

			}
			elseif($fromstore!="" && $tostore==''){

				$query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  fromstore = '".$fromstore."' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";


			}elseif($fromstore=="" && $tostore!=''){

			 $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where  tostore = '".$tostore."' and date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";

			}elseif($fromstore=="" && $tostore=='' ){
			  $query66 = "SELECT *,date(updatedatetime) as entrydate from master_internalstockrequest where   date(updatedatetime) BETWEEN '".$ADate1."' and '".$ADate2."'";
			}

			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			 while($res66 = mysqli_fetch_array($exec66))

			 {

			  $itemcode = $res66['itemcode'];

			  $docno = $res66['docno'];

			  $type = $res66['typetransfer'];

			  if($type == '1')

			  {

			  $typetransfer = 'Consumable';

			  }

			  else

			  {

			   $typetransfer = 'Tranfer';

			  }

			  $fromstore_code = $res66['fromstore'];

			  $tostore_code = $res66['tostore'];

			  $loopcount=$loopcount+1;

			  

			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore_code'");

			  $res22 = mysqli_fetch_array($query22);

			  $fromstore1 = $res22['store'];

			 

			 $query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore_code'");

			  $res221 = mysqli_fetch_array($query221);

			  $tostore1 = $res221['store'];

			 

			if($typetransfer=="Tranfer" ){						

				$query2a1 = "select sum(transferquantity) as transferquantity ,username from master_stock_transfer where itemcode='$itemcode' AND requestdocno='$docno' ";

				$exec2a1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2a1) or die ("Error in Query2a1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res2a1 = mysqli_fetch_array($exec2a1);

				$tranferqty = $res2a1["transferquantity"];
				$res2a1username = $res2a1["username"];

			}

			 


			 $updatedatetime = $res66['updatedatetime'] ;
			 
			 	$res66updatetime =date('h:i a', strtotime($updatedatetime));

			  $entrydate = $res66['entrydate'];
			  
			  
			   $itemcode = $res66['itemcode'];
			   
			    $res66username = $res66['username'];

			  $itemname = $res66['itemname'];
			  

			  $transaction_quantity = $res66['quantity'];

			  $status = $res66['recordstatus'];

			  

			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res3 = mysqli_fetch_array($exec3);

			  $rate = $res3['purchaseprice'];

			  

			  $requestamount = $transaction_quantity * $rate;

			  $reqtotamount = $reqtotamount + $requestamount;

			  

			  $transferamount = $tranferqty * $rate;

			  $transfertotamount = $transfertotamount + $transferamount;

			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

			  if ($showcolor == 0)

			  {

			  	//$colorcode = 'bgcolor="#66CCFF"';

			  }

			  else

			  {

			  	$colorcode = 'bgcolor="#cbdbfa"';

			  }

			  ?>

              <tr <?php echo $colorcode; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>

                <td class="bodytext31" valign="center"  align="left">

				<div align="center"><?php echo $typetransfer;?></div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31">

                  <div align="left"><?php echo $docno;?></div>

                </div></td>

               <td class="bodytext31" valign="center"  align="left">

				<div class="bodytext31">

				  <div align="left"><?php echo $fromstore1; ?></div>

				</div></td>

                <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $tostore1; ?></div></td>

                <td class="bodytext31" valign="center"  align="center">

				  <div align="left"><?php echo $entrydate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $res66updatetime; ?>   </div></td>
				  
				  
				     <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $itemcode; ?></div></td>
				  
				  

                <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $itemname; ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left">

				  <div align="right" style="text-transform:uppercase;"><?php echo $res66username; ?></div></td>
				  

                <td class="bodytext31" valign="center"  align="left">

				  <div align="right"><?php echo $transaction_quantity; ?></div></td>
				  
				  
				  <td class="bodytext31" valign="center"  align="left">

				  <div align="right" style="text-transform:uppercase;"><?php echo $res2a1username; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				  <div align="right"><?php echo $tranferqty; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				  <div align="right"><?php echo $status; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

				<div align="right"><?php echo $rate; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				  <div align="right"><?php echo number_format($transferamount,2); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

				  <div align="right"><?php echo number_format($requestamount,2); ?></div></td>

				

              </tr>

			  <?php

			  //}

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

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5" colspan="2" ><strong>Total : </strong></td>

                <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($transfertotamount,2); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($reqtotamount,2); ?></strong></td>

                </tr>

				  </tbody>

        </table></td>

      </tr>

	  <tr>

	  <td>&nbsp;</td>

	  </tr>

				<?php

				// }

				}
				if(isset($_POST['Submit']))

			{

				 ?>

                
				<tr>

                <td colspan="13" class="bodytext31" valign="center"  align="left">

				<a target="_blank" href="print_stockrequestsreport_xl.php?fromstore=<?=$fromstore_post;?>&&tostore=<?=$tostore_post;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>

				

				<a href="print_stockrequestsreportpdf.php?fromstore=<?=$fromstore_post;?>&&tostore=<?=$tostore_post;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>" target="_blank" class="bodytext32"><img src="images25/pdfdownload.jpg" width="30" height="30"></a>
				<!-- <a href="print_stockrequestsreportpdf.php?user=<?=$searchusername;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>" target="_blank" class="bodytext32"><img src="images25/pdfdownload.jpg" width="30" height="30"></a> -->

				

				</td>

				</tr>

				<?php

				}

				?>

          

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



