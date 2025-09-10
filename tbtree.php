<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];
$GLOBALS['eal'] = 0;
$GLOBALS['ieledgers'] = 0;
$GLOBALS['revenue'] = 0;


?>

<script type="text/javascript">

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
</script>
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<link rel="stylesheet" type="text/css" href="css/simple-grid.min.css" />   
<link rel="stylesheet" href="css/jquery-simple-tree-table.css">


<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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
/* collpase table*/

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
    <td colspan="10">&nbsp;</td>
  </tr>
</table>	

<form name="cbform1" method="post" action="">
	<div class="container-full">
		<div class="row">
			<div class="col-8">
				<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">
					<tbody>
				    <tr bgcolor="#011E6A">
				      <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>TB TREE</strong></td>
				      </tr>
				    
					
				  </tbody>
				</table>
			</div>
			
	     </div>
	 </div>

<div id="tblData" class="container-full">

	<div class="row">
		<div class="col-6">
			<?php

				

			echo "<table id='collapsed' border='0' style='width: 100%;background-color:#fff;font-size: 12.5px;border:0px;' cellpadding='1' cellspacing='2'>";
			echo '<tr bgcolor="#011E6A"><td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td></tr>';

			echo "<tr style='background-color: #4fc7fd;'><td>#</td><td>Code</td> <td>Ledger</td></tr>";


				$query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where section in ('A','E')  order by section";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

				$sno = 0;
				while($res = mysqli_fetch_array($exec))
				{       
 						$sno = $sno + 1;
						$opening_dr_cr = 0;
						$opening_dr_cr1= 0;
						$transaction_dr = 0;
						$transaction_cr = 0;
						$closing_dr_cr = 0;
						 $section = $res['section'];

							$array_ledgers_ids = array();
							$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
								$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
									array_push($array_ledgers_ids, $res_ledger_ids['id']);
								}

						
								echo "<tbody>";
						 		echo "<tr style='background-color: #ecf0f5;' data-node-id='".$sno."'><td></td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td></li>";
								echo getSubgroups($res['uid'],$sno);
								
								echo "</tbody>";
				}

					
			    echo "</table>"
		       ?>
		   </div>
		   <div class="col-6">
			<?php

			   

				echo "<table id='basic' border='0' style='
				    width: 100%;background-color:#fff;
				    font-size: 12.5px;border:0px;
				' cellpadding='1' cellspacing='2'>";
					echo '<tr bgcolor="#011E6A">
	              <td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
	              </tr>';

					echo "<tr style='background-color: #4fc7fd;'><td>#</td>  <td>Code</td> <td>Ledger</td> </tr>";
				 	$query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where section in ('I','L')  order by section";
					$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sno = 0;
					while($res = mysqli_fetch_array($exec))
					{
						
						
                            $sno = $sno + 1;

							$opening_dr_cr = 0;
							$opening_dr_cr1 = 0;
							$transaction_dr = 0;
							$transaction_cr = 0;
							$closing_dr_cr = 0;
							$section = $res['section'];
							
							
								$array_ledgers_ids = array();
								$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
									$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
										array_push($array_ledgers_ids, $res_ledger_ids['id']);
									}

								
							 //echo $res['uid'];
							 echo "<tr  style='background-color: #ecf0f5;' data-node-id='".$sno."'> <td></td>  <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td></tr>";
							 //echo $res['uid'];
								echo getSubgroups($res['uid'],$sno);
		
					}
	                  
				echo "</table>";
			?>
		</div>
		
	</div>
 

</div>
</form>

<?php
function getSubgroups($account_id,$sno){

	 $subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$account_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
    
    $sno2 = 0;
	while($res = mysqli_fetch_array($exec))
	{   
		$sno2 = $sno2 + 1;
		getGroupBalance($res['uid'],$sno,$sno2);		
	}

	return $data;
}
function getAllLedgers($group_id){

	$array_data = [];

$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
	while($res = mysqli_fetch_array($exec))
	{
		$ledger_query1 = "select id as code from master_accountname where accountssub='".$res['code']."' order by auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$data = "";

			while($res1 = mysqli_fetch_array($exec1))
			{
				array_push($array_data, $res1['code']);
			}

			getAllLedgers($res['code']);
	}	

	$ledger_query1 = "select id as code from master_accountname where accountssub='$group_id' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res1 = mysqli_fetch_array($exec1))
	{
		array_push($array_data, $res1['code']);
	}


	return $array_data;

}


function getGroupBalance($group_id,$sno,$sno2){
	$data = "";
	$all_ledgers = getAllLedgers($group_id);
	//$GLOBALS['ieledgers'] = '';
	
	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where auto_number='$group_id' ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res = mysqli_fetch_array($exec))
	{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;
		$opening_dr_cr1 = 0;
		
	$query0 = " SELECT accountsmain FROM master_accountssub WHERE auto_number = '$group_id'";
	$exec0 = mysqli_query($GLOBALS["___mysqli_ston"], $query0) or die ("Error in query0".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res0 = mysqli_fetch_array($exec0);
	$accountsmain = $res0['accountsmain'];
	
	$query1 = "SELECT section FROM master_accountsmain WHERE auto_number = '$accountsmain'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$section = $res1['section'];			
		

         $uuid = $res['uid'] + 1;
		 $data .="<tr  style='background-color: aquamarine;' data-node-id=".$sno.'.'.$sno2." data-node-pid=".$sno."><td></td>  <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> </tr>";

		if($res['show_ledger']=="1"){
		 	 $data .=getLedger($res['uid'],$sno,$sno2);
		 }

	}

	echo $data;

}	


function getLedger($group_id,$sno,$sno2){
	$ledger_query = "select auto_number as uid, id as code,accountname as name from master_accountname where accountssub='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query) or die ("Error in ledger_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
    
    $sno3 = 0;
	while($res = mysqli_fetch_array($exec))
	{   
		$sno3 = $sno3 + 1;

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;
		$old_opening_dr_cr  = 0;
	
	
	
		$ledgerid = $res['code'];
		$query12 = "SELECT accountsmain FROM master_accountname WHERE id= '$ledgerid'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		$res12= mysqli_fetch_array($exec12);
		$accountsmain12 = $res12['accountsmain'];
	
			
	$query1 = "SELECT section FROM master_accountsmain WHERE auto_number = '$accountsmain12'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$section = $res1['section'];
	
		 $ledgercode = $res['code'];


		 $data .="<tr data-node-id=".$sno.'.'.$sno2.'.'.$sno3." data-node-pid=".$sno.'.'.$sno2." > <td></td><td width='14%'>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."&nbsp;"."</td></tr>";

	}

	return $data;	
}


?>

<?php include ("includes/footer1.php"); ?>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/jquery-simple-tree-table.js"></script>

<script type="text/javascript">
  $('#collapsed').simpleTreeTable({
    opened: [0]
  });

  $('#basic').simpleTreeTable({
  	opened: [0]
  });
  </script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script type="text/javascript">

</script>

<script type="text/javascript">
	$("#btnExport").click(function(e) {
  let file = new Blob([$('#tblData').html()], {type:"application/vnd.ms-excel"});

let url = URL.createObjectURL(file);

let a = $("<a />", {
  href: url,
  download: "filename.xls"
})
.appendTo("body")
.get(0)
.click();
  e.preventDefault();
});

</script>
</body>
</html>
