<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";

$colorloopcount = '';

//To populate the autocompetelist_services1.js


$transactiondatefrom = date('2014-01-01');
$transactiondateto = date('Y-m-d');




if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	
	
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script type="text/javascript" src="js/disablebackenterkey.js"></script>




<script src="js/datetimepicker_css.js"></script>

<body>
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="drugs" action="pharmacysales.php" method="post" onKeyDown="return disableEnterKey()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Pharmacy Sales</strong></td>
          </tr>
        <tr>
          
        <script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}







</script>
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
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
			$query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
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
        </tr>
       
        
        <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="186" align="center" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong></strong> </td>
          <td width="186" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">  
		  </td>
        </tr>
        <tr>
         
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">
            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  type="submit" value="Search" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </div></td>
		  <td colspan="3" bgcolor="#fff">&nbsp;</td>
        </tr>
        
      </tbody>
    </table>
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400"
            align="left" border="0">
          <tbody>
		  
		 
		  
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$frmflag1 = $_REQUEST['frmflag1'];
				if ($frmflag1 == 'frmflag1')
				{
				if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
				
				?>
				<?php
				if($categoryname == '')
				{
				
				
				$query9 = "select * from pharmacysales_details where categoryname like '%$categoryname%' and entrydate between '$ADate1' and '$ADate2' group by categoryname order by entrydate desc"; 
				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res9 = mysqli_fetch_array($exec9))
				{
				$sno=0;
				$total=0;
				$categoryname = $res9['categoryname'];
				$query7 = "select * from pharmacysales_details where categoryname like '%$categoryname%' and entrydate between '$ADate1' and '$ADate2' group by itemname order by entrydate desc";
				
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
				if($num7!=0){
				?>
			<tr> <td align="left" valign="center"  
                class="bodytext31" colspan="3" bgcolor="#ecf0f5"><strong><?php echo $categoryname; ?></strong></td></tr>
			<tr>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Drug Name</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity</strong></div></td>
              
             </tr>
			<?php							
			while($res7 = mysqli_fetch_array($exec7))
			{
			
			$billdate6 = $res7['entrydate'];
			$quantity6 = $res7['quantity'];
			$patientname6 = $res7['patientname'];
			$itemname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res7['itemname']);
			//$total=$total+$quantity6;
			$query17 = "select sum(quantity) as quantity from pharmacysales_details where itemname like '%$itemname%' and entrydate between '$ADate1' and '$ADate2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$quantity6 = $res17['quantity'];
			$total=$total+$quantity6;	
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
				 <tr <?php echo $colorcode; ?>>
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
             
			  <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $itemname; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right"><?php echo intval($quantity6); ?></div></td>
             
              
				</tr>
				<?php
				} ?>
				
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong></strong></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Total</strong></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong><?php echo intval($total); ?></strong></div></td>
             
              
				</tr><?php }
}
}
				else
				{
				
				$sno = '';
				
				?>
				 <tr> <td align="left" valign="center"  
                class="bodytext31" width="5%" bgcolor="#ecf0f5" colspan="3"><strong><?php echo $categoryname; ?></strong></td></tr>
			 <tr>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Drug Name</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity</strong></div></td>
              
             </tr>
			<?php
			
			
						
			
				$query7 = "select * from pharmacysales_details where categoryname like '%$categoryname%' and entrydate between '$ADate1' and '$ADate2' group by itemname order by entrydate desc";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]) );
				$total=0;		
				while($res7 = mysqli_fetch_array($exec7))
				{
				$billdate6 = $res7['entrydate'];
				
				$patientname6 = $res7['patientname'];
				$itemname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res7['itemname']);
				
				$query17 = "select sum(quantity) as quantity from pharmacysales_details where itemname like '%$itemname%' and entrydate between '$ADate1' and '$ADate2'";
				$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die("Error in Query117".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res17 = mysqli_fetch_array($exec17);
				$quantity6 = $res17['quantity'];
				$total=$total+$quantity6;	
	
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
				 <tr <?php echo $colorcode; ?>>
             
              <td align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
              
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $itemname; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right"><?php echo intval($quantity6); ?></div></td>
              
              
				</tr>
				<?php
				}
				 ?>
				
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong></strong></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Total</strong></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong><?php echo intval($total); ?></strong></div></td>
             
              
				</tr><?php 
				}
				
				}
				?>
		  </tbody>
		  </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>