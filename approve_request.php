<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "teacher") {
    header("Location: login.php");
    exit;
}

include 'database.php';

$sql = "SELECT * FROM applications WHERE status = 'pending' ORDER BY id DESC";

$result = $conn->query($sql);
$applications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'navbarLink.php'; ?>
    <title>Approve Request</title>
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/approve_request.css" />
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="searchbar">
            <h2>Approve Requests</h2>
            <div class="search">
                <input type="text" id="searchInput" placeholder="Search...">
                <button onclick="filterApplications()">Search</button>
            </div>
        </div>

        <table id="applicationsTable">
            <thead>
                <tr>
                    <th>Table No.</th>
                    <th>Application Type</th>
                    <th>Name</th>
                    <th>Enrollment</th>
                    <th>Branch</th>
                    <th>Semester</th>
                    <th>Purpose</th>
                    <th>Time</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tableNo = 1;
                foreach ($applications as $app) { ?>
                    <tr>
                        <td><?= $tableNo++ ?></td>
                        <td><?= $app['application_type'] ?></td>
                        <td><?= $app['name'] ?></td>
                        <td><?= $app['enrollment'] ?></td>
                        <td><?= $app['branch'] ?></td>
                        <td><?= $app['semester'] ?></td>
                        <td><?= $app['purpose'] ?></td>
                        <td><?= $app['created_at'] ?></td>
                        <td class="approve">
                            <form action="process_approval.php" method="post">
                                <input type="text" name="id" value="<?= $app['id'] ?>" hidden>
                                <input type="submit" name="approve" value="Approve">
                            </form>
                        </td>
                        <td class="action-buttons">
                            <button onclick="openPopup()">Reject</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <form id="popup-form" action="process_approval.php" method="post">
                    <input type="text" name="id" value="<?= $app['id'] ?>" hidden>
                    <textarea id="user-input" name="reason" placeholder="Write an appropriate reason for reject" required></textarea>
                    <br>
                    <button type="submit" name="reject">Reject</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>


    <script>
        function openPopup() {
            document.getElementById("popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function filterApplications() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("applicationsTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>