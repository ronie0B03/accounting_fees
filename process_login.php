<?php
include 'dbh.php';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $checkAccount = $mysqli->query("SELECT * FROM accounts WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($checkAccount) > 0) {
        $newAccoount = $checkAccount->fetch_array();

        $_SESSION['username'] = $newAccoount['username'];
        $_SESSION['account_full_name'] = $newAccoount['full_name'];
        $_SESSION['account_role'] = $newAccoount['role'];
        $_SESSION['account_id'] = $newAccoount['id'];

        $_SESSION['active_school_year'] = '2020-2021';

        header("location: index.php");
    }
    else
    {
        $_SESSION['logInError'] = "Credentials do not match our records. Login failed. Please try again";
        header("location: login.php");
    }
}
?>