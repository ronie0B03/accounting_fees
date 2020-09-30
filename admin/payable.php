<?php
require_once 'process_student.php';

include('sidebar.php');
include('navbar.php');

$active_school_year = $_SESSION['active_school_year'];
$getItems = mysqli_query($mysqli, "SELECT * FROM inventory ");

//Get Payables
$getPayable = mysqli_query($mysqli, "SELECT *,p.id AS payable_id FROM payable p
JOIN inventory i
ON i.id = p.item_id ");

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
                <h1 class="h3 mb-0 text-gray-800">Payable</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Add account payable of certain level (one at a time)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_payable.php">
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th width="20%">Department</th>
                                    <th width="20%">Level</th>
                                    <th width="">School Year</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="item_id">
                                            <?php while($newItems=$getItems->fetch_assoc()){ ?>
                                            <option value="<?php echo $newItems['id']; ?>"><?php echo $newItems['item_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
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
                                        <select class="form-control" name="school_year">
                                            <option value="<?php echo $active_school_year; ?>" selected>2020-2021</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="float-right btn btn-sm btn-primary m-1" name="save_payable" type="submit"><i class="far fa-save" ></i> Save</button>
                            <a href="student.php" class="btn btn-danger btn-sm m-1 float-right"><i class="fas as fa-sync"></i> Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Student Individual-->

            <!-- List of Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Account Payables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="payableTable">
                            <thead>
                                <tr>
                                    <th>ID/th>
                                    <th>Name / Service</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>School Year</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($newPayable=$getPayable->fetch_assoc()){ ?>
                                    <td>
                                        <a href="report_receivables_classified.php?id=<?php echo $newPayable['payable_id']; ?>" target="_blank">
                                        <?php echo strtoupper($newPayable['payable_id']); ?>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="report_receivables_classified.php?id=<?php echo $newPayable['payable_id']; ?>" target="_blank">
                                        <?php echo strtoupper($newPayable['item_name']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="report_receivables_classified.php?id=<?php echo $newPayable['payable_id']; ?>" target="_blank">
                                        <?php echo strtoupper($newPayable['department']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $newPayable['level']; ?></td>
                                    <td><?php echo $newPayable['school_year']; ?></td>
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
            $('#payableTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
