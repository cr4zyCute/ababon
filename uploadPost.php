<?php
include 'database/dbcon.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$content = mysqli_real_escape_string($conn, $_POST['content']);
$mediaPaths = [];


if (isset($_FILES['media']['name'][0]) && $_FILES['media']['name'][0] != "") {
    foreach ($_FILES['media']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES['media']['name'][$key]);
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . time() . "_" . $fileName;


        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }


        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            $mediaPaths[] = $targetFilePath;
        }
    }
}


if (!empty($content) || !empty($mediaPaths)) {
    if (empty($mediaPaths)) {

        $query = "INSERT INTO posts (student_id, content) VALUES ('$student_id', '$content')";
        mysqli_query($conn, $query);
    } else {

        foreach ($mediaPaths as $mediaPath) {
            $query = "INSERT INTO posts (student_id, content, media) VALUES ('$student_id', '$content', '$mediaPath')";
            mysqli_query($conn, $query);
        }
    }
}

header("Location: home.php");
exit();
