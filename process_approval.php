<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "teacher") {
  header("Location: login.php");
  exit;
}

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['approve'])) {
    $id = $_POST['id'];
    $current_date_time = date("Y-m-d_H-i-s");
    $pdf = "bonafide_" . $id . "_" . $current_date_time . ".pdf";
    $sql = "UPDATE applications SET status = 'approved', pdf = '$pdf' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
      include_once('Generate/generate_certificate.php');
      generatePDF($id, $conn);
      header("Location: approve_request.php");
    } else {
      echo "Error updating record: " . $conn->error;
    }
    header("Location: approve_request.php");
  }
  if (isset($_POST['reject'])) {
    $id = $_POST['id'];
    $reason = $_POST['reason'];

    $sql = "UPDATE applications SET status = 'rejected', reason = '$reason' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
      header("Location: approve_request.php");
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
}
