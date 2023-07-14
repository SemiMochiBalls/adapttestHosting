<nav class="navbar navbar-expand-lg navbar-light navcolor">
  <a class="navbar-brand navtxtcolor" href="index.php"><img src="img/logo-no-title-light.svg" class="logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto links">
      <?php
      if (!isset($_SESSION['user'])) {
      ?>
        <div class="links-section">
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" href="about.php">About</a>
          </li>
        </div>
        <div class="account-section">
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" id="login" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" id="register" href="register.php">Sign Up</a>
          </li>
        </div>
      <?php
      } else {
      ?>
        <div class="links-section">
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" href="manage.php">Manage Patients</a>
          </li>
        </div>
        <div class="account-section">
          <li class="nav-item">
            <a class="nav-link navtxtcolor2" id="login" href="Controller/logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <span class="nav-link navtxtcolor2">Hi, <?php echo $_SESSION['userlogged'];?>.</span>
          </li>
        </div> 
      <?php } ?>
    </ul>
  </div>
</nav>