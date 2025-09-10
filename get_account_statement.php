<?php
session_start();
include ("db/db_connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get search parameters
$search_account = isset($_GET['search_account']) ? $_GET['search_account'] : '';
$search_account_code = isset($_GET['search_account_code']) ? $_GET['search_account_code'] : '';
$search_account_anum = isset($_GET['search_account_anum']) ? $_GET['search_account_anum'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-1 month'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');

// Validate required parameters
if (empty($search_account_code) || empty($search_account_anum)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Account code and account number are required']);
    exit;
}

// Get account information
$query_acc = "SELECT * FROM master_accountname WHERE id = ?";
$stmt_acc = mysqli_prepare($GLOBALS["___mysqli_ston"], $query_acc);
mysqli_stmt_bind_param($stmt_acc, 's', $search_account_code);
mysqli_stmt_execute($stmt_acc);
$result_acc = mysqli_stmt_get_result($stmt_acc);

if (!$result_acc || mysqli_num_rows($result_acc) == 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Account not found']);
    exit;
}

$account_info = mysqli_fetch_array($result_acc);
$currency = $account_info['currency'];

// Get exchange rate
$cur_qry = "SELECT * FROM master_currency WHERE currency LIKE ?";
$stmt_cur = mysqli_prepare($GLOBALS["___mysqli_ston"], $cur_qry);
mysqli_stmt_bind_param($stmt_cur, 's', $currency);
mysqli_stmt_execute($stmt_cur);
$result_cur = mysqli_stmt_get_result($stmt_cur);
$currency_info = mysqli_fetch_array($result_cur);
$exchange_rate = $currency_info['rate'] ?: 1;

// Calculate opening balance
$opening_balance = 0;
$opening_balance_query = "SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `transactiondate` < ? AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'
                         UNION ALL SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `transactiondate` < ? AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
                         UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `transactiondate` < ? AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%AOP%'
                         UNION ALL SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = ? AND b.billtype = 'PAY LATER' AND a.`transactiondate` < ?
                         UNION ALL SELECT SUM(`fxamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = ? AND `billdate` < ?
                         UNION ALL SELECT SUM(`debitamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = ? AND `entrydate` < ?
                         UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `docno` LIKE '%Cr.N%' AND `transactiondate` < ? AND `transactiontype` = 'paylatercredit'
                         UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `docno` LIKE '%CRN%' AND `transactiondate` < ? AND `transactiontype` = 'paylatercredit'
                         UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `docno` LIKE '%DBN%' AND `transactiondate` < ? AND `transactiontype` = 'paylaterdebit'
                         UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `billnumber` LIKE '%IPCr%' AND `transactiondate` < ? AND `transactiontype` = 'paylatercredit'
                         UNION ALL SELECT SUM(-1*`amount`) as paylater FROM `paylaterpharmareturns` WHERE billdate < ? AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = ? and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
                         UNION ALL SELECT SUM(-1*`openbalanceamount`) as paylater FROM `openingbalancesupplier` WHERE `accountcode` = ? AND `entrydate` < ?
                         UNION ALL SELECT SUM(-1*`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = ? AND `transactiondate` < ? AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
                         UNION ALL SELECT SUM(-1*`creditamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = ? AND `entrydate` < ?";

$stmt_opening = mysqli_prepare($GLOBALS["___mysqli_ston"], $opening_balance_query);
$params = array_fill(0, 32, $search_account_code);
$date_params = array_fill(0, 16, $date_from);
$params = array_merge($params, $date_params);
$types = str_repeat('s', count($params));
mysqli_stmt_bind_param($stmt_opening, $types, ...$params);
mysqli_stmt_execute($stmt_opening);
$result_opening = mysqli_stmt_get_result($stmt_opening);

while ($row = mysqli_fetch_array($result_opening)) {
    $paylater = $row['paylater'] ?: 0;
    $opening_balance += $paylater / $exchange_rate;
}

// Get transactions
$transactions_query = "SELECT groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from(
    select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano=? and accountnameid=? and transactiontype = 'finalize' and transactiondate between ? and ? and fxamount <>'0' and billnumber not like 'AOP%'
    union all select transactiondate as groupdate,patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano=? and accountnameid=? and transactiontype = 'finalize' and transactiondate between ? and ? and billnumber like 'AOP%'
    union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano=? and accountnameid=? and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between ? and ?
    union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano=? and accountnameid=? and transactiontype = 'paylaterdebit' and recordstatus <> 'deallocated' and transactiondate between ? and ?
    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = ? and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN ? AND ?
    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = ? and accountnameid=? and transactiondate between ? and ? and transactionstatus in ('onaccount','paylatercredit')
    union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars, selecttype as transactionmode, selecttype as subtypeano, '' as chequenumber, transactionamount as fxamount, auto_number, vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = ? AND `entrydate` BETWEEN ? AND ?
) as t order by groupdate asc";

$stmt_transactions = mysqli_prepare($GLOBALS["___mysqli_ston"], $transactions_query);
$transaction_params = array_fill(0, 24, $search_account_anum);
$transaction_params = array_merge($transaction_params, array_fill(0, 24, $search_account_code));
$transaction_params = array_merge($transaction_params, array_fill(0, 12, $date_from));
$transaction_params = array_merge($transaction_params, array_fill(0, 12, $date_to));
$types = str_repeat('s', count($transaction_params));
mysqli_stmt_bind_param($stmt_transactions, $types, ...$transaction_params);
mysqli_stmt_execute($stmt_transactions);
$result_transactions = mysqli_stmt_get_result($stmt_transactions);

$transactions = [];
$total_debit = 0;
$total_credit = 0;
$current_balance = $opening_balance;
$aging_buckets = [
    '30' => 0,
    '60' => 0,
    '90' => 0,
    '120' => 0,
    '180' => 0,
    '180_plus' => 0
];

while ($row = mysqli_fetch_array($result_transactions)) {
    $transaction_date = $row['groupdate'];
    $patient_name = $row['patientname'] ?: 'N/A';
    $patient_code = $row['patientcode'] ?: 'N/A';
    $visit_code = $row['visitcode'] ?: 'N/A';
    $bill_number = $row['billnumber'] ?: 'N/A';
    $particulars = $row['particulars'] ?: '';
    $transaction_type = $row['transactiontype'];
    $fx_amount = $row['fxamount'] ?: 0;
    
    // Convert amount to base currency
    $amount = $fx_amount / $exchange_rate;
    
    // Calculate days between transaction date and end date
    $t1 = strtotime($date_to);
    $t2 = strtotime($transaction_date);
    $days_between = ceil(abs($t1 - $t2) / 86400);
    
    // Update current balance
    if ($transaction_type == 'finalize') {
        $current_balance += $amount;
        $total_debit += $amount;
    } elseif ($transaction_type == 'paylatercredit' || $transaction_type == 'JOURNAL') {
        $current_balance -= $amount;
        $total_credit += $amount;
    }
    
    // Calculate aging buckets
    if ($amount > 0) {
        if ($days_between <= 30) {
            $aging_buckets['30'] += $amount;
        } elseif ($days_between <= 60) {
            $aging_buckets['60'] += $amount;
        } elseif ($days_between <= 90) {
            $aging_buckets['90'] += $amount;
        } elseif ($days_between <= 120) {
            $aging_buckets['120'] += $amount;
        } elseif ($days_between <= 180) {
            $aging_buckets['180'] += $amount;
        } else {
            $aging_buckets['180_plus'] += $amount;
        }
    }
    
    // Get MRD number
    $mrd_number = '';
    if (!empty($patient_code) && $patient_code != 'N/A') {
        $mrd_query = "SELECT mrdno FROM master_customer WHERE customercode = ?";
        $stmt_mrd = mysqli_prepare($GLOBALS["___mysqli_ston"], $mrd_query);
        mysqli_stmt_bind_param($stmt_mrd, 's', $patient_code);
        mysqli_stmt_execute($stmt_mrd);
        $result_mrd = mysqli_stmt_get_result($stmt_mrd);
        if ($mrd_row = mysqli_fetch_array($result_mrd)) {
            $mrd_number = $mrd_row['mrdno'] ?: '';
        }
    }
    
    // Get dispatch date
    $dispatch_date = '';
    if (!empty($bill_number) && $bill_number != 'N/A') {
        $dispatch_query = "SELECT updatedate FROM completed_billingpaylater WHERE billno = ?";
        $stmt_dispatch = mysqli_prepare($GLOBALS["___mysqli_ston"], $dispatch_query);
        mysqli_stmt_bind_param($stmt_dispatch, 's', $bill_number);
        mysqli_stmt_execute($stmt_dispatch);
        $result_dispatch = mysqli_stmt_get_result($stmt_dispatch);
        if ($dispatch_row = mysqli_fetch_array($result_dispatch)) {
            $dispatch_date = $dispatch_row['updatedate'] ?: '';
        }
    }
    
    $transactions[] = [
        'date' => $transaction_date,
        'description' => $patient_name . ' (' . $patient_code . ', ' . $visit_code . ', ' . $bill_number . ') ' . $particulars,
        'mrd_number' => $mrd_number,
        'bill_number' => $bill_number,
        'dispatch_date' => $dispatch_date,
        'debit' => $transaction_type == 'finalize' ? number_format($amount, 2) : '',
        'credit' => ($transaction_type == 'paylatercredit' || $transaction_type == 'JOURNAL') ? number_format($amount, 2) : '',
        'days' => $days_between,
        'current_balance' => number_format($current_balance, 2),
        'transaction_type' => $transaction_type
    ];
}

// Set JSON header
header('Content-Type: application/json');

// Return the data
echo json_encode([
    'success' => true,
    'account_info' => [
        'name' => $account_info['accountname'],
        'code' => $account_info['accountcode'],
        'currency' => $currency,
        'exchange_rate' => $exchange_rate
    ],
    'summary' => [
        'opening_balance' => number_format($opening_balance, 2),
        'total_debit' => number_format($total_debit, 2),
        'total_credit' => number_format($total_credit, 2),
        'current_balance' => number_format($current_balance, 2),
        'aging_buckets' => [
            '30_days' => number_format($aging_buckets['30'], 2),
            '60_days' => number_format($aging_buckets['60'], 2),
            '90_days' => number_format($aging_buckets['90'], 2),
            '120_days' => number_format($aging_buckets['120'], 2),
            '180_days' => number_format($aging_buckets['180'], 2),
            '180_plus_days' => number_format($aging_buckets['180_plus'], 2)
        ]
    ],
    'transactions' => $transactions
]);
?>
