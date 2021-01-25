<?php
require_once 'process_inventory.php';

include('sidebar.php');
include('navbar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI.'?';

$getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction");

if(!isset($_GET['itemCtrl'])){
    $itemCtrl = 1;
}
else{
    $itemCtrl = $_GET['itemCtrl'];
}

$accountFound = false;

if(isset($_GET['account'])){
    if($_GET['account']==1){
        $accountFound = true;
    }
    else{
        $accountFound = false;
    }
}
else{ ?>
<meta http-equiv = "refresh" content = "0; url = index.php" />
<?php
}
$currentID = $_SESSION['current_transact_id'];
$currentSeries = $_SESSION['currentSeries'];
$getCurrentTransaction = mysqli_query($mysqli, "SELECT *, i.item_name, tl.qty AS tl_qty, tl.price AS tl_price FROM transaction_lists tl
JOIN inventory i ON i.id = tl.item_id
WHERE tl.transaction_id='$currentID' AND void = 0");

if(mysqli_num_rows($getCurrentTransaction) > 0){
    $pendingItems = true;
    $total = 0;
}
else{
    $pendingItems = false;
    $total = 0;
}
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
                <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
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

            <!-- Add Transaction -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Transaction</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="min-height: 800px;">
                        <form method="post" action="process_transaction.php">
                            <input type="text" class="form-control" name="transactionID" value="<?php echo $currentID; ?>" readonly style="visibility: hidden;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price / Item</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Start -->
                                <?php while($newCurrentTransaction = $getCurrentTransaction->fetch_assoc()){ ?>
                                    <tr>
                                        <td class="font-weight-bold"><?php echo $newCurrentTransaction['item_name'];?></td>
                                        <td><?php echo $newCurrentTransaction['tl_qty']; ?></td>
                                        <td><?php echo $newCurrentTransaction['tl_price']; ?></td>
                                        <td><?php echo $subTotal = $newCurrentTransaction['subtotal']; ?></td>
                                    </tr>
                                <!-- Stop listing here -->
                                <?php
                                    $total+=$subTotal;
                                    } ?>
                                    <tr>
                                        <td>
                                        <select dir="rtl" class="form-control selectpicker" name="item" data-live-search="true">
                                                <?php
                                                $getItemForAdding = mysqli_query($mysqli, "SELECT * FROM inventory");
                                                while($newItemsForAdding=$getItemForAdding->fetch_assoc()){
                                                    ?>
                                                    <option data-tokens="<?php echo strtoupper($newItemsForAdding['item_name']); ?>" class="" value="<?php echo $newItemsForAdding['id']; ?>">
                                                        <?php echo strtoupper($newItemsForAdding['item_code'].' - '.$newItemsForAdding['item_name']); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
<!--                                             <select class="form-control selectpicker" id="select-country" data-live-search="true">
                                                    <option data-tokens="china">China</option>
                                                    <option data-tokens="malayasia">Malayasia</option>
                                                    <option data-tokens="singapore">Singapore</option>
                                            </select> -->
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="qty" value="<?php echo '1'; ?>" min="1" >
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="price" step="0.0001" placeholder="0.00" readonly>
                                        </td>
                                        <td><input class="form-control" name="subTotal" value="" step="0.0001" placeholder="0.00" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success btn-sm float-right" name="add_item">Add Item</button>
                            <br/>
                            <br/>
                            <span class="float-right"><b>TOTAL: ₱<?php echo number_format($total,2); ?></b></span>
                            <input name="grand_total" class="form-control" value="<?php echo $total;?>" style="visibility: hidden;">
                            <br>
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="10%;">Control ID</th>
                                    <th width="20%;">Series No.</th>
                                    <th width="">Student ID</th>
                                    <th width="">Full Name</th>
                                    <th width="">Amount Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="transactionID" value="<?php echo $currentID; ?>" readonly></td>
                                    <td><input type="text" class="form-control" value="<?php echo sprintf('%08d',$currentSeries); ?>" readonly></td>
                                    <td><input type="number" class="form-control" name="student_id" placeholder="ex: 0191919003;" value="<?php echo $_SESSION['student_id']; ?>" readonly  ></td>
                                    <td><input type="text" class="form-control" name="full_name" placeholder="ex: Juan Cruz" value="<?php echo $_SESSION['full_name']; ?>" readonly ></td>
                                    <td><input type="number" step="0.01" class="form-control" name="amount_paid" min="<?php echo $total; ?>" value="<?php echo $total; ?>" required></td>
                                </tr>
                                </tbody>
                            </table>
                            <br/>
                            <div style="text-align: center;">
                                <button class="btn btn-sm btn-primary m-1" name="save" type="submit"><i class="far fa-save" ></i> Save</button>
                                <a href="transactions.php" class="btn btn-danger btn-sm m-1"><i class="fas as fa-sync"></i> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Transaction -->

            <!-- List of Transactions -->
            <div class="card shadow mb-4" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Transactions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Control ID</th>
                                <th>Full Name</th>
                                <th style="display: none;">Phone Num</th>
                                <th>Total Amount</th>
                                <th>Total Paid</th>
                                <th style="display: none;">Total Balance</th>
                                <th style="display: none;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newTransaction = $getTransaction->fetch_assoc()){
                                $balance = $newTransaction['amount_paid'] - $newTransaction['total_amount'];
                                ?>
                                <tr>
                                    <td><?php echo $newTransaction['transaction_date']; ?></td>
                                    <td><a href="view_transaction.php?id=<?php echo $newTransaction['id']; ?>" target="_blank"><?php echo $newTransaction['id']; ?></a></td>
                                    <td><a href="view_transaction.php?id=<?php echo $newTransaction['id']; ?>" target="_blank"><?php echo $newTransaction['full_name']; ?></a></td>
                                    <td style="display: none;"><?php echo $newTransaction['phone_num']; ?></td>
                                    <td><?php echo '₱'.number_format($newTransaction['total_amount'],2); ?></td>
                                    <td><?php echo '₱'.number_format($newTransaction['amount_paid'],2); ?></td>
                                    <td style="display: none; color: <?php if($balance<0){echo 'red';}else{echo 'green';} ?>">
                                        <b><?php echo number_format($balance,2); ?></b>
                                    </td>
                                    <td style="display:none;">
                                        <!-- Start Drop down Delete here -->
                                        <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm">
                                            Are you sure you want to delete? You cannot undo the changes<br/>
                                            <a href="process_transaction.php?delete=<?php echo $newTransaction['id']; ?>" class='btn btn-danger btn-sm'>
                                                <i class="far fa-trash-alt"></i> Confirm Delete
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
        $(function() {
              $('.selectpicker').selectpicker();
        });
    </script>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Systems Plus College Foundation - Accounting Office <?php echo date("Y"); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Transaction Modal -->
<div id="transactionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <label class="">Select Student</label>
            </div>
            <div class="modal-body">
                <form method="post" action="process_transaction.php">
                    <input type="text" class="form-control mb-1" name="student_id" placeholder="Student ID:" required>
                    <button class="float-right btn btn-sm btn-info mb-1" type="submit" name="find_student">Submit</button>

                    <br/>
                    <br/>
                </form>
                <form method="post" action="process_transaction.php">
                    <label>New Cusrtomer</label>
                    <input type="text" class="form-control mb-1" name="new_cust_name" placeholder="ex: Juan Cruz" required>
                    <button class="float-right btn btn-sm btn-warning mb-1 text-gray-900" type="submit" name="new_cust">For New Customer</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal here -->
    <!-- <script src="js/bootstrap-select.min.js"></script> -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-select.min.css" rel="stylesheet" />

    <style type="text/css">
        .dropdown-menu{
            /*padding: 10px !important;*/
        }
        .topbar {
            /*height: 3rem !important; */
        }
        html{
            font-family: 'Roboto Condensed', sans-serif !important;
            font-size: 14px;
            scroll-behavior: smooth !important;
        }
        input.date{
            width: 10px;
        }

        #dataTable_wrapper,#fixtureTable_wrapper, #airconTable_wrapper, #forRepairTable_wrapper {
            width: 100% !important;
        }

        .bg-gradient-primary {
            background-color: #0f1e5d !important;
            background-image: none !important;
            background-image: none !important;
            background-size: cover !important;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #0f1e5d !important;
            border-color: #0f1e5d !important;
        }
        .container-fluid{
            background-color: white;
            /*padding-left: 5% !important;
            padding-right: 5% !important;*/
        }
        #content-wrapper{
            background-color: white !important;
        }
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            opacity: 0.7 !important; /* Firefox */
        }
        nav ul{
            position: sticky !important;
            top: 0;
            z-index: 99;
            white-space: normal;
        }
        nav ul li a{
            white-space: normal !important;
        }

    </style>
</body>

</html>
    