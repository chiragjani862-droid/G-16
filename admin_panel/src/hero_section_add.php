<?php
  include("../../conn.php");
?>
<?php
  if(isset($_POST['add']))
{
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    $path = $_FILES['img']['name'];
    $tmp = $_FILES['img']['tmp_name'];
    $size = $_FILES['img']['size'];

    $img_path = "../images/".$path;

    // Allowed Extensions
    $allowed_ext = array("jpg","jpeg","png","gif");
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if(in_array($ext,$allowed_ext))
    {
        if($size < 2000000) // 2MB limit
        {
            $insert = "insert into hero_section(name,description,img)values('$name','$desc','$path')";
            $result = mysqli_query($conn,$insert);

            if($result)
            {
                move_uploaded_file($tmp,$img_path);
                echo "<script>alert('Image Inserted Successfully'); window.location.href='hero_section_add.php';</script>";
            }
            else
            {
                echo "<script>alert('Database Error');</script>";
            }
        }
        else
        {
            echo "<script>alert('File size must be less than 2MB');</script>";
        }
    }
    else
    {
        echo "<script>alert('Only JPG, JPEG, PNG, GIF files allowed');</script>";
    }
}

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
              <h3 class="page-title text-uppercase fs-4">Hero Section Add</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter Name" name="name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">File upload</label>
                        <input type="file" class="form-control" id="exampleInputName1" placeholder="Enter Name" name="img">
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="4" name="desc" placeholder="Enter Description"></textarea>
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
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class=""></i></span>
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
