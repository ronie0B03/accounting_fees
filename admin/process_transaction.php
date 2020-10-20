<?php

include ('dbh.php');

$getURI = $_SESSION['getURI'];

$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if(isset($_POST['add_item'])){
    $transactionID = mysqli_real_escape_string($mysqli,$_POST['transactionID']);
    $item = mysqli_real_escape_string($mysqli, $_POST['item']);
    $qty = mysqli_real_escape_string($mysqli, $_POST['qty']);
    $getPrice = $mysqli->query("SELECT * FROM inventory WHERE id='$item' ") or die ($mysqli->error());
    $newPrice = $getPrice->fetch_array();
    $price = $newPrice['item_price'];

    $subTotal = floatval($price) * floatval($qty);

    $mysqli->query("INSERT INTO transaction_lists (transaction_id, item_id, qty, price, transaction_date, subtotal) VALUES('$transactionID', '$item', '$qty', '$price','$date','$subTotal' )") or die($mysqli->error());

    //Update Inventory
    $getQtyInventory = mysqli_query($mysqli, "SELECT * FROM inventory WHERE id = '$item' ");
    $newQtyInventory = $getQtyInventory->fetch_array();
    $inventoryQty = $newQtyInventory['qty'] - $qty;
    $mysqli->query("UPDATE inventory SET qty='$inventoryQty' WHERE id='$item' ") or die ($mysqli->error());


    //Add Logs - Add Items in order
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Transaction - Add Item. Transaction ID:'.$transactionID.', Item ID: '.$item.', Transaction Date: '.$date.', Sub Total: '.$subTotal;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Add Item', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] = "Item has been added!";
    $_SESSION['msg_type'] = "success";

    #header("location: ".$getURI); //2020-10-20
    header("location: transactions.php?account");

}

if(isset($_POST['save'])){
    $transactionID = mysqli_real_escape_string($mysqli, $_POST['transactionID']);

    $full_name = mysqli_real_escape_string($mysqli, $_POST['full_name']);
    $student_id = mysqli_real_escape_string($mysqli, $_POST['student_id']);
    $amount_paid = mysqli_real_escape_string($mysqli, $_POST['amount_paid']);
    $total = mysqli_real_escape_string($mysqli, $_POST['grand_total']);

    $change = $amount_paid - $total;

    $mysqli->query("UPDATE transaction SET amount_paid='$amount_paid', total_amount='$total', amount_change = '$change', status_transact='1' WHERE id='$transactionID' ") or die ($mysqli->error());

    //Add Logs - Finish Order
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Transaction - Finish Order. Transaction ID:'.$transactionID.', Full Name: '.$full_name.', Transaction Date: '.$date.', Total: ₱'.$total.', Amount Paid: ₱'.$amount_paid.' Change: ₱'.$change;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Finish Order', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] = "Transaction has been completed!";
    $_SESSION['msg_type'] = "success";

    header("location: view_transaction.php?id=".$transactionID);

}


if(isset($_POST['update_payment'])){
    $transaction_id = mysqli_real_escape_string($mysqli, $_POST['transaction_id']);
    $total_amount_paid = mysqli_real_escape_string($mysqli, $_POST['total_amount_paid']);
    $pay_amount = mysqli_real_escape_string($mysqli, $_POST['pay_amount']);

    $total_amount_paid = $total_amount_paid + $pay_amount;
    $mysqli->query("UPDATE transaction SET amount_paid='$total_amount_paid' WHERE id='$transaction_id' ") or die ($mysqli->error());

    $_SESSION['message'] = "Transaction has been updated!";
    $_SESSION['msg_type'] = "success";

    header('location: '.$getURI);
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query(" DELETE FROM transaction WHERE id = '$id' ") or die($mysqli->error());
    $mysqli->query(" DELETE FROM transaction_lists WHERE transaction_id = '$id' ") or die($mysqli->error());

    $_SESSION['message'] = "Transaction has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header('location: transactions.php');
}


//Initiating Transaction
if(isset($_POST['find_student'])){
    $student_id = mysqli_real_escape_string($mysqli, $_POST['student_id']);
    $getStudent = $mysqli->query(" SELECT * FROM student WHERE student_id = '$student_id' ") or die($mysqli->error());
    if(mysqli_num_rows($getStudent) > 0)
    {
        $newStudent = $getStudent->fetch_array();
        $_SESSION['student_id'] = $newStudent['student_id'];
        $_SESSION['full_name'] = $newStudent['full_name'];
        $_SESSION['level'] = $newStudent['level'];

        $student_id = $_SESSION['student_id'];
        $full_name = $newStudent['full_name'];
        $cashier_account = $_SESSION['account_full_name'];
        $sql = "INSERT INTO transaction (student_id, full_name, transaction_date, cashier_account) VALUES('$student_id', '$full_name', '$date','$cashier_account' )";

        if (mysqli_query($mysqli, $sql)) {
            $last_id = mysqli_insert_id($mysqli);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
        $_SESSION['current_transact_id'] = $last_id;

        //Add Logs - Initiate Order
        $accountCashier = $_SESSION['account_full_name'];
        $logDate = date_default_timezone_set('Asia/Manila');
        $logDate = date('Y-m-d H:i:s');
        $context = 'Initiate Order. Transaction ID:'.$last_id.', Student ID: '.$student_id.', Full Name: '.$full_name.', Transaction Date: '.$date;
        $context = mysqli_real_escape_string($mysqli, $context);
        $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Initiate Order', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

        $_SESSION['message'] = "Student found!";
        $_SESSION['msg_type'] = "primary";
        header("location: transactions.php?account=1");
    }
    else{
        $_SESSION['message'] =  $student_id. " does not exists in our database, please re-type the ID or Click the NEW CUSTOMER instead.";
        $_SESSION['msg_type'] = "warning";
        header("location: ".$getURI);
    }
}
else if(isset($_POST['new_cust'])){
    $full_name = $_POST['new_cust_name'];
    $_SESSION['full_name'] = $full_name;
    $_SESSION['student_id'] = '-1';
    $_SESSION['level'] = 'NA';

    $student_id = $_SESSION['student_id'];
    $cashier_account = $_SESSION['account_full_name'];

    $sql = "INSERT INTO transaction (student_id, full_name, transaction_date, cashier_account ) VALUES('$student_id', '$full_name', '$date', '$cashier_account' )";

    if (mysqli_query($mysqli, $sql)) {
        $last_id = mysqli_insert_id($mysqli);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
    $_SESSION['current_transact_id'] = $last_id;

    //Add Logs - Initiate Order
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Initiate Order. Transaction ID:'.$last_id.', Student ID: '.$student_id.', Full Name: '.$full_name.', Transaction Date: '.$date;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Initiate Order', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] =  "New Transaction";
    $_SESSION['msg_type'] = "primary";
    header("location: transactions.php?account=0");
}

if(isset($_GET['void'])){
    $id = $_GET['void'];
    $qty = $_GET['qty'];
    $item_id = $_GET['item'];
    $price = $_GET['price'];
    $sub_total = $_GET['sub_total'];
    $item_name = $_GET['item_name'];

    $transaction_id = $_GET['transaction_id'];

    //Get Item Qty
    $getItem = $mysqli->query(" SELECT * FROM inventory WHERE id = '$item_id' ") or die($mysqli->error());
    $newItem = $getItem->fetch_array();
    $currentQty = $newItem['qty'];
    $currentQty = $currentQty + $qty;
    //Update Item Qty
    $mysqli->query("UPDATE inventory SET qty='$currentQty' WHERE id='$item_id' ") or die ($mysqli->error());
    $mysqli->query("UPDATE transaction_lists SET void='1' WHERE id='$id' ") or die ($mysqli->error());

    //Add Logs - Void Item In Order
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Void Item In Order. Transaction ID:'.$transaction_id.' Item ID:'.$item_id.' Item Name: '.$item_name.' Price: ₱'.$price.' Sub Total: ₱'.$sub_total;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Void Item In Order', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] =  "Item has been nullified.";
    $_SESSION['msg_type'] = "danger";

    header("location: list_transactions.php");

}

//Function Cancel Order
if(isset($_GET['cancel'])){
    $id = $_GET['cancel'];
    $getTransactionLists = $mysqli->query(" SELECT *, tl.qty AS tl_qty, i.qty AS i_qty, tl.transaction_id AS tl_transaction_id
    FROM transaction_lists tl
    JOIN inventory i ON i.id = tl.item_id
    WHERE tl.transaction_id = '$id' AND tl.void = '0' ") or die($mysqli->error());

    while($newTransactionLists=$getTransactionLists->fetch_assoc()){
        $item_id = $newTransactionLists['item_id'];
        echo $tl_transaction_id = $newTransactionLists['tl_transaction_id'];
        $tl_qty = $newTransactionLists['tl_qty'];
        $i_qty = $newTransactionLists['i_qty'];
        $i_qty = $i_qty + $tl_qty;
        //Update item Qty
        $mysqli->query("UPDATE inventory SET qty='$i_qty' WHERE id='$item_id' ") or die ($mysqli->error());
        //Update transaction lists
        $mysqli->query("UPDATE transaction_lists SET void='1' WHERE transaction_id='$tl_transaction_id' ") or die ($mysqli->error());

    }

    //Update Transaction
    $getTransaction = $mysqli->query(" SELECT * FROM transaction WHERE id = '$id' ") or die($mysqli->error());
    $newTransaction = $getTransaction->fetch_array();
    $status_transact = $newTransaction['status_transact'];
    $total_amount = $newTransaction['total_amount'];
    $student_id = $newTransaction['student_id'];
    $full_name = $newTransaction['full_name'];
    if($status_transact==1){
        $total_amount = $total_amount;
    }
    else{
        // Do nothing for now
    }
    $mysqli->query("UPDATE transaction SET status_transact='-1', total_amount='$total_amount' WHERE id='$id' ") or die ($mysqli->error());

    //Add Logs - Void Item In Order
    $accountCashier = $_SESSION['account_full_name'];
    $logDate = date_default_timezone_set('Asia/Manila');
    $logDate = date('Y-m-d H:i:s');
    $context = 'Transaction - Cancel Transaction. Transaction ID:'.$id.' Student ID:'.$student_id.' Full Name: '.$full_name.' Total Amount Returned: ₱'.$total_amount;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Cancel Transaction', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] =  "Transaction with this ID: ".$id." has been nullified.";
    $_SESSION['msg_type'] = "danger";

    header("location: today_transaction.php");
}

?>