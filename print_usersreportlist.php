<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$colorloopcount=0;
$sno=0;
$description = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="UsersList.xls"');
header('Cache-Control: max-age=80');

if(isset($_REQUEST['description']))
{
 $description = $_REQUEST['description'];
}
?>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
			  <tr>
				  <td width="67" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
				  				  <td width="262"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>User Full Name </strong></td>	
                                  <td width="127"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Access Name </strong></td>
                                  <td width="203"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Description</strong></td>
                                  <td width="54"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Shift</strong></td>
                                  <td width="172"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Store </strong></td>
                                  <td width="143"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Location</strong></td>
			  </tr>					
           <?php
	    $description=trim($description);
		
		if($description == '')
			{
		$query1 = "select * from master_employee where status <> 'deleted' ORDER BY employeename "; 
		    }
			else
			{
		$query1 = "select * from master_employee where jobdescription = '$description' and status <> 'deleted' ORDER BY employeename "; 
         	}
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$res1employeename =$res1['employeename'];
		$res1accessname =$res1['username'];
		$res1store =$res1['store'];
		$res1location =$res1['location'];
		$res1shift=$res1['shift'];
		$res1description=$res1['jobdescription'];
		
		$query2 = "select * from master_store where auto_number = '$res1store' and recordstatus <> 'deleted' ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2= mysqli_fetch_array($exec2);
		$res2store =$res2['store'];
		
		$query3 = "select * from master_location where auto_number = '$res1location' and status <> 'deleted' ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3= mysqli_fetch_array($exec3);
		$res3location=$res3['locationname'];
		
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
		    <?php if($res1accessname != 'admin') { ?>
		 	<tr>
				<td width="67" align="center" valign="center" class="bodytext31"><?php echo $sno=$sno + 1; ?></td>
				<td width="262"  align="left" valign="center" class="bodytext31"><?php echo $res1employeename;  ?></td>
			    <td width="127"  align="left" valign="center" class="bodytext31"><?php echo $res1accessname; ?></td>
			    <td width="203"  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res1description); ?></td>
			    <td width="54"  align="left" valign="center" class="bodytext31"><?php echo $res1shift; ?></td>
			    <td width="172"  align="left" valign="center" class="bodytext31"><?php echo $res2store; ?></td>
			    <td width="143"  align="left" valign="center" class="bodytext31"><?php echo $res3location; ?></td>
			</tr>	
			<?php } ?>
		<?php
		}	  
		?>	
        </table>
	