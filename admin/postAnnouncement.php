<?php
include '../database/dbcon.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
    } else {

        echo "Error: Admin not logged in.";
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO announcements (title, content, admin_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $admin_id);

    if ($stmt->execute()) {
        echo "Announcement posted successfully!";
        header("Location: admin-dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
