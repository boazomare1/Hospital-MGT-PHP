<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = '';   
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }
//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate1"])) { $AbDate1 = $_REQUEST["ADate1"]; } else { $AbDate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["location"])) { $locationcode = $_REQUEST["location"]; } else { $locationcode = ""; }
}
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
//$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"];
	 
$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$resfaxnumber1 = $res1['faxnumber1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$phonenumber1 = $res1['phonenumber1'];
$locationname = $res1['locationname'];
//$locationcode = $res1['locationcode'];
?>
<?php  include("print_header1.php"); ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" cellspacing="0" cellpadding="4" width="800"align="center" border="0">		  
		
			  <tr>             
				<td width="120" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>
				<td width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"> <strong>Opg.Stock</strong> </td>
				<td width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"> <strong>Receipts</strong> </td>
				<td  width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"> <strong>Issues</strong> </td>
				<td width="80" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"> <strong>Returns</strong> </td>
				<td width="150" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"> <strong>Closing Stock</strong> </td>
			</tr>
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$frmflag1 = $_REQUEST['frmflag1'];
				if ($frmflag1 == 'frmflag1')
				{
				if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
				if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
				?>
				<?php
				if($searchmedicinename != '')
				{
				$noofdays=strtotime($ADate2) - strtotime($ADate1);
				$noofdays = $noofdays/(3600*24);
				//get store for location
				$location=$locationcode;
				//$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
				$query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$locationcode."' AND me.username= '".$username."'";
				if($store!='')
				{
				$query5ll .=" and ms.storecode='".$store."'";
				}
				$exec5ll = mysqli_query($GLOBALS["___mysqli_ston"], $query5ll) or die ("Error in Query5ll".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5ll = mysqli_fetch_array($exec5ll))
				{
				$store = $res5ll["storecode"];
				$res5name = $res5ll["store"];
				//$res5department = $res5["department"];
				?>
				<tr bgcolor="">
				<td colspan="7" class="bodytext31" style="font-size:18px;"><strong><?php echo $res5name;?></strong></td>
				</tr>
				
				<?php
				$ADate1=$AbDate1;
				for($i=0;$i<=$noofdays;$i++)
				{
				if($i!=0)
				{
				$ADate1=date('Y-m-d',strtotime($ADate1) + (1*3600*24));
				 $ADate2=$ADate1;
				}
				else
				{
				 $ADate2=$ADate1;
				}
				?>
				<tr  >
				<td colspan="7" class="bodytext31"><?php echo $ADate1;?></td>
				</tr>
				<?php
				include("openingbalancecalculation.php");
				$balance = $openingbalance;
				//echo $openingbalance;
				?>
				<tr>
				<td align="left" width="160" valign="center"  class="bodytext31"><strong><?php echo $searchmedicinename; ?></strong></td>
				</tr>
				<tr>
				<td class="bodytext31" valign="center"  align="left" ><strong>Opening Balance</strong></td>
				<td align="left" valign="center"  class="bodytext31"> <strong>&nbsp;</strong> </td>
				<td align="left" valign="center"  class="bodytext31"> <strong><?php echo $openingbalance; ?></strong> </td>
				<td align="left" valign="center"  class="bodytext31"><strong>  </strong></td>
				<td align="left" valign="center"  class="bodytext31"><strong>  </strong></td>
				<td align="left" valign="center"  class="bodytext31"><strong>  </strong></td>
				<td align="left" valign="center"  class="bodytext31"><strong> <?php echo $balance; ?> </strong></td>
				</tr>
			<?php
			//echo $balance;
				
			if($store == 'all')
			{
				$query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode like '%$medicinecode%' and transaction_date between '$ADate1' and '$ADate2'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num1 = mysqli_num_rows($exec1);
				}
				else
				{
				 $query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}				
				while($res1 = mysqli_fetch_array($exec1))
				{
				 $billnumber = $res1['entrydocno'];
				$suppliername = '';
				$billdate = $res1['transaction_date'];
				$quantity = $res1['transaction_quantity'];
				$purchaseopeningstock = 0;
				$purchaseissues = 0;
				$purchasereturns = 0;
				$batch = $res1['batchnumber'];	
				$user = $res1['username'];
				
				
				$description = $res1['description'];
				$patientname = $res1['patientname'];
				$patientvisitcode = $res1['patientvisitcode'];
				$transactionfunction = $res1['transactionfunction'];
				if($description=="" && $transactionfunction=='1' && substr($billnumber,0,3)=="ADJ"){
					$description='Stock Adj Add Stock';
				}else if($description=="" && $transactionfunction=='0' && substr($billnumber,0,3)=="ADJ"){
					$description="Stock Adj Minus Stock";
				}
				if($transactionfunction=='1')
				{
					$purchaseissues = $quantity;
					$purchasereturns = 0;
					$openingbalance = $openingbalance + $quantity;
					$purchasequantity = $openingbalance;
				}
				else
				{
					$purchaseissues = 0;
					$purchasereturns = $quantity;
					$openingbalance = $openingbalance - $quantity;
					$purchasequantity = $openingbalance;
				}
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = '';
				}
				else
				{
					//echo "else";
					$colorcode = '';
				}
				
				
				?>
				<tr <?php echo $colorcode; ?>>
				<td align="left" valign="center"  class="bodytext31"><strong>
                <?php
				if($description=='Purchase'||$description=='OPENINGSTOCK')
				{ 
					$query8 = "select suppliername from master_purchase where billnumber = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$suppliername = $res8['suppliername'];
					echo  'By Purchase ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
					$purchaseissues='0';                
				}
				if($description=='Purchase Return')
				{ 
					$query8 = "select suppliername from purchasereturn_details where billnumber = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$suppliername = $res8['suppliername'];
					echo  'By Purchase Return ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
					$quantity='0';                
				}
				else if($description=='Package'||$description=='Sales'||$description=='IP Direct Sales'||$description=='IP Sales')
				{
					echo  'By Issue ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )'; 
					$purchaseissues=$purchasereturns;
					$purchasereturns='0';
					$quantity='0';     
				}
				else if($description=='IP Sales Return'||$description=='Sales Return')
				{
					echo  'By Return ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$purchasereturns=$purchaseissues;
					$purchaseissues='0';
					$quantity='0';      
				}
				else if($description=='Process')
				{
					echo  'By Process ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$purchaseissues=$purchasereturns;
					$purchasereturns='0';
					$quantity='0';     
				}
				else if($description=='Stock Damaged Minus Stock')
				{
					echo  'By Adjust -  Damaged ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0';    
				}
				else if($description=='Stock Adj Minus Stock')
				{
					echo  'By Adjust - Stk Adj Minus ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0'; 
				}
				else if($description=='Stock Adj Add Stock')
				{
					echo  'By Adjust - Stk Adj Add ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$quantity=$purchaseissues;
					$purchaseissues='0';   
				}
				else if($description=='Stock Expired Minus Stock')
				{
					echo  'By Adjust - Expired ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';  
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0';  
				}
				else if($description=='Stock Transfer From'||$description=='Stock Transfer To')
				{
					
					$query8 = "select typetransfer,fromstore,tostore,tolocationname,locationname from master_stock_transfer where docno = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$fromstore = $res8['fromstore'];
					$tostore = $res8['tostore'];
					$tolocationname = $res8['tolocationname'];
					$locationname = $res8['locationname'];					
					$typetransfer = $res8['typetransfer'];
					$query8 = "select store from master_store where storecode = '$fromstore'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$fromstorename = $res8['store'];					
					$query9 = "select store from master_store where storecode = '$tostore'";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res9 = mysqli_fetch_array($exec9);
					$tostorename = $res9['store'];
					if($typetransfer=="Consumable" || $tostorename==''){						
						$query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore'";
						$exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2a = mysqli_fetch_array($exec2a);
							$tostorename = $res2a["accountname"];
					}
					
					if($description=='Stock Transfer From')
					{  
						echo  'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
						$purchaseissues=$quantity;
						$purchasereturns='0';
						$quantity='0';
					}
					else
					{
						echo  'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
						$purchaseissues=0;
						$purchasereturns='0';
					}
					
				}
				//echo $description;
				?>
                </strong></td>
                <td align="left" valign="center"  class="bodytext31"> <strong><?php echo $batch; ?></strong> </td>
				<td align="left" valign="center"  class="bodytext31"> <strong><?php echo $purchaseopeningstock; ?></strong> </td>
                <td align="left" valign="center"  class="bodytext31"> <strong><?php echo intval($quantity); ?></strong> </td>
                <td align="left" valign="center"  class="bodytext31"> <strong><?php echo $purchaseissues; ?></strong> </td>
                <td align="left" valign="center"  class="bodytext31"> <strong><?php echo $purchasereturns; ?></strong> </td>
                <td align="left" valign="center"  class="bodytext31"> <strong><?php echo intval($purchasequantity); ?></strong> </td>
				</tr>
				<?php
				}
				
				$balance = $openingbalance;
			
				}
				}
				}
				}
				?>
			
		  </table>
<?php
    $content = ob_get_clean();
    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('pdf_stockreportbydate.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>