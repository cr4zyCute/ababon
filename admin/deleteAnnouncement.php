<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $announcement_id = $_POST['announcement_id'] ?? null;

    if (!$announcement_id || !is_numeric($announcement_id)) {
        header("Location: adminPage.php?message=error&details=Invalid announcement ID.");
        exit;
    }

    // Database connection
    include 'db_connection.php'; // Adjust as needed

    $stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: adminPage.php?message=error&details=Invalid announcement ID.");
        exit;
    }

    // If the ID is valid, proceed to delete
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $announcement_id);

    if ($stmt->execute()) {
        header("Location: adminPage.php?message=success");
    } else {
        header("Location: adminPage.php?message=error&details=Failed to delete the announcement.");
    }
}
