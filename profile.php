<?php
session_start();

if (!isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$name = $password = "";
$name_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($name_err) && empty($password_err)) {

        $sql = "UPDATE users SET name=?, password=? WHERE email=?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_name, $param_password, $param_email);

            $param_name = $name;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $_SESSION['email'];

            if ($stmt->execute()) {
                $_SESSION['name'] = $name; // Update session with new name
                header("location: profile.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'navbarLink.php'; ?>
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/profile.css" />

    <title>Profile</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="profile1">
    <h2>Update Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="profile-form" name="update">
      <div>
        <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" placeholder="Name" class="form-input">
        <span><?php echo $name_err; ?></span>
      </div>
      <div>
        <input type="password" name="password" value="<?php echo $_SESSION['password']; ?>" placeholder="Password" class="form-input">
        <span><?php echo $password_err; ?></span>
      </div>
      <div>
        <button type="submit" class="btn-update">Update</button>
      </div>
    </form>
  </div>
    <?php include 'footer.php'; ?>

</body>

</html>