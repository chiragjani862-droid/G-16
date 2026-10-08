<?php

        include("conn.php");  
        $id=$_REQUEST['id'];

        $delete="delete from cart where id=$id";

        $r=mysqli_query($conn,$delete);

        if($r)
        {
            echo "<script>alert('Delete item in card..'); window.location.href='card_show.php';</script>";
        }
        else
        {
            echo "<script>alert('ERROR Delete Record..');</script>";

        }
           
?>