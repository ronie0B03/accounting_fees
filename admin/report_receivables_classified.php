<?php
require_once 'process_student.php';

include('sidebar.php');
include('navbar.php');

$active_school_year = $_SESSION['active_school_year'];
$getItems = mysqli_query($mysqli, "SELECT * FROM inventory ");
$payableID = $_GET['id'];
$getPayable = mysqli_query($mysqli, "SELECT * FROM payable p
JOIN inventory i
ON i.id = p.item_id
WHERE p.id = '$payableID' ");
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
                <h1 class="h3 mb-0 text-gray-800">Account Receivables Based on Payable Association</h1>
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

            <!-- Start Receiveables in Card -->
            <?php while($newPayable=$getPayable->fetch_assoc()){
                $department = $newPayable['department'];
                $level = $newPayable['level'];
                $item_id = $newPayable['item_id'];
                ?>

            <!-- List of Receiveables in Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo 'DEPARTMENT: '.strtoupper($newPayable['department']).' YEAR: '.strtoupper($newPayable['level']).' ITEM NAME: '.strtoupper($newPayable['item_name']); ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="payableTable">
                            <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Transaction Date</th>
                                <th>Paid</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $getReceivables = mysqli_query($mysqli, "SELECT s.student_id, s.full_name, tl.transaction_date, i.id AS item_id, i.item_name, i.item_price, tl.subtotal
                            FROM student s
                            LEFT JOIN transaction t
                            ON t.student_id = s.student_id
                            LEFT JOIN transaction_lists tl
                            ON tl.transaction_id = t.id AND tl.item_id = '$item_id'
                            LEFT JOIN inventory i
                            ON tl.item_id = i.id 
                            WHERE s.dept = '$department' AND s.level = '$level' AND s.school_year = '$active_school_year' ");
                            $counterTotal = 0;
                            $counterPayee = 0;
                            while($newReceivables=$getReceivables->fetch_assoc()){
                                $counterTotal++;
                                ?>
                                <tr>
                                    <td><?php echo strtoupper($newReceivables['student_id']);?></td>
                                    <td><?php echo strtoupper($newReceivables['full_name']);?></td>
                                    <td><?php echo $newReceivables['transaction_date'];?></td>
                                    <td><?php if($newReceivables['subtotal']==NULL){/* Do nothing*/}else{echo $newReceivables['subtotal']; $counterPayee++;}?></td>
                                </tr>
                            <?php } $counterTotal = $counterTotal - $counterPayee; ?>
                            </tbody>
                        </table>
                        <center>
                            <b>Number of students need to pay: <?php echo $counterTotal;?></b>
                        </center>
                    </div>
                </div>
            </div>
            <!-- End Receivables in Card -->
            <?php } ?>

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
