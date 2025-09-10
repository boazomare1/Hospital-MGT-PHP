<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	

	$query1 = "truncate table resultentry_laban";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table tb";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table forex_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_labregentlinking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table account_ledger_lists";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table account_ledgers";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table billing_ipprivatedoctor_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table budget_entry_temp";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_taxsub";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table caftorder";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table lab_supplierlink";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table rad_supplierlink";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	$query1 = "truncate table locationwise_consultation_fees";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table doctor_weekdays";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table family_dependant";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table pharma_rate_template";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_ippackage";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_otcalculation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_assetdepartment";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_taxrelief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table accumulateddepreciation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_surgery";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table insurance_relief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_nurse";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_supplier";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table caftcreditorder";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_interfacemachine";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_lablinking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table asset_information";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_dischargesummary";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table 	master_paye";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_theatre_procedures";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_theatre_equipments";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table request_externallab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_theatre_booking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table medical_report";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table external_request";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_itemmapsupplier";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_ward";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table doctorsharing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_categorylab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_nhif";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table generatedpo_externallab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table purchasereturn_tax";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_iptriage";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_categoryradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_supervisor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_categoryservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table doctor_mapping";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table appointmentschedule_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_payrolldepartment";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_labresultvalues";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_store";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table ipsamplecollection_laban";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_testtemplate";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_itemtosupplier";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table loan_assign";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table adjust_advdeposits";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table caftorder_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table master_manufacturerpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_packagepharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table externallab_receivenote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_doctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table debtors_invoice";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_category";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table approveddeposit_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table purchase_tax";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_subtype";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table payroll_assign";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table lab_tests";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_planname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table budgetentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_radiologytemplate";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_financialintegration";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_machinelablinkingreference";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_bed";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_categorypharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table death_notification";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);



	$query1 = "truncate table master_bedcharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_triagebilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table details_employeepayroll";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_genericname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table 	master_accountname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table testcodes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_consultationtype";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_packageslinking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_labreference";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_item";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


    

    $query1 = "truncate table consumedstock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table medicine_return_request";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table tempmedicineqty";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_serviceslinking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table nhif_monthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table paye_monthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table amendment_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table externallab_po";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table payroll_assignmonthwise";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table discharge_icd";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table master_medicine";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table 	master_itempharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table birth_notification";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	$query1 = "truncate table healthcarepackagelinking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table completed_billingpaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table dispensingfee";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table supplier_link";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table approvalstatus";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
    
	$query1 = "truncate table master_customer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table print_deliverysubtype";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

    $query1 = "truncate table opipsampleid_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table login_locationdetails";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	


	$query1 = "truncate table master_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_billing1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table prescription_externalpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_departmentreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table bankentryform";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table cogsentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table depositrefund_request";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table deposit_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_drugadmin";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table master_ipvisitentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_purchase";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_purchaseorder";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table master_purchaserequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table master_purchasereturn";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_internalstockrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	

	$query1 = "truncate table master_transactionadvancedeposit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_transactiondoctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_transactionexternal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table master_transactionip";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_transactionipcreditapproved";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_transactionipdeposit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionpaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionpaynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_transactionpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_visitentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table pharmacysalesreturn_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table pharmacysales_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	

	$query1 = "truncate table purchasereturn_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchaseorder_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	

	
	$query1 = "truncate table purchaserequest_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchaserequest_tax";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchase_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table transaction_stock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table receiptsub_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylaterlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylaterpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylaterradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylaterreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table refund_paylaterservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynowlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynowpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynowradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynowreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paynowservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_external";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_externallab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_externalpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_externalradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_externalreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ip";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipbedcharges";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipcreditapproved";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_iplab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ippharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterconsultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paylaterservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynowlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynowpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynowradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynowreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_paynowservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_pharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_referal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_externalservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipadmissioncharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipmiscbilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table billing_ipnhif";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipotbilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table billing_ipprivatedoctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table billing_ipadmissioncharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table expensesub_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table paymentmodedebit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table paymentmodecredit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	
	$query1 = "truncate table consultation_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_referal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table consultation_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_triage";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table iptest_procedures";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_ambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipmisc_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_otbilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipprivate_doctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipconsultation_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipconsultation_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipconsultation_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_bedallocation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_discharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_progressnotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_vitalio";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_discount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_doctornotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	
	$query1 = "truncate table ip_creditapproval";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_creditapprovalformdata";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_creditnote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_creditnotebrief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_debitnote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_debitnotebrief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_bedtransfer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipsamplecollection_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipprocess_service";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipresultentry_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipresultentry_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ippharmacy_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipmedicine_issue";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table expensesub_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table expense_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_icd";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_icd1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_ipadmission";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table consultation_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	
	$query1 = "truncate table consultation_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table consultation_referal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table consultation_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table resultentry_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table resultentry_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table samplecollection_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table stock_taking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
		
	$query1 = "truncate table process_service";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	
	$query1 = "truncate table purchaseorder_tax";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchaserequest_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchaserequest_tax";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchase_indent";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchase_ordergeneration";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table openingstock_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table pharmacysalesreturn_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table pharmacysales_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_stock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_stock_transfer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	//$query1 = "truncate table master_itemtosupplier";
	//$exec1 = mysql_query($query1);
	
	$query1 = "truncate table master_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_consultationlist";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_consultationpharm";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_consultationpharmissue";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_nhifprocessing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipcreditapprovedtransaction";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "update master_bed set recordstatus=''";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchase_rfqrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_rfq";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_rfqpurchaseorder";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table purchase_rfq";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchase_rfqrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table materialreceiptnote_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table shift_tracking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table depreciation_information";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_fixedassets";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchasenm_rfq";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_nmrfq";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_nmrfqpurchaseorder";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table purchasenm_rfqrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table materialreceiptnote_nmdetails";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table openingbalanceaccount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table openingbalancesupplier";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table bank_record";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_nmstockissue";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table newborn_motherdetails";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table preop";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table postop";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table pharma_insurance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table paylaterpharmareturns";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table optheatrenursenotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table operationrecord";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table member_insurance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_wishes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_vct";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table master_vaccine";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table details_login";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table dischargesummary";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table dc_discharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table dc_progressnotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table dc_vitalio";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table externalemr_upload";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table fluidbalance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipclinicalrecord";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipconsentform";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ip_otrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table login_restriction";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table sickleave_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table sick_referral";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table tbtemplate";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ancphysixam";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ancprespreg";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ancprevpreg";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ancprevser";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table vct";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table vaccination";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table userselected_report";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_ipambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_opambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table ipambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table opambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_opambulancepaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  refund_paylaterambulance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_homecare";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_homecarepaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table homecare";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table iphomecare";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table refund_paylaterhomecare";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table billing_iphomecare";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  ipmedicine_prescription";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  manual_lpo";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  samplecollection_laban";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  resultentery_laban";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  patientweivers";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  billing_patientweivers";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  master_journalentries";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  assets_register";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  master_transactionaponaccount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
	
	$query1 = "truncate table  master_transactiononaccount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
		$errmsg1 = "Table First Batch Truncate Completed.";
}





?>
<script language="javascript">
function btnClick1()
{
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete All Data In DB And Reset To Original State?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		alert ("Data In Table First Batch Not Deleted.");
		return false;
	}
}



</script>
<form id="form1" name="form1" method="post" action="" onsubmit="return btnClick1()">
  <p>Batch One : Will Delete All Data And Restore To Original State. </p>
  <p>
    <input type="submit" name="Submit" value="Truncate All Data" />
    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
  </p>
</form>
<?php echo $errmsg1; ?>
