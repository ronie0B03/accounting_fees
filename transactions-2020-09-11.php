<?php
require_once 'process_inventory.php';

include('sidebar.php');
include('navbar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI.'?';

$getLastTransaction = mysqli_query($mysqli, "SELECT * FROM transaction");
$getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction");

$lastTransactionID = 0;
while ($newLastTransaction = mysqli_fetch_array($getLastTransaction)) {
    $lastTransactionID = $newLastTransaction['id'];
}

if(!isset($_GET['itemCtrl'])){
    $itemCtrl = 1;
}
else{
    $itemCtrl = $_GET['itemCtrl'];
}

?>
<title>Transactions - Celine & Peter Store</title>
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
                    <div class="table-responsive">
                        <form method="post" action="process_transaction.php">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Adjusted Price / Item</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total = 0;
                                $itemCounter = 1;
                                while($itemCtrl>=$itemCounter){
                                    if(isset($_GET['itemCtrl'])){
                                        $item = $_GET['item'.$itemCounter];
                                        $qty = $_GET['qty'.$itemCounter];
                                        $price = $_GET['price'.$itemCounter];
                                        $subTotal = (float)$qty*(float)$price;
                                    }
                                    else{
                                        $item = NULL;
                                        $qty = NULL;
                                        $price = NULL;
                                        $subTotal = NULL;
                                    }

                                    ?>
                                    <tr>
                                        <td>
                                            <select dir="rtl" class="form-control" name="item<?php echo $itemCounter; ?>">
                                                <?php
                                                $getItemForAdding = mysqli_query($mysqli, "SELECT * FROM inventory");
                                                while($newItemsForAdding=$getItemForAdding->fetch_assoc()){
                                                    ?>
                                                    <option class="" value="<?php echo $newItemsForAdding['id']; ?>" <?php if($item==$newItemsForAdding['id']){echo 'selected';} ?>>
                                                        <?php echo strtoupper($newItemsForAdding['item_code'].' - '.$newItemsForAdding['item_name']/*.' - PHP'.$newItemsForAdding['item_price']*/); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="qty<?php echo $itemCounter; ?>" value="<?php echo $qty; ?>" placeholder="1" >
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="price<?php echo $itemCounter; ?>" value="<?php echo $price ?>" step="0.0001" placeholder="0.00" readonly>
                                        </td>
                                        <td><input class="form-control" name="subTotal" value="<?php echo number_format($subTotal,2); ?>" step="0.0001" placeholder="0.00" readonly></td>
                                    </tr>
                                    <?php
                                    $itemCounter++;
                                    $total += $subTotal;
                                } ?>
                                </tbody>
                            </table>
                            <input type="text" name="itemCtrl" value="<?php echo $itemCtrl; ?>" style="visibility: hidden;">
                            <span class="float-right"><b>TOTAL: ₱<?php echo number_format($total,2); ?></b></span>
                            <br>
                            <button type="submit" class="btn btn-success btn-sm float-right" name="add_item">Add Item</button>
                            <br>
                            <br>
                            <br>
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="10%;">Control ID</th>
                                    <th width="">Student ID</th>
                                    <th width="">Full Name</th>
                                    <th width="">Amount Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="transactionID" value="<?php echo ++$lastTransactionID; ?>" readonly></td>
                                    <td><input type="number" class="form-control" name="student_id" placeholder="ex: 0191919003;" value="000"></td>
                                    <td><input type="text" class="form-control" name="full_name" placeholder="ex: Juan Cruz" value="Juan Cruz"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="amount_paid" placeholder="<?php echo $total; ?>" value="<?php echo $total; ?>" required></td>
                                </tr>
                                </tbody>
                            </table>
                            <br/>
                            <center>
                                <button class="btn btn-sm btn-primary m-1" name="save" type="submit"><i class="far fa-save" ></i> Save</button>
                                <a href="transactions.php" class="btn btn-danger btn-sm m-1"><i class="fas as fa-sync"></i> Cancel</a>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Transaction -->

            <!-- List of Transactions -->
            <div class="card shadow mb-4">
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
                                <th>Phone Num</th>
                                <th>Total Amount</th>
                                <th>Total Paid</th>
                                <th style="display: none;">Total Balance</th>
                                <th>Actions</th>
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
                                    <td><?php echo $newTransaction['phone_num']; ?></td>
                                    <td><?php echo '₱'.number_format($newTransaction['total_amount'],2); ?></td>
                                    <td><?php echo '₱'.number_format($newTransaction['amount_paid'],2); ?></td>
                                    <td style="display: none; color: <?php if($balance<0){echo 'red';}else{echo 'green';} ?>">
                                        <b><?php echo number_format($balance,2); ?></b>
                                    </td>
                                    <td>
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
        $(document).ready(function() {
            $('#transactionTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
