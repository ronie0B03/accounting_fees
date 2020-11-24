
<!-- Page Wrapper -->
<div id="wrapper">
    <nav>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="mx-3">SPCF-AS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Inventory -->
            <li class="nav-item">
                <a class="nav-link" href="inventory.php">
                    <i class="fas fa-laptop"></i>
                    <span>Inventory</span></a>
            </li>

            <!-- Nav Item - Transactions -->
            <li class="nav-item" style="display:none;">
                <a class="nav-link btn" data-toggle="modal" data-target="#transactionModal">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transactions</span></a>
            </li>

            <!-- Transactions -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactions" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transactions</span>
                </a>
                <div id="collapseTransactions" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" data-toggle="modal" data-target="#transactionModal">Add Transactions</a>
                        <a class="collapse-item" href="for_receipt.php">View Transactions</a>
                    </div>
                </div>
            </li>

            <!-- Void -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVoid" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-key"></i>
                    <span>Void</span>
                </a>
                <div id="collapseVoid" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="list_transactions.php">Void Item</a>
                        <a class="collapse-item" href="today_transaction.php">Cancel / Return Transaction</a>
                    </div>
                </div>
            </li>

            <!-- Students -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                </a>
                <div id="collapseStudent" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="student.php">Add / Import Students</a>
                        <a class="collapse-item" href="uploads.php">Uploads</a>
                    </div>
                </div>
            </li>

            <!-- Students -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayable" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-receipt"></i>
                    <span>Payables</span>
                </a>
                <div id="collapsePayable" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="payable.php">Classify Payables per Department</a>
                        <a class="collapse-item" href="report_receivables.php">Detailed Report of Receivables</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Accounts -->
            <li class="nav-item" style="display:none;">
                <a class="nav-link" href="#">
                    <i class="fas fa-at"></i>
                    <span>Accounts</span></a>
            </li>

            <!-- Nav Item - Suppliers -->
            <li class="nav-item" style="">
                <a class="nav-link" href="supplier.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Supplier</span></a>
            </li>

            <!-- Nav Item - Reports -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="report.php">Consolidated Reports</a>
                        <a class="collapse-item" href="report_individual.php">Individual Item Report</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Accounts -->
            <li class="nav-item" style="">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccounts" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-user"></i>
                    <span>Accounts</span>
                </a>
                <div id="collapseAccounts" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">Accounts</a>
                        <a class="collapse-item" href="series_receipt.php">Series Receipts</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Activity Log -->
            <li class="nav-item" >
                <a class="nav-link" href="activity_log.php">
                    <i class="fa fa-history""></i>
                    <span>Activity Log</span></a>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item" style="display: none">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item" style="display: none;">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="display: none;">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item" style="display: none;">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item" style="display: none;">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item active" style="display: none;">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
    </nav>
    <!-- End of Sidebar -->
