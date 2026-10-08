<?php

        include("../../conn.php");  
        $id=$_REQUEST['id'];

        $delete="delete from contactas where id=$id";

        $r=mysqli_query($conn,$delete);

        if($r)
        {
            echo "<script>alert('Delete Contactas..'); window.location.href='contactas_show.php';</script>";
        }
        else
        {
            echo "<script>alert('ERROR Delete Record..');</script>";

        }
           
?>