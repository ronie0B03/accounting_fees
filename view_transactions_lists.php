<?php
require_once 'process_receipt.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$dateExist = false;

$cashier_account_full_name = $_SESSION['account_full_name'];

if(isset($_GET['from_date'])){
    $dateExist = true;
    $from_date = $_GET['from_date'].' 00:00:00';
    $to_date  = $_GET['to_date'].' 23:59:59';
    $getTransactions = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, tl.subtotal AS subtotal_amount_paid FROM transaction_lists tl
 JOIN transaction t ON t.id = tl.transaction_id
 JOIN inventory i
 ON i.id = tl.item_id
 WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
 AND t.cashier_account = '$cashier_account_full_name' AND tl.void = '0'
 ORDER BY t.transaction_date ASC ");

    $getSummaryItem = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, SUM(tl.qty) AS sum_qty, SUM(tl.subtotal) AS sum_subTotal, i.id AS item_id FROM transaction_lists tl
 JOIN transaction t ON t.id = tl.transaction_id
 JOIN inventory i
 ON i.id = tl.item_id
 WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
 AND t.cashier_account = '$cashier_account_full_name' GROUP BY tl.item_id  ");
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
                <h1 class="h3 mb-0 text-gray-800">Transaction Report (Item)</h1>
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

            <!-- Add Inventory -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Select Dates</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_receipt.php">
                            <table class="table" width="100%" cellspacing="0" id="">
                                <thead>
                                <tr>
                                    <th width="">From Date</th>
                                    <th width="">To Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="date" class="form-control" name="from_date" required></td>
                                    <td><input type="date" class="form-control" name="to_date" required></td>

                                </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-info float-right" type="submit" name="get_report_individual" >Proceed</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Add Inventory -->

            <?php if($dateExist){ ?>
                <!-- List of Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Reports from <?php echo $_GET['from_date'].' to '.$_GET['to_date'] ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="reportTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Control ID</th>
                                    <th>Series No.</th>
									<th>Date</th>
                                    <th>Full Name</th>
                                    <th>Amount</th>
                                    <th>Kind of Pay</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no=0;
                                $grandTotal = 0;
                                while($newTransaction = $getTransactions->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $newTransaction['transaction_id']; ?></td>
                                        <td class="font-weight-bold"><?php echo sprintf('%08d',$newTransaction['series_id']); ?></td>
										<td><?php echo $newTransaction['transaction_date']; ?></td>
                                        <td class="text-uppercase"><?php echo $newTransaction['full_name']; ?></td>
                                        <td>₱<?php echo number_format($newTransaction['subtotal_amount_paid'],2); ?></td>
                                        <td><?php echo $newTransaction['item_name']; ?></td>
                                    </tr>
                                <?php
                                    $grandTotal = $grandTotal + $newTransaction['subtotal_amount_paid'];
                                } ?>
                                </tbody>
                            </table><br/>
                            <div style="text-align: center;" class="font-weight-bold h5">
                                GRAND TOTAL: ₱<?php echo number_format($grandTotal,2); ?>
                            </div>
                            <br/>
                            <div style="text-align: left;" class=" h6">
                                <?php
								$subTotal = 0;
								while($newSummaryItem=$getSummaryItem->fetch_assoc()){?>
                                    <?php echo $newSummaryItem['item_name']; ?>: ₱<?php echo number_format($newSummaryItem['sum_subTotal'],2);?><br/>
                                <?php
								$subTotal = $subTotal + $newSummaryItem['sum_subTotal'];
								} //echo 'Total Tally: ₱'.$subTotal; ?>
                            </div>
                            <br/>
                            <span class="float-left">
                                PREPARED BY:<br/><br/>
                                <a class="font-weight-bold"><?php echo $cashier_account_full_name; ?></a>
                            </span>
                            <span class="float-right">
                                CHECKED BY:<br/><br/>
                                <a class="font-weight-bold">Jemelyn M. Alignay</a>
                            </span>
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
