<?php
require_once 'process_report.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$getItem = mysqli_query($mysqli, " SELECT * FROM inventory  ");

$dateExist = false;
if(isset($_GET['from_date'])){
    $dateExist = true;
    $from_date = $_GET['from_date'];
    $to_date  = $_GET['to_date'];
    $item_id = $_GET['item_id'];
    $getTransactionsList = mysqli_query($mysqli, " SELECT i.item_name, t.id AS transaction_id, t.transaction_date, t.full_name, tl.subtotal, t.cashier_account, t.student_id 
    FROM transaction_lists tl
    JOIN inventory i
    ON i.id = tl.item_id
    JOIN transaction t
    ON t.id = tl.transaction_id
    WHERE tl.item_id = '$item_id' AND t.status_transact = 1 ");
}
//print_r($getTransactions);
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
                <h1 class="h3 mb-0 text-gray-800">Transaction Report (Breakdown)</h1>
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

            <?php if($dateExist){ ?>
                <!-- List of Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Reports from <?php echo $_GET['from_date'].' to '.$_GET['to_date'] ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Control No.</th>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Item Name</th>
                                    <th>Total Paid</th>
                                    <th>Cashier</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total = 0;
                                while($newTransactionsList = $getTransactionsList->fetch_assoc()){
                                    $subTotal = $newTransactionsList['subtotal'];
                                    $total = $total + $subTotal;
                                    ?>
                                    <tr>
                                        <td><?php echo $newTransactionsList['transaction_date'];?></td>
                                        <td><?php echo $newTransactionsList['transaction_id'];?></td>
                                        <td><?php echo $newTransactionsList['student_id'];?></td>
                                        <td><?php echo $newTransactionsList['full_name'];?></td>
                                        <td><?php echo $newTransactionsList['item_name'];?></td>
                                        <td>₱<?php echo number_format($subTotal,2);?></td>
                                        <td><?php echo $newTransactionsList['cashier_account'];?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div style="text-align: center;" class="font-weight-bold">
                                Total Collection: ₱<?php echo number_format($total,2); ?> <small>on selected dates.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Item Lists -->
            <?php } ?>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- JS here -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reportTable').DataTable( {
                "pageLength": 100
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
