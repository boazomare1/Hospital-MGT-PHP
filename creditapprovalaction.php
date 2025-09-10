<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";







if (isset($_REQUEST["user"])) { $res21username = $_REQUEST["user"]; } else { $res21username = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$frmflag2 = $_POST['frmflag2'];

if(isset($_REQUEST['ADate2'])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

      



		if(isset($_REQUEST['approved'])){

			 $mode = $_REQUEST['approved'];

			$paymentstatus = 'completed';

			

		}

		

				if(isset($_REQUEST['cashpaynow'])){

			$mode = $_REQUEST['cash'];

			$paymentstatus = 'pending';

				}

				

		foreach($_POST['oredernumber'] as $key=>$value)

		{

		 $billnumber = $_POST['oredernumber'][$key];

			

			

		$query88 = "UPDATE caftcreditorder SET status='$mode',paymentstatus='$paymentstatus' WHERE ordernumber='".$billnumber."'";

		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		header("location:caftsalescreditreport.php");

		exit;



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





function validcheck()

{

if(document.getElementById("bed").value == '')

{

alert("Please Select Bed");

document.getElementById("bed").focus();

return false;

}

if(document.getElementById("ward").value == '')

{

alert("Please Select Ward");

document.getElementById("ward").focus();

return false;

}



}









function funcvalidation()

{

//alert('h');





if(document.getElementById("requestforapproval").checked == false)

{

alert("Please Click on Request for Approval");

return false;

}



if(confirm("Are you sure of the Request?")==false){

return false;	

}



}

function funcRadio(id){

	

	if(document.getElementById("approved").id==id)

	{

	document.getElementById("cashpaynow").checked=false;

	}else if(document.getElementById("cashpaynow").id==id)

	{

	document.getElementById("approved").checked=false;

	}

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

.bali

{

text-align:right;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<form name="form1" id="form1" method="post" action="" onSubmit="return validcheck()">	

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="14">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="91%" border="0" cellspacing="0" cellpadding="0">

      

	 

	

		<tr>

		<td>



		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

             <tr>

			  <td width="68" align="center" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>

			   <td width="65" align="center" valign="center" class="bodytext31">

               <input type="hidden" name="docno" id="docno" value="" size="10" readonly></td>

			   <td width="58"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>

			   <td width="111" colspan="2"  align="left" valign="center" class="bodytext31"> 

			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>

                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>

               </td>

             </tr>

            <tr>

				 <td  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> S.no</strong></div></td>

				 <td colspan="2"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Staff Name</strong></div></td>

				<td width="111"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

				 <td width="159" colspan=""  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>

				 <td width="170"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>

				 <td width="350"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>

              </tr>

           <?php

            $colorloopcount ='';

		$sno='';

		$totalamount1='';

			$query21 = "select * from caftcreditorder where staffcode = '$res21username' and orderdate between '$ADate1' and '$ADate2'  group by ordernumber"; 

		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res21 = mysqli_fetch_array($exec21))

		  {

     	  $staffname = $res21['staffname'];

		  $totalamount = $res21['totalamount'];

		  $remarks = $res21['credittext'];

		  $updatedatetime = $res21['orderdate'];

		  $billnumber = $res21['ordernumber'];

		  

		  $totalamount1=$totalamount1+$totalamount;

		  

			 

			

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

              <td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>

              <input type="hidden" name="oredernumber[]" value="<?php echo $billnumber?>">

              <td class="bodytext31" colspan="2" valign="center"  align="left">

               <?php echo $staffname; ?></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $updatedatetime; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

               <?php echo $billnumber; ?></td>

				<td width="170"  align="left" valign="center" class="bodytext31">

              <?php echo $remarks; ?></td>

                <td width="350"  align="left" valign="center" class="bodytext31"><?php echo number_format($totalamount, 2,'.',','); ?></td>

             </tr>

		   <?php 

		   } 

		  

		   ?>

           

            <tr>

             	<td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td width="23" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

            

             	<td width="24" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

             	</tr>

          </tbody>

        </table>		</td>

		</tr>

		

		</table>		</td>

		</tr>

	

      <tr>

        <td width="4%">&nbsp;</td>

      </tr>

<!--       <tr>

        <td>&nbsp;</td>

		 <td width="3%">&nbsp;</td>

		  <td width="3%">&nbsp;</td>

		<td width="26%" align="right" valign="center" class="bodytext311">Request for Approval</td>

		<td width="29%" align="left" valign="center" class="bodytext311">

        <input type="checkbox" name="requestforapproval" id="requestforapproval" value="1">

        

        </td>

      </tr>

-->	  <tr>

<td>&nbsp;</td>

<td width="4%">&nbsp;</td>

  	<td width="11%" align="right">Approve<input onClick="funcRadio(this.id)" type="checkbox" name="approved" id="approved"  value="approved" ></td>

  	<td width="11%" align="right">Cash<input onClick="funcRadio(this.id)" type="checkbox" name="cashpaynow" id="cashpaynow"  value="cashpaynow" ></td>

	   <td width="55%"><input type="hidden" name="frmflag1" value="frmflag1" />

      <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>



</tr>

    </table>

  </table>

</form>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



