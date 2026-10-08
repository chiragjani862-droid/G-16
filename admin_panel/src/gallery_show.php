<?php
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>admim panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <style>
        /* .table-container {
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        } */
        .btn-custom {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-success {
            background-color: #28a745;
            color: #fff;
        }
        
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php
        include("partials/navbar.php");
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
       
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php
        include("partials/sidebar.php");
        ?>
        <!-- partial -->
         <?php
            
         ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title text-uppercase fs-4">gallery Show</h3>
            </div>
            <div class="row">

              <!-- <div class="col-12 grid-margin stretch-card"> -->
                <!-- <div class="card"> -->
                  <!-- <div class="card-body"> -->
                  <?php
                  echo '
                         <div class="container table-container">

                         ' ;
                        include("../../conn.php");
                 
                         $select = "SELECT * FROM gallery";
                         $result = mysqli_query($conn, $select);
                 
                         if (mysqli_num_rows($result) > 0) {
                             echo "<table class='table table-bordered table-striped table-hover'>";
                             echo "<thead class='table-dark text-uppercase'>";
                             echo "<tr>";
                             echo "<th>id</th>";
                             echo "<th>Image</th>";
                             echo "<th>Delete</th>";
                             echo "<th>Update</th>";
                             echo "</tr>";
                             echo "</thead>";
                             echo "<tbody>";
                 
                             foreach ($result as $row) {
                                 echo "<tr>";
                                 echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                 echo "<td><img src='../images/" . $row['img'] . "' alt='Image' style='width: 150px; height: auto; border-radius: none;' ></td>";
                                 echo "<td><a class='btn btn-custom bg-danger btn-delete' href='../src/gallery_delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                                 echo "<td><a class='btn btn-custom btn-update bg-success' href='../src/gallery_update.php?id=" . $row['id'] . "'>Update</a></td>";
                                 echo "</tr>";
                             }
                 
                             echo "</tbody>";
                             echo "</table>";
                         } else {
                             echo "<p class='text-center text-muted'>No data found.</p>";
                         }
                         ?>
                     </div>
                     <!-- Bootstrap JS -->
                     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 
                  <!-- </div> -->
                <!-- </div> -->
              <!-- </div> -->

            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="" target="_blank"></a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <i class=""></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="../../assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
