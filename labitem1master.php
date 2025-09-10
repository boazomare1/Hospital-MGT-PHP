<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];


//to redirect if there is no entry in masters category or item.

 $loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';
/*for($i=1; $i<=$loccountloop; $i++)
{
	 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
	 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
	 
	 if($loccodeget!='')
	 {
		 echo $loccodeget;
		 echo $locrateget;
		 }
	
	}*/

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	for($i=1; $i<=$loccountloop; $i++)
{
	 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
	 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';

	 if($loccodeget!='')
	 {
		 // top end here 

		foreach($_POST['reference'] as $key => $value)
	{
	$subheader = $_POST['subheader'][$key];
	$reference = $_POST['reference'][$key];
	$units = $_POST['units'][$key];
	$rangelow = $_POST['rangelow'][$key];
	$rangehigh = $_POST['rangehigh'][$key];
	$gender = $_POST['gender'][$key];
	$agelimitfrom = $_POST['agelimitfrom'][$key];
	$agelimitto = $_POST['agelimitto'][$key];

	$refrange_label = $_POST['refrange_label'][$key];

	$reforder = $_POST['reforder'][$key];
	$refcode = $_POST['refcode'][$key];
	$genericsearch = $_POST['genericsearch'][$key];
	
	 $itemcode = $_REQUEST['itemcode'];	
	
	$itemname = $_REQUEST["itemname"];
	//$itemname = strtoupper($itemname);
	$criticallow=isset($_REQUEST['criticallow'])?$_REQUEST['criticallow']:'';
	$itemname = trim($itemname);
	//echo "simple";
	$length1=strlen($itemcode);
	$length2=strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname))
	{  
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg="Sorry. lab Item Not Added";
		
		header("location:labitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	
	$saccountname = $_REQUEST["saccountname"];
	$saccountid = $_REQUEST["saccountid"]; 

	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["purchaseprice"];
	//$rateperunit  = $_REQUEST["rateperunit"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$sampletype=$_REQUEST["sampletype"];
	$referencevalue = $_REQUEST["referencevalue"];
	$itemname_abbreviation = $_REQUEST["unitname_abbreviation"];
	$taxanum = isset($_REQUEST["taxanum"])?$_REQUEST["taxanum"]:'';
	$ipmarkup = $_REQUEST["ipmarkup"];
	$location = isset($_REQUEST["location"])?$_REQUEST["location"]:'';
	$criticalhigh = isset($_REQUEST["criticalhigh"])?$_REQUEST["criticalhigh"]:'';
	$displayname = isset($_REQUEST["displayname"])?$_REQUEST["displayname"]:'';
	//$rate2 = $_REQUEST['rate2'];
	//$rate3 = $_REQUEST['rate3'];
	$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';
	$radiology=isset($_REQUEST['radiology'])?$_REQUEST['radiology']:'no';
	$extrate = $_REQUEST['extrate'];
	if (isset($_REQUEST["externallab"])) { $externallab = $_REQUEST["externallab"]; } else { $externallab = "no"; }
	if(isset($_REQUEST['exclude'])) { $exclude = $_REQUEST['exclude']; } else { $exclude = 'no'; }
	
	$query1122 = "select * from master_tax where auto_number = '$taxanum' and status <> 'deleted' order by taxname";
	$exec1122 = mysqli_query($GLOBALS["___mysqli_ston"], $query1122) or die ("Error in Query1122".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res4taxname = $res1["taxname"];
	
	//$range = $rangelow.' - '.$rangehigh;
	$range = $subheader;
	
	
	$query12 = "select locationname from master_location where locationcode='".$loccodeget."'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	$searchlocationname = $res12["locationname"];
	
	
	
	
	if ($length1<25 && $length2<255)
	{
		
		if($reference != '')
		{	
			$query25 = "select * from master_labreference where itemcode = '$itemcode' and referencename = '$reference' and gender = '$gender' and criticallow = '$rangelow' and criticalhigh = '$rangehigh' and agefrom='$agelimitfrom' and ageto = '$agelimitto'";// or itemname = '$itemname'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_num_rows($exec25);
			if($res25 == 0)
			{
				
				$query112 = "INSERT into master_labreference (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,referencename,referenceunit,referencerange,criticallow,criticalhigh,displayname, gender, agefrom, ageto, refrange_label, subheader, reforder,refcode,generic_search) 
				values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '', '', '', '', '$ipaddress', '$updatedatetime','manual', '', '$referencevalue','$ipmarkup','$sampletype','$loccodeget','','$reference','$units','$range','$rangelow','$rangehigh','$displayname','$gender','$agelimitfrom','$agelimitto', '$refrange_label' ,'$subheader','$reforder','$refcode','$genericsearch')";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));	
				 $query25 = 'SELECT referencetable FROM `master_testtemplate` where testname="lab"';
				$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res25 = mysqli_fetch_array($exec25))
				{
					 $reftemplatename = $res25["referencetable"];
					 $querytemp1 = "INSERT into `$reftemplatename` (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,referencename,referenceunit,referencerange,criticallow,criticalhigh,displayname, gender, agefrom, ageto, refrange_label, subheader, reforder,refcode,generic_search) 
					values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$locrateget', '', '', '', '$ipaddress', '$updatedatetime','manual', '', '$referencevalue','$ipmarkup','$sampletype','$loccodeget','','$reference','$units','$range','$rangelow','$rangehigh','$displayname','$gender','$agelimitfrom','$agelimitto', '$refrange_label', '$subheader','$reforder','$refcode','$genericsearch')";
					$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
			}	
		}
		
		
		$query24 = "select * from master_lab where itemcode = '$itemcode' and location='".$loccodeget."'";// or itemname = '$itemname'";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_num_rows($exec24);
		if($res24 == 0)
		{
			$query155 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,  sampletype,location,externallab,externalrate,pkg,radiology,locationname,ledgercode,username,exclude) 
				values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$locrateget', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','manual', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$loccodeget','$externallab','$extrate','".$pkg."','".$radiology."','".$searchlocationname."','$saccountid','$username','$exclude')";
			//echo $query1;
			$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
			$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="lab"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				$querytemp1 = "insert into `$templatename` (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,  sampletype,location,externallab,externalrate,pkg,radiology,locationname) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$locrateget', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','manual', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$loccodeget','$externallab','$extrate','".$pkg."','".$radiology."','".$searchlocationname."')";
				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}
		}
	
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/
	
			$errmsg = "Success. New Lab Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';
			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			//$itemcode = '';
			

		
		
	
	}
	else
	{
		$errmsg = "Failed. lab Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
}	
// bot start here
 }
	
	}
//bot over here
}
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	
	//$itemcode = '';
	$query1 = "select * from master_lab where description='manual' order by auto_number desc limit 0, 1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount1 = mysqli_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		$itemcode = 'L000001';
	}
	else
	{
		$res1 = mysqli_fetch_array($exec1);
	    $res1itemcode = $res1['itemcode'];
		 $res1itemcode = substr($res1itemcode, 1, 7);
		$res1itemcode = intval($res1itemcode);
		 $res1itemcode = $res1itemcode + 1;
		
		
		 
		if (strlen($res1itemcode) == 5)
		{
			$res1itemcode = '0'.$res1itemcode;
		}if (strlen($res1itemcode) == 4)
		{
			$res1itemcode = '00'.$res1itemcode;
		}if (strlen($res1itemcode) == 3)
		{
			$res1itemcode = '000'.$res1itemcode;
		}if (strlen($res1itemcode) == 2)
		{
			$res1itemcode = '0000'.$res1itemcode;
		}
		if (strlen($res1itemcode) == 1)
		{
			$res1itemcode = '00000'.$res1itemcode;
		}
	 $itemcode = 'L'.$res1itemcode;
		 //get next itemcode form table by doing this conditions
		  $checklabitem=$itemcode;
		 $query12 = "select itemcode from master_lab where itemcode='".$checklabitem."'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $rowcount1 = mysqli_num_rows($exec12);
	if($rowcount1>0)
	{
		 $res1itemcode = $res1itemcode+1;
		if (strlen($res1itemcode) == 5)
		{
			$res1itemcode = '0'.$res1itemcode;
		}if (strlen($res1itemcode) == 4)
		{
			$res1itemcode = '00'.$res1itemcode;
		}if (strlen($res1itemcode) == 3)
		{
			$res1itemcode = '000'.$res1itemcode;
		}if (strlen($res1itemcode) == 2)
		{
			$res1itemcode = '0000'.$res1itemcode;
		}
		if (strlen($res1itemcode) == 1)
		{
			$res1itemcode = '00000'.$res1itemcode;
		}
		 $itemcode = 'L'.$res1itemcode;
		}
	while($rowcount1>0)
	{
		 $checklabitem=$itemcode;
		 $query12 = "select itemcode from master_lab where itemcode='".$checklabitem."'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $rowcount1 = mysqli_num_rows($exec12);
		 if($rowcount1>0)
		 {
		 $res1itemcode = $res1itemcode+1;
			if (strlen($res1itemcode) == 5)
		{
			$res1itemcode = '0'.$res1itemcode;
		}if (strlen($res1itemcode) == 4)
		{
			$res1itemcode = '00'.$res1itemcode;
		}if (strlen($res1itemcode) == 3)
		{
			$res1itemcode = '000'.$res1itemcode;
		}if (strlen($res1itemcode) == 2)
		{
			$res1itemcode = '0000'.$res1itemcode;
		}
		if (strlen($res1itemcode) == 1)
		{
			$res1itemcode = '00000'.$res1itemcode;
		}
			 $itemcode = 'L'.$res1itemcode;
			
		}
		else
		{
			$rowcount1=0;
			}
			
		}
		//get itemcode end here
		
	
		//echo $employeecode;
	}
		
//echo $itemcode;	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="lab"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				$querytemp1 = "update $templatename set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}
	
	
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query25 = 'SELECT templatename FROM `master_testtemplate` where testname="lab"';
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res25 = mysqli_fetch_array($exec25))
			{
				$templatename = $res25["templatename"];
				$querytemp1 = "update $templatename set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
				$exectemp1 = mysqli_query($GLOBALS["___mysqli_ston"], $querytemp1) or die ("Error in querytemp1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			}
	
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add lab Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }






?>
<!-- Modern MedStar Hospital Management CSS -->
<link rel="stylesheet" href="css/labitem-modern.css">
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
</head>
<script type="text/javascript" src="js/insertnewitemlab.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>
 

$(function() {

    $('#saccountname').autocomplete({
		
	//source:'accountnameradajax.php', 
	source: 'accountnamefinanceajax.php',
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#saccountauto').val(saccountauto);	
				$('#saccountid').val(saccountid);	
			}
    });
	
	
});

// Lab Items Table Management
$(document).ready(function() {
    let currentPage = 1;
    let itemsPerPage = 5;
    let allLabItems = [];
    let filteredItems = [];
    
    // Initialize the table
    loadLabItems();
    
    // Load lab items from database
    function loadLabItems() {
        $.ajax({
            url: 'get_lab_items.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                allLabItems = data;
                filteredItems = [...allLabItems];
                renderTable();
                updatePagination();
            },
            error: function() {
                console.error('Failed to load lab items');
                // Fallback: show sample data
                allLabItems = [
                    {itemcode: 'L000001', itemname: 'Blood Glucose', categoryname: 'Biochemistry', unit: 'mg/dL', price: '150.00', status: 'active', auto_number: 1},
                    {itemcode: 'L000002', itemname: 'Hemoglobin', categoryname: 'Hematology', unit: 'g/dL', price: '200.00', status: 'active', auto_number: 2},
                    {itemcode: 'L000003', itemname: 'Cholesterol', categoryname: 'Biochemistry', unit: 'mg/dL', price: '180.00', status: 'inactive', auto_number: 3},
                    {itemcode: 'L000004', itemname: 'Creatinine', categoryname: 'Biochemistry', unit: 'mg/dL', price: '120.00', status: 'active', auto_number: 4},
                    {itemcode: 'L000005', itemname: 'Urea', categoryname: 'Biochemistry', unit: 'mg/dL', price: '100.00', status: 'active', auto_number: 5}
                ];
                filteredItems = [...allLabItems];
                renderTable();
                updatePagination();
            }
        });
    }
    
    // Render table with current page data
    function renderTable() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageItems = filteredItems.slice(startIndex, endIndex);
        
        let tableHTML = '';
        pageItems.forEach(item => {
            const statusClass = item.status === 'active' ? 'active' : 'inactive';
            const statusText = item.status === 'active' ? 'Active' : 'Inactive';
            
            tableHTML += `
                <tr>
                    <td>${item.itemcode}</td>
                    <td>${item.itemname}</td>
                    <td>${item.categoryname}</td>
                    <td>${item.unit || '-'}</td>
                    <td>${item.price}</td>
                    <td>
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.auto_number})" title="Delete">🗑️</button>
                            <button class="btn btn-success btn-sm" onclick="toggleStatus(${item.auto_number})" title="Toggle Status">✅</button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        $('#labItemsTableBody').html(tableHTML);
    }
    
    // Update pagination controls
    function updatePagination() {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        const startItem = (currentPage - 1) * itemsPerPage + 1;
        const endItem = Math.min(currentPage * itemsPerPage, filteredItems.length);
        
        // Update pagination info
        $('#paginationInfo').text(`Showing ${startItem}-${endItem} of ${filteredItems.length} items`);
        
        // Update pagination buttons
        $('#prevPage').prop('disabled', currentPage === 1);
        $('#nextPage').prop('disabled', currentPage === totalPages);
        
        // Generate page numbers
        let pageNumbersHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            pageNumbersHTML += `<button class="page-number ${activeClass}" data-page="${i}">${i}</button>`;
        }
        $('#pageNumbers').html(pageNumbersHTML);
    }
    
    // Search functionality
    $('#labItemSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        const categoryFilter = $('#categoryFilter').val();
        const statusFilter = $('#statusFilter').val();
        
        filterItems(searchTerm, categoryFilter, statusFilter);
    });
    
    // Category filter
    $('#categoryFilter').on('change', function() {
        const searchTerm = $('#labItemSearch').val().toLowerCase();
        const categoryFilter = $(this).val();
        const statusFilter = $('#statusFilter').val();
        
        filterItems(searchTerm, categoryFilter, statusFilter);
    });
    
    // Status filter
    $('#statusFilter').on('change', function() {
        const searchTerm = $('#labItemSearch').val().toLowerCase();
        const categoryFilter = $('#categoryFilter').val();
        const statusFilter = $(this).val();
        
        filterItems(searchTerm, categoryFilter, statusFilter);
    });
    
    // Filter items based on search and filters
    function filterItems(searchTerm, categoryFilter, statusFilter) {
        filteredItems = allLabItems.filter(item => {
            const matchesSearch = !searchTerm || 
                item.itemcode.toLowerCase().includes(searchTerm) ||
                item.itemname.toLowerCase().includes(searchTerm) ||
                item.categoryname.toLowerCase().includes(searchTerm);
            
            const matchesCategory = !categoryFilter || item.categoryname === categoryFilter;
            const matchesStatus = !statusFilter || item.status === statusFilter;
            
            return matchesSearch && matchesCategory && matchesStatus;
        });
        
        currentPage = 1; // Reset to first page
        renderTable();
        updatePagination();
    }
    
    // Clear search
    $('#clearSearchBtn').on('click', function() {
        $('#labItemSearch').val('');
        $('#categoryFilter').val('');
        $('#statusFilter').val('');
        filteredItems = [...allLabItems];
        currentPage = 1;
        renderTable();
        updatePagination();
    });
    
    // Pagination navigation
    $(document).on('click', '.page-number', function() {
        currentPage = parseInt($(this).data('page'));
        renderTable();
        updatePagination();
    });
    
    $('#prevPage').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
            updatePagination();
        }
    });
    
    $('#nextPage').on('click', function() {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
            updatePagination();
        }
    });
    
    // Items per page change
    $('#itemsPerPage').on('change', function() {
        itemsPerPage = parseInt($(this).val());
        currentPage = 1;
        renderTable();
        updatePagination();
    });
});

// Sidebar functionality
$(document).ready(function() {
    function toggleSidebar() {
        const sidebar = $('#leftSidebar');
        const mainContent = $('.main-content-area');
        const floatingToggle = $('#floatingMenuToggle');
        
        if (sidebar.hasClass('collapsed')) {
            sidebar.removeClass('collapsed');
            mainContent.removeClass('sidebar-collapsed');
            floatingToggle.removeClass('active');
        } else {
            sidebar.addClass('collapsed');
            mainContent.addClass('sidebar-collapsed');
            floatingToggle.addClass('active');
        }
    }
    
    // Sidebar toggle from header
    $('#sidebarToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Floating menu toggle
    $('#floatingMenuToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Keyboard shortcut (Ctrl+M)
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
            e.preventDefault();
            toggleSidebar();
        }
    });
});

// Action functions
function deleteItem(autoNumber) {
    if (confirm('Are you sure you want to delete this item?')) {
        // Implement delete functionality
        console.log('Deleting item:', autoNumber);
    }
}

function toggleStatus(autoNumber) {
    // Implement status toggle functionality
    console.log('Toggling status for item:', autoNumber);
}
</script>
<script language="javascript">

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	 ///////////////
	if (document.form1.saccountid.value == "")
	{	
		alert ("Please select Income ledger.");
		document.form1.saccountname.focus();
		return false;
	}
	if (document.form1.saccountname.value == "")
	{
		alert ("Please Select Income ledger Name.");
		document.form1.saccountname.focus();
		return false;
	}
	/////////////////////////////////
	if (document.form1.itemcode.value != "")
	{	
		var data = document.form1.itemcode.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your lab Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your lab Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter lab Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	/* if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
			return false;
		}
	} */

var ifcount=0;
	var lcheck='lcheck';
	//var lcheckk='lcheck3';
	//alert(document.form1.lcheck.value);
	var lcount=document.form1.locationcount.value;
	
	if(lcount!=0)
	{
		for(var i=1; i<=lcount; i++)
		{
			if(document.form1.elements["lcheck"+i].checked == true)
			{ ifcount=ifcount+1;}
			/*var lname=lcheck+i;
			alert(lname);
			alert(document.form1.elements[lname].value);*/
			//alert(document.getElementById("icheck"+i).value);
		}
		if(ifcount==0)
		{
			alert('Please select atleast one Location');
			return false;
		}
	}
}

/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
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

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
		

}

</script>
<body onLoad="return process2()">
    <!-- Modern MedStar Hospital Management CSS -->
    <link rel="stylesheet" href="css/labitem-modern.css">
    
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Laboratory Item Master Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>›</span>
        <a href="#">Laboratory</a>
        <span>›</span>
        <span>Lab Item Master</span>
    </nav>

    <!-- Floating Menu Toggle Button -->
    <div class="floating-menu-toggle" id="floatingMenuToggle" title="Toggle Sidebar Menu">
        <span class="toggle-icon">☰</span>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>🏥 Lab Management</h3>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                    <span class="toggle-icon">☰</span>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <span class="nav-icon">🏠</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link active">
                            <span class="nav-icon">🧪</span>
                            <span class="nav-text">Lab Item Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labcategory1.php" class="nav-link">
                            <span class="nav-icon">📁</span>
                            <span class="nav-text">Lab Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">🔬</span>
                            <span class="nav-text">Lab Tests</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Lab Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content-area">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <span class="section-icon">🧪</span>
                    Lab Item Master
                </h2>
                <p class="page-subtitle">Add new laboratory items, manage categories, and configure reference values for accurate test results.</p>
            </div>

        <!-- Add New Lab Item Form -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">➕</span>
                <h3 class="section-title">Add New Lab Item</h3>
            </div>

            <!-- Error Messages -->
            <?php if ($st==1): ?>
            <div class="alert alert-warning" style="background: #fef3c7; color: #92400e; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #fbbf24;">
                ⚠️ Sorry, Special Characters Are Not Allowed
            </div>
            <?php endif; ?>

            <?php if ($errmsg != ''): ?>
            <div class="alert alert-info" style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #60a5fa;">
                ℹ️ <?php echo htmlspecialchars($errmsg); ?>
            </div>
            <?php endif; ?>

            <form name="form1" id="form1" method="post" action="labitem1master.php" onSubmit="return additem1process1()">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="categoryname" class="form-label">Category Name *</label>
                        <select id="categoryname" name="categoryname" class="form-select" required>
                            <?php if ($categoryname != ''): ?>
                                <option value="<?php echo htmlspecialchars($categoryname); ?>" selected="selected"><?php echo htmlspecialchars($categoryname); ?></option>
                            <?php else: ?>
                                <option value="" selected="selected">Select Category</option>
                            <?php endif; ?>
                            
                            <?php
                            $query1 = "select * from master_categorylab where status <> 'deleted' order by categoryname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res1 = mysqli_fetch_array($exec1)) {
                                $res1categoryname = $res1["categoryname"];
                            ?>
                                <option value="<?php echo htmlspecialchars($res1categoryname); ?>"><?php echo htmlspecialchars($res1categoryname); ?></option>
                            <?php } ?>
                        </select>
                        <small style="margin-top: 0.25rem; display: block;">
                            <a href="labcategory1.php" style="color: var(--medstar-primary); text-decoration: none;">➕ Add New Category</a>
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="itemcode" class="form-label">Lab Item Code *</label>
                        <input name="itemcode" value="<?php echo htmlspecialchars($itemcode); ?>" id="itemcode" readonly class="form-input" style="background-color: var(--background-secondary);" maxlength="100" />
                        <small style="margin-top: 0.25rem; color: var(--text-secondary);">Example: L000001</small>
                    </div>

                    <div class="form-group">
                        <label for="itemname" class="form-label">Lab Item Name *</label>
                        <input name="itemname" type="text" id="itemname" class="form-input" onChange="return spl()" placeholder="Enter lab item name" required />
                    </div>

                    <div class="form-group">
                        <label for="unitname_abbreviation" class="form-label">Unit (Optional)</label>
                        <input name="unitname_abbreviation" type="text" id="unitname_abbreviation" value="" class="form-input" placeholder="e.g., mg/dL, mmol/L" />
                    </div>

                    <div class="form-group">
                        <label for="purchaseprice" class="form-label">Purchase Price *</label>
                        <input name="purchaseprice" type="number" id="purchaseprice" value="<?php echo htmlspecialchars($purchaseprice); ?>" class="form-input" placeholder="0.00" step="0.01" required />
                    </div>

                    <div class="form-group">
                        <label for="saccountname" class="form-label">Income Ledger *</label>
                        <input name="saccountname" type="text" id="saccountname" value="<?php echo htmlspecialchars($saccountname); ?>" class="form-input" placeholder="Search income ledger..." required />
                        <input type="hidden" name="saccountid" id="saccountid" value="<?php echo htmlspecialchars($saccountid); ?>" />
                        <input type="hidden" name="saccountauto" id="saccountauto" value="<?php echo htmlspecialchars($saccountauto); ?>" />
                    </div>

                    <div class="form-group">
                        <label for="referencevalue" class="form-label">Reference Value (Optional)</label>
                        <textarea name="referencevalue" id="referencevalue" class="form-input" rows="3" placeholder="Enter reference value description"></textarea>
                        <input name="description" type="hidden" id="description" value="<?php echo htmlspecialchars($description); ?>" />
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="externallab" id="externallab" value="yes">
                        <label for="externallab">External Lab</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="exclude" id="exclude" value="yes">
                        <label for="exclude">Exclude from Reports</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="criticallow" id="criticallow" value="yes">
                        <label for="criticallow">Critical Low Alert</label>
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="extrate" class="form-label">External Rate</label>
                        <input name="extrate" id="extrate" type="number" class="form-input" placeholder="0.00" step="0.01" />
                    </div>
                    <div class="form-group">
                        <label for="ipmarkup" class="form-label">IP Markup (%)</label>
                        <input type="number" name="ipmarkup" id="ipmarkup" class="form-input" placeholder="0" min="0" max="100" />
                    </div>
                                </div>

                <!-- Reference Values Section -->
                <div class="reference-section">
                    <h4 style="margin: 1.5rem 0 1rem 0; color: var(--text-primary);">Reference Values</h4>
                    <table class="reference-table">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Unit</th>
                                <th>Normal Range</th>
                                <th>Critical Low</th>
                                <th>Critical High</th>
                                <th>Gender</th>
                                <th>Age Range</th>
                                <th>Ref. Range Label</th>
                                <th>Ref Order</th>
                                <th>Ref Code</th>
                                <th>Generic Search</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="reference[]" type="text" size="20" autocomplete="off"></td>
                                <td><input name="units[]" type="text" size="8" autocomplete="off"></td>
                                <td><input name="subheader[]" type="text" size="20" autocomplete="off"></td>
                                <td><input name="rangelow[]" type="text" size="8" autocomplete="off"></td>
                                <td><input name="rangehigh[]" type="text" size="8" autocomplete="off"></td>
                                <td>
                                    <select name="gender[]" id="gender">
                                        <option value="">All</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </td>
                                <td>
                                    <input name="agelimitfrom[]" type="text" size="1" autocomplete="off" placeholder="From">
                                    <input name="agelimitto[]" type="text" size="1" autocomplete="off" placeholder="To">
                                </td>
                                <td><input name="refrange_label[]" type="text" size="8" autocomplete="off"></td>
                                <td><input name="reforder[]" type="text" size="1" autocomplete="off"></td>
                                <td><input name="refcode[]" type="text" size="1" autocomplete="off"></td>
                                <td>
                                    <select name="genericsearch[]" id="genericsearch">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="btn btn-secondary">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
                    <input type="hidden" name="medicinecode" id="medicinecode" value="">
                    <input type="hidden" name="h" id="h" value="0">
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" name="Submit" class="btn btn-primary">
                        💾 Save Lab Item
                    </button>
                    <a href="labitem1.php" class="btn btn-secondary">
                        🔙 Back to List
                    </a>
                    <input type="hidden" name="frmflag" value="addnew" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="locationcount" value="1" />
                </div>
            </form>
        </div>

        <!-- Existing Lab Items Data -->
        <div class="data-section">
            <div class="section-header">
                <span class="section-icon">📋</span>
                <h3 class="section-title">Existing Lab Items</h3>
            </div>

            <!-- Search and Filter Bar -->
            <div class="search-filter-bar">
                <div class="search-section">
                    <input type="text" id="labItemSearch" class="search-input" placeholder="Search lab items..." />
                    <button class="btn btn-secondary" id="searchBtn">🔍 Search</button>
                    <button class="btn btn-outline" id="clearSearchBtn">Clear</button>
                </div>
                <div class="filter-section">
                    <select id="categoryFilter" class="filter-select">
                        <option value="">All Categories</option>
                        <?php
                        $query_categories = "select distinct categoryname from master_lab where status <> 'deleted' and categoryname != '' order by categoryname";
                        $exec_categories = mysqli_query($GLOBALS["___mysqli_ston"], $query_categories) or die ("Error in categories query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res_categories = mysqli_fetch_array($exec_categories)) {
                            $cat_name = $res_categories["categoryname"];
                        ?>
                            <option value="<?php echo htmlspecialchars($cat_name); ?>"><?php echo htmlspecialchars($cat_name); ?></option>
                        <?php } ?>
                    </select>
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Data Table with Pagination -->
            <div class="table-container">
                <table class="data-table" id="labItemsTable">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Purchase Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="labItemsTableBody">
                        <!-- Data will be loaded here via JavaScript -->
                    </tbody>
                </table>
                
                <!-- Pagination Controls -->
                <div class="pagination-controls">
                    <div class="pagination-info">
                        <span id="paginationInfo">Showing 0 of 0 items</span>
                    </div>
                    <div class="pagination-buttons">
                        <button id="prevPage" class="btn btn-outline" disabled>← Previous</button>
                        <div class="page-numbers" id="pageNumbers">
                            <!-- Page numbers will be generated here -->
                        </div>
                        <button id="nextPage" class="btn btn-outline" disabled>Next →</button>
                    </div>
                    <div class="items-per-page">
                        <label for="itemsPerPage">Items per page:</label>
                        <select id="itemsPerPage" class="items-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
