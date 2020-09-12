<?php
include ("sidebar.php");
include ("navbar.php");
include ("dbh.php");

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI.'?';

$lowStock = false;
$getLowStock = mysqli_query($mysqli, "SELECT * FROM inventory WHERE qty <= 10");
if($getLowStock->num_rows>=1){
    $lowStock = true;
}
$date = date('Y-m-d');
$from_date = $date.' 00:00:00';
$to_date = $date.' 23:59:59';
$getTotalTransaction = mysqli_query($mysqli, "SELECT COUNT(id) AS total_transaction FROM transaction
WHERE transaction_date BETWEEN '$from_date' AND '$to_date' ");
$newTotalTransaction = $getTotalTransaction->fetch_array();
$totalTransaction = $newTotalTransaction['total_transaction'];

$getTotalEarnings = mysqli_query($mysqli, "SELECT SUM(total_amount) AS total_earnings FROM transaction
WHERE transaction_date BETWEEN '$from_date' AND '$to_date' ");
$newTotalEarnings = $getTotalEarnings->fetch_array();
$totalEarnings = $newTotalEarnings['total_earnings'];

$getTotalItems = mysqli_query($mysqli, "SELECT count(id) AS total_items FROM inventory
WHERE qty > 0 ");
$getTotalItems = $getTotalItems->fetch_array();
$total_items = $getTotalItems['total_items'];

?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
<?php
    include("topbar.php");
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

            <!-- Alert here -->
            <?php if ($lowStock) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Inventory is low in stock. Please restock. Thank you
                </div>
            <?php } ?>
            <!-- End Alert here -->
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
          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings Today</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                          ₱ <?php echo number_format($totalEarnings,2); ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <!-- Items in Stock -->
              <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card border-left-success shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Items in Stock:</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                                      <?php echo $total_items; ?>
                                  </div>
                                  <!-- End Progress -->
                              </div>
                              <div class="col-auto">
                                  <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Items in Stock -->
              <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card border-left-warning shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Number of Transactions Today:</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                                      <?php echo $totalTransaction; ?>
                                  </div>
                                  <!-- End Progress -->
                              </div>
                              <div class="col-auto">
                                  <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>

          <!-- Another Section -->
          <div class="row">
              <div class="col-xl-6 col-md-6 mb-2">
                  <div class="card shadow mb-2">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">Select Student</h6>
                      </div>
                      <div class="card-body">
                          <form method="post" action="process_transaction.php">
                              <input type="text" class="form-control mb-2" name="student_id" placeholder="Student ID:" required>
                              <button class="float-right btn btn-sm btn-info mb-2" type="submit" name="find_student">Submit</button>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-xl-6 col-md-6 mb-2">
                  <div class="card shadow mb-2">
                      <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">New Customer</h6>
                      </div>
                      <div class="card-body">
                          <form method="post" action="process_transaction.php">
                              <input type="text" class="form-control mb-2" name="new_cust_name" placeholder="ex: Juan Cruz" required>
                              <button class="float-right btn btn-sm btn-warning mb-2 text-gray-900" type="submit" name="new_cust">For New Customer</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>



        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
    include ("footer.php");
?>
