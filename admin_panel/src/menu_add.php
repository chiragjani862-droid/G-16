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
              <h3 class="page-title text-uppercase fs-4">Menu Add</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Menu Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter Name" name="name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Price</label>
                        <input type="number" class="form-control" id="exampleInputName1" placeholder="Enter Price" name="price">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">File upload</label>
                        <input type="file" class="form-control" id="exampleInputName1" name="img">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Menu List</label>
                        <select class="form-select" name="menu" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="sofas">sofas</option>
                            <option value="dining tables">dining tables</option>
                            <option value="wardrobes">wardrobes</option>
                            <option value="tv unit">tv unit</option>
                        </select>
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
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i class=""></i></span>
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
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $menu  = mysqli_real_escape_string($conn, $_POST['menu']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Image Upload
    $file_name = $_FILES['img']['name'];
    $file_tmp  = $_FILES['img']['tmp_name'];
    $file_size = $_FILES['img']['size'];
    $file_error = $_FILES['img']['error'];

    // Allowed extensions
    $allowed = array('jpg','jpeg','png','webp');

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if(empty($file_name))
    {
        echo "<script>alert('Please Select Image');</script>";
        exit();
    }

    if(!in_array($file_ext, $allowed))
    {
        echo "<script>alert('Only JPG, JPEG, PNG & WEBP files allowed');</script>";
        exit();
    }

    if($file_size > 2097152) // 2MB limit
    {
        echo "<script>alert('Image size must be less than 2MB');</script>";
        exit();
    }

    if($file_error === 0)
    {
        // Unique file name generate
        $new_file_name = time().rand(1000,9999).".".$file_ext;
        $upload_path = "../images/".$new_file_name;

        if(move_uploaded_file($file_tmp, $upload_path))
        {
            $insert = "INSERT INTO menu(menu_name, price, img, menu)
                       VALUES('$name','$price','$new_file_name','$menu')";

            $result = mysqli_query($conn,$insert);

            if($result)
            {
                echo "<script>alert('Menu item inserted successfully'); window.location.href='menu_add.php';</script>";
            }
            else
            {
                echo "<script>alert('Database Insert Error');</script>";
            }
        }
        else
        {
            echo "<script>alert('Image Upload Failed');</script>";
        }
    }
    else
    {
        echo "<script>alert('File Upload Error');</script>";
    }
}
?>
