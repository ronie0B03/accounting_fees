<?php

include('dbh.php');

if(isset($_POST['get_report'])){
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    header("location: report.php?from_date=".$from_date."&to_date=".$to_date);

}

if(isset($_POST['get_report_individual'])){
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    header("location: report_individual.php?from_date=".$from_date."&to_date=".$to_date);

}

?>