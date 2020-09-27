<?php

include ('dbh.php');

if(isset($_POST['save_payable'])){
    $item_id = $_POST['item_id'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $school_year = $_POST['school_year'];

    $mysqli->query("INSERT INTO payable (item_id, department, level, school_year) VALUES('$item_id', '$department', '$level', '$school_year' ) ") or die($mysqli->error());

    $_SESSION['message'] = "Payable has been associated!";
    $_SESSION['msg_type'] = "success";
    header("location: payable.php");
}
?>