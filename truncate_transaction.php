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
	$query1 = "truncate table tb";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table transaction_stock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table pharmacysales_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table resultentry_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table pending_test_orders";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table stock_taking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table login_locationdetails";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table details_login";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipmedicine_issue";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipmedicine_prescription";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table billing_ippharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table audit_resultentry_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipresultentry_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_consultationpharmissue";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_consultationpharm";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionpaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table billing_paylaterpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipprivatedoctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_progressnotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_stock_transfer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table opipsampleid_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_internalstockrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_visitentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_consultationlist";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_triage";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table pharma_template_map";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table excel_insurance_upload";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table print_deliverysubtype";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table completed_billingpaylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table consultation_icd";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table paymentmodedebit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paylaterconsultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table assets_depreciation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table consultation_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table samplecollection_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paynowpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_stock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipconsultation_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipsamplecollection_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_iplab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table purchase_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table paymentmodecredit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paylaterservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_referal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_pharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionpaynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paylaterlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	materialreceiptnote_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table purchase_indent";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table consumedstock";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table iptest_procedures";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table approvalstatus";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table forex_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipconsultation_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	

	$query1 = "truncate table pharmacysalesreturn_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table medicine_return_request";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table purchaseorder_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipprivate_doctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactiondoctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table consultation_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table amendment_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table appointmentschedule_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paynowlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_purchase";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionaponaccount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipbedcharges";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table consultation_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_journalentries";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	resultentry_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paynowservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	
	$query1 = "truncate table discharge_icd";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table master_ipvisitentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_bedallocation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table ip_discharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipadmissioncharge";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table billing_ip";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionip";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table audit_master_medicine";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table openingstock_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table print_deliveryreport_billno";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table audit_master_lab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table bank_record";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_paylaterradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table completed_dispatch_billno";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table slade_claim";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	

	$query1 = "truncate table stock_take_adjust";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table billing_paynowradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table shift_tracking";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	manual_lpo";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table paylaterpharmareturns";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table bankentryform";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactiononaccount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ip_bedtransfer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ipconsultation_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_ipradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ipresultentry_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_transactionipdeposit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	patient_fingerprint_info";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	tempmedicineqty";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ip_bedtransfer";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	assets_register";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	sms_transactions";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	audit_master_services";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table 	cf_billno";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	paymententry_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	advance_payment_allocation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ip_vitalio";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	audit_master_radiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	//$query1 = "truncate table 	package_items";
	//$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ipmisc_billing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_ipmiscbilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	consultation_referal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ip_nhifprocessing";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table 	billing_ipnhif";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	consultation_ipadmission";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_ipprivatedoctor_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_paylaterreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);		$query1 = "truncate table 	billing_paylater";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_transactionadvancedeposit";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paylaterservices";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	adjust_advdeposits";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	ip_discount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paylaterconsultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paylaterpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table 	consultation_icd1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	audit_master_planname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	journal_updates";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	adhoc_creditnote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	fingerprint_login_details";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paynow";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	supplier_debit_transactions";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 		supplier_debits";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_paynowreferal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	login_restriction";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	approveddeposit_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	deposit_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	sickleave_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	depositrefund_request";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	mismail_send";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_triagebilling";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_consultation";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table 	audit_store_freeze";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	biometric_searches";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	discharge_revoked";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	dispensingfee";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paylaterlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table audit_master_visitentry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table dc_progressnotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_transactionipcreditapproved";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table billing_ipcreditapprovedtransaction";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	advance_payment_entry";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	master_test_parameter";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	audit_master_accountname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 		tb_opening_balances";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	refund_paynowpharmacy";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 		ip_creditapproval";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	billing_ipcreditapproved";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 		ip_creditapprovalformdata";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 		refund_paynowlab";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);


	$query1 = "truncate table crdradjustment_detail";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table debtors_invoice";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table mrdmovement";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table audit_master_subtype";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table pcrequest";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table refund_paynowradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table refund_paylaterradiology";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table fluidbalance";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table 	patientweivers";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_drugadmin";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table adhoc_debitnote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table assets_disposal";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_creditnotebrief";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_creditnote";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table audit_master_doctor";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ip_doctornotes";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_item_refund";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table sick_referral";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table ward_scheme_discount";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table dischargesummary";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table master_iptriage";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	//$query1 = "truncate table master_serviceslinking";
	//$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	//$query1 = "truncate table master_itemmapsupplier";
	//$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "truncate table doctor_weekdays";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	//$query1 = "truncate table master_customer";
	//$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	/* $query1 = "delete FROM master_employeerights where employeecode!='EMP00000001'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "delete FROM master_employeedepartment where employeecode!='EMP00000001'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "delete FROM master_employeelocation where employeecode!='EMP00000001'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "delete FROM master_employee where employeecode!='EMP00000001'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	$query1 = "delete FROM master_employeeinfo where employeecode!='EMP00000001'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
 */

	



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
