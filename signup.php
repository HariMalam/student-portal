<?php
session_start();

if (isset($_SESSION['usertype'])) {
  header("Location: index.php");
  exit;
}

include 'database.php';

$name = $email = $password = "";
$name_err = $email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["name"]))) {
    $name_err = "Please enter your name.";
  } else {
    $name = trim($_POST["name"]);
  }

  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter your email.";
  } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
    $email_err = "Please enter a valid email address.";
  } elseif (!preg_match("/@gecg28\.ac\.in$/", trim($_POST["email"]))) {
    $email_err = "Only email addresses with the domain 'gecg28.ac.in' are allowed.";
  } else {
    $email = trim($_POST["email"]);
  }

  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } elseif (strlen(trim($_POST["password"])) < 8) {
    $password_err = "Password must have at least 8 characters.";
  } else {
    $password = trim($_POST["password"]);
  }

  $usertype = trim($_POST["usertype"]);

  if (empty($name_err) && empty($email_err) && empty($password_err) && empty($usertype_err)) {

    $sql = "INSERT INTO users (name, email, password, usertype) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("ssss", $param_name, $param_email, $param_password, $param_usertype);

      $param_name = $name;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT);
      $param_usertype = $usertype;

      if ($stmt->execute()) {
        header("location: login.php");
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
  <link rel="stylesheet" href="css/signup.css" />

  <title>Signup</title>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <div class="signup">
    <h2>Signup</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signup-form">
      <div>
        <select name="usertype" class="form-input">
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
        </select>
      </div>
      <div>
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name" class="form-input">
        <span><?php echo $name_err; ?></span>
      </div>
      <div>
        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" class="form-input">
        <span><?php echo $email_err; ?></span>
      </div>
      <div>
        <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password" class="form-input">
        <span><?php echo $password_err; ?></span>
      </div>

      <div>
        <button type="submit" class="btn-signup">Signup</button>
      </div>
      <p class="login">
        Already have An Account? <a href="login.php">login</a>
      </p>
    </form>
  </div>
  <?php include 'footer.php'; ?>

</body>

</html>