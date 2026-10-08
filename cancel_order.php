<?php
session_start();
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];

    // Update order status to "Cancelled"
    $cancel_query = "UPDATE orders SET order_status = 'Cancelled' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $cancel_query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Order Cancelled Successfully!'); window.location.href='orders.php';</script>";
}
?>
