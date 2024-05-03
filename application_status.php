<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "student") {
  header("Location: login.php");
  exit;
}

include 'database.php';

$sql = "SELECT * FROM applications WHERE email = '{$_SESSION['email']}' ORDER BY created_at DESC";

$result = $conn->query($sql);
$applications = [];
if ($result->num_rows > 0) {
  $counter = 1;
  while ($row = $result->fetch_assoc()) {
    $row['no'] = $counter;
    $applications[] = $row;
    $counter++;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'navbarLink.php'; ?>
  <link rel="stylesheet" href="css/footer.css" />
  <link rel="stylesheet" href="css/application_status.css" />
  <title>Application Status</title>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <h1 class="head">Application Status</h1>

  <table id="applicationsTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Application Type</th>
        <th>Name</th>
        <th>Enrollment</th>
        <th>Branch</th>
        <th>Semester</th>
        <th>Purpose</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($applications as $app) { ?>
        <tr>
          <td><?= $app['no'] ?></td>
          <td><?= $app['application_type'] ?></td>
          <td><?= $app['name'] ?></td>
          <td><?= $app['enrollment'] ?></td>
          <td><?= $app['branch'] ?></td>
          <td><?= $app['semester'] ?></td>
          <td><?= $app['purpose'] ?></td>
          <td><?= $app['created_at'] ?></td>
          <?php if ($app['status'] == "rejected") : ?>
            <td class="rejected">REJECTED: <?= $app['reason'] ?></td>
          <?php elseif ($app['status'] == "approved") :
            $pdf = $app['pdf'];
            $downloadLink = 'download.php?file=' . urlencode($pdf);
            echo '<td><a href="' . $downloadLink . '" class="btn btn-success">Download</a></td>';
          ?>
          <?php else : ?>
            <td class="pending">PENDING</td>
          <?php endif; ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php include 'footer.php'; ?>
</body>

</html>