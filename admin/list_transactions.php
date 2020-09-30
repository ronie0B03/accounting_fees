<?php
require_once 'process_transaction.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$getTransactionsList = mysqli_query($mysqli, " SELECT t.student_id, t.full_name, t.transaction_date, tl.id AS transaction_list_id, tl.transaction_id, tl.item_id, tl.subtotal, tl.qty, tl.price, i.item_name
 FROM transaction_lists tl
 JOIN transaction t ON t.id = tl.transaction_id
 JOIN inventory i ON i.id = tl.item_id 
 WHERE tl.void ='0' AND t.status_transact = '0' ");
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
                <h1 class="h3 mb-0 text-gray-800">Transaction Lists / Item</h1>
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

                <!-- List of Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Item lists of current transaction</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Transaction Date</th>
                                    <th>Item Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while($newTransactionList=$getTransactionsList->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $newTransactionList['transaction_id']; ?></td>
                                    <td><?php echo $newTransactionList['student_id']; ?></td>
                                    <td><?php echo $newTransactionList['full_name']; ?></td>
                                    <td><?php echo $newTransactionList['transaction_date']; ?></td>
                                    <td><?php echo $itemName = $newTransactionList['item_name']; ?></td>
                                    <td><?php echo $qty = $newTransactionList['qty']; ?></td>
                                    <td>₱ <?php echo $price = $newTransactionList['price']; ?></td>
                                    <td>₱ <?php echo $subTotal = $newTransactionList['subtotal']; ?></td>
                                    <td>
                                    <?php
                                    if($newTransactionList['transaction_date']<$date){ ?>
                                        <span class="text-warning">ABANDONED</span>
                                    <?php } ?></td>
                                    <td>
                                        <!-- Start Drop down Delete here -->
                                        <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                            <i class="fas fa-key"></i> Void
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm" style="">
                                            Are you sure you want to void the item? You cannot undo the changes<br/>
                                            <a href="process_transaction.php?void=<?php echo $newTransactionList['transaction_list_id'].'&qty='.$newTransactionList['qty'].'&item='.$newTransactionList['item_id'].'&transaction_id='.$newTransactionList['transaction_id'].'&qty='.$qty.'&price='.$price.'&sub_total='.$subTotal.'&item_name='.$itemName; ?>" class='btn btn-danger btn-sm'>
                                                <i class="fas fa-key"></i> Confirm Void
                                            </a>
                                            <a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                        </div>
                                    </td>

                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div style="text-align: center;" class="font-weight-bold">
                            </div>
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
            $('#reportTable').DataTable( {
                "pageLength": 100
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
