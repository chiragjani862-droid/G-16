<?php
include("../../conn.php");  
$id = $_REQUEST['id'];

// Delete related records in 'orders' first to satisfy foreign key constraints
$deleteOrders = "DELETE FROM orders WHERE menu_id = $id";
mysqli_query($conn, $deleteOrders);

// Delete related records in 'cart' next
$deleteCart = "DELETE FROM cart WHERE menu_id = $id";
mysqli_query($conn, $deleteCart);

// Now delete the record from 'menu'
$deleteMenu = "DELETE FROM menu WHERE id = $id";
$r = mysqli_query($conn, $deleteMenu);

if ($r) {
    echo "<script>alert('Deleted Menu Successfully'); window.location.href='menu_show.php';</script>";
} else {
    echo "<script>alert('Error Deleting Record');</script>";
}
?>
