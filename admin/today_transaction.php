<?php
require_once 'process_inventory.php';

include('sidebar.php');
include('navbar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI.'?';

//$getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction WHERE DATE(transaction_date) = CURDATE() AND status_transact != '-1' ");
$getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction WHERE status_transact = '1' OR status_transact = '0'  ");

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
                <h1 class="h3 mb-0 text-gray-800">Today's Transaction</h1>
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

            <!-- List of Transactions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Transactions Today (Cancellation of Transaction)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Control ID</th>
                                <th>Series No.</th>
                                <th>Full Name</th>
                                <th style="display: none;">Phone Num</th>
                                <th>Total Amount</th>
                                <th style="display: none;">Total Paid</th>
                                <th>Status</th>
                                <th style="display: none;">Total Balance</th>
                                <th style="">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newTransaction = $getTransaction->fetch_assoc()){
                                $balance = $newTransaction['amount_paid'] - $newTransaction['total_amount'];
                                ?>
                                <tr>
                                    <td><?php echo $newTransaction['transaction_date']; ?></td>
                                    <td><a href="view_transaction.php?id=<?php echo $newTransaction['id']; ?>" target="_blank"><?php echo $newTransaction['id']; ?></a></td>
                                    <td><a href="view_transaction.php?id=<?php echo $newTransaction['id']; ?>" target="_blank"><?php echo sprintf('%08d',$newTransaction['series_id']); ?></a></td>
                                    <td><a href="view_transaction.php?id=<?php echo $newTransaction['id']; ?>" target="_blank"><?php echo $newTransaction['full_name']; ?></a></td>
                                    <td style="display: none;"><?php echo $newTransaction['phone_num']; ?></td>
                                    <td><?php echo '₱'.number_format($newTransaction['total_amount'],2); ?></td>
                                    <td style="display: none;"><?php echo '₱'.number_format($newTransaction['amount_paid'],2); ?></td>
                                    <td style="display: none; color: <?php if($balance<0){echo 'red';}else{echo 'green';} ?>">
                                        <b><?php echo number_format($balance,2); ?></b>
                                    </td>
                                    <td>
                                        <?php if($newTransaction['transaction_date']<$date && $newTransaction['status_transact']==0){ ?>
                                            <label class="text-danger">ABANDONED</label>
                                        <?php } else if($newTransaction['status_transact']==0){ ?>
                                            <label class="text-warning">PENDING</label>
                                        <?php } else if($newTransaction['status_transact']==-1){ ?>
                                            <label class="text-danger">RETURNED / CANCELLED</label>
                                        <?php } else if($newTransaction['status_transact']==1){ ?>
                                            <label class="text-success">COMPLETED</label>
                                        <?php } ?>
                                    </td>
                                    <td style="">
                                        <!-- Start Drop down Delete here -->
                                        <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-undo-alt"></i> Cancel Order
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm">
                                            Do you want to Cancel / Return the transaction? You cannot undo this action<br/>
                                            <a href="process_transaction.php?cancel=<?php echo $newTransaction['id']; ?>" class='btn btn-danger btn-sm'>
                                                <i class="far fa-trash-alt"></i> I understand. Cancel / Return the transaction
                                            </a>
                                            <a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- End Item Transactions -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- JS here -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#transactionTable').DataTable( {
                "pageLength": 25,
                "order": [[ 2, "desc" ]]
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>