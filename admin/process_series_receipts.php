<?php
include ('dbh.php');

if(isset($_POST['save'])){
    $series_id = mysqli_real_escape_string($mysqli, $_POST['series_id']);
    $series_from = mysqli_real_escape_string($mysqli, $_POST['series_from']);
    $series_to = mysqli_real_escape_string($mysqli, $_POST['series_to']);
    $account = mysqli_real_escape_string($mysqli, $_POST['account']);

    $mysqli->query("INSERT INTO series_controller (id, series_from, series_to, account_cashier) VALUES('$series_id','$series_from','$series_to', '$account')") or die($mysqli->error());

    $_SESSION['message'] = "A series has been associated!";
    $_SESSION['msg_type'] = "success";
    header('location: series_receipt.php');
}

?>



