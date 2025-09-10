<?php
session_start();
include ("db/db_connect.php");

$updatedatetime = date("Y-m-d H:i:s");
$username = $_SESSION["username"];

if (isset($_REQUEST["confirmationcode"])) { $confirmationcode = $_REQUEST["confirmationcode"]; } else { $confirmationcode = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{
	$total_count = $_REQUEST['total_count'];
	
	$confirmationcode= $_REQUEST['confirmationcode'];

	for($i=1;$i<=$total_count;$i++)
	{

	$main_autonumber=$_REQUEST['main_autonumber'.$i];
	
	$expense=$_REQUEST['expense'.$i];
	
	$expenseno=$_REQUEST['expenseno'.$i];
	
	$older_ledgerid=$_REQUEST['older_ledgerid'.$i];
	
	$expenseanum=$_REQUEST['expenseanum'.$i];
	
	$query43="update supplier_debits set ledger_id='$expenseno' where auto_number='$main_autonumber' and invoice_id='$confirmationcode' and ledger_id='$older_ledgerid'";
	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$query431="update tb set ledger_id='$expenseno' where doc_number='$confirmationcode' and ledger_id='$older_ledgerid'";
	$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("Error in Query431".mysqli_error($GLOBALS["___mysqli_ston"])); 
	    
		}
 echo '<script>';
echo 'window.close()';
echo '</script>';
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">



<script language="javascript">
function check_response(id){
for(j=1;j<=id;j++)
{
	var expenseno=$("#expenseno"+j).val();
	if(expenseno=='')
	{
		alert("Please select the Ledger");
		$("#expenseno"+j).focus();
		return false;
		
	}
}


}
  function exp(id){
$('#expense'+id).autocomplete({

  source:'autoexpensesearch.php', 

  select: function(event,ui){

      var code = ui.item.id;

      var anum = ui.item.anum;

      $('#expenseno'+id).val(code);

      $('#expenseanum'+id).val(anum);

      },

  html: true

    });
};
</script>



<body >

<?php
$query2 = "select * from supplier_debits where invoice_id='$confirmationcode' and record_status='1'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$numLab1 = mysqli_num_rows($exec2);

if($confirmationcode!=''){

?>

<form name='form2' id='form2' action='popup_supplier_ledgerupdate.php' method='post'>

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

    

	<tr bgcolor="#011E6A">

		<td width="5%" bgcolor="#CCCCCC" class="bodytext3"><div><strong>Sno</strong></div></td>
        
        <td width="19%" bgcolor="#CCCCCC" class="bodytext3"><div><strong>Item Description</strong></div></td>

		<td width="19%" bgcolor="#CCCCCC" class="bodytext3"><strong>Ledger</strong></td>


	  </tr>

	  <?php

	 $colorloopcount = 0;
	 $crm=0;

	 while ($res2 = mysqli_fetch_array($exec2))

	{

		 $colorloopcount = $colorloopcount + 1;
		 
		 $crm=$crm+1; 

		 $showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#5fe5de"';

		}
		
	$item_name = $res2['item_name'];
	$ledger_id = $res2['ledger_id'];
	$main_autonumber = $res2['auto_number'];
	
$query1 = "select accountname,auto_number from master_accountname where id='$ledger_id'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$accountname = $res1["accountname"];

$auto_number = $res1["auto_number"];	
	?>

	<tr <?php echo $colorcode;?>>
<td colspan="" align="left" class="bodytext31" valign="middle"><?php echo $crm;?>
<input name="id<?php echo $crm;?>" type="hidden" id="id<?php echo $crm;?>" value="<?php echo $id;?>"></td>
<input name="main_autonumber<?php echo $crm;?>" type="hidden" id="main_autonumber<?php echo $crm;?>" value="<?php echo $main_autonumber;?>"></td>

<td align="left" class="bodytext31" valign="middle" style="font-size:15px"><?php echo $item_name;?>
</td>
<td align="left" class="bodytext31" valign="middle" style="font-size:15px">
<input name="expense<?php echo $crm;?>" id="expense<?php echo $crm;?>" onKeyup="return exp(<?php echo $crm;?>)" value="<?php echo $accountname;?>" size="30" rsize="40" autocomplete="off"/>
<input name="expenseno<?php echo $crm;?>" id="expenseno<?php echo $crm;?>" value="<?php echo $ledger_id;?>" type="hidden" />
<input name="older_ledgerid<?php echo $crm;?>" id="older_ledgerid<?php echo $crm;?>" value="<?php echo $ledger_id;?>" type="hidden" />
<input name="expenseanum<?php echo $crm;?>" id="expenseanum<?php echo $crm;?>" value="<?php echo $auto_number;?>" type="hidden" />
</td>

</tr>

	 <?php

	}

      ?>

	 <tr bgcolor="#011E6A">

		<td width="5%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="19%" bgcolor="#CCCCCC" class="bodytext3"></td>
      
        
		<td width="16%" bgcolor="#CCCCCC" class="bodytext3">
        <input type="hidden" id="total_count" name="total_count" value="<?php echo $crm;?>">
        <input type="hidden" id="confirmationcode" name="confirmationcode" value="<?php echo $confirmationcode;?>">
        <input type="hidden" name="frmflag2" value="frmflag2">
		<input type='submit' name='update' id='update' value='Update'></td>

	  </tr>

	

 </tbody>

</table>

</form>

<?php

}

?>

</body>

