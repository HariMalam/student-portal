<?php
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== "student") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'navbarLink.php'; ?>
    <link rel="stylesheet" href="css/apply_bonafide.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <title>Bonafide Apply</title>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <form action="submit_bonafide.php" method="post" class="applyform" enctype="multipart/form-data">
        <div class="head">
            <h1>Apply Bonafide</h1>
        </div>
        <div>
            <input type="text" placeholder="Name" id="name" name="name">
        </div>
        <div>
            <input type="number" id="enrollment" placeholder="Enrollment" name="enrollment">
        </div>
        <div>
            <input type="text" id="branch" placeholder="Branch" name="branch">
        </div>
        <div>
            <input type="number" id="semester" placeholder="Semester" name="semester">
        </div>
        <div>
            <textarea id="purpose" placeholder="purpose for application" name="purpose"></textarea>
        </div>
        <div class="media">
            <div>
                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image">
            </div>
            <div>
                <label for="sign_image">Signature Image:</label>
                <input type="file" id="sign_image" name="sign_image">
            </div>
        </div>
        <input type="hidden" name="application_type" value="bonafide">
        <button type="submit">Apply</button>
    </form>
    <?php include 'footer.php'; ?>
</body>

</html>