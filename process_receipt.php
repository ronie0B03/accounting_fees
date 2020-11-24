<?php

include ('dbh.php');

$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if(isset($_POST['print_receipt'])){
    echo $control_id = $_POST['control_id'];
    echo $account_cashier = $_SESSION['account_full_name'];

    $sql = "INSERT INTO issue_receipt (transaction_id, issue_date, account_cashier ) VALUES('$control_id', '$date', '$account_cashier' )";

    if (mysqli_query($mysqli, $sql)) {
        $receipt_id = mysqli_insert_id($mysqli);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }

    //Add Logs - Generate Receipt
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Generate Receipt. Transaction ID:'.$control_id;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Generate Receipt', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    header('location: print_transaction.php?id='.$receipt_id);
}

if(isset($_POST['get_report_individual'])){
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    header("location: view_transactions_lists.php?from_date=".$from_date."&to_date=".$to_date);

}

?>