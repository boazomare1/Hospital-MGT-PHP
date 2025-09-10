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
			
			 if($rowData[$key] == 'Unit')

			 $unitss = $key;
			 
			 if($rowData[$key] == 'Sales Price')

			 $sales_price = $key;
			 
			 if($rowData[$key] == 'Tax %')

			 $taxname = $key;

			 if($rowData[$key] == 'Cost Price')

			$cost_price = $key;

			 if($rowData[$key] == 'packagename')

			 $packagename = $key;

			 if($rowData[$key] == 'formula')

			 $formulass = $key;
			 
			  if($rowData[$key] == 'Strength')

			 $strengthss = $key;
			 
			 if($rowData[$key] == 'genericname')

			 $genericname = $key;
			 
			 if($rowData[$key] == 'prodtype')

			 $prodtypess = $key;
			 
			 if($rowData[$key] == 'Purchase Type')

			 $purchase_type = $key;
			 
			 if($rowData[$key] == 'Cogs Name')

			 $cogs_name = $key;
			 if($rowData[$key] == 'Cogs Ledger Code')

			 $cogs_ledger_code = $key;
			 if($rowData[$key] == 'transfertype')

			 $transfertype = $key;
			 if($rowData[$key] == 'incomeledger')

			 $incomeledgerss = $key;
			 if($rowData[$key] == 'incomeledgercode')

			 $incomeledgercode = $key;
			 if($rowData[$key] == 'inventoryledgercode')

			 $inventoryledgercode = $key;
			 if($rowData[$key] == 'inventoryledgername')

			 $inventoryledgername = $key;
			 
			  if($rowData[$key] == 'Expense Ledger Name')

			 $expense_ledger_name = $key;
			 
			  if($rowData[$key] == 'Exp Ldg Code')

			 $exp_ldg_code = $key;
			 
			  if($rowData[$key] == 'producttypeid')

			 $producttypeidss = $key;
			 
			  if($rowData[$key] == 'drug_instructions')

			 $drug_instructions = $key;
			 
			 if($rowData[$key] == 'dose_measure')

			 $dose_measure = $key;
			 
			 if($rowData[$key] == 'cash_margin')

			 $cash_margin = $key;
	
				
			if($rowData[$key] == 'corporate_margin')

			 $corporate_margin = $key;
	
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

				$unit=$rowData[$unitss];
				

				//$salesprice=$rowData[$sales_price];
				$salesprice=0;

				$tax_name=$rowData[$taxname];
				
				$costprice=$rowData[$cost_price];
				
				$package_name=$rowData[$packagename];
				
				$formula=$rowData[$formulass];
				
				//$strength=$rowData[$strengthss];
				$strength=1;
								
				$generic_name=$rowData[$genericname];
				
				$prodtype=$rowData[$prodtypess];
				
				$purchasetype=$rowData[$purchase_type];
				
				$cogsname=$rowData[$cogs_name];
				
				$cogsledgercode=$rowData[$cogs_ledger_code];
				
				$transfertype=$rowData[$transfertype];
				
				$incomeledger=$rowData[$incomeledgerss];
								
				$incomeledger_code=$rowData[$incomeledgercode];
				
				$inventoryledger_code=$rowData[$inventoryledgercode];
				
				$inventory_ledgername=$rowData[$inventoryledgername];
				
				$expenseledgername=$rowData[$expense_ledger_name];
				
				$expldgcode=$rowData[$exp_ldg_code];
				
				$producttypeid=$rowData[$producttypeidss];
				
				$druginstructions=$rowData[$drug_instructions];
				
				$dosemeasure=$rowData[$dose_measure];
				$cashmargin=0;
				$corporatemargin=0;
				
				if($expenseledgername=='')
				{
					//$expenseledgername='SUPPLIES COST - PHARMACY';
				}
				if($expldgcode=='')
				{
					//$expldgcode='05-1000-7';
				}
								
				if($tax_name=='0' || $tax_name=='NIL')
				{
				$tax_name='TAX @ 0.00 %';
				$taxanum='14';
				}
				else if($tax_name=='16')
				{
				$tax_name='TAX @ 16.00 %';
				$taxanum='1';
				}
				else
				{
				$tax_name='TAX @ 0.00 %';
				$taxanum='14';	
				}

				
				$minimumstock = '1';

				$maximumstock = '1';

				/*$expenseledgercode='05-1000-1';

				$expenseledgername='Purchases Control';

				$incomeledgercode='04-1000-15';

				$incomeledgername='Medical Examinations Revenue';

				$ledgercode='05-1000-1';

				$ledgername='Purchases Control';

				$inventoryledgercode='02-1300-1';

				$inventoryledgername='INVENTORY IN HAND';*/
				
				$res4packagename='1S';
				
				$pkg='';
				
				$exclude='';
				
				$rol='1';
				
				$roq ='1';
				
				$ipmarkup='0.00';
				
				$spmarkup='0.00';
				
				//$formula='INCREMENT';
				
				$disease='';
				
				$markup='0';
				
 $query18801 = "select id from dose_measure where id='$dosemeasure' and status='1'";

$exec18801 = mysqli_query($GLOBALS["___mysqli_ston"], $query18801) or die ("Error in Query18801".mysqli_error($GLOBALS["___mysqli_ston"]));

$res18801 = mysqli_fetch_array($exec18801);

$dose = $res18801["id"];

$query188012 = "select id from drug_instructions where id='$druginstructions' and status='1'";

$exec188012 = mysqli_query($GLOBALS["___mysqli_ston"], $query188012) or die ("Error in Query188012".mysqli_error($GLOBALS["___mysqli_ston"]));

$res188012 = mysqli_fetch_array($exec188012);

$druginstructions = $res188012["id"];


if($categoryname=='')
{
$item_name='';
}


$query128 = "select * from master_categorypharmacy where status <> 'deleted' and categoryname='$category_name' order by categoryname";
$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query188".mysqli_error($GLOBALS["___mysqli_ston"]));

$res128 = mysqli_num_rows($exec128);
if($res128 == 0)
{
	$item_name='';
}
$expiryperiod='';
$transfertype=1;				
            $query2 = "select itemname from master_medicine where itemname = '" . $item_name . "'";
		
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		
		if ($res2 == 0 && $item_name!='') 
		{
	
			 	  $query1 = "insert into master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,purchaseprice, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, rateperunit,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,drug_instructions,dose_measure) 
			values ('$item_code', '$item_name', '$category_name', '$res4packagename','$res4packagename', '$costprice', '$expiryperiod', '$taxanum', '$tax_name', '$ipaddress', '$updatedatetime','', '$salesprice','$pkg','$generic_name','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$purchasetype','$producttypeid','$cogsname','$cogsledgercode','','$transfertype','','$incomeledger_code','$incomeledger','$inventoryledger_code','$inventory_ledgername','$expldgcode','$expenseledgername','$druginstructions','$dose')";



			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

			$sqlquerymap = "INSERT INTO master_itemmapsupplier(itemcode, suppliercode, rate, supplier_autoid,fav_supplier) VALUES ('$item_code','03-1500-91','$costprice','98','1')";
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);

			$fields = array();
			$queryChk = "SHOW COLUMNS FROM master_medicine";
			$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die("Error in queryChk" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($x = mysqli_fetch_assoc($execchk)) {

				if (stripos($x['Field'], "subtype_") !== false) {
					$fieldname = $x['Field'];
					$query1 = "update master_medicine set $fieldname='$salesprice' where itemcode='$item_code'";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
			
	
	//audit 1 loop start

			$query2 = "select * from audit_master_medicine where itemcode = '$item_code'"; // or itemname = '$itemname'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_num_rows($exec2);
			if ($res2 == 0) {
				$query1 = "insert into audit_master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,purchaseprice, expiryperiod, taxanum, taxname, ipaddress, updatetime, description,rateperunit,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,username,locationname,locationcode,auditstatus,from_table) 
			values ('$item_code', '$item_name', '$category_name', '$res4packagename','$res4packagename', '$costprice', '$expiryperiod', '$taxanum', '$tax_name', '$ipaddress', '$updatedatetime','', '$salesprice','$pkg','$generic_name','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$purchasetype','$producttypeid','$cogsname','$cogsledgercode','','$transfertype','','$incomeledger_code','$incomeledger','$inventoryledger_code','$inventory_ledgername','$expldgcode','$expenseledgername','$username','$locationname','$locationcode','i','master_medicine')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));

				$subtypedata = '';
				$fields = array();
				$queryChk = "SHOW COLUMNS FROM audit_master_medicine";
				$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die("Error in queryChk" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($x = mysqli_fetch_assoc($execchk)) {

					if (stripos($x['Field'], "subtype_") !== false) {

						$fieldname = $x['Field'];
						if ($subtypedata != '') {
							$subtypedata = $subtypedata . ',';
						}
						$subtypedata = $subtypedata . "$fieldname='$salesprice'";
					}
				}

				$query1 = "update audit_master_medicine set $subtypedata where itemcode='$item_code'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
			}

			//audit 1 loop end 	
			
			
			$query2 = "insert into master_itempharmacy (itemcode, itemname, categoryname, unitname_abbreviation, packagename,purchaseprice, expiryperiod, taxanum, taxname, ipaddress, updatetime, description,rateperunit, pkg, genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername) 
			values ('$item_code', '$item_name', '$category_name', '$res4packagename','$res4packagename', '$costprice', '$expiryperiod', '$taxanum', '$tax_name', '$ipaddress', '$updatedatetime','', '$salesprice','$pkg','$generic_name','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$purchasetype','$producttypeid','$cogsname','$cogsledgercode','','$transfertype','','$incomeledger_code','$incomeledger','$inventoryledger_code','$inventory_ledgername','$expldgcode','$expenseledgername')";
				
			
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

			// update pharmacy rate and subtypes

			// select pharmacy rate templates
			$sql_pharma_rate = "SELECT * FROM pharma_rate_template WHERE recordstatus <> 'deleted'";
			$exec_pharma_rate = mysqli_query($GLOBALS["___mysqli_ston"], $sql_pharma_rate) or die("Error in Query_pharma_rate" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res_pharma_rate = mysqli_fetch_array($exec_pharma_rate)) {
				$temp_id = $res_pharma_rate['auto_number'];
				$markup = $res_pharma_rate['markup'];
					if($temp_id==1)
					{
					$markup=$cashmargin;
					}
					if($temp_id==2)
					{
					$markup=$corporatemargin;
					}
				$margin = $markup;
				$item_id = $item_code;
				$item_price = (float)$costprice;

				$var_price = (($margin / 100) * $item_price);
				$new_price = ($item_price + $var_price);
				if($markup==0)
				{
					$new_price=0;
				}
				$date = date("Y-m-d");

				//insert new row in template rate mapping
				$sqlquerymap = "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus,margin) VALUES ('$temp_id','$item_id','$new_price','$username','$date','','$margin')";
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);

				//check subtypes linked // if any update values
				$array_subtype = array();
				$query_st = "SELECT * FROM master_subtype WHERE pharmtemplate = '$temp_id' ";
				$exec_st = mysqli_query($GLOBALS["___mysqli_ston"], $query_st) or die("Error in Query_st" . mysqli_error($GLOBALS["___mysqli_ston"]));
				$count = 0;
				$col = "";
				while ($res_st = mysqli_fetch_array($exec_st)) {
					$count++;
					$subtype = $res_st['auto_number'];

					if ($count > 1) {
						$col .= ',';
					}

					$col .= 'subtype_' . $subtype . " = " . $new_price;
				}
				// update master med
				$sqlquery_st_med = "UPDATE master_medicine SET $col WHERE itemcode = '$item_id'";
				//echo $sqlquery_st_med.'<br>';
				$exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);


				$sqlquery_st_med1 = "UPDATE audit_master_medicine SET $col WHERE itemcode = '$item_id'";
				//echo $sqlquery_st_med.'<br>';
				$exequery_st_med1 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med1);
			}		
		
 
				}

   				 //  Insert row data array into your database of choice here

			}

			} catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

			}

				

		}


}





/*if ($frmflag1 == 'frmflag1')

{

	$user=$profileid;

	$date=date('ymd');

	$uploaddir="tab_file_dump";

	$final_filename=$username."_tabdump.txt";

	$photodate = date('y-m-d');

	$photoid = $user.$date;

	

	$fileformat = basename( $_FILES['uploadedfile']['name']);

	$fileformat = substr($fileformat, -3, 3);

	if ($fileformat == 'txt')

	{

		$uploadfile123 = $uploaddir . "/" . $final_filename;

		$target_path = $uploadfile123;

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 

		{

			header ("location:pharmacydataimport1.php?upload=success");

		}

		else

		{

			header ("location:pharmacydataimport.php?upload=failed");

		}

	

	} 

	else

	{

			header ("location:pharmacydataimport.php?upload=failed");

	}

	

}
*/


if (isset($_REQUEST["upload_file"])) { $upload = $_REQUEST["upload_file"]; } else { $upload = ""; }

//$upload = $_REQUEST['upload'];

//echo $upload;

if ($upload == 'success')

{

	$errmsg = "File Upload Completed.";

	$bgcolorcode = 'success';

}

if ($upload == 'failed')

{

	$errmsg = "File Upload Failed. Make Sure You Are Uploading TAB Delimited File.";

	$bgcolorcode = 'failed';

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

              <td><form action="pharmacydataimport.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()">

                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Item Upload </strong></td>

                      </tr>

                      <tr>

                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

                    
                      <tr>

                    

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<span class="bodytext3"><strong><a href="uploads/upload_medicine.xlsx">Download The Sample File Here.</a></strong></span></td>
                        
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



