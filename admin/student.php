<?php
require_once 'process_student.php';

include('sidebar.php');
include('navbar.php');

$active_school_year = $_SESSION['active_school_year'];
$getStudents = mysqli_query($mysqli, "SELECT * FROM student WHERE school_year = '$active_school_year' ");

?>
<title>SPCF - Accounting Office</title>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <?php
        include('topbar.php');
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Students</h1>
            </div>

            <!-- Alert here -->
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php } ?>
            <!-- End Alert here -->

            <!-- Add Student Individual -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Student Individual (If does not exist)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_student.php">
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th >Student ID</th>
                                    <th >Full Name</th>
                                    <th width="20%">Department</th>
                                    <th width="20%">Level</th>
                                    <th width="">Semester</th>
                                    <th width="">School Year</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" name="student_id" class="form-control" placeholder="00001" required></td>
                                    <td><input type="text" name="full_name" class="form-control" placeholder="Marvin A. Domingo" required></td>
                                    <td>
                                        <select class="form-control" name="department" required>
                                            <option value="" selected disabled>Select Department</option>
                                            <option value="basic_ed">Basic Education (Kinder to Grade 10)</option>
                                            <option value="senior_hs">Senior High School</option>
                                            <option value="ccis">CCIS</option>
                                            <option value="cob">COB</option>
                                            <option value="coe">COE</option>
                                            <option value="com">COM</option>
                                            <option value="con">CON</option>
                                            <option value="chm">CHM</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="level" required>
                                            <option value="" selected disabled>Select Level</option>
                                            <option value="kinder">Kinder</option>
                                            <option value="prep">Prep</option>
                                            <option value="1">Grade 1</option>
                                            <option value="2">Grade 2</option>
                                            <option value="3">Grade 3</option>
                                            <option value="4">Grade 4</option>
                                            <option value="5">Grade 5</option>
                                            <option value="6">Grade 6</option>
                                            <option value="7">Grade 7</option>
                                            <option value="8">Grade 8</option>
                                            <option value="9">Grade 9</option>
                                            <option value="10">Grade 10</option>
                                            <option value="11">Grade 11</option>
                                            <option value="12">Grade 12</option>
                                            <option value="1">1st Year</option>
                                            <option value="2">2nd Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                            <option value="5">5th Year</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="semester" required>
                                            <option value="" selected disabled>Select Semester</option>
                                            <option value="1">1st Semester</option>
                                            <option value="2">2nd Semester</option>
                                            <option value="summer">Summer</option>
                                            <option value="0">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="school_year">
                                            <option value="2020-2021" selected>2020-2021</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="float-right btn btn-sm btn-primary m-1" name="save_student" type="submit"><i class="far fa-save" ></i> Save</button>
                            <a href="student.php" class="btn btn-danger btn-sm m-1 float-right"><i class="fas as fa-sync"></i> Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Student Individual-->

            <!-- Add Student Individual -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Import Student Lists (using Excel file)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_student.php" method="post" enctype="multipart/form-data" id="myForm">
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="30%">Select Filename</th>
                                    <th width="30%">Name the upload</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="form-control" accept=".csv" required name="excelFile" type="file" id="excelFile"/></td>
                                    <td><input type="text" name="upload_name" class="form-control" required placeholder="ex: Section and School Year" /></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary m-1" name="import_students" type="submit"><i class="far fa-save" ></i> Save</button>
                                        <a href="student.php" class="btn btn-danger btn-sm m-1"><i class="fas as fa-sync"></i> Cancel</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                        </form>
                        Before importing the data, please ask for assistance and contact ICTDU. Tel: 09270417431;<br/>
                        Please make sure that proper structure is being followed. Download this <a target="_blank" href="template/template.csv">template</a> for reference.
                    </div>
                </div>
            </div>
            <!-- End Add Student Individual-->

            <!-- List of Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Students</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="studentTable">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>Semester</th>
                                    <th>School Year</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($newStudents=$getStudents->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $newStudents['student_id']; ?></td>
                                    <td><?php echo $newStudents['full_name']; ?></td>
                                    <td><?php echo strtoupper($newStudents['dept']); ?></td>
                                    <td><?php echo strtoupper($newStudents['level']); ?></td>
                                    <td><?php echo strtoupper($newStudents['level']); ?></td>
                                    <td><?php echo strtoupper($newStudents['school_year']); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Item Lists -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- JS here -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#studentTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
