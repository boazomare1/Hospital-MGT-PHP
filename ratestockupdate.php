<?php
include ("db/db_connect.php");
/*echo $sql="select * from temp_cpupdate ";
$exec34 = mysql_query($sql) or die(mysql_error());
while($res34 = mysql_fetch_array($exec34))
{
   $itemcode=$res34["itemcode"];
   $docnumber=$res34["docno"];
   $batchnumber=$res34["batch"];
   $quantity=$res34["qty"];

   $lastsaleprice = $res34["rate"];

   mysql_query("update openingstock_entry set rateperunit='$lastsaleprice',totalrate=(quantity*$lastsaleprice) where billnumber='$docnumber' and itemcode='$itemcode' and batchnumber='$batchnumber' and rateperunit=0.00");

   mysql_query("update tb set transaction_amount=($quantity*$lastsaleprice) where doc_number='$docnumber' and from_table='openingstock_entry' and rateperunit=0.00");

   mysql_query("update purchase_details set rate='$lastsaleprice',subtotal=(quantity*$lastsaleprice) where billnumber='$docnumber' and itemcode='$itemcode' and batchnumber='$batchnumber' and rateperunit=0.00");
   

   $sql_trans="select fifo_code from transaction_stock where entrydocno='$docnumber' and itemcode='$itemcode' and batchnumber='$batchnumber' and description='OPENINGSTOCK' ";
    $exec343 = mysql_query($sql_trans) or die(mysql_error());
	if($res343 = mysql_fetch_array($exec343))
	{
		$fifocode=$res343['fifo_code'];

		mysql_query("update transaction_stock set rate='$lastsaleprice',totalprice=(transaction_quantity*$lastsaleprice) where entrydocno='$docnumber' and itemcode='$itemcode' and batchnumber='$batchnumber' and description='OPENINGSTOCK' and rateperunit=0.00");
        
		$sql_lastcp="select * from transaction_stock where itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and rate=0.00 and tablename in ('master_stock','master_stock_transfer','pharmacysales_details','pharmacysalesreturn_details') order by auto_number";
		$exec3432 = mysql_query($sql_lastcp) or die(mysql_error());
		while($res3432 = mysql_fetch_array($exec3432))
		{
		   $updateid = $res3432["auto_number"];
		   $entrydocno = $res3432["entrydocno"];
		   $tablename = $res3432["tablename"]; 

		   $ledger_sql="SELECT `master_medicine`.`inventoryledgercode` AS ledger,`master_medicine`.`ledgercode` AS cledger  FROM `master_medicine` WHERE itemcode = '$itemcode' ORDER BY auto_number DESC LIMIT 0,1";
		   $cp1233 = mysql_query($ledger_sql) or die(mysql_error());
		   $rescp33 = mysql_fetch_array($cp1233);
		   $ledger=$rescp33['ledger'];
		   $cledger=$rescp33['cledger'];

		   $ledger_sql2="SELECT `finance_ledger_mapping`.`ledger_id` 
                AS tilledger  
                FROM `finance_ledger_mapping`
                WHERE map_anum = '18' 
                ORDER BY auto_number 
                DESC LIMIT 0,1";
		  $cp12331 = mysql_query($ledger_sql2) or die(mysql_error());
		   $rescp331 = mysql_fetch_array($cp12331);
		   $tilledger=$rescp331['tilledger'];

           $cp="select rate from transaction_stock where itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and rate!=0.00 order by auto_number desc limit 0,1";
		   $cp12 = mysql_query($cp) or die(mysql_error());
		   $rescp = mysql_fetch_array($cp12);
		   $lastsaleprice = $rescp["rate"];

		   mysql_query("update transaction_stock set rate='$lastsaleprice',totalprice=(transaction_quantity*$lastsaleprice) where auto_number='$updateid'");

		   if($tablename =="master_stock"){

			   $updatesql="select  * from master_stock where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysql_query($updatesql) or die(mysql_error());
		           $rescp3 = mysql_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['transactiondate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];
				   $transactionparticular=$rescp3['transactionparticular'];
				   

              mysql_query("update master_stock set rateperunit='$lastsaleprice',totalrate=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

				if($transactionparticular=='BY ADJUSTMENT ADD'){
				  mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

					mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tilledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

				}elseif($transactionparticular=='BY ADJUSTMENT MINUS'){
					mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

					mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tilledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
				}

		   }

		   if($tablename =="master_stock_transfer"){

			    $updatesql="select  * from master_stock_transfer where docno='$entrydocno' and itemcode='$itemcode' and batch='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysql_query($updatesql) or die(mysql_error());
		           $rescp3 = mysql_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['transferquantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];
				   $typetransfer=$rescp3['typetransfer'];
				   $cost_center=$rescp3['cost_center'];
				   $tostore=$rescp3['tostore'];
				   

              mysql_query("update master_stock_transfer set rate='$lastsaleprice',amount=(quantity*$lastsaleprice) where docno='$entrydocno' and itemcode='$itemcode' and batch='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

			  if($typetransfer=='Consumable'){
				  mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '$cost_center',
									remarks = 'Goods Amount',
									from_table = 'master_stock_transfer',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
				mysql_query("INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tostore',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '$cost_center',
									remarks = 'Goods Amount',
									from_table = 'master_stock_transfer',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
			  }
		   }
           
		   if($tablename =="pharmacysales_details"){
			   if(strpos($entrydocno, "OPPI") !== false){

				   $updatesql="select  * from pharmacysales_details where docnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysql_query($updatesql) or die(mysql_error());
		           $rescp3 = mysql_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

				   mysql_query("update pharmacysales_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where docnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

				   

			   }else{

				   $updatesql="select  * from pharmacysales_details where ipdocno='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysql_query($updatesql) or die(mysql_error());
		           $rescp3 = mysql_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

                  mysql_query("update pharmacysales_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where ipdocno='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");                     
			   }

			   mysql_query("INSERT INTO `tb`
					SET
						doc_number = '$entrydocno', 
						ledger_id = '$ledger', 
						transaction_date = '$entrydate2', 
						transaction_amount = ($quantity3*$lastsaleprice), 
						transaction_type = 'C', 
						parent_type = '', 
						currency_code = 'CUR-1',
						exchange_rate = '1',
						cost_center_code = '',
						remarks = 'Inventory',
						from_table = 'pharmacysales_details',
						narration = '',
						created_at = now(),
						updated_at = now(),
						record_status = '1',
						user_name = '$username',
						locationcode = '$locationcode'");

						mysql_query("INSERT INTO `tb`
						SET
							doc_number = '$entrydocno', 
							ledger_id = '$cledger', 
							transaction_date = '$entrydate2',
							transaction_amount = ($quantity3*$lastsaleprice),  
							transaction_type = 'D', 
							parent_type = '', 
							currency_code = 'CUR-1',
							exchange_rate = '1',
							cost_center_code = '',
							remarks = 'COGS',
							from_table = 'pharmacysales_details',
							narration = '',
							created_at = now(),
							updated_at = now(),
							record_status = '1',
							user_name = '$username',
							locationcode = '$locationcode'");

		   }

		   if($tablename =="pharmacysalesreturn_details"){
			  $updatesql="select  * from pharmacysales_details where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysql_query($updatesql) or die(mysql_error());
		           $rescp3 = mysql_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

              mysql_query("update pharmacysalesreturn_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

			  mysql_query("INSERT INTO `tb`
				SET
					doc_number = '$entrydocno', 
					ledger_id = '$ledger', 
					transaction_date = '$entrydate2',
					transaction_amount = ($quantity3*$lastsaleprice),  
					transaction_type = 'D', 
					parent_type = '', 
					currency_code = 'CUR-1',
					exchange_rate = '1',
					cost_center_code = '',
					remarks = 'Inventory',
					from_table = 'pharmacysalesreturn_details',
					narration = '',
					created_at = now(),
					updated_at = now(),
					record_status = '1',
					user_name = '$username',
					locationcode = '$locationcode'");
				mysql_query("INSERT INTO `tb`
					SET
						doc_number = '$entrydocno', 
						ledger_id = '$cledger', 
						transaction_date = '$entrydate2',
						transaction_amount = ($quantity3*$lastsaleprice), 
						transaction_type = 'C', 
						parent_type = '', 
						currency_code = 'CUR-1',
						exchange_rate = '1',
						cost_center_code = '',
						remarks = 'COGS',
						from_table = 'pharmacysalesreturn_details',
						narration = '',
						created_at = now(),
						updated_at = now(),
						record_status = '1',
						user_name = '$username',
					    locationcode = '$locationcode'");
		   }


		}

	}

}*/

//'master_stock','master_stock_transfer','pharmacysales_details','pharmacysalesreturn_details','process_package','purchase_details'
       echo $sql_lastcp="select * from transaction_stock where  rate=0.00 and tablename in ('master_stock','master_stock_transfer','pharmacysales_details','pharmacysalesreturn_details','process_package','purchase_details')  order by auto_number";
		$exec3432 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_lastcp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3432 = mysqli_fetch_array($exec3432))
		{
		   $updateid = $res3432["auto_number"];
		   $entrydocno = $res3432["entrydocno"];
		   $tablename = $res3432["tablename"];
		   $batchnumber = $res3432["batchnumber"];
		   $fifocode = $res3432["fifo_code"];
		   $itemcode = $res3432["itemcode"];
		   $itemcode = $res3432["itemcode"];
		   $quantity = $res3432["transaction_quantity"];
		   $patientvisitcode = $res3432["patientvisitcode"];
		   

		   $ledger_sql="SELECT `master_medicine`.`inventoryledgercode` AS ledger,`master_medicine`.`ledgercode` AS cledger,purchaseprice  FROM `master_medicine` WHERE itemcode = '$itemcode' ORDER BY auto_number DESC LIMIT 0,1";
		   $cp1233 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescp33 = mysqli_fetch_array($cp1233);
		   $ledger=$rescp33['ledger'];
		   $cledger=$rescp33['cledger'];
		   $purchaseprice=$rescp33['purchaseprice'];

		   

		   $ledger_sql2="SELECT `finance_ledger_mapping`.`ledger_id` 
                AS tilledger  
                FROM `finance_ledger_mapping`
                WHERE map_anum = '18' 
                ORDER BY auto_number 
                DESC LIMIT 0,1";
		  $cp12331 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_sql2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescp331 = mysqli_fetch_array($cp12331);
		   $tilledger=$rescp331['tilledger'];

           $cp="select rate from transaction_stock where itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and rate!=0.00 order by auto_number desc limit 0,1";
		   $cp12 = mysqli_query($GLOBALS["___mysqli_ston"], $cp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescp = mysqli_fetch_array($cp12);
		   $lastsaleprice = $rescp["rate"];

		   if($lastsaleprice ==''){
			   $cp="select rate from transaction_stock where itemcode='$itemcode' and rate!=0.00 order by auto_number desc limit 0,1";
		   $cp12 = mysqli_query($GLOBALS["___mysqli_ston"], $cp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescp = mysqli_fetch_array($cp12);
		   $lastsaleprice = $rescp["rate"];

		   }
		   if($lastsaleprice ==''){
             $lastsaleprice = $purchaseprice;
		   }
		   echo "----".$lastsaleprice;

		   mysqli_query($GLOBALS["___mysqli_ston"], "update transaction_stock set rate='$lastsaleprice',totalprice=(transaction_quantity*$lastsaleprice) where auto_number='$updateid'");

		   if($tablename =="purchase_details"){

			   mysqli_query($GLOBALS["___mysqli_ston"], "update openingstock_entry set rateperunit='$lastsaleprice',totalrate=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' ");

		       mysqli_query($GLOBALS["___mysqli_ston"], "update tb set transaction_amount=($quantity*$lastsaleprice) where doc_number='$entrydocno' and from_table='openingstock_entry'");

		       mysqli_query($GLOBALS["___mysqli_ston"], "update purchase_details set rate='$lastsaleprice',subtotal=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' ");

		   }

		    if($tablename =="process_package"){
			   

				   $updatesql="select  * from pharmacysales_details where visitcode='$patientvisitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and costprice=0.00";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];
				   $entrydocno = $rescp3["docnumber"];
                if($entrydocno!=''){
				   mysqli_query($GLOBALS["___mysqli_ston"], "update pharmacysales_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where docnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

				   

			   

			   mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
					SET
						doc_number = '$entrydocno', 
						ledger_id = '$ledger', 
						transaction_date = '$entrydate2', 
						transaction_amount = ($quantity3*$lastsaleprice), 
						transaction_type = 'C', 
						parent_type = '', 
						currency_code = 'CUR-1',
						exchange_rate = '1',
						cost_center_code = '',
						remarks = 'Inventory',
						from_table = 'pharmacysales_details',
						narration = '',
						created_at = now(),
						updated_at = now(),
						record_status = '1',
						user_name = '$username',
						locationcode = '$locationcode'");

						mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
						SET
							doc_number = '$entrydocno', 
							ledger_id = '$cledger', 
							transaction_date = '$entrydate2',
							transaction_amount = ($quantity3*$lastsaleprice),  
							transaction_type = 'D', 
							parent_type = '', 
							currency_code = 'CUR-1',
							exchange_rate = '1',
							cost_center_code = '',
							remarks = 'COGS',
							from_table = 'pharmacysales_details',
							narration = '',
							created_at = now(),
							updated_at = now(),
							record_status = '1',
							user_name = '$username',
							locationcode = '$locationcode'");
				}

		   }
           
		    if($tablename =="master_stock"){

			   $updatesql="select  * from master_stock where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['transactiondate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];
				   $transactionparticular=$rescp3['transactionparticular'];
				   

              mysqli_query($GLOBALS["___mysqli_ston"], "update master_stock set rateperunit='$lastsaleprice',totalrate=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

				if($transactionparticular=='BY ADJUSTMENT ADD'){
				  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

					mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tilledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

				}elseif($transactionparticular=='BY ADJUSTMENT MINUS'){
					mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");

					mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tilledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '',
									remarks = 'Goods Amount',
									from_table = 'master_stock',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
				}

		   }

		   if($tablename =="master_stock_transfer"){

			    $updatesql="select  * from master_stock_transfer where docno='$entrydocno' and itemcode='$itemcode' and batch='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['transferquantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];
				   $typetransfer=$rescp3['typetransfer'];
				   $cost_center=$rescp3['cost_center'];
				   $tostore=$rescp3['tostore'];
				   

              mysqli_query($GLOBALS["___mysqli_ston"], "update master_stock_transfer set rate='$lastsaleprice',amount=(quantity*$lastsaleprice) where docno='$entrydocno' and itemcode='$itemcode' and batch='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

			  if($typetransfer=='Consumable'){
				  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$ledger',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'C', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '$cost_center',
									remarks = 'Goods Amount',
									from_table = 'master_stock_transfer',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
				mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
								SET
									doc_number = '$entrydocno', 
									ledger_id = '$tostore',  
									transaction_date = '$entrydate2',  
									transaction_amount = ($quantity3*$lastsaleprice),  
									transaction_type = 'D', 
									parent_type = '', 
									currency_code = 'CUR-1',
									exchange_rate = '1',
									cost_center_code = '$cost_center',
									remarks = 'Goods Amount',
									from_table = 'master_stock_transfer',
									narration = '',
									created_at = now(),
									updated_at = now(),
									record_status = '1',
									user_name = '$username',
						            locationcode = '$locationcode'");
			  }
		   }

		   if($tablename =="pharmacysales_details"){
			   if(strpos($entrydocno, "OPPI") !== false){

				   $updatesql="select  * from pharmacysales_details where docnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

				   mysqli_query($GLOBALS["___mysqli_ston"], "update pharmacysales_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where docnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

				   

			   }else{

				   $updatesql="select  * from pharmacysales_details where ipdocno='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

                  mysqli_query($GLOBALS["___mysqli_ston"], "update pharmacysales_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where ipdocno='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");                     
			   }

			   mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
					SET
						doc_number = '$entrydocno', 
						ledger_id = '$ledger', 
						transaction_date = '$entrydate2', 
						transaction_amount = ($quantity3*$lastsaleprice), 
						transaction_type = 'C', 
						parent_type = '', 
						currency_code = 'CUR-1',
						exchange_rate = '1',
						cost_center_code = '',
						remarks = 'Inventory',
						from_table = 'pharmacysales_details',
						narration = '',
						created_at = now(),
						updated_at = now(),
						record_status = '1',
						user_name = '$username',
						locationcode = '$locationcode'");

						mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
						SET
							doc_number = '$entrydocno', 
							ledger_id = '$cledger', 
							transaction_date = '$entrydate2',
							transaction_amount = ($quantity3*$lastsaleprice),  
							transaction_type = 'D', 
							parent_type = '', 
							currency_code = 'CUR-1',
							exchange_rate = '1',
							cost_center_code = '',
							remarks = 'COGS',
							from_table = 'pharmacysales_details',
							narration = '',
							created_at = now(),
							updated_at = now(),
							record_status = '1',
							user_name = '$username',
							locationcode = '$locationcode'");

		   }

		   if($tablename =="pharmacysalesreturn_details"){
			  $updatesql="select  * from pharmacysales_details where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode'";
				   $cp123 = mysqli_query($GLOBALS["___mysqli_ston"], $updatesql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		           $rescp3 = mysqli_fetch_array($cp123);
				   $ids=$rescp3['auto_number'];
				   $entrydate2=$rescp3['entrydate'];
				   $quantity3=$rescp3['quantity'];
				   $username=$rescp3['username'];
				   $locationcode=$rescp3['locationcode'];

              mysqli_query($GLOBALS["___mysqli_ston"], "update pharmacysalesreturn_details set costprice='$lastsaleprice',totalcp=(quantity*$lastsaleprice) where billnumber='$entrydocno' and itemcode='$itemcode' and batchnumber='$batchnumber' and fifo_code='$fifocode' and auto_number='$ids'");

			  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
				SET
					doc_number = '$entrydocno', 
					ledger_id = '$ledger', 
					transaction_date = '$entrydate2',
					transaction_amount = ($quantity3*$lastsaleprice),  
					transaction_type = 'D', 
					parent_type = '', 
					currency_code = 'CUR-1',
					exchange_rate = '1',
					cost_center_code = '',
					remarks = 'Inventory',
					from_table = 'pharmacysalesreturn_details',
					narration = '',
					created_at = now(),
					updated_at = now(),
					record_status = '1',
					user_name = '$username',
					locationcode = '$locationcode'");
				mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `tb`
					SET
						doc_number = '$entrydocno', 
						ledger_id = '$cledger', 
						transaction_date = '$entrydate2',
						transaction_amount = ($quantity3*$lastsaleprice), 
						transaction_type = 'C', 
						parent_type = '', 
						currency_code = 'CUR-1',
						exchange_rate = '1',
						cost_center_code = '',
						remarks = 'COGS',
						from_table = 'pharmacysalesreturn_details',
						narration = '',
						created_at = now(),
						updated_at = now(),
						record_status = '1',
						user_name = '$username',
					    locationcode = '$locationcode'");
		   }


		}




?>