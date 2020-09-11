<?php
include ("sidebar.php");
include ("navbar.php");
include ("dbh.php");

$lowStock = false;
$getLowStock = mysqli_query($mysqli, "SELECT * FROM inventory WHERE qty <= 10");
if($getLowStock->num_rows>=1){
    $lowStock = true;
}
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
                          ₱40,000
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
                                      ₱40,000
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
                                      ₱40,000
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



        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
    include ("footer.php");
?>
