<?php

include ('dbh.php');

$getURI = $_SESSION['getURI'];

$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
/*
 * 2020-09-10
if(isset($_POST['add_item'])){
    $itemCtrl = mysqli_real_escape_string($mysqli, $_POST['itemCtrl']);
    $itemCounter = ++$itemCtrl;
    do{
        $item = mysqli_real_escape_string($mysqli, $_POST['item'.$itemCtrl]);
        $getURI = $getURI.'&item'.$itemCtrl.'='.$item;

        $qty = mysqli_real_escape_string($mysqli, $_POST['qty'.$itemCtrl]);
        $getURI = $getURI.'&qty'.$itemCtrl.'='.$qty;

        //$price = mysqli_real_escape_string($mysqli, $_POST['price'.$itemCtrl]);
        $getPrice = $mysqli->query("SELECT * FROM inventory WHERE id='$item' ") or die ($mysqli->error());
        $newPrice = $getPrice->fetch_array();
        $price = $newPrice['item_price'];
        $getURI = $getURI.'&price'.$itemCtrl.'='.$price;

        $itemCtrl--;
    }while($itemCtrl!=0);

    $getURI = $getURI.'&itemCtrl='.$itemCounter;
    header("location: ".$getURI);
}

if(isset($_POST['save'])){
    $itemCtrl = mysqli_real_escape_string($mysqli, $_POST['itemCtrl']);
    $itemController = 1;
    $transactionID = mysqli_real_escape_string($mysqli, $_POST['transactionID']);

    $full_name = mysqli_real_escape_string($mysqli, $_POST['full_name']);
    $student_id = mysqli_real_escape_string($mysqli, $_POST['student_id']);
    $amount_paid = mysqli_real_escape_string($mysqli, $_POST['amount_paid']);

    $total=0;
    while($itemCtrl!=0){
        $item = mysqli_real_escape_string($mysqli, $_POST['item'.$itemCtrl]);
        $qty = mysqli_real_escape_string($mysqli, $_POST['qty'.$itemCtrl]);
        $price = mysqli_real_escape_string($mysqli, $_POST['price'.$itemCtrl]);

        if($qty!=NULL){
            $subTotal = $price*$qty;
            $mysqli->query("INSERT INTO transaction_lists (transaction_id, item_id, qty, price, transaction_date, subtotal) VALUES('$transactionID', '$item', '$qty', '$price','$date','$subTotal' )") or die($mysqli->error());
            //Update Inventory
            $getQtyInventory = mysqli_query($mysqli, "SELECT * FROM inventory WHERE id = '$item' ");
            $newQtyInventory = $getQtyInventory->fetch_array();
            $inventoryQty = $newQtyInventory['qty'] - $qty;
            $mysqli->query("UPDATE inventory SET qty='$inventoryQty' WHERE id='$item' ") or die ($mysqli->error());
        }

        echo $total += $subTotal;

        $itemController++;
        $itemCtrl--;
    }

    $mysqli->query("INSERT INTO transaction (id, full_name, transaction_date, student_id, total_amount, amount_paid) VALUES('$transactionID', '$full_name', '$date', '$student_id', '$total', '$amount_paid' )") or die($mysqli->error());

    $_SESSION['message'] = "Transaction has been saved!";
    $_SESSION['msg_type'] = "success";

    header('location: transactions.php');
}
*/
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
    $context = 'Transaction - Add Item. Transaction ID:'.$transactionID.', Item ID: '.$item.', Transaction Date: '.$date.', Subtotal: ₱'.$subTotal;
    $context = mysqli_real_escape_string($mysqli, $context);
    $mysqli->query("INSERT INTO logs (log_type, log_date, account_cashier, context) VALUES('Transaction - Add Item', '$logDate', '$accountCashier', '$context') ") or die($mysqli->error());

    $_SESSION['message'] = "Item has been added!";
    $_SESSION['msg_type'] = "success";

    header("location: ".$getURI);

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
    $context = 'Transaction - Finish Order. Transaction ID:'.$transactionID.', Full Name: '.$full_name.', Transaction Date: '.$date.', Total: ₱'.$total.', Amount Paid: ₱'.$amount_paid;
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
        $context = 'Initiate Order. Transaction ID:'.$last_id.', Student ID: '.$student_id.', full_name: '.$full_name.', transaction_date: '.$date;
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


?>