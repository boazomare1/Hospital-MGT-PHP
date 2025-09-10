<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

 ini_set('memory_limit','-1');
$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$errmsg = '';

$bgcolorcode = '';

$query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];


function readCSV($csvFile){

    $file_handle = fopen($csvFile, 'r');

    while (!feof($file_handle) ) {

        $line_of_text[] = fgetcsv($file_handle, 1024);

    }

    fclose($file_handle);

    return $line_of_text;

}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')
{	
	
	if(!empty($_FILES['upload_file']))

	{

		 $inputFileName = $_FILES['upload_file']['tmp_name'];

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {

    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		    $objPHPExcel = $objReader->load($inputFileName);

			$sheet = $objPHPExcel->getSheet(0); 

			$highestRow = $sheet->getHighestRow();

			$highestColumn = $sheet->getHighestColumn();

			$row = 1;

			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];
								

			foreach($rowData as $key=>$value)
			{

			
			 if($rowData[$key] == 'itemcode')

			 $itemcode = $key;

			 if($rowData[$key] == 'itemname')

			 $itemname = $key;
			 
			 if($rowData[$key] == 'categoryname')

			 $categoryname = $key;
			
			 if($rowData[$key] == 'Sales Price')

			 $sales_price = $key;
			 
			 if($rowData[$key] == 'baseunit')

			 $baseunit = $key;

			 if($rowData[$key] == 'incrementalquantity')

			 $incrementalquantity = $key;
			 
			  if($rowData[$key] == 'pkg')

			 $pkg = $key;

			 if($rowData[$key] == 'Income Ledger')

			 $income_ledger = $key;

			 if($rowData[$key] == 'Ledger Code')

			 $ledgercode = $key;
			 
			  if($rowData[$key] == 'wellnesspkg')

			 $wellnesspkg = $key;
		 
			}			

			for ($row = 2; $row <= $highestRow; $row++){ 

    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

				$item_code=$rowData[$itemcode ];	
								
				$item_name=$rowData[$itemname];	

				$category_name=$rowData[$categoryname];
				
				$item_name = addslashes($item_name);
		
		        $salesprice=$rowData[$sales_price];

				$base_unit=$rowData[$baseunit];
				
				$incremental_quantity=$rowData[$incrementalquantity];
				
				$package=$rowData[$pkg];
				
				$income_ledger_name=$rowData[$income_ledger];
				
				$ledger_code=$rowData[$ledgercode];
				
				$wellness_pkg=$rowData[$wellnesspkg];
				
				
				
$query188012 = "select auto_number from master_categoryservices where categoryname='$category_name' and status=''";

$exec188012 = mysqli_query($GLOBALS["___mysqli_ston"], $query188012) or die ("Error in Query188012".mysqli_error($GLOBALS["___mysqli_ston"]));

$res188012 = mysqli_fetch_array($exec188012);

$service_auto = $res188012["auto_number"];

if($service_auto=='')
{
$item_name='';
}
		
         $query2 = "select itemname from master_services where itemname = '" . $item_name . "'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		
		if ($res2 == 0 && $item_name!='') 
		{
	
			$query1 = "insert into master_services (itemcode, itemname, categoryname,rateperunit, baseunit,incrementalquantity,pkg,ipaddress,updatetime, ledgername, ledgerid,username,locationname,locationcode,wellnesspkg) 
			values ('$item_code', '$item_name', '$category_name','$salesprice', '$base_unit','$incremental_quantity','$package','$ipaddress', '$updatedatetime','$income_ledger_name', '$ledger_code','$username','$locationname','$locationcode','$wellness_pkg')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
	
				
			$query2 = "insert into audit_master_services (itemcode, itemname, categoryname,rateperunit, baseunit,incrementalquantity,pkg,ipaddress,updatetime, ledgername, ledgerid,username,locationname,locationcode,wellnesspkg) 
			values ('$item_code', '$item_name', '$category_name','$salesprice', '$base_unit','$incremental_quantity','$package','$ipaddress', '$updatedatetime','$income_ledger_name', '$ledger_code','$username','$locationname','$locationcode','$wellness_pkg')";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
	
				
				
$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="services"';
$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

while ($res25 = mysqli_fetch_array($exec25))

{

$templatename = $res25["templatename"];

$querytemp1 = "insert into `$templatename` (itemcode, itemname, categoryname,  rateperunit, ipaddress,updatetime, description,ledger_name,ledger_code) 
values ('$item_code', '$item_name', '$category_name',  '$salesprice','$ipaddress','$updatedatetime','manual','$income_ledger_name','$ledger_code')";
$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);	

			}
			
	
			
				}

   				 //  Insert row data array into your database of choice here

			}

			} catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

			}

			 $errmsg = "Success. Services Uploaded.";

	        $bgcolorcode = 'success';	

		}
		else
		{
		$errmsg = "Upload Failed.";

		$bgcolorcode = 'failed';
		}


}



/*
if (isset($_REQUEST["upload_file"])) { $upload = $_REQUEST["upload_file"]; } else { $upload = ""; }

if ($upload == 'success')
{

	$errmsg = "File Upload Completed.";

	$bgcolorcode = 'success';

}

if ($upload == 'failed')
{

	$errmsg = "File Upload Failed. Make Sure You Are Uploading TAB Delimited File.";

	$bgcolorcode = 'failed';

}*/
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

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;

}

-->

</style>

</head>

<script language="javascript">



function dataimport1verify()

{

	if (document.getElementById("uploadedfile").value == "")

	{

		alert ("Please Select The TAB Delimited File To Proceed.");

		return false;

	}

}



</script>

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

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td><form action="service_dataimport.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()">

                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Upload </strong></td>
                      

                      </tr>

                      <tr>
                    

                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#ecf0f5'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                    
                      <tr>

                    

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<span class="bodytext3"><strong><a href="uploads/upload_services.xlsx">Download The Sample File Here.</a></strong></span></td>
                        
                           <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="upload_file" id="upload_file" type="file" size="50" style="border: 1px solid #001E6A"></td>

                      </tr>

                  

                      <tr>

                        <td bgcolor="#FFFFFF" class="bodytext3"></td>

                        <td width="64%" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

                          <input type="submit" name="Submit" value="Proceed To Data Import" style="border: 1px solid #001E6A" />                        </td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="2" >&nbsp;</td>

                      </tr>

                    </tbody>

                  </table>

				  </form>

                </td>

            </tr>

            <tr>

              <td>&nbsp;</td>

            </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



