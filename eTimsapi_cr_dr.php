<?php
include ("db/db_connect.php");
$results = array();
$invoice_arry=array();
$inv_rslt=array();
$inv_line=array();
$messages=array();
$updatedatetime = date('d-m-Y H:i:s');
$timestamp = strtotime($updatedatetime);
$formatted_datetime = date('YmdHis', $timestamp);


 $query499 = "select auto_number from etims_data where billnumber='$ref_billno' and visitcode='$res11visitcode'";
$exec499 = mysqli_query($GLOBALS["___mysqli_ston"], $query499) or die ("Error in Query499".mysqli_error($GLOBALS["___mysqli_ston"]));
$res499 = mysqli_fetch_array($exec499);
$orig_auto_number = $res499['auto_number'];


//$query48 = "select tin,cmckey,bhfid,api_url from master_etims where locationcode='$res11locationcode'";
$query48 = "select tin,cmckey,bhfid,api_url,barcode_url from master_etims where id='1'";
$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query48".mysqli_error($GLOBALS["___mysqli_ston"]));
$res48 = mysqli_fetch_array($exec48);
$master_tin = $res48['tin'];
$master_cmckey = $res48['cmckey'];
$master_bhfid = $res48['bhfid'];
$etims_url = $res48['api_url'];
$etims_barcode_url = $res48['barcode_url'];

//$etims_barcode_url='https://etims.kra.go.ke/common/link/etims/receipt/indexEtimsReceiptData?Data=';
$j=1;


if($orig_auto_number!='')
{
if($res11billingdatetime>='2024-04-05')
{
	
$inv_dateconv = strtotime($res11billingdatetime);
$send_invdate = date('Ymd', $inv_dateconv);

$query77 = "select * from etims_data where billnumber='$billautonumber'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$rows77 = mysqli_num_rows($exec77);
if($rows77 == 0)
{
$query2 = "insert into etims_data(visitcode,billnumber,locationcode,transactionamount) values('$res11visitcode','$billautonumber','$res11locationcode','$res11subtotalamount')";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);

}

$query4 = "select auto_number,receipt_no from etims_data where billnumber='$billautonumber' and visitcode='$res11visitcode'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$auto_number = $res4['auto_number'];
$receipt_no_val = $res4['receipt_no'];
if($receipt_no_val=='')
{


 $data_string='{
    "tin": "'.$master_tin.'",
    "bhfId": "'.$master_bhfid.'",
    "invcNo": "'.$auto_number.'",
    "orgInvcNo": "'.$orig_auto_number.'",
    "custTin": "",
    "custNm": "",
    "salesTyCd": "N",
    "rcptTyCd": "R",
    "pmtTyCd": "01",
    "salesSttsCd": "02",
    "cfmDt": "'.$formatted_datetime.'",
    "salesDt":"'.$send_invdate.'",
    "stockRlsDt": "'.$formatted_datetime.'",
    "cnclReqDt": null,
    "cnclDt": null,
    "rfdDt": null,
    "rfdRsnCd": null,
    "totItemCnt": 1,
    "taxblAmtA": 0,
    "taxblAmtB": 0,
    "taxblAmtC": 0,
    "taxblAmtD": "'.$res11subtotalamount.'",
    "taxblAmtE": 0,
    "taxRtA": 0,
    "taxRtB": 16,
    "taxRtC": 0,
    "taxRtD": 0,
    "taxRtE": 8,
    "taxAmtA": 0,
    "taxAmtB": 0,
    "taxAmtC": 0,
    "taxAmtD": 0,
    "taxAmtE": 0,
    "totTaxblAmt": "'.$res11subtotalamount.'",
    "totTaxAmt": 0,
    "totAmt": "'.$res11subtotalamount.'",
    "prchrAcptcYn": "Y",
    "remark": null,
    "regrId": "Admin",
    "regrNm": "REH Healthcare Ltd",
    "modrId": "Admin",
    "modrNm": "REH Healthcare Ltd",
    "receipt": {
        "custTin": "",
        "custMblNo": "",
		"rcptPbctDt":"'.$formatted_datetime.'",
        "rptNo": "'.$auto_number.'",
        "trdeNm": "",
        "adrs": "",
        "topMsg": "REH Healthcare Ltd",
        "btmMsg": "Thankyou",
        "prchrAcptcYn": "Y"
    },
    "itemList": [
        {
            "itemSeq": 1,
            "itemCd": "KE3NTNO0000016",
            "itemClsCd": "8500000000",
            "itemNm": "Healthcare Services",
            "bcd": null,
            "pkgUnitCd": "NT",
            "pkg": 1,
            "qtyUnitCd": "U",
            "qty": "1",
            "prc": "'.$res11subtotalamount.'",
            "splyAmt": "'.$res11subtotalamount.'",
            "dcRt": 0,
            "dcAmt": 0,
            "isrccCd": null,
            "isrccNm": null,
            "isrcRt": null,
            "isrcAmt": null,
            "taxTyCd": "D",
            "taxblAmt": "'.$res11subtotalamount.'",
            "taxAmt": 0,
            "totAmt": "'.$res11subtotalamount.'"
        }
    ]
}';
/*echo $etims_url;
	print_r($authorization);
	print_r($data_string);

	exit;*/
	/*$authorization='{
        "tin": "P700000001F",
        "bhfid": "00",
        "cmckey": "84955C04D5B24DF48C21E56E000852432BCAC3C03F384256A9B3"
     }';*/
	 
	/* $headers = array(
    'Content-Type: application/json',
    'tin: P700000001F',
    'bhfid: 00',
    'cmckey: 84955C04D5B24DF48C21E56E000852432BCAC3C03F384256A9B3'
);
print_r($headers);*/
 $headers = array(
    'Content-Type: application/json',
    'tin: '.$master_tin.'',
    'bhfid: '.$master_bhfid.'',
    'cmckey: '.$master_cmckey.''
);
//print_r($data_string);
//exit;
//print_r($headers);
//exit;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json' ));
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
	curl_setopt($curl, CURLOPT_URL, $etims_url.'/?format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($curl);	
	//print_r($result);
	//exit;
	$err = curl_error($curl);
	curl_close($curl);    
	if ($err) {
	   $results['error'] = $err_unable_connect;
	}else{
		$obj=json_decode($result,true);	
      // print_r($obj);
	  // exit;
		if($obj){
            $results['rcptSign'] = $obj['data']['rcptSign'];
			
			$set_date=$obj['resultDt'];
		
$conv_date1 = DateTime::createFromFormat('YmdHis', $set_date);

$conv_date= $conv_date1->format('Y-m-d H:i:s');

//echo "the sdicd-->".$obj['data']['sdcId'];

//exit;

			
/*$query2 = "update etims_data set kra_payload='".addslashes($result)."',sdicd='".$obj['data']['sdcId']."',mrcNo='".$obj['data']['mrcNo']."',receipt_no='".$obj['data']['rcptSign']."',resultdate='$conv_date'  where auto_number='$auto_number'";*/
$query2 = "update etims_data set kra_payload='".addslashes($result)."',receipt_no='".$obj['data']['rcptSign']."',resultdate='$conv_date'  where auto_number='$auto_number'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	
			          
		}
		elseif(isset($obj['status']) && $obj['status']=='Failure'){
		  $results['error'] = $obj['message'];
		}
		else{
		  $results['error'] = 'Invalid Information';
		}
	  
	 
}
}

 $query41 = "select resultdate,mrcNo,sdicd,tin,branchid,receipt_no,auto_number from etims_data where billnumber='$billautonumber' and visitcode='$res11visitcode' ";
$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
$res41 = mysqli_fetch_array($exec41);
$resultdate = $res41['resultdate'];
$mrcNo = $res41['mrcNo'];
$sdicd = $res41['sdicd'];
$tin = $res41['tin'];
$branchid = $res41['branchid'];
$receipt_no = $res41['receipt_no'];
$auto_number = $res41['auto_number'];
$etims_rcptSign=$master_tin.$master_bhfid.$receipt_no;
if($receipt_no!='')
{

	?>
    
    <tr> 

            <td  width="350" class="bodytext31" align="left"></td> 

			<td  width="150" class="bodytext31" align="right"><?php echo $auto_number; ?> <br/> <?php echo $receipt_no; ?></td>
            
            <?php
include 'phpqrcode/qrlib.php';
		 $text = $etims_barcode_url.$etims_rcptSign;
		QRcode::png($text, 'qrcodes/image.png');
		?> 

			<td  width="90" align="right" class="bodytext30"><img src="qrcodes/image.png" alt="" style="height:65px"></td>

		</tr>

   
<?php

}

}
}
?>