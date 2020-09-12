<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

if($_SESSION['account_role']=='user'){
    header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPCF - ACCOUNTING SYSTEM - DASHBOARD </title>
    <link rel="icon" href="../img/favicon.png" type="image/gif" sizes="16x16">

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Data Tables -->
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- end Data Tables -->

    <!-- Custom Style by Ronie Bituin-->
    <style type="text/css">
        .dropdown-menu{
            /*padding: 10px !important;*/
        }
        .topbar {
            /*height: 3rem !important; */
        }
        html{
            font-family: 'Roboto Condensed', sans-serif !important;
            font-size: 14px;
            scroll-behavior: smooth !important;
        }
        input.date{
            width: 10px;
        }

        #dataTable_wrapper,#fixtureTable_wrapper, #airconTable_wrapper, #forRepairTable_wrapper {
            width: 100% !important;
        }

        .bg-gradient-primary {
            background-color: #0f1e5d !important;
            background-image: none !important;
            background-image: none !important;
            background-size: cover !important;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #0f1e5d !important;
            border-color: #0f1e5d !important;
        }
        .container-fluid{
            background-color: white;
            /*padding-left: 5% !important;
            padding-right: 5% !important;*/
        }
        #content-wrapper{
            background-color: white !important;
        }
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            opacity: 0.7 !important; /* Firefox */
        }
        nav ul{
            position: sticky !important;
            top: 0;
            z-index: 99;
            white-space: normal;
        }
        nav ul li a{
            white-space: normal !important;
        }

    </style>
</head>

<body id="page-top">
