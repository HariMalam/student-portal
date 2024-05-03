<?php
session_start();

if (isset($_SESSION['usertype'])) {
  header("Location: index.php");
  exit;
}

include 'database.php';

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter your email.";
  } else {
    $email = trim($_POST["email"]);
  }

  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  if (empty($email_err) && empty($password_err)) {

    $sql = "SELECT id, email, password, usertype, name FROM users WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_email);
      $param_email = $email;
      if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
          $stmt->bind_result($id, $email, $hashed_password, $usertype, $name);
          if ($stmt->fetch()) {
            if (password_verify($password, $hashed_password)) {
              session_start();
              $_SESSION["email"] = $email;
              $_SESSION["usertype"] = $usertype;
              $_SESSION["password"] = $password;
              $_SESSION["name"] = $name;
              header("location: index.php");
            } else {
              $password_err = "Invalid email or password.";
            }
          }
        } else {
          $email_err = "Invalid email or password.";
        }
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
  <link rel="stylesheet" href="css/login.css" />
  <title>Login</title>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="login">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
      <div>
        <input type="text" name="email" id="email" placeholder="Email" class="form-input">
        <span class="error"><?php echo $email_err; ?></span>
      </div>
      <div>
        <input type="password" name="password" id="password" placeholder="Password" class="form-input">
        <span class="error"><?php echo $password_err; ?></span>
      </div>
      <button type="submit" class="btn-login">Login</button>
      <p class="signup">
        Create An Account? <a href="signup.php">singup</a>
      </p>
    </form>
  </div>
  <?php include 'footer.php'; ?>

</body>

</html>