<?php
require_once 'process_student.php';

include('sidebar.php');
include('navbar.php');

$active_school_year = $_SESSION['active_school_year'];
$getUploads = mysqli_query($mysqli, "SELECT * FROM uploads ");

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
                <h1 class="h3 mb-0 text-gray-800">Students</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">List of Students</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="UploadTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Upload Name</th>
                                <th>Date</th>
                                <th>Upload ID</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while($newUploads=$getUploads->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $newUploads['id']; ?></td>
                                    <td><?php echo strtoupper($newUploads['upload_name']); ?></td>
                                    <td><?php echo strtoupper($newUploads['date']); ?></td>
                                    <td><?php echo $newUploads['upload_id']; ?></td>
                                    <td>
                                        <!-- Start Drop down Delete here -->
                                        <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                            <i class="fas fa-key"></i> Delete
                                        </button>
                                        <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton btn-sm" style="">
                                            Delete? You cannot undo this action<br/>
                                            <a href="process_student.php?delete=<?php echo $newUploads['upload_id'];?>" class='btn btn-danger btn-sm'>
                                                <i class="fas fa-key"></i> Confirm Deletion
                                            </a>
                                            <a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <b>Please contact the ICTDU before deleting an upload!</b>
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
            $('#UploadTable').DataTable( {
                "pageLength": 25
            } );
        } );
    </script>
    <?php
    include('footer.php');
    ?>
