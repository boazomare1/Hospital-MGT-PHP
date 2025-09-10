<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$docno = $_SESSION['docno'];

$username = $_SESSION['username'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;

  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if($location!='')

{
  $locationcode=$location;

  }

$data = '';

$status = '';

$searchsupplier = '';



$fromstore=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:"";

$tostore=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:"";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST[frmflag1];

/*if ($frmflag1 == 'frmflag1')

{

  $searchsupplier = $_REQUEST['searchsupplier'];

  $status = $_REQUEST['status'];

}*/



$indiatimecheck = date('d-M-Y-H-i-s');

$foldername = "dbexcelfiles";

//$checkfile = $foldername.'/SupplierList.xls';

//if(!is_file($checkfile))

//{

$tab = "\t";

$cr = "\n";



//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;



$data .= "Supplier".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;



$i=0;





$query2 = "select * from master_supplier where status like '%$status%'  order by suppliername";// desc limit 0, 100";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

$res2supplieranum = $res2['auto_number'];

$res2suppliername = $res2['suppliername'];

//$res2contactperson1 = $res2['contactperson1'];

$res2location = $res2['area'];

$res2phonenumber1 = $res2['phonenumber1'];

$res2phonenumber2 = $res2['phonenumber2'];

$res2emailid1 = $res2['emailid1'];

$res2emailid2 = $res2['emailid2'];

$res2faxnumber1 = $res2['faxnumber'];

$res2faxnumber2 = '';

$res2anum = $res2['auto_number'];

$res2address1 = $res2['address1'];

$res2address2 = $res2['address2'];

$res2city1 = $res2['city'];

$res2suppliercode = $res2['suppliercode'];



$data .= $res2suppliername. $tab . $res2location . $tab . $res2city1 . $tab . $res2phonenumber1 . $tab . $res2phonenumber2 . $tab . $res2emailid1 . $tab . $res2emailid2 . $tab . $res2faxnumber1 . $tab . $res2faxnumber2 . $tab . $res2address1 . $tab . $res2address2 . $tab. $cr;   



}     



$data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.



$fp = fopen($foldername.'/SupplierList.xls', 'w+');

fwrite($fp, $data);

fclose($fp);



?>

<style type="text/css">

<!--

body {

  margin-left: 0px;

  margin-top: 0px;

  background-color: #ecf0f5;

}

.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">

window.onload = function()

{

  funcSelectFromStore();

}

function process1()

{

  /*if (document.form1.fromstore.value == "")

  {

    alert("Select From Store");

    document.form1.fromstore.focus();

    return false;

  }

  if (document.form1.tostore.value == "")

  {

    alert("Select To Store");

    document.form1.tostore.focus();

    return false;

  }*/

  if (document.form1.fromstore.value!='' && document.form1.tostore.value!='' && (document.form1.fromstore.value) == (document.form1.tostore.value))

  {

    alert("From and To store cannot be same");

    document.form1.tostore.value = "";

    document.form1.tostore.focus();

    return false;

  }

}



function funcSelectFromStore(id)

{ 

  <?php 

  $query12 = "select * from master_location where status <> 'deleted'";

  $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

  while ($res12 = mysqli_fetch_array($exec12))

  {

  $res12anum = $res12["auto_number"];

  $res12locationcode = $res12["locationcode"];

  ?>

  if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")

  {

    document.getElementById("fromstore").options.length=null; 

    var combo = document.getElementById('fromstore'); 

    document.getElementById("tostore").options.length=null; 

    var comboto = document.getElementById('tostore');   

    <?php

    $loopcount=0;

    ?>

    combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 

    comboto.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 

    <?php

    $query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";

    $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

    while ($res10 = mysqli_fetch_array($exec10))

    {

    $loopcount = $loopcount+1;

    $res10anum = $res10["storecode"];

    $res10store = $res10["store"];

    ?>

    var newOptionfm = document.createElement('option');

    newOptionfm.text = "<?php echo $res10store;?>";

    newOptionfm.value = "<?php echo $res10anum;?>";

    if(newOptionfm.value == "<?php echo $fromstore; ?>"){

    newOptionfm.selected = "selected";}

    document.getElementById("fromstore").options.add(newOptionfm, null);

    

    var newOption = document.createElement('option');

    newOption.text = "<?php echo $res10store;?>";

    newOption.value = "<?php echo $res10anum;?>";

    if(newOption.value == "<?php echo $tostore; ?>"){

    newOption.selected = "selected";}

    document.getElementById("tostore").options.add(newOption, null);

      //combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 

      //comboto.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 

    <?php 

    }

    ?>

  }

  <?php

  }

  ?>

} 

function loadprintpage1(canum)

{

  var varcanum = canum;

  //alert (varqanum);

  window.open("print_renewal1.php?canum="+varcanum+"","Window"+varcanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

  //window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}



</script>

<script src="js/datetimepicker_css.js"></script>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

</head>



<body>

<table width="1500" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

    

    <form name="form1" id="form1" method="post" action="stocktransferreport.php" onSubmit="return process1()">

    <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="5" width="566" align="left" 

            border="0">

            <tbody>

              <tr bgcolor="#011e6a">

                <td class="bodytext31" bgcolor="#ecf0f5" 

                  colspan="5"><strong>Stock Transfer Report </strong></td>

              </tr>

              <tr>

              <td width="92" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               

               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">

                  <?php

            $docno = $_SESSION['docno'];

            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

            while ($res1 = mysqli_fetch_array($exec1))

            {

            $res1location = $res1["locationname"];

            $res1locationanum = $res1["locationcode"];

            ?>

            <option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

            <?php

            }

            ?>

                  </select>

              </span></td>

              </tr>
              <tr>
                  <td align="left" valign="center"  
                        bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
                  <td colspan="1" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
                    <select name="categoryname" id="categoryname">
                    <?php
              $categoryname_s = $_REQUEST['categoryname'];
              if ($categoryname_s != '')
              {
              ?>
                    <option value="<?php echo $categoryname_s; ?>" selected="selected"><?php echo $categoryname_s; ?></option>
                    <option value="">Show All Category</option>
                    <?php
              }
              else
              {
              ?>
                    <option selected="selected" value="">Show All Category</option>
                    <?php
              }
              ?>
                    <?php
              $query42 = "select categoryname from master_medicine where status = '' group by categoryname order by categoryname";
              $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($res42 = mysqli_fetch_array($exec42))
              {
              $categoryname = $res42['categoryname'];
              ?>
                    <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
                    <?php
              }
              ?>
                  </select></td>
         <?php if(isset($_REQUEST['tranfer_type'])){  $tranfer_type=$_REQUEST['tranfer_type']; }else{ $tranfer_type=''; } ?>
                  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Type</strong></td>
                  <td colspan="1" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
                    <select name="tranfer_type" id="tranfer_type">
                     <option value="">All</option>
                     <option value="Transfer" <?php  if($tranfer_type=='Transfer'){ echo 'Selected'; } ?>>Transfer</option>
                     <option value="Consumable" <?php if($tranfer_type=='Consumable'){ echo 'Selected'; } ?>>Consumable</option>
                  </select></td>
        </tr>

        

        <tr>

          <td width="92" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> From Store</strong></td>

          <td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

      <select name="fromstore" id="fromstore"></select></td>

          <td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> To Store</strong></span></td>

          <td width="143" align="left" valign="center"  bgcolor="#ffffff">

      <select name="tostore" id="tostore"></select></td>

          </tr>

              <tr>

          <td width="92" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td  width="194" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php if(isset($_REQUEST['ADate1'])){ echo $ADate1; }else{ echo $transactiondatefrom; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>      </td>

          <td width="97" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="143" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php if(isset($_REQUEST['ADate2'])){ echo $ADate2; }else{ echo $transactiondateto; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

      </span></td>

          </tr>

              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                width="92" bgcolor="#FFFFFF">&nbsp;</td>

                <td valign="center"  align="left" bgcolor="#FFFFFF" colspan="4"><div align="left">

                    <input type="hidden" name="frmflag1" value="frmflag1">

          <input type="submit" value="Search" name="Submit" class="button" />

                   

                </div></td>

              </tr>

            </tbody>

        </table>

    </form>   </td>

      </tr>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1311" 

            align="left" border="0">

            <tbody>

              <tr>

                <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td class="bodytext31" bgcolor="#ecf0f5"></td>

                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>

                <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>

                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

                </tr>

              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;

        </td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><!--<input onClick="javascript:excelexport1();" type="button" value="Export To Excel" name="Submit2" class="button" style="border: 1px solid #001E6A" />--></td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"   bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

              </tr>

              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

                <td width="3%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Type</strong></div></td>

                <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Location</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong> From Store </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>To Store</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="left"><strong>Date</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="left"><strong>Category</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Itemname</strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Batch </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Exp.Dt </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Trn.Qty </strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Cost</strong></div></td>

        <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Total Amt</strong></div></td>

              </tr>

        <?php

       if($frmflag1=='frmflag1') {

        $colorloopcount = '';

        $loopcount = '';

        $totamount = 0;

       $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;
       if(isset($_REQUEST['categoryname'])){  $categoryname_s=$_REQUEST['categoryname']; }
       if(isset($_REQUEST['tranfer_type'])){  $tranfer_type=$_REQUEST['tranfer_type']; }

           

      if($tostore!="" && $fromstore!='' && $categoryname_s!=""){  

       $query66 = "SELECT * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and tostore like '".$tostore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  and categoryname='$categoryname_s'";

      }

      elseif($fromstore!="" && $tostore=='' && $categoryname_s!=""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."' and categoryname='$categoryname_s'";

      }elseif($fromstore=="" && $tostore=='' && $categoryname_s!=""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."' and categoryname='$categoryname_s'";

      }

      elseif($tostore!="" && $fromstore!='' && $categoryname_s==""){
       $query66 = "SELECT * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and tostore like '".$tostore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";
      }

      elseif($fromstore!="" && $tostore=='' &&  $categoryname_s==""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";

      }elseif($fromstore=="" && $tostore=='' && $categoryname_s==""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";

      }
      if($tranfer_type=="Transfer"){
        $query66 .= " and typetransfer='Transfer' ";
      }
      if($tranfer_type=="Consumable"){
        $query66 .= " and typetransfer='Consumable' ";
      }
      // echo $query66;

       $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

       while($res66 = mysqli_fetch_array($exec66))

       {

        $itemcode = $res66['itemcode'];

        $docno = $res66['docno'];

        $typetransfer = $res66['typetransfer'];

        $fromstore_code = $res66['fromstore'];

        $tostore_code = $res66['tostore'];
        $categoryname = $res66['categoryname'];

        $loopcount=$loopcount+1;

        

        $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore_code'");

        $res22 = mysqli_fetch_array($query22);

        $fromstore1 = $res22['store'];

       

       $query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore_code'");

        $res221 = mysqli_fetch_array($query221);

        $tostore1 = $res221['store'];

       

      if($typetransfer=="Consumable" || $tostore1==''){           

        $query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore_code'";

        $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));

        $res2a = mysqli_fetch_array($exec2a);

        $tostore1 = $res2a["accountname"];

       }

        

        $batch = $res66['batch'];

        $fifo_code = $res66['fifo_code'];

        $transaction_quantity = $res66['transferquantity'];

        $entrydate = $res66['entrydate'];

        $itemname = $res66['itemname'];

        $locationname = $res66['locationname'];

        

        $query2 = "SELECT expirydate FROM purchase_details WHERE fifo_code = '$fifo_code' and itemcode = '$itemcode' order by auto_number desc";
        //$query2 = "SELECT expirydate FROM purchase_details WHERE batchnumber = '$batch' and itemcode = '$itemcode' order by auto_number desc";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $num2 = mysqli_num_rows($exec2);
        $res2 = mysqli_fetch_array($exec2);
        $expirydate = $res2['expirydate'];
        
        if($num2==0){
        $query2 = "SELECT expirydate FROM materialreceiptnote_details WHERE fifo_code = '$fifo_code' and itemcode = '$itemcode' order by auto_number desc";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $expirydate = $res2['expirydate'];
        }

        

        $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";

        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

        $res3 = mysqli_fetch_array($exec3);

        $rate = $res3['purchaseprice'];

        

        $amount = $transaction_quantity * $rate;

        $totamount = $totamount + $amount;

        

        $colorloopcount = $colorloopcount + 1;

        $showcolor = ($colorloopcount & 1); 

        $colorcode = '';

        if ($showcolor == 0)

        {

          //$colorcode = 'bgcolor="#66CCFF"';

        }

        else

        {

          $colorcode = 'bgcolor="#cbdbfa"';

        }

        ?>

              <tr <?php echo $colorcode; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>

                <td class="bodytext31" valign="center"  align="left">

        <div align="center"><?php echo $typetransfer;?></div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31">

                  <div align="left"><?php echo $docno;?></div>

                </div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="left">

        <?php echo $locationname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

        <div class="bodytext31">

          <div align="left"><?php echo $fromstore1; ?></div>

        </div></td>

                <td class="bodytext31" valign="center"  align="left">

          <div align="left"><?php echo $tostore1; ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $entrydate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $categoryname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

          <div align="left"><?php echo $itemname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

          <div align="left"><?php echo $batch; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

          <div align="left"><?php echo $expirydate; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left">

          <div align="right"><?php echo $transaction_quantity; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

        <div align="right"><?php echo $rate; ?></div></td>

        <td class="bodytext31" valign="center"  align="left">

          <div align="right"><?php echo number_format($amount,2); ?></div></td>

              </tr>

        <?php

        //}

        }

       

        ?>

              <tr>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="right"  bgcolor="#ecf0f5"><strong> </strong></td>
                <td class="bodytext31" valign="center"  align="right"  bgcolor="#ecf0f5"><strong>Total : </strong></td>

                <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totamount,2); ?></strong></td>

                </tr>

        <?php

        }

        if($frmflag1 == 'frmflag1') { ?>

        <tr>

        <td  class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_stocktransferreportpdf.php?fromstore=<?=$fromstore;?>&&location=<?= $location;?>&&tostore=<?= $tostore;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>&&categoryname=<?=$categoryname_s;?>&&tranfer_type=<?=$tranfer_type;?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>

                <td colspan="12" class="bodytext31" valign="center"  align="left">

        <a target="_blank" href="print_stocktransferreport.php?fromstore=<?=$fromstore;?>&&location=<?= $location;?>&&tostore=<?= $tostore;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>&&categoryname=<?=$categoryname_s;?>&&tranfer_type=<?=$tranfer_type;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>

        </td>

        </tr>

        <?php

        }

        ?>

            </tbody>

        </table></td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



