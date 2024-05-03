<?php
session_start();

if (isset($_POST['logout'])) {
  $_SESSION = array();
  session_destroy();
  header("Location: index.php");
  exit;
}
?>

<div class="second-bar">
  <img src="img/gecg-logo.png" alt="gecg-logo">
  <h1>Government Engineering College, Gandhinagar</h1>
  <img src="img/affiliated.png" alt="affiliated">
</div>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="fa-solid fa-house home-icon"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="faculty_profile.php">Faculty Profile</a>
        </li>
        <?php if ($_SESSION['usertype'] == "teacher") : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bonafide Approval
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="approve_request.php">Aprove Request</a></li>
              <li><a class="dropdown-item" href="history.php">History</a></li>
            </ul>
          </li>
        <?php elseif ($_SESSION['usertype'] == "student") :  ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bonafide Application
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="apply_bonafide.php">Apply for Bonafite Certificate</a></li>
              <li><a class="dropdown-item" href="current_past_applications.php">Current and Past Application</a></li>
              <li><a class="dropdown-item" href="application_status.php">Application Status</a></li>
            </ul>
          </li>
        <?php endif; ?>

      </ul>
      <?php if (!isset($_SESSION['email'])) : ?>
        <a href="login.php" class="btn btn-danger">Login</a>
      <?php else : ?>
        <div class="profile">

          <p>Welcome<?php if ($_SESSION['usertype'] == 'teacher') : ?> sir<?php endif; ?>, <?php echo $_SESSION['name'] ?></p>
          <a href="profile.php" class="btn btn-success">Profile</a>
          &nbsp;
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <button type="submit" class="btn btn-danger" name="logout">
              <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>