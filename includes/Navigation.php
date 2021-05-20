<nav class="navigation">
  <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="activities.php">Activities</a></li>
  <li><a href="ViewMoreBooks.php">Books</a></li>
  <li><a href="aboutUs.php">About us</a></li>
  <?php
  if(empty($_SESSION['userrole'])) { ?>
  <li><a href="logInPage.php">Log in</a></li>
  <li><a href="signUp.php">Sign up</a></li>

<?php } else if($_SESSION['userrole'] == 2){ ?>
    <li><a href="ProfilePage.php">My Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
<?php } else if($_SESSION['userrole'] == 1){ ?>
    <li><a href="ProfilePage.php">My Profile</a></li>
    <li><a href="AdministrationPage.php">Administration page</a></li>
    <li><a href="logout.php">Log out</a></li>
  <?php }  ?>

</ul>
</nav>
