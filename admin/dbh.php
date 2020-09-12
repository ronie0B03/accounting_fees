<?php
if (!isset($_SESSION)) {
    session_start();
}

$host = 'localhost';
$username = 'ronie';
$password = 'ronie';
$database = 'spcf_accounting_fees';

$mysqli = new mysqli($host, $username, $password, $database) or die(mysqli_error($mysqli));


?>