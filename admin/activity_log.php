<?php
require_once 'process_transaction.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$getLogs = mysqli_query($mysqli, " SELECT * FROM logs ");
?>
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
                <h1 class="h3 mb-0 text-gray-800">Activity Log</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Logs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="activityTable" width="100%" cellspacing="0" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th width="20%">Type</th>
                                <th width="15%">Date</th>
                                <th width="15%">Account / Cashier</th>
                                <th>Context</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newLogs=$getLogs->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $newLogs['log_type']; ?></td>
                                    <td><?php echo $newLogs['log_date']; ?></td>
                                    <td><?php echo $newLogs['account_cashier']; ?></td>
                                    <td><?php echo $newLogs['context']; ?></td>
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
            $('#activityTable').DataTable( {
                "pageLength": 100
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>