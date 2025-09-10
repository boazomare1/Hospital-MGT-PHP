<?php

session_start();



include ("../db/db_connect.php");

$recorddate = date('Y-m-d');

$recordtime = date('H:i:s');

$updatetime = date('Y-m-d H:i:s');

$user = $_SESSION['username'];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$action = $_REQUEST['action'];

$serialno = $_REQUEST['serialno'];

$textid = $_REQUEST['textid'];

$sortfunc = $_REQUEST['sortfunc'];

$colorloopcount='0';

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }





if (isset($_REQUEST["searchdepartmentname"])) { $searchdepartmentname = $_REQUEST["searchdepartmentname"]; } else { $searchdepartmentname = ""; }

if (isset($_REQUEST["searchdepartmentcode"])) { $searchdepartmentcode = $_REQUEST["searchdepartmentcode"]; } else { $searchdepartmentcode = ""; }

if (isset($_REQUEST["searchdepartmentanum"])) { $searchdepartmentanum = $_REQUEST["searchdepartmentanum"]; } else { $searchdepartmentanum = ""; }

		if($searchsupplieranum=='' && $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype Like '%$searchsupplieranum%' order by paymenttype limit $serialno,50";

		}

		else{

			

		if( $searchdepartmentanum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department Like '%$searchdepartmentanum%' and subtype = '$searchsupplieranum' order by paymenttype limit $serialno,50";

		}	

		

		else{

			

			if($searchsupplieranum==''){

	     $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype Like '%$searchsupplieranum%' order by paymenttype limit $serialno,50";

		}

		else{

			 $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' and department = '$searchdepartmentanum' and subtype = '$searchsupplieranum' order by paymenttype limit $serialno,50";

		}

		

		}

		

		}

	

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$auto_number = $res1["auto_number"];  

		$consultationtype = $res1["consultationtype"];

		$departmentanum = $res1["department"];

		$consultationfees = $res1["consultationfees"];

		$res1paymenttype = $res1["paymenttype"];

		$res1subtype = $res1['subtype'];

		$res1location = $res1['locationname']; 

		$res1doctorcode = $res1['doctorcode'];

		$res1doctor = $res1['doctorname'];

		

		$query = "select * from master_location where auto_number='$res1location'";

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_array($exec);

		$loc=$res['locationname'];

		

		$query2 = "select * from master_department where auto_number = '$departmentanum'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$department = $res2['department'];

		

		$query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res3 = mysqli_fetch_array($exec3);

		$res3paymenttype = $res3['paymenttype'];

		

		$query4 = "select * from master_subtype where auto_number = '$res1subtype'";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res4 = mysqli_fetch_array($exec4);

		$res4subtype = $res4['subtype'];

	

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		  

		?>

                      

                      <tr <?php echo $colorcode; ?>>

                        <td width="15" align="left" valign="top"  class="bodytext3"><div align="center">

					<a href="addconsultationtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteconsultationtype1('<?php echo $consultationtype;?>')">

					<img src="images/b_drop.png" width="8" height="11" border="0" /></a></div></td>

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $loc; ?></td>          

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>

          <td width="110" align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>

          <td width="80" align="left" valign="top"  class="bodytext3"><?php echo $res3paymenttype; ?></td>

		  <td width="180" align="left" valign="top"  class="bodytext3"><?php echo $res4subtype; ?></td>

          <td width="120" align="left" valign="top"  class="bodytext3"><?php echo $res1doctor; ?></td>

		  <td width="70" align="left" valign="top"  class="bodytext3"><?php echo $res1doctorcode; ?></td>

		  <td width="50" align="left" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td>

          <td width="30" align="left" valign="top"  class="bodytext3">

		  <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>		  </td> 

                        </tr>

                      <?php

		}

		?>