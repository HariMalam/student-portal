<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "teacher") {
  header("Location: login.php");
  exit;
}

include 'database.php';

$sql = "SELECT * FROM applications ORDER BY created_at DESC";

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
  <link rel="stylesheet" href="css/history.css" />
  <!-- <link rel="stylesheet" href="css/current_past_applications.css" /> -->
  <title>History</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<h1 class="head">History</h1>

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
        <td class="status <?= strtolower($app['status']) ?>">
          <?php if ($app['status'] == "rejected") : ?>
            REJECTED
          <?php elseif ($app['status'] == "approved") : ?>
            APPROVED
          <?php else : ?>
            PENDING
          <?php endif; ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>


</body>

</html>