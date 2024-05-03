<?php

session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "student") {
    header("Location: login.php");
    exit;
}

include 'database.php';

$name = $_POST['name'];
$enrollment = $_POST['enrollment'];
$branch = $_POST['branch'];
$semester = $_POST['semester'];
$purpose = $_POST['purpose'];
$application_type = $_POST['application_type'];
$email = $_SESSION['email'];

$current_date_time = date("Y-m-d_H-i-s");
$profile_image_name = $current_date_time . "_" . basename($_FILES["profile_image"]["name"]);
$profile_image_path = "uploads/" . $profile_image_name;
move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image_path);

$sign_image_name = $current_date_time . "_" . basename($_FILES["sign_image"]["name"]);
$sign_image_path = "uploads/" . $sign_image_name;
move_uploaded_file($_FILES["sign_image"]["tmp_name"], $sign_image_path);


$sql = "INSERT INTO applications (email, name, enrollment, branch, semester, purpose, profile_image, sign_image, application_type)
        VALUES ('$email','$name', '$enrollment', '$branch', '$semester', '$purpose', '$profile_image_name', '$sign_image_name', '$application_type')";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Applied successfully!"); window.location.href = "current_past_applications.php";</script>';

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
