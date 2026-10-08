<?php
    include("../../conn.php");
    $id = $_REQUEST['id'];
    $select = "SELECT * FROM menu WHERE id=$id";
    $query = mysqli_query($conn, $select);
    $r = mysqli_fetch_assoc($query); // Fetch the row as an associative array
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>admin panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include("partials/navbar.php"); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include("partials/sidebar.php"); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title text-uppercase fs-4">Menu Update</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputId">ID</label>
                        <input type="text" class="form-control" id="exampleInputId" name="id" value="<?php echo $r['id']; ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter Name" name="menu_name" value="<?php echo $r['menu_name']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPrice">Price</label>
                        <input type="text" class="form-control" id="exampleInputPrice" placeholder="Enter Price" name="price" value="<?php echo $r['price']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">File upload</label>
                        <input type="file" class="form-control" name="img">
                        <?php echo "<td><img src='../images/" . $r['img'] . "' alt='Image' style='width: 150px; height: auto;'></td>"; ?>
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectMenu">Category</label>
                        <select class="form-select" name="menu">
                            <option selected><?php echo $r['menu']; ?></option>
                            <option value="sofas">Sofas</option>
                            <option value="dining tables">Dining Tables</option>
                            <option value="wardrobes">Wardrobes</option>
                            <option value="tv unit">TV Unit</option>
                        </select>
                      </div>
                      <input type="submit" name="update" value="UPDATE" class="btn btn-gradient-secondary me-2 text-dark">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
      </div>
    </div>
    <!-- container-scroller -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="../../assets/js/jquery.cookie.js"></script>
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>
  </body>
</html>

<?php
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $menu_name = $_POST['menu_name'];
        $menu = $_POST['menu'];
        $price = $_POST['price'];

        $path = $_FILES['img']['name'];
        
        if ($path) {
            $img_path = "../images/".$path;
            $update = "UPDATE menu SET menu_name='$menu_name', img='$path', menu='$menu', price='$price' WHERE id=$id";
        } else {
            $update = "UPDATE menu SET menu_name='$menu_name', menu='$menu', price='$price' WHERE id=$id";
        }

        $res = mysqli_query($conn, $update);

        if ($res) {
            if ($path) {
                move_uploaded_file($_FILES['img']['tmp_name'], $img_path);
            }
            echo "<script>alert('Record Updated Successfully'); window.location.href='menu_show.php';</script>";
        } else {
            echo "<script>alert('Error Updating Record');</script>";
        }
    }
?>
