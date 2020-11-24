<?php
require_once 'process_series_receipts.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

//Get ID
$getSeries = mysqli_query($mysqli, "SELECT * FROM series_controller");
$lastSeriesId = 0;
while ($newlastSeriesId = mysqli_fetch_array($getSeries)) {
    $lastSeriesId = $newlastSeriesId['id'];
}
//Get Lsat Series To
$getSeries = mysqli_query($mysqli, "SELECT * FROM series_controller");
$lastSeriesTo = 0;
while ($newlastSeriesId = mysqli_fetch_array($getSeries)) {
    $lastSeriesTo = $newlastSeriesId['series_to'];
}
$getAccount = mysqli_query($mysqli, "SELECT * FROM accounts WHERE role = 'user' ");


//Get All The Series
$getSeries = mysqli_query($mysqli, "SELECT *, sc.id AS sc_id FROM series_controller sc JOIN accounts a ON a.id = sc.account_cashier ");
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
                <h1 class="h3 mb-0 text-gray-800">Series Receipts</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Associate Series on Accounts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_series_receipts.php">
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="">Item ID</th>
                                    <th width="">From</th>
                                    <th width="">To</th>
                                    <th width="30%">Account</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input name="series_id" value="<?php echo ++$lastSeriesId; ?>" class="form-control" type="text" readonly></td>
                                    <td><input name="series_from" value="<?php echo  ++$lastSeriesTo; ?>" type="number" class="form-control" readonly></td>
                                    <td><input name="series_to" type="number" class="form-control"></td>
                                    <td>
                                        <select name="account" class="form-control">
                                        <?php while($newAccount = $getAccount->fetch_assoc()){ ?>
                                            <option value="<?php echo $newAccount['id']; ?>"><?php echo $newAccount['full_name']; ?></option>
                                        <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="float-right btn btn-sm btn-primary m-1" name="save" type="submit"><i class="far fa-save" ></i> Save</button>
                            <a href="inventory.php" class="btn btn-danger btn-sm m-1 float-right"><i class="fas as fa-sync"></i> Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Inventory -->

            <!-- List of Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Account</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Remaining Sheets</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newSeries = $getSeries->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $newSeries['sc_id']; ?></td>
                                <td><?php echo $newSeries['full_name'];?></td>
                                <td><?php echo $newSeries['series_from'];?></td>
                                <td><?php echo $newSeries['series_to'];?></td>
                                <td><?php echo $newSeries['account_cashier'];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

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
            $('#inventoryTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
