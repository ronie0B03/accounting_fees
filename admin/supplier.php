<?php
require_once 'process_supplier.php';

include('sidebar.php');
include('navbar.php');

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$getLastItem = mysqli_query($mysqli, "SELECT * FROM supplier");
$lastItemID = 0;
while ($newLastItem = mysqli_fetch_array($getLastItem)) {
    $lastItemID = $newLastItem['id'];
}

$getSupplier = mysqli_query($mysqli, "SELECT * FROM supplier");

?>
<title>Inventory - Celine & Peter Store</title>
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
                <h1 class="h3 mb-0 text-gray-800">Supplier</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Add Supplier</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="process_supplier.php">
                            <table class="table" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="">Supplier Name</th>
                                    <th width="">Contact No.</th>
                                    <th width="">Email Address</th>
                                    <th width="">Additional Information</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" name="supplier_id" class="form-control" value="<?php if($edit){echo $supplier_id;}else{echo ++$lastItemID;} ?>" required readonly></td>
                                    <td><input type="text" name="supplier_name" class="form-control" placeholder="Angelina Bakery" value="<?php if($edit){echo $supplier_name;} ?>" required></td>
                                    <td><input type="contact" name="contact_no" class="form-control" placeholder="09234567890" value="<?php if($edit){echo $contact_no;} ?>" required></td>
                                    <td><input type="email" name="email_address" class="form-control" placeholder="accounting@spcf.edu.ph" value="<?php if($edit){echo $email_address;} ?>" required></td>
                                    <td><textarea name="other_info" class="form-control" style="min-height: 50px;" placeholder="e.g. Address"><?php if($edit){echo $other_info;} ?></textarea></td>
                                </tr>
                                </tbody>
                            </table>
                            <?php if(!$edit){ ?>
                            <button class="float-right btn btn-sm btn-primary m-1" name="save" type="submit"><i class="far fa-save" ></i> Save</button>
                            <?php } else { ?>
                                <button class="float-right btn btn-sm btn-success m-1" name="update" type="submit"><i class="far fa-save" ></i> Update</button>
                            <?php } ?>
                            <a href="inventory.php" class="btn btn-danger btn-sm m-1 float-right"><i class="fas as fa-sync"></i> Cancel</a>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Add Inventory -->

            <!-- List of Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Supplier</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th>Contact No</th>
                                <th>Email Address</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newSupplier = $getSupplier->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo strtoupper($newSupplier['id']); ?></td>
                                    <td><?php echo strtoupper($newSupplier['supplier_name']); ?></td>
                                    <td><?php echo $newSupplier['contact_no']; ?></td>
                                    <td><?php echo $newSupplier['email_address']; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-info mb-1" href="supplier.php?edit=<?php echo $newSupplier['id'];?>">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <!-- Start Drop down Delete here -->
                                        <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display:none;">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm" style="display:none;">
                                            Are you sure you want to delete? You cannot undo the changes<br/>
                                            <a href="process_inventory.php?delete=<?php echo $newSupplier['id']; ?>" class='btn btn-danger btn-sm'>
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
