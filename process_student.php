<?php
include ('dbh.php');

if(isset($_POST['save_student'])){
    $student_id = mysqli_real_escape_string($mysqli, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($mysqli, $_POST['full_name']);
    $department = mysqli_real_escape_string($mysqli,$_POST['department']);
    $level = mysqli_real_escape_string($mysqli, $_POST['level']);
    $semester = mysqli_real_escape_string($mysqli, $_POST['semester']);
    $school_year = mysqli_real_escape_string($mysqli, $_POST['school_year']);

    $mysqli->query("INSERT INTO student (student_id, full_name, dept, level, semester, school_year) VALUES('$student_id', '$full_name', '$department', '$level', '$semester', '$school_year') ") or die($mysqli->error());

    $_SESSION['message'] = "Student Added!";
    $_SESSION['msg_type'] = "success";
    header("location: student.php");
}


//Bulk addition using import
if(isset($_POST['import_students'])){
    $upload_name = mysqli_real_escape_string($mysqli, $_POST['upload_name']);
    $fileextension = strtolower(pathinfo($_FILES['excelFile']['name'],PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["excelFile"]["tmp_name"], "excel.csv");

    $file = file("excel.csv");
    foreach ($file as $k) {
        $csv[] = str_getcsv($k, ",", '"');
    }
    $upload_id = time().rand(0,1000000);
    for($i = 1; $i < count($csv); $i++){
        $stud_id = $csv[$i][0];
        $stud_id = str_replace('-',"",$stud_id);
        $stud_fullname = str_replace('"',"",$csv[$i][1]);
        $department = $csv[$i][2];
        $level = $csv[$i][3];
        $semester = $csv[$i][4];
        $school_year = $csv[$i][5];
        if(!empty($stud_id))
            mysqli_query($mysqli,"INSERT INTO student values('NULL','$stud_id','$stud_fullname','$level','$department','$school_year','$semester', '$upload_id')");
    }

    $date = date_default_timezone_set('Asia/Manila');
    $date = date("y-m-d h:i:sa");
    mysqli_query($mysqli,"INSERT INTO uploads values('NULL','$upload_name','$date','$upload_id')");

    $_SESSION['message'] = "Bulk import done!";
    $_SESSION['msg_type'] = "success";
    header("location: student.php");
}

if(isset($_GET['delete'])){
    $upload_id = $_GET['delete'];
    mysqli_query($mysqli,"DELETE FROM uploads where upload_id = '$upload_id' ");
    mysqli_query($mysqli,"DELETE FROM student where upload_id = '$upload_id' ");

    $_SESSION['message'] = "Uploads deleted!";
    $_SESSION['msg_type'] = "danger";
    header("location: uploads.php");
}
?>