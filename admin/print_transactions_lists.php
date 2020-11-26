<?php
require_once 'process_receipt.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$dateExist = false;
if(isset($_GET['from_date'])){
    $dateExist = true;
}
#$cashier_account_full_name = $_SESSION['account_full_name'];

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
                    <img src="../img/logo.png" style="width: 40px;">
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
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no=0;
                                $grandTotal = 0;
                                $seriesCount = 1;
                                while($seriesCount<=100){
                                    /* Added 2020-11-26*/

                                    if(isset($_GET['from_date'])){
                                        $cashier_account_full_name = $_GET['cashier_account'];
                                        $dateExist = true;
                                        $from_date = $_GET['from_date'].' 00:00:00';
                                        $to_date  = $_GET['to_date'].' 23:59:59';
                                        $getTransactions = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, tl.subtotal AS subtotal_amount_paid FROM transaction_lists tl
                                         RIGHT JOIN transaction t ON t.id = tl.transaction_id
                                         LEFT JOIN inventory i ON i.id = tl.item_id
                                         WHERE (t.transaction_date BETWEEN '$from_date' AND '$to_date')
                                         AND t.cashier_account = '$cashier_account_full_name' AND t.series_id = '$seriesCount'
                                         ORDER BY t.transaction_date ASC ");

                                        $getSummaryItem = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, SUM(tl.qty) AS sum_qty, SUM(tl.subtotal) AS sum_subTotal, i.id AS item_id FROM transaction_lists tl
                                         JOIN transaction t ON t.id = tl.transaction_id
                                         JOIN inventory i
                                         ON i.id = tl.item_id
                                         WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date')
                                         AND t.cashier_account = '$cashier_account_full_name' GROUP BY tl.item_id  ");
                                         if($cashier_account_full_name=='all'){
                                             $getTransactions = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, tl.subtotal AS subtotal_amount_paid FROM transaction_lists tl
                                             RIGHT JOIN transaction t ON t.id = tl.transaction_id
                                             LEFT JOIN inventory i ON i.id = tl.item_id     
                                             WHERE (t.transaction_date BETWEEN '$from_date' AND '$to_date') AND t.series_id = '$seriesCount'
                                             ORDER BY t.transaction_date ASC ");

                                             $getSummaryItem = mysqli_query($mysqli, " SELECT *, t.id AS transaction_id, SUM(tl.qty) AS sum_qty, SUM(tl.subtotal) AS sum_subTotal, i.id AS item_id FROM transaction_lists tl
                                         JOIN transaction t ON t.id = tl.transaction_id
                                         JOIN inventory i
                                         ON i.id = tl.item_id
                                         WHERE (tl.transaction_date BETWEEN '$from_date' AND '$to_date') GROUP BY tl.item_id  ");
                                         }

                                    }
                                    /* Added 2020-11-26*/
                                    if(mysqli_num_rows($getTransactions)>0){
                                        $newTransaction = $getTransactions->fetch_array();
                                    ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $newTransaction['transaction_id']; ?></td>
                                        <td class="font-weight-bold"><?php echo sprintf('%08d',$newTransaction['series_id']); ?>
                                            <?php
                                                if($newTransaction['status_transact']==-1){echo 'CANCELLED'; }
                                                if($newTransaction['status_transact']==0){ echo 'ABANDONED'; }
                                            ?>
                                        </td>
                                        <td><?php echo $newTransaction['transaction_date']; ?></td>
                                        <td class="text-uppercase"><?php echo $newTransaction['full_name']; ?></td>
                                        <td>₱<?php
                                        if($newTransaction['status_transact']==-1){
                                            echo number_format(0,2);
                                            $grandTotal = $grandTotal + $newTransaction['subtotal_amount_paid'];
                                        }
                                        else{
                                            echo number_format($newTransaction['subtotal_amount_paid'],2);
                                            $grandTotal = $grandTotal + $newTransaction['subtotal_amount_paid'];
                                        } ?>
                                        </td>
                                        <td><?php echo $newTransaction['item_name']; ?></td>
                                    </tr>
                                        <?php } else { ?>
                                        <tr>
                                            <td><?php echo ++$no; ?></td>
                                            <td><?php echo $seriesCount; ?></td>
                                            <td class="font-weight-bold"><?php echo sprintf('%08d',$seriesCount); ?>
                                                ABANDONED
                                            </td>
                                            <td>NA</td>
                                            <td class="text-uppercase">NA</td>
                                            <td>₱0.00 </td>
                                            <td>NA</td>
                                        </tr>
                                        <?php } ?>
                                    <?php $seriesCount++;
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
                                <a class="text-uppercase font-weight-bold"><?php echo $cashier_account_full_name; ?></a>
                            </span>
                            <span class="text-uppercase float-right">
                                PREPARED BY:<br/><br/>
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
</style>