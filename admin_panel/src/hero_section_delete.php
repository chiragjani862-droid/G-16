<?php

include("../../conn.php");
        $id=$_REQUEST['id'];

        $delete="delete from hero_section where id=$id";

        $r=mysqli_query($conn,$delete);

        if($r)
        {
            echo "<script>alert('Delete Record..'); window.location.href='hero_section_show.php';</script>";
        }
        else
        {
            echo "<script>alert('ERROR Delete Record..');</script>";

        }
           
?>