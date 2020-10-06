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
    $lowStockText = "Items that are low in stock:";
    while($newLowStock=$getLowStock->fetch_assoc()){
        $lowStockText = $lowStockText.' '.strtoupper($newLowStock['item_name'].',');
    }
}
$date = date('Y-m-d');
$from_date = $date.' 00:00:00';
$to_date = $date.' 23:59:59';
$getTotalTransaction = mysqli_query($mysqli, "SELECT COUNT(id) AS total_transaction FROM transaction
WHERE transaction_date BETWEEN '$from_date' AND '$to_date' ");
$newTotalTransaction = $getTotalTransaction->fetch_array();
$totalTransaction = $newTotalTransaction['total_transaction'];

$getTotalEarnings = mysqli_query($mysqli, "SELECT SUM(total_amount) AS total_earnings FROM transaction
WHERE (transaction_date BETWEEN '$from_date' AND '$to_date') AND status_transact = '1' ");
$newTotalEarnings = $getTotalEarnings->fetch_array();
$totalEarnings = $newTotalEarnings['total_earnings'];

$getTotalItems = mysqli_query($mysqli, "SELECT count(id) AS total_items FROM inventory
WHERE qty > 0 ");
$getTotalItems = $getTotalItems->fetch_array();
$total_items = $getTotalItems['total_items'];


//Get Monthly Sales;
$getMonthlySales = mysqli_query($mysqli, "SELECT YEAR(transaction_date) as SalesYear, MONTH(transaction_date) as SalesMonth, SUM(total_amount) AS TotalSales
FROM transaction WHERE status_transact = '1'  
GROUP BY YEAR(transaction_date), MONTH(transaction_date)
ORDER BY YEAR(transaction_date), MONTH(transaction_date) ");
$counter=0;
$month[-1] = 0;
while($newMonthlySales=$getMonthlySales->fetch_assoc()){
    $month[++$counter]=$newMonthlySales['TotalSales'];
}

//Get Earnings per cashier counter
$getIndividualEarning = mysqli_query($mysqli, "SELECT SUM(total_amount) AS individualEarning, cashier_account
FROM transaction WHERE (transaction_date BETWEEN '$from_date' AND '$to_date') AND status_transact = '1'
GROUP BY cashier_account ");
?>
<title>SPCF - Accounting Office</title>
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
                    <a><?php echo $lowStockText; ?>. Please restock. Thank you</a>
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

            <!-- Add Transaction -->
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
            <!-- Charts -->
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-6 col-md-6 mb-2">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="indexChart"></canvas>
                            </div>
                            <hr>
                            Disclaimer: This chart will grow once data has been fed.
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 mb-2">
                    <div class="card shadow mb-2" style="">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Earnings per Cashier</h6>
                        </div>
                        <div class="card-body">
                            Below are the expected earnings that should tally with their cabin
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Cashier / Accountant</th>
                                        <th>Total Earning</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $counter = 0;
                                while($newIndividualEarning=$getIndividualEarning->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo ++$counter; ?></td>
                                        <td>₱ <?php echo number_format($newIndividualEarning['individualEarning'],2); ?></td>
                                        <td><?php echo $newIndividualEarning['cashier_account']; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>

    <script type="text/javascript">
        var ctx = document.getElementById("indexChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [<?php echo 0; ?>, <?php echo 0; ?>, <?php echo 0; ?>, <?php echo 0; ?>, <?php echo 0; ?>, <?php echo 0; ?>, <?php echo 0; ?>, <?php echo $month[1]; ?>, <?php echo $month[2]; ?>, <?php echo $month[3]; ?>, <?php echo 0; ?>, <?php echo 0; ?>],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '₱' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ₱' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    </script>
    <?php
    include ("footer.php");
    ?>
