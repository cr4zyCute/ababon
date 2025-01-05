<?php
include '../database/dbcon.php';
session_start();


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announcement_id'])) {
    $announcement_id = intval($_POST['announcement_id']);


    $query = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $announcement_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Announcement deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting announcement.";
    }

    $stmt->close();
    header("Location: admin-dashboard.php");
    exit();
} else {
    header("Location: admin-dashboard.php");
    exit();
}
