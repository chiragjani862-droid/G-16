<?php

        include("../../conn.php");  
        $id=$_REQUEST['id'];

        $delete="delete from gallery where id=$id";

        $r=mysqli_query($conn,$delete);

        if($r)
        {
            echo "<script>alert('Delete imges in gallery..'); window.location.href='gallery_show.php';</script>";
        }
        else
        {
            echo "<script>alert('ERROR Delete Record..');</script>";

        }
           
?>