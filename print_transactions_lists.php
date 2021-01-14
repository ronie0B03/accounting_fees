<?php
require_once 'process_receipt.php';

include('sidebar.php');
include('navbar.php');

//$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
//$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//$_SESSION['getURI'] = $getURI;

$dateExist = false;

$cashier_account_full_name = $_SESSION['account_full_name'];


// 2021-01-14
// Make it remitted if it is being included
if(isset($_GET['remitted'])){
    $transacionID = $_GET['remitted'];
    $mysqli->query("UPDATE transaction SET remitted='1' WHERE id='$transacionID' ") or die ($mysqli->error());
}

if(isset($_GET['from_date'])){
    $dateExist = true;
    $from_date = $_GET['from_date'];
    $to_date  = $_GET['to_date'];
    $include_remitted = $_GET['include_remitted'];
    $getURI = "print_transactions_lists.php?from_date=".$from_date."&to_date=".$to_date."&include_remitted=".$include_remitted;

    $from_date = $from_date.' 00:00:00';
    $to_date  = $to_date.' 23:59:59';

/*$getTransactions = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, tl.subtotal AS subtotal_amount_paid FROM transaction_lists tl
 JOIN transaction t ON t.id = tl.transaction_id
 JOIN inventory i
 ON i.id = tl.item_id
 WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
 AND t.cashier_account = '$cashier_account_full_name' AND tl.void = '0'
 ORDER BY t.transaction_date ASC "); */

 $getTransactions = mysqli_query($mysqli, " SELECT *, t.remitted AS is_remitted, t.id AS transaction_id, tl.subtotal AS subtotal_amount_paid FROM transaction_lists tl
    RIGHT JOIN transaction t ON t.id = tl.transaction_id
    LEFT JOIN inventory i ON i.id = tl.item_id
    WHERE (t.transaction_date BETWEEN '$from_date' AND '$to_date')
    AND t.cashier_account = '$cashier_account_full_name'
    ORDER BY t.transaction_date ASC ");
 $getSummaryItem = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, SUM(tl.qty) AS sum_qty, SUM(tl.subtotal) AS sum_subTotal, i.id AS item_id FROM transaction_lists tl
    JOIN transaction t ON t.id = tl.transaction_id
    JOIN inventory i
    ON i.id = tl.item_id
    WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
    AND t.cashier_account = '$cashier_account_full_name' AND t.status_transact= '1' GROUP BY tl.item_id  ");
 /*
    $getSummaryItem = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, SUM(tl.qty) AS sum_qty, SUM(tl.subtotal) AS sum_subTotal, i.id AS item_id FROM transaction_lists tl
 JOIN transaction t ON t.id = tl.transaction_id
 JOIN inventory i
 ON i.id = tl.item_id
 WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
 AND t.cashier_account = '$cashier_account_full_name' GROUP BY tl.item_id  ");
 */
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
            <br>
            <br>
            <!-- Page Heading -->
            <div class="align-items-center justify-content-between mb-4" >
                <h4 style="text-align: center !important; font-family: 'Times New Roman' !important; margin-bottom: -5px;">
                    <img src="img/logo.png" style="width: 40px;">
                    SYSTEMS PLUS COLLEGE FOUNDATION
                </h4>
                <div style="text-align: center;">Mc Arthur Hi-Way Balibago, Angeles City, Pampanga</div>
            </div>

            <?php if($dateExist){ ?>
                <!-- List of Items -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <center><h6 class="m-0 font-weight-bold text-primary">List of Transaction from <?php echo $_GET['from_date'].' to '.$_GET['to_date'] ?></h6></center>
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
                                     <th>Actions / Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no=0;
                                $grandTotal = 0;
                                while($newTransaction = $getTransactions->fetch_assoc()){
                                    $is_remitted = $newTransaction['remitted'];
                                    if($include_remitted=='0' && $is_remitted=="1"){
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $newTransaction['transaction_id']; ?></td>
                                        <td class="font-weight-bold"><?php echo sprintf('%08d',$newTransaction['series_id']); ?></td>
                                        <td><?php echo $newTransaction['transaction_date']; ?></td>
                                        <td class="text-uppercase"><?php echo $newTransaction['full_name']; ?></td>
                                        <td><?php
                                        if($newTransaction['status_transact']!='1'){
                                            echo "<span style='color: red;'> CANCELLED</span>";
                                        }
                                        else{
                                            $sub_total_amount_paid = $newTransaction['subtotal_amount_paid'];
                                            $grandTotal = $grandTotal + $sub_total_amount_paid;
                                            echo '₱ '.number_format($sub_total_amount_paid,2);
                                        }?></td>
                                        <td><?php echo $newTransaction['item_name']; ?></td>
                                         <!-- <td><input style="font-size: 10px;" type="text" class="form-control text-success " name=""></td> -->
                                        <td>
                                            <!-- Start Drop down Delete here -->
                                            <button class="btn btn-info dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Info
                                            </button>
                                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm">
                                                Previously Remitted? Only confirm if this transaction is previously included submission!<br/>
                                                <a href="<?php echo $getURI; ?>&remitted=<?php echo $newTransaction['transaction_id']; ?>" class='btn btn-success btn-sm'>
                                                    <i class="far fa-check-circle"></i> I confirm. Mark this as remitted.
                                                </a>
                                                <a href="#" class='btn btn-danger btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    
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
<style>
    .navbar{
        display: none;
    }
    .navbar-nav{
        display: none;
    }
    @media print{@page {size: landscape}}
</style>
<!-- Add Logic About the Prev remitted here -->

<?php



?>