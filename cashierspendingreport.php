<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');



$searchsuppliername = "";

$totalconsultation = 0;

$totalpharma = 0;

$totallab = 0;

$totalrad = 0;

$totalser = 0;

$totalref = 0;

$res7username = '';

ini_set('max_execution_time', 300);

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

?>

<style type="text/css">

<!--

.bodytext313 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bal1

{

border-style:none;

background:none;

text-align:center;

font-weight:bold;

}

.bal

{

border-style:none;

background:none;

text-align:right;

font-size: 30px;

	font-weight: bold;

	FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

</style>


<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
  left: 0;
  top: 0;
  width: 900px; /* Full width */
  height: 100px; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */


}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #fff;
  float: right;
  font-size: 20px;
  font-weight: bold;
  border:2px solid aqua ;
  background-color: aqua;
  border-style: solid;
  border-radius: 8px;
  padding: 0px 3px 0px 3px;
  margin-right: 20px;

  /*display:block;
  box-sizing:border-box;
  width:20px;
  height:20px;
  border-width:3px;
  border-style: solid;
  border-color:red;
  border-radius:100%;
  background: -webkit-linear-gradient(-45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%), -webkit-linear-gradient(45deg, transparent 0%, transparent 46%, white 46%,  white 56%,transparent 56%, transparent 100%);
  background-color:red;
  box-shadow:0px 0px 5px 2px rgba(0,0,0,0.5);
  transition: all 0.3s ease;*/

}

.close:hover {
  color: red;
  text-decoration: none;
  cursor: pointer;
}


</style>


<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<link href="js/jquery-ui.css" rel="stylesheet">

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />    
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




function Viewvalues(id,locationcode1,fromdate,todate)
{
 //window.open("cashierspendingreportdetailed.php?visitcode=" + id+ "&&locationcode1=" + locationcode1+ "&&fromdate=" + fromdate+ "&&todate=" + todate, "Window2", 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
 data = "visitcode="+id+"&locationcode1="+locationcode1+"&fromdate="+fromdate+"&todate="+todate;
 $.ajax({		
	  type : "get",		
	  url : "cashierspendingreportdetailed.php",		
	  data : data,		
	  cache : false,		
	  timeout:30000,
	  success : function (data){	
	 //$('#items_dialog').html(data);
	 //alert(data);
	 //$('#exampleModal').html(data);
     //$("#exampleModal").modal('show');
	 // $('#myModalDept').modal('show');
	  $("#dialog1").dialog();
      $("#Schedule").html(data);
	  }
 });
}
</script>

    

<script src="js/datetimepicker_css.js"></script>

</head>

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

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><form name="cbform1" method="post" action="cashierspendingreport.php">

          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Casher Desk</strong></td>

              </tr>

            <tr>

          <td width="136" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></td>

          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>		  </td>

          </tr>
          
          <tr>

  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" >
            <option value="All">All</option>

          <?php
						

						$query01="select locationcode,locationname from master_location where status ='' order by locationname";

						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
	                    $loccode=array();
						while($res01=mysqli_fetch_array($exc01))

						{?>

							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		

						<?php 

						}

						?>

                      </select></span></td>
                      
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			  </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form></td>
        
        
        

        
        
        
        

        </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

 $fromdate=$_POST['ADate1'];

 $todate=$_POST['ADate2'];

?>

<form name="form1" id="form1" method="post" action="patienthandledby.php">	

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1226" 

            align="left" border="0">

          <tbody>

		   <tr>

              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="15" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>  

            </tr>

           <tr>

                <td width="20"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

                               <td width="173"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name </strong></td>

                               <td width="62" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>

				  <td width="66" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>

				<td width="66" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Visit Date</strong></td>

					  <td width="73" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Account Name</strong></td>

	                <td width="99" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Consultation Amount </strong></td>

                           <td width="97"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy Amount</strong></td>

                           <td width="104"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Lab Amount </td>

                           <td width="101"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Service Amount </td>

                           <td width="110"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Radiology Amount </td>

				<td width="110"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Referal Amount </td>
                
                <td width="110"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">View Detailed </td>
				
				<a target="_blank" href="excel_cashierspendingreport.php?ADate1=<?= $fromdate ?>&&ADate2=<?= $todate ?>&&location=<?= $location ?>&&cbfrmflag1=cbfrmflag1"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
           </tr>


<!--<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>-->


<div id="dialog1"  style="display:none;" >
    <div id="Schedule"  > </div>
</div>
			  <?php 
			  
			  
			  
			if($locationcode1=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$locationcode1'";
			}	

          	$qry12 = "select visitcode from (select patientvisitcode as visitcode,consultationdate as date from consultation_lab where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((copay <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                      UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_radiology where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0)))or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                      UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_services where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0)))or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                       UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_referal where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) and consultationdate between '$fromdate' and '$todate' and referalrate > 0 and $pass_location

                       UNION ALL select patientvisitcode as visitcode,recorddate as date from master_consultationpharm where ((billtype like 'pay now' and pharmacybill like 'pending' and amendstatus = '2') or (billtype like 'pay later' and pharmacybill like 'pending' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0) and amendstatus = '2')) and recorddate between '$fromdate' and '$todate'  and $pass_location

					   UNION ALL select visitcode as visitcode,consultationdate as date from master_visitentry where paymentstatus <> 'completed' and consultationdate between '$fromdate' and '$todate' and $pass_location) as viscode group by visitcode order by date ASC";

				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $qry12) or die("Error in Qry12 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res12 = mysqli_fetch_array($exec12))

				{

				$visitcode  = $res12['visitcode'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				$qrysub  = "select fxrate from master_subtype where auto_number = '$subtype'";

				$execsub = mysqli_query($GLOBALS["___mysqli_ston"], $qrysub) or die("Error in Qrysub ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$ressub = mysqli_fetch_array($execsub);

				$fxrate = $ressub['fxrate'];

				if($res1['paymentstatus'] != 'completed')

				{

				$consultationfee = $res1['consultationfees'];

				if($billtype =='PAY LATER' ){

				if( $forall = 'yes' && $planpercentage > 0)

				{

				$consultationfee  =($consultationfee*$planpercentage/100)*$fxrate;

				}

				else

				{

				$consultationfee  =($planfixedamount)*$fxrate;

				}

				}

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qrylab  = "select sum(labitemrate) as labamount from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qrylab  = "select sum(labitemrate) as labamount from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die("Error in Qrylab ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$reslab = mysqli_fetch_array($execlab);

				$labfee = $reslab['labamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$labfee = ($labfee*$planpercentage/100)*$fxrate;

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qryrad  = "select sum(radiologyitemrate) as radamount from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qryrad  = "select sum(radiologyitemrate) as radamount from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $qryrad) or die("Error in Qryrad ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resrad = mysqli_fetch_array($execrad);

				$radfee = $resrad['radamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$radfee = ($radfee*$planpercentage/100)*$fxrate;

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qryser  = "select sum(amount) as seramount from consultation_services where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qryser  = "select sum(amount) as seramount from consultation_services where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execser = mysqli_query($GLOBALS["___mysqli_ston"], $qryser) or die("Error in Qryser ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resser = mysqli_fetch_array($execser);

				$servicefee = $resser['seramount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$servicefee = ($servicefee*$planpercentage/100)*$fxrate;

				}

				

				$qrypharm  = "select sum(amount) as pharmamount from master_consultationpharm where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and pharmacybill = 'pending' and amendstatus = '2' and recorddate between '$fromdate' and '$todate'";

				$execpharm = mysqli_query($GLOBALS["___mysqli_ston"], $qrypharm) or die("Error in qrypharm ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$respharm = mysqli_fetch_array($execpharm);

				$pharmfee = $respharm['pharmamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$pharmfee = $pharmfee*$planpercentage/100;

				}

				$qryref  = "select sum(referalrate) as refamount from consultation_referal where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed'  and consultationdate between '$fromdate' and '$todate'";

				

				$execref = mysqli_query($GLOBALS["___mysqli_ston"], $qryref) or die("Error in qryref ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resref = mysqli_fetch_array($execref);

				$referalfee = $resref['refamount'];

				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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
              $name='';
			  ?>

				<tr <?php echo $colorcode; ?>>

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientfullname; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientcode; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1visitcode; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1consultationdate; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1['accountfullname']; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"> <?php echo number_format($pharmfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($labfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($servicefee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($radfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($referalfee,2,'.',','); ?></td>
                    
                <td  align="center" valign="center" class="bodytext31">
                
                <input class="open" type="button"  id="<?php echo $id; ?>" onClick="Viewvalues('<?php echo $res1visitcode; ?>','<?php echo $locationcode1; ?>','<?php echo $fromdate; ?>','<?php echo $todate; ?>')" value="View"/>
              
             <!--  <td><button class="open" id="<?php echo $id; ?>" onClick="Viewvalues('<?php echo $res1visitcode; ?>','<?php echo $locationcode1; ?>','<?php echo $fromdate; ?>','<?php echo $todate; ?>')">show first</button></td>
  <td><?php echo $name; ?></td>-->
                
          <!--       <iframe style="display:none" src="cashierspendingreportdetailed.php?locationcode1=<?php echo $locationcode1; ?>&&visitcode=<?php echo $res1visitcode; ?>&&date=<?php echo $consultationdate; ?>" width="450" height="450" frameborder="0">                  </iframe>-->
                </td>
                
          
     
				</tr>
                
<!--<div class="modal fade" id="exampleModal" class="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>-->


 
			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }

			  ?>


			<tr>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5">&nbsp;</td>

				<td  align="left" valign="center" 

				bgcolor="#ecf0f5" class="bodytext31"><strong>Grand Total :</strong></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong><?php $grandtotal = $totalconsultation +$totalpharma +$totallab +$totalrad +$totalser +$totalref ; echo number_format($grandtotal,2,'.',','); ?></strong></td>

				

				<td colspan="2" class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong>Total :</strong></td>

				

			

				<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalconsultation,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalpharma,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totallab,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalser,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalrad,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalref,2,'.',','); ?></strong></td>

			</tr>

          </tbody>

        </table>

		 </form>

		 

		 <?php

		 }

		 ?></td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>



</body>


</html>



