<?php
require_once 'process_inventory.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI.'?';

if(isset($_GET['id'])){
    $receipt_id = $_GET['id'];
}

$getReceipt = mysqli_query($mysqli, "SELECT * FROM issue_receipt WHERE id = '$receipt_id' ");
$newReceipt = $getReceipt->fetch_array();
$id = $newReceipt['transaction_id'];

$getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction WHERE id = '$id' ");
$newTransaction = $getTransaction->fetch_array();
$series_id = $newTransaction['series_id'];
$balance = $newTransaction['amount_paid'] - $newTransaction['total_amount'];

?>
<title>SPCF Officie Receipt. Control ID: <?php echo $id; ?>  AR No: <?php echo sprintf('%08d',$receipt_id); ?> </title>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <?php
        include('topbar.php');
        ?>
        <?php
        $counter = 0;
        while($counter<2){
            ?>
        <!-- Begin Page Content -->
        <p style="page-break-before: always">
        <div class="container-fluid print_area" style="color: black; border-bottom: solid grey 1px;" >
            <br>
            <br>
            <!-- Page Heading -->
            <div class="align-items-center justify-content-between mb-4" >
                <h4 style="text-align: center !important; font-family: 'Times New Roman' !important; position: relative; z-index: 99; line-height: 0;">
                    <img src="img/logo.png" style="width: 50px; position: absolute; z-index: -1; top: -20px;  left: 20px;">
                    SYSTEMS PLUS COLLEGE FOUNDATION
                </h4>
                <div style="text-align: center;">Mc Arthur Hi-Way Balibago, Angeles City, Pampanga</div>
            </div>

            <!-- View Individual Transactions -->
            <div class="mb-4">
                <div class="card-header py-3">
                    <span class="h6 m-0 font-weight-bold text-danger" style="display: none;">Transaction Control ID: <?php echo sprintf('%08d',$id); ?></span>
                    <span class=" h6 m-0 font-weight-bold text-danger text-uppercase">Acknowledgement Receipt: <?php echo sprintf('%08d',$series_id); ?></span>
                </div>
                <div class="card-body">
                    <span class="float-right">
                        <b>Date: <?php echo date('Y-m-d H:i:s');?></b></span>
                    <b class="text-uppercase">Customer Name: <?php echo ucwords($newTransaction['full_name']); ?></b>
                    <b style="display: none;">Address: <?php echo ucwords($newTransaction['address']); ?></b>
                    <b style="display: none;">Phone Number: <?php echo $newTransaction['phone_num']; ?></b>
                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="color: black;">
                            <thead>
                            <tr class="text-uppercase">
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $getTransactionLists = mysqli_query($mysqli, "SELECT * FROM transaction_lists WHERE transaction_id = '$id' AND void = '0' ");
                            $total = 0;
                            while ($newTransactionList=$getTransactionLists->fetch_assoc()){
                                $item_id = $newTransactionList['item_id'];
                                $getItem = mysqli_query($mysqli, "SELECT * FROM inventory WHERE id = '$item_id' ");
                                $newItem= $getItem->fetch_array();
                                $itemName = $newItem['item_name'];

                                $subTotal = $newTransactionList['price'] * $newTransactionList['qty'];
                                ?>
                                <tr>
                                    <td><?php echo strtoupper($itemName); ?></td>
                                    <td><?php echo $newTransactionList['qty'].' pc(s)'; ?></td>
                                    <td>₱ <?php echo number_format($newTransactionList['price'],2); ?></td>
                                    <td>₱ <?php echo number_format($subTotal,2); ?></td>
                                </tr>
                                <?php
                                $total += $subTotal;
                            } ?>
                            <tr>
                                <td colspan="3"><span class="float-right font-weight-bold ">TOTAL:</span></td>
                                <td><span class="font-weight-bold">₱<?php echo number_format($total,2); ?></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <b class="float-right" style="line-height: 0;">TOTAL AMOUNT PAID: ₱<?php echo number_format($newTransaction['amount_paid'],2); ?></b>
                        <br>
                        <b class="float-right" style="line-height: 0;">CHANGE: ₱<?php echo number_format($newTransaction['amount_paid']-$newTransaction['total_amount'],2); ?></b>
                        <br/>
                        <br/>
                        <div style="">
                            <span class="float-right"><b>CASHIER: <u><?php echo strtoupper($_SESSION['account_full_name']); ?></b></u></span>
                            <a style="display: none;" href="view_transaction.php?id=<?php echo $id; ?>" class="text-white btn btn-sm btn-info float-left"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                            <?php if($counter==1){ ?>
                                STUDENT'S COPY
                            <?php } else { ?>
                                ACCOUNTING OFFICE'S COPY
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End View Individual Transactions -->

        </div>
        <?php $counter++;
        }
        ?>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- JS here -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#transactionTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
    <style>
        .sidebar, .navbar, .sticky-footer{
            display: none;
        }
        html{
            font-size: 14px;
        }
        @media print {
            .print_area {
                min-height: 5.5in;
            }
        }

        table.table {
            width: 100% !important;
            margin: 0 auto;
        }

        /** only for the head of the table. */
        table.table thead th {
            padding: 0;
        }

        /** only for the body of the table. */
        table.table tbody td {
            padding: 0;
        }
    </style>