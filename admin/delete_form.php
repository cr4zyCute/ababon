<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_id'])) {
    $form_id = intval($_POST['form_id']);

    $delete_query = $conn->prepare("DELETE FROM forms WHERE id = ?");
    $delete_query->bind_param('i', $form_id);

    if ($delete_query->execute()) {

        header('Location: adminForm.php?message=Form deleted successfully');
        exit;
    } else {

        header('Location: adminForm.php?error=Failed to delete form');
        exit;
    }
}

header('Location: adminForm.php');
exit;
