<?php

include ('dbh.php');

if(isset($_POST['save'])){
    $supplier_id = mysqli_real_escape_string($mysqli, $_POST['supplier_id']);
    $supplier_name = mysqli_real_escape_string($mysqli, $_POST['supplier_name']);
    $contact_no = mysqli_real_escape_string($mysqli, $_POST['contact_no']);
    $email_address = mysqli_real_escape_string($mysqli, $_POST['email_address']);
    $other_info = mysqli_real_escape_string($mysqli, $_POST['other_info']);

    $mysqli->query("INSERT INTO supplier (id, supplier_name, contact_no, email_address, other_info) VALUES('$supplier_id','$supplier_name','$contact_no', '$email_address', '$other_info')") or die($mysqli->error());

    $_SESSION['message'] = "A supplier has been added!";
    $_SESSION['msg_type'] = "success";
    header('location: supplier.php');


}

if(isset($_POST['update'])){
    $supplier_id = mysqli_real_escape_string($mysqli, $_POST['supplier_id']);
    $supplier_name = mysqli_real_escape_string($mysqli, $_POST['supplier_name']);
    $contact_no = mysqli_real_escape_string($mysqli, $_POST['contact_no']);
    $email_address = mysqli_real_escape_string($mysqli, $_POST['email_address']);
    $other_info = mysqli_real_escape_string($mysqli, $_POST['other_info']);

    $mysqli->query("UPDATE supplier SET supplier_name='$supplier_name', contact_no='$contact_no', email_address='$email_address', other_info='$other_info' WHERE id = '$supplier_id'  ") or die($mysqli->error());

    $_SESSION['message'] = "A supplier has been updated!";
    $_SESSION['msg_type'] = "info";
    header('location: supplier.php');


}


if(isset($_GET['edit'])){
    $edit = true;
    $id = $_GET['edit'];
    $getSupplier = $mysqli->query("SELECT * FROM supplier WHERE id='$id' ") or die ($mysqli->error());
    $newSupplier = $getSupplier->fetch_array();

    $supplier_id = $newSupplier['id'];
    $supplier_name = $newSupplier['supplier_name'];
    $contact_no = $newSupplier['contact_no'];
    $email_address = $newSupplier['email_address'];
    $other_info = $newSupplier['other_info'];
}
else{
    $edit = false;
}

?>