<?php
  include("../../conn.php");
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
              <h3 class="page-title text-uppercase fs-4">Gallery Add</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">File upload</label>
                        <input type="file" class="form-control" id="exampleInputName1" name="img">
                      </div>
                      <input type="submit" name="add" value="ADD" class="btn btn-gradient-primary me-2 ">
                    </form>
                  </div>
                </div>
              </div>
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
<?php
if(isset($_POST['add']))
{
    // Check file selected or not
    if(empty($_FILES['img']['name']))
    {
        echo "<script>alert('Please select an image');</script>";
        exit();
    }

    $file_name = $_FILES['img']['name'];
    $file_tmp  = $_FILES['img']['tmp_name'];
    $file_size = $_FILES['img']['size'];
    $file_error = $_FILES['img']['error'];

    // Allowed extensions
    $allowed_ext = array("jpg","jpeg","png","gif");
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate extension
    if(!in_array($file_ext, $allowed_ext))
    {
        echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed');</script>";
        exit();
    }

    // Validate file size (2MB limit)
    if($file_size > 2 * 1024 * 1024)
    {
        echo "<script>alert('File size must be less than 2MB');</script>";
        exit();
    }

    // Check file error
    if($file_error !== 0)
    {
        echo "<script>alert('Error uploading file');</script>";
        exit();
    }

    // Create unique file name to avoid duplicate
    $new_file_name = time().rand(1000,9999).".".$file_ext;
    $upload_path = "../images/".$new_file_name;

    // Insert into database
    $insert = "INSERT INTO gallery(img) VALUES('$new_file_name')";
    $result = mysqli_query($conn,$insert);

    if($result)
    {
        move_uploaded_file($file_tmp, $upload_path);
        echo "<script>alert('Gallery image added successfully'); window.location.href='gallery_add.php';</script>";
    }
    else
    {
        echo "<script>alert('Error inserting record');</script>";
    }
}
?>
